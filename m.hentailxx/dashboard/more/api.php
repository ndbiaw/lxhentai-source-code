<?php

function get_home_tab($id) {
    $data = [];    
    foreach(story_categories_60($id) as $tt) {
            $getStory       = stories_by_id($tt['story_id']);
            $x              = [];
        $x['id']           = $getStory['id'];
        $x['thumb']        = $getStory['thumb'];
        $x['chapter_id']   = $getStory['chapter_id'];
        $x['chapter_name'] = sanitize_xss( character_by_id($getStory['chapter_id'])['name'] );
        $x['name']         = show_text(sanitize_xss($getStory['name']));
        array_push($data, $x);
    }
    
    echo json_encode($data);
}

function user_similar() {
    global $conn;

    $data = [];
    $type = trim($_GET['type']);
    $key  = mysqli_real_escape_string($conn, $_GET['key']);
    if ($type) {
        $stories = query_mysql("select {$type}, id from stories where name like '%{$key}%' limit 5");
        foreach($stories as $get) {
            if(trim($get[$type]))   array_push($data, $get);
        }
    }        
    echo json_encode($data);
}

function user_follow_story() {
    global $conn, $my, $id;

    if(!$my)    echo 0;
    else {
        $id = (int)$id;
        $my_id = (int)$my['id'];
        $check = query_mysql("select count(id) as total from story_follow where story_id = {$id} and user_id = {$my_id}", true);        
        if((int)$check['total']) {
            mysqli_query($conn, "delete from story_follow where story_id = {$id} and user_id = {$my_id}") or die('error');
            cache_delete('story_follow');
            echo 1;
        } else {
            mysqli_query($conn, "insert into story_follow (story_id, user_id) values({$id},{$my_id})") or die('error');
            cache_delete('story_follow');
            echo 2;
        }
    }
}

function user_sub_comment() {
    global $my, $conn, $id, $cid;

    if(!$my)    echo '{"error": 1}';
    else {
        if(isset($_POST['comment'])) {
            $id = (int)$id;
            $check = query_mysql("select count(id) as total from comment where id = {$id} and sub = 0", true);  
            if((int)$check['total']) {        
                $data = [];
                $time    = time();
                $comment = mysqli_real_escape_string($conn, $_POST['comment']);
                $cid     = (int)$cid;
                $my_id   = (int)$my['id'];
                $query   = "insert into comment (user_id, time, text, sub, story_id, chapter_id) 
                            values ({$my_id}, {$time}, '{$comment}', {$id}, {$id}, {$cid})";
                $result = mysqli_query($conn, $query);  
                cache_delete('comment');          
                if ($result) {
                    $lid       = mysqli_insert_id($conn);
                      
                    $data['id']      = $lid;
                    $data['user_id'] = $my['id'];
                    $data['rights']  = $my['rights'] == 'admin' ? 'admin' : 'member';
                    $data['name']    = sanitize_xss($my['username']);
                    $data['comment'] = smileys($comment);
                    $data['time']    = date('H:i d/m/y', $time);
                }
                      
                echo json_encode($data);
            }
        }        
    }
}

function show_comment() {
    global $id;

    $data = [];
    $lid  = (int)$_GET['lid'];
    $comment = $lid ? comment30_2($id, $lid) : comment30($id);
    foreach($comment as $get) {
        $getUser      = user_by_id($get['user_id']);

        $get['rights']     = $getUser['rights'] == 'admin' ? 'admin' : 'member';
        $get['name']       = sanitize_xss($getUser['username']);
        $get['chapters']   = sanitize_xss( character_by_id($get['chapter_id'])['name'] ?? '' );
        $get['comment']    = smileys($get['text']);
        $get['subcomment'] = [];
        $get['time']       = date('H:i d/m/y', $get['time']);
        
        foreach(sub_comment($get['id']) as $got) {                
                    $getUser   = user_by_id($got['user_id']);
            $got['rights']  = $getUser['rights'] =  'admin' ? 'admin' : 'member';
            $got['name']    = sanitize_xss($getUser['username']);
            $got['comment'] = smileys($got['text']);
            $got['time']    = date('H:i d/m/y', $got['time']);
            array_push($get['subcomment'], $got);
        }
        array_push($data, $get);
    }
    echo json_encode($data);
}

