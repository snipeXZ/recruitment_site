<html>

<head>
  <link rel="stylesheet" href="styles/login.css">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign in</title>
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
                Don't have an account?
              </p>
              <button class="info-btn">
                Sign up
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="container-form">
        <div class="form-item log-in">
          <div class="table">
            <div class="table-cell">
              <form action="http://recruitment.com/api/companies/login.php" METHOD="POST">
                <input id="email" name="email" placeholder="email" type="text" />
                <input id="password" name="password" placeholder="password" type="password" />
                <input class="btn" type="submit" value="Login" href="#">
              </form>
            </div>
          </div>
        </div>
        <div class="form-item sign-up">
          <div class="table">
            <div class="table-cell">
              <form action="">
              <input name="email" placeholder="Email" type="text" />
              <input name="fullName" placeholder="Full Name" type="text" />
              <input name="Username" placeholder="Username" type="text" />
              <input name="Password" placeholder="Password" type="Password" />
              
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
    if(url.searchParams.get('success')){
      alert(url.searchParams.get('success'))
    }
  </script>  <script>
    const url = new URL(location.href);
    if(url.searchParams.get('error')){
      alert(url.searchParams.get('error'))
    }
  </script>
</body>


</html>