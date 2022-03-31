<?php

$page   = isset($_GET['p']) ? abs(intval($_GET['p'])) : 1;    
$offset = $page >1 ? ($page-1)*60 : 0;
$id = (int)$id;

if(isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);    
    $sql    = "SELECT `c`.* 
                FROM `stories` AS `s`, `story_categories` AS `c` 
                WHERE `c`.`story_id` = `s`.`id` AND `c`.`category_id` = {$id} AND `s`.`name` LIKE '%{$search}%' 
                LIMIT 60 OFFSET {$offset}";                 
    $cate = query_mysql($sql);                
    
    $sql = "SELECT count(`s`.id) as alls  
            FROM `stories` AS `s`, `story_categories` AS `c` 
            WHERE `c`.`story_id` = `s`.`id` AND `c`.`category_id` = {$id} AND `s`.`name` LIKE '%{$search}%'";
    $total = intval(query_mysql($sql, true)['alls']);
} else {
    $cate = do_cache("(story_categories)_cate:1:{$id}:{$page}", function() use($id, $offset){
        $sql = "SELECT `c`.* 
            FROM `stories` AS `s`, `story_categories` AS `c` 
            WHERE `c`.`story_id` = `s`.`id` AND `c`.`category_id` = {$id} AND `s`.`duyet` = 1 
            ORDER BY `c`.`lastupdate` DESC, `c`.`id` DESC 
            LIMIT 60 OFFSET {$offset}";
        return query_mysql($sql);    
    }, 86400);

    $total = do_cache("(story_categories)_cate_total:{$id}", function() use($id){
        $cate = query_mysql("select count(distinct story_id) as alls from story_categories where category_id = {$id}", true);
        return (int)$cate['alls'];
    }, 86400);
}

function card_cat() {
    global $cate;

    $html = '';
    foreach($cate as $tt) {
        $getStory = stories_by_id($tt['story_id']);
        $newest   = character_by_id($getStory['chapter_id']);
        $html .= 
            '<div class="col-md-3 col-6 py-2">
                <div onclick="'.href('/story/view.php?id='.$getStory['id']).'" style="background: url(\'/assets/hentai/'.$getStory['thumb'].'.jpg\'); background-size: cover; height: 200px; border: 1px solid #ddd; background-position: center; position: relative">
                    <div class="newestChapter"><a href="/story/chapter.php?id='.$newest['id'].'">'.sanitize_xss($newest['name']).'</a></div>
                </div>
                <a href="/story/view.php?id='.$getStory['id'].'">'. show_text(sanitize_xss($getStory['name'])).'</a>
            </div>';
    }
    return $html;
}

function page_cat() {
    global $total, $page, $id;
    
    if($total <= 60) return '';
    
    $html = '';

    $dem      = 0;
    $pageI    = $page > 4 ? $page-3 : 1;
    $end_page = ceil($total/60);
    if($end_page > 4) {
        if($page == $end_page-3) $pageI = $page-3;
        if($page == $end_page-2) $pageI = $page-4;
        if($page == $end_page-1) $pageI = $page-5;
        if($page == $end_page-0) $pageI = $page-6;
    }
    if($pageI < 1) $pageI = 1;
    if($page > 1) {
        $html .= 
            '<li class="page-item">
                <a class="page-link" href="cat.php?id='.$id.'&p=1'.(isset($_GET['search']) ? '&search='.htmlspecialchars($_GET['search']) : '').'" tabindex="-1" aria-disabled="true">«</a>
            </li>';
    }
        
    for($i= $pageI; $i <= $end_page; $i++) {
        $html .='<li class="page-item'.($i === $page ? ' active' : '').'"><a class="page-link" href="cat.php?id='.$id.'&p='.$i.''.(isset($_GET['search']) ? '&search='.htmlspecialchars($_GET['search']) : '').'" '.($i === $page ? 'aria-current="page"' : '').'>'.$i.' '.($i === $page ? ' <span class="sr-only">(current)</span>' : '').'</a></li>';
        if(++$dem === 7)  break;
    }
    if($page < $end_page) {
        $html .=
            '<li class="page-item">
                <a class="page-link" href="cat.php?id='.$id.'&p='.$end_page.''.(isset($_GET['search']) ? '&search='.htmlspecialchars($_GET['search']) : '').'" tabindex="-1" aria-disabled="true">»</a>
            </li>';
    }   

    return 
     '<nav aria-label="Page navigation example mt-2">
        <ul class="pagination justify-content-center mt-4">'.$html.'</ul>
     </nav>';
}


function you_like_box() {
    $html = '';
    $stories_like = do_cache('stories:rand:5', function() {
        return query_mysql('select * from stories as s1 INNER JOIN (select id from stories order by rand() limit 5) as s2 on s1.id=s2.id');
    }, 60*5);        
    foreach($stories_like as $get) {
        $html .= 
        '<div class="py-2" style="border-bottom: 1px solid #eee">
            <div class="flexRow">
                <div><img src="/assets/hentai/'.$get['thumb'].'.jpg" height="70px" width="50px" style="border: 1px solid #ddd"></div>
                <div class="flex1 pl-2">
                    <div><a href="/story/view.php?id='.$get['id'].'">'.sanitize_xss($get['name']).'</a></div>
                    <div class="flexRow">
                    <div class="flex1">
                    <div class="ellipsis">'.($get['authors'] ? sanitize_xss($get['authors']) : 'Đang cập nhật').'</div>
                    </div>
                    <div><i><i class="fa fa-eye fa-fw"></i> '.number_format($get['view']).'</i></div>
                    </div>
                </div>
            </div>
        </div>';
    }

    if (!$html) return '';
    return 
    '<div class="col-md-4">
        <div class="darkbox mt-4">
            <h2>CÓ THỂ BẠN THÍCH</h2>'.$html.'
        </div>
    </div>';
}