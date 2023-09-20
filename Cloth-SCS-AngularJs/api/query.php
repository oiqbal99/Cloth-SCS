<?php

class Query {
    /*
    This class provides a quick static interface to perform an SQL query.
    */
    public static function run($sql) {
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 'mockdb';
        $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
        $result = $mysqli->query($sql);
        $mysqli->close();
        return $result;
    }
}

if (isset($_POST['sql'])) {
    // get the SQL query from POST data
    $sql = $_POST['sql'];
    $result = Query::run($sql);
    $rows = array();
    while (!is_bool($result) && $row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    // return results as JSON string
    echo json_encode($rows);
}
?>
