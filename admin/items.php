<?php

    // copy template
    // you can use this template on all pages

    session_start();
    $pageTitle = 'Template';
    if(isset($_SESSION['Username'])){
        include 'init.php';
      
        $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;
      
        if($do == 'manage'){
            echo 'welcome to' . $do . 'page';
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
                    <!-- start name -->
                    <div class="form-group form-group-lg">
                    
                        <label class="col-sm-2 control-label">Description</label>
                        
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="description" class="form-control" placeholder="Name of the item">
                        </div>
                    
                    </div>
                    <!-- end username -->

                    <!-- start btn -->
                    <div class="form-group form-group-lg">
                        
                        <div class="col-sm-offset-2 col-sm-10 col-md-4">
                            <input type="submit" value="Add item" class="btn btn-primary">
                        </div>
                    
                    </div>
                    <!-- end btn -->
                </form>
            
            </div>

<?php   
        }elseif($do == 'insert'){
            echo 'welcome to' . $do . 'page';
        }elseif($do == 'edit'){
            echo 'welcome to' . $do . 'page';
        }elseif($do == 'update'){
            echo 'welcome to' . $do . 'page';
        }elseif($do == 'delete'){
            echo 'welcome to' . $do . 'page';
        }elseif($do == 'activate'){
            echo 'welcome to' . $do . 'page';
        }

        include $tpl . 'footer.inc.php' ;
    }else{
        header('Location: index.php');
        exit();
    }
