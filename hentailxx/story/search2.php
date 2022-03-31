<?php
/**
 * author : trint
 * modify code : 2020-04
 * phone : 098 406 3678
 */
require '../connect/_con.php';
$title = 'Tìm kiếm nâng cao';
$tab   = 'moreSearch';
require '../connect/header.php';

include './more/search2.php';
?>
<h1 class="page-title" onclick="$('#nangcao').toggle()">TÌM KIẾM NÂNG CAO <i class="fa fa-caret-down fa-fw"></i></h1>
<form id="nangcao">
<div class="row">
    <div class="col-md-12">
        <div class="form-group pt-2">
            <label><b>Tên truyện</b></label>
            <input class="form-control" type="text" name="key" placeholder="Không ghi cũng được" value="<?=($key?:'')?>">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group pt-2">
            <label><b>Doujinshi bộ nào</b></label>
            <input class="form-control" type="text" name="doujinshi" placeholder="Có thể bỏ trống" value="<?=($dojinshi?:'')?>">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group pt-2">
            <label><b>Tác giả</b></label>
            <input class="form-control" type="text" name="authors" placeholder="Có thể bỏ trống" value="<?=($authors?:'')?>">
        </div>
    </div>
    <div class="col-md-12 pt-2"><b>Thể loại cần tìm:</b></div>
    <div class="col-md-12 pb-4 pt-2">
        <div class="row">
        <?php foreach(get_categories() as $get) : ?>
            <div class="col-md-2 col-4"><input type="checkbox" <?=in_array($get['id'], $_GET['selectFolder']) ? 'checked' : ''?> value="<?=$get['id']?>" name="selectFolder[]" id="f<?=$get['id']?>"> <label for="f<?=$get['id']?>"><?=sanitize_xss($get['name'])?></label></div>
        <?php endforeach; ?>
        </div>    
    </div>
    <div class="col-md-6"> 
        <select class="form-control" name="status">
            <option value="">Đã hoàn thành / chưa hoàn thành</optiom>
            <option value="1" <?=$_GET['status'] == 1 ? 'selected' : ''?>>Đã hoàn thành</option>
            <option value="2" <?=$_GET['status'] == 2 ? 'selected' : ''?>>Chưa hoàn thành</option>
        </select>
    </div> 
    <div class="col-md-6">
        <button class="m-0 btn btn-warning w-100" type="submit" style="padding: .375rem .75rem"><i class="fal fa-search fa-fw"></i> Tìm kiếm</button>
    </div>       
</div>
</form>
<?php if($total) : ?>
    <div class="alert alert-info mb-2 mt-3">Có <b><?=number_format($total)?></b> kết quả.</div>
<?php endif; ?>
<div class="row">
<?php foreach($stories as $getStory) : ?>
    <div class="col-md-2 col-6 py-2">
        <div onclick="window.location.href='/story/view.php?id=<?=$getStory['id']?>'" style="background: url('/assets/hentai/<?=$getStory['thumb']?>.jpg'); background-size: cover; height: 200px; border: 1px solid #ddd; background-position: center; position: relative">
            <div class="newestChapter"><a href="/story/chapter.php?id=<?=$getStory['chapter_id']?>"><?=sanitize_xss(character_by_id($getStory['chapter_id'])['name'])?></a></div>
        </div>
        <a href="/story/view.php?id=<?=$getStory['id']?>"><?=show_text(sanitize_xss($getStory['name']))?></a>  <?=$type == 'tacgia' ? '<small>- '.sanitize_xss($getStory['authors']).'</small>' : ''?>  <?=$type == 'doujinshi' ? '<small>- '.sanitize_xss($getStory['doujinshi']).'</small>' : ''?>
    </div>
<?php endforeach; ?>    
</div>
<?=page_search2()?>
<?php
require '../connect/footer.php';