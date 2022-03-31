<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
echo "Your \$_SESSION['name'] var is ".$_SESSION['name'];
exit();
?>
