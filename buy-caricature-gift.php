<?  include("includes/configuration.php");
	$u_id=$_SESSION['sess_tt_uid'];
	$ezimages_query = mysql_query("SELECT * FROM `toon_ez_categories` WHERE `ecat_display`='1' ORDER BY `ecat_priority` ASC");
	if(isloggedIn())
	{
		$cartarray_rs=mysql_query("SELECT * FROM `toon_cart` WHERE `user_id`=$u_id AND `cart_status`='active'");
		$cartarray_row=mysql_fetch_assoc($cartarray_rs);
		$number_row=mysql_num_rows($cartarray_rs);
		if($number_row)
		{
			$cart_pdt_num=count(unserialize(base64_decode($cartarray_row['cart_array'])));
		}
		else
		{
			$cart_pdt_num=0;
		}
	}
	$title_text = "Personalized Photo Gifts:";
	include (DIR_INCLUDES.'header.php'); 
?>
<link rel="stylesheet" type="text/css" href="styles/highslide.css" />
<script type="text/javascript" src="javascripts/highslide-with-html.js"></script>
<script type="text/javascript" src="javascripts/imageswap.js"></script>
<script>
window.onload=function(){MM_preloadImages('images/lefttop_blue.gif','images/righttop_blue.gif','images/left_bottom.gif','images/right_bottom.gif','images/topstrip_blue.gif','images/bottom_strip.gif','images/left_strip.gif','images/rightstripblue.gif')}
</script>
<script type="text/javascript" src="javascripts/highslide-full.js"></script>
<script type="text/javascript" src="javascripts/buy_products.js"></script>
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
</script>
		<!--header ends-->
		<!--content starts-->
		<div id="content">
			<div style="padding:0 0 0 785px;"><script type="text/javascript" src="http://cdn.socialtwist.com/2011113055505/script.js"></script><a class="st-taf" href="http://tellafriend.socialtwist.com:80" onclick="return false;" style="border:0;padding:0;margin:0;"><img alt="SocialTwist Tell-a-Friend" style="border:0;padding:0;margin:0;" src="http://images.socialtwist.com/2011113055505/button.png" onmouseout="STTAFFUNC.hideHoverMap(this)" onmouseover="STTAFFUNC.showHoverMap(this, '2011113055505', window.location, document.title)" onclick="STTAFFUNC.cw(this, {id:'2011113055505', link: window.location, title: document.title });"/></a></div>
			<div style="padding: 0pt 0pt 0pt 43px;position: relative;"><img border="0" src="images/gift_ideasmain.png"></div>
			<div style="margin:0px;">   
			<table cellpadding="0" cellspacing="0" width="724" align="center" border="0">
				<tr>
				<td>
					<div style="width:850px; margin:auto;-moz-border-radius: 20px;-webkit-border-radius: 20px;-khtml-border-radius: 20px;border-radius: 20px; background-color:#FFF;padding:10px;"> 
					<table width="100%" style="-moz-border-radius: 0.5em;-webkit-border-radius: 0.5em;-khtml-border-radius: 0.5em;border-radius: 0.5em;">
					   <tr>
						<td  style="background-color:#FFFFFF;height:40px; font-family:Arial; font-weight:bold; font-size:16px;color:#003399; padding-left:15px;" width="240">Click items below <br /> to see pricing</td>
						<td width="70%" align="right">
							<table cellpadding="0" cellspacing="0" border="0">
								<tr>
									<? if(isloggedIn()){?>
									 <td height="12" valign="bottom" align="left"><img src="images/top_left_curve.png" alt="top left curve" /></td>
									 <td width="20" valign="top" align="right" style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;padding-left:11px"><a href="shoppingcart.php" class="header_links_ez"><img border="0" src="images/shop_img.png" /></a></td>
									 <td align="left" valign="top" style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;padding-left:11px">&nbsp;&nbsp;<a href="shoppingcart.php" class="header_links_ez"> <?=$cart_pdt_num?> <? if($cart_pdt_num==1) {?> Item In Cart<? }else{?> Items In Cart<? }?></a></td>
									 <td style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;padding-left:11px">&nbsp;</td>
									 <td valign="top" align="left" style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;padding-left:11px"><? if($cart_pdt_num!=0) {?><a href="shoppingcart.php" class="header_links_ez">View Cart</a><? }?></td>
									 <td valign="bottom"><img src="images/top_right_curve.png" /></td>
									 <? } else {?>
									 <td>&nbsp;</td>
									 <? } ?>
								</tr>
							</table>
						</td>
					  </tr>
					   <tr>
						<td valign="top" style="padding-top:10px;" id="tr_divs">
							<table cellpadding="1" cellspacing="0" width="240" border="0">
							<? 	$qq=1;
								$jj=1;
								$mainezimag_query = mysql_query("SELECT * FROM `toon_main_category` WHERE `mcat_display`='1' ORDER BY `mcat_priority` ASC");
								while($mainezimg_row = mysql_fetch_array($mainezimag_query))
								{?>
								<tr><td colspan="2" ><img src="images/giftnav.png"  width="240"/></td></tr>
								<tr><td colspan="2" id="maincat_td_<?=$qq?>"><img src="images/giftleftarrow.png"  style="padding-left:10px;"/><a onmouseover="maincat_td_mouseover('<?=$qq?>')" onmouseout="maincat_td_mouseout('<?=$qq?>')" style="font-size:16px; font-family:arial; font-weight:bold; color:#000066;text-decoration:none;padding-left:10px;" id="x<?=$mainezimg_row['mcat_id']?>" href="maincategory/<?=$mainezimg_row['mcat_id']?>/merchandise_learn.html"><?=$mainezimg_row['mcat_name'] ?></a></td></tr>
								<tr><td >
									<div id="<?='main_'.$qq?>" style="display: none;">
									<table cellpadding="1" cellspacing="0" width="240">
								<? 	$subezimag_query = mysql_query("SELECT * FROM `toon_ez_categories` WHERE mcat_id = ".$mainezimg_row['mcat_id']." AND `ecat_display`='1' ORDER BY `ecat_priority` ASC");
									while($subezimg_row = mysql_fetch_array($subezimag_query))
									{ ?>
									<tr><td width="100%" colspan="2" id="subcat_td_<?=$jj?>"><a style="font-size:14px;font-family:arial;font-weight:bold;color:#000066;text-decoration:none" id="x<?=$subezimg_row['ecat_id']?>" href="subcategory/<?=$mainezimg_row['mcat_id']?>/<?=$subezimg_row['ecat_id']?>/merchandise_learn.html" onmouseover="subcat_td_mouseover('<?=$jj?>')" onmouseout="subcat_td_mouseout('<?=$jj?>')"><?=$subezimg_row['ecat_name']?></a></td></tr>
									<tr><td ><div id="<?='sub_'.$jj?>" style="display: none;"><table>
									<? $ezimag_subpro = mysql_query("SELECT * FROM `toon_ez_products` WHERE ecat_id = ".$subezimg_row['ecat_id']." AND `ezproduct_display`='1' ORDER BY `ezproduct_priority` ASC");
									while($ezimg_subpro_row=mysql_fetch_array($ezimag_subpro))
									 { 
										$j++;?>
									<tr onmouseover="td_mouseover('<?=$j?>')" id="td_<?=$j?>" onmouseout="td_mouseout('<?=$j?>')">
										<td class="grey_txt" width="100%"><a style="text-decoration:none" class="grey_txt" href="category/<?=$ezimg_subpro_row['ecat_id']?>/merchandise_learn.html"><?=$ezimg_subpro_row['ezproduct_name'] ?></a></td>
										<td class="grey_txt" style="text-align:right;"><a style="text-decoration:none" class="grey_txt" href="category/<?=$ezimg_subpro_row['ecat_id']?>/merchandise_learn.html"><?=number_format($ezimg_subpro_row['ezproduct_price'],2); ?></a></td>
									</tr> 
									<? 
									}?>
									</table>
									</div>
									</td></tr>
								<? $jj++;
									} ?>
								<!--<input type="hidden" name="subtotal_cnt" id="subtotal_cnt" value="<?=$jj?>" />-->
								</table>
									</div>
								</td></tr>
								<?
								$qq++;
								 } ?>
								 <tr><td colspan="2" ><img src="images/giftnav.png"  width="240"/></td></tr>
								 <input type="hidden" name="subtotal_cnt" id="subtotal_cnt" value="<?=$jj?>" />
								 <input type="hidden" name="maintotal_cnt" id="maintotal_cnt" value="<?=$qq?>" />
						   </table> 
							<table>
							   <tr>
									<td style="padding-top:50px; padding-left:25px;"><img border="0" src="images/world_wide_shopping.png" alt="shopping" title="shopping" width="190px"/></td>
							   </tr>
						   </table>
						</td>
						<td style="padding-top:5px;padding-left:5px;" valign="top">
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" >
							<div style="border-radius:55px;-moz-border-radius:25px;-webkit-border-radius:25px;-khtml-border-radius: 25px;">
						   <?	$maincatimages_query = mysql_query("SELECT * FROM `toon_main_category` WHERE `mcat_display`='1' ORDER BY `mcat_priority` ASC");
								$imagecnt=1;
								$colori=0;
								while($maincatimages_row=mysql_fetch_array($maincatimages_query)) 
								{
								
								if($colori%5==4)
								{
									$bgimg1="giftblue11";
									$bgimg2="giftblue12";
									$bgimg3="giftblue13";
								}
								else if($colori%5==3)
								{
									$bgimg1="giftgreen1";
									$bgimg2="giftgreen2";
									$bgimg3="giftgreen3";
								}
								else if($colori%5==2)
								{
									$bgimg1="giftviolet1";
									$bgimg2="giftviolet2";
									$bgimg3="giftviolet3";
								}
								else if($colori%5==1)
								{
									$bgimg1="giftblue21";
									$bgimg2="giftblue22";
									$bgimg3="giftblue23";
								}
								else if($colori%5==0)
								{
									$bgimg1="giftorange1";
									$bgimg2="giftorange2";
									$bgimg3="giftorange3";
								} ?>
							<tr><td colspan="3"><img src="images/<?=$bgimg1?>.png" border="0" width="600" height="12"/></td></tr>	 
							 <tr>
								<td style="background:url(images/<?=$bgimg2?>.png);">
									<table cellpadding="1" cellspacing="1" width="99%"  >
										<tr><td height="5"></td></tr>
										<tr>
                                           <td style="width:240px;padding:0 5px 0 5px;"><a href="<?=$_SERVER['HTTP_HOST']?>z_uploads/EZ_category_images/<?=$maincatimages_row['mcat_image']?>" onclick="return hs.expand(this)"><img src="<? echo $_SERVER['HTTP_HOST']?>z_uploads/EZ_category_images/<?=$maincatimages_row['mcat_image'];?>" border="0" alt="<?=$maincatimages_row['mcat_name']?>" title="<?=$maincatimages_row['mcat_name']?>" style="border: 1px solid #CCCCCC;" width="240" /></a></td>
											<td valign="top">
												<table cellspacing="1" cellpadding="1" width="100%" >
												<tr>
													<td><a href="maincategory/<?=$maincatimages_row['mcat_id']?>/merchandise_learn.html" style="text-decoration:none"><font class="text_blue" style="color:#FFFF00 !important; font-size:16px;"><b><?=$maincatimages_row['mcat_name']?></b></font></a></td>
												</tr>
												<tr>
													<td style="font-family:Arial, Helvetica, sans-serif;color:#FFF;font-size:13px; list-style-image:url(images/sqr.png);"><?=$maincatimages_row['mcat_description']?></td>
											   </tr>
											   <tr><td height="10"></td></tr>
											   <? $firstsubcategory_query=  mysql_query("SELECT * FROM `toon_ez_categories` WHERE `mcat_id`=".$maincatimages_row['mcat_id']." ORDER BY `toon_ez_categories`.`ecat_priority` ASC"); 
												$firstsubcategory_row=mysql_fetch_array($firstsubcategory_query);
												
											/*   if($firstsubcategory_row['ecat_id']!="") {*/
												   
											   $ezpdt_query = mysql_query("SELECT * FROM `toon_ez_products` WHERE `ecat_id`=".$firstsubcategory_row['ecat_id']." AND `ezproduct_display`='1' ORDER BY `ezproduct_priority` ASC");								   
												$ezpdt_row=mysql_fetch_array($ezpdt_query); 
												$valcount = count($ezpdt_row);
												 if($valcount!='') { ?>
												<tr>
												   <td align="left" ><a href="maincategory/<?=$maincatimages_row['mcat_id']?>/merchandise_learn.html"><img src="<?=$_SERVER['HTTP_HOST']?>images/giftviewmore.png" style="border:none;" id="image_<?=$imagecnt?>" alt="view More Gifts Items" title="view More Gifts Items" /></a></td>
												</tr>
												<? }?>
												</table>
											</td>
										</tr>
									  <tr><td height="5"></td></tr>
								  </table>
								</td>
							</tr>
							<tr><td colspan="3"><img src="images/<?=$bgimg3?>.png" border="0" width="600" height="12"/></td></tr>	 
							<tr><td colspan="3" height="10" ></td></tr>
							<? $imagecnt++;
							 $colori++;
							
							 } ?>
							</div>
							</table>
						</td>
					   </tr>
					   <tr><td colspan="2" height="5"></td></tr>
					</table>
					</div>
				</td>
				</tr>
			</table>
		</div>
		<div style="height:20px;"></div>	
		<div class="header_text" style="padding:0 0px 0 80px;width:830px;">In life all those special occasions need celebrating. Time and again we find ourselves looking for new and unique gifting ideas. With caricature toons, we can provide you with some funky caricature toon gifting options that are truly unique. We&prime;ve been told time and time again that our caricature cartoons made a huge splash and are an absolute cherished hit, always guaranteed to put a smile on the face of the person who receives it.<br/><br/>It doesn&prime;t just stop with getting gifts for others they are also great gifts to give your self, there is nothing better than seeing your Caricature Toon displayed on a cool product, your family or co-workers will definitely take notice and ask where you got that. We&prime;ve seen some great final gifts our customers have created, some with one caricature, others with two or even with a group shot. Either way using a photo for caricature and printing it on a gift is really cool. 
Buying our gifting products online using our website is fast and easy. The caricature you ordered and approved is already pre-loaded into the buy products builder system, no need to upload it from your computer, and once you place your caricature cartoon a preview is shown automatically so you know exactly what it&prime;s going to look like.<br/><br/>The process is simple. Just browse through this section, find the product you prefer from our long list and check out how your caricature cartoon will look like on it. Don&prime;t worry about being a designer; we have lots and lots pre-loaded designs available for you to use and constantly adding more regularly. Our most popular are caricatured frames, caricature mouse pads, caricature mugs, caricature water bottles, caricature cards and caricature t-shirts.<br/><br/>You may want to spice things up even more by making Triathlon race support crew caricature T-shirts. Or surprise someone with a set of humorous playing cards. Or put your caricature on a necklace or cartooned keepsake box. You also don&prime;t need to just use our site for caricature toons, from experience, we can tell you football caricature toons, movie caricature toons, engagement caricature toons, golfing caricature toons, retirement caricature toons, surfing caricature toons are also quite popular and ordered often.<br/><br/></div>
        <div style="height:20px">&nbsp;</div>			
		</div>
		<!--content ends-->	
		<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>