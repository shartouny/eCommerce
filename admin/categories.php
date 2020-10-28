<?php

    // copy template
    // you can use this template on all pages

    session_start();
    $pageTitle = 'Categories';
    if(isset($_SESSION['Username'])){
      include 'init.php';
      
        $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;
      
        if($do == 'manage'){
            $sort = 'ASC';
            $sort_array = array('ASC', 'DESC');
            if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
                $sort = $_GET['sort'];
            }
            $stmt = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
            $stmt->execute();
            $cats= $stmt->fetchAll();
?>
        <h1 class="text-center">Manage Categories</h1>
        <div class="container categories">
            <div class="panel panel-default">
                <div class="panel-heading">Manage Categories
                    <div class="ordering pull-right">
                        Sort:
                        <a href="?sort=DESC" class="fa fa-sort-down<?php if($sort == 'ASC'){echo ' active';} ?>"></a>
                        <a href="?sort=ASC" class="fa fa-sort-up<?php if($sort == 'DESC'){echo ' active';} ?>"></a>
                        view :  <span>classick</span>
                                <span>full</span>
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                        foreach($cats as $cat){
                            echo"
                                <div class='cat'>
                                    <div>
                                        <a href='#' class='btn btn-danger pull-right fas fa-trash'></a>                                
                                        <a href='?do=edit&catid=" . $cat['ID'] . "'class='btn btn-success fas fa-edit pull-right'></a>
                                    </div>
                                    <h3>".$cat['Name']."</h3>
                                    <div class='full-view'>
                                        <p>"; if($cat['Description']==''){echo "no description";}else{echo $cat['Description'];}echo"</p>";
                                        if($cat['Visibility']==1){echo "<i class='btn btn-danger fas fa-eye-slash'></i>";}else {echo "<i class='btn btn-success fas fa-eye'></i>";}
                                        if($cat['Allow_Comment']==1){echo "<i class='btn btn-danger fas fa-comment-slash'></i>";}else {echo "<i class='btn btn-success fas fa-comment'></i>";}
                                        if($cat['Allow_Ads']==1){echo "<i class='btn btn-danger fas fa-ad'></i>";}else {echo "<i class='btn btn-success fas fa-ad'></i>";}
                            echo"
                                    </div>
                                </div>
                                <hr/>
                            ";                             
                        }
                    ?>
                </div>
            </div>
            <a href="?do=add" class="fa fa-plus btn btn-info"></a>
        </div>

<?php
        }elseif($do == 'add'){
?>
                
            <h1 class="text-center">Add New Category</h1>
            <div class="container">
            
                <form action="?do=insert" method="POST" class="form-horizontal">
                    <!-- start name -->
                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Name</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="name" class="form-control" placeholder="Name of the category">
                        </div>
                    
                    </div>
                    <!-- end username -->
                    <!-- start Description -->
                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Description</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <input type='text' name="description" class=" form-control" placeholder="Describe the category">
                        </div>
                    
                    </div>
                    <!-- end Description -->
                    <!-- start Oedering -->
                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Ordering</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="ordering" class="form-control" placeholder="Number to arrange categories">
                        </div>
                    
                    </div>
                    <!-- end Ordering -->
                    <!-- start visibility -->
                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Visible</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <div>
                                <input id="vis-yes" type="radio" name="visibility" value = "0" checked> 
                                <label for="vis-yes">Yes</label>
                            </div>          
                            <div>
                                <input id="vis-no" type="radio" name="visibility" value = "1" > 
                                <label for="vis-no">No</label>
                            </div>          
                        </div>
                    
                    </div>
                    <!-- end visibility -->
                    <!-- start commenting -->
                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Commenting allowed</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <div>
                                <input id="cmnt-yes" type="radio" name="cmnt" value = "0" checked> 
                                <label for="cmnt-yes">Yes</label>
                            </div>          
                            <div>
                                <input id="cmnt-no" type="radio" name="cmnt" value = "1" > 
                                <label for="cmnt-no">No</label>
                            </div>          
                        </div>
                    
                    </div>
                    <!-- end commenting -->
                    <!-- start ads -->
                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Ads allowed</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <div>
                                <input id="ads-yes" type="radio" name="ads" value = "0" checked> 
                                <label for="ads-yes">Yes</label>
                            </div>          
                            <div>
                                <input id="ads-no" type="radio" name="ads" value = "1" > 
                                <label for="ads-no">No</label>
                            </div>          
                        </div>
                    
                    </div>
                    <!-- end ads -->
                    <!-- start btn -->
                    <div class="form-group form-group-lg">
                    
                        
                        <div class="col-sm-offset-2 col-sm-10 col-md-4">
                            <input type="submit" value="Add Category" class="btn btn-primary">
                        </div>
                    
                    </div>
                    <!-- end btn -->
                </form>
            
            </div>

<?php   
        }elseif($do == 'insert'){

            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                echo "<h1 class = 'text-center'>Add New Category</h1>";
                echo "<div class='container'>";

                // assign values from form to a variables
                $name=$_POST['name'];
                $desc=$_POST['description'];
                $order=$_POST['ordering'];
                $visible=$_POST['visibility'];
                $cmnt=$_POST['cmnt'];
                $ads=$_POST['ads'];
                

                    //check if user exist in database
                $exist = checkItem('Name','categories', $name);
                if($exist ==1){
                    redirectHome("user already exists", 'danger', 'back');
                }else{
                    //update the database
                    $stmt=$con->prepare('INSERT INTO 
                                        categories(Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads) 
                                        VALUES(:name, :desc, :order, :visible, :cmnt, :ads)');
                    $stmt->execute(array(
                        'name' => $name,
                        'desc' => $desc,
                        'order' => $order,
                        'visible' => $visible,
                        'cmnt' => $cmnt,
                        'ads' => $ads
                    ));

                    //print the sucess message
                    echo '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Inserted </div>';
                    echo '<a href="' .$_SERVER['HTTP_REFERER'] . '" class = "btn btn-primary">ok</a>';
                }
            }else{
                $errorMsg = 'this page is not available for such idiots like you';
                redirectHome($errorMsg, 'danger');
            }
            echo '</div>';
        }elseif($do == 'edit'){
            //check if get request catID is numeric and get the integar value from it
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
            
            //select all data depend on this id 
            $stmt = $con -> prepare("SELECT * FROM categories WHERE ID = ?");
            //execute the query
            $stmt->execute(array($catid));
            //fetch the data 
            $cat = $stmt->fetch();
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
            header("Location: dashboard.php");
            echo 'there is no such id';
            }
        }elseif($do == 'update'){
            echo 'welcome to ' . $do .' in the ' . $pageTitle. ' page';
        }elseif($do == 'delete'){
            echo 'welcome to ' . $do .' in the ' . $pageTitle. ' page';
        }elseif($do == 'activate'){
            echo 'welcome to ' . $do .' in the ' . $pageTitle. ' page';
        }

        include $tpl . 'footer.inc.php';
    }else{
        header('Location: index.php');
        exit();
    }