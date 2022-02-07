<?php
// заголовки 
header("Access-Control-Allow-Origin: http://authentication-jwt/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 include_once 'config/database.php';
 include_once 'objects/user.php';

 $database = new Database();
 $db = $database->getConnection();

$user = new User($db);

 $data = json_decode(file_get_contents("php://input"));

 $user->email = $data->email;
 $email_exists = $user->emailExixts();

 include_once 'config/core.php';
 include_once 'libs/php-jwt-master/src/BeforeValidException.php';
 include_once 'libs/php-jwt-master/src/ExpiredException.php';
 include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
 include_once 'libs/php-jwt-master/src/JWT.php';
 use \Firebase\JWT\JWT;

 if ($email_exists && password_verify($data->password, $user->password)) {

    $token = array(
      "iss" => $iss, //адрес или мя удостоверяющего центра  
      "aud" => $aud, //имя клиента для которого выпущен токен
      "iat" => $iat, //время когда был выпущен JWT
      "nbf" => $nbf, //время начиная с которого может быть использован
      "data" => array(
        "id" => $user->id,
        "firstname" => $user->firstname,
        "lastname" => $user->lastname,
        "email" => $user->rmail
    )
    );
 }
else {
    http_response_code(401);
    echo json_encode(array("message"=> "login error"));
}
?>