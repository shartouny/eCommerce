<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=#app-nav>
        <span class="sr-only">Toggle-navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="dashboard.php" class="navbar-brand">Brand</a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li class="nav-item"><a class="nav-link" href="categories.php"><?php echo lang('Categories') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="items.php"><?php echo lang('Items') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="members.php"><?php echo lang('Members') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="comments.php"><?php echo lang('Comments') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="../index.php"><?php echo lang('Client Area') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><?php echo lang('Statistics') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><?php echo lang('Logs') ?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class ="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo lang('Account') ?><span class="caret"></span>
          <ul class="dropdown-menu"></a> 
            <li><a class="dropdown-item" href="members.php?do=edit&userid=<?php echo $_SESSION['id']?>"><?php echo lang('Edit Profile') ?></a></li>
            <li><a class="dropdown-item" href="#"><?php echo lang('Settings') ?></a></li>
            <li><a class="dropdown-item" href="logout.php"><?php echo lang('Logout') ?></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav> 



