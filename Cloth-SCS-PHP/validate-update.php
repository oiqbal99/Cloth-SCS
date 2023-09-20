<?php
require_once("common.php");
session_start();
use_common_page_header();
?>

<html>
<style>
    th {
        margin: 10px;
        border-style: solid;
        text-align: left;
        word-wrap: break-word;
        min-width: 150px;
    }
</style>
    <body>
        <?php


         $tableName = trim($_POST["tableSelect"]);
         echo "<h1>Table Updated: ".$_POST['tableSelect']."</h1>";
         if(strcmp($tableName, "Review") == 0){
     
             $rating_number = "";
             $review_text = "";
             $item_number = "";
             $user_id ="";
             $reviewId = trim($_POST["mReviewId"]);
     
             $result = Query::run("SELECT * FROM Review WHERE id=$reviewId");
             while($row = $result->fetch_assoc()) {
                 $rating_number = $row["rating_number"];
                 $review_text = $row["review_text"];
                 $item_number = $row["item_id"];
                 $user_id = $row["user_id"];    
             }
     
             if(trim($_POST["ratingNumber"]) != null){$rating_number = trim($_POST["ratingNumber"]);}
             if(trim($_POST["reviewText"]) != null){$review_text = trim($_POST["reviewText"]);}
             if(trim($_POST["itemNumber"]) != null){$item_number = trim($_POST["itemNumber"]);}
             if(trim($_POST["mUserId"]) != null){$user_id = trim($_POST["mUserId"]);}
     
     
     
             $update_query = <<<QUERY
                     UPDATE Review SET user_id='$user_id'
                     , item_id='$item_number' 
                     , review_text='$review_text'
                     , rating_number='$rating_number'
                      WHERE id='$reviewId'
                 QUERY;
             Query::run($update_query);

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
                                <td>{$reviewId} </td>
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
     
                 $orderid = trim($_POST["orderId"]);
                 $dateReceived = "";
                 $totalPrice = "";
                 $paymentCode= "";
                 $userId = "";
                 $tripId = "";
                 $receiptId = "";
                 $completed ="";
     
                 $result = Query::run("SELECT * FROM `order` WHERE id='$orderid'");
                 while($row = $result->fetch_assoc()) {
                     $dateIssued =$row["date_issued"];
                     $dateReceived = $row["date_received"];
                     $totalPrice = $row["total_price"];
                     $paymentCode= $row["payment_code"];
                     $userId = $row["user_id"];
                     $tripId = $row["trip_id"];
                     $receiptId = $row["receipt_id"];
                     $completed = $row["completed"];
                 }
     
                 if(trim($_POST["dateIssued"]) != null){$dateIssued = trim($_POST["dateIssued"]);}
                 if(trim($_POST["dateReceived"]) != null){$dateReceived = trim($_POST["dateReceived"]);}
                 if(trim($_POST["totalPrice"]) != null){$totalPrice = trim($_POST["totalPrice"]);}
                 if(trim($_POST["paymentCode"]) != null){$paymentCode = trim($_POST["paymentCode"]);}
                 if(trim($_POST["userId"]) != null){$userId = trim($_POST["userId"]);}
                 if(trim($_POST["tripId"]) != null){$tripId = trim($_POST["tripId"]);}
                 if(trim($_POST["receiptId"]) != null){$receiptId = trim($_POST["receiptId"]);}
                 if(trim($_POST["orderIsComp"]) != null){$completed = trim($_POST["orderIsComp"]);}
                 
                 require_once("classes/query.php");
                 $update_query = <<<QUERY
                     UPDATE `Order` SET date_issued='$dateIssued'
                     , date_received='$dateReceived' 
                     , total_price='$totalPrice'
                     , payment_code='$paymentCode'
                     , user_id='$userId'
                     , trip_id='$tripId'
                     , completed='$completed'
                     , receipt_Id='$receiptId' WHERE id='$orderid'
                 QUERY;
                 Query::run($update_query);
             
             }
         
             if(strcmp($tableName, "Item") == 0){
                 //Generate Variables for Item Table
                 $itemId = trim($_POST["iItemId"]);
                 $itemName ="";
                 $itemPrice ="";
                 $itemSource ="";
                 $itemDepart="";
                 $itemUrl="";
     
                 $result = Query::run("SELECT * FROM Item WHERE id='$itemId'");
                 while($row = $result->fetch_assoc()) {
                     $itemName =$row["name"];
                     $itemPrice = $row["price"];
                     $itemSource = $row["source"];
                     $itemDepart= $row["department"];
                     $itemUrl=$row["image_url"];
                 }
     
                if(trim($_POST["itemName"]) != null){$itemName = trim($_POST["itemName"]);}
                if(trim($_POST["itemPrice"]) != null){$itemPrice = trim($_POST["itemPrice"]);}
                if(trim($_POST["itemSource"]) != null){$itemSource = trim($_POST["itemSource"]);}
                if(trim($_POST["itemDest"]) != null){$itemDepart= trim($_POST["itemDest"]);}
                if(trim($_POST["itemUrl"]) != null){$itemUrl= trim($_POST["itemUrl"]);}
        
                require_once("classes/query.php");
                $update_query = <<<QUERY
                     UPDATE $tableName SET name='$itemName'
                     , price='$itemPrice' 
                     , source='$itemSource'
                     , department='$itemDepart'
                     , image_url = '$itemUrl'
                     WHERE id='$itemId'
                QUERY;
                Query::run($update_query);
            }
     
            if(strcmp($tableName, "User") == 0){
     
             //Generate Variables for User Table
            $userid = trim($_POST["uUserId"]);
            $loginId = "";
            $userPass = "";
            $userName = "";
            $userEmail= "";
            $userPhone = "";
            $userAddress = "";
            $userCC= "";
            $balance= "";
            $isAdmin="";
     
            $result = Query::run("SELECT * FROM User WHERE id='$userid'");
            while($row = $result->fetch_assoc()) {
                $loginId = $row["login_id"];
                $userPass = $row["password"];
                $userName = $row["name"];
                $userEmail= $row["email"];
                $userPhone = $row["phone"];
                $userAddress = $row["address"];
                $userCC= $row["city_code"];
                $balance= $row["balance"];
                 $isAdmin=$row["is_admin"];
     
            }
     
             if(trim($_POST["loginId"]) != null){$loginId = trim($_POST["loginId"]);}
             if(trim($_POST["userPass"]) != null){$userPass = trim($_POST["userPass"]);}
             if(trim($_POST["userName"]) != null){$userName = trim($_POST["userName"]);}
             if(trim($_POST["userEmail"]) != null){$userEmail= trim($_POST["userEmail"]);}
             if(trim($_POST["userPhone"]) != null){$userPhone = trim($_POST["userPhone"]);}
             if(trim($_POST["userAddress"]) != null){$userAddress = trim($_POST["userAddress"]);}
             if(trim($_POST["userCC"]) != null){$userCC = trim($_POST["userCC"]);}
             if(trim($_POST["userBalance"]) != null){$balance = trim($_POST["userBalance"]);}
             if(trim($_POST["userIsAdmin"]) != null){$isAdmin = trim($_POST["userIsAdmin"]);}
     
     
            //$userIsAdmin = trim($_POST["userIsAdmin"]);
     
            require_once("classes/query.php");
            $update_query = <<<QUERY
                     UPDATE $tableName SET login_id='$loginId'
                     , password='$userPass' 
                     , name='$userName'
                     , email='$userEmail'
                     , phone='$userPhone' 
                     , address='$userAddress'
                     , city_code='$userCC'
                     , balance='$balance'
                     , is_admin='$isAdmin'
                     WHERE id='$userid'
                QUERY;
                Query::run($update_query);
        }
        
        if(strcmp($tableName, "Trip") == 0){
         ////Generate Variables for Trip Table
         
     
         $tripId = trim($_POST["tTripId"]);
     
         $srcCode ="";
         $destCode = "";
         $tripDist = "";
         $tripTruckId="";
         $tripPrice = "";
     
     
         $result = Query::run("SELECT * FROM Trip WHERE id='$tripId'");
            while($row = $result->fetch_assoc()) {
                $srcCode = $row["source_code"];
                $destCode = $row["destination_code"];
                $tripDist = $row["distance"];
                $tripTruckId= $row["truck_id"];
                $tripPrice = $row["price"];
            }
     
     
         if(trim($_POST["srcCode"]) != null){$srcCode = trim($_POST["srcCode"]);}
         if(trim($_POST["destCode"]) != null){$destCode = trim($_POST["destCode"]);}
         if(trim($_POST["tripDist"]) != null){$tripDist= trim($_POST["tripDist"]);}
         if(trim($_POST["tripTruckId"]) != null){$tripTruckId= trim($_POST["tripTruckId"]);}
         if(trim($_POST["tripPrice"]) != null){$tripPrice = trim($_POST["tripPrice"]);}
     
         require_once("classes/query.php");
            $update_query = <<<QUERY
                     UPDATE $tableName SET source_code='$srcCode'
                     , destination_code='$destCode' 
                     , distance='$tripDist'
                     , truck_id='$tripTruckId'
                     , price='$tripPrice' 
                     WHERE id='$tripId'
                QUERY;
                Query::run($update_query);
         } 
     
     
         
         if(strcmp($tableName, "Shopping") == 0){
             //Generate Variables for Shopping Table
            
             $shoppingId = trim($_POST["sStoreId"]);
             $storeCode = "";
             $shoppingPrice = "";
     
     
             $result = Query::run("SELECT * FROM Shopping WHERE id='$shoppingId'");
             while($row = $result->fetch_assoc()) {
                $storeCode = $row["store_code"];
                $shoppingPrice = $row["total_price"];
            }
     
             if(trim($_POST["storeCode"]) != null){$storeCode = trim($_POST["storeCode"]);}
             if(trim($_POST["shoppingPrice"]) != null){$shoppingPrice = trim($_POST["shoppingPrice"]);}
     
             require_once("classes/query.php");
             $update_query = <<<QUERY
                     UPDATE $tableName SET store_code='$storeCode'
                     , total_price='$shoppingPrice' 
                     WHERE id='$shoppingId'
                QUERY;
                Query::run($update_query);
         }
     
     
         if(strcmp($tableName, "Truck") == 0){
             //Generate Variables for Truck Table
     
             $truckId = trim($_POST["mTruckId"]); 
             $truckCode = "";
             $availCode = "";
     
             $result = Query::run("SELECT * FROM Truck WHERE id='$truckId'");
             while($row = $result->fetch_assoc()) {
                $truckCode = $row["truck_code"];
                $availCode = $row["availability_code"];
             }
     
     
             if(trim($_POST["tTruckCode"]) != null){$truckCode = trim($_POST["tTruckCode"]);}
             if(trim($_POST["truckAvailCode"]) != null){$availCode = trim($_POST["truckAvailCode"]);}
     
             require_once("classes/query.php");
             $update_query = <<<QUERY
                 UPDATE $tableName SET truck_code='$truckCode' , availability_code='$availCode' WHERE id='$truckId'
             QUERY;
             Query::run($update_query);
         }
        ?>
    </body>
</html>