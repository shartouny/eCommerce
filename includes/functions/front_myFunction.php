<?php

    // /* 
    // =======================================================================
    // **  getTitle function v 1.0
    // **  this function set the title for each page according the
    //     global variable.
    // =======================================================================
    // */ 
    // function getTitle(){
    //     global $pageTitle;
    //     if(isset($pageTitle)){
    //         echo $pageTitle;
    //     }else{
            
    //         echo 'Default';
    //     }
    // }

    // /* 
    // ========================================================================
    // **  redirectHome function v 1.0
    // **  this function redirect the user after displaying an error msj.
    // **  redirect function | this function accept parameters
    // **  $errorMsj = echo the error message
    // **  $seconds = seconds before redirecting
    // =========================================================================
    // */ 
    // function redirectHome($msg, $msgType, $url=null, $seconds =3){
    //     $url = null ? 'index.php' : isset( $_SERVER['HTTP_REFERER'])  &&  !empty($_SERVER['HTTP_REFERER']) ?  $_SERVER['HTTP_REFERER'] : 'index.php';
        
    //     echo '<div class="alert alert-'.$msgType.'">'. $msg .'</div>
    //             <a href="'.$url.'" class="btn btn-primary">ok</a>';
    //     exit();
    // }

    // /* 
    // ========================================================================
    // **  checkItem function v 1.0
    // **  function to check item in database[functtion accept parameters].
    // **  $select = to select item from database [example: user, item, category]
    // **  $from = to specify which database to select from [example: users, items, categories]
    // **  $value = the value need to be selected [example: username, itemname, categoryname]
    // =========================================================================
    // */ 
    // function checkItem($select, $from, $value){
    //     global $con ; //to set the global value of the connection statement
    //     $stmt = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    //     $stmt->execute(array($value));
    //     $count = $stmt->rowCount();
    //     return $count;
        
        
    // }

    // /* 
    // ========================================================================
    // **  checkCount function v 1.0
    // **  function to count the specific rows[functtion accept parameters].
    // **  $item = to select item from database [example: user, item, category]
    // **  $table = to specify which database to select from [example: users, items, categories]
    // =========================================================================
    // */ 
    // function countItems($item, $table, $condition=1 ){

    //     global $con;
        
    //     $stmt = $con->prepare("SELECT COUNT($item) FROM $table WHERE $condition");
    //     $stmt->execute();
    //     return $stmt->fetchColumn();
    // }

    // /* 
    // ========================================================================
    // **  get categories Records function v 1.0
    // **  function to get categories from database[functtion accept parameters].
    // =========================================================================
    // */ 
    function getCat(){
        global $con;
        $getStmt = $con->prepare("SELECT * FROM categories ORDER BY ID DESC");
        $getStmt->execute();
        $categories = $getStmt->fetchAll();
        return $categories;
    }

    // /* 
    // ========================================================================
    // **  get items Records function v 1.0
    // **  function to get items from database[functtion accept parameters].
    // =========================================================================
    // */ 
    function getItems($category,$member=NULL){
        global $con;
        $getStmt = $con->prepare("SELECT * FROM items WHERE CatID = ? ORDER BY ItemID DESC");
        $getStmt->execute(array($category));
        $items = $getStmt->fetchAll();
        return $items;
    }
    // /* 
    // ========================================================================
    // **  checUserStatus v 1.0
    // **  function to check the status for user [functtion accept parameters].
    // **  $user = is the user you want to check his status
    // =========================================================================
    // */ 
    function checkUserStatus($user){
        global $con;
        $stmt = $con -> prepare("SELECT Username, RegStatus , Password 
                                FROM users WHERE Username= ? AND RegStatus = 0");
        $stmt->execute(array($user));
        $count = $stmt->rowCount();
        return $count;
    }


