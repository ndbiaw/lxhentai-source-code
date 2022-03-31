<?php 

if(!preg_match('/dashboard/', $_SERVER['REQUEST_URI']) && is_mobile()) {
  redirect('//m.lxhentai.com'.$_SERVER['REQUEST_URI']);
}

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
	<meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT">
  <meta http-equiv="Pragma" content="no-cache">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.0.0/css/swiper.min.css">
  <link rel="stylesheet" href="/assets/css/hentai.css?cache=s101" />
  <link rel="stylesheet" href="/assets/css/more.css?cache=s101" />
  <link href="/assets/webfont/css_font/css/all.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,400italic,700,700italic&amp;subset=latin,vietnamese" rel="stylesheet" type="text/css" />
	<?= $style ?>
	<script type="text/javascript">
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
      && location.href.search('m.lxhentai.com') == -1 && location.href.search('dashboard') == -1) 
    {
      location.href = document.URL.replace("www.","").replace("lxhentai.com", "m.lxhentai.com");
    }
	</script>
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
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v4.0"></script>
<div id="menuMobile">
  <div class="container" style="background:#141414">
    <form action="/story/search.php">
    <input class="form-control square" placeholder="Nhập từ khóa..." name="key">
    <div class="flexRow">
      <div style="flex:1">
        <select class="form-control m-0 w-100 mt-1" name="type">
          <option value="">Tìm theo tên truyện</option>
          <option value="tacgia">Tìm theo tác giả</option>
          <option value="doujinshi">Tìm theo Doujinshi</option>
        </select>
      </div>
      <div class="mt-1 ml-1">
        <button type="submit" class="m-0" type="submit"><i class="fa fa-search"></i></button>
      </div>
    </div>
    </form>
    <ul>
      <li><a href="/" <?= !$tab ? 'class="active"' : '' ?>>Trang chủ</a></li>
      <li><a href="/dashboard/?page=gallery" <?= $tab == 'gallery' ? 'class="active"' : '' ?>>Theo dõi</a></li>
      <li><a href="/dashboard/?page=history" <?= $tab == 'history' ? 'class="active"' : '' ?>>Lịch sử</a></li>
      <li><a href="/story/search.php?nangcao" <?= $tab == 'moreSearch' ? 'class="active"' : '' ?>>Tìm truyện nâng cao</a></li>
      <li onclick="$('#theloaiMob').toggle();"><a href="#" <?= $tab == 'category' ? 'class="active"' : '' ?>>Thể loại <i class="fa fa-caret-down fa-fw"></i></a></li>
    </ul>
    <div class="row" id="theloaiMob" style="display: none">
    <?php foreach(get_categories() as $v) : ?>
      <div class="col-6">
        <a href="/story/cat.php?id=<?= $v['id'] ?>" <?= $v['type']==='home' ? 'style="color:#e74c3c!important;font-weight:bold"' : '' ?>><?= $v['name'] ?></a>
      </div>
    <?php endforeach; ?>  
    </div>
    <ul>
      <?php if(!$my) : ?>
        <li><a href="/login.php" class="normal">Đăng nhập</a></li>
        <li><a href="/register.php" class="normal">Đăng ký</a></li>
      <?php else : ?>
        <li><a href="/dashboard/?page=uploaded"><i class="fa fa-upload fa-fw"></i> Upload truyện</a></li>
        <li><a href="/dashboard/?page=gallery"><i class="fa fa-bookmark fa-fw"></i> Bộ Sưu Tập</a></li>
        <li><a href="/logout.php"><i class="fa fa-sign-out-alt fa-fw"></i> Đăng xuất</a></li>
      <?php endif; ?>
    </ul>
  </div>
</div>

<header class="_header">
  <div class="container">
    <div class="_headerFlex">
      <div class="headerLogo">
        <a href="/"><img src="/assets/images/logo2.png" width="130px" /></a>
      </div>
      <form action="/story/search.php"  class="headerSearchBar">

        <input name="key" type="text" class="form-control ml-3 hide-mob" placeholder="Nhập từ khóa...">
        <select class="hide-mob" name="type">
          <option value="">Tên truyện</option>
          <option value="tacgia">Tác giả</option>
          <option value="doujinshi">Doujinshi</option>
        </select>
        <button class="hide-mob" type="submit"><i class="fa fa-search"></i></button>
        
        <div class="noti">
          <?php $total = $my ? alert_new_total($my['id']) : 0; ?>
          <i onclick="window.location.href='/dashboard/'" class="fa fa-comment <?= $total ? 'active' : '' ?>"></i>
        </div>

      </form>
      <div class="headerUserBar">
        <?php if ($my) : ?>
          <div class="hide-mob relative">
            <a href="/dashboard/">Hi, <?= $my['username'] ?> <i class="fa fa-caret-down"></i></a>
            <div class="userPanel">
            <ul>
              <a href="/dashboard/"><li><i class="fa fa-user fa-fw"></i> Trang cá nhân</li></a>
              <a href="/dashboard/index.php?page=uploaded"><li><i class="fa fa-upload fa-fw"></i> Upload truyện</li></a>
              <a href="/dashboard/index.php?page=gallery"><li><i class="fa fa-bookmark fa-fw"></i> Bộ Sưu Tập</li></a>
              <a href="/logout.php"><li><i class="fa fa-sign-out-alt fa-fw"></i> Đăng xuất</li></a>
            </ul>
            </div>
          </div>
        <?php else : ?>
          <div class="hide-mob"><a href="/login.php">Đăng nhập</a> / <a href="/register.php">Đăng ký</a></div>
        <?php endif; ?>        
        <div class="show-mob">
          <i onclick="window.location.href='/story/search2.php'" class="fa fa-search"></i>  
          <i class="fa fa-bars" onclick="showMenu(this)"></i><i class="fa fa-times" onclick="hideMenu(this)"></i>  
        </div>
      </div>
    </div>
  </div>
</header>

<div class="_navbar hide-mob">
  <div class="container">
    <div class="_navbarFlex">
      <div <?= !$tab ? 'class="active"' : '' ?>><a href="/"><i class="fa fa-home"></i></a></div>
      <div <?= $tab == 'gallery' ? 'class="active"' : '' ?>><a href="/dashboard/?page=gallery">Theo dõi</a></div>
      <div <?= $tab == 'history' ? 'class="active"' : '' ?>><a href="/dashboard/?page=history">Lịch sử</a></div>
      <div id="theloai" <?= $tab == 'category' ? 'class="active"' : '' ?>>
      Thể loại <i class="fa fa-caret-down" style="margin-left: 5px"></i>
        <div id="showTheLoai" class="pt-2">
        <ul class="row">
          <?php foreach(get_categories() as $v) : ?>
            <li class="col-sm-3">
              <a href="/story/cat.php?id=<?= $v['id'] ?>" <?= $v['type']==='home' ? 'style="color:#e74c3c!important; font-weight: bold;"' : '' ?>><?= $v['name'] ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
        </div>
      </div>
      <div <?= $tab=='moreSearch' ? 'class="active"' : '' ?>><a href="/story/search2.php">Tìm truyện nâng cao</a></div>
    </div>
  </div>
</div>

<main class="main">
  <div class="container p-15 bg-white" id="mainpage">
    <div class="text-center mb-2">
        <div>
            <a href="https://bit.ly/lxhentai-bong90-pc-top-1" target="_blank" rel="nofollow"><img src="//lxhentai.com/banners/728x90-bong90.gif" alt="PC Top Banner"></a>
        </div>
    </div>  
