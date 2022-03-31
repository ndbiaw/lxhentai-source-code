<?php

$rights = $my['rights'];
$uid    = $my['id'];

if($_GET['user_access']) {
    if($my['rights'] == 'admin' && $my['id'] != $_GET['user_access']) {        
        $my = user_by_id(intval($_GET['user_access']));
        if($my) {
            $uid = intval($_GET['user_access']);
            $access = '<span style="color: green">(*) BẠN ĐANG SỬ DỤNG TRANG CÁ NHÂN VỚI TƯ CÁCH LÀ <b>'.sanitize_xss($my['username']).'</b></span>';
        } else {            
            $my = user_by_id($uid);
        }
    }
}

function default_index() {
    global $conn, $uid;

    $content = '<h1 class="postname">Tổng quan</h1>';
    $page   = isset($_GET['p']) ? abs(intval($_GET['p'])) : 1;
    $offset = $page>1 ? ($page-1)*30 : 0;
    $alert  = alert_30($uid, $offset);
    $total  = alert_total($uid);
    
    if(!$alert) $content .= '<div class="alert alert-info">Bạn chưa có thông báo nào.</div>';
    foreach($alert as $get)
    {
        mysqli_query($conn, 'update alert set view = 1 where id = '.intval($get['id']));
        cache_delete('alert');
        $content .= 
        '<div class="alert alert-'.(!$get['view'] ? 'success' : 'info').' my-2 thongbao">
            <div class="row">
                <div class="col-md-8"><i class="fa fa-bell fa-fw"></i> '.sanitize_xss($get['text']).'</div>
                <div class="col-md-4 text-right"><i class="fa fa-clock fa-fw"></i> '.date('H:i d/m/Y', $get['time']).'</div>
            </div>
        </div>';
    }

    if($total > 30) {
        $content .= 
        '<nav aria-label="Page navigation example mt-2">
            <ul class="pagination justify-content-center mt-4">';
        $dem      = 0;
        $pageI    = $page > 4 ? $page-3 : 1;
        $end_page = ceil($total/30);
        if($end_page > 4) {
            if($page == $end_page-3) $pageI = $page-3;
            if($page == $end_page-2) $pageI = $page-4;
            if($page == $end_page-1) $pageI = $page-5;
            if($page == $end_page-0) $pageI = $page-6;
        }
        if($pageI < 1) $pageI = 1;
        if($page > 1) {
            $content .= '<li class="page-item">
            <a class="page-link" href="index.php?p=1" tabindex="-1" aria-disabled="true">«</a>
            </li>';
        }            
		
        for($i = $pageI; $i <= $end_page; $i++) {
            $content .= '<li class="page-item'.($i === $page ? ' active' : '').'"><a class="page-link" href="index.php?p='.$i.'" '.($i === $page ? 'aria-current="page"' : '').'>'.$i.' '.($i === $page ? ' <span class="sr-only">(current)</span>' : '').'</a></li>';
            if(++$dem === 7)    break;
        }
        if($page < $end_page) {
            $content .= '<li class="page-item">
                <a class="page-link" href="index.php?p='.$end_page.'" tabindex="-1" aria-disabled="true">»</a>
            </li>';
        }
            
        $content .= '</ul></nav>';
    }

    return $content;
}

function password_index() {
    global $conn, $access, $my;

    $content = '<h1 class="postname">Đổi mật khẩu</h1>';
    if(isset($_POST['changepass'])) {
        if(!$access) {
            if($_POST['newpass'] != $_POST['newpass2'] || !$_POST['newpass']) {
                $content .= '<div class="alert alert-danger">Mật khẩu mới khác nhau !</div>';
            } else {
                if(md5($_POST['oldpass']) != $my['password']) {
                    $content .= '<div class="alert alert-danger">Mật khẩu cũ không đúng !</div>';
                } else {
                    mysqli_query($conn, 'update users set password = "'.md5($_POST['newpass']).'" where id = '.intval($my['id']));
                    cache_delete('users');
                    setcookie('password', md5($_POST['newpass']), time()+86400*365, '/');
                    $content .= '<div class="alert alert-success">Đổi mật khẩu thành công !</div>';
                }
            }
        } else {
            mysqli_query($conn, 'update users set password = "'.md5($_POST['newpass']).'" where id = '.intval($my['id']));
            cache_delete('users');
            $content .= '<div class="alert alert-success">Đổi mật khẩu thành công !</div>';
        }
    }
    return $content . 
    '<div>
        <form method="post">            
            '.(!$access ? 
            '<div class="form-group">
                <label>Mật khẩu cũ</label>
                <input class="form-control" required type="password" name="oldpass" placeholder="nhập mật khẩu cũ..."/>
            </div>' : ''
            ).'
            <div class="form-group">
                <label>Mật khẩu mới</label>
                <input class="form-control" required type="password" name="newpass" placeholder="nhập mật khẩu mới..."/>
            </div>
            <div class="form-group">
                <label>Nhập lại mật khẩu mới</label>
                <input class="form-control" required type="password" name="newpass2" placeholder="nhập lại mật khẩu mới..."/>
            </div>
            <button class="btn btn-primary" type="submit" name="changepass">Đổi mật khẩu</button>
        </form>
    </div>';
}

