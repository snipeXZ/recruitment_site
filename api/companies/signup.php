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
include_once '../../models/Companies.php';

//variables for error messages
$company_name_err = "";
$email_err = "";
$password_err = "";
$con_password_err = "";

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Company object
$company = new Companies($db);

//Processes data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    //Check if company name field is empty
    if(empty(trim($data->name))) {
        $company_name_err = "Please enter your company name";
        echo json_encode(array('message' => "$company_name_err"));
        die();
    } else {
        $company->name = trim($data->name);
    }

    //Check if email field is empty
    if(empty(trim($data->email))) {
        $email_err = "Please enter your email";
        echo json_encode(array('message' => "$email_err"));
        die();
    } else {
        $company->email = trim($data->email);
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
        $company->password = trim($data->password);
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
        $company->password = trim($data->password);
    }

    //If there are no errors .... Try signing company up
    if(empty($company_name_err) && empty($password_err) && empty($con_password_err)) {
        if($company->signup()){
            if(!$company->exist){
                http_response_code(201);
                echo json_encode(array('message' => 'Company created successfully'));
                die();
            } else {
                echo json_encode(array('message' => "$company->exist"));
            }
        } else {
            echo json_encode(array('message' => "Company not created"));
        }
    }

}