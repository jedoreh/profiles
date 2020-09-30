<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/profile.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$profile = new Profile($db);
  
// set ID property of record to read
$profile->username = isset($_GET['id']) ? $_GET['id'] : die();
  
// read the details of product to be edited
$profile->readOne();
  
if($profile->lastname!=null){
    // create array
    $profile_arr = array(
        "id" => $profile->id,
        "firstname" => $profile->firstname,
        "lastname" => $profile->lastname,
        "email" => $profile->email,
        "gender" => $profile->gender,
        "profile_pic" => $profile->profile_pic,
        "phone1" => $profile->phone1,
        "phone2" => $profile->phone2,
        "faculty" => $profile->faculty,
        "department" => $profile->department,
        "designation" => $profile->designation,
        "office_address" => $profile->office_address,
        "biography" => $profile->biography,
        "profile_show" => $profile->profile_show,
        "username" => $profile->username
  
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($profile_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Profile does not exist."));
}
?>