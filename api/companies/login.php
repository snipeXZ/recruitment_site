<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);


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

    //Check if email field is empty
    if(empty(trim($_POST['email']))) {
        $email_err = "Please enter an email";
        header("location: frontend/login.php?error=$email_err");
        die();
    } else {
        $company->email = trim($_POST['email']);
    }

    //Check if password field is empty
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password";
        header("location: frontend/login.php?error=$password_err");
        die();
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = "Password must have at least 6 characters";
        header("location: frontend/login.php?error=$password_err");
        die();
    } else {
        $company->password = trim($_POST['password']);
    }

    if(empty($email_err) && empty($password_err)) {
        if($company->login()) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $company->email;
            $_SESSION['status'] = $company->account_status;
            $_SESSION['id'] = $company->id;

            //Redirect company to welcome page
            header('location: frontend/homepage.php');

        } else {
            http_response_code(401);
            header('location: frontend/login.php?error=Invalid credentials');
        }
    }
}