<?php

/**
 * This DBMaintain API supports operations for the "DB Maintain" feature.
 */

header("Content-Type: application/json");
session_start();
require_once("./query.php");

$response = array();

$called_func = $_POST["fn"];
$used_args = $_POST["args"] ?? [];

switch ($called_func) {
    case "delete":
        $table_name = $used_args[0];
        $u = $used_args;
        switch ($table_name) {
            case "Truck":
                $result = Query::run("
                    DELETE FROM `Review` WHERE id='$u[1]';
                ");
                break;
            case "Order":
                $result = Query::run("
                    DELETE FROM `Order` WHERE id='$u[1]';
                ");
                break;
            case "Item":
                $result = Query::run("
                    DELETE FROM `Item` WHERE id='$u[1]';
                ");
                break;
            case "User":
                $result = Query::run("
                    DELETE FROM `User` WHERE id='$u[1]';
                ");
                break;
            case "Shopping":
                $result = Query::run("
                    DELETE FROM `Shopping` WHERE id='$u[1]';
                ");
                break;
            case "Review":
                $result = Query::run("
                    DELETE FROM `Review` WHERE id='$u[1]';
                ");
                break;
            case "Trip":
                $result = Query::run("
                    DELETE FROM `Trip` WHERE id='$u[1]';
                ");
                break;

            default:
                $response["error"] = "Table does not exist: $table_name";
                break;
        }
        $arg_count = count($used_args);
        $response["message"] = "Successful delete in $table_name having $arg_count arguments";
        break;
    case "select":

        $table_name = $used_args[0];
        $record_ids = $used_args[1];

        $santz_record_ids = "";
        foreach (str_split($record_ids) as $char) {
            if (str_contains('1234567890', $char)) {
                $santz_record_ids .= $char;
            }
            elseif ($char === ',' && strlen($santz_record_ids) > 0 && substr($santz_record_ids, -1) !== ',') {
                $santz_record_ids .= ",";
            }
        }
        $santz_record_ids = rtrim($santz_record_ids, ",");

        $result = Query::run("
            SELECT * FROM `$table_name` WHERE id IN ($santz_record_ids)
        ");
        $records = array();
        while ($row = $result->fetch_assoc()) {
            array_push($records, $row);
        }

        $response["result"] = array("records" => $records, "record_count" => count($records));
        $response["message"] = "Successful query of $table_name for records ($santz_record_ids)";
        break;

    case "insert":

        $table_name = $used_args[0];
        $u = $used_args;
        switch ($table_name) {
            case "Truck":
                $result = Query::run("
                    INSERT INTO `Truck` (truck_code, availability_code) VALUES ('$u[1]', '$u[2]');
                ");
                break;
            case "Order":
                $result = Query::run("
                    INSERT INTO `Order` (date_issued, date_received, total_price, payment_code, user_id, trip_id, receipt_id, completed) VALUES ('$u[1]', '$u[2]','$u[3]', '$u[4]','$u[5]', '$u[6]','$u[7]', '$u[8]');
                ");
                break;
            case "Item":
                $result = Query::run("
                    INSERT INTO `Item` (name, price, source, department, image_url) VALUES ('$u[1]', '$u[2]','$u[3]', '$u[4]','$u[5]');
                ");
                break;
            case "User":
                $result = Query::run("
                    INSERT INTO `User` (login_id, password, name, email, phone, address, city_code, balance,is_admin) VALUES ('$u[1]', '$u[2]','$u[3]', '$u[4]','$u[5]', '$u[6]','$u[7]', '$u[8]', '$u[9]');
                ");
                break;
            case "Shopping":
                $result = Query::run("
                    INSERT INTO `Shopping` (store_code, total_price) VALUES ('$u[1]', '$u[2]');
                ");
                break;
            case "Review":
                $result = Query::run("
                    INSERT INTO `Review` (user_id, item_id, rating_number, review_text) VALUES ('$u[1]', '$u[2]', '$u[3]', '$u[4]');
                ");
                break;
            case "Trip":
                $result = Query::run("
                    INSERT INTO `Trip` (source_code, destination_code, distance, truck_id, price) VALUES ('$u[1]', '$u[2]', '$u[3]', '$u[4]', '$u[5]');
                ");
                break;

            default:
                $response["error"] = "Table does not exist: $table_name";
                break;
        }
        $arg_count = count($used_args);
        $response["message"] = "Successful insert into $table_name having $arg_count arguments";
        break;
    case "update":
        $table_name = $used_args[0];
        $u = $used_args;
        switch ($table_name) {
            case "Truck":
                $truckId = $u[1];
                $truckCode = "";
                $availCode = "";

                $result = Query::run("SELECT * FROM Truck WHERE id='$truckId'");
                while($row = $result->fetch_assoc()) {
                   $truckCode = $row["truck_code"];
                   $availCode = $row["availability_code"];
                }
        
                if($u[2] != null){$truckCode = $u[2];}
                if($u[3] != null){$availCode = $u[3];}

                $result = Query::run("
                UPDATE `Truck`  SET truck_code='$truckCode' , availability_code='$availCode' WHERE id='$truckId'
                ");
                break;
            case "Order":

                $orderid = $u[1];
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

                if($u[2] != null){$dateIssued = $u[2];}
                if($u[3] != null){$dateReceived = $u[3];}
                if($u[4] != null){$totalPrice = $u[4];}
                if($u[5] != null){$paymentCode = $u[5];}
                if($u[6] != null){$userId = $u[6];}
                if($u[7] != null){$tripId = $u[7];}
                if($u[8] != null){$receiptId = $u[8];}
                if($u[9] != null){$completed = $u[9];}


                $result = Query::run("
                UPDATE `Order` SET date_issued='$dateIssued'
                , date_received='$dateReceived' 
                , total_price='$totalPrice'
                , payment_code='$paymentCode'
                , user_id='$userId'
                , trip_id='$tripId'
                , completed='$completed'
                , receipt_Id='$receiptId' WHERE id='$orderid'
                ");
                break;
            case "Item":
                 $itemId = $u[1];
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
                 
                if($u[2] != null){$itemName = $u[2];}
                if($u[3] != null){$itemPrice = $u[3];}
                if($u[4] != null){$itemSource = $u[4];}
                if($u[5] != null){$itemDepart = $u[5];}
                if($u[6] != null){$itemUrl = $u[6];}
               

                $result = Query::run("
                UPDATE `Item` SET name='$itemName'
                , price='$itemPrice' 
                , source='$itemSource'
                , department='$itemDepart'
                , image_url = '$itemUrl'
                WHERE id='$itemId'
                ");
                break;
            case "User":

                $userid = $u[1];
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

                if($u[2] != null){$loginId = $u[2];}
                if($u[3] != null){$userPass = $u[3];}
                if($u[4] != null){$userName = $u[4];}
                if($u[5] != null){$userEmail = $u[5];}
                if($u[6] != null){$userPhone = $u[6];}
                if($u[7] != null){$userAddress = $u[7];}
                if($u[8] != null){$userCC = $u[8];}
                if($u[9] != null){$balance = $u[9];}
                if($u[10] != null){$isAdmin = $u[10];}
               

                $result = Query::run("
                UPDATE `User` SET login_id='$loginId'
                , password='$userPass' 
                , name='$userName'
                , email='$userEmail'
                , phone='$userPhone' 
                , address='$userAddress'
                , city_code='$userCC'
                , balance='$balance'
                , is_admin='$isAdmin'
                WHERE id='$userid'
                ");
                break;
            case "Shopping":
                $shoppingId = $u[1];
                $storeCode = "";
                $shoppingPrice = "";

                $result = Query::run("SELECT * FROM Shopping WHERE id='$shoppingId'");
                while($row = $result->fetch_assoc()) {
                   $storeCode = $row["store_code"];
                   $shoppingPrice = $row["total_price"];
               }

               if($u[2] != null){$storeCode = $u[2];}
                if($u[3] != null){$shoppingPrice = $u[3];}

                $result = Query::run("
                UPDATE `Shopping` SET store_code='$storeCode'
                , total_price='$shoppingPrice' 
                WHERE id='$shoppingId'
                ");
                break;
            case "Review":

                $rating_number = "";
                $review_text = "";
                $item_number = "";
                $user_id ="";
                $reviewId = $u[1];
        
                $result = Query::run("SELECT * FROM Review WHERE id=$reviewId");
                while($row = $result->fetch_assoc()) {
                    $rating_number = $row["rating_number"];
                    $review_text = $row["review_text"];
                    $item_number = $row["item_id"];
                    $user_id = $row["user_id"];    
                }
                
                if($u[2] != null){$rating_number = $u[2];}
                if($u[3] != null){$review_text = $u[3];}
                if($u[4] != null){$item_number = $u[4];}
                if($u[5] != null){$user_id = $u[5];}
                
                $result = Query::run("
                UPDATE `Review` SET user_id='$user_id'
                , item_id='$item_number' 
                , review_text='$review_text'
                , rating_number='$rating_number'
                 WHERE id='$reviewId'
                ");
                break;
            case "Trip":
                $tripId = $u[1];
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
     
                if($u[2] != null){$srcCode = $u[2];}
                if($u[3] != null){$destCode = $u[3];}
                if($u[4] != null){$tripDist = $u[4];}
                if($u[5] != null){$tripTruckId = $u[5];}
                if($u[6] != null){$tripPrice = $u[6];}
               

                $result = Query::run("
                UPDATE `Trip` SET source_code='$srcCode'
                , destination_code='$destCode' 
                , distance='$tripDist'
                , truck_id='$tripTruckId'
                , price='$tripPrice' 
                WHERE id='$tripId'
                ");
                break;

            default:
                $response["error"] = "Table does not exist: $table_name";
                break;
        }
        $arg_count = count($used_args);
        $response["message"] = "Successful Update into $table_name having $arg_count arguments";
        break;

    default:

        $response["message"] = "Unknown function: $called_func";
        break;
}

echo(json_encode($response));

?>