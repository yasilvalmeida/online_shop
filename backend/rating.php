<?php
  if(isset($_GET['pid']))
  {
    // Inialize session
    session_start();
    // Check
    if (isset($_SESSION) && $_SESSION['views'] == 0)
    {
      header('Location: index.php');
    }
    else
    {
      // Load user information from $_SESSION
      $id = $_SESSION[$_SESSION['views'].'id'];
      $username = $_SESSION[$_SESSION['views'].'username'];
      $password = $_SESSION[$_SESSION['views'].'password'];
      $access = $_SESSION[$_SESSION['views'].'access'];
      $pid = $_GET['pid'];
      echo "<input type='hidden' id='logged_id' value='".$id."' />";
      echo "<input type='hidden' id='logged_username' value='".$username."' />";
      echo "<input type='hidden' id='logged_password' value='".$password."' />";
      echo "<input type='hidden' id='logged_access' value='".$access."' />";
      echo "<input type='hidden' id='pid' value='".$pid."' />";
    }
  }
  else
    header('Location: product.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <?php
      require_once("cmp/head.php");
    ?>
    <title id="title"></title>
  </head>
  <body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <h5 class="my-0 mr-md-auto font-weight-normal">Online Shop Challenge Backend</h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link" href="main.php">Main</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="client.php">Clients</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="rating.php">Products</a>
          </li>
          <li class="nav-item">
            <a id="parameter_menu" class="nav-link" href="parameter.php"></a>
          </li>
          <li class="nav-item">
            <a id="user_menu" class="nav-link" href="user.php"></a>
          </li>
          <li class="nav-item dropdown">
            <?php
              require_once("cmp/user_area.php");
            ?>
          </li>
        </ul>
      </nav>
    </div>
    <div class="container">
      <div class="card-deck mb-3 text-left">
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 id="header" class="my-0 font-weight-normal"></h4>
          </div>
          <div class="card-body">
            <table id="dataTable" class="table table-striped table-bordered table-hover display">
                <thead>
                    <tr>
                      <th>Username</th>
                      <th>Date</th>
                      <th>Rate</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <hr />
            <a class="btn btn-secondary" href="product.php">
                <i class="fas fa-arrow-left fa-sm fa-fw mr-2 text-gray-400"></i>
                Voltar
            </a>
          </div>
        </div>
      </div>
      <?php
        require_once("cmp/footer.php");
        require_once("cmp/modal_rating.php");
      ?>
    </div>
    <?php
      require_once("cmp/script.php");
    ?>
    <script src="js/rating.js"></script>
  </body>
</html>
