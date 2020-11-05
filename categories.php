<?php
   $pageTitle ='eCommerce | Categories';
   session_start();
    include "init.php";
?>

    <div class="container">
        <h1 class="text-center"><?php echo str_replace('-', ' ', $_GET['pagename']) ?></h1>
        <div class="row">
            <?php
                $items=getItems('CatID',$_GET['id']);
                foreach($items as $item){
                    if(!empty($items)){
                        echo '
                        <a href="#">
                            <div class="col-md-3 col-sm-6">
                                <div class="stat st-members">
                                    <div class="thumbnail item-box">
                                        <span class="price-tag">$'.$item['Price'].'</span>
                                        <img class="img-responsive" src="laptop.jpeg" alt="Not Found">
                                        <div class="caption">
                                            <h2>'.$item['Owner'].'</h2>
                                            <h3>'.$item['Name'].'</h3>
                                            <p>'.$item['Description'].'</p>
                                            <div class="date">'.$item['AddDate'].'</div>
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
    </div>

<?php
    include $tpl . "footer.inc.php";  
?>

