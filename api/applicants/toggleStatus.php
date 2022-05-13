<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

//Headers
header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

include_once '../../config/Database.php';
require_once '../../models/Applicants.php';

$database = new Database();
$db = $database->connect();

$applicant = new Applicant($db);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    $applicant->id = $data->id;
    if($applicant->toggleStatus()){
        http_response_code(200);
    }else {
        http_response_code(401);
    }
}