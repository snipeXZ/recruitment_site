<html>

<head>
  <link rel="stylesheet" href="styles/login.css">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign up</title>
</head>

<body>
    <div class="container">
    <div class="container-forms">
      <div class="container-info">
        <div class="info-item">
          <div class="table">
            <div class="table-cell">
              <p>
                Have an account?
              </p>
              <button class="info-btn">
                Log in
              </button>
            </div>
          </div>
        </div>
        <div class="info-item">
          <div class="table">
            <div class="table-cell">
              <p>
                Already have an account?
              </p>
              <button class="info-btn">
                Sign in
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="container-form">
        <div class="form-item log-in">
          <div class="table">
            <div class="table-cell">
              <form action="http://recruitment.com/api/applicants/signup.php" method="POST">
                <input name="first_name" placeholder="first name" type="text" />
                <input name="last_name" placeholder="last name" type="text" />
                <input name="email" placeholder="email" type="text" />
                <input name="password" placeholder="password" type="password" />
                <input name="confirm_password" placeholder="confirm password" type="password" />
                <input class="btn" type="submit" value="Login" href="#">
              </form>

            </div>
          </div>
        </div>
        <div class="form-item sign-up">
          <div class="table">
            <div class="table-cell">
              <input name="email" placeholder="Email" type="text" />
              <input name="fullName" placeholder="Full Name" type="text" />
              <input name="Username" placeholder="Username" type="text" />
              <input name="Password" placeholder="Password" type="Password" />
              <button class="btn">
                Sign up
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
    <script>
    const url = new URL(location.href);
    if(url.searchParams.get('error')){
      alert(url.searchParams.get('error'))
    }
  </script>
  
</body>

</html>