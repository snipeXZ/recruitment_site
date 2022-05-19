<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

include_once '../../config/Database.php';
require_once '../../models/Applicants.php';

$database = new Database();
$db = $database->connect();

$applicant = new Applicant($db);

$applicant->applicant_id = $_GET['id'];

$applicant->toggleStatus();

session_start();

unset($_SESSION["LOGIN"]);

session_destroy();

header('location: http://www.recruitment.com/api/applicants/frontend/login.php?success=Status changed kindly login again');