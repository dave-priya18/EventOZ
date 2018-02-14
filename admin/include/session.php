<?php
session_start();
if($_SERVER['PHP_SELF'] != "/EventOZ/admin/index.php"){
	if(!isset($_SESSION['admin_credential'])){
	ob_start();
	header('Location:index.php');
	
}
}


?>