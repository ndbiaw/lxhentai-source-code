<?php
/**
 * author : trint
 * modify code : 2020-04
 * phone : 098 406 3678
 */
require './connect/_con.php';
include './more/login.php';

$title = 'Đăng nhập';
require './connect/header.php';
?>
<ul class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
  <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/" class="itemcrumb active" itemprop="item" itemtype="http://schema.org/Thing"><span itemprop="name">Trang chủ</span></a><meta itemprop="position" content="2"></li>
  <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/login.php" class="selectedcrumb">Đăng nhập</a></li>
</ul>
<form method="post">
<div class="authForm">
  <h1 class="postname" style="color: #000">Đăng nhập</h1>
  <div class="form-group">
    <label style="color: #000">Email</label>
    <input required name="email" type="email" class="form-control" placeholder="Email">
  </div>
    <div class="form-group">
    <label style="color: #000">Mật khẩu</label>
    <input required name="password" type="password" class="form-control" placeholder="Mật khẩu">
  </div>
  <input type="checkbox" name="remember" id="remember"> <label for="remember" style="color: #000">Ghi nhớ</label>
  <div class="text-right" style="color: #000">
    <a href="/register.php" style="margin-left: 10px">Đăng ký mới</a>
  </div>
  <button class="btnLogin" type="submit" name="login">Đăng nhập</button>
  <?= $error ? '<div class="alert alert-danger mt-3">Sai tài khoản hoặc mật khẩu !</div>' : '' ?>
</div>
</form>

<?php
require './connect/footer.php';