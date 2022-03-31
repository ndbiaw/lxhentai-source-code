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
<?php if($key) :?>
    <div class="cat_title"><span><?=number_format($total)?> kết quả</span> được tìm thấy cho cụm từ <span><?=$key?></span></div>    
<?php else:?>
    <div class="cat_title">DANH SÁCH TRUYỆN</div>
<?php endif; ?>
<div class="container">
    <div class="row">
    <?php foreach($stories as $getStory) : ?>
        <div class="col-4 py-2 px-1">
            <div class="thumb_mob" onclick="<?=href('/story/view.php?id='.$getStory['id'])?>" style="background: url('//lxhentai.com/assets/hentai/<?=$getStory['thumb']?>.jpg'); background-size: cover; background-position: center; position: relative">
            </div>
            <a class="text-black" href="/story/view.php?id=<?=$getStory['id']?>">
            <?=show_text(sanitize_xss($getStory['name']))?>
            </a>  <?=$type == 'tacgia' ? '<small>- '.sanitize_xss($getStory['authors']).'</small>' : ''?>  <?=$type == 'doujinshi' ? '<small>- '.sanitize_xss($getStory['doujinshi']).'</small>' : ''?><br/>
            <small><a href="/story/chapter.php?id=<?=$getStory['chapter_id']?>" class="text-black"><?=sanitize_xss(character_by_id($getStory['chapter_id'])['name'])?></a></small>
        </div>    
    <?php endforeach; ?> 
    </div>
    <?= page_search() ?>
</div>
<?php
require '../connect/footer.php';