function history_index($title) {
    global $uid;
    
    $content = '<h1 class="postname">'.$title.'</h1>';

    $page   = isset($_GET['p']) ? abs(intval($_GET['p'])) : 1;
    $offset = $page>1 ? ($page-1)*66 : 0;
    
    $history = history_30($uid, $offset);
    $total   = history_total($uid);
    $content .= 
    '<div class="mb-2" style="color:#fff">Bạn đã đọc qua <b>'. number_format($total).'</b> truyện. Theo dõi truyện đó để nhận những thông báo mới và tránh lạc mất truyện nhé !</div>
    <div class="row">';

    if(!$total) {
        $content .= '<div class="mt-2 col-12">Bạn chưa đọc qua truyện nào.</div>';
    } else {
        foreach($history as $get) {
            // $get   = stories_by_id($gett['story_id']);
            // if (!$get['duyet']) {
            //     // $total--;
            //     continue;
            // }
            $dd    = history_by_story_id($get['id']);
            
            $docdo = character_by_id($dd['chapter_id']);
            $content .= 
            '<div class="col-md-6" id="story_'.$get['id'].'">
                <div class="flexRow py-3" style="border-bottom: 1px solid #eee">
                    <div style="width: 150px; height: 250px;">
                        <img src="/assets/hentai/'.$get['thumb'].'.jpg" width="150px" height="250px" alt="" />
                    </div>
                    <div class="ml-3" style="flex:1;color:#fff">
                        <span class="text-large"><a href="/story/view.php?id='.$get['id'].'">'.sanitize_xss($get['name']).'</a></span><br/>
                        '.($get['duyet'] ? ($get['status'] ? '<font color=green><i class="fal fa-check fa-fw"></i>Đã hoàn thành</font>' : '<font color=blue><i class="fal fa-clock fa-fw"></i> Chưa hoàn thành</font>') : '<font color=gray>...chờ duyệt</font>').'<br/>
                        Đang đọc dở: <a href="/story/chapter.php?id='.$docdo['id'].'">'.sanitize_xss($docdo['name']).'</a>
                    </div>
                </div>
            </div>';
        }
    }

    $content .= '</div>';

    if($total > 66) {
        $content .= 
        '<nav aria-label="Page navigation example mt-2">
            <ul class="pagination justify-content-center mt-4">';

        $dem      = 0;
        $pageI    = $page > 4 ? $page-3 : 1;
        $end_page = ceil($total/66);
        if($end_page > 4) {
            if($page == $end_page-3) $pageI = $page-3;
            if($page == $end_page-2) $pageI = $page-4;
            if($page == $end_page-1) $pageI = $page-5;
            if($page == $end_page-0) $pageI = $page-6;
        }
		if($pageI < 1) $pageI = 1;
        if($page > 1) {
            $content .= 
            '<li class="page-item">
                <a class="page-link" href="index.php?page=history&user_access='.$uid.'&p=1" tabindex="-1" aria-disabled="true">«</a>
            </li>';
        }
            
        for($i = $pageI; $i <= $end_page; $i++) {
            $content .= '<li class="page-item'.($i === $page ? ' active' : '').'"><a class="page-link" href="index.php?page=history&user_access='.$uid.'&p='.$i.'" '.($i === $page ? 'aria-current="page"' : '').'>'.$i.' '.($i === $page ? ' <span class="sr-only">(current)</span>' : '').'</a></li>';
            if(++$dem === 7)    break;
        }
        if($page < $end_page) {
            $content .= 
            '<li class="page-item">
                <a class="page-link" href="index.php?page=history&user_access='.$uid.'&p='.$end_page.'" tabindex="-1" aria-disabled="true">»</a>
            </li>';
        }
            
        $content .= '</ul></nav>';
    }
    
    return $content;
}

