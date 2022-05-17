<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

include_once '../../models/Jobs.php';
include_once '../../config/Database.php';

$database = new Database();
$db = $database->connect();

$jobs = new Jobs($db);

//Get user data
$data = json_decode(file_get_contents("php://input"));
$jobs->company_id = $data->company_id;

//Jobs query
$result = $jobs->list_company_jobs();
//Get row count
$num = $result->rowCount();

//Check if any posts
if($num > 0) {
    //Post array
    $applied_arr = array();
    $applied_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $applied_item = array(
            'id' => $id,
            'job_name' => $job_name,
            'discription' => $discription,
            'requirements' => $requirements
        );

        //Push to array
        array_push($applied_arr['data'], $applied_item);
    }

    //Convert to JSON
    echo json_encode($applied_arr);
} else {
    //No jobs
    echo json_encode(array('message' => 'No jobs found'));
}