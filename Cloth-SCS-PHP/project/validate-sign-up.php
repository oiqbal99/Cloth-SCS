<?php

session_start();

if (isset($_SESSION["user_login_id"])) {
    header("Location: .");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $santz_username = trim($_POST["username"]);
    $santz_email = trim($_POST["email"]);
    $santz_name = trim($_POST["fname"]) . " " . trim($_POST["lname"]);
    $santz_password = $_POST["password"];
    $santz_phone = trim($_POST["phone"]);
    $santz_address = trim($_POST["address"]);
    $santz_city_code = substr($santz_phone, 0, 3);
    $is_admin = (isset($_POST["is_admin"]) && $_POST["is_admin"] === '1') ? 1 : 0;

    require_once("classes/query.php");
    $username_check_result = Query::run("SELECT COUNT(*) AS matches FROM User WHERE login_id = '$santz_username'");

    if ($username_check_result->fetch_assoc()["matches"] > 0) {
        $_SESSION["register_username_error"] = "This identifier has already been taken";
        $referrer = $_SERVER['HTTP_REFERER'] ?? ".";
        header('Location: ' . $referrer);
    }
    else {
        unset($_SESSION["register_username_error"]);

        $insert_query = <<<QUERY
            INSERT INTO User
            (login_id, password, name, email, address, phone, city_code, is_admin)
            VALUES
            ('$santz_username', '$santz_password', '$santz_name', '$santz_email', '$santz_address', '$santz_phone', '$santz_city_code', $is_admin)
        QUERY;
        Query::run($insert_query);

        header('Location: ./sign-in.php');
    }
}
else {
    header('Location: .');
}

?>