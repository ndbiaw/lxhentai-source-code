<?php
error_reporting(0);
define('ROOT', dirname(__DIR__));

include __DIR__.'/function.php';

ob_start();
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

connect_mysql();
connect_redis();

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

// foreach($_POST as $key => $value) {
// 	if(!is_array($_POST[$key]) && $key != 'html') {
//         $_POST[$key] = htmlspecialchars(str_replace("'","''",trim($_POST[$key])));
//     }		
// }