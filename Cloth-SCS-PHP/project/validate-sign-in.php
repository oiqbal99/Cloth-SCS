<?php

session_start();

if (isset($_SESSION["user_login_id"])) {
    header("Location: .");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $santz_username = trim($_POST["username"]);
    $santz_password = $_POST["password"];

    $auth_query = "SELECT id FROM User WHERE login_id = '$santz_username' AND password = '$santz_password'";

    require_once("classes/query.php");
    $result = Query::run($auth_query);

    $found_row = $result->fetch_assoc();

    if ($found_row === NULL) {
        $referrer = $_SERVER['HTTP_REFERER'] ?? ".";
        $_SESSION["auth_credentials_error"] = "Invalid identifier or password";
        header('Location: ' . $referrer);
    }
    else {
        $_SESSION["user_login_id"] = $found_row["id"];
        header('Location: .');
    }
}
else {
    header('Location: .');
}

?>