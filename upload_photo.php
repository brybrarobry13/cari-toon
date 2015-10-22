<?php
	include("includes/configuration.php");
	ini_set("memory_limit","200M");
	ini_set("post_max_size","200M");
	
	set_time_limit(0);
	// Work-around for setting up a session because Flash Player doesn't send the cookies
	/*if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}*/
	$u_id=$_SESSION['sess_tt_uid'];
	$query="SELECT * FROM `toon_orders` WHERE `user_id`='$u_id' and `order_status`='In Cart' ";
	$result=mysql_query($query);
	$row=mysql_fetch_array($result);
	$num=mysql_num_rows($result);
	if($num<=0)
	{
	mysql_query("INSERT INTO `toon_orders` (`user_id`,`order_date`)VALUES('$u_id',now())");
	$ord_id=mysql_insert_id();
	}
	else
	{
	$ord_id=$row['order_id'];
	}
	$imagename 	= $_FILES['Filedata']['name'];
	$image_type = $_FILES['Filedata']['type'];
	$ext		= explode('.',$imagename);
	$ext_size	= sizeof($ext);
	$actual_type= $ext[$ext_size-1];
	
	$destination = "z_uploads/photos/".$imagename;
	$db_image=$imagename;
	while(file_exists($destination) && !is_dir($destination)) 
	{	
		$db_image=rand().$imagename;
		$destination="z_uploads/photos/".$db_image;
	}
	move_uploaded_file($_FILES['Filedata']['tmp_name'],$destination);
	mysql_query("INSERT INTO `toon_order_products` (`order_id`,`opro_posted`)VALUES('$ord_id',now())");
	mysql_query("INSERT INTO `toon_order_images` (`order_id`,`order_image_name`)VALUES('$ord_id', '$db_image'");
	
?>