<?php
session_start();

if(sha1($_SESSION['user']['id']) == $_GET['csrf']) {
    session_unset();
    session_destroy();
    
    header('Location:/');
}
?>