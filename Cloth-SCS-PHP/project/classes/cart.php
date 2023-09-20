<?php

require_once("query.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Cart {
    /*
    This class provides a quick static interface to perform an SQL query.
    */

    public static function initialize() {
        // Attempt to initialize cart in $_SESSION
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    public static function add_item($product_id) {
        // Add an item to the cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }
    }

    public static function remove_item($product_id) {
        // Remove an item from the cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]--;
            if ($_SESSION['cart'][$product_id] <= 0) {
                unset($_SESSION['cart'][$product_id]);
            }
        }
    }

    public static function get_cost() {
        // Get the total price of all items in the cart
        $total = 0;
        foreach ($_SESSION['cart'] as $product_id => $item_count) {
            $product = Query::run("SELECT * FROM Item WHERE id = $product_id")->fetch_assoc();
            $total += $product['price'] * $item_count;
        }
        return $total;
    }

    public static function get_size() {
        // Get the total number of items in the cart
        $count = 0;
        foreach ($_SESSION['cart'] as $item_count) {
            $count += $item_count;
        }
        return $count;
    }

    public static function as_array() {
        // Get the cart data as an array of products with their count and total price
        $cart_data = array();
        foreach ($_SESSION['cart'] as $product_id => $item_count) {
            $product = Query::run("SELECT * FROM item WHERE id=$product_id")->fetch_assoc();
            $product_total = $product['price'] * $item_count;
            $cart_data[] = array(
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'count' => $item_count,
                'total' => $product_total,
            );
        }
        return $cart_data;
    }
}

?>