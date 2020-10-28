<?php
include 'connect.php';
//Routes

$tpl    = "includes/templates/";  // Template directory
$css    = "layout/css/" ;         // css directory
$js     = "layout/js/";           //js directory
$lang   = "includes/languages/";  //laguages directory
$fun    = "includes/functions/";  //function directory

// include the important files
include $fun  . "myFunction.php";
include $lang . "english.php";
include $tpl  . "header.inc.php";

// include navbar on all pages except the one with no navbar variables

if(!isset($noNavbar)){ include  $tpl . "navbar.inc.php"; }