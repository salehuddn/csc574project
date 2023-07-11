<?php
session_start();

// Unset or destroy the relevant session variables
unset($_SESSION['loggedIn']);
// or use session_destroy() to destroy the entire session if needed

// Redirect to the desired page after logout
header('Location: index.php');
exit();
?>