<?
	function isloggedIn($user_id=NULL)
	{
		if($user_id)
		{
			// Check whether the user with id '$user_id' is logged in		
			if($_SESSION['sess_tt_uid']==$user_id)
				return true;
			else
				return false;				
		}
		else
		{
			// Check whether any user is loggedin		
			if(isset($_SESSION['sess_tt_uid']))
				return true;
			else
				return false;
		}
	}
	
	//Fetch user details from the database
	function getUserDetails($user_id=NULL)
	{
		$user_id=($user_id==NULL)?$_SESSION['sess_tt_uid']:$user_id;
		$exsists_query = "SELECT * FROM toon_users WHERE `user_id`='$user_id'";
		$rs_exsists_details = mysql_query($exsists_query);
		$row_exsists_details = mysql_fetch_assoc($rs_exsists_details);
		return $row_exsists_details;
	}
	
	//Fetch toon message details from the database
	function toon_messages($user_id=NULL)
	{
		$user_id=($user_id==NULL)?$_SESSION['sess_uid']:$user_id;
		$toon_messages_query = "SELECT * FROM toon_messages WHERE `user_id`='$user_id'";
		$rs_toon_messages_details = mysql_query($toon_messages_query);
		$row_toon_messages_details = mysql_fetch_assoc($rs_toon_messages_details);
		return $row_toon_messages_details;
	}
	
	//Fetch toon orders details from the database
	function toon_orders($order_id)
	{
		$toon_messages_query = "SELECT * FROM toon_orders WHERE `order_id`='$order_id'";
		$rs_toon_messages_details = mysql_query($toon_messages_query);
		$row_toon_messages_details = mysql_fetch_assoc($rs_toon_messages_details);
		return $row_toon_messages_details;
	}
	function artist_gallery($user_id=NULL)
	{
		$user_id=($user_id==NULL)?$_SESSION['sess_uid']:$user_id;
		$gallery_query = "SELECT * FROM `toon_artist_gallery` WHERE `user_id`='$user_id' ORDER BY `agal_code` DESC , `opro_image` DESC";
		$rs_gallery = mysql_query($gallery_query);
		$gallery_array = array();
		$index=0;
		while($row_gallery=mysql_fetch_assoc($rs_gallery))
		{
			$gallery_array[$index]=$row_gallery;
			$index++;
		}
		return $gallery_array;
	}
	function genRandomString()
	{
	$length = 7;
	$characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWZYZ";
	$string="ID";

		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters)-1)];
		}
	return $string;
	}
?>