<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

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

    //Check if company name field is empty
    if(empty(trim($_POST['name']))) {
        $company_name_err = "Please enter your company name";
        header("location: frontend/signup.php?error=$company_name_err");
        die();
    } else {
        $company->name = trim($_POST['name']);
    }

    //Check if email field is empty
    if(empty(trim($_POST['email']))) {
        $email_err = "Please enter your email";
        header("location: frontend/signup.php?error=$email_err");
        die();
    } else {
        $company->email = trim($_POST['email']);
    }

    //Check if password field is empty
    if(empty(trim($_POST['password']))) {
        $password_err = "Please enter a password";
        header("location: frontend/signup.php?error=$password_err");
        die();
    } // Check password length 
    elseif (strlen(trim($_POST['password'])) < 6)
    {
        $password_err = "Password must have at least 6 characters";
        header("location: frontend/signup.php?error=$password_err");
        die();
    } else {
        $company->password = trim($_POST['password']);
    }

    //Check if confirm password field if empty
    if(empty(trim($_POST['confirm_password']))) {
        $con_password_err = "Please confirm the password";
        header("location: frontend/signup.php?error=$con_password_err");
        die();
    }
    //Check password
    elseif(empty($password_err) && (($_POST['password']) != ($_POST['confirm_password']))) {
        $con_password_err = "Password did not match";
        header("location: frontend/signup.php?error=$con_password_err");
        die();
    } else {
        $company->password = trim($_POST['password']);
    }

    //If there are no errors .... Try signing company up
    if(empty($company_name_err) && empty($password_err) && empty($con_password_err)) {
        if($company->signup()){
                session_start();
                // Store data in session variables
                $_SESSION['LOGIN'] = 'true';
                $_SESSION['email'] = $applicant->email;
                $_SESSION['applicant_id'] = $applicant->applicant_id;

                header('location: frontend/login.php?success=created successfully');
                die();

        } else {
            header('location: frontend/signup.php?error=not created');
        }
    }

}