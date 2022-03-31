<?php
class SimpleImage {
    var $image;
    var $image_type;
    function load($filename) {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if( $this->image_type == IMAGETYPE_JPEG ) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif( $this->image_type == IMAGETYPE_GIF ) {
            $this->image = imagecreatefromgif($filename);
        } elseif( $this->image_type == IMAGETYPE_PNG ) {
            $this->image = imagecreatefrompng($filename);
        }
    }
    function save($filename, $image_type=IMAGETYPE_JPEG, $compression=100, $permissions=null) {
        if( $image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image,$filename,$compression);
        } elseif( $image_type == IMAGETYPE_GIF ) {
            imagegif($this->image,$filename);
        } elseif( $image_type == IMAGETYPE_PNG ) {
            imagepng($this->image,$filename);
        }
        if( $permissions != null) {
            chmod($filename,$permissions);
        }
    }
    function output($image_type=IMAGETYPE_JPEG) {
        if( $image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image);
        } elseif( $image_type == IMAGETYPE_GIF ) {
            imagegif($this->image);
        } elseif( $image_type == IMAGETYPE_PNG ) {
            imagepng($this->image);
        }
    }
    function getWidth() {
        return imagesx($this->image);
    }
    function getHeight() {
        return imagesy($this->image);
    }
    function resizeToHeight($height) {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width,$height);
    }
    function resizeToWidth($width) {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width,$height);
    }
    function scale($scale) {
        $width = $this->getWidth() * $scale/100;
        $height = $this->getheight() * $scale/100;
        $this->resize($width,$height);
    }
    function resize($width,$height) {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }
}

function alias($url, $dot = false) {
    $a = array(
        '/[.]/',
        '/-/',
        '/\s/',
        '/a|á|ả|ạ|ã|ă|ắ|ằ|ẳ|ặ|ẵ|â|ấ|ầ|ẩ|ậ|ẫ|à/i',
        '/đ/i',
        '/e|é|è|ẻ|ẹ|ẽ|ê|ế|ề|ể|ệ|ễ/i',
        '/í|ì|ỉ|ị|ĩ/i',
        '/o|ó|ò|ỏ|ọ|õ|ô|ố|ồ|ổ|ộ|ỗ|ơ|ớ|ờ|ở|ợ|ỡ/i',
        '/u|ú|ù|ủ|ụ|ũ|ư|ứ|ừ|ử|ự|ữ/i',
        '/y|ý|ỳ|ỷ|ỵ|ỹ/i'
    );
    $b = array(
        '_',
        '',
        '-',
        'a',
        'd',
        'e',
        'i',
        'o',
        'u',
        'y'
    );
    if($dot)
        $b[0] = 'o';
    $url = str_replace('à', 'a', $url);
    $url = mb_strtolower($url,'UTF-8');
    $url = preg_replace($a, $b, $url);
    $url = str_replace('--', '-', $url);
    $url = preg_replace('/[-]$/', '', $url);
    
    $url = preg_replace("/[^a-zA-Z0-9-]+/", "", $url);
    return $url;
}