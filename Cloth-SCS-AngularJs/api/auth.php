<?php

/**
 * This Auth API supports operations to the flow of all authentication in
 * this application.
 */

header("Content-Type: application/json");
session_start();
require_once("./query.php");

$response = array();

$called_func = $_POST["fn"];
$used_args = $_POST["args"] ?? [];

switch ($called_func) {
    case "sign_up":

        $login_id     = $used_args[0];
        $password_raw = $used_args[1];
        $name         = $used_args[2];
        $email        = $used_args[3];
        $address      = $used_args[4];
        $phone        = $used_args[5];
        $city_code    = $used_args[6];
        $is_admin     = $used_args[7] ?? "0";
        
        $rand_salt = base64_encode(random_bytes(12));
        $password_salted_hashed = md5($password_raw . $rand_salt);

        $result = Query::run("
            INSERT INTO User (login_id, password, name, email, address, phone, city_code, salt, is_admin) VALUES
            ('$login_id', '$password_salted_hashed', '$name', '$email', '$address', '$phone', '$city_code', '$rand_salt', '$is_admin')
        ");

        $response["message"] = "Successfully added user: $login_id";
        break;

    case "sign_in":

        $login_id = $used_args[0];
        $password = $used_args[1];

        $result = Query::run("
            SELECT id, salt, password FROM User WHERE login_id = '$login_id'
        ");
        $row = $result->fetch_assoc();

        if ($row === NULL) {
            $response["error_flag"] = 1;
            $response["message"] = "User is not found: $login_id";
        }
        else {
            $password_salted_hashed = md5($password . $row["salt"]);
            if ($password_salted_hashed !== $row["password"]) {
                $response["error_flag"] = 1;
                $response["message"] = "User is found, but incorrect password: $password";
            }
            else {
                $user_id = $row["id"];
                $_SESSION["user_id"] = $user_id;
                $response["success_flag"] = 1;
                $response["message"] = "Successfully logged in as user ID: $user_id";
            }
        }
        break;

    case "sign_out":

        unset($_SESSION["user_id"]);
        $response["message"] = "Successfully signed out and removed current session";
        break;

    case "get_session_user":

        if (!isset($_SESSION["user_id"])) {
            $response["result"] = array("is_logged_in" => 0);
            break;
        }
        $user_id = $_SESSION["user_id"];
        $result = Query::run("
            SELECT id, login_id, is_admin FROM User WHERE id = '$user_id'
        ");
        $row = $result->fetch_assoc();
        $response["result"]["id"] = $row["id"];
        $response["result"]["login_id"] = $row["login_id"];
        $response["result"]["is_admin"] = intval($row["is_admin"] ?? "0");
        $response["result"]["is_logged_in"] = 1;
        $response["message"] = "Getting data of session user ID: $user_id";
        break;
        
    default:

        $response["message"] = "Unknown function: $called_func";
        break;
}

echo(json_encode($response));

?>