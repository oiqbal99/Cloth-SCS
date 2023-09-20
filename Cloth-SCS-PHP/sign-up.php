<?php
require_once("common.php");
session_start();
use_common_page_header();

if (isset($_SESSION["user_login_id"])) {
    header("Location: .");
    exit();
}

$username_error = $_SESSION["register_username_error"] ?? "";

echo <<<REGISTER_FORM
<form action="validate-sign-up.php" method="post">
    <div class="sign-wrapper">
        <div class="sign-container">
            <h1>Sign Up</h1>
            <p>Register an account to start using our services.</p>
            <label for="username"><b>Username / Login ID</b></label>
            <input type="text" name="username" autocomplete="username" required>
            <span class="error-text">$username_error</span>
            <label for="email"><b>Email</b></label>
            <input type="email" name="email" autocomplete="email" required>
            <div class="sign-multiple-column">
                <div>
                    <label for="fname"><b>First name</b></label>
                    <input type="text" name="fname" autocomplete="off" required>
                </div>
                <div>
                    <label for="lname"><b>Last name</b></label>
                    <input type="text" name="lname" autocomplete="off" required>
                </div>
            </div>
            <label for="password"><b>Password</b></label>
            <input type="password" name="password" autocomplete="new-password" onChange="onPassChange()" required>
            <label for="password_conf"><b>Confirm Password</b></label>
            <input type="password" name="password_conf" autocomplete="new-password" onChange="onPassChange()" required>
            <div class="sign-multiple-column">
                <div>
                    <label for="phone"><b>Phone #</b></label>
                    <input type="text" name="phone" placeholder="(XXX) YYY-ZZZZ" autocomplete="tel-local" required>
                </div>
                <div>
                    <label for="address"><b>Address</b></label>
                    <input type="text" name="address" autocomplete="street-address" required>
                </div>
            </div>
            <div class="sign-multiple-column sign-end">
                <input type="submit" value="Sign Up">
                <a href="./sign-up-admin.php">For Admins</a>
            </div>
        </div>
    </div>
</form>
REGISTER_FORM;

unset($_SESSION["register_username_error"]);

use_common_page_footer();
?>