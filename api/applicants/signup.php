<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Applicants.php';

//variables for error message
$first_name_err   = "";
$last_name_err    = "";
$email_err        = "";
$password_err     = "";
$con_password_err = "";

//Instantiate DB & connect
$database = new Database();
$db       = $database->connect();

//Instantiate Applicant post object
$applicant = new Applicant($db);

//Processes data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    //Get raw posted data (from post request)
    $data = json_decode(file_get_contents("php://input"));

    //Check if first_name field is empty
    if(empty(trim($data->first_name))) {
        $first_name_err = "Please enter your first name";
        echo json_encode(array('message' => "$first_name_err"));
        die();
    } else {
        $applicant->first_name = trim($data->first_name);
    }

    //Check if last_name field is empty
    if(empty(trim($data->last_name))) {
        $first_name_err = "Please enter your last name";
        echo json_encode(array('message' => "$last_name_err"));
        die();
    } else {
        $applicant->last_name = trim($data->first_name);
    }

    //Check if email field is empty
    if(empty(trim($data->email))) {
        $email_err = "Please enter your email";
        echo json_encode(array('message' => "$email_err"));
        die();
    } else {
        $applicant->email = trim($data->email);
    }

    //Check if password field is empty
    if(empty(trim($data->password))) {
        $password_err = "Please enter a password";
        echo json_encode(array('message' => "$password_err"));
        die();
    } // Check password length 
    elseif (strlen(trim($data->password)) < 6)
    {
        $password_err = "Password must have at least 6 characters";
        echo json_encode(array('message' => "$password_err"));
        die();
    } else {
        $applicant->password = trim($data->password);
    }

    //Check if confirm password field if empty
    if(empty(trim($data->confirm_password))) {
        $con_password_err = "Please confirm the password";
        echo json_encode(array('message' => "$con_password_err"));
        die();
    }
    //Check password
    elseif(empty($password_err) && (($data->password) != ($data->confirm_password))) {
        $con_password_err = "Password did not match";
        echo json_encode(array('message' => "$con_password_err"));
        die();
    } else {
        $applicant->password = trim($data->password);
    }

    //If there are no errors.... Try signing user up
    if(empty($usernam_err) && empty($password_err) && empty($confirm_password)) {
        if($applicant->signup()) {
            if(!$applicant->exist){
                http_response_code(201);
                echo json_encode(array('message' => 'User created successfully'));
                die();
            } else {
                echo json_encode(array('message' => "$applicant->exist"));
            }
        } else {
            echo json_encode(array('message' => 'User not created'));
        }
    }

}