<?php
require_once("common.php");
require_once("classes/query.php");
session_start();
use_common_page_header();

$conn = mysqli_connect('localhost', "root", "", "mockdb");

$order_date = date("Y-m-d H:i:s");
#echo $order_date;
$order_total = $_SESSION["invoice_total"];
#echo $_SESSION["user_login_id"];
$user_id = $_SESSION["user_login_id"];
$distance_price = round(floatval($_SESSION["distance"]) / 10, 2);
$date_received = $_SESSION["datetime"];
$branch = $_SESSION["branch"];
#echo $_SESSION["subtotal"];
$subtotal = $_SESSION["subtotal"];
$address = $_SESSION["address"];
$distance = $_SESSION["distance"];

$sql1 = "INSERT INTO Truck(truck_code, availability_code) VALUES ('123', '456')";
mysqli_query($conn, $sql1);

$truck_id = mysqli_insert_id($conn);

$sql2 = "INSERT INTO Shopping(store_code, total_price) VALUES ('$branch', '$subtotal');";
mysqli_query($conn, $sql2);

$receipt_id = mysqli_insert_id($conn);

$sql3 = "INSERT INTO Trip(source_code, destination_code, distance, truck_id, price) 
        VALUES ('$branch','$address', '$distance', '$truck_id', '$distance_price')";

mysqli_query($conn, $sql3);

$trip_id = mysqli_insert_id($conn);

$sql4 = "INSERT INTO `Order`(date_issued, date_received, total_price, payment_code, user_id, trip_id, receipt_id) 
        VALUES ('$order_date', '$date_received', '$order_total', '200', '$user_id', '$trip_id', '$receipt_id')";
mysqli_query($conn, $sql4);
?>

Successful order!

<?php
use_common_page_footer();
?>