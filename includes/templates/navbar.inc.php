
<div class="upper-bar">
  <div class="container">
    <?php
      if(isset($_SESSION['user'])){
        echo 'Welcome '. $_SESSION['user'] .
        ' <a href="profile.php">My Profile </a>
          <a href="logout.php">Logout</a> ';
        $status = checkUserStatus($_SESSION['user']);
        if($status!=0){
          
        }
      }else{?>
    <a href="login.php">
      <span class="pull-right">login/signup</span>
    </a>
      <?php } ?>
  </div>
</div>

<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=#app-nav>
        <span class="sr-only">Toggle-navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="index.php" class="navbar-brand">eCommerce</a>
    </div>
    <div class="collapse navbar-collapse navbar-right" id="app-nav">
      <ul class="nav navbar-nav">
        <?php
          $categories = getCat();
          foreach($categories as $cat){
              echo '<li class="nav-item"><a class="nav-link" href="categories.php?id='.$cat['ID'].'&pagename='.str_replace(' ', '-', $cat['Name']).'">'.$cat['Name'].'</a></li>';
          }
        ?>       
      </ul>

    </div>
  </div>
</nav> 

