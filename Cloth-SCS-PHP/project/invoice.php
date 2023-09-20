<?php
require_once("common.php");
session_start();
use_common_page_header();

foreach (array("datetime", "branch", "address", "distance") as $k) {
    $_SESSION[$k] = $_POST[$k];
}

require_once("classes/cart.php");

echo <<<CONFIRM_FORM_START
<form action="confirm-purchase.php" method="post">
    <div class="invoice-wrapper">
        <div class="invoice-container">
            <h1>Invoice Summary</h1>
            <b>Address</b>
            <p>{$_SESSION["address"]}</p>
            <b>Branch</b>
            <p>{$_SESSION["branch"]}</p>
            <b>Delivery Date</b>
            <p>{$_SESSION["datetime"]}</p>
            <hr>
            <table class="item-table">
                <tr>
                    <th width="55%">Item</th>
                    <th>Quantity</th>
                    <th>Unit Cost</th>
                    <th>Amount</th>
                </tr>
CONFIRM_FORM_START;

foreach (Cart::as_array() as $_ => $cart_item) {
    echo <<<BOUGHT_ITEM
    <tr>
        <td>{$cart_item["name"]}</td>
        <td>{$cart_item["count"]}</td>
        <td>\${$cart_item["price"]}</td>
        <td>\${$cart_item["total"]}</td>
    </tr>
    BOUGHT_ITEM;
}

$inv_subtotal = Cart::get_cost();
$inv_distance_fee = round(floatval($_SESSION["distance"]) / 10, 2);
$inv_hst = round(0.13 * ($inv_subtotal + $inv_distance_fee), 2);
$inv_total = round($inv_subtotal + $inv_distance_fee + $inv_hst, 2);

$disp_subtotal = sprintf('%0.2f', $inv_subtotal);
$disp_distance_fee = sprintf('%0.2f', $inv_distance_fee);
$disp_hst = sprintf('%0.2f', $inv_hst);
$disp_total = sprintf('%0.2f', $inv_total);

$_SESSION["invoice_total"] = $inv_total;
$_SESSION["subtotal"] = $inv_subtotal;

echo <<<CONFIRM_FORM_END
            </table>
            
            <br clear="all">
            <div class="invoice-multiple-column invoice-end">
                <input type="submit" value="Place Order">
                <div>
                <table class="sum-table">
                <tr>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td><b>Subtotal:</b></td>
                    <td width="10%"></td>
                    <td>\${$disp_subtotal}</td>
                </tr>
                <tr>
                    <td><b>Distance Fee ($1 / 10km):</b></td>
                    <td width="10%"></td>
                    <td>\${$disp_distance_fee}</td>
                </tr>
                <tr>
                    <td><b>HST (13%):</b></td>
                    <td width="10%"></td>
                    <td>\${$disp_hst}</td>
                </tr>
                <tr>
                    <td colspan="3">--</td>
                </tr>
                <tr>
                    <td><b>Total:</b></td>
                    <td width="10%"></td>
                    <td>\${$disp_total}</td>
                </tr>
            </table>
                </div>
            </div>
        </div>
    </div>
</form>
CONFIRM_FORM_END;

use_common_page_footer();
?>