function user_comment() {
    global $my, $conn, $id;
    
    if(!$my)    echo '{"error": 1}';
    else {
        $cid = intval($_POST['cid']);
        $getChapter = $cid ? character_by_id($cid) : true;

        if(isset($_POST['comment']) && $get = stories_by_id($id) && $getChapter) {
            $data = [];
            $time = time();
            $comment = mysqli_real_escape_string($conn, $_POST['comment']);
            $my_id   = (int)$my['id'];
            $query = "insert into comment (story_id, chapter_id, user_id, time, text, sub) 
                    values ({$id}, {$cid}, {$my_id}, {$time}, '{$comment}', 0)";
            $result = mysqli_query($conn, $query);
            cache_delete('comment');          
            if ($result) {
                $lid = mysqli_insert_id($conn);

                if($my['id'] != $get['user_id']) {
                    $html = '<a href="/story/view.php?id='.$id.'">Truyện <b>'.($get['name']).'</b> có một bình luận mới từ <b>'.($my['username']).'</b> !</a>';
                    $query = "insert into alert(user_id, text, time, view) values ({$get['user_id']}, '".mysqli_real_escape_string($conn, $html)."',{$time}, 1)";                        
                    mysqli_query($conn, $query);
                    cache_delete('alert');          
                }
                
                $data['id']       = $lid;
                $data['user_id']  = $my['id'];
                $data['rights']   = $my['rights'] == 'admin' ? 'admin' : 'member';
                $data['name']     = sanitize_xss($my['username']);
                $data['chapters'] = sanitize_xss($getChapter['name'] ?? '');
                $data['comment']  = smileys($_POST['comment']);
                $data['time']     = date('H:i d/m/y', $time);
            }
            echo json_encode($data);
        }
    }
}

function admin_delete_comment() {
    global $my, $conn, $id;

    if($my['rights'] === 'admin') {
        $id = (int)$id;
        mysqli_query($conn, "delete from comment where id = {$id}");
        cache_delete('comment');
    }
}

function user_delete_story() {
    global $my, $conn, $id;

    $id = (int)$id;
    $my_id = (int)$my['id'];
    if($my['rights'] === 'admin' || mysqli_num_rows(mysqli_query($conn, "select id from stories where user_id = {$my_id} and id = {$id}"))) {
        mysqli_query($conn, "delete from stories where id = {$id}");
        cache_delete('stories');
        mysqli_query($conn, "delete from story_categories where story_id = {$id}");
        cache_delete('story_categories');
        mysqli_query($conn, "delete from chapters where story_id = {$id}");
        cache_delete('chapters');
    }
}

function admin_check_category() {
    global $my, $conn, $id;

    $id = (int)$id;
    if($my['rights'] === 'admin') {            
        mysqli_query($conn, "update categories set type = ".(categories_by_id($id)['type']?'':'home')." where id = {$id}");
        cache_delete('categories');
    }
}

function admin_duyet_story() {
    global $my, $id, $conn;

    $id = (int)$id;
    if($my['rights'] === 'admin' && $get = stories_by_id($id)) {
        mysqli_query($conn, "update stories set duyet = 1 where id = {$id}");
        cache_delete('stories');
        $time = time();
        $html = '<a href="/story/view.php?id='.$id.'">Truyện <b>'.($get['name']).'</b> của bạn đã được duyệt !</a>';
        $query = "insert into alert (user_id, text, time, view) 
            values ({$get['user_id']}, '".mysqli_real_escape_string($conn, $html)."', {$time}, 1)";
        mysqli_query($conn, $query);
        cache_delete('alert');          
    }
}