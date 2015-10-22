<? 	
include("includes/configuration.php");
include(DIR_FUNCTIONS.'options.php');
if(!isloggedIn())
{
	header('Location:alogin.php');
	exit();
}

$order_id  = $_REQUEST['ord_id'];
if(!$order_id)
	header("Location:m-order.php");

mysql_query("UPDATE `toon_messages` SET `msg_read`='1' WHERE `order_id`='".$order_id."' AND `user_id`!='".$_SESSION['sess_tt_uid']."'");
$toon_orders = toon_orders($order_id);
$user_id		  	  = $_SESSION['sess_tt_uid'];//Fetching the userid
$getuserDetails 	  = getUserDetails($user_id);//Fetching the user details according to the userid
$user_type=$getuserDetails['utype_id'];
if(isset($_REQUEST['comment_submit_x']))
{	
	if($_POST['comment']!='')
	{		
		$comment	 		  = addslashes($_POST['comment']);//Fetching the new customer comments
		$user_id		  	  = $_SESSION['sess_tt_uid'];//Fetching the userid
		$getuserDetails 	  = getUserDetails($user_id);//Fetching the user details according to the userid
		$attachmentname 	  = $_FILES["browse"]["name"];//Fetching the user attachment
		$file				  = explode('.',$attachmentname);
		$ext				  = $file[1];//Extention of the file attached
 
 		if($ext!='exe' && $ext!='EXE')//Checks whether the attachment is an executable file
		{ 
			if ($_FILES["browse"]["size"] >10485760)//Checking whether the file size is less than 50MB
			{
				$error="<span style='color:#FF0000'>&nbsp;* Maximum file size 10 MB</span>";//Error message
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
					$customer_name	  = $getuserDetails['user_fname'];
					$artist_id		  = $toon_orders['artist_id'];
					$getuserDetails   = getUserDetails($artist_id);
					$f_email		  = $getuserDetails['user_email'];//Fetching corresponding artist email ID
					$user_fname		  = $getuserDetails['user_fname'];
					$toon_messages_result=toon_messages($user_id);
					if($toon_messages_result>0)
					{	
						$from=$_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
						$header = "From: ".$from."\n";
						$header .= "MIME-Verson: 1.1\n";
						$header .= "Content-type:text/html; charset=iso-8859-1\n";
						$subject	  = "Important Client Message-Order Id # ".$order_id;
						$message		  = 'Date : '.date("m-d-Y",strtotime($toon_messages_result['msg_posted'])).'<br> 
Order Id : '.$order_id.'<br><br> 

Hi '.$user_fname.',<br><br> 

'.stripslashes($comment).'<br><br>

Do not reply to this email, to respond with '.$customer_name.', please login to your account at '.$_CONFIG['site_url'].'alogin.php and click the “MY ORDERS” link and view the envelope.<br><br>

If at anytime you have questions or require assistance, please email us at '.$_CONFIG['email_contact_us'].'<br><br>

Life should always be fun!!!<br><br>

The Captoon<br>
www.caricaturetoons.com';
						mail($f_email,$subject,$message,$header);//Sending email about the new message to the artist
					}
				}
				elseif($getuserDetails['utype_id']==2)//Checking whether the user is an artist
				{
					$artist_name=$getuserDetails['user_fname'];
					$customer_id	  = $toon_orders['user_id'];
					$getuserDetails   = getUserDetails($customer_id);
					$f_email		  = $getuserDetails['user_email'];//Fetching corresponding customer email ID
					$toon_messages_result=toon_messages($user_id);
					if($toon_messages_result>0)
					{	
						$from=$_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
						$header = "From: ".$from."\n";
						$header .= "MIME-Verson: 1.1\n";
						$header .= "Content-type:text/html; charset=iso-8859-1\n";
						
						$subject 	  = "Message From Caricature Toons #".$order_id; 
						$text 	 	  = "Date : ".date("m-d-Y",strtotime($toon_messages_result['msg_posted']))."
Order Id : ".$order_id."<br/><br/>Hi ".$getuserDetails['user_fname'].",<br><br>

".stripslashes($comment)."<br><br>

Do not reply to this email, to respond to ".$artist_name.", please login to your account at ".$_CONFIG['site_url']."alogin.php and click the “view communications link” in MY TOONS section.<br><br>

If at anytime you have questions or require assistance, please email us at ".$_CONFIG['email_contact_us']."<br><br>

Life should always be fun!!!<br><br>

The Captoon<br>
www.caricaturetoons.com";
						mail($f_email, $subject, $text,$header);//Sending email about the new message to the customer
					}
				}
			}	
		}
		else
		{ 
			$error="<span style='color:#FF0000'>&nbsp;* Enter a valid file</span>";//Error message if it's an executable filee
		}
	}
	$getuserDetails   = getUserDetails($user_id);
	if($getuserDetails['utype_id']==2)
	{
	header("location:art-hm.php");
	} else {
	header("location:my-caricature-toons.php");
	}


}
$mysql_msg_query = mysql_query("SELECT IF(u.`utype_id`!=".$user_type.",u.user_fname,concat(u.user_fname,' ',u.user_lname))as name,u.utype_id, m.msg_body, m.msg_attachment, m.msg_posted FROM toon_users u, toon_messages m WHERE u.user_id=m.user_id AND m.order_id='$order_id' ORDER BY m.msg_posted DESC");//For ordering the latest messages by posted date
$getuserDetails   = getUserDetails($user_id);
if($getuserDetails['utype_id']==2)
{
include (DIR_INCLUDES.'artist_header.php');
}
else
{
include (DIR_INCLUDES.'header.php');
}
?> 

