<?php

$newest     = [];
$listChuong = '';
$queryChuong = character_by_story_id($id);
foreach($queryChuong as $get) {
    if(!$newest) $newest = $get;
    
    $checkRead = true;//history_total_story_id_chapter_id($my['id'], $id, $get['id']);
    $listChuong .= '
    <li class="row" style="border-bottom: 1px dashed #ddd; padding: 5px 0 10px;">
        <div class="col-5"><a href="/story/chapter.php?id='.$get['id'].'" '.($checkRead ? 'class="seen"' : '').' style="color:#fff">'.sanitize_xss($get['name']).'</a></div>
        <div class="text-center col-4" style="color: #777676; font-style: italic;">'.date('H:i d/m/y', $get['time']).'</div>
        <div class="text-center col-3" style="color: #777676; font-style: italic;">'.number_format($get['view']).'</div>
    </li>
    ';
    $oldest = $get;
}
$id = (int)$id;
mysqli_query($conn, "update stories set chapter_id = ".intval($newest['id'])." where id = {$id}");
cache_delete('stories');
$checkFollow = story_follow_total_by_sid_uid($id, $my['id']);

$theloai = '';
foreach(story_categories_by_story_id($id) as $got) {
    $theloai .= ' <a href="/story/cat.php?id='.$got['category_id'].'">'.sanitize_xss(categories_by_id($got['category_id'])['name']).'</a> -';
}
$theloai .= '.';
$theloai = str_replace(' -.', '', $theloai);

$demComment = comment_total($id);

$author       = explode(',', $getStory['authors']);
$total_author = count($author)-1;
$authors      = '';
foreach($author as $i=>$value) {
    $authors .= '<a href="/story/search.php?type=tacgia&key='.$value.'&exact">'.sanitize_xss($value).'</a>';
    if($i != $total_author) {
        $authors .= ', ';
    }    
}

$doujinshi       = explode(',', $getStory['doujinshi']);
$total_doujinshi = count($doujinshi)-1;
$doujinshis      = '';
foreach($doujinshi as $i=>$value) {
    $doujinshis .= '<a href="/story/search.php?type=doujinshi&key='.$value.'">'.sanitize_xss($value).'</a>';
    if($i != $total_doujinshi) {
        $doujinshis .= ', ';
    }
}

function smileys_view() {
    $smileys = '';
    foreach(get_smileys() as $get) {
        $smileys .= '<img onclick="insertComment(\''.$get['name'].'\')" src="/assets/smileys/'.$get['link'].'" />';
    }
    return $smileys;
}

function stories_like_view() {
    global $getStory, $id;

    $html = '';
    foreach(stories_like_author($getStory, $id) as $get) {
        $html .= 
        '<div class="py-2" style="border-bottom: 1px solid #eee">
            <div class="flexRow">
                <div><img src="/assets/hentai/'.$get['thumb'].'.jpg" height="70px" width="50px" style="border: 1px solid #ddd"></div>
                <div class="flex1 pl-2">
                    <div><a href="/story/view.php?id='.$get['id'].'">'.sanitize_xss($get['name']).'</a></div>
                    <div class="flexRow">
                    <div class="flex1">
                    <div class="ellipsis">'.($get['authors'] ?: 'Đang cập nhật').'</div>
                    </div>
                    <div><i><i class="fa fa-eye fa-fw"></i> '.number_format($get['view']).'</i></div>
                    </div>
                </div>
            </div>
        </div>';
    }
    return $html;
}