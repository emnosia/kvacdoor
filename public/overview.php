<?php
$title = "Overview";

require_once '../includes/autoloads.php';

if (isset($_SESSION['ads'])) {
    unset($_SESSION['ads']);
}
