<?php
session_start();
if(isset($_SESSION['user']['id'])){
    require_once('../../app/Models/includes.php');
    if (!User::isAuthentified() || !CSRF::isAjaxRequest() && $AUTHUSER['grade'] < 2)
    {
        die("ERROR");
    }
    
    if (isset($_SESSION['admin_mode'])) {

        unset($_SESSION['admin_mode']);

    } else {
        $_SESSION['admin_mode'] = 1;
    }
}
