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
        '<div class="col-4 px-1 py-2">
            <div class="thumb_mob" onclick="'.href('/story/view.php?id='.$getStory['id']).'" style="background: url(\'//lxhentai.com/assets/hentai/'.$getStory['thumb'].'.jpg\'); background-size: cover; background-position: center; position: relative">        
            </div>
		    <a href="/story/view.php?id='.$getStory['id'].'" class="text-black">
                '.show_text(sanitize_xss($getStory['name'])).'<br/>
		        <small><a class="text-black" href="/story/chapter.php?id='.$newest['id'].'">'.sanitize_xss($newest['name']).'</a></small>
            </a>
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
