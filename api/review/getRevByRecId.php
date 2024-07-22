<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    
    require (__DIR__ .'/../../models/review.php');

    $review= new Review();
    parse_str($_SERVER['QUERY_STRING'], $queryParams);

    $results = $review->selectReviewsByRecipeId($queryParams['recipe_id']);
    $results = $results->get_result();
    $reviews_arr = array();
    if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) 
            $reviews_arr[] = $row;
        echo json_encode($reviews_arr);
    } else 
        echo json_encode(["message" => "No reviews found"]);

?>