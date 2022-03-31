<?php
/**
 * author : trint
 * modify code : 2020-04
 * phone : 098 406 3678
 */
require '../connect/_con.php';

$id         = intval($_GET['id']);
$getStory   = stories_by_id($id);

if(!$getStory && ($getStory['duyet'] == 0 && $my['rights'] != 'admin') && ($getStory['duyet'] == 0 && $my['id'] != $getStory['user_id'])) {
    redirect('/');
}

$title = sanitize_xss($getStory['name']);
require '../connect/header.php';

include './more/view.php';
?>

<div class="row">
    <div class="col-md-12 pt-4" style="color: #333">
        <div class="container">
            <div class="flexRow pt-2">
	            <div><img src="//lxhentai.com/assets/hentai/<?=$getStory['thumb']?>.jpg" width="120px" height="160px" style="box-shadow: 0 0 10px rgba(0, 0, 0, .5)" /></div>
	            <div class="pl-3">
		            <a href="#" style="font-size: 18px; margin-bottom: 10px; display: block;"><?=sanitize_xss($getStory['name'])?></a>
	                <div><span class="fa-red"><i class="fa fa-eye fa-fw"></i> <?=number_format($getStory['view'])?></span> lượt xem</div>
	                <div class="mt-2">
                        <div>
                            <button onclick="user_follow_story(<?=$id?>)" class="btn btn-success" id="story_follow_btn" <?=$checkFollow ? 'style="display: none; white-space: nowrap"' : 'style="white-space: nowrap;"'?>><i class="fa fa-heart fa-fw"></i> Theo dõi</button>
                            <button onclick="user_follow_story(<?=$id?>)" class="btn btn-warning" id="story_unfollow_btn" <?=!$checkFollow ? 'style="display: none; white-space: nowrap"' : 'style="white-space: nowrap;"'?>><i class="fa fa-times-circle fa-fw"></i> Bỏ theo dõi</button>
                        </div>
	                    <div class="mt-2" style="align-self: center;"><b id="story_follow_count"><?=story_follow_total($id)?></b> Người Đã Theo Dõi<br/><small>Theo dõi để nhận thông báo khi ra chương mới.</small></div>
	                </div>
                </div>
            </div>
        </div>
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item mob">
                <a class="nav-link active" id="pills-new-tab" data-toggle="pill" href="#pills-new" role="tab" aria-controls="pills-new" aria-selected="true"
                onclick="(function(){ $('.dmm').removeClass('show active'); $('#pills-new').addClass('show active'); })();">Danh Sách Chương</a>
            </li>
            <li class="nav-item mob">
                <a class="nav-link" id="pills-ttt-tab" data-toggle="pill" href="#pills-ttt" role="tab" aria-controls="pills-ttt" aria-selected="false"
                onclick="(function(){ $('.dmm').removeClass('show active'); $('#pills-ttt').addClass('show active'); })();">Thông Tin Truyện</a>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active dmm" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab">
                <div class="flexRow" style="flex-wrap: wrap"><?=$listChuong?></div>
            </div>

            <div class="tab-pane fade dmm pl-2" id="pills-ttt" role="tabpanel" aria-labelledby="pills-ttt-tab">
                <div><i class="fa fa-paint-brush-alt fa-fw fa-red"></i> Tác giả: <?=$getStory['authors'] ? $authors : 'Đang cập nhật'?></div>
                <div class="mt-1"><i class="fa fa-rss fa-fw fa-red"></i> Tình trạng: <?=$getStory['status'] ? '<font color=#e74c3c>Đã hoàn thành</font>' : 'Đang tiến hành'?></div>
                <div class="mt-1"><i class="fa fa-tags fa-fw fa-red"></i> Thể loại: <?=$theloai?></div>
                <div class="mt-1"><i class="fa fa-user fa-fw fa-red"></i> Thực hiện: <?=$getStory['thuchien'] ?: 'Đang cập nhật'?></div>
                <div class="mt-1"><i class="fa fa-users fa-fw fa-red"></i> Nhóm dịch: <?=$getStory['nhomdich'] ?: 'Đang cập nhật'?></div>
                <div class="mt-1"><i class="fa fa-poo fa-fw fa-red"></i> Doujinshi: <?=$getStory['doujinshi'] ? $doujinshis : 'Rỗng'?></div>
                <div class="mt-1"><i class="fa fa-info-circle fa-fw fa-red"></i> Giới thiệu truyện:
                    <div class="mt-2"><?=sanitize_xss($getStory['intro'] ?: 'Truyện này chưa có mô tả.')?></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="detail-content mt-4">
                <h6><i class="fa fa-comments fa-fw"></i> BÌNH LUẬN <b id="count_comment" class="badge badge-danger px-2"><?=$demComment?></b></h6>

                <?php if ($my['id']) : ?>
                    <div class="smileys" id="smile_original"><?=smileys_view()?></div>
                    <form onsubmit="postBigComment(event, <?=$id?>)">
                        <textarea id="bigComment" required class="comment" placeholder="Mời bạn thảo luận, vui lòng nhập Tiếng Việt có dấu"></textarea>
                        <div class="text-right">
                            <a href="javascript:void(0)" class="btn btn-light" onclick="$('#smile_original').toggle()"><i class="fal fa-smile fa-fw"></i></a> 
                            <button class="btn btn-info" type="submit">Gửi Bình Luận</button>
                        </div>
                    </form>
                <?php else : ?>
                    <textarea class="comment" placeholder="Bạn cần đăng nhập để thảo luận" disabled></textarea>
                <?php endif; ?>
                    <div id="listComment"></div>    
                <?php if($demComment > 30) : ?>
                    <center id="load_comment_more"><a href="javascript:showComment(<?=$id?>)">Xem thêm bình luận <i class="fa fa-caret-down"></i></a></center>
                <?php endif; ?>

            </div>

        </div>

    </div>
</div>
<?php
$script =  '<script>$(function() { showComment('.$id.') })</script>';
require '../connect/footer.php';