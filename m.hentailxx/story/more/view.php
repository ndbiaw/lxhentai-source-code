<?php

$newest     = [];
$listChuong = '';
$queryChuong = character_by_story_id($id);
foreach($queryChuong as $get) {
    if(!$newest) $newest = $get;
    
    $checkRead = true;//history_total_story_id_chapter_id($id, $get['id']);

    $listChuong .= 
    '<div style="width: 50%;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;" class="pl-2 py-2">
        <a class="text-black" href="/story/chapter.php?id='.$get['id'].'" '.($checkRead ? 'class="seen"' : '').'>'.$get['name'].'</a>
    </div>';
    
    $oldest = $get;
}

$checkFollow = story_follow_total_by_sid_uid($id, $my['id']);

$theloai = '';
foreach(story_categories_by_story_id($id) as $got) {
    $theloai .= ' <a href="/story/cat.php?id='.$got['category_id'].'">'.sanitize_xss(categories_by_id($got['category_id'])['name']).'</a>, ';
}
$theloai .= '.';
$theloai = str_replace(', .', '', $theloai);

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
        $smileys .= '<img onclick="insertComment(\''.$get['name'].'\')" src="//lxhentai.com/assets/smileys/'.$get['link'].'" />';
    }
    return $smileys;
}