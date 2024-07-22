<?php
    require(__DIR__ . '/../config/connection.php');
    class Recipe{
        public $conn;

        public function __construct(){
            $this->conn = dbConnect();
        }

        public function readAll(){
            $query = "SELECT r.recipe_id, r.recipe_name, r.created_by, r.recipe_desc, u.full_name, i.ingredient_name 
            FROM recipes_ingredients p
            JOIN recipes r ON p.fk_recipe_id = r.recipe_id
            LEFT JOIN users u ON r.created_by = u.user_id
            JOIN ingredients i ON p.fk_ingredient_id = i.ingredient_id
            ORDER BY r.recipe_id ASC;";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    }
?>