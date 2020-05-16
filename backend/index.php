<!doctype html>
<html lang="en">
  <head>
    <title>OSCB | Authentication</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free-5.13.0-web/css/all.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- User Defined CSS -->
    <link rel="stylesheet" href="css/login.css" />
  </head>
  <body class="text-center">
    <div class="form-signin">
      <div class="login-logo">
        <h2>Online Shop Challenge Backend</h2>
      </div>
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">User Authentication</p>
          <form class="user">
            <div class="input-group mb-4">
              <input id="username_login" type="text" class="form-control" placeholder="Username">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-4">
              <input id="password_login" type="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-9"></div>
              <!-- /.col -->
              <div class="col-5">
                <a href="javascript:login()" class="btn btn-success btn-user btn-block" tabindex="3">Login</a>
              </div>
              <!-- /.col -->
            </div>
            <hr />
            <div id="login_state" class="d-flex justify-content-center" role="alert">
            </div>
          </form>
          <p class="login-box-msg">Go to FrontEnd <a href="../index.php">Here!!</a></p>
        </div>
      </div>
    </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- User Defined    JavaScript -->
    <script src="js/login.js"></script>
  </body>
</html>