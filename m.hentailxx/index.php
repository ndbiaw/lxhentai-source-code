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

<?=swiper_html()?>

<div class="container">
  <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
    <li class="nav-item mob">
      <a class="nav-link active" id="pills-new-tab" data-toggle="pill" href="#pills-new" role="tab" aria-controls="pills-new" aria-selected="true" onclick="home('new')">Mới</a>
    </li>
    <?php foreach(categories_home() as $get) : ?>
      <?php if(in_array($get['id'], [61,12,45])) : ?>
        <li class="nav-item mob">
          <a class="nav-link" onclick="home(<?=$get['id']?>, true)" id="pills-<?=$get['id']?>-tab" data-toggle="pill" href="#pills-<?=$get['id']?>" role="tab" aria-controls="pills-<?=$get['id']?>" aria-selected="false" style="padding: 0"><?=sanitize_xss(str_replace('Truyện', '', $get['name']))?></a>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>  
  </ul>

  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab">
      <div class="row"><?=story_duyet_60_html()?></div>
    </div>    
    <?php foreach(categories_home() as $get) : ?>
      <div class="tab-pane fade" id="pills-<?=$get['id']?>" role="tabpanel" aria-labelledby="pills-<?=$get['id']?>-tab">
        <div class="row" style="min-height: 1000px;"></div>
      </div>
    <?php endforeach; ?>    
  </div>

  <div class="text-right my-2">
    <a href="/story/" id="home_more">Xem thêm »</a>
  </div>

</div>
<?php
require './connect/footer.php';