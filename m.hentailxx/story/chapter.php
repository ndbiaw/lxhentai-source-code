<?php
/**
 * author : trint
 * modify code : 2020-04
 * phone : 098 406 3678
 */
require '../connect/_con.php';

$id = intval($_GET['id']);

$getChapter = character_by_id($id);
$getStory   = stories_by_id($getChapter['story_id']);
if(!$getChapter || !$getStory || ($getStory['duyet'] == 0 && $my['rights'] != 'admin') || ($getStory['duyet'] == 0 && $my['id'] != $getStory['user_id'])) {
    redirect('/');
}

$title = $getStory['name'].' - '.$getChapter['name'];
$viewChapter = '/story/view.php?id='.$getStory['id'];
require '../connect/header.php';
include './more/chapter.php';
?>

<div class="flexRow mt-4">
    <div><?=$prev ? '<a href="/story/chapter.php?id='.$prev['id'].'" class="changeChap"><i class="fal fa-angle-left"></i></a>' : 
    '<a href="javascript:void(0);" class="changeChap" style="background: #ddd"><i class="fal fa-angle-left"></i></a>'?></div>
    <div class="px-2 flex1">
        <select style="height: 48px" class="form-control" id="selectChapter" onChange="window.location.href='chapter.php?id='+this.value">
        <?php foreach(character_by_story_id($getChapter['story_id']) as $get) : ?>
            <option value="<?=$get['id']?>" <?=$get['id'] == $getChapter['id'] ? 'selected' : ''?>><?=sanitize_xss($get['name'])?></option>
        <?php endforeach; ?>
        </select>
    </div>
    <div><?=$next ? '<a href="/story/chapter.php?id='.$next['id'].'" class="changeChap"><i class="fal fa-angle-right"></i></a>' : 
    '<a href="javascript:void(0);" class="changeChap" style="background: #ddd"><i class="fal fa-angle-right"></i></a>'?></div>
</div>
<div class="flexRow mt-2">
    <div class="flex1">
        <button onclick="user_follow_story(<?=$getStory['id']?>)" class="btn-custom square" id="story_follow_btn" style="<?=$checkFollow?'display:none;white-space:nowrap':'white-space:nowrap'?>"><i class="fa fa-heart fa-fw"></i> Theo dõi</button>
        <button onclick="user_follow_story(<?=$getStory['id']?>)" class="btn-custom-red square" id="story_unfollow_btn" style="<?=!$checkFollow?'display:none;white-space:nowrap':'white-space:nowrap'?>"><i class="fa fa-times-circle fa-fw"></i> Bỏ theo dõi</button>
    </div>
    <div class="text-right flex1">        
        <button class="square btn-custom" <?=$getChapter['download'] ? 'onclick="window.open(\''.$getChapter['download'].'\', \'_blank\')"' : 'disabled style="background: #ddd!important; color: #333!important; border: 1px solid #ddd; user-select: none;"'?>><i class="fa fa-cloud-download" aria-hidden="true"></i> Download</button>
    </div>
</div>
<div class="my-2 square text-white" style="background: #009688; border: 1px solid #009688;" onclick="onclickdoisvanh()">
    <i class="fa fa-exchange" aria-hidden="true"></i> <b>ĐỔI SERVER ẢNH</b> NẾU LỖI
</div>
<div class="reader text-center py-2" id="content_chap"><?=$getChapter['html']?>
    <div class="text-center" style="margin-top: 15px; margin-bottom: 15px;"><a href="http://bit.ly/lxhentai-bongdax-hotgirl" target="_blank"><img src="//lxhentai.com/banners/gaixinh2.gif" alt="Bottom Chapter"></a></div>
</div>

<div class="flexRow">
    <div><?=$prev ? '<a href="/story/chapter.php?id='.$prev['id'].'" class="changeChap"><i class="fal fa-angle-left"></i></a>' : '<a href="javascript:void(0);" class="changeChap" style="background: #ddd"><i class="fal fa-angle-left"></i></a>'?></div>
    <div class="px-2 flex1">
        <select style="height: 48px" class="form-control" id="selectChapter" onChange="window.location.href='chapter.php?id='+this.value">
        <?php foreach(character_by_story_id($getChapter['story_id']) as $get) : ?>
            <option value="<?=$get['id']?>" <?=$get['id'] == $getChapter['id'] ? 'selected' : ''?>><?=sanitize_xss($get['name'])?></option>
        <?php endforeach; ?>
        </select>
    </div>
    <div><?=$next ? '<a href="/story/chapter.php?id='.$next['id'].'" class="changeChap"><i class="fal fa-angle-right"></i></a>' : '<a href="javascript:void(0);" class="changeChap" style="background: #ddd"><i class="fal fa-angle-right"></i></a>'?></div>
</div>
<?php $demComment = comment_total($getChapter['story_id']); ?>
<div class="detail-content mt-4">
    <h6><i class="fa fa-comments fa-fw"></i> BÌNH LUẬN <b id="count_comment" class="badge badge-danger px-2"><?=$demComment?></b></h6>

    <?php if($my['id']) : ?>
        <div class="smileys" id="smile_original"><?=smileys_chapter()?></div>
        <form onsubmit="postBigComment(event, <?=$getStory['id']?>, <?=$id?>)">
            <textarea id="bigComment" required class="comment" placeholder="Mời bạn thảo luận, vui lòng nhập Tiếng Việt có dấu"></textarea>
            <div class="text-right"><a href="javascript:void(0)" class="btn btn-light" onclick="$('#smile_original').toggle()"><i class="fal fa-smile fa-fw"></i></a> <button class="btn btn-info" type="submit">Gửi Bình Luận</button></div>
        </form>
    <?php else : ?>
        <textarea class="comment" placeholder="Bạn cần đăng nhập để thảo luận" disabled></textarea>
    <?php endif; ?>
    <div id="listComment"></div>
    <?php if($demComment > 30) : ?>
    <center id="load_comment_more"><a href="javascript:showComment(<?=$getStory['id']?>)">Xem thêm bình luận <i class="fa fa-caret-down"></i></a></center>
    <?php endif; ?>

</div>
<?php
$script = '<script>
$(function() { 
    showComment('.$getStory['id'].');
    if(location.href.search(\'m.lxhentai.com\') == -1) {
        $(\'#content_chap\').append(\'<a href="http://bit.ly/hentailx-go88-pc-under-content-v1" target="_blank" class="mt-4"><img src="//lxhentai.com/assets/images/undercontent.gif"></a>\');
    } else {
        console.log(\'error\')
    }
})
</script>';

require '../connect/footer.php';