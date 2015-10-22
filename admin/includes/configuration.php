<?php
	/**
	* @copyright eShackle
	* @author itekk LLC
	* @link http://www.ehackle.com
	**/
	
	/**
	* Global include for the frontend
	*/
	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	session_start();
	
	
	define('IN_CLIENT', false);
	
	/**
	* Configuration data
	*/
	if (substr(PHP_OS, 0, 3) == "WIN")
	{
		$base_dir = str_replace('admin\\includes\\configuration.php', '', realpath(__FILE__));
		$pear_dir = $base_dir.'admin\\includes\\classes\\pear';
		
	}
	else
	{
		$base_dir = str_replace('admin/includes/configuration.php', '', realpath(__FILE__));
		$pear_dir = $base_dir.'admin/includes/classes/pear';
	}
	
	$includes_dir = $base_dir.'includes/';
	define("FILESYSTEM_PATH", '../');
	define("DIR_INCLUDES", $includes_dir);
	define("DIR_CLASSES", DIR_INCLUDES.'classes/');
	define("DIR_FUNCTIONS", DIR_INCLUDES.'functions/');
	define("DIR_ARTIST_GALLERY", FILESYSTEM_PATH.'z_uploads/artist_gallery/');
	define("DIR_CART_IMAGES",FILESYSTEM_PATH.'z_uploads/cart_images/');
	define("DIR_PROOF_IMAGES",FILESYSTEM_PATH.'z_uploads/proof_images/');
	define("DIR_MESSAGING_IMAGES",FILESYSTEM_PATH.'z_uploads/messaging_images/');
	define("DIR_CARICATURE_IMAGES",FILESYSTEM_PATH.'z_uploads/caricature_images/');
	define("DIR_PROFILE_IMAGES",FILESYSTEM_PATH.'z_uploads/profile_images/');
	define("DIR_COOL_LINK_IMAGES",FILESYSTEM_PATH.'z_uploads/cool_link_images/');
	define("DIR_COUPON_IMAGES",FILESYSTEM_PATH.'z_uploads/coupon_images/');
	define("DIR_EZ_IMAGES",FILESYSTEM_PATH.'z_uploads/EZ_images/');
	define("DIR_EZPRINTS_CAT_IMAGES",FILESYSTEM_PATH.'z_uploads/EZ_category_images/');
	
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
	$pages_allowed=array("index.php");
	
	// TO PREVENT UNAUTHORISED ACCES
	if(!isset($_SESSION['sess_admin']))
	{
		$pg_continue = 0;
		// IF THIS PAGE IS NOT ALLOWED TO VIEW WITHOUT LOGGING IN, THEN REDIRECT
		foreach($pages_allowed as $allowed)
		{
			if(preg_match("/".$allowed."/", $_SERVER['PHP_SELF']))
				$pg_continue= 1;
		}
		if($pg_continue == 0)
		{
			@header("Location:index.php");
		}
	}
	
	//TO INCLUDE FUNCTION USER.PHP
	include(DIR_INCLUDES.'functions/options.php');	
	include(DIR_INCLUDES.'functions/user.php');	
	include(DIR_INCLUDES.'functions/general.php');	
	//if(!isloggedIn() && $_COOKIE["toons_id"])
//	{
//		$_SESSION['sess_tt_uid'] = $_COOKIE["toons_id"];
//	}

	/* End of file configuration.php */
?>