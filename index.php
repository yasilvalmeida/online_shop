<?php
	// Inialize session
	session_start();
	// Check
  if (isset($_SESSION['views']) && $_SESSION['views'] > 0)
  {
		// Load client information from $_SESSION
    $id = $_SESSION[$_SESSION['views'].'id'];
    $username = $_SESSION[$_SESSION['views'].'username'];
    $password = $_SESSION[$_SESSION['views'].'password'];
    $balance = $_SESSION[$_SESSION['views'].'balance'];
    echo "<input type='hidden' id='logged_id' value='".$id."' />";
    echo "<input type='hidden' id='logged_username' value='".$username."' />";
    echo "<input type='hidden' id='logged_password' value='".$password."' />";
    echo "<input type='hidden' id='logged_balance' value='".$balance."' />";
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <?php
      require_once("cmp/head.php");
    ?>
    <title>Online Shop Challenge</title>
  </head>
  <body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <h5 class="my-0 mr-md-auto font-weight-normal">Online Shop Challenge</h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link active" href="index.php">Products</a>
          </li>
          <?php
            require_once("cmp/user_area.php");
          ?>
          <li class="nav-item">
            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#cart_modal" class="nav-link">
              <i class='fas fa-shopping-cart'>
                <span id="item_added_to_cart_text" class="badge badge-light badge-counter"></span>
              </i> Cart
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <div class="container">
      <div id="productContent" class="card-deck mb-3 text-center">
        <!-- Content here -->
      </div>
      <div id="productPagination">
        <!-- Pagination here -->
      </div>
      <?php
        require_once("cmp/footer.php");
      ?>
    </div>
    <?php
      require_once("cmp/script.php");
    ?>
  </body>
</html>
