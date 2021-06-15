<?php
session_start();

if(isset($_SESSION['username'])) {
    $_SESSION = array();
    setcookie(session_name(), '', time() - 2592000, '/');
    setcookie('username', $_SESSION['username'], time() - 60*60, '/');
    setcookie('password', $_SESSION['password'], time() - 60*60, '/');
    setcookie('firstname', $_SESSION['firstname'], time() - 60*60, '/');
    setcookie('lastname', $_SESSION['lastname'], time() - 60*60, '/');
	session_destroy();
    header("Location: index.php");
} else {
    header("Location: index.php");
}
?>