<?php

function connect_mysql() {
    global $conn;

    // live
    $host = 'localhost';
    $user = 'vivoo';
    $pass = 'dmS8anHtswnhUjCp';
    $name = 'vivoo_715';

    // local
    // $host = 'localhost';
    // $user = 'root';
    // $pass = '';
    // $name = 'vivoo_715';

    $conn = mysqli_connect($host, $user, $pass, $name) or die('Error 1!');

    mysqli_set_charset($conn,'UTF8');
}

function close_mysql() {
    global $conn;

    if ($conn) {
        mysqli_close($conn); 
    }
}

function connect_redis() {
    global $redis;

    $host          = 'localhost';
    $port          = 6379;
    $password      = '';
    $database      = 0;
    $timeout       = 10;
    $retryInterval = 0;
    $readTimeout   = -1;

    $redis  = new Redis();
    $redis->connect($host, $port, $timeout, null, $retryInterval) or die('Error 2!');    
    $redis->setOption(Redis::OPT_READ_TIMEOUT, $readTimeout);
    
    if ('' != (string)$password) {
        $redis->auth($password);
    }
    $redis->select($database);    
}

function close_redis() {
    global $redis;

    if ($redis) {
        $redis->close(); 
    }
}

function is_mobile() {
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    
    return (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)   
        || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)));
}

function do_cache(string $key, callable $callback, ?int $lifeTime=0) {
    global $redis;

    $key   = "xxx:{$key}";
    $debug = false;

    $result = $debug ? null : $redis->get($key);
    if (gettype($result) !== 'string') {
        $result = $callback();
        if ($lifeTime === null) {
            // no expired
            $redis->set($key, igbinary_serialize($result));                
        } else {
            $redis->setex($key, $lifeTime, igbinary_serialize($result));
        }
        return $result;        
    }
    return igbinary_unserialize($result);  
}

function cache_delete($prefix) {
    global $redis;

    $keys = $redis->keys("xxx:({$prefix})_*");
    if (count($keys)) {
        $redis->del($keys);
    }
}

function exitx() {
    session_write_close();
    close_mysql();
    close_redis();
    exit;
}

function redirect($location='/') {
    Header("Location: {$location}");
    exitx();
}

function query_mysql(string $sql, bool $limit=false) {
    global $conn;
    $result = null;
    $sql .= $limit ? ' limit 1' : '';
    $query = mysqli_query($conn, $sql);
    while($get = mysqli_fetch_assoc($query)) {
        $result[] = $get;
    }
    mysqli_free_result($query);
    return $limit ? $result[0] : $result;
}

function get_smileys() {
    return do_cache('(smileys)_get_smileys', function() {
        return query_mysql('select * from smileys');        
    }, null);
}

function smileys($text) {
    [$search, $replace] = do_cache('(smileys)_smileys', function() {
        $data = get_smileys();
        foreach($data as $v) {
            $search [] = ":{$v['name']}:";
            $replace[] = '<img src="//lxhentai.com/assets/smileys/'.$v['link'].'">';
        }
        return [$search, $replace];
    }, null);

    return str_replace($search, $replace, $text);
}

function get_categories() {
    return do_cache('(categories)_get_categories', function() {
        return query_mysql('select * from categories order by name asc');
    }, null);
}

function character_by_id($chapter_id) {
    $chapter_id = (int)$chapter_id;
    if (!$chapter_id) {
        return null;
    }
    return do_cache("(chapters)_character_by_id:{$chapter_id}", function() use($chapter_id) {
        return query_mysql("select * from chapters where id = {$chapter_id}", true);
    }, 86400);
}

function categories_home() {
    return do_cache('(categories)_categories:home', function() {
        return query_mysql('select * from categories where type = "home"');
    }, 86400);
}

function categories_by_id($id) {
    $id = (int)$id;
    return do_cache("(categories)_categories_by_id:{$id}", function() use($id){
        return query_mysql("select * from categories where id = {$id}", true);
    }, 86400);
}

function get_user_login($email, $pass) {
    return do_cache("(users)_user:{$email}|{$pass}", function() use($email, $pass) {
        global $conn;
        $email = mysqli_real_escape_string($conn, $email);
        $pass  = mysqli_real_escape_string($conn, $pass);
        $query = "select * from users where email = '{$email}' and password = '{$pass}'";
        return query_mysql($query, true);
    }, null);
}

function do_login($email, $pass) {
    $user = get_user_login($email, $pass);
    if ($user['rights'] === 'admin') {
        return null;
    }
    return $user;
}

