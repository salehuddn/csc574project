<?php
session_start();

//unset
unset($_SESSION['loggedIn']);
unset($_SESSION['cart']);

//set the logout message in the session
$_SESSION['logoutMessage'] = "Logged out successfully.";

//redirect to index.php
header('Location: index.php');
exit();

?>