<?php
error_reporting(0);
define('ROOT', dirname(__DIR__));

include __DIR__.'/function.php';

ob_start();
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

connect_mysql();
connect_redis();

// login = admin
$email = $_COOKIE['0c83f57c786a0b4a39efab23731c7ebc'];
$pass  = $_COOKIE['5f4dcc3b5aa765d61d8327deb882cf99'];
if($email && $pass) {    
    $my = do_login_admin($email, $pass);    
    if (!$my) {
        setcookie('0c83f57c786a0b4a39efab23731c7ebc', '', time()-1, '/');
        setcookie('5f4dcc3b5aa765d61d8327deb882cf99', '', time()-1, '/');
        redirect('/');
    } else {
        if($my['ban']) {
            redirect('https://www.google.com/');            
        }
        $uid = $my['id'];
    }
}

// login = user
if (!$my) {
    $email = $_COOKIE['email'];
    $pass  = $_COOKIE['password'];
    if($email && $pass) {    
        $my = do_login($email, $pass);
        if (!$my) {
            setcookie('email', '', time()-1, '/');
            setcookie('password', '', time()-1, '/');
            redirect('/');
        } else {
            if($my['ban']) {
                redirect('https://www.google.com/');            
            }
            $uid = $my['id'];
        }
    }
}

// foreach($_POST as $key => $value) {
// 	if(!is_array($_POST[$key]) && $key != 'html') {
//         $_POST[$key] = htmlspecialchars(str_replace("'","''",trim($_POST[$key])));
//     }		
// }
