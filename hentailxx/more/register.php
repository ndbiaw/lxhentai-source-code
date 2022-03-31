<?php

if($my) {
    redirect('/');
}

if(isset($_POST['register'])) {
    $email    = $_POST['email'];
    $password = md5($_POST['password']);

    if(md5($_POST['code']) != $_SESSION['captcha']) {
        $error = 'Mã bảo mật sai !';
    } elseif(strlen($_POST['username']) < 5 || !preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
        $error = 'Tên đăng nhập không hợp lệ !';
    } elseif($_POST['password'] != $_POST['repassword']) {
        $error = 'Mật khẩu nhập lại không đúng !';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ !';
    }

    if(!$error) {
        $email    = mysqli_real_escape_string($conn, $_POST['email']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $check = query_mysql("select id from users where email = '{$email}' or username = '{$username}'", true);        
        if(!$check) {
            $time = time();
            $insert = "insert into users (username, email, password, time, rights, ban) values ('{$username}', '{$email}', '{$password}', {$time}, '', 0)";
            mysqli_query($conn, $insert) or die('error');
            cache_delete('users'); 
            setcookie('email', $email, time()+86400*365, '/');
            setcookie('password', $password, time()+86400*365, '/');
            
            redirect('/dashboard/');
        } else {
            $error = 'Tài khoản hoặc Email đã tồn tại !';
        }
    }
}