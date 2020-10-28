<?php

    /* 
    =======================================================================
    **  getTitle function v 1.0
    **  this function set the title for each page according the
        global variable.
    =======================================================================
    */ 
    function getTitle(){
        global $pageTitle;
        if(isset($pageTitle)){
            echo $pageTitle;
        }else{
            
            echo 'Default';
        }
    }

    /* 
    ========================================================================
    **  redirectHome function v 1.0
    **  this function redirect the user after displaying an error msj.
    **  redirect function | this function accept parameters
    **  $errorMsj = echo the error message
    **  $seconds = seconds before redirecting
    =========================================================================
    */ 
    function redirectHome($msg, $msgType, $url=null, $seconds =3){
        $url = null ? 'index.php' : isset( $_SERVER['HTTP_REFERER'])  &&  !empty($_SERVER['HTTP_REFERER']) ?  $_SERVER['HTTP_REFERER'] : 'index.php';
        
        echo "<div class='container'>
              <div class='alert alert-" . $msgType . "'>$msg</div>
              <div class='alert alert-info'>You will be redirected to the $url page after $seconds seconds.</div>
              </div>";
        header("refresh:$seconds;url=$url");
        exit();
    }

    /* 
    ========================================================================
    **  checkItem function v 1.0
    **  function to check item in database[functtion accept parameters].
    **  $select = to select item from database [example: user, item, category]
    **  $from = to specify which database to select from [example: users, items, categories]
    **  $value = the value need to be selected [example: username, itemname, categoryname]
    =========================================================================
    */ 
    function checkItem($select, $from, $value){
        global $con ; //to set the global value of the connection statement
        $stmt = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
        $stmt->execute(array($value));
        $count = $stmt->rowCount();
        return $count;
        
        
    }

    /* 
    ========================================================================
    **  checkCount function v 1.0
    **  function to count the specific rows[functtion accept parameters].
    **  $item = to select item from database [example: user, item, category]
    **  $table = to specify which database to select from [example: users, items, categories]
    =========================================================================
    */ 
    function countItems($item, $table, $condition=1 ){

        global $con;
        
        $stmt = $con->prepare("SELECT COUNT($item) FROM $table WHERE $condition");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /* 
    ========================================================================
    **  getLatest Records function v 1.0
    **  function to get the latest items from database[functtion accept parameters].
    **  $item  = to select item from database [example: user, item, category]
    **  $table = to specify which database to select from [example: users, items, categories]
    **  itemID = to use it for ordering the items decending or assending
    **  $limit = how much maximum items to fetch
    =========================================================================
    */ 
    function getLatest($item, $table, $itemID, $condition = 1, $limit = 5){
        global $con;
        $getStmt = $con->prepare("SELECT $item FROM $table WHERE $condition ORDER BY $itemID DESC LIMIT $limit");
        $getStmt->execute();
        $rows = $getStmt->fetchAll();
        return $rows;
    }



