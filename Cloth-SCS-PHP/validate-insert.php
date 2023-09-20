<?php
require_once("common.php");
session_start();
use_common_page_header();
?>

<html>
    <body>
        <?php 
             $tableName = trim($_POST["tableSelect"]);

             echo "<h1>Table Inserted: ".$_POST['tableSelect']."</h1>";

             if(strcmp($tableName, "Review") == 0){
         
             $rating_number = $_POST["ratingNumber"];
             $review_text = trim($_POST["reviewText"]);
             $item_number = trim($_POST["itemNumber"]);
             $user_id = trim($_SESSION["user_login_id"]);
             require_once("classes/query.php");
             $insert_query = <<<QUERY
                     INSERT INTO REVIEW
                     (user_id, item_id, rating_number, review_text)
                     VALUES
                     ('$user_id', '$item_number', '$rating_number', '$review_text')
             QUERY;
             Query::run($insert_query);

             echo <<<REVIEW
                    <br></br>
                        <table> 
                            <tr>
                                <th>Review Id</th>
                                <th>Rating Number </th>
                                <th>Review text</th>
                                <th>User ID</th>
                            </tr>
                            <tr>
                                <td>{$review_text} </td>
                                <td>{$rating_number}</td>
                                <td>{$item_number} </td>
                                <td>{$user_id} </td>
                            </tr>
                        </table>
                    <br></br>
                REVIEW;
         
             }
             
             if(strcmp($tableName, "Order") == 0){
         
             //Generate Variables for Order Table
            
                 $dateIssued = trim($_POST["dateIssued"]);
                 $dateReceived = trim($_POST["dateReceived"]);
                 $totalPrice = $_POST["totalPrice"];
                 $paymentCode= trim($_POST["paymentCode"]);
                 $userId = trim($_POST["userId"]);
                 $tripId = trim($_POST["tripId"]);
                 $receiptId = trim($_POST["receiptId"]);
                 $completed = trim($_POST["orderIsComp"]);
         
                 require_once("classes/query.php");
                 $insert_query = <<<QUERY
                 INSERT INTO `order`(`date_issued`, `date_received`, `total_price`, `payment_code`, `user_id`, `trip_id`, `receipt_id`, `completed`) VALUES ('$dateIssued','$dateReceived','$totalPrice','$paymentCode','$userId','$tripId','$receiptId','$completed')
                 QUERY;
                 Query::run($insert_query);
             
             }
         
             if(strcmp($tableName, "Item") == 0){
         
                  //Generate Variables for Item Table
                 
                 $itemName = trim($_POST["itemName"]);
                 $itemPrice = trim($_POST["itemPrice"]);
                 $itemSource = trim($_POST["itemSource"]);
                 $itemDepart= trim($_POST["itemDest"]);
                 $itemUrl = trim($_POST["itemUrl"]);
         
                 require_once("classes/query.php");
                 $insert_query = <<<QUERY
                     INSERT INTO $tableName
                     (name, price, source, department, image_url)
                     VALUES
                     ('$itemName', '$itemPrice', '$itemSource', '$itemDepart', '$itemUrl')
                 QUERY;
                 Query::run($insert_query);
         
             }
             
             if(strcmp($tableName, "Truck") == 0){
                 //Generate Variables for Truck Table
                
                 $truckCode = trim($_POST["truckCode"]);
                 $availCode = trim($_POST["availCode"]);
         
                 require_once("classes/query.php");
                 $insert_query = <<<QUERY
                     INSERT INTO $tableName
                     (truck_code, availability_code)
                     VALUES
                     ('$truckCode', '$availCode')
                 QUERY;
                 Query::run($insert_query);
             }
             
             if(strcmp($tableName, "User") == 0){
         
                  //Generate Variables for User Table
                 
                 $loginId = trim($_POST["loginId"]);
                 $userPass = trim($_POST["userPass"]);
                 $userName = trim($_POST["userName"]);
                 $userEmail= trim($_POST["userEmail"]);
                 $userPhone = trim($_POST["userPhone"]);
                 $userAddress = trim($_POST["userAddress"]);
                 $userCC = trim($_POST["userCC"]);
                 $isAdmin = trim($_POST["userIsAdmin"]);
                 $balance = trim($_POST["userBalance"]);
         
                 require_once("classes/query.php");
                 $insert_query = <<<QUERY
                     INSERT INTO $tableName
                     (login_id, password, name, email, phone, address, city_code, balance,is_admin)
                     VALUES
                     ('$loginId', '$userPass', '$userName', '$userEmail', '$userPhone', '$userAddress', '$userCC', '$balance', '$isAdmin')
                 QUERY;
                 Query::run($insert_query);
         
             }
         
             if(strcmp($tableName, "Shopping") == 0){
                 //Generate Variables for Shopping Table
                
                 $storeCode = trim($_POST["storeCode"]);
                 $shoppingPrice = trim($_POST["shoppingPrice"]);
         
                 require_once("classes/query.php");
                 $insert_query = <<<QUERY
                     INSERT INTO $tableName
                     (store_code, total_price)
                     VALUES
                     ('$storeCode', '$shoppingPrice')
                 QUERY;
                 Query::run($insert_query);
             }
         
             if(strcmp($tableName, "Trip") == 0){
                 ////Generate Variables for Trip Table
                 
                 $srcCode = trim($_POST["srcCode"]);
                 $destCode = trim($_POST["destCode"]);
                 $tripDist= trim($_POST["tripDist"]);
                 $tripTruckId= trim($_POST["tripTruckId"]);
                 $tripPrice = trim($_POST["tripPrice"]);
         
                 require_once("classes/query.php");
                 $insert_query = <<<QUERY
                     INSERT INTO $tableName
                     (source_code, destination_code, distance, truck_id, price)
                     VALUES
                     ('$srcCode', '$destCode', '$tripDist', '$tripTruckId', '$tripPrice')
                 QUERY;
                 Query::run($insert_query);
         
             } 
        
        ?>
    </body>
</html>


<?php 

use_common_page_footer();

?>