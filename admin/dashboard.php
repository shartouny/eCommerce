<?php
    session_start();
    $pageTitle = 'Dashboard';
    if(isset($_SESSION['Username'])){
      include 'init.php';
      
      //specify the getLatest function paramateres
      $specificLatestUser = 3; 
      $latestUsers = getLatest("*", "users", "userID", "GroupID!=1", $specificLatestUser);
      $latestItems = getLatest("*", "items", "ItemID");

      // START CONTENT OF DASHBOARD PAGE
     ?> 

      <div class="container home-stats text-center">
        <h1>Dashboard</h1>
        <div class="row">
          <a href="members.php">
            <div class="col-md-3">
              <div class="stat st-members">
              <i class="fas fa-users"></i>
                <div class="info">
                  Total Members
                  <span><?php echo countItems('userID', 'users', 'GroupID!=1')?></span>
                </div>
              </div>
            </div>
          </a>
          <a href="members.php?do=manage&page=pending">
            <div class="col-md-3">
              <div class="stat st-pending">
              <i class="fa fa-user-plus"></i>
                <div class="info">
                  Pending Members
                  <span><?php echo checkItem('RegStatus', 'users', 'RegStatus=0')?></span>
                </div>
              </div>
            </div>
          </a>
          <a href="items.php">
            <div class="col-md-3">
              <div class="stat st-items">
              <i class="fas fa-tag"></i>
                <div class="info">
                  Total Items
                  <span><?php echo countItems('*', 'items') ?></span>
                </div>
              </div>
            </div>
          </a>
          <a href="comments.php">
            <div class="col-md-3">
              <div class="stat st-comments">
              <i class="fas fa-comments"></i>
                  <div class="info">
                    Total Comments
                    <span><?php echo countItems('*', 'comments')  ?></span>
                  </div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="container latest">
        <div class="row">
          <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fas fa-users"></i>
                  Latest <?php echo $specificLatestUser; ?> Registered Users
                  <span class="pull-right toggle-info"><i class="fas fa-plus"></i></span>
              </div>
              <div class="panel-body">
                <ul class="list-unstyled latest-users"> 
                  <?php
                    if(!empty($latestUsers)){
                      foreach($latestUsers as $user){
                        echo '
                            <li class="alert alert-info"><i class="fas fa-user icon"></i> '. $user['Username']. '
                              <div class="pull-right"> 
                                <a href="members.php?do=edit&userid=' . $user['userID'] . '" class="btn btn-success fa fa-edit " title="Edit Member" ></a>
                                <a href="members.php?do=delete&userid=' . $user['userID'] . '" class="confirm btn btn-danger fa fa-user-minus " title="Delete Member"></a>';
                                if($user['RegStatus']==0){
                                  echo ' <a href="members.php?do=activate&userid=' . $user['userID'] . '" class=" btn btn-info fa fa-check" title="Activate Member"></a>
                                  ';
                                }echo'
                                </div>
                            </li>';
                      }
                    }else{
                      echo '
                          <li class="alert alert-info"><i class="fas fa-user icon"></i>
                          No Users Yet
                          </li>';
                    }  
                  ?>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fas fa-tag"></i>
                Latest items
                <span class="pull-right toggle-info"><i class="fas fa-plus"></i></span>
              </div>
              <div class="panel-body">
                <ul class="list-unstyled latest-users">
                  <?php
                  if(!empty($latestItems)){
                    foreach($latestItems as $item){
                      echo '
                      <li class="alert alert-info"><i class="fas fa-shopping-bag icon"></i> '. $item['Name']. '
                        <div class="pull-right">
                          <a href="items.php?do=edit&itemid=' . $item['ItemID'] . '" class="btn btn-success fa fa-edit " title="Edit Member" ></a>
                          <a href="items.php?do=delete&itemid=' . $item['ItemID'] . '" class="confirm btn btn-danger fa fa-user-minus " title="Delete Member"></a>';
                          if($item['Approve']==0){
                            echo ' <a href="items.php?do=activate&itemid=' . $item['ItemID'] . '" class=" btn btn-info fa fa-check" title="Activate Member"></a>
                            ';
                        }echo'
                        </div>
                      </li>';
                    }
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- start latest comments  -->
        <div class="row">
          <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fas fa-comments"></i>
                  Latest Comments
                  <span class="pull-right toggle-info"><i class="fas fa-plus"></i></span>
              </div>
              <div class="panel-body">
                <?php
                  $stmt = $con->prepare("SELECT comments.*, users.FullName AS UserCmnt FROM comments 
                                            INNER JOIN users ON users.userID = comments.UserID");
                  $stmt->execute();
                  $cmnts = $stmt->fetchAll();
                  if(!empty($cmnts)){
                    foreach($cmnts as $cmnt){
                      echo '
                            <div class="comment-box">
                              <span class="cmnter">  '.$cmnt['UserCmnt'].'</span>
                              <p class="cmntcntnt"> '.$cmnt['Cmnt'].'</p>
                            </div>
                          ';
                    }
                  }else{
                    echo '<i>no comments</i>';
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
      // END CONTENT OF DASHBOARD PAGE

      include $tpl . 'footer.inc.php';
    }else{
        header('Location: index.php');
        exit();
    }