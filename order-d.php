<?
	include("includes/configuration.php");
	include('includes/imageResize.php');
	$change_status_id=$_POST['change_status'];
	if(!isloggedIn())
	{
		header('Location:alogin.php');
		exit();
	}
	if(isset($_POST['ok']))
	{
		if($change_status_id)
		{
			$changestatus_query=mysql_query("UPDATE `toon_orders` SET`order_status`='Work In Progress'WHERE `order_id`='$change_status_id'");
			//mail
			$sql_content = mysql_query("SELECT 
				T.*,
				TP.`product_title`, 
				TP.`product_turnaroundtime`, 
				TA.`user_fname` AS `artist_fname`, 
				TA.`user_lname` AS `artist_lname`, 
				TC.`user_fname` AS `cust_fname`, 
				TC.`user_lname` AS `cust_lname`, 
				TC.`user_email` AS `cust_email`
			FROM `toon_orders` T,`toon_products` TP,`toon_users` TA ,`toon_users` TC 
			WHERE T.`order_id` = $change_status_id
				AND T.`product_id` = TP.`product_id` 
				AND T.user_id = TC.user_id 
				AND T.artist_id = TA.user_id");
			$sql_details = mysql_fetch_array($sql_content);
			$to = "{$sql_details['cust_email']}";
			$bcc = $_CONFIG['email_contact_us'];
			$subject = "New Toon has been Started";	
			$from = $_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
			$header = "From: ".$from."\n";
			$header .= 'Bcc: '.$bcc."\r\n";
			$header.= "MIME-Verson: 1.1\n";
			$header.= "Content-type:text/html; charset=iso-8859-1\n";
			
			//$message = "Date:".date("m-d-Y")."<br> Order ID:".$sql_details['order_id']."<br><br>";
			$message.= "Hi ". $sql_details['cust_fname'] ."<br>"; 
			$message.= "The Caricature Toon below has been started by the artist.<br /><br />";
			$message.= "The details are given below:<br />";
			$message.= "<b> Artist     : </b> {$sql_details['artist_fname']} {$sql_details['artist_lname']}<br />";
			$message.= "<b> Product    : </b> {$sql_details['product_title']}<br />";
			$message.= "<b> Order Date : </b> ".date("m-d-Y",strtotime($sql_details['order_date']))."<br /><br />"; 
			//$message.= "If at anytime you have questions or require assistance, please email us at ".$_CONFIG['email_contact_us']."<br><br>";
			//$message.= "Life should always be fun!!!<br> The Captoon"; 
			if ($sql_details['cust_fname'] != "")
				mail($to,$subject,$message,$header);
			//end of mail
		}
	}
	$ord_id=$_REQUEST['ord_id'];
	$ord_query = mysql_query("SELECT * FROM `toon_orders` WHERE `order_id`='$ord_id'");
	$ord_row=mysql_fetch_array($ord_query);
	$fname_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`='$ord_row[user_id]'");
	$fname_row=mysql_fetch_array($fname_query);
	$username=$fname_row['user_fname'];
	$femail_row=$fname_row['user_email'];
	$product_query = mysql_query("SELECT * FROM `toon_products` WHERE `product_id`='$ord_row[product_id]'");
	$product_row=mysql_fetch_array($product_query);
	$image_caricature_query = mysql_query("SELECT * FROM `toon_order_products` WHERE `order_id`='$ord_id'");
	$image_caricature_row=mysql_fetch_array($image_caricature_query);
	$image_query = mysql_query("SELECT * FROM `toon_order_images` WHERE `order_id`='$ord_id'");
	$u_id=$_SESSION['sess_tt_uid'];
	if(isset($_POST['orderimage_gallery']))
	{
		$u_id=$_SESSION['sess_tt_uid'];
	    $order_id=$_POST['orderid'];
		$image=$_POST['orderimage'];
		$filename=$_POST['caricature'];
		$insert_gallery=mysql_query("INSERT INTO `toon_artist_gallery`(`opro_image`,`agal_image`,`user_id`)VALUES('$image','$filename','$u_id')");
		$name=mysql_insert_id();
		if($image)
		{
		$newnamecart=$name.'_'.$image;
		}
		$newnamecaricature=$name.'_'.$filename;
		mysql_query("UPDATE `toon_artist_gallery` SET `opro_image` = '$newnamecart',`agal_image` = '$newnamecaricature' WHERE `agal_id`='$name'");
		copy(DIR_CARICATURE_IMAGES."$filename",DIR_ARTIST_GALLERY."$newnamecaricature");
		new imageProcessing(DIR_ARTIST_GALLERY."$newnamecaricature",920,600);
		if($image){
		copy(DIR_CART_IMAGES."$image",DIR_ARTIST_GALLERY."$newnamecart");
		new imageProcessing(DIR_ARTIST_GALLERY."$newnamecart",920,600);
		}
		header("location:art-gall.php?art_id=$u_id");
		exit();
	}
	if(isset($_POST['submit']))
	{
		$orderid_proof=$_POST['orderid_proof'];
		if($_FILES['image']['name']!='')
		{	
			$ext = strtolower(end(explode(".",$_FILES['image']['name'])));				
			if ($ext == "jpg" || $ext == "jpeg")		
			{
				if($_FILES['image']['size'] < 10485760)
				// IF PHOTO SIZE LESS THAN ALLOWED SIZE THEN CONTINUE
				{	
					$photoName1=$_FILES['image']['name'];
					$photoName=str_replace(" ","_",$photoName1);
					mysql_query("INSERT INTO `toon_proofs` (`opro_id` ,`proof_image`,`proof_posted`)VALUES ('$image_caricature_row[opro_id]', '$photoName',now())");	
					$name=mysql_insert_id();																			  						 				move_uploaded_file($_FILES['image']['tmp_name'],DIR_PROOF_IMAGES.$name.'_'.$photoName);
					$newname=$name.'_'.$photoName;
					mysql_query("UPDATE `toon_proofs` SET `proof_image`='$newname' WHERE `proof_id`='$name'");
					mysql_query("UPDATE `toon_orders` SET `order_status`='waiting for approval' WHERE `order_id`='$orderid_proof'");
					$msg='<span class="div_text_green">*Proof submited for the approval of the user</span>';
					$from=$_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
					$to=$femail_row;
					$subject='Your Caricature Toon Is Ready';
					$message ='Date:'.date("m-d-Y").'<br>
						Order ID:'.$ord_id.'<br><br>
																
						Hi '.$username.'<br>
						We’re pleased to let you know your Caricature Toon Proof is ready.<br><br>
						
						To view your Toon please login to your account at '.$_CONFIG['site_url'].'alogin.php and click on MY TOONS section.<br><br>
						
						From there you can download a high resolution version or talk to your Toonist it requires a Toon up.<br><br>
						
						If at anytime you have questions or require assistance, please email us at '.$_CONFIG['email_contact_us'].'<br><br>
						
						Life should always be fun!!!<br>
						The Captoon'; 
					$header = "From: ".$from."\n";
					$header .= "MIME-Verson: 1.1\n";
					$header .= "Content-type:text/html; charset=iso-8859-1\n";
					mail($to,$subject,$message,$header);
				}
			
				else
				{
					$size_error='Please select an image less than 10 MB';
				}
			}
		else
		{
			$type_error='please select an image file';
		}
	}	
}
include (DIR_INCLUDES.'artist_header.php');
?>
<script>
function validation()
{
	alert('Is the image you uploaded, in jpg format, no watermark and 2400 x 3000 pixels?');
	if (document.getElementById("image").value=='')
	{
		document.getElementById("error_image").style.display='block'
		return false;
	}
	else
	{
		document.getElementById("error_image").style.display='none'
	}		
	document.getElementById("upload").style.display='block'
}
</script>
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
<table width="100%">
	<tr>
		<td height="75" colspan="2">
		</td>
	</tr>
	<tr><td align="left" style="clear:left;text-align:left;padding-left:115px;" class="header_text">Below is your Caricature Toons order details. We love how you transform images into caricatures.</td></tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td align="center">
		<table cellpadding="0" cellspacing="0"  width="80%">
			<tr>
				<td width="23"><img src="images/topleft.gif"></td>
				<td class="artist_top">&nbsp;</td>
				<td align="right" width="23"><img src="images/top_right.gif"></td>
			</tr>
			<tr>
				<td class="artist_left">&nbsp;</td>
				<td class="bgcolour" align="center">
				<table cellpadding="4" cellspacing="4" class="text_blue" width="70%" border="0">
                	<tr>
						<td align="center" colspan="3" class="div_text">
						<?=$msg?></td>
					</tr>
					<tr>
						<td width="50%" align="left">
						Order Id</td>
						<td align="left">:</td>
						<td align="left" class="shift_right"><?=$ord_id?></td>
					</tr>
                    <tr>
						<td width="50%" align="left">
						Customer</td>
						<td align="left">:</td>
						<td align="left" class="shift_right"><?=$fname_row['user_fname'];?></td>
					</tr>
					<tr>
						<td align="left">Artist style</td>
						<td align="left">:</td>
						<td align="left" class="shift_right"><?=$product_row['product_title'];?></td>
					</tr>
					<tr>
						<td align="left">No of people</td>
						<td align="left">:</td>
						<td align="left" class="shift_right"><?=$ord_row['order_people_count'];?></td>
					</tr>
					<!--<tr>
						<td align="left">Props</td>
						<td align="left">:</td>
						<td align="left" class="shift_right"><?=$ord_row['order_props'];?></td>
					</tr>-->
					<tr>
						<td align="left">Order Status</td>
						<td align="left">:</td>
						<td align="left" class="shift_right"><? if($ord_row['order_status']=='Paid'){ echo 'Not started';}elseif($ord_row['order_status']=='Work In Progress' || $ord_row['order_status']=='waiting for approval'){ echo 'Work In Progress';} else { echo $ord_row['order_status'];}?></td>
					</tr>
                    
                    <? if($ord_row['order_status']=='artist paid')
					{
					?>
                    <tr>
						<td align="left">Payment Number</td>
						<td align="left">:</td>
						<td align="left" class="shift_right"><?=$ord_row['order_artist_payment_no']?></td>
					</tr>
                    <?
					}?>
                    <? if($ord_row['order_status']=='Refunded')
					{
					?>
                    <tr>
						<td align="left">Comments</td>
						<td align="left">:</td>
						<td align="left" class="shift_right"><?=$ord_row['order_refund_reason']?></td>
					</tr>
                    <tr>
						<td align="left">Payment Number</td>
						<td align="left">:</td>
						<td align="left" class="shift_right"><?=$ord_row['order_refunded_number']?></td>
					</tr>
                    <?
					}?>
                    
					<tr>
						<td align="left">Order Date</td>
						<td align="left">:</td>
						<td align="left"  class="shift_right"><?=date("m-d-Y",strtotime($ord_row['order_date']));?></td>
					</tr>
                    <tr>
						<td align="left">Turnaround Days</td>
						<td align="left">:</td>
						<td align="left"  class="shift_right"><?=$product_row['product_turnaroundtime'];?></td>
					</tr>
                    <?
                   $product_row['product_turnaroundtime']
					?>
                    <?
					$deadline =mysql_fetch_array(mysql_query("SELECT DATE_ADD('$ord_row[order_date]', INTERVAL  '$product_row[product_turnaroundtime]' DAY),NOW() AS `today`"));
					?>
                     <tr>
						<td align="left">Deadline</td>
						<td align="left">:</td>
						<td align="left"  class="shift_right"><span <? if($deadline[0]<$deadline['today']) {?>style="color:#FF0000"<? }?>><? echo date("m-d-Y",strtotime($deadline[0]));?></span></td>
					</tr>
                    <tr>
						<td align="left">Wholesale price</td>
						<td align="left">:</td>
						<td align="left"  class="shift_right">$&nbsp;<?=round($ord_row['order_wholesale_price'],2)?></td>
					</tr>
					<tr>
						<td valign="top" align="left">Special instructions</td>
						<td align="left" valign="top">:</td>
						<td align="left" class="shift_right"><?=$ord_row['order_instructions'];?></td>
					</tr>
					
						<?
						if($ord_row['order_status']=='Completed'){
						?>
					<tr>
						<td valign="top" align="left">caricature</td>
						<td align="left" valign="top">:</td>
						<td align="left" class="shift_right">
						<a href="z_uploads/caricature_images/<?=$image_caricature_row['opro_caricature']?>" onclick="return hs.expand(this)"><img src="<?='includes/imageProcess.php?image='.$image_caricature_row['opro_caricature'].'&type=caricature&size=150';?>"  border="0" /></a>						</td>
					</tr>
					<tr>
						<td valign="top" align="left">Order Images</td>
						<td align="left" valign="top">:</td>
						<td align="left" colspan="2">
						<form action="order-d.php?ord_id=<?=$ord_id?>" method="post" enctype="multipart/form-data">
							<table>
					<? 	while($image_row=mysql_fetch_array($image_query)){?>
								<tr>
									<td align="left" class="shift_right"><a href="z_uploads/cart_images/<?=$image_row['order_image_name']?>" onclick="return hs.expand(this)"><img src="<?='includes/imageProcess.php?image='.$image_row['order_image_name'].'&type=cart&size=150';?>"  border="0" /></a>
									</td>
								</tr>
								<tr>
									<td align="center"><input type="radio" name="orderimage" value="<?=$image_row['order_image_name']?>" />
									</td>
								</tr>
							<? }?>
							</table>
							<input type="hidden" name="caricature" value="<?=$image_caricature_row['opro_caricature']?>" />
							<input type="hidden" name="orderid" value="<?=$ord_id?>" />
							<input type="submit" name="orderimage_gallery" value="Upload to gallery" />
						</form>
						</td>
					</tr>
						<?
						}
						else
						{
						?>
					<tr>
						<td valign="top" align="left">Order Images</td>
						<td align="left" valign="top">:</td>
						<td align="left" colspan="2">
							<table>
					<? 	while($image_row=mysql_fetch_array($image_query)){?>
								<tr>
									<td align="left" class="shift_right"><a href="z_uploads/cart_images/<?=$image_row['order_image_name']?>" onclick="return hs.expand(this)"><img src="<?='includes/imageProcess.php?image='.$image_row['order_image_name'].'&type=cart&size=150';?>"  border="0" /></a>
									</td>
								</tr>
								<tr>
									<td align="left" class="shift_right"><a href="save_image.php?f_name=<?=$image_row['order_image_name']?>">Download image</a>
									</td>
								</tr>
							<? }?>
							</table>
						</td>
					</tr>
						<?
						if($ord_row['order_status']=='Paid'){
						?>
						<form action="order-d.php?ord_id=<?=$ord_id?>" method="post">
					<tr><td align="left">Change status</td>
						<td align="left">:</td>
						<td align="left"><input name="change_status" type="radio" value="<?=$ord_id?>" />Work in progress<input type="radio"<? if($ord_row['order_status']=='Paid'){?> checked="checked"<? }?> name="change_status"/>paid</td>
					</tr>
					<tr><td></td>
						<td>&nbsp;</td>
						<td align="left"><input type="submit" name="ok" value="change status" />						</td>
					</tr>
					</form>
					<? }}?>
					<? if($ord_row['order_status']=='Work In Progress' || $ord_row['order_status']=='waiting for approval'){?>
					
					<form action="order-d.php?ord_id=<?=$ord_id?>" method="post" enctype="multipart/form-data">
					<tr><td></td>
						<td align="left"></td>
						<td align="left" class="shift_right"><a href="p-proof.php?ord_id=<?=$ord_id?>&art_id=<?=$u_id?>">View previous proofs</a></td>
					</tr>
					<tr><td></td></tr>
					<tr><td></td>
					    <td align="left"></td>
					    <td align="left" class="shift_right" style="font-size:14px;color:#00C000">Upload Customer Toon</td>
					</tr>
					<tr><td></td>
						<td align="left">&nbsp;</td>
						<td align="left" class="shift_right">
							<input type="file" name="image" id="image">
							<div id="error_image" class="div_text" style="display:none">*Please select one image</div>
							<div class="div_text_green" id="upload" style="display:none;padding-top:10px;"><img src="images/loader_green.gif"/>&nbsp;&nbsp;&nbsp;Uploading image please wait.... </div>
							<div class="div_text"><?=$type_error?></div>
							<div class="div_text"><?=$size_error?></div></td>
					</tr>
							<input type="hidden" name="orderid_proof" value="<?=$ord_id?>" />
					<tr><td></td>
						<td align="left">&nbsp;</td>
						<td align="left" class="shift_right"><input type="submit" onClick="return validation()" name="submit" value="Submit proof"></td>
					</tr>
					</form>
					<? }?>
				</table>
				</td>
				<td class="artist_right">&nbsp;</td>
			</tr>
			
			<tr>
				<td><img src="images/contact_btm_left_curve.gif"></td>
				<td class="artist_bottom">&nbsp;</td>
				<td colspan="2" align="right"><img src="images/contact_btm_right_curve.gif"></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<?
	include (DIR_INCLUDES.'artist_footer.php');

?>