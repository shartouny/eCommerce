<?php
    session_start();
    $pageTitle= 'Create New Ad';
    include 'init.php';
    if(isset($_SESSION['user'])){
        

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $formErrors = array();
        $name           = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $description    = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price          = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $country        = filter_var($_POST['madein'], FILTER_SANITIZE_STRING);
        $image          = filter_var($_POST['image'], FILTER_SANITIZE_NUMBER_INT);
        $status         = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
        $category       = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

        if(empty($name)){
            $formErrors[] = 'Specify the name of the item';
        }
        if(empty($description)){
            $formErrors[] = 'Describe the item in 1 sentence';
        }
        if(empty($price)){
            $formErrors[] = 'Specify the price of the item';
        }
        if(empty($country)){
            $formErrors[] = 'Where is this item from';
        }
        if($status == 0){
            $formErrors[] = 'Specify the status of the item';
        }
        if($category == 0){
            $formErrors[] = 'Specify in which category this item might be';
        }
        if(!empty($formErrors)){
            foreach($formErrors as $error){
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
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
                'catid'         => $category,
                'memberid'      => $_SESSION['userid']
            ));
            redirectHome($stmt->rowCount() . ' Item Added', 'success');


        }
}
    
?>
<h1 class="text-center">Create New Ad</h1>
<div class="create-ad block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Create New Ad</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <form action="?do=insert" method="POST" class="form-horizontal">
                            <!-- start name -->

                            <div class="form-group form-group-lg">
                            
                                <label class="col-sm-2 control-label">Name</label>
                                
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="name" data-class=".live-title" class="form-control live" placeholder="Name of the item">
                                </div>
                            
                            </div>

                            <!-- end username -->

                            <!-- start description -->
                            <div class="form-group form-group-lg">
                            
                                <label class="col-sm-2 control-label">Description</label>
                                
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="description" data-class=".live-description" class="form-control live" placeholder="Description of the item">
                                </div>
                            
                            </div>
                            <!-- end description -->

                            <!-- start price -->

                            <div class="form-group form-group-lg">
                            
                                <label class="col-sm-2 control-label">Price</label>
                                
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="price" data-class=".live-price" class="form-control live" placeholder="Price of the item">
                                </div>
                            
                            </div>
                            <!-- end price -->

                            <!-- start coutry -->

                            <div class="form-group form-group-lg">
                            
                                <label class="col-sm-2 control-label">Made In</label>
                                
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="madein" class="form-control" placeholder="Where is this item from?">
                                </div>
                            
                            </div>
                            <!-- end country -->

                            <!-- start image -->

                            <div class="form-group form-group-lg">
                            
                                <label class="col-sm-2 control-label">image</label>
                                
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="image" class="form-control" placeholder="Name of the item">
                                </div>
                            
                            </div>
                            <!-- end image -->

                            <!-- start status -->

                            <div class="form-group form-group-lg">
                            
                                <label class="col-sm-2 control-label">Status</label>
                                
                                <div class="col-sm-10 col-md-9">
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

                            <!-- start categories -->

                            <div class="form-group form-group-lg">
                            
                                <label class="col-sm-2 control-label">Category</label>
                                
                                <div class="col-sm-10 col-md-9">
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
                    <div class="col-md-4">
                        <div class="thumbnail item-box live-preview">
                            <span class="price-tag">$<span class="live-price">0</span></span>
                            <img class="img-responsive" src="laptop.jpeg" alt="Not Found">
                            <div class="caption">
                                <h3 class="live-title">Title</h3>
                                <p class="live-description">Description</p>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

    }else{
        header('Location: login.php');
        exit();
    }
    include $tpl .'footer.inc.php';

?>