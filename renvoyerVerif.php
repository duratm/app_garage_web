<?php
require_once "autoload.php";
session_start();
$_SESSION['code_validation'] = rand(10000,99999);
$_SESSION['resend'] = 0;
header('Location: validation.php');
?>