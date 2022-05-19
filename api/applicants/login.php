<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

//Headers
// header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json');
// header('Access-Control-Allow-Methods: POST');
// header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

//Initialize the session
session_start();

include_once '../../config/Database.php';
include_once '../../models/Applicants.php';

//variables for error message
$email_err = "";
$password_err = "";

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Applicant post object
$applicant = new Applicant($db);

//Processes data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    //Check if email field is empty
    if(empty(trim($_POST['email']))) {
        $email_err = "Please enter an email";
        header("location: frontend/login.php?error=$email_err");
        die();
    } else {
        $applicant->email = trim($_POST['email']);
    }

    //Check if password filed is empty
    if(empty(trim($_POST['password']))) {
        $password_err = "Please enter a password";
        header("location: frontend/login.php?error=$password_err");
        die();
    }//Check password length
    elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = "Password must have at least 6 charachers";
        header("location: frontend/login.php?error=$password_err");
        die();
    }else {
        $applicant->password = trim($_POST['password']);
    }

    //If there are no errors... Try to login
    if(empty($email_err) && empty($password_err)) {
        if($applicant->login()) {
            //pasword is valid so start a session

            // Store data in session variables
            $_SESSION['LOGIN'] = 'true';
            $_SESSION['email'] = $applicant->email;
            $_SESSION['name'] = $applicant->first_name;
            $_SESSION['applicant_id'] = $applicant->applicant_id;
            $_SESSION['status'] = $applicant->account_status;

            // Redirect user to welcome page
            header('Location: frontend/homepage.php');
        }else {
            header("location: frontend/login.php?error=Invalid username or password");
        }
    }
}