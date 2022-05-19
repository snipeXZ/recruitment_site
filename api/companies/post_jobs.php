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
    $data = json_decode(file_get_contents("php://input"));

    if(empty(trim($data->job_name))) {
        $job_name_err = "Please enter an job name";
        echo json_encode(array('message' => "$job_name_err"));
        die();
    } else {
        $jobs->job_name = trim($data->job_name);
    }

    if(empty(trim($data->discription))) {
        $discription_err = "Please enter job discription";
        echo json_encode(array('message' => "$discription_err"));
        die();
    } else {
        $jobs->discription = trim($data->discription);
    }

    if(empty(trim($data->requirements))) {
        $requirements_err = "Please enter job requirements";
        echo json_encode(array('message' => "$requirements_err"));
        die();
    } else {
        $jobs->requirements = trim($data->requirements);
    }

    if(empty(trim($data->company_id))) {
        echo json_encode(array('message' => "Headers tempared with"));
        die();
    } else {
        $jobs->company_id = trim($data->company_id);
    }

    if(empty($job_name_err) && empty($discription_err) && empty($requirement_err)) {
        if($jobs->post_job()){
        echo json_encode(array('message' => "Created successfully"));
        } else {
            http_response_code(401);
        }
    }
}