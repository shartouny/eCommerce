<?php
    session_start();
    include 'init.php';
    $pageTitle= $sessionUser .' | Profile';
    if(isset($_SESSION['user'])){

    $getUser = $con->prepare('SELECT * FROM users WHERE Username = ?');
    $getUser->execute(array($sessionUser));
    $userInfo = $getUser->fetch();
    
?>
<h1 class="text-center">My Profile</h1>
<div class="information block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Information</div>
            <div class="panel-body">
                Name : <?php echo $userInfo['FullName'] ?> </br>
                Email : <?php echo $userInfo['Email'] ?> </br>
                Member Since : <?php echo $userInfo['Date'] ?> </br>
                Favourite Category : 
            </div>
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
<?php

    }else{
        header('Location: ./');
    }
    include $tpl .'footer.inc.php';

?>