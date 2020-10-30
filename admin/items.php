<?php

    // copy template
    // you can use this template on all pages

    session_start();
    $pageTitle = 'Items';
    if(isset($_SESSION['Username'])){
        include 'init.php';
      
        $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;
      
        if($do == 'manage'){
            
           
            
            //select all users from the data base except admin
            
            $stmt = $con->prepare(" SELECT items.*, categories.Name AS CatName, users.Username As Owner FROM items 
                                    INNER JOIN categories ON categories.ID = items.CatID 
                                    INNER JOIN users ON users.userID = items.MemberID");
            $stmt->execute();

            //assign the values to a variable
            $items = $stmt->fetchAll();
?>
            <!-- manage page design -->
            <h1 class="text-center">Manage Items</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Owned By</td>
                            <td>Category</td>
                            <td>Price</td>
                            <td>Adding  Date</td>
                            <td>Control</td>
                        </tr>
                        <?php
                            foreach($items as $item){
                                echo "
                                    <tr>
                                        <td>". $item['ItemID'] . "</td>
                                        <td>". $item['Name'] . "</td>
                                        <td>". $item['Description'] . "</td>
                                        <td>". $item['Owner'] . "</td>
                                        <td>". $item['CatName'] . "</td>
                                        <td>". $item['Price'] . "</td>
                                        <td>". $item['AddDate'] . "</td>
                                        <td>
                                            <a href='?do=edit&itemid=" . $item['ItemID'] . "' class='btn btn-success fa fa-edit' title='Edit Item' ></a>
                                            <a href='?do=delete&itemid=" . $item['ItemID'] . "' class='confirm btn btn-danger fa fa-trash' title='Delete Item'></a>";
                                            if($item['Approve']==0){
                                                echo "
                                                <a href='?do=approve&itemid=" . $item['ItemID'] . "' class='btn btn-info fa fa-check' title='Edit Item' ></a>";}                                 
                                        echo "</td>";
                                   
                                        
                                        
                                    
                                    echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
                <a class="btn btn-primary fa fa-plus" title="Add Item" href="?do=add"></a>
            </div>
<?php
        }elseif($do == 'add'){
?>
            <h1 class="text-center">Add New Item</h1>
            <div class="container">
            
                <form action="?do=insert" method="POST" class="form-horizontal">
                    <!-- start name -->

                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Name</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="name" class="form-control" placeholder="Name of the item">
                        </div>
                    
                    </div>

                    <!-- end username -->

                    <!-- start description -->
                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Description</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="description" class="form-control" placeholder="Description of the item">
                        </div>
                    
                    </div>
                    <!-- end description -->

                    <!-- start price -->

                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Price</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="price" class="form-control" placeholder="Price of the item">
                        </div>
                    
                    </div>
                    <!-- end price -->

                    <!-- start coutry -->

                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Made In</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="madein" class="form-control" placeholder="Where is this item from?">
                        </div>
                    
                    </div>
                    <!-- end country -->

                    <!-- start image -->

                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">image</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="image" class="form-control" placeholder="Name of the item">
                        </div>
                    
                    </div>
                    <!-- end image -->

                    <!-- start status -->

                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Status</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <select name="status" class="form-control">
                                <option value="0">Select Status</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Old</option>
                            </select>
                        </div>
                    
                    </div>
                    <!-- end status -->

                    <!-- start members -->

                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Member</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <select name="member" class="form-control">
                                <option value="0">Select Member</option>
                                <?php
                                    $stmt = $con->prepare('SELECT * FROM users WHERE GroupID!=1 AND RegStatus =1');
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach($users as $user){
                                        echo '<option value="'.$user['userID'].'">'.$user['Username'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    
                    </div>
                    <!-- end members -->

                    <!-- start categories -->

                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Category</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <select name="category" class="form-control">
                                <option value="0">Select Category</option>
                                <?php
                                    $stmt = $con->prepare('SELECT * FROM categories');
                                    $stmt->execute();
                                    $categories = $stmt->fetchAll();
                                    foreach($categories as $category){
                                        echo '<option value="'.$category['ID'].'">'.$category['Name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    
                    </div>
                    <!-- end categories -->

                    <!-- start btn -->
                    
                    <div class="form-group form-group-lg">
                        
                        <div class="col-sm-offset-2 col-sm-10 col-md-4">
                            <input type="submit" value="Add item" class="btn btn-primary btn-sm">
                        </div>
                    
                    </div>
                    
                    <!-- end btn -->
                </form>
            
            </div>

<?php   
        }elseif($do == 'insert'){
            //page title
            echo '<h1 class="text-center">Add New Item</h1>
            <div class="container">';
                //check if the HTTP request is POST
                if($_SERVER['REQUEST_METHOD']=='POST'){
                        
                        //present the page

                        

                        //get the data from the form
                        $name           = $_POST['name'];
                        $description    = $_POST['description'];
                        $price          = $_POST['price'];
                        $country        = $_POST['madein'];
                        $image          = $_POST['image'];
                        $status         = $_POST['status'];
                        $member         = $_POST['member'];
                        $category       = $_POST['category'];
                        //check for errors
                        $formErrors= array();
                        if(empty($name)){
                            $formErrors[]='Specify the name of the item';
                        }
                        if(empty($price)){
                            $formErrors[]='Specify the Price of the item';
                        }
                        if(empty($image)){
                            $formErrors[]='Select an image to Upload';
                        }
                        if($member == 0){
                            $formErrors[]='Select a Member';
                        }
                        if($category == 0){
                            $formErrors[]='Select category';
                        }
                        if(!empty($formErrors)){
                            foreach ($formErrors as $error){
                               echo '<div class="alert alert-danger">'.$error.'</div>';

                            }
                            echo '<a href="'.$_SERVER['HTTP_REFERER'].'" class="btn btn-danger">OK</a>';
                            

                        }else{

                            //inset the data to the database 
                            $stmt = $con->prepare('INSERT INTO items(Name, Description, Price, AddDate, CountryMade, Image, Status, MemberID, CatID) 
                            VALUES(:name, :description, :price, now(), :madin, :image, :status, :memberid, :catid )');
                            $stmt->execute(array(
                                'name'          => $name,
                                'description'   => $description,
                                'price'         => $price,
                                'madin'         => $country,
                                'image'         => $image,
                                'status'        => $status,
                                'memberid'      => $member,
                                'catid'         => $category
                            ));
                            redirectHome($stmt->rowCount() . ' Item Added', 'success');


                        }
                        

                }else{
                        $errorMsg = 'this page is not available for such idiots like you';
                        redirectHome($errorMsg, 'danger');
                    }
            echo '</div>';
        }elseif($do == 'edit'){
            //check if get request userid is numeric and get the integar value from it
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
            
            //select all data depend on this id 
            $stmt = $con -> prepare("SELECT * FROM items WHERE ItemID= ?");
            //execute the query
            $stmt->execute(array($itemid));
            //fetch the data 
            $item = $stmt->fetch();
            //check if the data of the user existed
            $count = $stmt->rowCount();
            //if the id exist change the form
            if($count >0){
?>
                <h1 class="text-center">Edit Item</h1>
                <div class="container">
                
                    <form action="?do=update" method="POST" class="form-horizontal">
                        <input type="hidden" value = "<?php echo $itemid ?>" name="itemid">


                        <!-- start name -->

                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Name</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="name" class="form-control" placeholder="Name of the item"  value="<?php echo $item['Name'] ?>">
                            </div>
                        
                        </div>

                        <!-- end username -->

                        <!-- start description -->
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Description</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="description" class="form-control" placeholder="Description of the item"  value="<?php echo $item['Description'] ?>">
                            </div>
                        
                        </div>
                        <!-- end description -->

                        <!-- start price -->

                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Price</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="price" class="form-control" placeholder="Price of the item"  value="<?php echo $item['Price'] ?>">
                            </div>
                        
                        </div>
                        <!-- end price -->

                        <!-- start coutry -->

                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Made In</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="madein" class="form-control" placeholder="Where is this item from?"  value="<?php echo $item['CountryMade'] ?>">
                            </div>
                        
                        </div>
                        <!-- end country -->

                        <!-- start image -->

                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">image</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="image" class="form-control" placeholder="Name of the item">
                            </div>
                        
                        </div>
                        <!-- end image -->

                        <!-- start status -->

                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Status</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <select name="status" class="form-control">
                                    
                                    <option value="1" <?php if($item['Status']==1){echo 'selected';} ?> >New</option>
                                    <option value="2" <?php if($item['Status']==2){echo 'selected';} ?> >Like New</option>
                                    <option value="3" <?php if($item['Status']==3){echo 'selected';} ?> >Used</option>
                                    <option value="4" <?php if($item['Status']==4){echo 'selected';} ?> >Old</option>
                                </select>
                            </div>
                        
                        </div>
                        <!-- end status -->


                        <!-- start categories -->

                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2 control-label">Category</label>
                            
                            <div class="col-sm-10 col-md-4">
                                <select name="category" class="form-control">
                                    
                                    <?php
                                        $stmt = $con->prepare('SELECT * FROM categories');
                                        $stmt->execute();
                                        $categories = $stmt->fetchAll();
                                        foreach($categories as $category){
                                            echo '<option value="'.$category['ID'].'"'; 
                                            if($item['CatID']==$category['ID']){echo 'selected';} echo '>'.$category['Name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        
                        </div>
                        <!-- end categories -->

                        <!-- start btn -->
                        
                        <div class="form-group form-group-lg">
                            
                            <div class="col-sm-offset-2 col-sm-10 col-md-4">
                                <input type="submit" value="Save item" class="btn btn-primary btn-sm">
                            </div>
                        
                        </div>
                        
                        <!-- end btn -->
                    </form>
                
                </div>

<?php       
            //if the user does not exist , show error
            }else{
                redirectHome('No Such Id' , 'danger');
            }
        }elseif($do == 'update'){
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                echo "<h1 class = 'text-center'>Update Item</h1>";
                echo "<div class='container'>";

                    //get the values from the form

                    $itemid         = $_POST['itemid'];
                    $name           = $_POST['name'];
                    $description    = $_POST['description'];
                    $price          = $_POST['price'];
                    $country        = $_POST['madein'];
                    $image          = $_POST['image'];
                    $status         = $_POST['status'];
                    $category       = $_POST['category'];
                    
                    if(empty($name)){
                        $formErrors[]='Specify the name of the item';
                    }
                    if(empty($price)){
                        $formErrors[]='Specify the Price of the item';
                    }
                    if(empty($image)){
                        $formErrors[]='Select an image to Upload';
                    }
                    if($category == 0){
                        $formErrors[]='Select category';
                    }
                    if(!empty($formErrors)){
                        foreach ($formErrors as $error){
                            echo '<div class = "alert alert-danger">' . $error . '</div>';
                        }
                        echo '<a href="'.$_SERVER['HTTP_REFERER'].'" class="btn btn-danger">Damn it</a>';

                    }else{
                        //update the database
                        $stmt=$con->prepare('UPDATE items SET Name=?, Description=?, Price=?, CountryMade=?, Image=?, Status=?, CatID=? WHERE ItemID=?');
                        $stmt->execute(array($name, $description, $price, $country, $image, $status, $category, $itemid));
                        redirectHome($stmt->rowCount() . ' Item Updated' , 'success');

                }
                echo '</div';
                
                
            }else{
                redirectHome('this page is not available for such idiots like you', 'danger');
            }
        }elseif($do == 'delete'){

            echo "  <h1 class = 'text-center'>Delete Member</h1>
                    <div class='container'>";
            //check if the itemid request is numeric and exists and get the integer value from it
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
            $exist = checkItem('ItemID', 'items', $itemid);
            if($exist>0){

                //select the data depending on this id
                // $stmt = $con->prepare('SELECT itemid FROM items WHERE ItemID =? ');
                // $stmt->execute(array($itemid));
                // $check = $stmt->rowCount();
                
                $stmt = $con->prepare('DELETE FROM items WHERE ItemID = :itemid');
                $stmt->bindParam('itemid', $itemid);
                $stmt->execute();
                
                redirectHome('1 Item Deleted', 'success');

            }else{
                
                redirectHome('no such id', 'danger');

            }
            echo '</div>';

                
            
        }elseif($do == 'approve'){
            echo "<h1 class = 'text-center'>Approve Item</h1>";
            echo "<div class='container'>";
            
                //check if item id is exist and numeric
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

                //check if this id exist in the database
                $exist = checkItem('itemid', 'items', $itemid);

                if($exist>0){
                    $stmt = $con->prepare('UPDATE items SET Approve =1, AddDate = now() WHERE ItemID =?');
                    $stmt->bindParam('itemid', $itemid);
                    $stmt->execute(array($itemid));

                    redirectHome($stmt->rowCount().'Item Approved', 'success');
                }else{
                    redirectHome('no such id', 'danger');
                }
            
            echo "</div>";
        }

        include $tpl . 'footer.inc.php' ;
    }else{
        header('Location: index.php');
        exit();
    }
