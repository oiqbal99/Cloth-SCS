<?php
require_once("common.php");
require_once("classes/query.php");
session_start();
use_common_page_header();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Searching Orders</title>
    <style>
        #inputBox {
            position: absolute;
            top: 100px;
            right: 60px;
            padding-right: 30px;
            width: 200px;
        }
        #searchButton {
            position: absolute;
            top: 95px;
            right: 20px;
            border: none;
            background-color: transparent;
            font-size: 20px;
            cursor: pointer;
        }
        th {
        margin: 10px;
        border-style: solid;
        text-align: left;
        word-wrap: break-word;
        min-width: 150px;
    }
    </style>
</head>

<?php
    if(isset($_POST["SubmitButton"])){ 
        $orderID = $_POST['inputBox'];
        $orderID = (int)$orderID; 
        $result = Query::run("SELECT * FROM `Order` WHERE id = $orderID");
        if (!$result) {
            echo 'Could not run query';
            exit;
        }
        $row = $result->fetch_assoc();
        if ((isset($row['completed']))){
            if($row['completed'] == 1){
                echo 'Order ' . $orderID . ' is completed';
            } else if($row['completed'] == 0){
                echo 'Order ' . $orderID . ' is not completed';
            }

            /*$result = Query::run("SELECT * FROM `order` WHERE id=$orderID AND {$_SESSION['user_login_id']}= order.user_id");
            while($row = $result->fetch_assoc()) {
            echo <<<ORDER
                
                <br></br>
                <h3>ORDER</h3>
                    <table> 
                        <tr>
                            <th>Order Id</th>
                            <th>Date Issued </th>
                            <th>Date Received</th>
                            <th>Price </th>
                            <th>Payment Code </th>
                            <th>User</th>
                            <th>Trip Id</th>
                            <th>Receipt Id</th>
                            <th>Completed</th>
                        </tr>
                        <tr>
                            <td>{$row["id"]} </td>
                            <td>{$row["date_issued"]}</td>
                            <td>{$row["date_received"]} </td>
                            <td>{$row["total_price"]} </td>
                            <td>{$row["payment_code"]} </td>
                            <td>{$row["user_id"]}</td>
                            <td>{$row["trip_id"]} </td>
                            <td>{$row["receipt_id"]} </td>
                            <td>{$row["completed"]} </td>
                           
                        </tr>
                    </table>
                <br></br>
            ORDER;
            }
            */
        }
        else{
            echo 'Order ' . $orderID . ' does not exist';
        }

        
    
    }    
?>
<body>
    <form action="" method="post">
        <input type="text" id="inputBox" name="inputBox" placeholder="OrderID">
        <button type="submit" id="searchButton" name="SubmitButton">&#x1F50D;</button>
    </form>
</body>
</html>

<?php
use_common_page_footer();
?>