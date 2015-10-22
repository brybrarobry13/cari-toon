<?php
	/**
	* @copyright CaricatureToons
	* @author itekk LLC
	* @link http://www.toonsforu.com
	**/
	
	/**
	* Global include for the frontend
	*/
	//error_reporting(0);

	if ($_SERVER['HTTPS'] != "on" && (preg_match('/\/chkout.php/',$_SERVER['PHP_SELF']) || preg_match('/\/merckout.php/',$_SERVER['PHP_SELF']))) { 
		//header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
	}
	
	if ($_SERVER['HTTPS'] == "off" && !preg_match('/\/chkout.php/',$_SERVER['PHP_SELF']) && !preg_match('/\/merckout.php/',$_SERVER['PHP_SELF']) &&  !preg_match('/\/ajax_shippingprice.php/',$_SERVER['PHP_SELF'])) { 
		header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
	}
	error_reporting(E_ERROR | E_WARNING | E_PARSE);;
	ini_set('display_errors','On');
	session_start();
	
	
	define('IN_CLIENT', true);
	
	/**
	* Configuration data
	*/
	if (substr(PHP_OS, 0, 3) == "WIN")
	{
		$base_dir = str_replace('includes\\configuration.php', '', realpath(__FILE__));
		$pear_dir = $base_dir.'includes\\classes\\pear';
	}
	else
	{
		$base_dir = str_replace('includes/configuration.php', '', realpath(__FILE__));
		$pear_dir = $base_dir.'includes/classes/pear';
	}
	$includes_dir = str_replace('configuration.php', '', realpath(__FILE__));
	
	define("FILESYSTEM_PATH", $base_dir);
	define("DIR_INCLUDES", $includes_dir);
	define("DIR_CLASSES", DIR_INCLUDES.'classes/');
	define("DIR_FUNCTIONS", DIR_INCLUDES.'functions/');
	define("DIR_ARTIST_GALLERY", FILESYSTEM_PATH.'z_uploads/artist_gallery/thumb_artist_images/');
	define("DIR_CART_IMAGES",FILESYSTEM_PATH.'z_uploads/cart_images/');
	define("DIR_PROOF_IMAGES",FILESYSTEM_PATH.'z_uploads/proof_images/');
	define("DIR_MESSAGING_IMAGES",FILESYSTEM_PATH.'z_uploads/messaging_images/');
	define("DIR_CARICATURE_IMAGES",FILESYSTEM_PATH.'z_uploads/caricature_images/');
	define("DIR_EZPRINTS_IMAGES",FILESYSTEM_PATH.'z_uploads/EZ_images/');
	define("DIR_PROFILE_IMAGES",FILESYSTEM_PATH.'z_uploads/profile_images/');
	define("DIR_COOL_LINK_IMAGES",FILESYSTEM_PATH.'z_uploads/cool_link_images/');
	define("DIR_COUPON_IMAGES",FILESYSTEM_PATH.'z_uploads/coupon_images/');
	define("DIR_EZUPLOAD_IMAGES",FILESYSTEM_PATH.'z_uploads/ez_uploads/');
	define("DIR_EZPRINTS_CAT_IMAGES",FILESYSTEM_PATH.'z_uploads/EZ_category_images/');
	define("DIR_SAMPLE_IMAGES",FILESYSTEM_PATH.'z_uploads/sample_images/');

	
	
	ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$pear_dir); // For PEAR packages
	
	
	/**
	* Include the Connections file.
	**/
	$filename=DIR_INCLUDES .'db_connect.php';
	if (file_exists($filename)) 
	{
		require_once($filename);
	}
	else
	{
		print("Database connection file not found!!!");
	}
		
	## FETCH VALUES FROM CONFIG TABLE AND MOVE TO '$_CONFIG' ARRAY()
	$configuration_query = mysql_query('SELECT * FROM `toon_configuration`')or die(mysql_error());	
  	while ($row_configuration = mysql_fetch_assoc($configuration_query)) 
	{
		$config_code=strtolower($row_configuration['config_code']);
    	$_CONFIG[$config_code]=$row_configuration['config_value'];
  	}
	
	
	//TO INCLUDE FUNCTION USER.PHP
	include(DIR_INCLUDES.'functions/user.php');	
	if(!isloggedIn() && $_COOKIE["toons_id"])
	{
		$_SESSION['sess_tt_uid'] = $_COOKIE["toons_id"];
	}

	/* End of file configuration.php */
?>