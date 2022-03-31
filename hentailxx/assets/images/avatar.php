<?php

$id = intval($_GET['id']);

if(file_exists('../avatar/'.$id.'.jpg'))
    $path = '../avatar/'.$id.'.jpg';
else
    $path = 'avatar_default.jpg';

$fp = @fopen($path, "r");

if (!$fp) {
    echo 'Mở file không thành công';
}
else
{
    // Đọc file và trả về nội dung
    $data = fread($fp, filesize($path));
    echo $data;
}