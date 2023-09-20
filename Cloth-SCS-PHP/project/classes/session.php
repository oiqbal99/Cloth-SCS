<?php

require_once("query.php");

class UserSession {
    /*
    This class provides a quick static interface to perform session operations
    which affect the user.
    */
    public static function get_prop_safely($prop, $default) {
        if (!isset($_SESSION["user_login_id"])) {
            return $default;
        }
        $session_user_id = $_SESSION["user_login_id"];
        $result = Query::run("SELECT * FROM User WHERE id = $session_user_id");
        $found_row = $result->fetch_assoc();
        if ($found_row === NULL) {
            return $default;
        }
        return $found_row[$prop];
    }
}

?>