function gallery_index() {
    global $uid;

    $content = '<h1 class="postname">Bộ sưu tập</h1>';

    $page   = isset($_GET['p']) ? abs(intval($_GET['p'])) : 1;
    $offset = $page>1 ? ($page-1)*24 : 0;

    $story_follow = story_follow_24($uid, $offset);
    $total        = story_follow_total_by_uid($uid);
    $content .= 
    '<div class="mb-2" style="color:#fff">Bạn đã theo dõi <b>'.number_format($total).'</b> truyện</div>
    <div class="row">';

    if(!$total) {
        $content .= '<div class="mt-2 col-12">Bạn chưa theo dõi truyện nào.</div>';
    } else {
        foreach($story_follow as $gett) {
            $get = stories_by_id($gett['story_id']);
            if (!$get['duyet']) {
                // $total--;
                continue;
            }
            $checkRead = history_total_story_id_chapter_id($uid, $get['id'], $get['chapter_id']);
            $content .= 
            '<div class="col-md-6" id="story_'.$get['id'].'">
                <div class="flexRow py-3" style="border-bottom: 1px solid #eee;color:#fff">
                    <div style="width: 150px; height: 250px;">
                        <img src="/assets/hentai/'.$get['thumb'].'.jpg" width="150px" height="250px" alt="" />
                    </div>
                    <div class="ml-3" style="flex: 1">
                        <span class="text-large"><a href="/story/view.php?id='.$get['id'].'">'.sanitize_xss($get['name']).'</a></span><br/>
                        '.($get['duyet'] ? ($get['status'] ? '<font color=green><i class="fal fa-check fa-fw"></i>Đã hoàn thành</font>' : '<font color=blue><i class="fal fa-clock fa-fw"></i> Chưa hoàn thành</font>') : '<font color=gray>...chờ duyệt</font>').'<br/>
                        Chap mới nhất: <b>'.sanitize_xss(character_by_id($get['chapter_id'])['name']).'</b><br/>
                        '.($checkRead ? '<span class="badge badge-success">Đã đọc</span>' : '<span class="badge badge-danger">Chưa đọc</span>').'
                    </div>
                </div>
            </div>';
        }
    }

    $content .= '</div>';

    if($total > 24) {
        $content .= 
        '<nav aria-label="Page navigation example mt-2">
            <ul class="pagination justify-content-center mt-4">';

        $dem      = 0;
        $pageI    = $page > 4 ? $page-3 : 1;
        $end_page = ceil($total/24);
        if($end_page > 4) {
            if($page == $end_page-3) $pageI = $page-3;
            if($page == $end_page-2) $pageI = $page-4;
            if($page == $end_page-1) $pageI = $page-5;
            if($page == $end_page-0) $pageI = $page-6;
        }
		if($pageI < 1) $pageI = 1;
        if($page > 1) {
            $content .= 
            '<li class="page-item">
                <a class="page-link" href="index.php?page=gallery&user_access='.$uid.'&p=1" tabindex="-1" aria-disabled="true">«</a>
            </li>';
        }
            
        for($i = $pageI; $i <= $end_page; $i++)
        {
            $content .= '<li class="page-item'.($i === $page ? ' active' : '').'"><a class="page-link" href="index.php?page=gallery&user_access='.$uid.'&p='.$i.'" '.($i === $page ? 'aria-current="page"' : '').'>'.$i.' '.($i === $page ? ' <span class="sr-only">(current)</span>' : '').'</a></li>';
            if(++$dem === 7)    break;
        }
        if($page < $end_page) {
            $content .= 
            '<li class="page-item">
                <a class="page-link" href="index.php?page=gallery&user_access='.$uid.'&p='.$end_page.'" tabindex="-1" aria-disabled="true">»</a>
            </li>';
        }
            
        $content .= '</ul></nav>';
    }
    
    return $content;
}
/*
function gallery_index() {
    global $uid;

    $content = '<h1 class="postname">Bộ sưu tập</h1>';

    $page   = isset($_GET['p']) ? abs(intval($_GET['p'])) : 1;
    $offset = $page>1 ? ($page-1)*24 : 0;

    $story_follow = story_follow_nopage($uid);
    $content .= 
    '<div class="mb-2" style="color:#fff">Bạn đã theo dõi <b>'.number_format(count($story_follow)).'</b> truyện</div>
    <div class="row">';

    if(!$story_follow) {
        $content .= '<div class="mt-2 col-12">Bạn chưa theo dõi truyện nào.</div>';
    } else {
        foreach($story_follow as $get) {
            // $get = stories_by_id($gett['story_id']);
            // if (!$get['duyet']) {
            //     // $total--;
            //     continue;
            // }
            $checkRead = history_total_story_id_chapter_id($uid, $get['id'], $get['chapter_id']);
            $content .= 
            '<div class="col-md-6" id="story_'.$get['id'].'">
                <div class="flexRow py-3" style="border-bottom: 1px solid #eee;color:#fff">
                    <div style="width: 150px; height: 250px;">
                        <img src="/assets/hentai/'.$get['thumb'].'.jpg" width="150px" height="250px" alt="" />
                    </div>
                    <div class="ml-3" style="flex: 1">
                        <span class="text-large"><a href="/story/view.php?id='.$get['id'].'">'.$get['name'].'</a></span><br/>
                        '.($get['duyet'] ? ($get['status'] ? '<font color=green><i class="fal fa-check fa-fw"></i>Đã hoàn thành</font>' : '<font color=blue><i class="fal fa-clock fa-fw"></i> Chưa hoàn thành</font>') : '<font color=gray>...chờ duyệt</font>').'<br/>
                        Chap mới nhất: <b>'.character_by_id($get['chapter_id'])['name'].'</b><br/>
                        '.($checkRead ? '<span class="badge badge-success">Đã đọc</span>' : '<span class="badge badge-danger">Chưa đọc</span>').'
                    </div>
                </div>
            </div>';
        }
    }

    $content .= '</div>';
    
    return $content;
}
*/
function information_index() {
    global $my, $conn, $rights, $uid;

    $content = '<h1 class="postname">Thông tin tài khoản</h1>';
    if(isset($_POST['save']) && $rights === 'admin') {        
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $rights = mysqli_real_escape_string($conn, $_POST['rights']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $uid = (int)$uid;
        $result = mysqli_query($conn, 'update users set email = "'.$email.'", username = "'.$username.'", rights = "'.$rights.'" where id = '.$uid);
        cache_delete('users');
        if ($result) {
            $my['rights']   = $rights;
            $my['username'] = $username;
            $my['email']    = $email;
            $content .= '<div class="alert alert-success">Thay đổi lưu !</div>';
        } else {
            $content .= '<div class="alert alert-success">Lưu thông tin không thành công :(</div>';
        }        
    }

    if(isset($_POST['changeAvatar']) && isset($_FILES['avatar'])) {
        $file_name  = $_FILES['avatar']['name'];            
        if ($file_name) {
            $file_tmp   = $_FILES['avatar']['tmp_name'];            
            $file_ext   = @strtolower(end(explode('.',$file_name)));
            if(!in_array($file_ext,["jpeg","jpg","png","gif"])){
                $content .= '<div class="alert alert-danger">Chỉ hỗ trợ upload file JPEG, GIF hoặc PNG !</div>';
            } else {
                $image = new SimpleImage();
                $image->load($file_tmp);
                $image->resize(100, 100);
                $image->save(ROOT.'/assets/avatar/'.$uid.'.jpg');
                $content .= '<div class="alert alert-success">Tải lên thành công !</div>';
            }
        }        
    }
    return $content . 
    '<div>
        <form method="post">
        <div class="form-group">
            <label>Tên đăng nhập</label>
            <input required type="text" class="form-control" '.($rights === 'admin' ? '' : 'disabled').' name="username" value="'.sanitize_xss($my['username']).'">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input required type="email" class="form-control" '.($rights === 'admin' ? '' : 'disabled').'  name="email" value="'.sanitize_xss($my['email']).'">
        </div>
        '.($rights === 'admin' ? '
        <div class="form-group">
            <label>Chức vụ</label>
            <select class="form-control" name="rights">
                <option value="">Member</option>
                <option value="admin" '.($my['rights'] === 'admin' ? 'selected' : '').'>Admin</option>
            </select>
        </div>
        <button class="btn btn-primary mb-3" type="submit" name="save">Lưu lại</button>' : ''
        ).'
        </form>
        <h1 class="postname">Thay Avatar</h1>
        <div>
            <img src="/assets/images/avatar.php?id='.$uid.'">
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="avatar" class="form-control mt-2" accept="image/*" style="max-width: 500px;">
                <button class="btn btn-success mt-2" type="submit" name="changeAvatar">Upload</button>
            </form>
        </div>
        <h1 class="postname mt-3">Thống Kê Hoạt Động</h1>
        <div style="color: #fff">Truyện đã đăng: <b>'. number_format(stories_uid_total($uid)) .'</b></div>
        <div style="color: #fff">Chapter đã đăng: <b>'. number_format(chapters_uid_total($uid)) .'</b></div>
        <div style="color: #fff">Comment đã đăng: <b>'. number_format(comment_uid_total($uid)) .'</b></div>
    </div>';
}

