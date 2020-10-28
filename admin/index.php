<?php
    session_start();
    $noNavbar= '';
    $pageTitle ='Home';
    if(isset($_SESSION['Username'])){
        header('Location: dashboard.php'); // redirect to dashboard page
    }
    include "init.php";
     
    
    // check if user coming from http post request
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);
        // check if user exist as admin in the data base before leting him in
        $stmt = $con -> prepare("SELECT  
                                    userID, Username , Password 
                                FROM users 
                                WHERE Username= ? 
                                AND Password = ? 
                                AND GroupID=1 -- the group id is to identify if the user is admin or no
                                LIMIT 1");
        $stmt->execute(array($username , $hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        
        if($count > 0 ){
            $_SESSION['Username'] = $username ; // register session name
            $_SESSION['id'] = $row['userID'];
            
            redirectHome("welcome " . $username . " You Are a Stupid Admin" , 'success');
        }

    }
?>

<!-- Login Form -->
<form action="<?php echo $_SERVER['PHP_SELF']?>" method = "POST" class="login">

    <h4 class="text-center">Admin Login</h4>
    <input type="text" name="user" class="form-control input-lg" placeholder="username" autocomplete="off">
    <input type="password" name="pass" class="form-control input-lg" placeholder="password" autocomplete = "new-password">
    <input type="submit" class="btn btn-primary btn-block btn-lg" value="Login">

</form>

<?php
    include $tpl . "footer.inc.php";  
?>

