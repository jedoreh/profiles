<?php

    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // get database connection
    include_once '../config/database.php';
    
    // instantiate product object
    include_once '../objects/profile.php';

    $database = new Database();
    $db = $database->getConnection();
    
    $profile = new Profile($db);

    // get posted data
    $data = json_decode(file_get_contents("php://input"));

    // make sure data is not empty
    if(
        !empty($data->firstname) &&
        !empty($data->lastname) &&
        !empty($data->email) &&
        !empty($data->profile_pic) &&
        !empty($data->faculty) &&
        !empty($data->department) &&
        !empty($data->profile_show)
    ){
    
        // set product profile values
        $profile->firstname = $data->firstname;
        $profile->lastname = $data->lastname;
        $profile->email = $data->email;
        $profile->profile_pic = $data->profile_pic;
        $profile->phone1 = $data->phone1;
        $profile->phone2 = $data->phone2;
        $profile->faculty = $data->faculty;
        $profile->department = $data->department;
        $profile->designation = $data->designation;
        $profile->gender = $data->gender;
        $profile->office_address = $data->office_address;
        $profile->biography = $data->biography;
        $profile->profile_show = $data->profile_show;

        
        //$product->created = date('Y-m-d H:i:s');
    
        // create the profile
        if($profile->create()){
    
            // set response code - 201 created
            http_response_code(201);
    
            // tell the user
            echo json_encode(array("message" => "Profile was created."));
        }
    
        // if unable to create the product, tell the user
        else{
    
            // set response code - 503 service unavailable
            http_response_code(503);
    
            // tell the user
            echo json_encode(array("message" => "Unable to create profile."));
        }
    }
    
    // tell the user data is incomplete
    else{
    
        // set response code - 400 bad request
        http_response_code(400);
    
        // tell the user
        echo json_encode(array("message" => "Unable to create profile. Data is incomplete."));
    }
  





?>