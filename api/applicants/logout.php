<?php

include_once '../../config/Database.php';
include_once '../../models/Applicants.php';

//Headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

//Initialize the session
session_start();

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate User post object
$applicant = new Applicant($db);

if($user->logout()) {
    //Redirect to login page
    header('Location: http://www.recruitment.com/api/applicants/frontend/login.php');
    exit;
}