<?
if(isset($_POST['submit_x']))
	{
		@$encrypt_obj = new AzDGCrypt(1074);
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$email=$_POST['email'];
		$pass=$_POST['password'];
		$password=$encrypt_obj->crypt($_POST['password']);
		$include=$_POST['include_mail'];
		if($newsletter=$_POST['newsletter'])
	   	{
			$nltr_query="INSERT INTO `toon_newsletter` (`nltr_email`,`nltr_fname`,`nltr_lname`) VALUES('$email','$fname_news','$lname_news')";	
			$nltr_result=mysql_query($nltr_query);
		}
		$query = mysql_query("SELECT * FROM `toon_users` where user_email='$email' and `user_delete`='0'");
		$number = mysql_num_rows($query);
		
		if ($number<=0)
		{
			$query="INSERT INTO `toon_users` (`user_password`,`user_email`,`user_fname`,`user_lname`,`user_joined`) VALUES('$password','$email','$firstname','$lastname',NOW())";
			
			$result=mysql_query($query)or die('Query failed: ' . mysql_error());
			$login_query = mysql_query("SELECT * FROM `toon_users` where user_email='$email' and user_password='$password' ");
			$row = mysql_fetch_array($login_query );
			
			$header .= "From: ".$_CONFIG['site_name']." <".$_CONFIG['email_outgoing'].">\n";
			$header.= "MIME-Verson: 1.1\n";
			$header.= "Content-type:text/html;charset=iso-8859-1\n";
			$subject = "Welcome To CARICATURE TOONS";
			$text = "Hi ".$firstname.",<br /><br />
			Thanks for taking the time to join Caricature Toons. We love Tooning people up and we aim to please.<br /><br />
			We’re so confident you’ll like your Toon that we provide a 100% money back guarantee if your not completely satisfied. We also have some great products you can display your Toon on or present as a gift.<br/><br/>
			Your email ID: ".$email."<br />Password : ".$pass."<br /><br />
			<a href='http://www.caricaturetoons.com/order-caricature.php'>Click Here to Order Your Toon</a> <br/>
			<a href='http://www.caricaturetoons.com/buy-caricature-gift.php'>Click Here to Buy Products</a><br/><br/>
			If at anytime you have questions or require assistance, please email us at<br/> ".$_CONFIG['email_contact_us']."<br/><br/>
			Life should always be fun!!!<br/><br/>
			The Captoon<br/>
			www.caricaturetoons.com<br/>";
			mail($email, $subject, $text, $header);
			$u_id=$row['user_id'];	
			$_SESSION['sess_tt_uid']=$u_id; 
			$backto=$_REQUEST['back_to'];
			
			//Caricature MailChimp Key
			$apikey = 'd7229a6dbbe5df2b5bb2f6430fdbefd4-us2';
			
			#List Id of Registration
			//$listID = '71f346e13d';
			
			#List Id of Caricature Toons
			$listID = 'dbde0db1cb';
			
			$api = new MCAPI($apikey);
	
			$mergeVars = array('FNAME'=>$firstname,
							   'LNAME'=>$lastname);

			if($api->listSubscribe($listID, $email, $mergeVars) === true) {
				// It worked!	
			}else{
				// An error ocurred, return error message	
				$msg='Error: ' . $api->errorMessage;
			}
			
			if($backto)
			{
				header('Location:'.$backto);
				exit();
			}
			else
			{				
				header('Location:order-caricature.php?reg=success');	
				exit();
		}	}
		else
		{
			$reg_msg="*Email already registerd";
		}
	}
?>
