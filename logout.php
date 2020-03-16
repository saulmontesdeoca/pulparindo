<?php
session_start();
header('Location: home.php');
// remove all session variables
session_unset();

// destroy the session
session_destroy();
?>