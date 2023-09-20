<?php
require_once("common.php");
session_start();
use_common_page_header();
?>

<html>  
    <body>
        <?php
        
        //Check which table to insert into
    $tableName = trim($_POST["tableSelect"]);
    echo "<h1>Table Deleted: ".$_POST['tableSelect']."</h1>";
    if(strcmp($tableName, "Review") == 0){

        //Generate Variables for Order Table
        $reviewId = trim($_POST["reviewId"]);
       
        require_once("classes/query.php");
        $delete_query = <<<QUERY
                DELETE FROM Review WHERE id='$reviewId' 
            QUERY;
            Query::run($delete_query);
            echo "<h5> Deleted Review with ID: $reviewId </h5>";
        
    }
    
    if(strcmp($tableName, "Order") == 0){

    //Generate Variables for Order Table
    $orderId = trim($_POST["orderid"]);
   
    require_once("classes/query.php");
    $delete_query = <<<QUERY
            DELETE FROM `order` WHERE id='$orderId' 
        QUERY;
        Query::run($delete_query);
    
    }

    if(strcmp($tableName, "Item") == 0){

         //Generate Variables for Item Table
        $itemId = trim($_POST["itemId"]);
        
        require_once("classes/query.php");
        $delete_query = <<<QUERY
            DELETE FROM $tableName WHERE id='$itemId' 
        QUERY;
        Query::run($delete_query);

    }
    
    if(strcmp($tableName, "Truck") == 0){
        //Generate Variables for Truck Table
        $truckId = trim($_POST["truckId"]);
        require_once("classes/query.php");
        $delete_query = <<<QUERY
                DELETE FROM $tableName WHERE id='$truckId' 
            QUERY;
            Query::run($delete_query);
    }
    
    if(strcmp($tableName, "User") == 0){

         //Generate Variables for User Table
        $userId = trim($_POST["userId"]);
        

        require_once("classes/query.php");
        $delete_query = <<<QUERY
                DELETE FROM $tableName WHERE id='$userId' 
            QUERY;
            Query::run($delete_query);

    }

    if(strcmp($tableName, "Shopping") == 0){
        //Generate Variables for Shopping Table
        $shoppingId = trim($_POST["shoppingId"]);
      

        require_once("classes/query.php");
        $delete_query = <<<QUERY
                DELETE FROM $tableName WHERE id='$shoppingId' 
            QUERY;
            Query::run($delete_query);
    }

    if(strcmp($tableName, "Trip") == 0){
        ////Generate Variables for Trip Table
        $tripId = trim($_POST["tripId"]);
       

        require_once("classes/query.php");
        $delete_query = <<<QUERY
                DELETE FROM $tableName WHERE id='$tripId' 
            QUERY;
            Query::run($delete_query);
    } 
        ?>
    </body>
</html>


<?php 
use_common_page_footer();
?>