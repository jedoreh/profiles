<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// files for decoding jwt will be here
// required to encode json web token
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/profile.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$profile = new Profile($db);
  
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";

// decode jwt here
// if jwt is not empty
if($jwt){
 
    // if decode succeed, show user details
    try {
 
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));


        // set ID property of product to be edited
        $profile->id = $data->id;
        
        // set product property values
        $profile->firstname = $data->firstname;
        $profile->lastname = $data->lastname;
        $profile->email = $data->email;
        $profile->gender = $data->gender;
        $profile->profile_pic = $data->profile_pic;
        $profile->phone1 = $data->phone1;
        $profile->phone2 = $data->phone2;
        $profile->faculty = $data->faculty;
        $profile->department = $data->department;
        $profile->designation = $data->designation;
        $profile->office_address = $data->office_address;
        $profile->biography = $data->biography;
        $profile->profile_show = $data->profile_show;
        $profile->username = $data->username;


                
        // update the product
        if($profile->update()){
        
            // set response code - 200 ok
            http_response_code(200);
        
            // tell the user
            echo json_encode(array("message" => "Profile was updated."));
        }
        
        // if unable to update the product, tell the user
        else{
        
            // set response code - 503 service unavailable
            http_response_code(503);
        
            // tell the user
            echo json_encode(array("message" => "Unable to update profile."));
        }
    }
       // catch failed decoding will be here
    // if decode fails, it means jwt is invalid
    catch (Exception $e){
    
        // set response code
        http_response_code(401);
    
        // show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }

}
// error message if jwt is empty will be here
// show error message if jwt is empty
else{
 
    // set response code
    http_response_code(401);
 
    // tell the user access denied
    echo json_encode(array("message" => "Access denied."));
}    
  


?>