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
$email_err = "";
$password_err = "";

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Company object
$company = new Companies($db);

//Processes data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    //Check if email field is empty
    if(empty(trim($data->email))) {
        $email_err = "Please enter an email";
        echo json_encode(array("message" => "$email_err"));
        die();
    } else {
        $company->email = trim($data->email);
    }

    //Check if password field is empty
    if(empty(trim($data->password))){
        $password_err = "Please enter a password";
        echo json_encode(array("message" => "$password_err"));
        die();
    } elseif (strlen(trim($data->password)) < 6) {
        $password_err = "Password must have at least 6 characters";
        echo json_encode(array("message" => "$password_err"));
        die();
    } else {
        $company->password = trim($data->password);
    }

    if(empty($email_err) && empty($password_err)) {
        if($company->login()) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $company->email;
            $_SESSION['id'] = $company->id;

            //Redirect company to welcome page
            //header('location: homepage);

            http_response_code(200);
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Invalid username of password"));
        }
    }
}