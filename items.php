<?php
    session_start();
    include 'init.php';
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
    
    //select all data depend on this id 
    $stmt = $con -> prepare("SELECT * FROM items WHERE ItemID= ?");
    //execute the query
    $stmt->execute(array($itemid));
    //fetch the data 
    $item = $stmt->fetch();
    //check if the data of the user existed
    $count = $stmt->rowCount();
    
    
    $pageTitle= $item['Name'];
?>
<h1 class="text-center"><?php echo $item['Name'] ?></h1>
<?php

    include $tpl .'footer.inc.php';

?>


