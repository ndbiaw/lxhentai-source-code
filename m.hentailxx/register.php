<?php
/**
 * author : trint
 * modify code : 2020-04
 * phone : 098 406 3678
 */
require './connect/_con.php';
include './more/register.php';

$title = 'Đăng ký';
require './connect/header.php';
?>

<ul class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/" class="itemcrumb active" itemprop="item" itemtype="http://schema.org/Thing"><span itemprop="name">Trang chủ</span></a><meta itemprop="position" content="2"></li>        
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="//lxhentai.com/login.php" class="selectedcrumb">Đăng nhập</a></li>
</ul>
<form method="post">
    <div class="authForm">
        <h1 class="postname" style="color: #000">Đăng ký</h1>
        <div class="form-group">
            <label style="color: #000">Nick name</label>
            <input required name="username" type="text" class="form-control mb-2" placeholder="User Name" maxlength="25" value="<?= sanitize_xss($_POST['username'] ?? '') ?>">
            Tên hiển thị bắt buộc từ 5 - 25 ký tự, không có dấu cách và ký tự đặc biệt.
        </div>
        <div class="form-group">
            <label style="color: #000">Email</label>
            <input required name="email" type="email" class="form-control" placeholder="Email" value="<?= sanitize_xss($_POST['email'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label style="color: #000">Mật khẩu</label>
            <input required name="password" type="password" class="form-control" placeholder="Mật khẩu">
        </div>
        <div class="form-group">
            <label style="color: #000">Nhập lại mật khẩu</label>
            <input required name="repassword" type="password" class="form-control" placeholder="Mật khẩu">
        </div>
        <div class="form-group">
            <label><img src="captcha.php"></label>
            <input required name="code" type="text" class="form-control" placeholder="Mã xác nhận">
        </div>
        <div class="text-right" style="color: #000">
            Đã có tài khoản ? <a href="/login.php" style="margin-left: 10px">Đăng nhập</a>
        </div>
        <button class="btnLogin" type="submit" name="register">Đăng ký</button>
        <?= ($error ? '<div class="alert alert-danger mt-3">'.$error.'</div>' : '') ?>
    </div>
</form>

<?php
require './connect/footer.php';