function do_login_admin($email, $pass) {
    $user = get_user_login($email, $pass);
    if ($user['rights'] === 'admin') {
        return $user;
    }
    return null;
}

function stories_by_id($story_id) {
    $story_id = (int)$story_id;
    if (!$story_id) {
        return null;
    }
    return do_cache("(stories)_stories_by_id:{$story_id}", function() use($story_id){
        return query_mysql("select * from stories where id = {$story_id}", true);
    }, 86400);
}

function user_by_id($user_id) {
    $user_id = (int)$user_id;
    if (!$user_id) {
        return null;
    }
    return do_cache("(users)_user_by_id:{$user_id}", function() use($user_id) {
        return query_mysql("select * from users where id = {$user_id}", true);
    }, 86400);
}

function story_follow_total_by_sid_uid($story_id, $user_id) {
    $story_id = (int)$story_id;
    $user_id = (int)$user_id;
    return do_cache("(story_follow)_story_follow_total_by_sid_uid:{$story_id}:{$user_id}", function() use ($story_id, $user_id) {        
        $result = query_mysql("select count(id) as total from story_follow where story_id = {$story_id} and user_id = {$user_id}", true);
        return (int)$result['total'];
    }, 86400);
}

function story_follow_total($story_id) {
    $story_id = (int)$story_id;
    return do_cache("(story_follow)_story_follow_total:{$story_id}", function() use ($story_id) {        
        $result = query_mysql("select count(id) as total from story_follow where story_id = {$story_id}", true);
        return (int)$result['total'];
    }, 86400);
}

function character_by_story_id($story_id) {
    $story_id = (int)$story_id;
    return do_cache("(chapters)_character_by_story_id:{$story_id}", function() use ($story_id) {        
        return query_mysql("select name, time, view, id from chapters where story_id = {$story_id} order by stt desc");
    }, 86400);
}

function comment_total($story_id) {
    $story_id = (int)$story_id;
    return do_cache("(comment)_comment_total:{$story_id}:0", function() use ($story_id) {        
        $result = query_mysql("select count(id) as total from comment where story_id = {$story_id} and sub = 0", true);
        return (int)$result['total'];
    }, 86400);
}

function comment30($story_id) {
    $story_id = (int)$story_id;
    return do_cache("(comment)_comment30:{$story_id}", function() use ($story_id) {        
        return query_mysql("select * from comment where story_id = {$story_id} and sub = 0 order by id desc limit 30");
    }, 86400);
}

function comment30_2($story_id, $lid) {
    $story_id = (int)$story_id;
    $lid = (int)$lid;
    return do_cache("(comment)_comment30_2:{$story_id}:$lid", function() use ($story_id, $lid) {        
        return query_mysql("select * from comment where story_id = {$story_id} and sub = 0 and id < {$lid} order by id desc limit 30");
    }, 86400);
}

function story_categories_by_story_id($story_id) {
    $story_id = (int)$story_id;
    return do_cache("(story_categories)_story_categories_by_story_id:{$story_id}", function() use ($story_id) {    
        return query_mysql("select category_id from story_categories where story_id = {$story_id}");
    }, 86400);
}

function story_categories_by_category_id($category_id) {
    $category_id = (int)$category_id;
    return do_cache("(story_categories)_story_categories_by_category_id:{$category_id}", function() use ($category_id) {   
        global $conn; 
        return mysqli_num_rows(mysqli_query($conn, 'select id from story_categories where category_id = '.$category_id));
    }, 86400);
}

function alert_new_total($user_id) {
    $user_id = (int)$user_id;
    return do_cache("(alert)_alert_new_total:{$user_id}:0", function() use($user_id) {
        $alert = query_mysql("select count(id) as total from alert where user_id = {$user_id} and view = 0", true);
        return (int)$alert['total'];
    }, 86400);
}

function show_text($s) {
    return strlen($s) > 40 ? substr($s, 0, 40) . '...' : $s;
}

function href($link) {
    return "window.location.href='{$link}'";
}

function sub_comment($sub) {
    $sub = (int)$sub;
    return do_cache("(comment)_sub_comment:{$sub}", function() use($sub) {
        return query_mysql("select * from comment where sub = {$sub}");
    }, 86400);
}

function alert_30($uid, $offset) {
    $uid = (int)$uid;
    return do_cache("(alert)_alert_30:{$uid}:{$offset}", function() use($uid, $offset) {
        return query_mysql("select * from alert where user_id = {$uid} order by view asc, id desc limit 30 offset {$offset}");  
    }, 86400);
}

