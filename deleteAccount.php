<?php
require_once "autoload.php";
session_start();
if (!isset($_SESSION['client'])){
    header('Location: Connexion.php');
}
else{
    $customerBDD = new CustomerDAO(MaBD::getInstance());
    $_SESSION['client']->mail = "";
    $customerBDD->update($_SESSION['client']);
    unset($_SESSION['client']);
    $_SESSION['supp'] = 1;
    header('Location: index.php');
}
?>