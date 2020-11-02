<?php
include 'connect.php';
//Routes

$tpl            = "includes/templates/";  // Template directory
$css            = "layout/css/" ;         // css directory
$js             = "layout/js/";           //js directory
$lang           = "includes/languages/";  //laguages directory
$front_fun      = "includes/functions/";  //function directory
$bk_fun         = "admin/includes/functions/";  //function directory
// include the important files
include $front_fun  . "front_myFunction.php";
include $bk_fun  . "bk_myFunction.php";
include $lang . "english.php";
include $tpl  . "header.inc.php";

// include navbar on all pages except the one with no navbar variables

if(!isset($noNavbar)){ include  $tpl . "navbar.inc.php"; }