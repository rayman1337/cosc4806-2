<?php

require_once 'config.php';

function db_connect() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_PORT);
    if ($conn->connect_error) {
        die("There was an error connecting to the database: " . $conn->connect_error);
    }
    return $conn;
}

?>
