<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// database connection will be here
// files needed to connect to database
include_once '../config/database.php';
include_once '../objects/staff.php';
include_once '../objects/profile.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate product object
$staff = new Staff($db);
$profile = new Profile($db);
 
// submitted data will be here
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$staff->fullname = $data->fullname;
$staff->usersname = $data->usersname;
$staff->email = $data->email;
$staff->password = $data->password;
 
// use the create() method here
// create the user
if(!$staff->emailExists() &&
    !empty($staff->fullname) &&
    !empty($staff->email) &&
    !empty($staff->password) &&
    $staff->create()
){
 
    $username = $data->usersname;
    $id = 0;
    $con = mysqli_connect("localhost","root","Pa55w0rd@1","staffprofile");

    $query_id = mysqli_query($con, "SELECT id FROM login WHERE usersname='$username'");
    $row_id = mysqli_fetch_array($query_id, 1);
    $id = $row_id['id'];
    
   
     // set product profile values
    /*  $profile->firstname = '';
     $profile->lastname = $data->fullname;
     $profile->email = $data->email;
     $profile->profile_pic = 'images/avatar.png';
     $profile->phone1 = '';
     $profile->phone2 = '';
     $profile->faculty = 'None';
     $profile->department = 'None';
     $profile->designation = 'None';
     $profile->gender = 'None';
     $profile->office_address = 'None';
     $profile->biography = 'None';
     $profile->profile_show = 'NO';
     $profile->username = $id; */
    
     $insert_profile = mysqli_query($con, "INSERT INTO profile(firstname,lastname,email,gender,profile_pic,
                                                                    phone1,phone2,faculty,department,designation,office_address,biography,
                                                                    profile_show,username) VALUES('','$data->fullname','$data->email','None',
                                                                    'avatar.png','','','None','None','None','None','None','NO',$id);");
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "Staff was created."));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create staff." . $staff->password));
}
?>