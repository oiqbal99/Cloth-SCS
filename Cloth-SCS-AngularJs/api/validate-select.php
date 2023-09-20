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
        $tableName = $_POST['tableSelect'];
        echo "<h1>Table Selected: ".$_POST['tableSelect']."</h1>";

        if(strcmp($tableName, "Review") == 0){

            //Generate Variables for Order Table
            $reviewId = trim($_POST["reviewId"]);
        
            require_once("classes/query.php");
            $result = Query::run("SELECT * FROM Review WHERE id=$reviewId");
            while($row = $result->fetch_assoc()) {
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
                                <td>{$row["id"]} </td>
                                <td>{$row["rating_number"]}</td>
                                <td>{$row["review_text"]} </td>
                                <td>{$row["user_id"]} </td>
                            
                            </tr>
                        </table>
                    <br></br>
                REVIEW;
            }
        }

        if(strcmp($tableName, "Order") == 0){

            //Generate Variables for Order Table
            $orderId = trim($_POST["orderid"]);
        
            require_once("classes/query.php");
            $result = Query::run("SELECT * FROM `order` WHERE id=$orderId");
                while($row = $result->fetch_assoc()) {
                    echo <<<REVIEW
                        
                        <br></br>
                        
                            <table> 
                                <tr>
                                    <th>Order Id</th>
                                    <th>Date Issued </th>
                                    <th>Date Received</th>
                                    <th>Price </th>
                                </tr>
                                <tr>
                                    <td>{$row["id"]} </td>
                                    <td>{$row["date_issued"]}</td>
                                    <td>{$row["date_received"]} </td>
                                    <td>{$row["total_price"]} </td>
                                
                                </tr>
                            </table>
                        <br></br>
                    REVIEW;
                }
            }

            if(strcmp($tableName, "Item") == 0){

                //Generate Variables for Item Table
                $itemId = trim($_POST["itemId"]);
                
                require_once("classes/query.php");
                $result = Query::run("SELECT * FROM $tableName WHERE id=$itemId");
                while($row = $result->fetch_assoc()) {
                    echo <<<ITEM
                        
                        <br></br>
                        
                            <table> 
                                <tr>
                                    <th>Item Id</th>
                                    <th>Name</th>
                                    <th>Source</th>
                                    <th>Price </th>
                                </tr>
                                <tr>
                                    <td>{$row["id"]} </td>
                                    <td>{$row["name"]}</td>
                                    <td>{$row["source"]} </td>
                                    <td>{$row["price"]} </td>
                                </tr>
                            </table>
                        <br></br>
                    ITEM;
                }

            }
            
            if(strcmp($tableName, "Truck") == 0){
                //Generate Variables for Truck Table
                $truckId = trim($_POST["truckId"]);
                require_once("classes/query.php");
                $result = Query::run("SELECT * FROM $tableName WHERE id=$truckId");
                while($row = $result->fetch_assoc()) {
                    echo <<<TRUCK
                    
                        <br></br>
                        
                            <table> 
                                <tr>
                                    <th>Truck Id</th>
                                    <th>Truck Code </th>
                                    <th>Availability Code</th>
                                </tr>
                                <tr>
                                    <td>{$row["id"]} </td>
                                    <td>{$row["truck_code"]}</td>
                                    <td>{$row["availability_code"]} </td>
                                </tr>
                            </table>
                        <br></br>
                    TRUCK;
                }
            }
            
            if(strcmp($tableName, "User") == 0){

                //Generate Variables for User Table
                $userId = trim($_POST["userId"]);
                

                require_once("classes/query.php");
                $result = Query::run("SELECT * FROM $tableName WHERE id=$userId");
                while($row = $result->fetch_assoc()) {
                    echo <<<USER
                    
                        <br></br>
                        
                            <table> 
                                <tr>
                                    <th>Login Id</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Email</th>
                                </tr>
                                <tr>
                                    <td>{$row["login_id"]} </td>
                                    <td>{$row["name"]}</td>
                                    <td>{$row["password"]} </td>
                                    <td>{$row["email"]} </td>
                                </tr>
                            </table>
                        <br></br>
                    USER;
                }

            }

            if(strcmp($tableName, "Shopping") == 0){
                //Generate Variables for Shopping Table
                $shoppingId = trim($_POST["shoppingId"]);
            

                require_once("classes/query.php");
                $result = Query::run("SELECT * FROM $tableName WHERE id=$shoppingId");
                while($row = $result->fetch_assoc()) {
                    echo <<<SHOPPING
                        <br></br>
                        
                            <table> 
                                <tr>
                                    <th>Shopping Id</th>
                                    <th>Store Code</th>
                                    <th>Total Price</th>  
                                </tr>
                                <tr>
                                    <td>{$row["id"]} </td>
                                    <td>{$row["store_code"]}</td>
                                    <td>{$row["total_price"]} </td>
                                </tr>
                            </table>
                        <br></br>
                    SHOPPING;
                }
            }

            if(strcmp($tableName, "Trip") == 0){
                ////Generate Variables for Trip Table
                $tripId = trim($_POST["tripId"]);
            
                require_once("classes/query.php");
                $result = Query::run("SELECT * FROM $tableName WHERE id=$tripId");
                while($row = $result->fetch_assoc()) {
                    echo <<<TRIP
                        <br></br>
                            <table> 
                                <tr>
                                    <th>Trip Id</th>
                                    <th>Source Code</th>
                                    <th>Destination Code</th>  
                                    <th>Distance</th>  
                                </tr>
                                <tr>
                                    <td>{$row["id"]} </td>
                                    <td>{$row["source_code"]}</td>
                                    <td>{$row["destination_code"]} </td>
                                    <td>{$row["distance"]} </td>
                                </tr>
                            </table>
                        <br></br>
                    TRIP;
                }
            }

    ?>

    </body>
</html>

<?php
require_once("common.php");
use_common_page_footer();
?>