function alert_total($uid) {
    $uid = (int)$uid;
    return do_cache("(alert)_alert_total:{$uid}", function() use($uid) {
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, "select id from alert where user_id = {$uid}"));  
    }, 86400);
}

// function history_30($uid, $offset) {
//     return do_cache("(history)_history_40:{$uid}:{$offset}", function() use($uid, $offset) {
//         return query_mysql('select distinct story_id from history where user_id = '.$uid.' order by story_id desc limit 40 offset '.$offset);
//     }, 86400);
// }

function history_30($uid, $offset) {
    $uid = (int)$uid;
    return do_cache("(history)_history_join_40_3:{$uid}:{$offset}", function() use($uid, $offset) {
        return query_mysql('select DISTINCT b.story_id, a.* from stories as a, history as b where a.id=b.story_id and b.user_id = '.$uid.' and a.duyet=1 order by b.story_id desc limit 40 offset '.$offset);
    }, 86400);
}

// function history_total($uid) {
//     return do_cache("(history)_history_total:{$uid}", function() use($uid) {
//         global $conn;
//         return mysqli_num_rows(mysqli_query($conn, 'select distinct story_id from history where user_id = '.$uid));
//     }, 86400);
// }

function history_total($uid) {
    $uid = (int)$uid;
    return do_cache("(history)_history_join_total_2:{$uid}", function() use($uid) {
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, 'select DISTINCT b.story_id from stories as a, history as b where a.id=b.story_id and b.user_id = '.$uid.' and a.duyet=1'));
    }, 86400);
}

function history_total_story_id_chapter_id($uid, $story_id, $chapter_id) {
    $uid = (int)$uid;
    $story_id = (int)$story_id;
    $chapter_id = (int)$chapter_id;
    return do_cache("(history)_history_total_story_id_chapter_id:{$uid}:{$story_id}:{$chapter_id}", function() use($uid, $story_id, $chapter_id) {     
        $total = query_mysql("select count(id) as total from history where user_id = {$uid} and story_id = {$story_id} and chapter_id = {$chapter_id}", true);
        return (int)$total['total'];
    }, 86400);
}

function history_by_story_id($story_id) {
    $story_id = (int)$story_id;
    return do_cache("(history)_history_by_story_id:{$story_id}", function() use($story_id) {
        return query_mysql("select chapter_id from history where story_id = {$story_id} order by id desc", true);
    }, 86400);
}

function story_follow_24($uid, $offset) {
    $uid = (int)$uid;
    return do_cache("(story_follow)_story_follow_24:{$uid}:{$offset}", function() use($uid, $offset) {
        return query_mysql('select story_id from story_follow where user_id = '.$uid.' order by id desc limit 24 offset '.$offset);
    }, 86400);
}

// function story_follow_nopage($uid) {
//     return do_cache("(story_follow)_story_follow_24:{$uid}", function() use($uid) {
//         return query_mysql('select story_id from story_follow where user_id = '.$uid.' order by id desc');
//     }, 86400);
// }

function story_follow_nopage($uid) {
    $uid = (int)$uid;
    return do_cache("(story_follow)_story_follow_join_24:{$uid}", function() use($uid) {
        return query_mysql('select a.* from stories as a, story_follow as b 
                            where a.id=b.story_id and b.user_id = '.$uid.' order by b.id desc');
    }, 86400);
}

function story_follow_total_by_uid($uid) {
    $uid = (int)$uid;
    return do_cache("(story_follow)_story_follow_total_by_uid:{$uid}", function() use($uid) {
        global $conn;
        return intval(mysqli_fetch_assoc(mysqli_query($conn, 'select COUNT(id) as ids from story_follow where user_id = '.$uid))['ids']);
    }, 86400);
}

function stories_uid_total($uid) {
    $uid = (int)$uid;
    return do_cache("(stories)_stories_uid_total:{$uid}", function() use($uid) {
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, 'select id from stories where user_id = '.$uid));
    }, 86400);
}

function stories_uid_30($uid, $offset) {
    $uid = (int)$uid;
    return do_cache("(stories)_stories_uid_30:{$uid}:{$offset}", function() use($uid, $offset) {
        return query_mysql('select thumb, name, id, view, status, duyet from stories where user_id = '.$uid.' order by id desc limit 30 offset '.$offset);
    }, 86400);
}

function chapters_uid_total($uid) {
    $uid = (int)$uid;
    return do_cache("(chapters)_chapters_uid_total:{$uid}", function() use($uid) {
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, 'select id from chapters where user_id = '.$uid));
    }, 86400);
}

