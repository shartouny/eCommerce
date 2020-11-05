<?php 
    include 'init.php';
    $pagetitle = 'Login'; 
    session_start();
    if(isset($_SESSION['user'])){
        header('Location: index.php'); // redirect to dashboard page
    }
    // check if user coming from http post request
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        if(isset($_POST['login'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashedPass = sha1($password);
            // check if user exist as admin in the data base before leting him in
            $stmt = $con -> prepare("SELECT userID, Username , Password 
                                    FROM users WHERE Username= ? AND Password = ?");
            $stmt->execute(array($username , $hashedPass));
            $count = $stmt->rowCount();
            $getUserInfo = $stmt->fetch();
            if($count > 0 ){
                $_SESSION['user'] = $username ; // register session name
                $_SESSION['userid'] = $getUserInfo['userID'];
                header('Location: index.php');
                exit();
            }
        }else{
            $formErrors = array();

            $username = $_POST['username'];
            $email = $_POST['email'];
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];
            

            if(isset($username)){
                $filteredUser = filter_var($username, FILTER_SANITIZE_STRING);
                if(strlen($filteredUser)<2){
                    $formErrors[] = 'Username must be larger then 2 characters';
                }
            }
            if(isset($password1)){
                $pass1 = sha1($password1);
                $pass2 = sha1($password2);
                if(!empty($pass1)){
                    if($pass1 !== $pass2){
                        $formErrors[] = 'Password does not match';
                    }
                }else{
                    $formErrors[]= 'Password is empty';
                }
            }
            if(isset($email)){
                $filteredEmail= filter_var($email, FILTER_SANITIZE_EMAIL);
                if(filter_var($filteredEmail, FILTER_VALIDATE_EMAIL)!= true){
                    $formErrors[] = 'Email is not Valid';
                }
            }
                //check if there is an error
            if(empty($formErrors)){
                //check if user exist in database
                $exist = checkItem('Username', 'users', $user);
                if($exist != 0){
                    $formErrors[] = 'User already exist';
                }else{
                    //update the database
                    $stmt=$con->prepare('INSERT INTO 
                                        users(Username, Password, Email, RegStatus, Date) 
                                        VALUES(:user, :pass, :email, 0, now())');
                    $stmt->execute(array(
                        'user' => $username,
                        'pass' => $pass1,
                        'email' => $email,
                    ));

                    //print the sucess message
                    echo '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Inserted </div>';
                    echo '<a href="' .$_SERVER['HTTP_REFERER'] . '" class = "btn btn-primary">ok</a>';
                }
            }
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
            <input type="submit" name="login" value="Login" class="btn btn-info btn-block" >
        </form>
        <!-- END LOGIN FORM  -->
        <!-- START SIGNUP FORM  -->
        <form action="" class="signup" method="POST" >
            <div class="input-container">
                <input name="username" type="text" class="form-control" placeholder="Username" required>
                <input name="email" type="text" class="form-control" placeholder="Email">
                <input name="password1" type="password" class="form-control" placeholder="Password">
                <input name="password2" type="password" class="form-control" placeholder="Re-Password">
                <input type="submit" name="signup" value="Signup" class="btn btn-success btn-block" >
            </div>
        </form>
        <!-- END SIGNUP FORM  -->
        <div class="container">
            <?php 
                if(!empty($formErrors)){
                    foreach ($formErrors as $error){
                        echo '<div class="alert alert-danger">'.$error.'</div>';
                    }
                }
            ?>
        </div>
    </div>
<?php include $tpl . "footer.inc.php"; ?>