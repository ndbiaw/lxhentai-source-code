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

require '../connect/header.php';
include './more/chapter.php';
?>
<ul class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/" class="itemcrumb active" itemprop="item" itemtype="http://schema.org/Thing"><span itemprop="name">Trang chủ</span></a><meta itemprop="position" content="2"></li>
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/story/" class="selectedcrumb">Danh sách truyện</a></li>
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/story/view.php?id=<?=$getStory['id']?>" class="selectedcrumb"><?=sanitize_xss($getStory['name'])?></a></li>
</ul>
<h4 style="color: #fff"><a href="/story/view.php?id=<?=$getStory['id']?>"><?=sanitize_xss($getStory['name'])?></a> - <?=sanitize_xss($getChapter['name'])?></h4> <i></i>
<div class="row py-2" style="background: #f6f7f8">
    <div class="col-md-6">
        <div class="flexRow my-2">
            <div><img src="/assets/images/avatar.php?id=<?=$getChapter['user_id']?>" style="border-radius: 40px; height: 80px;"></div>
            <div class="pl-2" style="align-self: center">Bởi: <b><?=ucfirst(user_by_id($getChapter['user_id'])['username'])?></b><br/>
                <i class="far fa-clock fa-fw"></i> <?=date('H:i d/m/Y', $getChapter['time'])?><br/>
                <i class="far fa-eye fa-fw"></i> Lượt đọc: <?=$getChapter['view']?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        Chuyển Chapter Nhanh:<br/>
        <select class="form-control mt-2" id="selectChapter" onChange="window.location.href='chapter.php?id='+this.value">
        <?php foreach(character_by_story_id($getChapter['story_id']) as $get) : ?>
            <option value="<?=$get['id']?>" <?= $get['id'] == $getChapter['id'] ? 'selected' : '' ?>><?=sanitize_xss($get['name'])?></option>
        <?php endforeach; ?>
        </select>

        <div class="flexRow mt-2 mb-3">
            <div>
                <button onclick="user_follow_story(<?=$getStory['id']?>)" class="btn btn-success" id="story_follow_btn" style="<?=$checkFollow?'display:none;white-space:nowrap':'white-space:nowrap'?>"><i class="fa fa-heart fa-fw"></i> Theo dõi</button>
                <button onclick="user_follow_story(<?=$getStory['id']?>)" class="btn btn-warning" id="story_unfollow_btn" style="<?=!$checkFollow?'display:none;white-space:nowrap':'white-space:nowrap'?>"><i class="fa fa-times-circle fa-fw"></i> Bỏ theo dõi</button>
            </div>
            <div class="pl-3" style="align-self:center"><b id="story_follow_count"><?=story_follow_total($getStory['id'])?></b> Người Đã Theo Dõi<br/><small>Theo dõi để nhận thông báo khi ra chương mới.</small></div>
        </div>
    </div>

    <p style="text-align:center"><font color="red">--------------------------------------------------------Bấm F5, ĐỔI SEVER NẾU TRUYỆN HỎNG, KHÔNG ĐƯỢC THÌ HÃY COMMENT TRUYỆN HỎNG!--------------------------------------------</font></p>

</div>
<div style="background:#e4e4e4;height:41px;position:sticky;top:0;z-index:1;align-items:center;display:flex">
    <div class="row" style="flex:1">    
        <div class="col-2 text-left pl-4">
            <button <?=!$prev ? 'disabled' : 'onclick="'.href('/story/chapter.php?id='.$prev['id']).'"'?> class="btn-sm btn btn-secondary">←<span class="hide-mob"> chương trước</span></button>
        </div>

        <div class="col-8 text-center">
            <button <?=!$getChapter['download'] ? 'disabled' : 'onclick="'.href($getChapter['download']).'"'?> class="btn-sm btn btn-danger" ><i class="fal fa-cloud-download fa-fw"></i> Download</button> <button class="btn-sm btn btn-info" onclick="onclickdoisvanh()"><i class="fal fa-sync fa-fw"></i> Đổi server</button>
        </div>
        
        <div class="col-2 text-right pr-4">
            <button <?=!$next ? 'disabled' : 'onclick="'.href('/story/chapter.php?id='.$next['id']).'"'?> class="btn-sm btn btn-secondary"><span class="hide-mob">chương sau </span>→</button>
        </div>
    </div>
</div>
<div class="reader text-center py-2" id="content_chap"><?=($getChapter['html'])?>
    <div class="text-center" style="margin-top: 15px; margin-bottom: 15px;"><a href="http://bit.ly/lxhentai-bongdax-hotgirl" target="_blank"><img src="//lxhentai.com/banners/gaixinh2.gif" alt="Bottom Chapter"></a></div>
</div>

<div class="flexRow mt-2">
    <div style="align-self:center">
        <button <?=!$prev ? 'disabled' : 'onclick="'.href('/story/chapter.php?id='.$prev['id']).'"'?> class="btn-sm btn btn-secondary">←<span class="hide-mob"> chương trước</span></button>
    </div>
    <div class="px-2 flex1">
        <select class="form-control" id="selectChapter" onChange="window.location.href='chapter.php?id='+this.value">
        <?php foreach(character_by_story_id($getChapter['story_id']) as $get) : ?>
            <option value="<?=$get['id']?>" <?=$get['id'] == $getChapter['id'] ? 'selected' : ''?>><?=sanitize_xss($get['name'])?></option>
        <?php endforeach; ?>
        </select>
    </div>
    <div style="align-self: center">
        <button <?=!$next ? 'disabled' : 'onclick="'.href('/story/chapter.php?id='.$next['id']).'"'?> class="btn-sm btn btn-secondary"><span class="hide-mob">chương sau </span>→</button>
    </div>
</div>

<?php $demComment = comment_total($getChapter['story_id']); ?>
<div class="detail-content mt-3">
    <h3 class="list-title"><i class="fa fa-comments fa-fw"></i> BÌNH LUẬN <b style="float: right" id="count_comment" class="badge badge-danger px-2"><?=$demComment?></b></h3>

    <?php if($my['id']) : ?>
        <div class="smileys" id="smile_original"><?=smileys_chapter()?></div>
        <form onsubmit="postBigComment(event, <?=$getStory['id']?>, <?=$id?>)">
            <textarea id="bigComment" required class="comment" placeholder="Mời bạn thảo luận, vui lòng nhập Tiếng Việt có dấu"></textarea>
            <div class="text-right"><a href="javascript:void(0)" class="btn btn-light" onclick="$('#smile_original').toggle()"><i class="fal fa-smile fa-fw"></i></a> <button class="btn btn-primary" type="submit">Gửi Bình Luận</button></div>
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
$script = "<script>
                document.addEventListener('contextmenu', event => event.preventDefault());
                $(function() { showComment({$getStory['id']}) })
            </script>";

require '../connect/footer.php';