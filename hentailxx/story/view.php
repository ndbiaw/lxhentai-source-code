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
    <div class="col-md-12">
        <ul class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">    
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/" class="itemcrumb active" itemprop="item" itemtype="http://schema.org/Thing"><span itemprop="name">Trang chủ</span></a><meta itemprop="position" content="2"></li>
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/story/" class="selectedcrumb">Danh sách truyện</a></li>
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/story/view.php?id=<?=$id?>" class="selectedcrumb"><?=sanitize_xss($getStory['name'])?></a></li>
        </ul>
    </div>    
    <div class="col-md-8" style="color:#333">
        <div class="text-center mb-3">
            <?php if (!$getStory['duyet']) : ?>
                <h3 style="color:red"><i class="fa fa-clock fa-fw"></i> Truyện đang chờ duyệt...</h3>
            <?php endif; ?>            
            <h1 class="title-detail" style="color:#fff"><?=sanitize_xss($getStory['name'])?></h1>
            <time class="small">[Cập nhật lúc: <?=date('H:i d/m/Y', $newest['time'] ?: $getStory['time'])?>]</time>
        </div>
        <div class="row">
            <div class="col-md-4 text-center" style="align-self: center"><img src="/assets/hentai/<?=$getStory['thumb']?>.jpg" width="175px" height="275px" style="border: 1px solid #ddd" /></div>
            <div class="col-md-8" style="font-size: 16px;">
                <div class="row mt-2" style="color: #777676;line-height: 27px;">
                    <div class="col-4 py-1"><i class="fa fa-paint-brush-alt"></i> Tác giả</div>
                    <div class="col-8 py-1" style="color:#fff"><?=$getStory['authors'] ? ($authors) : 'Đang cập nhật'?></div>

                    <div class="col-4 py-1"><i class="fa fa-rss"></i> Tình trạng</div>
                    <div class="col-8 py-1"><?=$getStory['status'] ? '<font color=#e74c3c>Đã hoàn thành</font>' : 'Đang tiến hành'?></div>

                    <div class="col-4 py-1"><i class="fa fa-tags"></i> Thể loại</div>
                    <div class="col-8 py-1" style="color:#fff"><?=$theloai?></div>

                    <div class="col-4 py-1"><i class="fa fa-user"></i> Thực hiện</div>
                    <div class="col-8 py-1" style="color:#fff"><?=sanitize_xss($getStory['thuchien'] ?: 'Đang cập nhật')?></div>

                    <div class="col-4 py-1"><i class="fa fa-users"></i> Nhóm dịch</div>
                    <div class="col-8 py-1" style="color:#fff"><?=sanitize_xss($getStory['nhomdich'] ?: 'Đang cập nhật')?></div>

                    <div class="col-4 py-1"><i class="fa fa-poo"></i> Doujinshi</div>
                    <div class="col-8 py-1" style="color:#fff"><?=$getStory['doujinshi'] ? ($doujinshis) : 'Rỗng'?></div>

                    <div class="col-4 py-1"><i class="fa fa-eye"></i> Lượt xem</div>
                    <div class="col-8 py-1" style="color:#fff"><?=number_format($getStory['view'])?></div>
                </div>

                <div class="flexRow mt-2 mb-3">
                    <div>
                        <button onclick="user_follow_story(<?=$id?>)" class="btn btn-success" id="story_follow_btn" <?=$checkFollow ? 'style="display: none; white-space: nowrap"' : 'style="white-space: nowrap;"'?>><i class="fa fa-heart fa-fw"></i> Theo dõi</button>
                        <button onclick="user_follow_story(<?=$id?>)" class="btn btn-warning" id="story_unfollow_btn" <?=!$checkFollow ? 'style="display: none; white-space: nowrap"' : 'style="white-space: nowrap;"'?>><i class="fa fa-times-circle fa-fw"></i> Bỏ theo dõi</button>
                    </div>
                    <div class="pl-3" style="align-self: center;"><b id="story_follow_count"><?=story_follow_total($id)?></b> Người Đã Theo Dõi<br/><small>Theo dõi để nhận thông báo khi ra chương mới.</small></div>
                </div>

                <a class="btn btn-info text-white" href="/story/chapter.php?id=<?=$oldest['id']?>">Đọc từ đầu</a>
                <a class="btn btn-info text-white" href="/story/chapter.php?id=<?=$newest['id']?>">Đọc mới nhất</a>
            </div>
        </div>

        <div class="detail-content mt-4">
            <h3 class="list-title"><i class="fa fa-info-circle fa-fw"></i> GIỚI THIỆU TRUYỆN</h3>
            <p style="font-size: 16px;"><?=sanitize_xss($getStory['intro'] ?: 'Truyện này chưa có mô tả.')?></p>
        </div>

        <div class="detail-content mt-3" style="overflow: hidden">
            <h3 class="list-title"><i class="fa fa-list fa-fw"></i> DANH SÁCH CHƯƠNG</h3>
            <div id="listChuong">
                <ul style="overflow: hidden">
                    <li class="row" style="border-bottom: 1px dashed #ddd; padding: 5px 0 10px; font-size: 16px;">
                        <div class="col-5">Số chương</div>
                        <div class="text-center col-4">Cập nhật</div>
                        <div class="text-center col-3 nowrap">Lượt xem</div>
                    </li>
                    <?=$listChuong?>
                </ul>
            </div>
            <?php if(count($queryChuong)+1 > 15) : ?>
            <a class="viewmore mt-2" href="javascript:viewmore()"><i class="fa fa-plus"></i> Xem thêm</a>
            <?php endif; ?>
            <div class="detail-content mt-3">
                    <h3 class="list-title"><i class="fa fa-comments fa-fw"></i> BÌNH LUẬN <b style="float: right" id="count_comment" class="badge badge-danger px-2"><?=$demComment?></b></h3>
                <?php if ($my['id']) : ?>
                    <div class="smileys" id="smile_original"><?=smileys_view()?></div>
                    <form onsubmit="postBigComment(event, <?=$id?>)">
                        <textarea id="bigComment" required class="comment" placeholder="Mời bạn thảo luận, vui lòng nhập Tiếng Việt có dấu"></textarea>
                        <div class="text-right">
                            <a href="javascript:void(0)" class="btn btn-light" onclick="$('#smile_original').toggle()"><i class="fal fa-smile fa-fw"></i></a> 
                            <button class="btn btn-primary" type="submit">Gửi Bình Luận</button>
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
    <div class="col-md-4">
        <div class="darkbox">
            <h2><?=$getStory['authors'] ? 'TRUYỆN CÙNG TÁC GIẢ' : 'CÓ THỂ BẠN THÍCH'?></h2>
            <?=stories_like_view()?>    
        </div>
    </div>
</div>
<?php
$script =  '<script>$(function() { showComment('.$id.') })</script>';
require '../connect/footer.php';