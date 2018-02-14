<?php
	//echo "Hello"
	session_start();
	unset($_SESSION['admin_credential']);
	session_destroy();
	header('Location:index.php');
?>