<?php
    require (__DIR__ .'/../config/connection.php');
    class User{

        private $conn;

        public function __construct(){
            $this->conn = dbConnect();
        }

        public function login($email, $password){
            $stmt = $this->conn->prepare('SELECT user_id, email, password, full_name
            FROM users 
            where email=?');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            return $stmt;
        }
    }
?>