<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

include_once '../../config/Database.php';
require_once '../../models/Companies.php';

$database = new Database();
$db = $database->connect();

$company = new Companies($db);

$company->id = $_GET['id'];

$company->toggleStatus();

session_start();

unset($_SESSION["loggedin"]);

session_destroy();

header('location: http://www.recruitment.com/api/companies/frontend/login.php?success=Status changed kindly login again');