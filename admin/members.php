<?php

    // manage members page
    // you can add edit or delet members from here

    session_start();
    $pageTitle = 'Members';
    if(isset($_SESSION['Username'])){
      include 'init.php';
      
        $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;
      
        if($do == 'manage'){
            
            $query ='';
            if(isset($_GET['page']) && $_GET['page']=='pending'){
                $query = 'AND RegStatus = 0';
            }
            
            //select all users from the data base except admin
            
            $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1 $query");
            $stmt->execute();

            //assign the values to a variable
            $rows = $stmt->fetchAll();
?>
            <!-- manage page design -->
            <h1 class="text-center">Members</h1>
            <div class="container">
                <?php if(!empty($rows)){ ?>
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                <td>#ID</td>
                                <td>Username</td>
                                <td>Email Address</td>
                                <td>Full Name</td>
                                <td>Registered Date</td>
                                <td>Control</td>
                            </tr>
                            <?php
                                foreach($rows as $row){
                                    echo "
                                        <tr>
                                            <td>". $row['userID'] . "</td>
                                            <td>". $row['Username'] . "</td>
                                            <td>". $row['Email'] . "</td>
                                            <td>". $row['FullName'] . "</td>
                                            <td>". $row['Date'] . "</td>
                                            <td>
                                                <a href='?do=edit&userid=" . $row['userID'] . "' class='btn btn-success fa fa-edit' title='Edit Member' ></a>
                                                <a href='?do=delete&userid=" . $row['userID'] . "' class='confirm btn btn-danger fa fa-trash' title='Delete Member'></a>
                                            ";
                                            if($row['RegStatus']==0){
                                                echo "<a href='?do=activate&userid=" . $row['userID'] . "' class=' btn btn-info fa fa-check' title='Activate Member'></a>
                                                ";
                                            }
                                            "
                                            </td>
                                        </tr>
                                    ";
                                }
                            ?>
                        </table>
                    </div>
                <?php }else{
                    echo '<div class="alert alert-danger">No Members Yet</div>';                
                } ?>
                <a class="btn btn-primary fa fa-plus" title="Add Member" href="?do=add"></a>                    
            </div>
<?php
        }elseif($do == 'add'){
            //ADD MEMBER PAGE
?>
                
                <h1 class="text-center">Add New Member</h1>
                <div class="container">
                
                    <form action="?do=insert" method="POST" class="form-horizontal">
                        <!-- start username -->
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Username</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="username" class="form-control"  required="required" placeholder="Username">
                            </div>
                        
                        </div>
                        <!-- end username -->
                        <!-- start passowrd -->
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Password</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <input type='password' name="password" class="password form-control"required placeholder="Password">
                                <i class="show-pass fa fa-eye fa-2x"></i>
                            </div>
                        
                        </div>
                        <!-- end passowrd -->
                        <!-- start email -->
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Email</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <input type="email" name="email" class="form-control" required="required" placeholder="Email Adress">
                            </div>
                        
                        </div>
                        <!-- end email -->
                        <!-- start fullname -->
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Full Name</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="fullname" class="form-control" required="required" placeholder="Full Name">
                            </div>
                        
                        </div>
                        <!-- end fullname -->
                        <!-- start btn -->
                        <div class="form-group form-group-lg">
                        
                            
                            <div class="col-sm-offset-2 col-sm-10 col-md-4">
                                <input type="submit" value="Add Member" class="btn btn-primary">
                            </div>
                        
                        </div>
                        <!-- end btn -->
                    </form>
                
                </div>

<?php   
        //inset page    
        }elseif($do == 'insert'){

            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                echo "<h1 class = 'text-center'>Add New Member</h1>";
                echo "<div class='container'>";

                // assign values from form to a variables
                $user=$_POST['username'];
                $pass=$_POST['password'];
                $email=$_POST['email'];
                $fullname=$_POST['fullname'];
                
                $hashedPass = sha1($pass);
                
                //validate the form
                $formErrors = array();
                if(strlen($user) < 4){
                    $formErrors [] = 'username cant be less then <strong> 4 characters </strong>';
                }
                if(empty($pass)){
                    $formErrors [] = 'Password cant be <strong> empty </strong>';
                }
                if(empty($email)){
                    $formErrors [] = 'email cant be <strong>empty</strong>';
                }
                if(empty($fullname)){
                    $formErrors [] = 'fullname cant be <strong>empty</strong>';
                }
                
                foreach($formErrors as $error){
                    echo '<div class = "alert alert-danger">' . $error . '</div>';
                    echo '<form method="POST" action="?do=edit&userid='. $_SESSION['id'] .'"><input type="submit" value="back" class="btn btn-primary"></form>';
                }

                //check if there is an error
                if(empty($formErrors)){
                    //check if user exist in database
                    $exist = checkItem('Username', 'users', $user);
                    if($exist ==1){
                        redirectHome("user already exists", 'danger', 'back');
                    }else{
                        //update the database
                        $stmt=$con->prepare('INSERT INTO 
                                            users(Username, Password, Email, FullName, RegStatus, Date) 
                                            VALUES(:user, :pass, :email, :fullname, 1, now())');
                        $stmt->execute(array(
                            'user' => $user,
                            'pass' => $hashedPass,
                            'email' => $email,
                            'fullname' => $fullname
                        ));
    
                        //print the sucess message
                        echo '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Inserted </div>';
                        echo '<a href="' .$_SERVER['HTTP_REFERER'] . '" class = "btn btn-primary">ok</a>';
                    }
                }
            }else{
                $errorMsg = 'this page is not available for such idiots like you';
                redirectHome($errorMsg, 'danger');
            }
            echo '</div>';
        }elseif($do == 'edit'){
            //check if get request userid is numeric and get the integar value from it
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            
            //select all data depend on this id 
            $stmt = $con -> prepare("SELECT * FROM users WHERE userID= ? LIMIT 1");
            //execute the query
            $stmt->execute(array($userid));
            //fetch the data 
            $row = $stmt->fetch();
            //check if the data of the user existed
            $count = $stmt->rowCount();
            //if the id exist change the form
            if($count >0){
?>
                <h1 class="text-center">Edit Member</h1>
                <div class="container">
                
                    <form action="?do=update" method="POST" class="form-horizontal">
                        <input type="hidden" value = "<?php echo $userid ?>" name="userid">
                        <!-- start username -->
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Username</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" required="required">
                            </div>
                        
                        </div>
                        <!-- end username -->
                        <!-- start passowrd -->
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Password</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <input type="hidden" name="oldpassword" value = "<?php echo $row['Password'] ?>" >
                                <input type="password" name="newpassword" class="form-control"required>
                            </div>
                        
                        </div>
                        <!-- end passowrd -->
                        <!-- start email -->
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Email</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" required="required">
                            </div>
                        
                        </div>
                        <!-- end email -->
                        <!-- start fullname -->
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Full Name</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="fullname" class="form-control" value="<?php echo $row['FullName'] ?>" required="required">
                            </div>
                        
                        </div>
                        <!-- end fullname -->
                        <!-- start btn -->
                        <div class="form-group form-group-lg">
                        
                            
                            <div class="col-sm-offset-2 col-sm-10 col-md-4">
                                <input type="submit" value="Save" class="btn btn-primary">
                            </div>
                        
                        </div>
                        <!-- end btn -->
                    </form>
                
                </div>

<?php       
            //if the user does not exist , show error
            }else{
                reditectHome('no such id', 'danger') ;               
            }
        }elseif($do == 'update'){
            
            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                echo "<h1 class = 'text-center'>Update Member</h1>";
                echo "<div class='container'>";

                // assign values from form to a variables
                $id=$_POST['userid'];
                $user=$_POST['username'];
                $email=$_POST['email'];
                $fullname=$_POST['fullname'];
                //password update

                //shortcut if statment:                
                //var = (      condition           ) ? (  if true var =    ) : (       if false var =            );   
                $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : $pass = sha1($_POST['newpassword']);
                
                //validate the form
                $formErrors = array();
                if(strlen($user) < 4){
                    $formErrors [] = 'username cant be less then <strong> 4 characters </strong>';
                }
                if(empty($user)){
                    $formErrors [] = 'Username cant be <strong>empty</strong>';
                }
                if(empty($email)){
                    $formErrors [] = 'email cant be <strong>empty</strong>';
                }
                if(empty($fullname)){
                    $formErrors [] = 'fullname cant be <strong>empty</strong>';
                }
                
                foreach($formErrors as $error){
                    echo '<div class = "alert alert-danger">' . $error . '</div>';
                    echo '<a href="?do=edit&userid='. $_SESSION['id'] .'" class="btn btn-danger">back</a>';
                }

                //check if there is an error
                if(empty($formErrors)){
                    
                    $slstmt = $con->prepare('SELECT * FROM users WHERE Username = ? AND userID != ?');
                    $slstmt->execute(array($user, $id));

                    $exist = $slstmt->rowCount();
                    if($exist ==1){
                        redirectHome("user already exists", 'danger', 'back');
                    }else{

                        //update the database
                        $stmt = $con->prepare("UPDATE users SET Username = ?,  Password = ?, Email = ?, FullName = ? WHERE userID = ?");
                        $stmt -> execute(array($user, $pass, $email, $fullname,  $id));
        
                        //print the sucess message
                        echo '<div class="alert alert-success">' . $stmt->rowCount() . ' Record updated </div>';
                        echo '<a href="members.php" class = "btn btn-primary">ok</a>';
                    }
                }

            }else{
                echo 'this page is not available for such idiots like you';
            }
            echo '</div>';
        }elseif($do == 'delete'){
                
            echo "<h1 class = 'text-center'>Delete Member</h1>";
            echo "<div class='container'>";
                //delet members 
                
                //check if get request userid is numeric and get the integar value from it
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

                //select all data depend on this id 
                $check = checkItem('userid', 'users', $userid);

                if($check >0){
                    
                    $stmt = $con->prepare("DELETE FROM users WHERE userID = :userID");
                    $stmt->bindParam('userID',$userid);
                    $stmt->execute();
                    
                    echo '<div class="alert alert-success">' . $stmt->rowCount() . ' Member Deleted </div>';
                    echo '<a href="members.php" class="btn btn-primary">ok</a>
             </div>';

            }else{
                echo "no id exits";
            }
        }elseif($do == 'activate'){
                
            echo "<h1 class = 'text-center'>Activate Member</h1>";
            echo "<div class='container'>";
            //delet members 
            
            //check if get request userid is numeric and get the integar value from it
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

            $check = checkItem('userid', 'users', $userid);
            //if the id exist change the form
            if($check >0){
                
                $stmt = $con->prepare("UPDATE users SET RegStatus = 1, Date = now() WHERE UserID = ?");
                $stmt->bindParam('userID',$userid);
                $stmt->execute(array($userid));
                
                echo '<div class="alert alert-success">' . $stmt->rowCount() . ' Member Activated </div>';
                echo '<a href="members.php" class = "btn btn-primary">ok</a>';

            }else{
                echo "no id exits";
            }
        }

        include $tpl . 'footer.inc.php';
    }else{
        header('Location: index.php');
        exit();
    }