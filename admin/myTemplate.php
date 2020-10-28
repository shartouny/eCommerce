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
            echo 'welcome to' . $do . 'page';
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
