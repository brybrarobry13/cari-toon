<?
	session_start();
	session_destroy();
	setcookie('toons_id');
	$_COOKIE['toons_id'];
	header("Location:alogin.php");
?>