function comment_uid_total($uid) {
    $uid = (int)$uid;
    return do_cache("(comment)_comment_uid_total:{$uid}", function() use($uid) {
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, 'select id from comment where user_id = '.$uid));
    }, 86400);
}

function categories_total_admin() {
    return do_cache("(categories)_categories_total_admin", function() {
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, 'select id from categories'));
    }, 86400);
}

function stories_total_admin() {
    return do_cache("(stories)_stories_total_admin", function() {
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, 'select id from stories'));
    }, 86400);
}

function stories_pennding_total_admin() {
    return do_cache("(stories)_stories_pennding_total_admin", function() {
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, 'select id from stories where duyet = 0'));
    }, 86400);
}

function users_total_admin() {
    return do_cache("(users)_users_total_admin", function() {
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, 'select id from users'));
    }, 86400);
}

function comment_total_admin() {
    return do_cache("(comment)_comment_total_admin", function() {
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, 'select id from comment'));
    }, 86400);
}

function chapters_total_admin() {
    return do_cache("(chapters)_chapters_total_admin", function() {
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, 'select id from chapters'));
    }, 86400);
}

function user_60($offset) {
    return do_cache("(users)_user_60:{$offset}", function() use($offset) {
        return query_mysql("select * from users limit 60 offset {$offset}");
    }, 86400);
}

function story_categories_60($id) {
    $id = (int)$id;
    return do_cache("(story_categories)_story_categories:1:{$id}:60", function()use($id){
        $sql = "SELECT c.* 
                FROM stories AS s, story_categories AS c 
                WHERE c.story_id = s.id AND c.category_id = {$id} AND s.duyet = 1 
                ORDER BY c.lastupdate DESC, c.id DESC 
                LIMIT 60";
        return query_mysql($sql);
    }, 86400);
}

function stories_like_author($getStory, $id) {
    $id = (int)$id;
    return do_cache('stories_like_author:'.str_replace(' ','',$getStory['authors']).':rand:5', function() use($getStory, $id){
        return query_mysql("select * from stories as s1 INNER JOIN (select * from stories where duyet = 1 and authors = '{$getStory['authors']}' and id != {$id} order by rand() limit 5) as s2 on s1.id=s2.id");
    }, 60*5);   
}

function users_total_24_admin($time24) {    
    return do_cache("(users)_users_total_24_admin:".date('dmY', $time24), function() use($time24){
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, "select id from users where time > {$time24}"));
    }, 86400);
}

function stories_total_24_admin($time24) {    
    return do_cache("(stories)_stories_total_24_admin:".date('dmY', $time24), function() use($time24){
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, "select id from stories where time > {$time24}"));
    }, 86400);
}

function chapters_total_24_admin($time24) {    
    return do_cache("(chapters)_chapters_total_24_admin:".date('dmY', $time24), function() use($time24){
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, "select id from chapters where time > {$time24}"));
    }, 86400);
}

function comment_total_24_admin($time24) {    
    return do_cache("(comment)_comment_total_24_admin:".date('dmY', $time24), function() use($time24){
        global $conn;
        return mysqli_num_rows(mysqli_query($conn, "select id from comment where time > {$time24}"));
    }, 86400);
}

function comment_30($offset) {
    return do_cache("(comment)_comment_30:{$offset}", function() use($offset) {
        return query_mysql("select * from comment order by id desc limit 30 offset {$offset}");
    }, 86400);
}

function story_follow_by_story_follow($story_id) {
    $story_id = (int)$story_id;
    return do_cache("(story_follow)_story_follow_by_story_follow:{$story_id}", function() use($story_id){
        return query_mysql("select * from story_follow where story_id = {$story_id}");
    }, 86400);
}

function prev_chapters($story_id, $stt) {
    $story_id = (int)$story_id;
    $stt = (int)$stt;
    return do_cache("(chapters)_prev_chapters:{$story_id}:{$stt}", function() use($story_id, $stt){
        return query_mysql("select id from chapters where story_id = {$story_id} and stt < {$stt} order by stt desc", true);
    }, 86400);
}

function next_chapters($story_id, $stt) {
    $story_id = (int)$story_id;
    $stt = (int)$stt;
    return do_cache("(chapters)_next_chapters:{$story_id}:{$stt}", function() use($story_id, $stt){
        return query_mysql("select id from chapters where story_id = {$story_id} and stt > {$stt} order by stt asc", true);
    }, 86400);
}

function sanitize_xss($s) {
    $s = strip_tags(ltrim($s, '>'));
    return htmlspecialchars($s, ENT_QUOTES | ENT_HTML5);
}