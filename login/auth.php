<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST");

require(__DIR__ .'/../models/user.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $user = new User();
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'];
    $password = $data['password'];
    $stmt = $user->login($email, $password);
    $stmt->store_result();
    $stmt->bind_result($id, $email, $hashed_password, $name);
    $stmt->fetch();
    $user_exists = $stmt->num_rows;


    if ($user_exists == 0) {
        $res['message'] = "user not found";
    } else {

        if (password_verify($password, $hashed_password)) {
            $res['status'] = 'authenticated';
            $res['user_id'] = $id;
            $res['full_name'] = $name;
            $res['email'] = $email;
        } else {
            $res['status'] = "wrong password";
        }
    }
} else {
    echo json_encode(["error" => "Wrong request method"]);
}
echo json_encode($res);
?>