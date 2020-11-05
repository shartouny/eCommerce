<?php
    session_start();
    $pageTitle= $_SESSION['user'] .' | Profile';
    include 'init.php';
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
                <ul class="list-unstyled">
                    <li>
                        <i class="fas fa-unlock-alt fa-fw"></i>
                        <span>Name : </span><?php echo $userInfo['FullName'] ?>
                    </li>
                    <li>
                        <i class="fas fa-envelope fa-fw"></i>
                        <span>Email : </span><?php echo $userInfo['Email'] ?>

                    </li>
                    <li>
                        <i class="fas fa-calendar-alt fa-fw"></i>
                        <span>Member Since : </span><?php echo $userInfo['Date'] ?>

                    </li>
                    <li>
                        <i class="fas fa-tags fa-fw"></i>
                        <span>Favourite Category : </span>
                    </li>
                   
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="my-ads block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Ads</div>
            <div class="panel-body">
                <div class="row">
                    <?php
                        $items=getItems('MemberID',$userInfo['userID']);
                        if(!empty($items)){
                            foreach($items as $item){
                                echo '
                                <a href="items.php?itemid='.$item['ItemID'].'">
                                    <div class="col-md-3 col-sm-6">
                                        <div class="stat st-members">
                                            <div class="thumbnail item-box">
                                                <span class="price-tag">$'.$item['Price'].'</span>
                                                <img class="img-responsive" src="laptop.jpeg" alt="Not Found">
                                                <div class="caption">
                                                    <h3>'.$item['Name'].'</h3>
                                                    <p>'.$item['Description'].'</p>
                                                    <div class="date">'.$item['AddDate'].'</div>
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                </a>
                                ';
                            }
                        }else{
                            echo '<i>No Items Available <a href="newad.php">Create New Ad</a></i>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="my-cmnts block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Comments</div>
            <div class="panel-body">
                <div class="row">
                    <?php          
                         $stmt = $con->prepare("SELECT Cmnt FROM comments WHERE UserID=?");
                         $stmt->execute(array($userInfo['userID']));
                         $cmnts = $stmt->fetchAll();
                         if(!empty($items)){
                            foreach($cmnts as $cmnt){
                                echo '
                                <a href="#">
                                    <div class="col-md-3 col-sm-6">
                                        <div class="stat st-members">
                                            <div class="thumbnail item-box">
                                                <div class="caption">
                                                    <p>'.$cmnt['Cmnt'].'</p>
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                </a>
                                ';
                            }
                        }else{
                            echo '<i>No Comments Available</i>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

    }else{
        header('Location: ./');
        exit();
    }
    include $tpl .'footer.inc.php';

?>