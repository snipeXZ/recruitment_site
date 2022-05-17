<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

include_once '../../models/Applied_jobs.php';
include_once '../../config/Database.php';

$database = new Database();
$db = $database->connect();

$applied = new Applied_jobs($db);

//Jobs query
$result = $applied->list_company_jobs();
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