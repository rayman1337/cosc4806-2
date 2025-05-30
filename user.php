<?php

require_once('database.php');

class User {

    public function get_all_users() {
        $db = db_connect();
        if (!$db) {
            return []; 
        }

        $statement = $db->prepare("SELECT * FROM users;");
        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);
        return $rows;
    }

}

?>
