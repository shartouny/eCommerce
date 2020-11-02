<?php
   $pageTitle ='eCommerce | Categories';
    include "init.php";
?>

    <div class="container">
        <h1 class="text-center"><?php echo str_replace('-', ' ', $_GET['pagename']) ?></h1>
        <?php
            $items=getItems($_GET['id']);
            foreach($items as $item){
                if(!empty($items)){
                    echo '
                    <a href="#">
                        <div class="col-md-3 col-sm-6">
                            <div class="stat st-members">
                                <div class="thumbnail item-box">
                                    <span class="price-tag">'.$item['Price'].'</span>
                                    <img class="img-responsive" src="laptop.jpeg" alt="Not Found">
                                    <div class="caption">
                                        <h3>'.$item['Name'].'</h3>
                                        <p>'.$item['Description'].'</p>

                                        
                                    </div>
                                </div>    
                            </div>
                        </div>
                    </a>
                    ';
                }else{
                    echo 'No Items Available';
                }
            }
        ?>
    </div>

<?php
    include $tpl . "footer.inc.php";  
?>

