<?php

$page   = isset($_GET['p']) ? abs(intval($_GET['p'])) : 1;
$offset = $page>1 ? ($page-1)*60 : 0;

if(!isset($_GET['hot'])) {
    $stories = do_cache("(stories)_stories:duyet:1:{$page}", function() use($offset){
        return query_mysql("select * from stories where duyet = 1 order by time desc limit 60 offset {$offset}");
    }, 86400);        
    
    $total = do_cache("(stories)_stories_total:duyet:1", function() {
        return query_mysql("select count(id) as total from stories where duyet = 1", true);
    }, 86400);
} else {
    $stories = do_cache("(stories)_stories:{$page}", function() use($offset){
        return query_mysql("select * from stories order by view desc limit 60 offset {$offset}");
    }, 86400);        
    
    $total = do_cache("(stories)_stories_total", function() {
        return query_mysql("select count(id) as total from stories", true);
    }, 86400);
}
$total = (int)$total['total'];

function page_index() {
    global $total, $page;

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
            <a class="page-link" href="index.php?p=1'.(isset($_GET['hot']) ? '&hot' : '').'" tabindex="-1" aria-disabled="true">«</a>
        </li>';
    }
        
    for($i = $pageI; $i <= $end_page; $i++) {
        $html .= '<li class="page-item'.($i === $page ? ' active' : '').'"><a class="page-link" href="index.php?p='.$i.''.(isset($_GET['hot']) ? '&hot' : '').'" '.($i === $page ? 'aria-current="page"' : '').'>'.$i.' '.($i === $page ? ' <span class="sr-only">(current)</span>' : '').'</a></li>';
        if(++$dem === 7)  break;
    }
    if($page < $end_page) {
        $html .= 
        '<li class="page-item">
            <a class="page-link" href="index.php?p='.$end_page.''.(isset($_GET['hot']) ? '&hot' : '').'" tabindex="-1" aria-disabled="true">»</a>
        </li>';
    }
        
    return '<nav aria-label="Page navigation example mt-2"><ul class="pagination justify-content-center mt-4">'.$html.'</ul></nav>';
}