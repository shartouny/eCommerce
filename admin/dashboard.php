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
                Total Members
                <span><?php echo countItems('userID', 'users', 'GroupID!=1')?></span>
              </div>
            </div>
          </a>
          <a href="members.php?do=manage&page=pending">
            <div class="col-md-3">
              <div class="stat st-pending">
                Pending Members
                <span><?php echo checkItem('RegStatus', 'users', 'RegStatus=0')?></span>
              </div>
            </div>
          </a>
          <a href="items.php">
            <div class="col-md-3">
              <div class="stat st-items">
                Total Items
                <span><?php echo countItems('*', 'items') ?></span>
              </div>
            </div>
          </a>
          <div class="col-md-3">
            <div class="stat st-comments">
              Total Comments
              <span>2000</span>
            </div>
          </div>
        </div>
      </div>
      <div class="container latest">
        <div class="row">
          <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fas fa-users"></i>
                  Latest <?php echo $specificLatestUser; ?> Registered Users
              </div>
              <div class="panel-body">
                <ul class="list-unstyled latest-users"> 
                  <?php
                      foreach($latestUsers as $user){
                        echo '
                              <li class="alert alert-info"><i class="fas fa-user icon"></i> '. $user['Username']. '
                              <div class="pull-right"> 
                                <a href="members.php?do=edit&userid=' . $user['userID'] . '" class="btn btn-success fa fa-edit " title="Edit Member" ></a>
                                <a href="members.php?do=delete&userid=' . $user['userID'] . '" class="confirm btn btn-danger fa fa-user-minus " title="Delete Member"></a>
                              </div>';
                              if($user['RegStatus']==0){
                                  echo '<a href="members.php?do=activate&userid=' . $user['userID'] . '" class=" btn btn-info fa fa-check pull-right" title="Activate Member"></a>
                                  ';
                              }
                              '
                              </li>
                            ';
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
              </div>
              <div class="panel-body">
                <ul class="list-unstyled latest-users">
                  <?php
                    foreach($latestItems as $item){
                      echo '
                      <li class="alert alert-info"><i class="fas fa-shopping-bag icon"></i> '. $item['Name']. '
                      <div class="pull-right">
                      <a href="items.php?do=edit&itemid=' . $item['ItemID'] . '" class="btn btn-success fa fa-edit " title="Edit Member" ></a>
                      <a href="items.php?do=delete&itemid=' . $item['ItemID'] . '" class="confirm btn btn-danger fa fa-user-minus " title="Delete Member"></a>
                      </div>
                      </li>';
                    }
                  ?>
                </ul>
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