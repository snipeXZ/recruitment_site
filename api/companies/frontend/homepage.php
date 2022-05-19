<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
//Initialize the session
session_start();
//Check if user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: http://www.recruitment.com/api/companies/frontend/login.php");
    exit;
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
                <a href="http://www.recruitment.com/api/companies/toggleStatus.php?id=<?php echo $_SESSION['id']; ?>">toggleAccountStatus</a>
            </div>
            <div class="link">
                <a href="./post_jobs.php">Post Job</a>
            </div>
            <div class="link">
                <a href="http://www.recruitment.com/api/companies/logout.php">Logout</a>
            </div>
        </div>
    </header>
    <article id="article">
    </article>
    
    <script>
        fetch("http://www.recruitment.com/api/companies/list_jobs.php?company_id=<?php echo $_SESSION['id']; ?>", {
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
                        <p class="job_name">${element.job_name}</p>
                        <p class="discription">${element.discription}</p>
                        <p class="requirements">${element.requirements}</p>
                        <button class="btn">Check Applicants</button>
                    </tile>
                `;
                article.innerHTML += _data;
            });

        })
    </script>
</body>
</html>