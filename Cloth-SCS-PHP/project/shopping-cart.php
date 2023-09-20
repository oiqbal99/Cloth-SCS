<?php
require_once("common.php");
session_start();
use_common_page_header();

if (!isset($_SESSION["user_login_id"])) {
    header("Location: .");
    exit();
}

echo "<h1>Shopping Cart</h1>";

if (isset($_SESSION["cart"])) {
    require_once("classes/query.php");

    foreach ($_SESSION["cart"] as $product => $count) {
        // Display the product name, image, price, and count
        $result = Query::run("SELECT * FROM item WHERE id = " . intval($product));
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo <<<PRODUCT
            <div class="cart-item">
                <img src="{$row["image_url"]}" alt="{$row["name"]}" class="no-user-select" width="40" height="40">
                <div class="cart-item-description">
                    <span><b>{$row["name"]}</b></span>
                    <br>
                    <span>\${$row["price"]} x {$count}</span>
                </div>
            </div>
            <br>
            PRODUCT;
        }
    }
}

use_common_page_footer();
?>
