<?php

function default_admin() {
    global $conn;

    $time24 = time()-86400;
    return '<h1 class="postname" style="color: #fff">Thống Kê Dữ Liệu</h1>
    <div class="row">
    <div class="col-3"></div>
    <div class="col-5" style="color: #fff"><b>TỔNG SỐ</b></div>
    <div class="col-4" style="color: #fff"><b>24H QUA</b></div>
    
    <div class="col-3 py-3 text-large mt-2" style="color: #fff"><i class="fa fa-users fa-fw"></i> Users</div>
    <div class="col-5 py-3 text-large totalAna mt-2">'.number_format(users_total_admin()).'</div>
    <div class="col-4 py-3 text-large in24hrs mt-2">+ '.number_format(users_total_24_admin($time24)).'</div>
    
    <div class="col-3 py-3 text-large mt-2" style="color: #fff"><i class="fa fa-book fa-fw"></i> Truyện</div>
    <div class="col-5 py-3 text-large totalAna mt-2">'.number_format(stories_total_admin()).'</div>
    <div class="col-4 py-3 text-large in24hrs mt-2">+ '.number_format(stories_total_24_admin($time24)).'</div>
    
    <div class="col-3 py-3 text-large mt-2" style="color: #fff"><i class="fa fa-list fa-fw"></i> Chương</div>
    <div class="col-5 py-3 text-large totalAna mt-2">'.number_format(chapters_total_admin()).'</div>
    <div class="col-4 py-3 text-large in24hrs mt-2">+ '.number_format(chapters_total_24_admin($time24)).'</div>
    
    <div class="col-3 py-3 text-large mt-2" style="color: #fff"><i class="fa fa-comments fa-fw"></i> Comments</div>
    <div class="col-5 py-3 text-large totalAna mt-2">'.number_format(comment_total_admin()).'</div>
    <div class="col-4 py-3 text-large in24hrs mt-2">+ '.number_format(comment_total_24_admin($time24)).'</div>
    
    </div>';
}

function category_admin() {
    global $conn;

    $content = '<h1 class="postname">Quản lý chuyên mục</h1>';

    if(isset($_GET['newFolder']) && $name = trim($_GET['newFolder'])) {
        $name = mysqli_real_escape_string($conn, $name);
        $check = mysqli_num_rows(mysqli_query($conn, "select id from categories where name = '{$name}'"));
        if(!$check) {
            mysqli_query($conn, "insert into categories set name = '{$name}'");
            cache_delete('categories');
            $content .= '<div class="alert alert-success">Thêm thư mục thành công !</div>';
        }     
    }

    if(isset($_GET['delete']) && $delete = intval($_GET['delete'])) {
        if(mysqli_num_rows(mysqli_query($conn, "select id from categories where id = {$delete}"))) {
            mysqli_query($conn, "delete from story_categories where category_id = {$delete}");
            cache_delete('story_categories');
            mysqli_query($conn, "delete from categories where id = {$delete}");
            cache_delete('categories');
            $content .= '<div class="alert alert-success">Xóa thư mục thành công !</div>';
        }     
    }

    if(isset($_GET['name']) && $name = trim($_GET['name']) && $id = intval($_GET['id'])) {
        if(mysqli_num_rows(mysqli_query($conn, "select id from categories where id = {$id}"))) {
            $name = mysqli_real_escape_string($conn, $name);
            mysqli_query($conn, "update categories set name = '{$name}' where id = {$id}");
            cache_delete('categories');
            $content .= '<div class="alert alert-success">Đổi tên thư mục thành công !</div>';
        }
    }

    $content .= '<button class="btn btn-info mb-2" onclick="add_category()"><i class="fa fa-plus-circle fa-fw"></i> Thêm chuyên mục</button><br />
    Check vào ô muốn hiện ở trang chủ.';

    foreach(get_categories() as $get) {
        $content .= 
        '<div class="row">
            <div class="col-md-8 text-large">
                <a href="/story/cat.php?id='.$get['id'].'"><i class="fa fa-folder"></i> '.sanitize_xss($get['name']).'</a>
            </div>
            <div class="col-md-4">
            <div class="text-right">
                Data: '.number_format( story_categories_by_category_id($get['id']) ).' 
                <input type="checkbox" '.($get['type'] ? 'checked' : '').' onchange="(function(){ $.ajax({ url: \'/dashboard/api.php?act=admin_check_category&id='.$get['id'].'\', success: function(){ toastr[\'success\'](\'Thao tác thành công!\'); } }) })();">
                <button class="btn btn-primary ml-2" title="Sửa" data-toggle="tooltip" data-placement="bottom" onclick="edit_category('.$get['id'].', \''.$get['name'].'\')"><i class="fa fa-edit fa-fw"></i></button>
                <button class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="xóa" onclick="delete_category('.$get['id'].')"><i class="fa fa-trash fa-fw"></i></button>
            </div>
            </div>
        </div>';
    }

    return '<div id="category_panel">'.$content.'</div>';
}

