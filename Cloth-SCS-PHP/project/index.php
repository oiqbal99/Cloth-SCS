<?php
require_once("common.php");
session_start();
use_common_page_header();

require_once("classes/query.php");
$result = Query::run("SELECT * FROM Item");

echo <<<HOME_PAGE_START
<body onload="initMap()">
    <div class="home-page-container">
        <div id="service-a" class="home-page-service">
            <h1>Service A: Product List</h1>
            <div class="product-list">
HOME_PAGE_START;

while($row = $result->fetch_assoc()) {
    echo <<<PRODUCT
    <div class="product-box" draggable="true" ondragstart="dragProduct(event)">
        <img src="{$row["image_url"]}" alt="{$row["name"]}" draggable="false" class="no-user-select">
        <div class="product-description">
            <span><b>{$row["name"]}</b></span>
            <br>
            <span>\${$row["price"]}</span>
        </div>
        <object data="{$row["id"]}"></object>
    </div>
    PRODUCT;         
}



require_once("classes/cart.php");
Cart::initialize();
$display_service_b = Cart::get_size() > 0;
$service_b_attr = $display_service_b ? "block" : "none";

echo <<<HOME_PAGE_END
            </div>
        </div>
        <form id="delivery-form" action="invoice.php" method="post">
            <div id="service-b" class="home-page-service" style="display: $service_b_attr">
                <h1>Service B: Branch-Destination Picker</h1>
                <div id="map"></div>
                <br>
                <br>
                <label for="datetime">Delivery Date and Time:</label>
                <input type="text" id="datetime" name="datetime">
                <br>
                <br>
                <label for="branch">Delivery Branch:</label>
                <select id="branch" name="branch">
                    <option value="RBC Royal Bank, 200 Bay St. Main Floor, Toronto, ON">Branch A</option>
                    <option value="220 Yonge St, Toronto, ON">Branch B</option>
                    <option value="3401 Dufferin St, Toronto, ON">Branch C</option>
                </select>
                <br>
                <br>
                <label for="address">Delivery Address:</label>
                <input type="text" id="address" name="address"><br>
                <br>
                <br>
                <button id="delivery-form-submit">Use Delivery</button>
                <h2 id="distance"></h2>
                <input type="hidden" id="distance-field" name="distance"><br>
            </div>
            <div id="invoice-sum-redir" class="home-page-service" style="display: none">
                <h1>Proceed to Invoice?</h1>
                <button type="submit">Proceed</button>
            </div>
        </form>
    </div>
</body>
HOME_PAGE_END;

use_common_page_footer();
?>