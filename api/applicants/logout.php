<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

//Initialize the session
session_start();

unset($_SESSION["LOGIN"]);

session_destroy();

header('location: http://www.recruitment.com/api/applicants/frontend/login.php?success=Status changed please login again');