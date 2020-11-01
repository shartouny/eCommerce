<?php
include 'connect.php';
//Routes

$tpl    = "admin/includes/templates/";  // Template directory
$css    = "admin/layout/css/" ;         // css directory
$js     = "admin/layout/js/";           //js directory
$lang   = "admin/includes/languages/";  //laguages directory
$fun    = "admin/includes/functions/";  //function directory
// include the important files
include $fun  . "myFunction.php";
include $lang . "english.php";
include $tpl  . "header.inc.php";

// include navbar on all pages except the one with no navbar variables

if(!isset($noNavbar)){ include  $tpl . "navbar.inc.php"; }