function ads_admin() {    
    $file = ROOT . '/dashboard/script.txt';
    if(isset($_POST['save'])) {
        $fp = @fopen($file, 'w');
        if($fp) {
            fwrite($fp, $_POST['html']);
            $notice = true;
        }
        @fclose($fp);
    }

    $fp = @fopen($file, 'r');
    if($fp)     $script = fread($fp, filesize($file));
    @fclose($fp);

    return 
    '<h1 class="postname">Quản lý quảng cáo</h1>   
     '.($notice ? '<div class="alert alert-success">Cập nhật thành công !</div>' : '').'
     <form method="post">
        <label>Nhập script quảng cáo</label>
        <textarea class="form-control" name="html" placeholder="HTML quảng cáo" style="height: 200px;">'.htmlspecialchars($script).'</textarea>
        <button type="submit" name="save" class="btn btn-success btn-lg mt-2"><i class="fa fa-save"></i> Lưu lại</button>
    </form>';
}

function smileys_admin() {
    global $conn;

    $content = '<h1 class="postname">Biểu cảm</h1>';

    if(isset($_GET['delete']) && $delete = intval($_GET['delete'])) {
        mysqli_query($conn, "delete from smileys where id = {$delete}");
        cache_delete('smileys');
        $content .= '<div class="alert alert-success">Xóa biểu cảm thành công !</div>';
    }

    if(isset($_POST['upload']) && isset($_FILES['avatar'])) {
        $file_name  = $_FILES['avatar']['name'];
        $file_tmp   = $_FILES['avatar']['tmp_name'];
        $file_ext   = @strtolower(end(explode('.',$_FILES['avatar']['name'])));
        if(!in_array($file_ext,['jpeg','jpg','png','gif'])){
            $content .= '<div class="alert alert-danger">Chỉ hỗ trợ upload file JPEG, GIF hoặc PNG !</div>';
        } else {
            move_uploaded_file($file_tmp, ROOT.'/assets/smileys/'.$file_name);
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            mysqli_query($conn, 'insert into smileys (name, link) values ("'.$name.'", "'.$file_name.'")');
            cache_delete('smileys');
            $content .= '<div class="alert alert-success">Tải lên thành công !</div>';
        }
    }
				
    $content .= 
    '<form method="post" action="admin.php?page=smileys" enctype="multipart/form-data">
        <div class="row py-2" style="background: #eee">
            <div class="col-md-6 mt-1">
                <input name="avatar" type="file" class="form-control" accept="image/*" />
            </div>
            <div class="col-md-6 mt-1">
                <div class="flexRow">
                <input class="form-control mr-2" name="name" placeholder="cú pháp" required />
                    <button type="submit" name="upload" class="btn btn-info"><i class="fa fa-plus fa-fw"></i></button>
                </div>
            </div>
        </div>
    </form>
    
    <div id="category_panel" class="mt-2">';

    $smileys = get_smileys();
    if (!$smileys)  $content .= '<div>Dữ liệu trống !</div>';

    foreach($smileys as $got) {
        $content .= 
        '<div class="row">
            <div class="col-10">
                <div class="flexRow">
                    <div><img src="/assets/smileys/'.$got['link'].'" width="70px" /></div><div class="pl-2" style="align-self: center;">
                    Cú pháp:<br/>
                    <b class="text-large">:'.sanitize_xss($got['name']).':</b></div>
                </div>
            </div>
            <div class="col-2 text-right" style="align-self: center;">
                <button onclick="window.location.href=\'admin.php?page=smileys&delete='.$got['id'].'\'" class="btn btn-danger"><i class="fa fa-ban fa-fw"></i></button>
            </div>
        </div>';
    }
    return $content . '</div>';
}

