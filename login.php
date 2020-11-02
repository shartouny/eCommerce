<?php 
    include 'init.php';
    $pagetitle = 'Login'; 
    session_start();
    if(isset($_SESSION['user'])){
        header('Location: index.php'); // redirect to dashboard page
    }
    // check if user coming from http post request
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPass = sha1($password);
        // check if user exist as admin in the data base before leting him in
        $stmt = $con -> prepare("SELECT userID, Username , Password 
                                FROM users WHERE Username= ? AND Password = ?");
        $stmt->execute(array($username , $hashedPass));
        $count = $stmt->rowCount();
        
        if($count > 0 ){
            $_SESSION['user'] = $username ; // register session name
            header('Location: index.php');
            exit();
        }

    }
?>

    <div class="container login-page">
        <h1 class="text-center"> 
            <span class="selected " data-class="signup"> Login </span>  
            <span class="signup" data-class="login"> Signup </span>
        </h1>
        <!-- START LOGIN FORM  -->
        <form action="<?php echo $_SERVER['PHP_SELF']?>" class="login" method="POST">
            <input name="username" type="text" class="form-control" placeholder="Username">
            <input name="password" type="password" class="form-control" placeholder="Password">
            <input type="submit" value="Login" class="btn btn-info btn-block" >
        </form>
        <!-- END LOGIN FORM  -->
        <!-- START SIGNUP FORM  -->
        <form action="" class="signup" method="POST" >
            <div class="input-container">
                <input name="username" type="text" class="form-control" placeholder="Username" required>
            </div>

            <input name="email" type="text" class="form-control" placeholder="Email">
            <input name="Password1" type="password" class="form-control" placeholder="Password">
            <input name="password2" type="password" class="form-control" placeholder="Re-Password">
            <input type="submit" value="Signup" class="btn btn-success btn-block" >
        </form>
        <!-- END SIGNUP FORM  -->
    </div>
<?php include $tpl . "footer.inc.php"; ?>