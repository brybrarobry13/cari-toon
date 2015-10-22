<?  ini_set("max_execution_time",1800);	
	ini_set("upload_max_filesize","100M");
	ini_set("max_input_time",1800);
	ini_set("post_max_size","100M");
	
	include("includes/configuration.php");
	include(DIR_INCLUDES.'functions/orders.php');
	$u_id=$_SESSION['sess_tt_uid'];
	$artist_name=$_REQUEST['artistname'];
	//echo "SELECT u.user_id , MIN( p.product_price ) as lowprice FROM `toon_users` u, `toon_products` p WHERE u.`user_id` = p.`user_id` AND `utype_id` = '2' AND `user_status` = 'Active' AND `user_delete` = '0' AND `user_fname` ='$artist_name'";
	$art_price_query = mysql_query("SELECT u.user_id , MIN( p.product_price ) as lowprice FROM `toon_users` u, `toon_products` p WHERE u.`user_id` = p.`user_id` AND `utype_id` = '2' AND `user_status` = 'Active' AND `artist_gallery_status`='Active' AND `user_delete` = '0' AND `user_fname` ='$artist_name' AND approval_status='Approved'"); 
	$row_first_price=mysql_fetch_assoc($art_price_query);
	if(isset($_GET['artistname']))
	{
		$img_query="SELECT * FROM toon_artist_gallery WHERE user_id=".$row_first_price['user_id']." ORDER BY agal_id DESC";
		$img_res=mysql_query($img_query);
		$img_row=mysql_fetch_assoc($img_res);
	}

	$art_query = mysql_query("SELECT * FROM `toon_users` WHERE `utype_id`=2 AND `user_status`='Active' AND `artist_gallery_status`='Active' AND approval_status='Approved' AND `user_delete`='0' ORDER BY `user_artist_priority` ASC");	    
	$utype_maxphotos =5;
	$allowedImage = array("jpg","jpeg","gif","tiff","png","bmp");
	if(!empty($_POST) && count($_POST)>0)
	{
	 $instructions=$_POST['tellus'];
	 if(!get_magic_quotes_gpc())
	 {
		 $instructions=addslashes($_POST['tellus']);
	 }
	 //$temp_pdct_id = $_POST['art_style'];
	 //$style_split = explode('_',$temp_pdct_id);
	 //$pdct_id=$style_split[0];
	 $pdct_id=$_POST['art_style'];
	 $art_id_query = mysql_query("SELECT * FROM `toon_products` WHERE `product_id`='$pdct_id'"); 
	 $art_id_row = mysql_fetch_array($art_id_query);
	 $art_id=$art_id_row['user_id'];
	 $no_people=$_POST['no_people'];
	 $pro_code=$_POST['pcode'];
	 $add_props = $_POST['add_props'];
	 if($add_props=='')
	 	$add_props = 1;
	 $pcode_query=mysql_query("SELECT * FROM `toon_promo` WHERE `promo_code`='$pro_code' and current_date() BETWEEN `promo_start_date` AND `promo_expiry`");
	 $pcode_row=mysql_fetch_array($pcode_query);
	 $pcode=$pcode_row['promo_id'];

	 $scode_query=mysql_query("SELECT * FROM `toon_special_coupons` WHERE `spc_code`='$pro_code' AND `spc_product`='Toon product' AND `spc_isused` = '0'");
	 $scode_row=mysql_fetch_array($scode_query);
	 $scode=$scode_row['spc_id'];
	 $spc_wholesale_price=$scode_row['spc_wholesale_price'];	 
	 
	 //$wholesaleprice = $art_id_row['product_wholesale_price']+($art_id_row['product_additionalCopy_price']*($no_people-1));
	 if ($no_people > 1)
	 	$wholesaleprice = $art_id_row['product_wholesale_price'] * $no_people;
	 else
	 	$wholesaleprice = $art_id_row['product_wholesale_price'];
	 $price_details  = price($no_people,$pdct_id,$pro_code,$add_props);
	 //print_r($price_details); exit();
	 
	 if($price_details[2]==0)
	 {
	 	mysql_query("INSERT INTO `toon_orders`(`user_id`,`order_price`,`order_wholesale_price`,`order_instructions`,`promo_id`,`product_id`,`order_people_count`,`order_props`,`artist_id`,`order_date`,`order_status`)VALUES('$u_id','$price_details[2]','$wholesaleprice','$instructions','$pcode','$pdct_id','$no_people','$add_props','$art_id',now(),'Paid')");	
	 }
	 else
	 {
		 if($pcode != "")
		 {
			mysql_query("INSERT INTO `toon_orders`(`user_id`,`order_price`,`order_wholesale_price`,`order_instructions`,`promo_id`,`product_id`,`order_people_count`,`order_props`,`artist_id`,`order_date`,`order_status`)VALUES('$u_id','$price_details[2]','$wholesaleprice','$instructions','$pcode','$pdct_id','$no_people','$add_props','$art_id',now(),'Pending')");	
		 }
		 elseif($scode != "")
		 {
			mysql_query("INSERT INTO `toon_orders`(`user_id`,`order_price`,`order_wholesale_price`,`order_instructions`,`promo_id`,`promo_type`,`product_id`,`order_people_count`,`order_props`,`artist_id`,`order_date`,`order_status`)VALUES('$u_id','$price_details[2]','$spc_wholesale_price','$instructions','$scode','spl coupans','$pdct_id','$no_people','$add_props','$art_id',now(),'Pending')");	
	
		 }
		 else
		 {
			mysql_query("INSERT INTO `toon_orders`(`user_id`,`order_price`,`order_wholesale_price`,`order_instructions`,`promo_id`,`product_id`,`order_people_count`,`order_props`,`artist_id`,`order_date`,`order_status`)VALUES('$u_id','$price_details[2]','$wholesaleprice','$instructions','$pcode','$pdct_id','$no_people','$add_props','$art_id',now(),'Pending')");	
	
		 }
	 }
	$ord_id=mysql_insert_id();
	if(!isloggedIn())
	{
		setcookie("toons_order_id", $ord_id);
	}
	mysql_query("INSERT INTO `toon_order_products` (`order_id`,`opro_posted`)VALUES ('$ord_id',now())");
	if($utype_maxphotos>0)
		{
			$photo_count = 0;
			$upload_count=$photo_count+1;
			// IF USER HAS PHOTO UPLOADS REMAINING
			for($upload_count;$upload_count<=$utype_maxphotos;$upload_count++)
			{			
				if($_FILES['photo_'.$upload_count]['name']!='')
				{
					if (((((($_FILES['photo_'.$upload_count]["type"] == "image/gif")
						|| ($_FILES['photo_'.$upload_count]["type"] == "image/jpeg")
						|| ($_FILES['photo_'.$upload_count]["type"] == "image/pjpeg")
						|| ($_FILES['photo_'.$upload_count]["type"] == "image/bmp")
						|| ($_FILES['photo_'.$upload_count]["type"] == "image/tiff")
						|| ($_FILES['photo_'.$upload_count]["type"] == "image/png"))))))
					{
						if($_FILES['photo_'.$upload_count]['size'] < 10485760)
						// IF PHOTO SIZE LESS THAN ALLOWED SIZE THEN CONTINUE
						{	
							$photoName1=$_FILES['photo_'.$upload_count]['name'];
							$photoName=str_replace(" ","_",$photoName1);
							mysql_query("INSERT INTO `toon_order_images` (`order_id` ,`order_image_name`) VALUES ('$ord_id', '$photoName')");
							$name=mysql_insert_id();																			  						 										move_uploaded_file($_FILES['photo_'.$upload_count]['tmp_name'],DIR_CART_IMAGES.$name.'_'.$photoName);
							$newname=$name.'_'.$photoName;
							mysql_query("UPDATE `toon_order_images` SET `order_image_name`='$newname' WHERE `order_image_id`='$name'");
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
		}
		if($price_details[2]==0)
		{
			if($u_id!='')
			{
				header("Location:reciept.php?ord_id=$ord_id");
				exit();
			}
			else
			{
				header("Location:my-caricature-toons.php");
				exit();
			}
		}
		else
		{
			header("Location:chkout.php?ord_id=$ord_id");
			exit();
		}
	}
	$spo_query= mysql_query("SELECT * FROM `toon_special_offers` WHERE current_date() BETWEEN `spo_startdate` AND `spo_enddate` AND `spo_product`='Toon product'");
	$number_spo=mysql_num_rows($spo_query);	
	$row_spo = mysql_fetch_assoc($spo_query);
	$title_text = "Order Caricatures from photos:";
	include (DIR_INCLUDES.'header.php');
	
?> 
<script type="text/javascript" src="javascripts/upload.js" ></script>
<script>
	var max_photos = <?=$utype_maxphotos?>;
	var processing=false;
	var validateclick=false;
	function validation()
	{
		if(document.getElementById(photo_count).value=='')
			{
				document.getElementById('error_photo1').style.display='block';
				return false;
			}
		else
			{
				document.getElementById('error_photo1').style.display='none';
			}
		if(document.getElementById('art_style').value=='')
			{
				document.getElementById('art_style_error').style.display='block';
				return false;
			}
		else
			{
				document.getElementById('art_style_error').style.display='none';
			}
		if(document.getElementById('no_people').value=='')
			{
				document.getElementById('no_people_error').style.display='block';
				return false;
			}
		else
			{
				document.getElementById('no_people_error').style.display='none';
			}
		document.getElementById('uploading').style.display='block';
		if(processing==true)
		{
			validateclick=true;
			return false;
		}
	}

	var fname = '';
	var xmlhttp;
	function pricevalue()
	{
		var pdct_id = document.getElementById('art_style').value;		
		var pcode = document.getElementById('pcode').value;
		//var props = document.getElementById('add_props').value;
		var no_people = document.getElementById('no_people').value;
		
		if (isNaN(no_people))		
		{
			document.getElementById('total_price').value='';
			return false;
		}
		processing=true	;
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
		{
			alert ("Your browser does not support XMLHTTP!");
			return false;
		}
		var url="price_calculate.php";
		url=url+"?people="+no_people;
		url +="&pdct_id="+pdct_id;
		url +="&pcode="+pcode;
		//url +="&props="+props;
		url=url+"&sid="+Math.random();
		//alert(url);
		xmlhttp.onreadystatechange=stateChanged2;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
	}
		
	function stateChanged2()
	{
		if (xmlhttp.readyState==4)
		{
			var style_split = xmlhttp.responseText.split("||");
			var pdct_price = style_split[0];
			fname = style_split[1];
			if (fname != '')
			{
				document.getElementById('artist_name_gallery').style.display='none';
				document.getElementById('artist_name').style.display='block';
				document.getElementById('artist_name').innerHTML='Artist: <b>'+fname+'</b>';
			}
			document.getElementById('total_price_gallery').style.display="none";
			document.getElementById('total_price').style.display="block";
			document.getElementById('total_price').innerHTML=pdct_price;
			processing=false;
			if(validateclick==true)
			{
				document.orderpost.submit();
			}
		}
	}
	
	function get_image(prd_id)
	{
		processing=true	;
		xmlhttp_new=GetXmlHttpObject();

		if (xmlhttp_new==null)
		{
			alert ("Your browser does not support xmlhttp_new!");
			return false;
		}
		var url="get_image.php";
		url +="?pdct_id="+prd_id;
		xmlhttp_new.onreadystatechange=function()
		  {
		 	 if (xmlhttp_new.readyState==4)
				{
					document.getElementById('artist_image').innerHTML=xmlhttp_new.responseText;
				}	
		  }
		
		xmlhttp_new.open("GET",url,true);
		xmlhttp_new.send(null);
	}
	
	/*function show_image()
	{
		alert(xmlhttp_new.responseText);
		if (xmlhttp_new.readyState==4)
		{
			alert(xmlhttp_new.responseText);
			document.getElementById('artist_image').innerHTML=xmlhttp_new.responseText;
		}	
	}*/
	function GetXmlHttpObject()
	{
		if (window.XMLHttpRequest)
		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			return new XMLHttpRequest();
		}
		if (window.ActiveXObject)
		{
			// code for IE6, IE5
			return new ActiveXObject("Microsoft.XMLHTTP");
		}
		return null;
	}

</script>
<link rel="stylesheet" type="text/css" href="styles/highslide/highslide.css" />
<link rel="stylesheet" type="text/css" href="styles/stylish-select.css" />
<script type="text/javascript" src="javascripts/jquery_select.js"></script>
<script src="javascripts/jquery_002.js" type="text/javascript"></script>
<script type="text/javascript" src="javascripts/highslide-with-html.js"></script>
<script type="text/javascript">
$(document).ready(function(){

	$("#art_style").sSelect({ddMaxHeight: '200px'});
});
</script>
<script type="text/javascript">
hs.graphicsDir = 'styles/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>

		<!--header ends-->
		<!--content starts-->
		<link href="styles/style.css" rel="stylesheet" type="text/css" />
		<div id="content">
		<div style="height:5px;">
        <? if($_GET['reg']=="success") { ?>
            <!-- Google Code for Register Conversion Conversion Page -->
			<script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 956900108;
            var google_conversion_language = "en";
            var google_conversion_format = "3";
            var google_conversion_color = "ffffff";
            var google_conversion_label = "1OImCOTglgMQjMakyAM";
            var google_conversion_value = 0;
            /* ]]> */
            </script>
            <script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
            </script>
            <noscript>
            <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/956900108/?label=1OImCOTglgMQjMakyAM&amp;guid=ON&amp;script=0"/>
            </div>
            </noscript>
        <? } ?>
        </div>
		<div style="height:200px;">
		<div style="float:left; width:190px;padding:15px 0 5px 15px;position:absolute;z-index:1000;"><a href="terms.php"><img src="images/guarantee-seal.png" width="190px" border="0" /></a></div>
		<div align="center" style="margin-left: 210px; width: 77%;">
			<div align="left"  class="header_text" style="padding-top:95px;padding-left:5px;">Welcome to Caricature Toons, we offer some of the highest quality caricatures you can order online at better than affordable prices. All our Caricatures are hand-drawn, many making use of the latest digital technology. We offer a tremendous amount of Caricature Artists&prime; Styles and Prices, one&prime;s bound to suit your taste, requirements and budget.
<br/><br/>Some of our Caricature Artists and Cartoonists are world-renowned and draw cartoons for leading Newspapers, Magazines and Entertainment Parks. Our artists are talented, truly ingenious and want to satisfy all your creative needs. Once you put your trust in us, we are sure you will come back to us asking for more.
</div>
		</div>
		</div>
		<div style="clear:both"></div>
			<div class="finish_line_div" align="center" style="width:360px;" id="artist_image">
	<?php	if(isset($_GET['artistname']))
			{
				if(mysql_num_rows($img_res)==0)
				{
				?>
				<div style="padding-right: 1px;"><img src="images/noimage.gif" border="0" alt="captoon" title="captoon" width="204"/ ></div>
				<?php
				}
				else
				{
					$org_aftr_img=str_replace("th_","",$img_row['agal_image']);
				?>
				<div class="gallery_bg">
				<div style="height:5px;"></div>
				<a href="gallery_view.php?art_id=<?=$img_row['user_id']?>"  onclick="return hs.htmlExpand(this,{headingText: '', objectType: 'iframe',width:1000,height:500 })"><div style="padding-right: 1px;"><img src="z_uploads/artist_gallery/thumb_artist_images/<?=$img_row['agal_image']?>" border="0" width="204"/ ></div><div style="height:5px;"></div><img alt="View <?=$artist_name?>'S Gallery" title="View <?=$artist_name?>'S Gallery" src="show_text/<? echo base64_encode("VIEW ".strtoupper($artist_name)."'S GALLERY")?>/7/" border="0"  /></a></div>
				<?php
				}
			}
			else
			{
			?>
			<img src="images/captoon.png" border="0" alt="captoon" title="captoon" width="360"/ >
			<?php
			}
			?>
			</div>
			<div>
				<div class="finish_line_top_left_curve"><img src="images/contact_top_left_curve.gif" /></div>
				<div class="buy_now_middlestrip finish_line_content_position"></div>
				<div  class="finish_line_top_right"><img src="images/contact_top_right_curve.gif" /></div>
				<div class="buy_now_content_middlestrip finish_line_box_content_prepperties">
					<div class="finish_line_toon_div" style="float:left;">
						<div class="finish_line_start_line_img" id="fsUploadProgress" ><img src="images/start_line.gif" border="0" alt="start line" title="Start line" /></div>
						<div class="text_blue finish_line_content_txt_" style="width:200px;">
							Getting started is easy! Just upload your image(s), describe your vision, pick an artist and tell us how many people you want in your Toon. <p>&nbsp;</p><p>We&prime;ll notify you the minute your Toon is ready and place it in the My Toons section. From there you&prime;ll be able to view your proofs and communicate with the Artist directly.</p><p>&nbsp;</p><p>Once your 100% satisfied, you can download your Royalty Free Toon. Or check out the <a href="buy-caricature-gift.php" target="_blank">Buy Products</a> section to see the cool ways you can display your Toon. They make Great Gifts and we ship worldwide.</p>
						</div>
					</div>
					<form action="<?=$_SERVER['PHP_SELF']?>" method="post" name="orderpost" enctype="multipart/form-data">
					<div id="outer_wrap_finishline" style="margin-left:10px;">
						<div align="center" class="div_text"><?=$type_error?></div>
						<div align="center" class="div_text"><?=$size_error?></div>
						<div class="height_63"></div>
						<? $p_count=1;?>
					    <div style="clear:both;">
							<? if($photo_count<$utype_maxphotos) { ?>
                            <div id="photo_more" style="padding-left:30px;padding-bottom:10px"><input type="file" id="<?=$p_count?>" name="photo_<?=$p_count?>" /></div><script>var photo_count= <?=$p_count?>;</script>
                            <? } if($photo_count<($utype_maxphotos-1)) { ?>
                            <div id="add_photo" class="finish_line_padding" ><input type="image" border="0" name="add_photo" src="images/add_another_photo.png" onclick="return more_photo()" alt="add another photo" title="Add another photo" /></div>
                            <? } ?><script>var photo_counter = <?=$p_count?>;</script>
                        </div>
                        <div style="padding-left:40px;padding-top:10px"><img src="images/tell_us_your_vision.gif" border="0" alt="tell us your vision" title="Tell us your vision" /></div>
						<div>
						<div class="finish_line_padding finish_line_text_area_bg" style="float:left"><textarea name="tellus" cols="30" rows="10" style="border:solid 1px #FFFFFF;"><?=$instructions?></textarea></div>
                        <div style="float:left;"><a href="" onclick="return hs.htmlExpand(this,{headingText: 'TIPS'})"><img src="images/tips.png" border="0" alt="tips" title="Tips"/></a>
						<div class="highslide-maincontent">
						If you&prime;d Like Group Caricatures, more than 5 people, please let us know. Fill out the number of people you like to see in your Caricature Toon. For multiple, individual Caricature Toons, please submit each order separately. If you require any assistance or have any special requests, please don't hesitate to <a href="contact.php">contact us</a>.
						<br/>
						<h5><img src="images/tips.png" border="0" style="height:12px;" alt="tips" title="Tips" /></h5>
						Our Caricaturists aim to please. The more information and the higher quality images you can supply, the better. 
						<h5><img src="images/images.gif" alt="Images" title="Images"/></h5> 
					The ideal headshot shows the entire head with facial the expression you'd like to see. Body shots can be actual body shots of the person that&prime;s being Tooned or you can supply us someone else&prime;s body as a guide. It&prime;s the same with backgrounds or props.
                    <h5><img src="images/vision.gif" alt="Vision" title="Vision"/></h5>
Our artists are perfectionists and they want to do right by you, the clearer your vision the better. If your downloading various images, perhaps one for the headshot, another for the body, another for a prop and another for a background and want them all combined in a specific pose, detail it the best you can.<br />
<h5><img src="images/vision_example.gif" alt="Vision example" title="Vision example" /></h5>
Use image #1 for head, #2 for body, #3 for bike, #4 for mountain background, #5 for body pose. Please have him riding up the side of the mountain, holding a beer in one hand as if he's toasting it to the world. Also add the following text at the top - WORLD'S GREATEST DAD and IRONMAN ST GEORGE at the bottom.</i>
<h5><img src="images/communicatingwithyourartist.gif" alt="Communicating with your artist" title="Communicating with your artist" /></h5>
It&prime;s easy to communicate directly with your artist once you&prime;ve placed your order. If you need to provide additional information or images, or just want to ask a question, you can do this through the My Toons page.</div>

 						
					</div>
						</div>
						<div class="height_5"></div>
					
						
						<div style="height:38px; clear:both;">
							<div class="text_blue finish_line_content_txt_" style="float:left;padding:0px"><span class="text_blue finish_line_content_txt_" style="float:left;padding:0px"><img src="images/artist_style.gif" alt="artist style" title="Artist style" /></span></div>
							<div style="float:left" id="win-xp" class="finish_line_txt_field_bg">
								<select name="art_style" onchange="pricevalue();get_image(this.value)" id="art_style" >
                                <option style="font-family:Arial, Helvetica, sans-serif;" selected="selected" value="">Choose a Style</option>
								<? while($art_row = mysql_fetch_array($art_query))
									{
								?>
									<optgroup id="group<?=$k++?>" label="<?=$art_row['user_fname']; ?>" >
										<?
										$prod_query = mysql_query("SELECT * FROM `toon_products` WHERE `user_id`=$art_row[user_id] AND `product_delete`=0");
										$x=1;
										while($prod_row = mysql_fetch_array($prod_query ))
										{
											if($artist_name==$art_row['user_fname'])
											{
											?>
											<option style="font-family:Arial, Helvetica, sans-serif;" <? if($x==1){?>selected=selected <? }?> value="<?=$prod_row['product_id'];?>" ><?=$prod_row['product_title'].' - $'.number_format($prod_row['product_price'],2);?></option>
											<? $x++;
											}
											else
											{?>
											<option style="font-family:Arial, Helvetica, sans-serif;"  value="<?=$prod_row['product_id'];?>" ><?=$prod_row['product_title'].' - $'.number_format($prod_row['product_price'],2);?></option>
											
											<? }
										}
										
										?>
										
									</optgroup>
								<? 	}?>
													
								</select>
							</div>	
							<div style="padding-left:3px;"><a href="style-price.php" target="_blank"><img src="images/view_txt.gif" border="0px" alt="view" title="View" /></a></div>
						</div>
						<? if($artist_name!='') { ?>
						<div class="text_blue" style="font-size:12px;display:block;clear:both;padding-left:130px;padding-bottom:10px;" id="artist_name_gallery">Artist: <b><?=$artist_name?></b></div>
                        <div class="text_blue" style="font-size:12px;display:none;clear:both;padding-left:130px;padding-bottom:10px;" id="artist_name"></div>
						<? } ?>
                        <div style="display:block;" id="artist_name_gallery"></div>
                        <div class="text_blue" style="font-size:12px;display:block;clear:both;padding-left:130px;padding-bottom:10px;" id="artist_name"></div>
                        <?
						/*if($number_spo==0)
						{*/
						?>
						<div style="clear:both; height:38px;">
							<div class="text_blue" style="float:left;margin-left:3px;"><img src="images/promo_code.gif" alt="promo code" title="Promo code" /></div>
							<div style="float:left;margin-left:3px" class="finish_line_txt_field_bg">
							<input type="text" onblur="pricevalue()" name="pcode" id="pcode" value="<?=$pro_code?>" style="width:112px;margin-left:-10px;margin-top:-2px;background:none; border:none;font-family:Arial, Helvetica, sans-serif;"/>
							</div>
						</div>
                        <?
                      /*  }
						else
						{ */
						?><!--<input type="hidden" id="pcode" name="pcode" />--><? //}?>
                        
                        <!--div style="clear:both; height:38px;">
							<div class="text_blue" style="float:left;margin-left:63px;"><img src="images/props.png" alt="props" title="Props" /></div>
							<<div style="float:left;margin-left:3px" class="finish_line_txt_field_bg">
							<input type="text" onblur="pricevalue()" name="add_props" id="add_props" value="<?=$add_props?>" style="width:112px;margin-left:-10px;margin-top:-2px;background:none; border:none;font-family:Arial, Helvetica, sans-serif;"/>
							</div>
						</div-->
                        
                        
						<div style="clear:both;height:38px;">
							<div class="text_blue" style="float:left;padding:0px;margin-left:-58px; width:180px;"><img src="images/numbr_people.gif" alt="number of people" title="Number of people" /></div>
                            
                            
							<div style="float:left;margin-left:3px" class="finish_line_txt_field_bg">
							  <input name="no_people" type="text" onblur="pricevalue()" id="no_people" value="<?=$no_people?>" style="width:112px;margin-left:-6px;margin-top:-2px;background:none;border:none;font-family:Arial, Helvetica, sans-serif;" />
						  </div>
                      <div style="padding-left:117px;"><a href="" onclick="return hs.htmlExpand(this,{headingText: 'More Info'})"><img src="images/question-_mark.gif" border="0" alt="question mark" title="Question mark" /></a>
					<div class="highslide-maincontent"> 
					 If you want more than one person in your Caricature Toon, this is the box to let us know. Enter the number of people you&prime;d like to have in your Toon. If you require multiple individual Toons, please submit each order separately. For assistance or any special requests, please don&prime;t hesitate to <a href="mailto:<?=$_CONFIG['email_contact_us']?>?subject=Message - Support Request">contact us.</a> 
					 </div> 
					  </div>
                         
						</div>
						<div style="clear:both; height:38px;">
							<div style="float:left;padding-top:5px; margin-left:67px;"><img src="images/price_txt.gif" alt="price" title="Price" /></div>
							<? if($row_first_price['lowprice']!=''){ ?>
							<div style="float:left;text-align:center;margin-left:12px;font-family:Arial, Helvetica, sans-serif;display:block;" class="finish_line_txt_field_bg" id="total_price_gallery" name="price"><?=$row_first_price['lowprice'];?></div>
                            <div style="float:left;text-align:center;margin-left:12px;font-family:Arial, Helvetica, sans-serif;display:none;" class="finish_line_txt_field_bg" id="total_price" name="price"></div>
							<? } else { ?>
                            <div style="float:left;" id="total_price_gallery" name="price"></div>
                            <div style="float:left;text-align:center;margin-left:12px;font-family:Arial, Helvetica, sans-serif;display:block;" class="finish_line_txt_field_bg" id="total_price" name="price"></div>
                            <? } ?>
						</div>
						<div id="art_style_error" style="display:none; clear:both;" class="div_text_buynow">*Please choose artist style</div>
						<div id="no_people_error" style="display:none" class="div_text_buynow">*Please enter number of people</div>
						<div id="error_photo1" style="display:none;" class="div_text_buynow">*Please select one image</div>
                        <div id="uploading" style="display:none;" class="div_text_buynow"><img src="images/loader_green.gif"/><span class="div_text_green">&nbsp;* Uploading Images..This may take several minutes</span></div>
						<div style="float:left">
							
							<div style="padding-left:117px;">
							<input  name="ok" type="image" src="images/check_out.gif" onclick="return validation()" border="0" alt="check out" title="Check out" /></div>
					  </div>
					  </div>
					</form>
				   <? if($number_spo!=0) { ?>
                    <div style="clear:both;margin-left:15px;color:#ff6e01;font-family:Arial, Helvetica, sans-serif;font-size:12px;margin-right:20px"><? include ('includes/special_offers_popup.php');?></div>
                    <div style="clear:both;margin-left:20px;color:#044BA2;font-family:Arial, Helvetica, sans-serif;font-size:12px;margin-right:20px;margin-top:25px; text-align:left;">Note:- Any of our special offers do not require you to place a coupon code. We automatically calculate the discount at checkout</div>
                    <? } ?>
					<div style="height:3px; clear:both;"></div>
				</div>
				<div class="finish_line_btm_left_curve"><img src="images/contact_btm_left_curve.gif" /></div>
				<div class="contact_middle_strip_btm finish_line_btm_middle_strip"></div>
				<div><img src="images/contact_btm_right_curve.gif" /></div>
				<div class="finish_line_btm_div"></div>
			</div>
			<div align="justify"class="header_text" style="padding:10px 20px 10px 10px;">Most cartoon caricatures that are designed by us are used as gifts or souvenirs. They can be used on various things, which range from, Mugs, T-Shirts, Framed Posters, Framed Canvas, Mouse pad, Calendars, Greeting Cards, Water Bottles, Aprons, Tote Bag, Puzzles, Coasters, Buttons, Photo Key and Luggage Tag, Playing Cards, Ceramic Tiles, Jewelry, Keepsake Box, Desktop Organizer, Magnets, Gallery Wrapped Canvas, Rolled Canvas, Rolled Posters, Flat Cards, Eco Friendly Cards and Notepads, Cards, Stickers, eClings, Gadget Cases, Photobook and so forth.<br /> <br /> 
		This website is designed to make it a cakewalk for you to make a Cartoon Caricature of yourself and others. The ordering is very simple. Upload the pictures that you&prime;d want to be cartoon caricatures and then find the artist&prime;s drawing style from the galleries you have liked the most. Give the caricaturist a brief description of what you&prime;d want to make out of it. Whether you want to blow it up, warp and twist it or have some other special idea that you think would be ideal and you will love. Once everything is filled it go ahead and place your order. It is that easy and simple.<br /> <br /> 
		Once the caricature has been created we will alert you, and it will be placed in the My Toons section. We give you a 100% assurance so that you can download your Royalty Free Caricature Toon once your picture is done. So why the wait try one today!
		</div>
		</div>
		<!--content ends-->	
		<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>