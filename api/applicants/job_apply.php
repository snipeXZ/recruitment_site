<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

include_once '../../models/Applied_jobs.php';
include_once '../../config/Database.php';

//variables for errors
$job_name_err = "";
$discription_err = "";
$requirements_err = "";

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//Instantiate Jobs object
$jobs = new Applied_jobs($db);

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = json_decode(file_get_contents("php://input"));

    //Check if applicant and company ids where set
    if(empty($data->company_id) || empty($data->applicant_id)) {
        echo json_encode(array('message' => "headers tempared with"));
        die();
    }else {
        $jobs->applicant_id = $data->applicant_id;
        $jobs->company_id = $data->company_id;
    }

    if($jobs->apply_job()) {
        http_response_code(201);
        die();
    } else {
        http_response_code(401);
    }
}