<?
	if(isset($_POST['login_x']))
	{
		@$encrypt_obj = new AzDGCrypt(1074);
		$login_email=$_POST['login_email'];
		$login_password=$_POST['login_password'];
		$backto=$_REQUEST['back_to'];
		$login_query = mysql_query("SELECT U.* FROM `toon_users`U,`toon_user_types`UT where U.`user_email`='".addslashes($login_email)."' AND U.`user_delete`='0'  AND U.`utype_id`=UT.`utype_id` AND (UT.`utype_name`='Customer' OR  UT.`utype_name`='Artist') AND (`user_status`='Active' OR (`approval_status`='Approved' ))") or die(mysql_error());
		//Removed this code from above sql AND `artist_gallery_status`='Active' which was after `approval_status`='Approved'
		
		$row = mysql_fetch_array($login_query);
		$number = mysql_num_rows($login_query );
		$password = $row['user_password'];
		$password = $encrypt_obj->decrypt($password);
		if ($password != $login_password)		
		{
			$login_msg="*Invalid user";
		}
		else
		{ 		
			$u_id=$row['user_id'];	
			$_SESSION['sess_tt_uid']=$u_id; 
			$cookie=$_POST['cookie'];
			if($cookie!='')
			{
				$expire=time()+60*60*24*7;
				setcookie("toons_id", $u_id, $expire);
			}
		}
	}
	if(isloggedIn())
	{
		if($backto)
		{
			header('Location:'.$backto);
			exit();
		}
		if($u_id=$row['utype_id']==2)
		{
		header('Location:art-hm.php');
		exit();
		}
		header('Location:my-caricature-toons.php');
		exit();
	}
?>