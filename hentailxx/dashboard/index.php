<?php
/**
 * author : trint
 * modify code : 2020-04
 * phone : 098 406 3678
 */
require '../connect/_con.php';
include 'function.php';

if(!$my) {
    require('../connect/header.php');
    echo '<div class="alert alert-danger">Bạn phải đăng nhập để tiếp tục !</div>';
    require('../connect/footer.php');
	exit;
}

include './more/index.php';

switch($_GET['page'])
{
    default:
        $menu  = 1;
        $title = 'Trang cá nhân';
        require '../connect/header.php';
        $content = default_index();
    break;

    case 'password':
        $menu = 5;
        $title = 'Đổi mật khẩu';
        require '../connect/header.php';
        $content = password_index();
    break;

    case 'uploaded':
        switch($_GET['do'])
        {
            default: 
                $title = 'Truyện đã upload';
                $content = upload_do_index($title);
            break;

            case 'addChapter':
                $id = intval($_GET['id']);
                $title = 'Thêm chương mới';
                $content = upload_add_chapter_index($id, $title);
                
                $style  = '<style>.ck-editor__editable {min-height: 300px}</style>';
                $style  .= '<link rel="stylesheet" href="/assets/css/dropzone.css" />
                            <script src="/assets/js/dropzone.js"></script>';

                $script = "<script src=\"//cdn.ckeditor.com/4.13.0/standard/ckeditor.js\"></script><script>CKEDITOR.replace( 'editor' );</script>";                
                $script .= "<script>
                                var myDropzone = new Dropzone('.dropzone', { maxFilesize: 2, parallelUploads: 1, autoDiscover: false, autoProcessQueue: false, dictDefaultMessage: 'Chọn, kéo các trang muốn upload, tối đa 100 ảnh, mỗi ảnh dưới 2Mb.', url: \"index.php?user_access=$uid&page=uploaded&do=addChapter&id=$id&upload_ajax\", method: 'post', paramName: 'page', acceptedFiles: 'image/*', uploadMultiple: true, maxFiles: 100, addRemoveLinks: true });

                                $('#upload').click(function(){                                 
                                    if($('input[name=stt]').val().trim() == '' || $('input[name=name]').val().trim() == '' || $('#htmlMode').is(':visible')) {
                                        $('#form').click();
                                        return;
                                    }                                            
                                    myDropzone.processQueue(); 
                                    myDropzone.on('complete', function(){ myDropzone.processQueue(); });
                                    myDropzone.on('queuecomplete', function(){ $('#form').click(); })
                                });
                            </script>";
                
            break;

            case 'editChapter':        
                $title = 'Sửa chapter';
                $content = upload_edit_chapter_index($title);
                $style = '<style>.ck-editor__editable {min-height: 300px}</style>';
                $script = "<script src=\"//cdn.ckeditor.com/4.13.0/standard/ckeditor.js\"></script>
                            <script>CKEDITOR.replace( 'editor' );</script>";
            break;

            case 'list':
                $title = 'Danh sách chương';
                $content = upload_list_index($title);
            break;

            case 'setting':
                $title = 'Cài đặt truyện';
                $content = upload_setting_index($title);
            break;

            case 'upload':
                $title = 'Upload truyện mới';
                $content = upload_upload_index($title);
            break;
        }

        $menu = 2;
        require '../connect/header.php';
    break;
    
    case 'history':
        $menu = 6;
        $title = 'Lịch sử đọc truyện';
        $tab = 'history';
        require '../connect/header.php';
        $content = history_index($title);
    break;

    case 'gallery':
        $menu = 3;
        $title = 'Bộ sưu tập';
        $tab = 'gallery';
        require '../connect/header.php';
        $content = gallery_index();        
    break;

    case 'information':
        $menu = 4;
        $title = 'Thông tin tài khoản';
        require '../connect/header.php';
        $content = information_index();
    break;

}
?>

<ul class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">    
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/" class="itemcrumb active" itemprop="item" itemtype="http://schema.org/Thing"><span itemprop="name">Trang chủ</span></a><meta itemprop="position" content="2"></li>        
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/dashboard/" class="selectedcrumb">Thông tin chung</a></li>
</ul>
    
<div class="row">
    <div class="col-md-3 col-sm-4">
        <div class="flexRow db_board">
            <div style="min-width: 80px;"><img src="/assets/images/avatar.php?id=<?=$uid?>" width="80px"/></div>
            <div class="db_miniInfo">
                <div class="db_title">Tài khoản của</div>
                <b><?=sanitize_xss($my['username'])?></b>
            </div>
            <div class="db_toggle" onclick="db_toggle();">
                <i class="fa active fa-angle-down"></i>
            </div>
        </div>
    
        <ul class="db_utils">
            <li <?=$menu === 1 ? 'class="active"' : ''?>><a href="index.php?user_access=<?=$uid?>"><i class="fa fa-home"></i> Tổng quan</a></li>
            <li <?=$menu === 2 ? 'class="active"' : ''?>><a href="index.php?page=uploaded&user_access=<?=$uid?>"><i class="fa fa-upload fa-fw"></i> Upload truyện</a></li>
            <li <?=$menu === 3 ? 'class="active"' : ''?>><a href="index.php?page=gallery&user_access=<?=$uid?>"><i class="fa fa-bookmark fa-fw"></i> Bộ Sưu Tập</a></li>
            <li <?=$menu === 6 ? 'class="active"' : ''?>><a href="index.php?page=history&user_access=<?=$uid?>"><i class="fa fa-undo fa-fw"></i> Lịch sử đọc truyện</a></li>
            <li <?=$menu === 4 ? 'class="active"' : ''?>><a href="index.php?page=information&user_access=<?=$uid?>"><i class="fa fa-info-circle fa-fw"></i> Thông tin tài khoản</a></li>
            <li <?=$menu === 5 ? 'class="active"' : ''?>><a href="index.php?page=password&user_access=<?=$uid?>"><i class="fa fa-lock fa-fw"></i> Đổi mật khẩu</a></li>
            <li><a href="/logout.php"><i class="fa fa-sign-out fa-fw"></i> Đăng xuất</a></li>
            <?=$my['rights'] === 'admin' ? '<li><a href="admin.php" style="color: blue"><i class="fa fa-user-shield fa-fw"></i> Chế độ Admin</a></li>' : ''?>
        </ul>

    </div>
    <div class="col-md-9 col-sm-8">
        <?=$access?>
        <?=$content?>
    </div>
</div>

<?php
require '../connect/footer.php';
