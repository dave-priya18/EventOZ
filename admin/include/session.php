<?php
session_start();
//print_r($_SERVER['PHP_SELF']);

if($_SERVER['PHP_SELF'] != "/EventOZ/admin/index.php"){
	if(!isset($_SESSION['admin_credential'])){
	ob_start();
	header('Location:index.php');
}
	

}
elseif(!empty($_SESSION['admin_credential']) && $_SERVER['PHP_SELF'] == "/EventOZ/admin/index.php"){
	header('Location:dashboard.php');
	exit;
}


?>