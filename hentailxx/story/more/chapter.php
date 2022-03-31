<?php

$id = (int)$id;

mysqli_query($conn, "update chapters set view = view+1 where id = {$id}");
cache_delete('chapters');
mysqli_query($conn, "update stories set view = view+1 where id = ".intval($getStory['id']));
cache_delete('stories');
if($my) {
    mysqli_query($conn, "insert into history (chapter_id, story_id, user_id) values ({$id}, ".intval($getStory['id']).", ".intval($my['id']).")");
    cache_delete('history'); 
}

$checkFollow = $my['id'] ? story_follow_total_by_sid_uid($getStory['id'], $my['id']) : null;

$prev = prev_chapters($getStory['id'], $getChapter['stt']);
$next = next_chapters($getStory['id'], $getChapter['stt']);

function smileys_chapter() {
    $smileys = '';
    foreach(get_smileys() as $get) {
        $smileys .= '<img onclick="insertComment(\''.$get['name'].'\')" src="/assets/smileys/'.$get['link'].'" />';
    }
    return $smileys;
}