<?php

require './connect/_con.php';

session_destroy();
setcookie('email', '', time()-1, '/');
setcookie('password', '', time()-1, '/');

close_mysql();
close_redis();

redirect('/');