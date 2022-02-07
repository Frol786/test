<?php
header("Acces-Control-Allow-Origin: http://authentication-jwt/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: Post");
header("Access-Control-Max-Age: 3600");
header("Access-Control_Allow_Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->firstname = $data->firstname;
$user->lastname = $data->lastname;
$user->email = $data->email;
$user->password = $data->password;

if (
	!empty($user->firstname) &&
	!empty($user->email) &&
	!empty($user->password) &&
	$user->create()
) {
	http_response_code(200);
	echo json_encode(array("message"=> "user created"));
}

else {
	http_response_code(400);
	echo json_encode(array("message" => "error when creating a user"));
}
?>