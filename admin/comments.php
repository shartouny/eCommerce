<?php

    // copy template
    // you can use this template on all pages

    session_start();
    $pageTitle = 'Template';
    if(isset($_SESSION['Username'])){
        include 'init.php';
      
        $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;
      
        if($do == 'manage'){

            
           //select all comments from the database
           $stmt = $con->prepare("SELECT comments.*, users.Username AS UserCmnt, items.Name AS ItemCmnt FROM comments 
                                INNER JOIN users ON users.userID = comments.UserID 
                                INNER JOIN items ON items.ItemID = comments.ItemID");
           $stmt->execute();
           $cmnts = $stmt->fetchAll();
?>
            <h1 class="text-center">Manage Comments</h1>
            <div class="container">
                <?php if(!empty($cmnts)){ ?>
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                <td>#ID</td>
                                <td>Comment</td>
                                <td>User Commented</td>
                                <td>On Item</td>
                                <td>Date Commented</td>
                                <td>Control</td>
                            </tr>
                            <?php
                            foreach($cmnts as $cmnt){
                                echo'<tr>
                                        <td>'.$cmnt['CmntID'].'</td>
                                        <td>'.$cmnt['Cmnt'].'</td>
                                        <td>'.$cmnt['UserCmnt'].'</td>
                                        <td>'.$cmnt['ItemCmnt'].'</td>
                                        <td>'.$cmnt['CmntDate'].'</td>
                                        <td>
                                            <a class="btn btn-success fas fa-edit" href=?do=edit&cmntid='.$cmnt['CmntID'].'><a>
                                            <a class="btn btn-danger fas fa-trash" href=?do=delete&cmntid='.$cmnt['CmntID'].'><a>';
                                            if($cmnt['Status']==0){
                                                echo ' <a class="btn btn-info fas fa-check" href="?do=approve&cmntid='.$cmnt['CmntID'].'"></a>';
                                            }echo
                                        '</td>
                                    </tr>';
                            }
                            ?>
                        </table>
                    </div>
                <?php }else{
                    echo '<div class="alert alert-danger">No Comments Yet</div>';                
                } ?>
            </div>

<?php

        }elseif($do == 'add'){
            echo 'welcome to' . $do . 'page';
        }elseif($do == 'insert'){
            echo 'welcome to' . $do . 'page';
        }elseif($do == 'edit'){
            //check if get request ID OF THE COMMENT is numeric and get the integar value from it
            $cmntid = isset($_GET['cmntid']) && is_numeric($_GET['cmntid']) ? intval($_GET['cmntid']) : 0;
            
            //select all data depend on this id 
            $stmt = $con -> prepare("SELECT * FROM comments WHERE CmntID= ?");
            //execute the query
            $stmt->execute(array($cmntid));
            //fetch the data 
            $cmnts = $stmt->fetch();
            //check if the data of the user existed
            $exist = $stmt->rowCount();
            //if the id exist change the form
            if($exist >0){
?>
                <h1 class="text-center">Edit Comment</h1>
                <div class="container">
                
                    <form action="?do=update" method="POST" class="form-horizontal">
                        <input type="hidden" value = "<?php echo $cmntid ?>" name="cmntid">
                        <!-- start username -->
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Comment</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <textarea class="form-control" name="cmnt"><?php echo $cmnts['Cmnt'] ?></textarea>
                            </div>
                        
                        </div>
                        <!-- end username -->
                        <!-- start passowrd -->
                        
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
                
                echo "<h1 class = 'text-center'>Update Comment</h1>";
                echo "<div class='container'>";

                // assign values from form to a variables
                $cmntid=$_POST['cmntid'];
                $cmnt=$_POST['cmnt'];
                $stmt = $con->prepare("UPDATE comments SET Cmnt = ? WHERE CmntID = ?");
                $stmt -> execute(array($cmnt, $cmntid));

                //print the sucess message
                redirectHome($stmt->rowCount().' Comment Updated', 'success');                

            }else{
                redirectHome('this page is not available for such idiots like you','danger');
            }
            echo '</div>';
        }elseif($do == 'delete'){
                
            echo "<h1 class = 'text-center'>Delete Member</h1>";
            echo "<div class='container'>";
                //delet members 
                
                //check if get request userid is numeric and get the integar value from it
                $cmntid = isset($_GET['cmntid']) && is_numeric($_GET['cmntid']) ? intval($_GET['cmntid']) : 0;

                //select all data depend on this id 
                $exist = checkItem('cmntid', 'comments', $cmntid);

                if($exist >0){
                    
                    $stmt = $con->prepare("DELETE FROM comments WHERE CmntID = :cmntid");
                    $stmt->bindParam('cmntid',$cmntid);
                    $stmt->execute();
                    
                    redirectHome($stmt->rowCount() . ' Comment Deleted', 'success');
             echo'</div>';

            }else{
                redirectHome("no id exits", 'danger');
                
            }
        }elseif($do == 'approve'){
                
            echo "<h1 class = 'text-center'>Approve Comment</h1>";
            echo "<div class='container'>";
            //Update Comment 
            
            //check if get request userid is numeric and get the integar value from it
            $cmntid = isset($_GET['cmntid']) && is_numeric($_GET['cmntid']) ? intval($_GET['cmntid']) : 0;

            $check = checkItem('CmntID', 'comments', $cmntid);
            //if the id exist change the form
            if($check >0){
                
                $stmt = $con->prepare("UPDATE comments SET Status=1, CmntDate = now() WHERE CmntID = ?");
                $stmt->execute(array($cmntid));
                
               redirectHome($stmt->rowCount().' Comment Approved', 'success');

            }else{
                echo "no id exits";
            }
            echo '</dive>';
        }

        include $tpl . 'footer.inc.php' ;
    }else{
        header('Location: index.php');
        exit();
    }
