<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
//Initialize the session
session_start();
//Check if user is logged in, if not then redirect to login page
if (!isset($_SESSION["LOGIN"]) || $_SESSION["LOGIN"] !== 'true') {
    header("Location: http://www.recruitment.com/api/applicants/frontend/login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/homepage.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div id="logo">
            <a href="">LOGO</a>
        </div>
        <div id="status">
            Account Status : <span><?php isset($_SESSION['status']); echo $_SESSION['status']; ?></span>
        </div>
        <div id="links">
            <div class="link">
                <a href="http://www.recruitment.com/api/applicants/toggleStatus.php?id=<?php echo $_SESSION['applicant_id']; ?>">toggleAccountStatus</a>   
            </div>
            <div class="link">
                <a href="">Upload CV</a>
            </div>
            <div class="link">
                <a href="">Jobs Applied</a>
            </div>
            <div class="link">
                <a href="http://www.recruitment.com/api/applicants/logout.php">Logout</a>
            </div>
        </div>
    </header>
    <article id="article"></article>

        <script>
        fetch("http://www.recruitment.com/api/applicants/get_jobs.php", {
            method: 'GET',
        })
        .then((res) => {
            return res.json();
        })
        .then((data) => {
            const article = document.querySelector('#article');
            data.data.forEach(element => {
                const _data = `
                    <tile>
                        <p class="company_name">Company Name</p>
                        <p class="job_name">${element.job_name}</p>
                        <p class="discription">${element.discription}</p>
                        <div class="combined">
                            <button class="btn">More Info</button>
                            <a href="http://www.recruitment.com/api/applicant/apply.php?applicant_id=<?php echo $_SESSION['applicant_id']; ?>&id=${element.id}" class="btn">Apply</a>
                        </div>
                    </tile>
                `;
                article.innerHTML += _data;
            });

        })
    </script>
    
</body>
</html>