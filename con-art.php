<? 	
include("includes/configuration.php");
include (DIR_INCLUDES.'header.php');
if(!isloggedIn())
{
	header('Location:alogin.php');
	exit();
}

$order_id=2;
//$order_id  = $_REQUEST['order_id'];
$toon_orders = toon_orders($order_id);

if(isset($_REQUEST['comment_submit_x']))
	{	
		$comment	 		  = $_POST['comment'];//Fetching the new customer comments
		$user_id		  	  = $_SESSION['sess_tt_uid'];//Fetching the userid
		$getuserDetails 	  = getUserDetails($user_id);//Fetching the user details according to the userid
		$toon_messages_result = toon_messages($user_id);//Fetching the messages attachment according to the userid
		$msg_attachment		  = $toon_messages_result['msg_attachment'];

		//Updating the fields in the tables
		mysql_query("INSERT INTO toon_messages (`user_id`,`order_id`,`msg_body`,`msg_attachment`,`msg_posted`) VALUES ('$user_id','$order_id','$comment','$msg_attachment',NOW())");
		
		//Uploading the user attached image
		if ((($_FILES["browse"]["type"] == "image/gif") || ($_FILES["browse"]["type"] == "image/jpeg") || ($_FILES["browse"]["type"] == "image/pjpeg") && ($_FILES["browse"]["size"] < 52428800)))
		{	
			$imagename 	 = $_FILES["browse"]["name"];
			$destination = DIR_MESSAGING_IMAGES.$imagename;
			$temp_name   = $_FILES["browse"]["tmp_name"];
			mysql_query("UPDATE toon_messages SET msg_attachment='$imagename' WHERE user_id='$user_id'");
			move_uploaded_file($temp_name,$destination);
		}	
		
		if($getuserDetails['utype_id']==3)//Checking whether the user is a customer 
		{
			$artist_id		= $toon_orders['artist_id'];
			$getuserDetails = getUserDetails($artist_id);
			$f_email=$getuserDetails['user_email'];//Fetching corresponding artist email ID
			if($toon_messages_result>0)
			{	
				$subject = "New Message<br /><br />";
				$text = "Hi,<br />Date : ".$toon_messages_result['msg_posted']."<br />Message : ".$comment."<br />If there exists any issue, you can let us know about it.";
				mail($f_email, $subject, $text);//Sending email about the new message to the artist
			}
		}
		elseif($getuserDetails['utype_id']==2)//Checking whether the user is an artist
		{
			$customer_id	= $toon_orders['user_id'];
			$getuserDetails = getUserDetails($customer_id);
			$f_email=$getuserDetails['user_email'];//Fetching corresponding customer email ID
			if($toon_messages_result>0)
			{	
				$subject = "New Message<br /><br />";
				$text = "Hi,<br />Date : ".$toon_messages_result['msg_posted']."<br />Message : ".$comment."<br />If there exists any issue, you can let us know about it.";
				mail($f_email, $subject, $text);//Sending email about the new message to the customer
			}
		}
	}
//For ordering the latest messages by posted date
$mysql_msg_query=mysql_query("SELECT * FROM toon_messages WHERE `order_id`='$order_id' ORDER BY `msg_posted` DESC");
?> 

<!--header ends-->
<!--content starts-->
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="styles/highslide.css" />
<script type="text/javascript" src="javascripts/highslide-with-html.js"></script>
<script type="text/javascript">
	hs.graphicsDir = 'images/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.numberPosition = 'caption';
	hs.dimmingOpacity = 0.75;

	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
</script>
<form action="con-art.php" method="post" enctype="multipart/form-data">
<div id="content">
	<div class="height80"></div>
	<div align="center" style="width:58%;margin-left:210px;">
		<div align="left" style="text-align:left;" class="header_text">Talking to your caricaturist regarding your Caricature Toons Order or to upload additional images is easy. Just use the form below regarding and we'll adjust your caricatures accordingly. We aim to please. </div>
	</div>
	<div style="height:20px;"></div>
	<div>
		<div class="buy_now_curvepadding contact_margin"><img src="images/white_curve_top_left.gif" /></div>
		<div class="buy_now_white_curve_top_middle_strip previous_whiteCurve_middle_strip"></div>
		<div class="clear_right"><img src="images/white_curve_top_right.gif" /></div>							
		<div class="finish_white_curve_middle_border contact_margin_both">
			<div class="contact_artist_img"><img src="images/toonist_messaging.gif" alt="toonist messaging" title="Toonist messaging" /></div>
			<div>
				<div  class="contact_artist_box_left_margin">
					<div>
				  <textarea name="comment" class="text_field_txt contact_artist_box_properties1" >Enter comment</textarea></div>
					<div class="contact_artist_browse_btn"><input type="file" name="browse" id="browse"/></div>
					<div class="contact_artist_submit_btn"><input type="image" src="images/submit.gif" border="0" name="comment_submit" alt="submit" title="Submit" /></div>
				</div>
			</div>
			<div class="contact_artist_space">&nbsp;</div>
			<div><? while($toon_messages=mysql_fetch_assoc($mysql_msg_query)) {?>
				<div  class="contact_artist_box_left_margin" style="clear:both;margin-bottom:40px;">
					<div style="float:left"><a href="z_uploads/messaging_images/<?=$toon_messages['msg_attachment']?>" onclick="return hs.expand(this)"><img src="<?='includes/imageProcess.php?image='.$toon_messages['msg_attachment'].'&type=messaging&size=100';?>" border="0"/></a></div>
					<div style="margin-left:110px;" class="contact_artist_message_txt">User ID : <? echo $toon_messages['user_id'];?> <br/>Date : <? echo $toon_messages['msg_posted'];?><br/>Message : <? echo $toon_messages['msg_body'];?></div>
				</div><? }?>
			</div>
			<div class="contact_artist_space">&nbsp;</div>
		</div>
		<div>
			<div class="buy_now_curvepadding contact_margin"><img src="images/contact_btm_left_curve.gif" /></div>
			<div class="white_btm_middle_strip previous_whiteCurve_middle_strip"></div>
			<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif" /></div>
		</div>
	</div>
	<div>&nbsp;</div>
</div>
</form>
<!--content ends-->	
<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>