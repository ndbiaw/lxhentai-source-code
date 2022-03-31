<?php

require './connect/_con.php';

session_destroy();
setcookie('email', '', time()-1, '/');
setcookie('password', '', time()-1, '/');

setcookie('0c83f57c786a0b4a39efab23731c7ebc', '', time()-1, '/');
setcookie('5f4dcc3b5aa765d61d8327deb882cf99', '', time()-1, '/');

close_mysql();
close_redis();

redirect('/');