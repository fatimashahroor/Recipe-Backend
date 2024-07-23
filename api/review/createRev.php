<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

    require (__DIR__ .'/../../models/review.php');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["message" => "Method not allowed"]);
        exit();
    }
    $newReview = new Review();
    $data = json_decode(file_get_contents("php://input"), true);
    $posted_by = $data['posted_by'];
    $recipe_id = $data['recipe_id'];
    $star = $data['star'];
    $comment = $data['comment'];
    $result = $newReview->insertReview($posted_by, $recipe_id, $star, $comment);

    if ($result) 
        echo json_encode(["message" => "Review created successfully"]);
    else 
        echo json_encode(["message" => "Failed to create review"]);
?>