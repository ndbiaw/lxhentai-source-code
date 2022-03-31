<?php
/**
 * author : trint
 * modify code : 2020-04
 * phone : 098 406 3678
 */
require './connect/_con.php';
include './more/index.php';

require './connect/header.php';
?>
<iframe src="https://www3.cbox.ws/box/?boxid=3447586&boxtag=2nsh5p" width="100%" height="380" allowtransparency="yes" allow="autoplay" frameborder="0" marginheight="0" marginwidth="0" scrolling="auto"></iframe>	
<?= swiper_html() ?>

<div class="row mt-2">
  <div class="col-md-8">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item">
          <a class="nav-link active" id="pills-new-tab" data-toggle="pill" href="#pills-new" role="tab" aria-controls="pills-new" aria-selected="true" onclick="home('new')">Truyện Mới</a>
      </li>
      <?php foreach(categories_home() as $v) : ?>
      <li class="nav-item">
        <a class="nav-link" onclick="home(<?= $v['id'] ?>)" id="pills-<?= $v['id'] ?>-tab" data-toggle="pill" href="#pills-<?= $v['id'] ?>" role="tab" aria-controls="pills-<?= $v['id'] ?>" aria-selected="false"><?= sanitize_xss($v['name']) ?></a>
      </li>
      <?php endforeach; ?>  
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab">
        <div class="row"><?= story_duyet_60_html() ?></div>
      </div>
      <?php foreach(categories_home() as $v) : ?>
      <div class="tab-pane fade" id="pills-<?= $v['id'] ?>" role="tabpanel" aria-labelledby="pills-<?= $v['id'] ?>-tab">
        <div class="row" style="min-height: 1000px;"></div>
      </div>
      <?php endforeach; ?>    
    </div>
    <div class="text-right my-2"><a href="/story/" id="home_more">Xem thêm »</a></div>
  </div>
  <div class="col-md-4">
    <div class="darkbox">
      <h2>Fanpage</h2>
      <div class="fb-page" data-href="https://www.facebook.com/Shoplxer/" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Shoplxer/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Shoplxer/">Cộng Đồng Lxer</a></blockquote></div>
    </div>
    <div class="darkbox mh1200 mt-3">
    <h2>Bình luận mới</h2>
    <?= comment_html() ?>
    </div>
    <div class="darkbox"><iframe width="100%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/playlists/1040835757&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/phong-hoang-410857208" title="phong hoang" target="_blank" style="color: #cccccc; text-decoration: none;">phong hoang</a> · <a href="https://soundcloud.com/phong-hoang-410857208/sets/great-music" title="Great Music" target="_blank" style="color: #cccccc; text-decoration: none;">Great Music</a></div></div>
  </div>
</div>
<?php
require './connect/footer.php';
