<?php

require_once 'database.php';

$conn = db_connect();

if ($conn) {
    echo "Database connection successful!";
} else {
    echo "Database connection failed!";
}

?>
