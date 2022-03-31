<?php 
$title    = $title ?? 'Đọc truyện tranh, truyện Online hay có tại Hentailxx.com';
$desc     = $desc ?? 'đọc truyện tranh các bạn có thể đọc truyện online hay mới nhất, cập nhật liên tục đọc truyện online, truyện hot nhất hiện nay tại Hentaillx.com';
$keywords = $keywords ?? 'đọc truyện, doc truyen, doc truyen tranh, truyen hay';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $title ?></title>
  <meta name="keywords" content="'<?= $keywords ?>">
  <meta name="description" content="<?= $description ?>">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.0.0/css/swiper.min.css">
  <link rel="stylesheet" href="//lxhentai.com/assets/css/hentai.css?cache=s101" />
  <link rel="stylesheet" href="//lxhentai.com/assets/css/hentai_mob.css?cachex=zsda" />
  <link href="//m.lxhentai.com/assets/webfont/css_font/css/all.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,400italic,700,700italic&amp;subset=latin,vietnamese" rel="stylesheet" type="text/css" />
	<?= $style ?>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-144652877-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-144652877-1');
  </script>
<style type="text/css">
.sticky-footer{position:fixed;bottom:0;z-index:999;width:100%}
.second-sticky-footer { bottom: 50px; }
.third-sticky-footer { bottom: 100px; }
.four-sticky-footer { bottom: 150px; }
.second-pc-sticky-footer { bottom: 90px; }
.third-pc-sticky-footer { bottom: 180px; }
.sticky-footer-content{margin-left:auto;margin-right:auto;width:320px;position:relative}
.sticky-pc-footer-content{width: 728px}
.sticky-x-button{position:absolute;left:10px!important;top:-15px!important;font-size:16px;color:#222;cursor:pointer;background:#fff;border-radius:50%;padding:4px 9px}
.sticky-x-button-top{top: auto !important;bottom: -15px !important;}
.top-sticky-one{top: 0 !important;bottom: auto;}
.top-sticky-two{top: 50px !important;bottom: auto;}
.left-balloon {position: fixed; bottom: 0; left: 0; width: 300px; height: 250px; z-index: 999;}
.x-left-balloon {position: fixed; left: 0; bottom: 224px; display: block; background: #222; color: #fff; cursor: pointer; padding: 3px 10px;}
.right-balloon {position: fixed; bottom: 0; right: 0; width: 300px; height: 250px; z-index: 999;}
.x-right-balloon {position: fixed; right: 0; bottom: 224px; display: block; background: #222; color: #fff; cursor: pointer; padding: 3px 10px;}
.float-left {position: fixed; top: 0; left: 0; width: 120px; height: 600px; z-index: 999;}
.x-float-left {position: fixed; left: 0; top: 0; display: block; background: #222; color: #fff; cursor: pointer; padding: 3px 10px;}
.float-right {position: fixed; top: 0; right: 0; width: 120px; height: 600px; z-index: 999;}
.x-float-right {position: fixed; right: 0; top: 0; display: block; background: #222; color: #fff; cursor: pointer; padding: 3px 10px;}
#banner-float-left {position: fixed; top: 0; left: 0; z-index: 999;}
.close-float-left {position: fixed; left: 0; top: 0; display: block; background: #222; color: #fff; cursor: pointer; padding: 3px 10px; width: 120px; text-align: center;}
#banner-float-right {position: fixed; top: 0; right: 0; z-index: 999;}
.close-float-right {position: fixed; right: 0; top: 0; display: block; background: #222; color: #fff; cursor: pointer; padding: 3px 10px; width: 120px; text-align: center;}
#banner-float-left img, #banner-float-right img {margin-top: 25px}
.preload-modal {width:auto;max-width:530px;margin:65px auto 0}
.mobile-preload-modal {width:auto;max-width:330px;margin:65px auto 0}
mark { background-color: yellow; }
</style>
</head>
<body>
<div class="menu_mob" style="z-index: 3">
  <div class="menu_2light flexRow">
    <div><img class="menu_avatar" src="//lxhentai.com/assets/images/avatar.php?id=<?=$uid?>"></div>
    <div class="px-0 flex1">Xin chào,<br/><?= $uid ? $my['username'] : 'Khách' ?></div>
    <div class="text-right"><i class="fa fa-times fa-fw" style="background: transparent" onclick="$('.menu_mob').toggle()"></i></div>
  </div>
<?php if(!$uid) : ?>
  <a href="/login.php">Đăng Nhập</a>
  <a href="/register.php">Đăng Ký</a>
<?php else : ?>
  <a href="//lxhentai.com/login.php?loginWithRequest&email=<?=base64_encode($my['email'])?>&password=<?=base64_encode($my['password'])?>"><i class="fa fa-bell fa-fw"></i> Thông Báo ( <span class="fa-red"><?=alert_new_total($my['id'])?></span> )</a>
  <a href="//lxhentai.com/login.php?loginWithRequest&email=<?=base64_encode($my['email'])?>&password=<?=base64_encode($my['password'])?>&redirect=uploaded"><i class="fa fa-upload fa-fw"></i> Upload Truyện</a>
  <a href="/logout.php"><i class="fa fa-sign-out fa-fw"></i> Đăng Xuất</a>
<?php endif; ?>
  <div class="menu_2light">HENTAILXX.COM</div>
  <a href="/"><i class="fa fa-home fa-fw"></i> Trang Chủ</a>
  <a href="https://www.facebook.com/Shoplxer/" target="_blank"><i class="fab fa-facebook-square fa-fw"></i> Bán Truyện Hentai</a>
  <a href="//lxhentai.com/login.php?loginWithRequest&email=<?=base64_encode($my['email'])?>&password=<?=base64_encode($my['password'])?>&redirect=gallery"><i class="fa fa-fw fa-bookmark"></i> Bộ Sưu Tập ( <span class="fa-red"><?=story_follow_total_by_uid($uid)?></span> )</a>
  <a href="//lxhentai.com/login.php?loginWithRequest&email=<?=base64_encode($my['email'])?>&password=<?=base64_encode($my['password'])?>&redirect=history"><i class="fa fa-undo fa-fw"></i> Lịch Sử Xem</a>
  <a href="/story/search2.php"><i class="fa fa-search fa-fw"></i> Tìm Kiếm Nâng Cao</a>
  <div class="menu_2light"><i class="fa fa-fw fa-tags"></i> Thể Loại Truyện</div>
  <?php foreach(get_categories() as $v) : ?>
    <a href="/story/cat.php?id=<?=$v['id']?>" style="width:49%;display:inline-block"><?=$v['name']?></a>
  <?php endforeach; ?>  
</div>

<div id="mainContent">
<?php if(!$viewChapter) : ?>
  <div class="header" style="z-index:2">
    <div class="px-2" onclick="$('.menu_mob').toggle()"><i class="fa fa-bars"></i></div>
    <div class="flex1"><a href="/">HENTAILXX</a></div>
    <div></div>
  </div>
<?php else : ?>
  <div class="header">
    <div onclick="window.location.href='<?=$viewChapter?>'" class="px-2"><i class="fal fa-angle-left" aria-hidden="true"></i></div>
    <div class="flex1"><a href="/">HENTAILXX</a></div>
    <div onclick="$('.menu_mob').toggle()" class="px-2"><i class="fa fa-bars"></i></div>
  </div>
<?php endif; ?>

  <div class="container">
    <form action="/story/search.php">
      <div class="search_mob my-2 bg-white">
        <div class="flex1"><input name="key" class="w-100" placeholder="Tìm kiếm truyện..." required></div>
        <div style="width: 25%; border-left: 1px solid #f2f2f2;"><select class="w-100"><option value="">Tên truyện</option><option value="tacgia">Tác giả</option><option value="doujinshi">Doujinshi</option></select></div>
        <div style="width: 20%"><button type="submit" class="w-100 text-center"><i class="fa fa-search"></i></button></div>
      </div>
    </form>
  </div>

  <div class="text-center"><a href="https://bit.ly/lxhentai-b29" target="_blank"><img src="//lxhentai.com/banners/320x50-b29.gif" alt="Top 1"></a></div>
  <div class="text-center"><a href="https://bit.ly/lxhentai-bong90-mobile-top-2" target="_blank"><img src="//lxhentai.com/banners/320x50-bong90.gif" alt="Top 2"></a></div>
  <div class="text-center"><a href="http://bit.ly/lxhentai-bongdax-home" target="_blank"><img src="//lxhentai.com/banners/bongda-320x50.gif" alt="Top 3"></a></div>

  <div <?=!$viewChapter?'class="bg-white mt-2 py-2"':''?>>
    <div class="container">
      <div class="alert alert-warning" style="font-size: x-large"><i class="fa fa-bomb fa-fw"></i> AI THẤY TRUYỆN DIE THÌ HÃY GỬI LINK Ở CHATBOX  HAY COMMENT BÊN DƯỚI ĐỂ ĐƯỢC SỬA!</div>
 
