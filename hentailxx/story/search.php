<?php
/**
 * author : trint
 * modify code : 2020-04
 * phone : 098 406 3678
 */
require '../connect/_con.php';
$title = 'Tìm kiếm';
require '../connect/header.php';
include './more/search.php';
?>
<h1 class="page-title">TÌM KIẾM</h1>
<form>
<div class="flexRow mb-2">
    <div class="flex1"><input class="form-control" type="text" name="key" placeholder="Nhập từ khóa" value="<?=sanitize_xss($key ?: '')?>"></div>
    <div class="px-2">
        <select class="form-control" name="type">
            <option value="">Tên truyện</option>
            <option value="tacgia" <?=$type === 'tacgia' ? 'selected' : ''?>>Tác giả</option>
            <option value="doujinshi" <?=$type === 'doujinshi' ? 'selected' : ''?>>Doujinshi</option>
        </select>
    </div>
    <div><button class="btn btn-primary" type="submit"><i class="fa fa-search fa-fw"></i></button></div>
</div>
</form>
<?php if($key) :?>
<div class="alert alert-info mb-2">Có <b><?=number_format($total)?></b> kết quả với từ khóa <b><?=sanitize_xss($key)?></b></div>
<?php endif; ?>
<div class="row">
<?php foreach($stories as $getStory) : ?>
    <div class="col-md-2 col-6 py-2">
        <div onclick="<?=href('/story/view.php?id='.$getStory['id'])?>" style="background: url('/assets/hentai/<?=$getStory['thumb']?>.jpg'); background-size: cover; height: 200px; border: 1px solid #ddd; background-position: center; position: relative">
            <div class="newestChapter"><a href="/story/chapter.php?id=<?=$getStory['chapter_id']?>"><?=sanitize_xss(character_by_id($getStory['chapter_id'])['name'])?></a></div>
        </div>
        <a href="/story/view.php?id=<?=$getStory['id']?>"><?=show_text(sanitize_xss($getStory['name']))?></a>  <?=$type == 'tacgia' ? '<small>- '.sanitize_xss($getStory['authors']).'</small>' : ''?>  <?=$type == 'doujinshi' ? '<small>- '.sanitize_xss($getStory['doujinshi']).'</small>' : ''?>
    </div>
<?php endforeach; ?>    
</div>
<?= page_search() ?>
<?
require '../connect/footer.php';