function upload_do_index($title) {
    global $uid;

    $content = '<h1 class="postname">'.$title.'</h1>';

    $page   = isset($_GET['p']) ? abs(intval($_GET['p'])) : 1;
    $offset = $page>1 ? ($page-1)*30 : 0;

    $stories = stories_uid_30($uid, $offset);
    $total = stories_uid_total($uid);

    $content .= 
    '<div class="mb-2" style="color:#fff">Bạn đã upload <b>'.number_format($total).'</b> truyện</div>
    <a href="index.php?page=uploaded&user_access='.$uid.'&do=upload" class="btn btn-info"><i class="fa fa-upload fa-fw"></i> Upload truyện mới</a>
    <div class="row">';

    if(!$total) {
        $content .= '<div class="mt-2 col-12">Bạn chưa upload truyện nào.</div>';
    } else {
        foreach($stories as $get) {
            $theloai = '';
            foreach(story_categories_by_story_id($get['id']) as $tll) {
                $theloai .= '<a href="/story/cat.php?id='.$tll['category_id'].'">'.sanitize_xss(categories_by_id($tll['category_id'])['name']).'</a>, ';
            }

            $content .= 
            '<div class="col-md-6" id="story_'.$get['id'].'">
                <div class="flexRow py-3" style="border-bottom: 1px solid #eee">
                    <div style="width: 150px; height: 250px;">
                        <img src="/assets/hentai/'.$get['thumb'].'.jpg" width="150px" height="250px" alt="" />
                    </div>
                    <div class="ml-3" style="flex:1;color:#fff">
                        <span class="text-large"><a href="/story/view.php?id='.$get['id'].'">'.sanitize_xss($get['name']).'</a></span><br/>
                        '.($get['duyet'] ? ($get['status'] ? '<font color=green><i class="fal fa-check fa-fw"></i>Đã hoàn thành</font>' : '<font color=blue><i class="fal fa-clock fa-fw"></i> Chưa hoàn thành</font>') : '<font color=gray>...chờ duyệt</font>').'<br/>
                        Lượt xem: <b>'.number_format($get['view']).'</b><br/>
                        Thể loại: '.$theloai.'
                        <div class="mt-2">
                            <a class="btn btn-warning" href="index.php?page=uploaded&do=setting&user_access='.$uid.'&id='.$get['id'].'"><i class="fa fa-cog fa-fw"></i></a>
                            <a href="index.php?user_access='.$uid.'&page=uploaded&do=list&id='.$get['id'].'" class="btn btn-primary"><i class="fa fa-list fa-fw"></i></a>
                            <button class="btn btn-danger" onclick="user_delete_story('.$get['id'].')"><i class="fa fa-trash fa-fw"></i></button>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }

    $content .= '</div>';

    if($total > 30) {
        $content .= 
        '<nav aria-label="Page navigation example mt-2">
            <ul class="pagination justify-content-center mt-4">';
        $dem      = 0;
        $pageI    = $page > 4 ? $page-3 : 1;
        $end_page = ceil($total/30);
        if($end_page > 4) {
            if($page == $end_page-3) $pageI = $page-3;
            if($page == $end_page-2) $pageI = $page-4;
            if($page == $end_page-1) $pageI = $page-5;
            if($page == $end_page-0) $pageI = $page-6;
        }
        if($pageI < 1) $pageI = 1;
        if($page > 1) {
            $content .= 
            '<li class="page-item">
                <a class="page-link" href="index.php?page=uploaded&user_access='.$uid.'&p=1" tabindex="-1" aria-disabled="true">«</a>
            </li>';
        }
            
        for($i = $pageI; $i <= $end_page; $i++) {
            $content .= '<li class="page-item'.($i === $page ? ' active' : '').'"><a class="page-link" href="index.php?page=uploaded&user_access='.$uid.'&p='.$i.'" '.($i === $page ? 'aria-current="page"' : '').'>'.$i.' '.($i === $page ? ' <span class="sr-only">(current)</span>' : '').'</a></li>';
            if(++$dem === 7)    break;
        }
        if($page < $end_page) {
            $content .= '<li class="page-item">
                <a class="page-link" href="index.php?page=uploaded&user_access='.$uid.'&p='.$end_page.'" tabindex="-1" aria-disabled="true">»</a>
            </li>';
        }
            
        $content .= '</ul></nav>';
    }

    return $content;
}

function upload_upload_index($title) {
    global $conn, $rights, $uid;
    
    $content = '<h1 class="postname">'.$title.'</h1>';
    if(isset($_POST['submit'])) {        
        $name    = trim($_POST['name']??'');
        $authors = trim($_POST['authors']??'');
        $intro   = trim($_POST['intro']??'');
        $status  = $_POST['status'] ? 1 : 0;
        if(isset($_FILES['avatar']) && $file_name = $_FILES['avatar']['name']) {            
            $file_tmp  = $_FILES['avatar']['tmp_name'];
            $file_ext  = @strtolower(end(explode('.',$file_name)));
            if(!in_array($file_ext,["jpeg","jpg","png","gif"])) {
                $content .= '<div class="alert alert-danger">Ảnh thumb không hợp lệ !<br>Chỉ hỗ trợ upload file JPEG, GIF hoặc PNG.</div>';
            } else {
                $image = new SimpleImage();
                $image->load($file_tmp);
                $image->resize(250, 350);
                $imgName = time().rand(1,1000);
                $image->save(ROOT.'/assets/hentai/'.$imgName.'.jpg');
                $duyet = $rights === 'admin' ? 1 : 0;

                $name = mysqli_real_escape_string($conn, $name);
                $authors = mysqli_real_escape_string($conn, $authors);
                $intro = mysqli_real_escape_string($conn, $intro);
                $uid = (int)$uid;
                $doujinshi = mysqli_real_escape_string($conn, $_POST['doujinshi']);
                $thuchien = mysqli_real_escape_string($conn, $_POST['thuchien']);
                $nhomdich = mysqli_real_escape_string($conn, $_POST['nhomdich']);

                $query = 'insert into stories (name, authors, intro, time, user_id, thumb, duyet, doujinshi, thuchien, nhomdich, status, view, chapter_id, hot) 
                values ("'.$name.'", "'.$authors.'", "'.$intro.'", '.time().', '.$uid.', "'.$imgName.'", '.$duyet.', "'.$doujinshi.'", "'.$thuchien.'", "'.$nhomdich.'", '.$status.', 0, 0, 0)';     

                $result = mysqli_query($conn, $query);
                cache_delete('stories');          
                if ($result) {
                    $sid = (int)mysqli_insert_id($conn);
                    if ($sid) {
                        foreach($_POST['theloai'] as $value) {
                            $value = mysqli_real_escape_string($conn, $value);
                            $query = 'insert into story_categories (story_id, category_id, lastupdate) values ('.$sid.', '.$value.', '.time().')';
                            $result = mysqli_query($conn, $query);
                            cache_delete('story_categories'); 
                        } 
                    }
                    
                }
                                            
                redirect("index.php?user_access={$uid}&page=uploaded&do=list&id={$sid}");
            }
        }
    }

    $categories = '';
    foreach(get_categories() as $get)
    {
        $categories .= 
        '<div class="col-6 col-md-3">
            <input type="checkbox" name="theloai[]" value="'.$get['id'].'" id="check'.$get['id'].'" '.($_POST['theloai'] ? in_array($get['id'], $_POST['theloai']) ? 'checked' : '' : '').'> <label for="check'.$get['id'].'">'.sanitize_xss($get['name']).'</label>
        </div>';
    }

    return $content . 
    '<form method="post" enctype="multipart/form-data" id="postTruyen" class="dropzone" autocomplete="off">
    <div class="form-group">
        <label><b>Tên truyện</b></label>
        <input class="form-control" required type="text" maxlength="1000" name="name" value="'.sanitize_xss($_POST['name']).'">
        <div class="checkTrung">
            <h5>KHÁ GIỐNG VỚI: </h5>
            <div id="listTrungTruyen">đang chờ nhập...</div>
        </div>
    </div>
    <div class="form-group">
        <label><b>Tác giả</b></label>
        <input class="form-control" required name="authors" maxlength="350" type="text" placeholder="cách nhau bằng dấu phẩy" value="'.
        sanitize_xss($_POST['authors']).'">
        <div class="checkTrung">
            <h5>KHÁ GIỐNG VỚI: </h5>
            <div id="listTrungTacGia">đang chờ nhập...</div>
        </div>
    </div>
    <div class="form-group">
        <label><b>Doujinshi</b> (không bắt buộc)</label>
        <input class="form-control" name="doujinshi" type="text" maxlength="350" placeholder="cách nhau bằng dấu phẩy" value="'.
        sanitize_xss($_POST['doujinshi']).'">
        <div class="checkTrung">
            <h5>KHÁ GIỐNG VỚI: </h5>
            <div id="listTrungDoujinshi">đang chờ nhập...</div>
        </div>
    </div>
    <h4 style="color: #fff">Thể loại</h4>
    <div class="row">'.$categories.'</div>
    <div class="form-group mt-2">
        <label><b>Mô tả truyện</b></label>
        <textarea class="form-control" name="intro" required style="min-height: 200px;">'.sanitize_xss($_POST['intro']).'</textarea>
    </div>
    <div class="form-group">
        <label><b>Ảnh đại diện</b></label>
        <input accept="image/*" type="file" required name="avatar" />
    </div>
    <div class="form-group">
        <label><b>Thực hiện bởi</b> (không bắt buộc)</label>
        <input class="form-control" name="thuchien" type="text" maxlength="350" value="'.sanitize_xss($_POST['thuchien']).'">
    </div>
    <div class="form-group">
        <label><b>Nhóm dịch</b> (không bắt buộc)</label>
        <input class="form-control" name="nhomdich" type="text" maxlength="350" value="'.sanitize_xss($_POST['nhomdich']).'">
        <div class="checkTrung">
            <h5>KHÁ GIỐNG VỚI: </h5>
            <div id="listTrungNhomDich">đang chờ nhập...</div>
        </div>
    </div>
    <div class="form-group">
        <label>Trạng thái</label>
        <select class="form-control" name="status">
            <option value="0">Chưa hoàn thành</option>
            <option value="1" '.($status ? 'selected' : '').'>Đã hoàn thành</option>
        </select>
    </div>
    <button type="submit" name="submit" class="btn-lg btn btn-success">Upload</button> <a class="ml-2 btn-lg btn btn-danger" href="index.php?page=uploaded&user_access='.$uid.'">Quay lại</a><br/><br/>
        <span style="color: #fff">Truyện sẽ được ADMIN kiểm duyệt trước khi đăng !</span>
    </form>
    ';
}

function upload_setting_index($title) {
    global $rights, $conn, $uid;

    $id = intval($_GET['id']);
    $get = stories_by_id($id);
    if(!$get) {
        redirect('/');
    }
    $content = '<h1 class="postname">'.$title.'</h1>';

    if(isset($_POST['submit'])) {            
        $hot = $_POST['hot'] ? time() : 0;
        $doujinshi = mysqli_real_escape_string($conn, $_POST['doujinshi']);
        $thuchien = mysqli_real_escape_string($conn, $_POST['thuchien']);
        $nhomdich = mysqli_real_escape_string($conn, $_POST['nhomdich']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $authors = mysqli_real_escape_string($conn, $_POST['authors']);
        $intro = mysqli_real_escape_string($conn, $_POST['intro']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        mysqli_query($conn, 'update stories set hot = '.$hot.', doujinshi="'.$doujinshi.'", thuchien = "'.$thuchien.'", nhomdich = "'.$nhomdich.'", name = "'.$name.'", intro = "'.$intro.'", status = "'.$status.'", authors = "'.$authors.'" where id = '.$id);
        cache_delete('stories');
        mysqli_query($conn, 'delete from story_categories where story_id = '.$id);
        cache_delete('story_categories');
        
        array_unique($_POST['theloai']);
        foreach($_POST['theloai'] as $value) {
            $value = mysqli_real_escape_string($conn, $value);
            $query = 'insert into story_categories (story_id, category_id, lastupdate) values ('.$id.', '.$value.', '.time().')';
            $result = mysqli_query($conn, $query);
            cache_delete('story_categories'); 
        }
        if(isset($_FILES['avatar']) && $file_name = $_FILES['avatar']['name']) {            
            $file_ext  = @strtolower(end(explode('.',$file_name)));
            if(!in_array($file_ext, ["jpeg","jpg","png","gif"])){
                $content .= '<div class="alert alert-danger">Chỉ hỗ trợ upload file JPEG, GIF hoặc PNG !</div>';
            } else {
                $image = new SimpleImage();
                $image->load($_FILES['avatar']['tmp_name']);
                $image->resize(250, 350);
                $imgName = time().rand(1,1000);
                $image->save(ROOT.'/assets/hentai/'.$get['thumb'].'.jpg');
            }
        }
        $content .= '<div class="alert alert-success">Cập nhật thành công !</div>';
        $_POST = [];
    }

    if(!is_array($_POST['theloai'])) {
        $_POST['theloai'] = [];
        foreach(story_categories_by_story_id($id) as $get) {
            array_push($_POST['theloai'], $get['category_id']);
        }
    }

    $categories = '';        
    foreach(get_categories() as $get) {
        $categories .= 
        '<div class="col-6 col-md-3">
            <input type="checkbox" name="theloai[]" value="'.$get['id'].'" id="check'.$get['id'].'" '.($_POST['theloai'] ? in_array($get['id'], $_POST['theloai']) ? 'checked' : '' : '').'> <label for="check'.$get['id'].'">'.sanitize_xss($get['name']).'</label>
        </div>';
    }
    $get = stories_by_id($id);
    $content .= 
    '<form method="post" enctype="multipart/form-data"  autocomplete="off">
        <div class="form-group">
            <label><b>Tên truyện</b></label>
            <input class="form-control" required type="text" maxlength="1000" name="name" value="'.sanitize_xss($_POST['name'] ?: $get['name']).'">
            <div class="checkTrung">
                <h5>KHÁ GIỐNG VỚI: </h5>
                <div id="listTrungTruyen">đang chờ nhập...</div>
            </div>
        </div>

        <div class="form-group">
            <label><b>Tác giả</b></label>
            <input class="form-control" required name="authors" type="text" placeholder="cách nhau bằng dấu phẩy" value="'.sanitize_xss($_POST['authors'] ?: $get['authors']).'">
            <div class="checkTrung" id="checkTrungTacGia">
                <h5>KHÁ GIỐNG VỚI: </h5>
                <div id="listTrungTacGia">đang chờ nhập...</div>
            </div>
        </div>
        <div class="form-group">
            <label><b>Doujinshi</b> (không bắt buộc)</label>
            <input class="form-control" name="doujinshi" type="text" maxlength="350" placeholder="cách nhau bằng dấu phẩy" value="'.sanitize_xss($_POST['doujinshi'] ?: $get['doujinshi']).'">
            <div class="checkTrung">
                <h5>KHÁ GIỐNG VỚI: </h5>
                <div id="listTrungDoujinshi">đang chờ nhập...</div>
            </div>
        </div>
        <h4 style="color: #fff">Thể loại</h4>
        <div class="row">'.$categories.'</div>
        <div class="form-group mt-2">
            <label><b>Mô tả truyện</b></label>
            <textarea class="form-control" name="intro" required style="min-height: 200px;">'.sanitize_xss($_POST['intro'] ?: $get['intro']).'</textarea>
        </div>
        <div class="form-group">
            <div class="flexRow">
                <div>
                    <img src="/assets/hentai/'.$get['thumb'].'.jpg?cache='.rand(1,10000).'" height="200px" width="150px">
                </div>
                <div class="pl-2" style="color: #fff">
                    <input accept="image/*" type="file" name="avatar" class="my-2" /><br/>
                    Bỏ trống nếu không đổi Thumb.<br/>
                    (*) Thumbnail có thể cập nhật chậm.';
			
    if($rights === 'admin') {
        $content .= '<div class="mt-2"><input type="checkbox" name="hot" value="1" id="hot" '.($get['hot'] ? 'checked' : '').'><label for="hot"> <b style="font-size: large;" class="ml-2">THÊM VÀO LIST TRUYỆN HOT</b></label></div>';
    }
        
    
    $content .= '</div>
            </div>
        </div>
        <div class="form-group">
            <label><b>Thực hiện bởi</b> (không bắt buộc)</label>
            <input class="form-control" name="thuchien" type="text" maxlength="350" value="'.sanitize_xss($_POST['thuchien'] ?: $get['thuchien']).'">
        </div>
        <div class="form-group">
            <label><b>Nhóm dịch</b> (không bắt buộc)</label>
            <input class="form-control" name="nhomdich" type="text" maxlength="350" value="'.sanitize_xss($_POST['nhomdich'] ?: $get['nhomdich']).'">
            <div class="checkTrung">
                <h5>KHÁ GIỐNG VỚI: </h5>
                <div id="listTrungNhomDich">đang chờ nhập...</div>
            </div>
        </div>
        <div class="form-group">
            <label>Trạng thái</label>
            <select class="form-control" name="status">
                <option value="0">Chưa hoàn thành</option>
                <option value="1" '.($get['status'] ? 'selected' : '').'>Đã hoàn thành</option>
            </select>
        </div>
        <button type="submit" name="submit" class="btn-lg btn btn-success">Cập nhật</button> <a class="ml-2 btn-lg btn btn-danger" href="index.php?page=uploaded&user_access='.$uid.'">Quay lại</a><br/><br/>
    </form>';
    
return $content;        
}

function upload_list_index() {
    global $conn, $uid, $rights;
    
    $id = intval($_GET['id']);
    $get = stories_by_id($id);
    if(!$get || ($get['user_id'] != $uid && $rights != 'admin')) {
        redirect('/');
    }
    $content = 
    '<h1 class="postname">'.sanitize_xss($get['name']).'</h1>
    <a href="index.php?user_access='.$uid.'&page=uploaded&do=addChapter&id='.$id.'" class="btn btn-info"><i class="fa fa-plus fa-fw"></i> Thêm chương mới</button> <a class="ml-2 btn btn-warning" href="index.php?page=uploaded&do=setting&user_access='.$uid.'&id='.$id.'"><i class="fa fa-cog fa-fw"></i></a> <a href="javascript:window.history.back();"> « Quay lại</a>
    ';

    if(isset($_GET['delete'])) {
        $getChapter = query_mysql('select name, id from chapters where story_id = '.$id.' and id = '.intval($_GET['delete']), true);
        if($getChapter) {
            mysqli_query($conn, 'delete from chapters where story_id = '.$id.' and id = '.intval($_GET['delete']));
            cache_delete('chapters');
            $content .= '<div class="alert alert-success mt-3">Xóa <b>'.sanitize_xss($getChapter['name']).'</b> thành công !</div>';
        }
    }
		
    if(isset($_GET['deleteImg'])) {
        $getChapter = query_mysql('select html, name from chapters where story_id = '.$id.' and id = '.intval($_GET['deleteImg']), true);
        if($getChapter) {
            preg_match_all('/\/assets\/read\/(.*.jpg)/imU', $getChapter['html'], $match);
            $imgLocal = $match[1];
            foreach($imgLocal as $value) { 
                unlink(ROOT.'/assets/read/'.$value);
            }
            $content .= '<div class="alert alert-success mt-3">Xóa <b>'.count($imgLocal).'</b> ảnh của <b>'.sanitize_xss($getChapter['name']).'</b> thành công !</div>';
        }
    }

    $content .= '<div class="mt-3">';
    foreach(character_by_story_id($id) as $get) {
        $content .= 
        '<div class="row" style="border-bottom: 1px solid #eee">
            <div class="col-md-8">
                <a href="/story/chapter.php?id='.$get['id'].'" class="text-large">• '.sanitize_xss($get['name']).'</a>
            </div>
            <div class="col-md-4 text-right py-2" style="color:#fff">
                Xem: <b>'.$get['view'].'</b> '.
                ($rights === 'admin' ? '<a href="index.php?page=uploaded&user_access='.$uid.'&do=editChapter&id='.$get['id'].'" style="color:yellow">[SỬA]</a> 
                <a href="index.php?page=uploaded&user_access='.$uid.'&do=list&id='.$id.'&deleteImg='.$get['id'].'" style="color:blue">[Xóa Ảnh Upload]</a> 
                <a href="index.php?page=uploaded&user_access='.$uid.'&do=list&id='.$id.'&delete='.$get['id'].'" style="color: red">[XÓA]</a>' : '').'
            </div>
        </div>';
    }

    return $content . '</div>';
}

function upload_edit_chapter_index() {
    global $conn, $uid, $rights;

    $id       = intval($_GET['id']);
    $get      = character_by_id($id);
    $getStory = stories_by_id($get['story_id']);
    
    $content = '<h1 class="postname">'.sanitize_xss($getStory['name']).': '.sanitize_xss($get['name']).'</h1>';
    
    if(!$get || ($get['user_id'] != $uid && $rights != 'admin') ) {
        redirect('/');            
    }

    if(isset($_POST['submit'])) {
        $download = mysqli_real_escape_string($conn, $_POST['download']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $stt = mysqli_real_escape_string($conn, $_POST['stt']);
        $html = mysqli_real_escape_string($conn, $_POST['html']);

        mysqli_query($conn, 'update chapters set download="'.$download.'", time_update = '.time().', name = "'.$name.'", stt = "'.$stt.'", html = "'.$html.'" where id = '.$id);
        cache_delete('chapters');
        redirect("index.php?user_access={$uid}&page=uploaded&do=list&id={$get['story_id']}");
    }

    return $content . 
    '<form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label><b>Số thứ tự</b></label>
            <input type="number" required name="stt" class="form-control" placeholder="cần để sắp xếp vị trí" value="'.($_POST['stt'] ?: $get['stt']).'">
        </div>
        <div class="form-group">
            <label><b>Tiêu đề</b></label>
            <input type="text" name="name" class="form-control" placeholder="VD: Chap 17.3: tên chap" value="'.sanitize_xss($_POST['name'] ?: $get['name']).'">
        </div>
        <div class="form-group" style="color: #fff">
            <label><b>Content</b></label>
            Copy ảnh truyện (không phải link) rồi paste xuống dưới (có thể copy nhiều bằng cách giữ shift hoặc ctrl)
		<div class="mt-2"></div>
			<textarea name="html" id="editor">'.(($_POST['html'] ?: $get['html'])).'</textarea>
        </div>
        <div class="form-group">
        <label><b>Link download</b> (không bắt buộc)</label>
		'.sanitize_xss($get['download']).'
        <input type="text" name="download" class="form-control" placeholder="Thuận tiện cho việc reup." value="'.sanitize_xss($_POST['download'] ?: $get['download']).'">
        </div>
        <button class="btn btn-lg btn-success my-2" type="submit" name="submit">Cập nhật</button>
        <a href="index.php?page=uploaded&user_access='.$uid.'&do=list&id='.$get['story_id'].'" class="btn btn-lg btn-danger my-2">Quay lại</a>
    </form>';
}

function upload_add_chapter_index($id) {
    global $uid, $rights, $conn, $redis;

    $keyRedis = "sess:html:{$uid}:{$id}";
    $setRedis = static function ($html) use($redis, $keyRedis) {
        $redis->setex($keyRedis, 1800, $html);
    };
    $getRedis = static function() use($redis, $keyRedis) {
        return $redis->get($keyRedis);
    };    

    $id = (int)$id;
    $get = stories_by_id($id);
    if(!$get && $get['user_id'] != $uid && $rights != 'admin') {
        redirect('/');
    }
    
    $content = '<h1 class="postname">'.sanitize_xss($get['name']).'</h1>';
    if(isset($_POST['submit']) || isset($_GET['upload_ajax'])) {

        if(isset($_POST['submit']) && !$_POST['html']) {
            $_POST['html'] = $getRedis();
        }
            
        if(trim($_POST['html'])) {
            $html = mysqli_real_escape_string($conn, $_POST['html']);
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $download = mysqli_real_escape_string($conn, $_POST['download']);
            $stt = (int)mysqli_real_escape_string($conn, $_POST['stt']);
            $result = $query = 'insert into chapters (name, stt, user_id, html, time, story_id, download, view, time_update) 
            values ("'.$name.'", '.$stt.', '.$uid.', "'.$html.'", '.time().', '.$id.', "'.$download.'", 0, 0)';
            mysqli_query($conn, $query) or die('error');
            cache_delete('chapters'); 
            
            $nid = (int)mysqli_insert_id($conn);
            $userFollow = story_follow_by_story_follow($id);
            if ($nid && $userFollow) {
                foreach($userFollow as $getUF) {
                    $html = '<a href="/story/chapter.php?id='.$nid.'">Truyện <b>'.$get['name'].'</b> đã thêm chương <b>'.$_POST['name'].'</b> !</a>';
                    $html = mysqli_real_escape_string($conn, $html);
                    mysqli_query($conn, 'insert into alert set user_id = "'.intval($getUF['user_id']).'", text = "'.$html.'", time = "'.time().'"');
                    cache_delete('alert'); 
                }
            }            
            mysqli_query($conn, 'update story_categories set lastupdate = '.time().' where story_id = '.$id);
            cache_delete('story_categories');
            mysqli_query($conn, 'update stories set chapter_id = '.$nid.', time = '.time().' where id = '.$id);
            cache_delete('stories');
            $_POST = [];
            $setRedis('');
            
            redirect("index.php?page=uploaded&user_access={$uid}&do=list&id={$id}");
        } else {
            $file_page = $_FILES['page'];
            if(isset($file_page)) {
                $imgName = time().rand(1,1000);
                $errors  = [];
                $len = count($file_page['name']);
                for($key = 0; $key < $len; $key++) {
                    $file_tmp = $file_page['tmp_name'][$key];
                    $file_ext = @strtolower(end(explode('.',$file_page['name'][$key])));
                    if(!in_array($file_ext, ["jpeg","jpg","png","gif"])){
                        $errors[]="<b>Trang '.$key.': </b> Chỉ hỗ trợ upload file JPEG, GIF hoặc PNG.";
                    }                    
                    if($file_page['size'][$key] > 2098000) { 
                        $errors[]="<b>Trang '.$key.': </b> Chỉ hỗ trợ upload file JPEG, GIF hoặc PNG dưới 2Mb.";
                    }                    
                }

                if($errors) {
                    $content .= '<div class="alert alert-danger">';
                    foreach($errors as $value) {
                        $content .= '<div>'.$value.'</div>';
                    }
                    $content .= '</div>';
                } else {
                    $html = '';
                    for($key = 0; $key < $len; $key++) {
                        $file_tmp = $file_page['tmp_name'][$key];
                        $image = new SimpleImage();
                        $image->load($file_tmp);
                        $image->save(ROOT.'/assets/read/'.$imgName.'_'.$key.'.jpg');
                        $html .= '<div><img src="//lxhentai.com/assets/read/'.$imgName.'_'.$key.'.jpg" alt="Bạn đang xem truyện tại Hentailxx.com" /></div>';
                    }
                    
                    $setRedis($getRedis() . $html);                    
                    exitx();
                }
            } else {
                $content .= '<div class="alert alert-danger">Bạn chưa upload trang nào !</div>';                
            }
        }
    }
		
    $setRedis('');
		
    if(isset($_POST['html'])) {
        $content .= '<script>$(function(){ admin_switch_post(); });</script>';
    }

    return $content . 
    '<form method="post">
        <div class="form-group">
            <label><b>Số thứ tự</b></label>
            <input type="number" required name="stt" class="form-control" placeholder="cần để sắp xếp vị trí" value="'.($_POST['stt'] ?: '').'">
        </div>
        <div class="form-group">
            <label><b>Tiêu đề</b></label>
            <input type="text" name="name" class="form-control" placeholder="VD: Chap 17.3: tên chap" value="'.sanitize_xss($_POST['name'] ?: '').'">
        </div>
        <div class="form-group">
            <label><b>Link download</b> (không bắt buộc)</label>
            <input type="text" name="download" class="form-control" placeholder="Thuận tiện cho việc reup.">
        </div>
        '.($rights === 'admin' ? '				
        <div class="my-2">
            <a href="javascript:admin_switch_post()">ADMIN: Sử dụng HTML / Upload</a>
        </div>

        <div class="mb-2" id="htmlMode" style="display: none;color:#fff">
            Copy ảnh truyện (không phải link) rồi paste xuống dưới (có thể copy nhiều bằng cách giữ shift hoặc ctrl)
            <div class="mt-2"></div>
			<textarea name="html" id="editor">'.($_POST['html']?:'').'</textarea>
        </div>' : '').'        
        <button type="submit" id="form" name="submit" style="display: none"></button>
    </form>    
    <div id="uploadMode">
        <form class="dropzone"></form>          
    </div>
    <button class="btn btn-lg btn-success my-2" type="submit" name="submit" id="upload">Upload</button>
    <a href="index.php?page=uploaded&user_access='.$uid.'&do=list&id='.$id.'" class="btn btn-lg btn-danger my-2">Quay lại</a>
    <div style="color: #fff">Thời gian Upload phụ thuộc vào số trang và tốc độ mạng của bạn, vui lòng đợi !</div>    
    ';
}