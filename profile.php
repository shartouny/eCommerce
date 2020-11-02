<?php
    session_start();
    $pageTitle= $_SESSION['user'] .' | Profile';
    include 'init.php';
?>
<h1 class="text-center">My Profile</h1>
<div class="information block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Information</div>
            <div class="panel-body">name : osama</div>
        </div>
    </div>
</div>
<div class="my-ads block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Ads</div>
            <div class="panel-body">name : osama</div>
        </div>
    </div>
</div>
<div class="my-cmnts block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Comments</div>
            <div class="panel-body">name : osama</div>
        </div>
    </div>
</div>