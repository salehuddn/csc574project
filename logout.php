<?php
session_start();

//unset
unset($_SESSION['loggedIn']);
//or use session_destroy() to destroy the entire session if needed

//set the logout message in the session
$_SESSION['logoutMessage'] = "Logged out successfully.";

//redirect to index.php
header('Location: index.php');
exit();

?>