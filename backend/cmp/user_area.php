<?php
    echo '
        <a id="username_logged_view" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"></a>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="javascript:loadLoggedUserInfo()" class="dropdown-item" data-toggle="modal" data-target="#change_modal">
                <i class="fas fa-id-card mr-2"></i> Change my information
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#logout_modal">
                <i class="fas fa-sign-out-alt mr-2"></i> Exit
            </a>
        </div>
        ';
?>
