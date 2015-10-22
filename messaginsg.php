<? 	
include("includes/configuration.php");
include(DIR_FUNCTIONS.'options.php');
if(!isloggedIn())
{
	header('Location:alogin.php');
	exit();
}

$order_id=3;
//$order_id  = $_REQUEST['order_id'];
$toon_orders = toon_orders($order_id);

if(isset($_REQUEST['comment_submit_x']))
{	
	if($_POST['comment']!='')
	{		
		$comment	 		  = $_POST['comment'];//Fetching the new customer comments
		$user_id		  	  = $_SESSION['sess_tt_uid'];//Fetching the userid
		$attachmentname 	  = $_FILES["browse"]["name"];//Fetching the user attachment
		$file				  = explode('.',$attachmentname);
		$ext				  = $file[1];//Extention of the file attached
 
 		if($ext!='exe' && $ext!='EXE')//Checks whether the attachment is an executable file
		{ 
			if ($_FILES["browse"]["size"] >5242880)//Checking whether the file size is less than 5MB
			{
				$error="<span style='color:#FF0000'>&nbsp;* Maximum file size 5MB</span>";//Error message
			}
			else
			{
				mysql_query("INSERT INTO toon_messages (`user_id`,`order_id`,`msg_body`,`msg_posted`) VALUES ('$user_id','$order_id','$comment',NOW())");//Updating the fields in the tables
				$msg_id 		 	  = mysql_insert_id();	
			
				if($attachmentname)
				{ 
					$destination 	  = DIR_MESSAGING_IMAGES.$msg_id."_".$attachmentname;//Appending msg_id with the attachment name
					$temp_name   	  = $_FILES["browse"]["tmp_name"];
					$attachment_name  = $msg_id."_".$attachmentname;
					move_uploaded_file($temp_name,$destination);//Uploading the user attachement
					mysql_query("UPDATE toon_messages SET msg_attachment='$attachment_name' WHERE msg_id='$msg_id'");
				}
				
				if($getuserDetails['utype_id']==3)//Checking whether the user is a customer 
				{
					$artist_id		  = $toon_orders['artist_id'];
					$getuserDetails   = getUserDetails($artist_id);
					$f_email		  = $getuserDetails['user_email'];//Fetching corresponding artist email ID
					if($toon_messages_result>0)
					{	
						$subject	  = "New Message<br /><br />";
						$text		  = "Hi,<br />Date : ".$toon_messages_result['msg_posted']."<br />Message : ".$comment."<br />If there exists any issue, you can let us know about it.";
						mail($f_email, $subject, $text);//Sending email about the new message to the artist
					}
				}
				elseif($getuserDetails['utype_id']==2)//Checking whether the user is an artist
				{
					$customer_id	  = $toon_orders['user_id'];
					$getuserDetails   = getUserDetails($customer_id);
					$f_email		  = $getuserDetails['user_email'];//Fetching corresponding customer email ID
					if($toon_messages_result>0)
					{	
						$subject 	  = "New Message<br /><br />";
						$text 	 	  = "Hi,<br />Date : ".$toon_messages_result['msg_posted']."<br />Message : ".$comment."<br />If there exists any issue, you can let us know about it.";
						mail($f_email, $subject, $text);//Sending email about the new message to the customer
					}
				}
			}	
		}
		else
		{ 
			$error="<span style='color:#FF0000'>&nbsp;* Enter a valid file</span>";//Error message if it's an executable filee
		}
	}
}
$mysql_msg_query = mysql_query("SELECT u.user_id, concat(u.user_fname,' ',u.user_lname)as name, m.user_id, m.msg_body, m.msg_attachment, m.msg_posted, o.user_id, o.artist_id FROM toon_users u, toon_messages m, toon_orders o WHERE o.order_id = '$order_id',m.order_id=o.order_id  ORDER BY m.`msg_posted` DESC");
//$mysql_msg_query=mysql_query("SELECT * FROM toon_messages WHERE `order_id`='$order_id' ORDER BY `msg_posted` DESC");//For ordering the latest messages by posted date

include (DIR_INCLUDES.'header.php');
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
<form action="mess.php" method="post" enctype="multipart/form-data">
<div id="content">
	<div class="height80"></div>
	<div>
		<div class="buy_now_curvepadding contact_margin"><img src="images/white_curve_top_left.gif" /></div>
		<div class="buy_now_white_curve_top_middle_strip previous_whiteCurve_middle_strip"></div>
		<div class="clear_right"><img src="images/white_curve_top_right.gif" /></div>							
		<div class="finish_white_curve_middle_border contact_margin_both">
			<div class="contact_artist_img"><img src="images/toonist_messaging.gif" alt="toonist messaging" title="Toonist messaging" /></div>
			<div>
				<div  class="contact_artist_box_left_margin">
					<div>
				  <textarea name="comment" class="text_field_txt contact_artist_box_properties1" ></textarea></div>
					<div class="contact_artist_browse_btn" style=""><input type="file" name="browse" id="browse"/><?=$error;?></div>
					<div class="contact_artist_submit_btn"><input type="image" src="images/submit.gif" border="0" name="comment_submit" alt="submit" title="Submit" /></div>
				</div>
			</div>
			<div class="contact_artist_space">&nbsp;</div>
			<div><? while($toon_messages=mysql_fetch_assoc($mysql_msg_query)) 
				 { ?>
				<div  class="contact_artist_box_left_margin" style="clear:both;margin-bottom:25px;">
					<div class="contact_artist_message_txt" style="margin-bottom:5px;">User name : <? echo $toon_messages['name']?><br/>Message : <? echo $toon_messages['msg_body'];?></div><!--Displays userid & message content-->
					<div style="margin-bottom:5px;">
					<? $msg_attachment=$toon_messages['msg_attachment'];
					   $file=explode('.',$msg_attachment);
					   $ext=$file[1];//Extention of the file attached
						if($msg_attachment)
						{ 
							if(in_array($ext, getoption_values('image_types')))//Checks whether the attachment is an image file
							{ ?> 
								<a href="z_uploads/messaging_images/<?=$msg_attachment?>" onclick="return hs.expand(this)"><img src="<?='includes/imageProcess.php?image='.$msg_attachment.'&type=messaging&size=100';?>" border="0"/></a><!--Displays attached image with pop-up--> 
							<? } 
							else
							{ ?>
								<a href="z_uploads/messaging_images/<?=$msg_attachment;?>"><img src="images/generic.gif" border="0" /></a><!--Displays document image-->
							<? }
						}	?></div>
					<div class="contact_artist_message_txt">Date : <? echo $toon_messages['msg_posted'];?></div><!--Displays message posted date-->
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