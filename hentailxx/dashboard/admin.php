<?php
/**
 * author : trint
 * modify code : 2020-04
 * phone : 098 406 3678
 */
require '../connect/_con.php';

if($my['rights'] != 'admin') {
    redirect('/');
}

cache_delete('categories'); 
$title = 'Bảng Quản Trị';

require '../connect/header.php';

include './more/admin.php';

switch($_GET['page'])
{
    default:
    $menu = 1;
    $content = default_admin();
    break;

    case 'category':
    $menu = 2;
    $content = category_admin();
    break;

    case 'ads':
    $menu = 6;
    $content = ads_admin();
    break;

    case 'users':
    $menu = 5;
    $content = user_admin();

    break;

    case 'smileys':
    $menu = 8;
    $content = smileys_admin();

    break;
    case 'contentPending':    
    $menu = 4;
    $content = content_pending_admin();
    break;

    case 'content':    
    $menu = 3;
    $content = content_admin();
    break;

    case 'comment':    
    $menu = 7;
    $content = comments_admin();

    break;
}
?>
<ul class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">    
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/" class="itemcrumb active" itemprop="item" itemtype="http://schema.org/Thing"><span itemprop="name">Trang chủ</span></a><meta itemprop="position" content="2"></li>
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/dashboard/admin.php" class="selectedcrumb">Chế độ Admin</a></li>
</ul>
<div class="row">
    <div class="col-md-3 col-sm-4">

        <ul class="db_utils">
            <li <?=$menu === 1 ? 'class="active"' : ''?>><a href="admin.php"><i class="fal fa-analytics"></i> Thống kê dữ liệu</a></li>
            <li <?=$menu === 2 ? 'class="active"' : ''?>><a href="admin.php?page=category"><i class="fal fa-folders fa-fw"></i> Quản lý chuyên mục <span class="ml-2 badge badge-primary"><?=number_format(categories_total_admin())?></span></a></li>
            <li <?=$menu === 3 ? 'class="active"' : ''?>><a href="admin.php?page=content"><i class="fal fa-book fa-fw"></i> Quản lý nội dung <span class="ml-2 badge badge-primary"><?=number_format(stories_total_admin())?></span></a></li>
            <li <?=$menu === 4 ? 'class="active"' : ''?>><a href="admin.php?page=contentPending"><i class="fal fa-clock fa-fw"></i> Nội dung chờ duyệt <span class="ml-2 badge badge-warning"><?=number_format(stories_pennding_total_admin())?></span></a></li>
            <li <?=$menu === 5 ? 'class="active"' : ''?>><a href="admin.php?page=users"><i class="fal fa-users fa-fw"></i> Quản lý thành viên <span class="ml-2 badge badge-primary"><?=number_format(users_total_admin())?></span></a></li>
            <li <?=$menu === 6 ? 'class="active"' : ''?>><a href="admin.php?page=ads"><i class="fal fa-ad fa-fw"></i> Quảng cáo</a></li>
            <li <?=$menu === 7 ? 'class="active"' : ''?>><a href="admin.php?page=comment"><i class="fal fa-comments fa-fw"></i> Bình luận <span class="ml-2 badge badge-primary"><?=number_format(comment_total_admin())?></span></a></li>
            <li <?=$menu === 8 ? 'class="active"' : ''?>><a href="admin.php?page=smileys"><i class="fal fa-smile fa-fw"></i> Biểu cảm <span class="ml-2 badge badge-primary"><?=count(get_smileys())?></span></a></li>
            <li><a href="index.php"><i class="fal fa-user fa-fw"></i> Chế độ thường</a></li>
        </ul>

    </div>
    <div class="col-md-9 col-sm-8">
    <?=$content?>
    </div>
</div>
<?php
require '../connect/footer.php';