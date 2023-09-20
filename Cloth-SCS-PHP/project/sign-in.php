<?php
require_once("common.php");
session_start();
use_common_page_header();

if (isset($_SESSION["user_login_id"])) {
    header("Location: .");
    exit();
}

$credentials_error = $_SESSION["auth_credentials_error"] ?? "";

echo <<<AUTHENTICATE_FORM
<form action="validate-sign-in.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <h1>Sign In</h1>
            <p>Enter your user or admin credentials here.</p>
            <label for="username"><b>Username / Login ID</b></label>
            <input type="text" name="username" autocomplete="username" required>
            <span class="error-text">$credentials_error</span>
            <label for="password"><b>Password</b></label>
            <input type="password" name="password" autocomplete="current-password" required>
            <span class="error-text">$credentials_error</span>
            <div class="sign-multiple-column sign-end">
                <input type="submit" value="Sign In">
            </div>
        </div>
    </div>
</form>
AUTHENTICATE_FORM;

unset($_SESSION["auth_credentials_error"]);

use_common_page_footer();
?>