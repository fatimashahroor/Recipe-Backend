<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require '../../models/recipe.php';

    $recipe = new Recipe();
    $result = $recipe->readAll();
    $result = $result->get_result();
    $recipes= array();

    if($result->num_rows == 0){
        echo json_encode(["message" => "No recipes found"]);
        exit();
    }

    while($row = $result->fetch_assoc()){
        if(!empty($recipes) && end($recipes)['recipe_id'] == $row['recipe_id']){
            $recipes[array_key_last($recipes)]['ingredients'][] = $row['ingredient_name'];
        }elseif(empty($recipes) || end($recipes)['recipe_id'] != $row['recipe_id']){
            $newRecipe = [
                'recipe_id' => $row['recipe_id'],
                'recipe_name' => $row['recipe_name'],
                'created_by' => $row['full_name'],
                'recipe_desc' => $row['recipe_desc'],
                'ingredients' => [
                    $row['ingredient_name']
                ]];
            array_push($recipes, $newRecipe);
        }
        
    }
    echo json_encode($recipes);
?>