function user_admin() {
    global $conn;

    $content = '<h1 class="postname">Quản lý thành viên</h1>';
    
    if(isset($_GET['ban']) && $delete = intval($_GET['ban'])) {
        $getUser = query_mysql("select ban from users where id = {$delete}", true);
        if($getUser['ban']) {
            mysqli_query($conn, "update users set ban = 0 where id = {$delete}");
            $content .= '<div class="alert alert-success">Unban thành viên thành công !</div>';
        } else {
            mysqli_query($conn, "update users set ban = 1 where id = {$delete}");
            $content .= '<div class="alert alert-warning">Ban thành viên thành công !</div>';
        }
        cache_delete('users');
    }

    $content .= 
    '<form method="get" action="admin.php">
        <div class="row">
            <div class="col-md-8">
            <div class="flexRow">
                <input type="hidden" name="page" value="users" />
                <input name="search" class="form-control" style="max-width: 450px;" placeholder="Nhập tên user" value="'.sanitize_xss($_GET['search']).'">
                <button class="btn btn-info ml-2" type="submit">Tìm</button>
            </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="pl-2 text-right" style="align-self: center;">
                <select id="sort" onchange="(function(){ var sort = $(\'#sort\').val(); window.location.href = \'admin.php?page=contentPending&sort=\'+sort; })()" class="p-2">
                <option value="desc">Mới đến cũ</option>
                <option value="pending" '.($_GET['sort'] === 'asc' ? 'selected' : '').'>Cũ đến mới</option></select>
                </div>
            </div>
        </div>
    </form>';
	
	$page   = isset($_GET['p']) ? abs(intval($_GET['p'])) : 1;
    $offset = $page>1 ? ($page-1)*60 : 0;
	
    if(isset($_GET['search'])) {
        $search = mysqli_real_escape_string($conn, trim($_GET['search']));
        $user = query_mysql('select * from users where username like "%'.$search.'%" limit 60 offset '.$offset);
		$total = mysqli_num_rows(mysqli_query($conn, 'select id from users where username like "%'.$search.'%"'));
	} else { 
        $user = user_60($offset);
		$total = users_total_admin();
	}
    
    $content .= '<div id="category_panel" class="mt-2">';
    if(!$user)  $content .= '<div>Không có kết quả nào cho từ khóa <b>'.sanitize_xss($_GET['search']).'</b> !</div>';

    foreach($user as $get) {
        $content .= '
        <div class="row">
            <div class="col-md-8">
                <div class="flexRow">
                    <div><img src="/assets/images/avatar.php?id='.$get['id'].'" width="70px" /></div>
                    <div class="pl-2">
                    <a href="/dashboard/index.php?user_access='.$get['id'].'&page=information" target="_blank"><b class="text-large">'.sanitize_xss($get['username']).'</b></a><br/>
                    '.(!$get['rights'] ? 'Member': '<font color=red>'.ucfirst($get['rights']).'</font>').'<br/>
                    '.sanitize_xss($get['email']).'
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right" style="align-self: center;">
                <i class="fa fa-circle fa-fw" style="font-size: 7px; color: '.($get['ban'] ? 'red' : 'green').'"></i>
                <button class="btn btn-primary mx-2" data-toggle="tooltip" title="Sửa" onclick="window.open(\'/dashboard/index.php?user_access='.$get['id'].'&information\', \'_blank\')"><i class="fa fa-edit fa-fw"></i></button>
                <button class="btn btn-danger" data-toggle="tooltip" title="Ban/Unban" onclick="user_ban('.$get['id'].')"><i class="fa fa-ban fa-fw"></i></button>
            </div>
        </div>';
    }

    $content .= '</div>';
	
	if($total > 60)
    {
        $content .= 
        '<nav aria-label="Page navigation example mt-2">
            <ul class="pagination justify-content-center mt-4">';
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
            $content .= '<li class="page-item">
            <a class="page-link" href="admin.php?page=users&p=1" tabindex="-1" aria-disabled="true">«</a>
            </li>';
        }
		            
        for($i = $pageI; $i <= $end_page; $i++) {
            $content .= '<li class="page-item'.($i === $page ? ' active' : '').'"><a class="page-link" href="admin.php?page=users&p='.$i.'" '.($i === $page ? 'aria-current="page"' : '').'>'.$i.' '.($i === $page ? ' <span class="sr-only">(current)</span>' : '').'</a></li>';
            if(++$dem === 7)    break;
        }
        if($page < $end_page) {
            $content .= 
            '<li class="page-item">
                <a class="page-link" href="admin.php?page=users&p='.$end_page.'" tabindex="-1" aria-disabled="true">»</a>
            </li>';
        }
            
        $content .= '</ul></nav>';
    }
    return $content;
}

