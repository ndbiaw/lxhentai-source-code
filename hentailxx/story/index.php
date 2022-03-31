<?php
/**
 * author : trint
 * modify code : 2020-04
 * phone : 098 406 3678
 */
require '../connect/_con.php';

$title = 'Danh sách truyện';
require '../connect/header.php';
include './more/index.php';
?>
<ul class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/" class="itemcrumb active" itemprop="item" itemtype="http://schema.org/Thing"><span itemprop="name">Trang chủ</span></a><meta itemprop="position" content="2"></li>
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/story/" class="selectedcrumb">Danh sách truyện</a></li>
</ul>

<div class="row">
    <div class="col-md-8">
        <h1 class="page-title">DANH SÁCH TRUYỆN ></h1>
        <ul class="nav nav-pills nav-fill my-3" style="background: #ddd">
            <li class="nav-item">
                <a class="nav-link <?=!isset($_GET['hot']) ? 'active' : ''?>" href="index.php">Mới cập nhật</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=isset($_GET['hot']) ? 'active' : ''?>" href="index.php?hot">Hot nhất</a>
            </li>
        </ul>
        <div class="row">
        <?php foreach($stories as $getStory) : ?>
            <?php $newest = character_by_id($getStory['chapter_id']); ?>
            <div class="col-md-3 col-6 py-2">
                <div onclick="window.location.href=<?=href('/story/view.php?id='.$getStory['id'])?>" style="background: url('/assets/hentai/<?=$getStory['thumb']?>.jpg'); background-size: cover; height: 200px; border: 1px solid #ddd; background-position: center; position: relative">
                    <div class="newestChapter"><a href="/story/chapter.php?id=<?=$newest['id']?>"><?=sanitize_xss($newest['name'])?></a></div>
                </div>
                <a href="/story/view.php?id=<?=$getStory['id']?>"><?=show_text(sanitize_xss($getStory['name']))?></a>
            </div>
        <?php endforeach; ?>
        </div>   
        <?= page_index() ?> 
    </div>
    <div class="col-md-4">
        <div class="darkbox mt-4">
            <h2>DANH SÁCH THỂ LOẠI</h2>
            <div class="row">
            <?php foreach(get_categories() as $get) : ?>
                <div class="col-6 py-2"><a href="cat.php?id=<?=$get['id']?>" style="color:#fff"><?=sanitize_xss($get['name'])?></a></div>
            <?php endforeach; ?>    
            </div> 
        </div>
    </div>
</div>

<?php
require '../connect/footer.php';