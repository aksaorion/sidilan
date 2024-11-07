<?php
// routes.php

$uri = trim($_SERVER['REQUEST_URI'], '/');

switch ($uri) {
    case 'admin/home':
        include 'admin/dashboard.php';
        break;
    case 'user/profile':
        include 'user/profile.php';
        break;
    default:
        include '404.php';
        break;
}

?>