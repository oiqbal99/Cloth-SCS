<?php

session_start();

unset($_SESSION["user_login_id"]);
unset($_SESSION["cart"]);

$referrer = $_SERVER['HTTP_REFERER'] ?? ".";
header("Location: .");

?>