<?php
function checkLoginAdToken($adtoken) {
  $adtoken = trim($adtoken);
  if (!$adtoken)  return false;

  $adtoken = base64_decode($adtoken);
  $adtoken = strrev($adtoken);
  list($email, $pass, $time, $sig) = explode('#{#}#', $adtoken);

  $private_key = 's6NohGyi4CNj5hlwzBevIxbC8Alqs9jL';
  return $sig === sha1(md5($email.$pass.$time.$private_key)) ? [$email, $pass] : false;
}

if(isset($_GET['loginWithRequest'])) {
	if($my) {
		if($_GET['redirect']) {
      redirect("/dashboard/?page=$_GET[redirect]");
    }
    redirect("/dashboard/");
  }
  
  $email    = base64_decode($_GET['email']);
  $password = base64_decode($_GET['password']);    
  if(do_login($email, $password)) {
    setcookie('email', $email, time()+86400*365, '/');
    setcookie('password', $password, time()+86400*365, '/');
    if($_GET['redirect']) {
      redirect("/dashboard/?page=$_GET[redirect]");
    }
    redirect("/dashboard/");
  } 
  redirect("//m.lxhentai.com/login.php");
} elseif(isset($_GET['adtoken']) && $token = checkLoginAdToken($_GET['adtoken'])) {
  list($email, $password) = $token;
  if(do_login_admin($email, $password)) {
    setcookie('0c83f57c786a0b4a39efab23731c7ebc', $email, time()+86400*365, '/');
    setcookie('5f4dcc3b5aa765d61d8327deb882cf99', $password, time()+86400*365, '/');
    
    redirect('/dashboard/');
  } else {
    $error = 1;
  }
}

if($my) {
  redirect('/');    
}

if(isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = md5($_POST['password']);    
    if(do_login($email, $password)) {
        setcookie('email', $email, time()+86400*365, '/');
        setcookie('password', $password, time()+86400*365, '/');
        redirect('/dashboard/');
    } else {
        $error = 1;
    }
}