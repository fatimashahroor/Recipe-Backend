<?php
    require(__DIR__ .'/../config/connection.php');
    class Review {        
        public $conn;
        public function __construct() {
            $this->conn = dbConnect();
        }
        public function selectReviewsByRecipeId($recipe_id) {
            $query= 'SELECT rv.review_id, rv.star, rv.comment, rv.created_on, u.full_name
            FROM reviews rv
            LEFT JOIN users u ON rv.posted_by = u.user_id
            WHERE rv.recipe_id = ?;';
            $stmt= $this->conn->prepare($query);
            $stmt->bind_param('i',$recipe_id);
            $stmt->execute();
            return $stmt;
        }

        public function insertReview($posted_by, $recipe_id, $star, $comment) {
            $query= 'INSERT INTO reviews 
            (posted_by, recipe_id, star, comment, created_on) 
            VALUES (?,?,?,?,?);';
            $date = date("Y-m-d H:i:s");
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('iiiss', $posted_by, $recipe_id, $star, $comment, $date);
            if ($stmt->execute()) {
                return true;
            } else 
                return false;
        }
    }
?>