<?php

if($my) {
  redirect('/');    
}

if(isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = md5($_POST['password']);    
    if(do_login($email, $password)) {
        setcookie('email', $email, time()+86400*365, '/');
        setcookie('password', $password, time()+86400*365, '/');
        redirect('/');
    } else {
        $error = 1;
    }
}