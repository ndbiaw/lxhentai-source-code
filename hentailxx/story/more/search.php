<?php
$type = trim(htmlspecialchars($_GET['type']));
$page = isset($_GET['p']) ? abs(intval($_GET['p'])) : 1;

$offset = $page>1 ? ($page-1)*60 : 0;
$query  = '';

$sqlFolder       = '';
$getSelectFolder = '&';

if($_GET['flexCat']) {
    foreach($_GET['selectFolder'] as $key => $value) {
        $value = (int)$value;
        if (!$value)    continue;
        
		$getSelectFolder .= 'selectFolder%5B%5D='.$value.'&';
        if($_GET['flexCat'] == 1) {
            $sqlFolder .= ' category_id != '.$value;
            if($key != (count($_GET['selectFolder'])-1)) {
                $sqlFolder .= ' and';
            }
        } else {
            $sqlFolder .= ' category_id = '.$value;
            if($key != (count($_GET['selectFolder'])-1)) {
                $sqlFolder .= ' or';
            }
        }
    }
}
$_GET['selectFolder'] = $getSelectFolder;
$key = htmlspecialchars($_GET['key']);
$key = mysqli_real_escape_string($conn, $key);

$where_status = $_GET['status'] ? 'status = '.($_GET['status'] == 1 ? 1 : 2).' and' : '';
$where_key    = " like '%{$key}%'";
$where_id     = "and id in (select distinct story_id from story_categories where {$sqlFolder})";

switch($type) {
    default:
    if(!$_GET['flexCat']) {
        $stories = query_mysql("select * from stories where duyet = 1 and {$where_status} name {$where_key} limit 60 offset {$offset}");
        $total   = query_mysql("select count(id) as total from stories where duyet = 1 and {$where_status} name {$where_key}", true);
    } else {
        $stories = query_mysql("select * from stories where duyet = 1 and {$where_status} name {$where_key} {$where_id} limit 60 offset {$offset}");
        $total   = query_mysql("select count(id) as total from stories where duyet = 1 and {$where_status} name {$where_key} {$where_id}", true);
    }
    break;
    case 'tacgia':
    if(!$_GET['flexCat']) {
		if(!isset($_GET['exact'])) {
            $stories = query_mysql("select * from stories where duyet = 1 and {$where_status} authors {$where_key} limit 60 offset {$offset}");
            $total   = query_mysql("select count(id) as total from stories where {$where_status} authors {$where_key}", true);
		} else {
            $stories = query_mysql("select * from stories where duyet = 1 and {$where_status} authors = '{$key}' limit 60 offset {$offset}");
            $total   = query_mysql("select count(id) as total from stories where duyet = 1 and {$where_status} authors = '{$key}'", true);
		}
	} else {
        $stories = query_mysql("select * from stories where duyet = 1 and {$where_status} name {$where_key} {$where_id} limit 60 offset {$offset}");
        $total   = query_mysql("select count(id) as total from stories where duyet = 1 and {$where_status} name {$where_key} {$where_id}", true);
    }
    break;
    case 'doujinshi':
	if(!$_GET['flexCat']) {
        $stories = query_mysql("select * from stories where duyet = 1 and {$where_status} doujinshi {$where_key} limit 60 offset {$offset}");
        $total   = query_mysql("select count(id) as total from stories where duyet = 1 and {$where_status} doujinshi {$where_key}", true);
    } else {
        $stories = query_mysql("select * from stories where duyet = 1 and {$where_status} doujinshi {$where_key} {$where_id} limit 60 offset {$offset}");
        $total   = query_mysql("select count(id) as total from stories where duyet = 1 and {$where_status} doujinshi {$where_key} {$where_id}", true);
    }
    break;
}

$total = (int)$total['total'];

function page_search() {
    global $total, $page, $key, $type;

    if($total <= 60) return '';
    
    $html     = '';
    $dem      = 0;
    $pageI    = $page > 4 ? $page-3 : 1;
    $end_page = ceil($total/60);
    if($end_page > 4) {
        if($page == $end_page-3) $pageI = $page-3;
        if($page == $end_page-2) $pageI = $page-4;
        if($page == $end_page-1) $pageI = $page-5;
        if($page == $end_page-0) $pageI = $page-6;
    }
    if($page > 1) {
        $html .= 
        '<li class="page-item">
            <a class="page-link" href="search.php?key='.$key.'&type='.$type.'&status='.htmlspecialchars($_GET['status']).'&flexCat='.htmlspecialchars($_GET['flexCat']).htmlspecialchars($_GET['selectFolder']).'&p=1'.(isset($_GET['hot']) ? '&hot' : '').'" tabindex="-1" aria-disabled="true">«</a>
        </li>';
    }
        
    for($i = $pageI; $i <= $end_page; $i++) {
        $html .= '<li class="page-item'.($i === $page ? ' active' : '').'"><a class="page-link" href="search.php?key='.$key.'&status='.htmlspecialchars($_GET['status']).'&flexCat='.htmlspecialchars($_GET['flexCat']).htmlspecialchars($_GET['selectFolder']).'&type='.$type.'&p='.$i.'" '.($i === $page ? 'aria-current="page"' : '').'>'.$i.' '.($i === $page ? ' <span class="sr-only">(current)</span>' : '').'</a></li>';
        if(++$dem === 7)    break;
    }
    if($page < $end_page) {
        $html .= 
        '<li class="page-item">
            <a class="page-link" href="search.php?key='.$key.'&status='.htmlspecialchars($_GET['status']).'&flexCat='.htmlspecialchars($_GET['flexCat']).htmlspecialchars($_GET['selectFolder']).'&type='.$type.'&p='.$end_page.'" tabindex="-1" aria-disabled="true">»</a>
        </li>';
    }
        
    return 
    '<nav aria-label="Page navigation example mt-2">
        <ul class="pagination justify-content-center mt-4">'.$html.'</ul>
    </nav>';
}