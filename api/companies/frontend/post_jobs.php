<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
//Initialize the session
session_start();
var_dump($_SESSION);
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
    <article>
        <tile>
            <form action="">
                <label for="job_name">Job Name: </label><br>
                <input id="job_name" type="text" placeholder="Job Name"><br>
                <label for="discription">Discription: </label><br>
                <textarea name="" id="discription" cols="40" rows="10"></textarea><br>
                <label for="requirements">Requirements</label><br>
                <textarea name="" id="requirements" cols="50" rows="10"></textarea>
                <input id="submit" class="btn" type="submit" value="Login" href="#">
            </form>
            </div>
        </tile>
    </article>

    <script>
        const url = new URL(location.href);
        if(url.searchParams.get('error')){
        alert(url.searchParams.get('error'))
        }
        if(url.searchParams.get('success')){
        alert(url.searchParams.get('success'))
        }
  </script>
    
    <script>
    const submit = document.querySelector('#submit');

    submit.addEventListener('click', (e) => {
        e.preventDefault();
        const job_name = document.querySelector('#job_name');
        const discription = document.querySelector('#discription');
        const requirements = document.querySelector('#requirements')

        //Create a javascript object and parse the values to it
        const data = {
            company_id: <?php echo $_SESSION['id'] ?> ,
            job_name:job_name.value,
            discription:discription.value,
            requirements:requirements.value
        }

        const result = JSON.stringify(data);
        console.log(result);
        fetch('http://recruitment.com/api/companies/post_jobs.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: result
            })
            .then((res) => {
                status = res.status;
                return res.json();
            })
            .then((data) => {
                alert(data.message);
                if (status == 200) {
                    location.href =
                        'ttp://recruitment.com/api/companies/frontend/homepage.php';
                }
            })
            .catch((err) => {
                console.log(err);
            });
    });
    </script>

</body>
</html>