<!--header ends-->
<!--content starts-->
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="styles/highslide.css" />
<script type="text/javascript" src="javascripts/highslide-with-html.js"></script>
<script type="text/javascript" src="javascripts/highslide-full.js"></script>
<script type="text/javascript">
	hs.graphicsDir = 'images/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.dimmingOpacity = 0.75;

	// define the restraining box
	hs.useBox = true;
	hs.width = 280;
	hs.height = 400;

	// Add the controlbar
	hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: false,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: 1,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
	function valid()
{
	if(document.getElementById("textfield").value=="")
	{
		document.getElementById("tfield").style.display="block";
		return false;
	}
	else
	{
	document.getElementById("tfield").style.display="none";
	}
	if(document.getElementById("browse").value!="")
	{
	document.getElementById("loading").style.display='block';
	}
	else
	
	{
	document.getElementById("tfield").style.display="none";
	document.getElementById("loading").style.display="none";
	}
	
	return true;

}

</script>


<form action="mess.php?ord_id=<?=$order_id?>" method="post" enctype="multipart/form-data">
<div id="content">
	<div class="height80"></div>
	<div align="center" style="width:60%;margin-left:200px;">
				<div align="left" style="text-align:left;" class="header_text">To talk to your caricaturist regarding your Caricature Toon or upload additional images, is easy. Just use the form below. <a href="order-caricature.php">To order more caricatures click here</a></div>
	</div>
	<div style="height:20px;"></div>
	<div>
		<div class="buy_now_curvepadding contact_margin"><img src="images/white_curve_top_left.gif" /></div>
		<div class="buy_now_white_curve_top_middle_strip previous_whiteCurve_middle_strip"></div>
		<div class="clear_right"><img src="images/white_curve_top_right.gif" /></div>							
		<div class="finish_white_curve_middle_border contact_margin_both">
			<div class="contact_artist_img"><img src="images/toonist_messaging.gif" alt="toonist messaging" title="Toonist messaging"/></div>
			<div>
				<div  class="contact_artist_box_left_margin">
				  <div></div>
					<div id="tfield" class="div_text" style="display:none; padding-left:5px;">* Please enter text</div>
				</div><div id="loading" class="div_text_green" style="display:none; padding-left:30px;"><img src="images/loader_green.gif"/>&nbsp;&nbsp;&nbsp;Image Uploading please wait.</div>
				  <div class="contact_artist_browse_btn" style="">
				    <textarea name="comment" class="text_field_txt contact_artist_box_properties1"  id="textfield"></textarea>
                    <?
                    if($getuserDetails['utype_id']==3)
					{
					?>
				    <input type="file" name="browse" id="browse"/><?=$error;?>
                    <?
					}
                    ?>
				  <!--<div class="contact_artist_submit_btn"><input type="image" src="images/submit.gif" border="0" name="comment_submit" onclick="return valid()"/></div>-->
				  <div>
				  <div class="contact_artist_sub_btn"><input type="image" src="images/submit.gif" border="0" name="comment_submit" onclick="return valid()" alt="submit" title="Submit"/></div>
				  <?
                    if($getuserDetails['utype_id']==2)
					{
				  ?>
				   <div class="contact_artist_cancel_btn"><a href="art-hm.php"><img src="images/cancel.gif" border="0" alt="cancel" title="Cancel" /></a></div>
				  <?
				   } else {
				   ?>
				   <div class="contact_artist_cancel_btn"><a href="my-caricature-toons.php"><img src="images/cancel.gif" border="0" alt="cancel" title="Cancel"/></a></div>

				   <? } ?>
				  </div>
				</div>
			</div>
			<div class="contact_artist_space">&nbsp;</div>
			<div><? while($toon_messages=mysql_fetch_assoc($mysql_msg_query)) 
				 { ?>
				<div  class="contact_artist_box_left_margin" style="clear:both;margin-bottom:25px;">
					<div class="contact_artist_message_txt" style="margin-bottom:5px;"><? if($toon_messages['utype_id']==3) { ?><span style="color:#FF0000;font-weight:bold;"><? echo $toon_messages['name'];?></span><? } else { ?><span style="color:#000099;font-weight:bold;"><? echo $toon_messages['name'];?></span><? }?><br/><? echo stripslashes($toon_messages['msg_body']);?></div><!--Displays user name & message content-->
					<div style="margin-bottom:5px;">
					<? $msg_attachment=$toon_messages['msg_attachment'];
					   $file=explode('.',$msg_attachment);
					   $ext=strtolower($file[1]);//Extention of the file attached
						if($msg_attachment)
						{ 
							if(in_array($ext, getoption_values('image_types')))//Checks whether the attachment is an image file
							{ ?> 
								<a href="z_uploads/messaging_images/<?=$msg_attachment?>" onclick="return hs.expand(this)"><img src="<?='includes/imageProcess.php?image='.$msg_attachment.'&type=messaging&size=100';?>" border="0"/></a>&nbsp;&nbsp;<!--Displays attached image with pop-up--> 
                                
							<? 
							 if($getuserDetails['utype_id']==2)
							{
							?>
							<div class="contact_artist_message_txt"><a href="save_msg_image.php?image=<?=$msg_attachment?>">Download</a></div>
							 <?
							}
							} 
							else
							{ ?>
								<a href="z_uploads/messaging_images/<?=$msg_attachment;?>"><img src="images/generic.gif" border="0" /></a>&nbsp;&nbsp;<a href="z_uploads/messaging_images/<?=$msg_attachment?>"><span style="font-size:12px;"><? echo $msg_attachment;?></span></a><!--Displays document image-->
							<? }
						}	?></div>
                      
					<div class="contact_artist_message_txt" style="font-size:10px;font-weight:bold;">Date : <? echo $toon_messages['msg_posted'];?></div><!--Displays message posted date-->
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
<? 
if($getuserDetails['utype_id']==2)
{
include (DIR_INCLUDES.'artist_footer.php');
}
else
{
include (DIR_INCLUDES.'footer.php'); 
}

?>