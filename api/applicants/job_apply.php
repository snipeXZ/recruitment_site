<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

include_once '../../models/Jobs.php';
include_once '../../config/Database.php';

//variables for errors
$job_name_err = "";
$discription_err = "";
$requirements_err = "";

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//Instantiate Jobs object
$jobs = new Jobs($db);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    
}