function content_pending_admin() {
    global $conn, $uid;

    $content = '<h1 class="postname">Nội dung chờ duyệt</h1>';

    $page   = isset($_GET['p']) ? abs(intval($_GET['p'])) : 1;
    $offset = $page>1 ? ($page-1)*30 : 0;

    $sort    = $_GET['sort'] === 'asc' ? 'asc' : 'desc';
    $stories = query_mysql("select thumb, name, id, view, status from stories where duyet = 0 order by id {$sort} limit 30 offset {$offset}");
    $total   = stories_pennding_total_admin();
    $_GET['sort'] = $sort;
    
    $content .= ' 
    <div class="flexRow">
        <div style="flex:1;color:#fff">
            Có <b>'.$total.'</b> truyện chờ duyệt.
        </div>
        <div class="pl-2 text-right" style="align-self: center;">
        <select id="sort" onchange="(function(){ var sort = $(\'#sort\').val(); window.location.href = \'admin.php?page=contentPending&sort=\'+sort; })()" class="p-2">
        <option value="desc">Mới đến cũ</option>
        <option value="pending" '.($_GET['sort'] === 'asc' ? 'selected' : '').'>Cũ đến mới</option></select>
        </div>
    </div>
    <div class="row">';

    if(!$total) {
        $content .= '<div class="mt-2 col-12" style="color:#fff">Chưa có truyện nào.</div>';
    } else {
        foreach($stories as $get) {
            $theloai = '';
            foreach(story_categories_by_story_id($get['id']) as $tll) {
                $theloai .= '<a href="/story/cat.php?id='.$tll['category_id'].'">'.sanitize_xss( categories_by_id($tll['category_id'])['name'] ).'</a>, ';
            }
            
            $content .= 
            '<div class="col-md-6" id="story_'.$get['id'].'">
                <div class="flexRow py-3" style="border-bottom: 1px solid #eee">
                    <div style="width: 150px; height: 250px;">
                        <img src="/assets/hentai/'.$get['thumb'].'.jpg" width="150px" height="250px" alt="" />
                    </div>
                    <div class="ml-3" style="flex: 1">
                        <span class="text-large"><a href="/story/view.php?id='.$get['id'].'" target="_blank">'.sanitize_xss($get['name']).'</a></span><br/>
                        '.($get['status'] ? '<font color=green><i class="fal fa-check fa-fw"></i>Đã hoàn thành</font>' : '<font color=blue><i class="fal fa-clock fa-fw"></i> Chưa hoàn thành</font>').'<br/>
                        Số chapter: '.count(character_by_story_id($get['id'])).'<br/>
                        Thể loại: '.$theloai.'
                        <div class="mt-2">
                            <a target="_blank" class="btn btn-warning" href="index.php?page=uploaded&do=setting&user_access='.$uid.'&id='.$get['id'].'"><i class="fa fa-cog fa-fw"></i></a>
                            <a target="_blank" href="index.php?user_access='.$uid.'&page=uploaded&do=list&id='.$get['id'].'" class="btn btn-primary"><i class="fa fa-list fa-fw"></i></a>
                            <button class="btn btn-danger" onclick="user_delete_story('.$get['id'].')"><i class="fa fa-trash fa-fw"></i></button>
                            <button class="btn btn-success" onclick="admin_duyet_story('.$get['id'].')"><i class="fa fa-check fa-fw"></i></button>
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
        if($end_page > 4)
        {
            if($page == $end_page-3) $pageI = $page-3;
            if($page == $end_page-2) $pageI = $page-4;
            if($page == $end_page-1) $pageI = $page-5;
            if($page == $end_page-0) $pageI = $page-6;
        }
		if($pageI < 1) $pageI = 1;
        if($page > 1) {
            $content .= 
            '<li class="page-item">
                <a class="page-link" href="admin.php?page=content&p=1&sort='.$_GET['sort'].'" tabindex="-1" aria-disabled="true">«</a>
            </li>';
        }
            
        for($i = $pageI; $i <= $end_page; $i++)
        {
            $content .= '<li class="page-item'.($i === $page ? ' active' : '').'"><a class="page-link" href="admin.php?page=content&sort='.$_GET['sort'].'&p='.$i.'" '.($i === $page ? 'aria-current="page"' : '').'>'.$i.' '.($i === $page ? ' <span class="sr-only">(current)</span>' : '').'</a></li>';
            if(++$dem === 7)    break;
        }
        if($page < $end_page) {
            $content .= 
            '<li class="page-item">
                <a class="page-link" href="admin.php?page=content&sort='.$_GET['sort'].'&p='.$end_page.'" tabindex="-1" aria-disabled="true">»</a>
            </li>';
        }
            
        $content .= '</ul></nav>';
    }
    
    return $content;
}

function content_admin() {
    global $conn, $uid;

    $content = '<h1 class="postname">Tất cả nội dung</h1>';

    $page   = isset($_GET['p']) ? abs(intval($_GET['p'])) : 1;
    $offset = $page>1 ? ($page-1)*30 : 0;

    $sql = '';
    if ($search = $_GET['search']) {
        $search = mysqli_real_escape_string($conn, $search);
        $sql = ' where name like "%'.$search.'%"';
    }
    
    if($_GET['sort'] === 'done') {
        $stories = query_mysql("select thumb, name, id, view, status, duyet from stories {$sql} order by status desc, id desc limit 30 offset {$offset}");
    } else if ($_GET['sort'] === 'pending') {
        $stories = query_mysql("select thumb, name, id, view, status, duyet from stories {$sql} order by status asc, id desc limit 30 offset {$offset}");        
    } else {
        $stories = query_mysql("select thumb, name, id, view, status, duyet from stories {$sql} order by id desc limit 30 offset {$offset}");
    }

    $total = intval(mysqli_fetch_assoc(mysqli_query($conn, "select COUNT(id) as ids from stories {$sql}"))['ids']);
    $_GET['sort'] = $_GET['sort'] ?: 'default';

    $content .= 
    '<form>
        <div class="flexRow mb-2">
            <input type="hidden" name="page" value="content">
            <input name="search" class="form-control" style="max-width: 450px;" placeholder="Nhập tên truyện" value="'.sanitize_xss($_GET['search']).'">
            <button class="btn btn-primary ml-2" type="submit">Tìm</button>
        </div>
    </form>
    <div class="flexRow">
        <div style="flex: 1"><a href="index.php?page=uploaded&user_access='.$uid.'&do=upload" target="_blank" class="btn btn-info"><i class="fa fa-upload fa-fw"></i> Upload truyện mới</a></div>
        <div class="pl-2 text-right" style="align-self: center;">
            <select id="sort" onchange="(function(){ var sort = $(\'#sort\').val(); window.location.href = \'admin.php?page=content&sort=\'+sort; })()" class="p-2">
                <option value="default">Mặc định</option>
                <option value="done" '.($_GET['sort'] === 'done' ? 'selected' : '').'>Đã hoàn thành</option>
                <option value="pending" '.($_GET['sort'] === 'pending' ? 'selected' : '').'>Chưa hoàn thành</option>
            </select>
        </div>
    </div>
    <div class="row">';
    
    if(!$total) {
        $content .= '<div class="mt-2 col-12" style="color:#fff">Chưa có truyện nào.</div>';
    } else {
        foreach($stories as $get) {
            $theloai = '';
            foreach(story_categories_by_story_id($get['id']) as $tll) {
                $theloai .= '<a href="/story/cat.php?id='.$tll['category_id'].'">'.sanitize_xss( categories_by_id($tll['category_id'])['name'] ).'</a>, ';
            }

            $content .= 
            '<div class="col-md-6" id="story_'.$get['id'].'">
                <div class="flexRow py-3" style="border-bottom: 1px solid #eee">
                    <div style="width: 150px; height: 250px;">
                        <img src="/assets/hentai/'.$get['thumb'].'.jpg" width="150px" height="250px" alt="" />
                    </div>
                    <div class="ml-3" style="flex: 1;color:#fff">
                        <span class="text-large"><a href="/story/view.php?id='.$get['id'].'" target="_blank">'.sanitize_xss($get['name']).'</a></span><br/>
                        '.($get['duyet'] ? ($get['status'] ? '<font color=green><i class="fal fa-check fa-fw"></i>Đã hoàn thành</font>' : '<font color=blue><i class="fal fa-clock fa-fw"></i> Chưa hoàn thành</font>') : '<font color=gray>...chờ duyệt</font>').'<br/>
                        Lượt xem: <b>'.number_format($get['view']).'</b><br/>
                        Thể loại: '.$theloai.'
                        <div class="mt-2">
                            <a target="_blank" class="btn btn-warning" href="index.php?page=uploaded&do=setting&user_access='.$uid.'&id='.$get['id'].'"><i class="fa fa-cog fa-fw"></i></a>
                            <a target="_blank" href="index.php?user_access='.$uid.'&page=uploaded&do=list&id='.$get['id'].'" class="btn btn-primary"><i class="fa fa-list fa-fw"></i></a>
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
        $dem = 0;
        $pageI = $page > 4 ? $page-3 : 1;
        $end_page = ceil($total/30);
        if($end_page > 4)
        {
            if($page == $end_page-3) $pageI = $page-3;
            if($page == $end_page-2) $pageI = $page-4;
            if($page == $end_page-1) $pageI = $page-5;
            if($page == $end_page-0) $pageI = $page-6;
        }
		if($pageI < 1) $pageI = 1;
        if($page > 1) {
            $content .= 
            '<li class="page-item">
                <a class="page-link" href="admin.php?page=content&p=1&sort='.$_GET['sort'].'&search='.htmlspecialchars($_GET['search']).'" tabindex="-1" aria-disabled="true">«</a>
            </li>';
        }
            
        for($i = $pageI; $i <= $end_page; $i++) {
            $content .= 
            '<li class="page-item'.($i === $page ? ' active' : '').'">
                <a class="page-link" href="admin.php?page=content&search='.htmlspecialchars($_GET['search']).'&sort='.$_GET['sort'].'&p='.$i.'" '.($i === $page ? 'aria-current="page"' : '').'>'.$i.' '.($i === $page ? ' <span class="sr-only">(current)</span>' : '').'</a>
            </li>';
            if(++$dem === 7)    break;
        }
        if($page < $end_page) {
            $content .= 
            '<li class="page-item">
                <a class="page-link" href="admin.php?page=content&sort='.$_GET['sort'].'&search='.htmlspecialchars($_GET['search']).'&p='.$end_page.'" tabindex="-1" aria-disabled="true">»</a>
            </li>';
        }

        $content .= '</ul></nav>';
    }

    return $content;
}

function comments_admin() {
    $content = '<h1 class="postname">Tất cả bình luận</h1>';
    $page    = isset($_GET['p']) ? abs(intval($_GET['p'])) : 1;
    
    $offset  = $page>1 ? ($page-1)*30 : 0;

    $comment = comment_30($offset);
    $total   = comment_total_admin();
    foreach($comment as $get) {
        $content .= '
        <div class="py-2" style="border-bottom: 1px solid #eee;color:#fff" id="bl_'.$get['id'].'">
            <div class="ellipsis"><a href="/story/view.php?id='.$get['story_id'].'" style="color:#a79300">'.sanitize_xss( stories_by_id($get['story_id'])['name'] ).'</a></div>
            <div class="text-right ellipsis"><small style="color: #03f"><a href="/story/chapter.php?id='.$get['chapter_id'].'">'.sanitize_xss( character_by_id($get['chapter_id'])['name'] ).'</a></small></div>
            <div class="flexRow mt-2">
                <div><button class="btn btn-danger" onclick="admin_delete_comment('.$get['id'].')"><i class="fal fa-trash fa-fw"></i></button> <img src="/assets/images/avatar.php?id='.$get['user_id'].'" width="50px" style="border: 1px solid #eee"></div>
                <div class="pl-2 flex1">
                    <div class="flexRow">
                        <div class="flex1"><b style="color: #03f">'.ucfirst(user_by_id($get['user_id'])['username']).'</b></div>
                        <div><abbr><i class="far fa-clock fa-fw"></i> <span>'.date('H:i d/m/y', $get['time']).'</span></abbr></div>
                    </div>
                    '.smileys($get['text']).'
                </div>
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
                <a class="page-link" href="admin.php?page=comment&&p=1" tabindex="-1" aria-disabled="true">«</a>
            </li>';
        }
            
        for($i = $pageI; $i <= $end_page; $i++) {
            $content .= '<li class="page-item'.($i === $page ? ' active' : '').'"><a class="page-link" href="admin.php?page=comment&p='.$i.'" '.($i === $page ? 'aria-current="page"' : '').'>'.$i.' '.($i === $page ? ' <span class="sr-only">(current)</span>' : '').'</a></li>';
            if(++$dem === 7)    break;
        }
        if($page < $end_page) {
            $content .= '<li class="page-item">
                <a class="page-link" href="admin.php?page=comment&p='.$end_page.'" tabindex="-1" aria-disabled="true">»</a>
            </li>';
        }
            
        $content .= '</ul></nav>';
    }

    return $content;
}