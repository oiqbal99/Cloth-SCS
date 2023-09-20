<?php

/**
 * This Cart API supports operations to the Cart and helps to interface between
 * JavaScript and PHP logic.
 */

header("Content-Type: application/json");
require_once("../classes/cart.php");

Cart::initialize();

$response = array();

$called_func = $_POST["fn"];

switch ($called_func) {
    case "add_item":
        $item_id = $_POST["args"][0];
        Cart::add_item($item_id);
        $response["message"] = "Successfully added item of ID: $item_id";
        break;
    default:
        $response["message"] = "Unknown function: $called_func";
        break;
}

$response["cart_arr"] = Cart::as_array();

echo(json_encode($response));

?>