<?
	include("includes/configuration.php");
	$change_status_id=$_POST['change_status'];
	if(isset($_POST['ok']))
		{
			if($change_status_id)
				{
					$changestatus_query=mysql_query("UPDATE `toon_orders` SET`order_status`='Work In Progress'WHERE `order_id`='$change_status_id'");
				}
		}
	$ord_id=$_REQUEST['ord_id'];
	$ord_query = mysql_query("SELECT * FROM `toon_orders` WHERE `order_id`='$ord_id'");
	$ord_row=mysql_fetch_array($ord_query);
	$product_query = mysql_query("SELECT * FROM `toon_products` WHERE `product_id`=$ord_row[product_id]");
	$product_row=mysql_fetch_array($product_query);
	$image_query = mysql_query("SELECT * FROM `toon_order_products` WHERE `order_id`='$ord_id'");
	$image_row=mysql_fetch_array($image_query);
	$u_id=$_SESSION['sess_tt_uid'];
	if(($image=$_REQUEST['f_name'])&($filename=$_REQUEST['c_name']))
	{
		$u_id=$_REQUEST['u_id'];
		$insert_gallery=mysql_query("INSERT INTO `toon_artist_gallery`(`opro_image`,`agal_image`,`user_id`)VALUES('$image','$filename','$u_id')");
		copy(DIR_CARICATURE_IMAGES."$filename",DIR_ARTIST_GALLERY."$filename");
		copy(DIR_CART_IMAGES."$image",DIR_ARTIST_GALLERY."$image");
		header("location:art-hm.php");
		exit();
	}
	if(isset($_POST['submit']))
	{
	if($_FILES['image']['name']!='')
					{					
						if (((((($_FILES['image']["type"] == "image/gif")
							|| ($_FILES['image']["type"] == "image/jpeg")
							|| ($_FILES['image']["type"] == "image/pjpeg")
							|| ($_FILES['image']["type"] == "image/bmp")
							|| ($_FILES['image']["type"] == "image/tiff")
							|| ($_FILES['image']["type"] == "image/png"))))))
								
					
							{
								if($_FILES['image']['size'] < 5000000)
								// IF PHOTO SIZE LESS THAN ALLOWED SIZE THEN CONTINUE
									{	
										$photoName1=$_FILES['image']['name'];
										$photoName=str_replace(" ","_",$photoName1);
										mysql_query("INSERT INTO `toon_proofs` (`opro_id` ,`proof_image`,`proof_posted`)VALUES ('$image_row[opro_id]', '$photoName',now())");	
										$name=mysql_insert_id();																			  						 				move_uploaded_file($_FILES['image']['tmp_name'],DIR_PROOF_IMAGES.$name.$photoName);
										$msg='*Proof submited for the aproval of the user';
									}
								
								else
									{
										$size_error='Please select an image less than 5 MB';
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
	if (document.getElementById("image").value=='')
		{
			document.getElementById("error_image").style.display='block'
			return false;
		}
	else
		{
			document.getElementById("error_image").style.display='none'
		}		
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
	<tr>
		<td align="center">
		<table cellpadding="0" cellspacing="0"  width="80%">
			<tr>
				<td width="23"><img src="images/topleft.gif"></td>
				<td class="artist_top" valign="middle" align="center"></td>
				<td align="right" width="23"><img src="images/top_right.gif"></td>
			</tr>
			<tr>
				<td class="artist_left">&nbsp;</td>
				<td class="bgcolour" align="center">
				<div class="div_text"><?=$msg?></div>
				<table cellpadding="4" cellspacing="4" class="text_blue" width="70%" border="0">
					<tr>
						<td width="50%">
						Order Id 
						</td>
						<td>:&nbsp;&nbsp;&nbsp;<?=$ord_id?>
						</td>
					</tr>
					<tr>
						<td>Artist style
						</td>
						<td>:&nbsp;&nbsp;&nbsp;<?=$product_row['product_title'];?>
						</td>
					</tr>
					<tr>
						<td>No of peoples
						</td>
						<td>:&nbsp;&nbsp;&nbsp;<?=$ord_row['order_people_count'];?>
						</td>
					</tr>
					
					<tr>
						<td>Order Status
						</td>
						<td>:&nbsp;&nbsp;&nbsp;<?=$ord_row['order_status'];?>
						</td>
					</tr>
					<tr>
						<td>Order Date
						</td>
						<td>:&nbsp;&nbsp;&nbsp;<?=$ord_row['order_date'];?>
						</td>
					</tr>
					<tr>
						<td valign="top">Special instructions 
						</td>
						<td>:&nbsp;&nbsp;&nbsp;<?=$ord_row['order_instructions'];?>
						</td>
					</tr>
					
						<?
						if($ord_row['order_status']=='Completed'){
						?>
					<tr>
						<td valign="top">caricature
						</td>
						<td>&nbsp;&nbsp;&nbsp;
						<a href="z_uploads/caricature_images/<?=$image_row['opro_id'].$image_row['opro_caricature']?>" onclick="return hs.expand(this)"><img src="<?='includes/imageProcess.php?image='.$image_row['opro_id'].$image_row['opro_caricature'].'&type=caricature&size=150';?>"  border="0" /></a>
						</td>
					</tr>
					<tr><td></td>
						<td >&nbsp;&nbsp;&nbsp;
							<a href="order_details.php?u_id=<?=$u_id?>&c_name=<?=$image_row['opro_id'].$image_row['opro_caricature']?>&f_name=<?=$image_row['opro_id'].$image_row['opro_image']?>">upload image to gallery</a>
						</td>
					</tr>
						<?
						}
						else
						{
						?>
					<tr>
						<td valign="top">Order Image
						</td>
						<td>&nbsp;&nbsp;&nbsp;
						<a href="z_uploads/cart_images/<?=$image_row['opro_id'].$image_row['opro_image']?>" onclick="return hs.expand(this)"><img src="<?='includes/imageProcess.php?image='.$image_row['opro_id'].$image_row['opro_image'].'&type=cart&size=150';?>"  border="0" /></a>
						</td>
					</tr>	
					
					<tr><td></td>
						<td >&nbsp;&nbsp;&nbsp;
							<a href="save_image.php?f_name=<?=$image_row['opro_id'].$image_row['opro_image']?>">Download image</a>
						</td>
					</tr>
						<?
						if($ord_row['order_status']=='Paid'){
						?>
						<form action="order_details.php?ord_id=<?=$ord_id?>" method="post">
					<tr><td>Change status</td>
						<td >:&nbsp;&nbsp;&nbsp;<input name="change_status" type="radio" value="<?=$ord_id?>" />Work in progress<input type="radio"<? if($ord_row['order_status']=='Paid'){?> checked="checked"<? }?> name="change_status"/>paid
						</td>
					</tr>
					<tr><td></td>
						<td><input type="submit" name="ok" value="change status" />
						</td>
					</tr>
					</form>
					<? }}?>
					<? if($ord_row['order_status']=='Work In Progress'){?>
					
					<form action="#" method="post" enctype="multipart/form-data">
					<tr><td></td>
						<td>&nbsp;&nbsp;&nbsp;<a href="previous_proofs.php?ord_id=<?=$ord_id?>&art_id=<?=$u_id?>">View previous proofs</a>
						</td>
					</tr>
					<tr><td></td>
						<td >&nbsp;&nbsp;&nbsp;
							<input type="file" name="image" id="image">
							<div id="error_image" class="div_text" style="display:none">*Please select one image</div>
							<div class="div_text"><?=$type_error?></div>
							<div class="div_text"><?=$size_error?></div>

						</td>
					</tr>
					
					<tr><td></td>
						<td >&nbsp;&nbsp;&nbsp;<input type="submit" onClick="return validation()" name="submit" value="Submit proof">
						</td>
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