<?
	if(preg_match("/localhost/",$_SERVER['SERVER_NAME']))
	{
		// LOCALHOST
		$hostname = 'localhost';
		$dbname = 'toons_db';
		$db_user = 'root';
		$db_password = '';
	}
	elseif(preg_match("/itekk/",$_SERVER['SERVER_NAME']) || preg_match("/matekk/",$_SERVER['SERVER_NAME']))
	{	
		//DEV SERVER
		$hostname = 'h50mysql41.secureserver.net';
		$dbname = 'forallproj3';
		$db_user = 'forallproj3';
		$db_password = 'forall123Proj';
	}
	else
	{
		// LIVE SERVER
		$hostname = 'localhost';
		$dbname = 'caricdb';
		$db_user = 'caricdb';
		$db_password = 'CCbd12!Pa';
	}

	$link = mysql_connect($hostname,$db_user,$db_password);
	$connect = mysql_select_db($dbname,$link)or die(mysql_error());
?>