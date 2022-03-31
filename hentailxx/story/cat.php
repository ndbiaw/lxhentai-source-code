<?php
/**
 * author : trint
 * modify code : 2020-04
 * phone : 098 406 3678
 */
require '../connect/_con.php';

$id  = (int)$_GET['id'];
$get = categories_by_id($id);
if(!$get) {
    redirect('/');
}

$title = $get['name'];
$tab   = 'category';

require '../connect/header.php';

include './more/cat.php';
?>
<ul class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/" class="itemcrumb active" itemprop="item" itemtype="http://schema.org/Thing"><span itemprop="name">Trang chủ</span></a><meta itemprop="position" content="2"></li>
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/story/cat.php?id=<?=$id?>" class="selectedcrumb"><?=$title?></a></li>
</ul>

<div class="row">
    <div class="col-md-8">
        <h1 class="page-title"><?= $title ?>></h1>
        <form>
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="flexRow mt-2">
                <div class="flex1"><input type="text" name="search" class="form-control" placeholder="Nhập từ khóa..." value="<?= sanitize_xss($_GET['search']??'') ?>"></div>
                <div class="pl-2"><button class="btn btn-primary" type="submit"><i class="fal fa-search fa-fw"></i></button></div>
            </div>
        </form>
        <div class="my-2" style="color: #fff"><b><?= $total ?></b> kết quả.</div>
        <div class="row"><?= card_cat() ?></div>
        <?= page_cat() ?>
    </div>   
    <?= you_like_box() ?>  
</div>  
<?php
require '../connect/footer.php';