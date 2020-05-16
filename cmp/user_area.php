<?php
    if(isset($_SESSION['views']) && $_SESSION['views'] > 0)
    {
        echo '
            <li class="nav-item dropdown">
                <a id="username_logged_view" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i> 
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#change_modal">
                        <i class="fas fa-id-card mr-2"></i> Change my information
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#order_modal">
                        <i class="fas fa-file-invoice-dollar"></i> Orders
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#logout_modal">
                        <i class="fas fa-sign-out-alt mr-2"></i> Exit
                    </a>
                </div>
            </li>
        ';
    }
    else
    {
        echo '
            <li class="nav-item dropdown">
                <a id="username_logged_view" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i> Guest
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#login_modal">
                        <i class="fas fa-sign-in-alt"></i> Log In
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#signup_modal">
                        <i class="fas fa-user-plus"></i> Sign Up
                    </a>
                </div>
            </li>
        ';
    }
?>
