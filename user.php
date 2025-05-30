<?php

require_once('database.php');

class User {

    public function get_all_users() {
        $db = db_connect();
        if (!$db) {
           return false; 
        }

        $statement = $db->prepare("SELECT * FROM users;");
        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);
        return $rows;
    }

  public function create_user($username, $password) {
      $db = db_connect();
      if (!$db) {
          return false; 
      }

      try {
          $checkDupeUser = $db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
          $checkDupeUser->execute([$username]);
          $userExists = $checkDupeUser->fetchColumn();  

          if ($userExists) {
              return false;
          }

          $hashed_password = password_hash($password, PASSWORD_DEFAULT);
          $statement = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?);");
          $statement->execute([$username, $hashed_password]);
          return $statement->rowCount();
      } catch (PDOException $ex) {
          error_log("Error creating user: " . $ex->getMessage());
          return false;  
      }
  }

}

?>
