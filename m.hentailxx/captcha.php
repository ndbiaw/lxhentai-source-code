<?php

$length  = $_GET["len"]?:5;
$md5     = md5(rand());
$text    = substr($md5,0,$length);
$captcha = imagecreatefrompng('captcha.png');
$font    = 5;

for($i=0;$i<20;$i++) {
    imageline( $captcha, rand(0,100), rand(0,100), rand(0,100),rand(0,100),rand(0,100000));
}
    
$image_width  = imagesx($captcha);
$image_height = imagesy($captcha);
$text_width   = imagefontwidth($font)*$length;
$text_height  = imagefontheight($font);
imagestring($captcha, $font, ($image_width-$text_width)/2 , ($image_height-$text_height)/2, $text, 0);

session_start();
$_SESSION['captcha'] = md5($text);
header("Content-type: image/png");
imagepng($captcha);
imagedestroy($captcha);