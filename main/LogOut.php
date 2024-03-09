<?php
    session_start();
    session_unset();
    
    echo 'You have successfully logged out. Redirecting to login page...';
    header('Refresh: 2; URL = index.php');
?>