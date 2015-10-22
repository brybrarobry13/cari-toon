<?  include("includes/configuration.php");
	$u_id=$_SESSION['sess_tt_uid'];
	$cat_id=$_REQUEST['cat_id'];
	$mcatid=$_REQUEST['mcat_id'];
		
	if($cat_id==""&&$mcatid=="")
	{
	header("Location:buy-caricature-gift.php");
	exit();
	}
	?>
	
	<? if($mcatid!=""){?>
	<script>var mdivid=<?=$mcatid?>;</script>
	<? } ?>
	<? if($cat_id!=""){?>
	<script>var cdivid=<?=$cat_id?>;</script>
	<? } ?>
	<?
	$ezimages_query = mysql_query("SELECT * FROM `toon_ez_products` WHERE `ecat_id`='$cat_id' AND `ezproduct_display`='1' ORDER BY `ezproduct_priority` ASC");
	$ez_cat_query = mysql_query("SELECT * FROM `toon_ez_categories` WHERE `ecat_id`='$cat_id'");
	$ez_cat_row=mysql_fetch_array($ez_cat_query);
	$subimages_query = mysql_query("SELECT * FROM `toon_ez_categories` WHERE `mcat_id`='$mcatid' AND `ecat_display`='1' ORDER BY `ecat_priority` ASC");
	
	
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
	include (DIR_INCLUDES.'header.php'); 
?>
<link rel="stylesheet" type="text/css" href="<?=$_SERVER['HTTP_HOST']?>styles/highslide.css" />
<link href="<?=$_SERVER['HTTP_HOST']?>styles/style.css" rel="stylesheet" type="text/css" />
<!--<base href="http://www.toonsforu.com/" />-->
<base href="http://www.caricaturetoons.com/" />
<!--<base href="http://localhost/priswin/caricaturetoons/" />-->
<script type="text/javascript" src="<?=$_SERVER['HTTP_HOST']?>javascripts/highslide-with-html.js"></script>
<script type="text/javascript" src="<?=$_SERVER['HTTP_HOST']?>javascripts/imageswap.js"></script>
<script>
window.onload=function(){MM_preloadImages('images/lefttop_blue.gif','images/righttop_blue.gif','images/left_bottom.gif','images/right_bottom.gif','images/topstrip_blue.gif','images/bottom_strip.gif','images/left_strip.gif','images/rightstripblue.gif')}
</script>
<script type="text/javascript" src="<?=$_SERVER['HTTP_HOST']?>javascripts/highslide-full.js"></script>
<script type="text/javascript" src="<?=$_SERVER['HTTP_HOST']?>javascripts/buy_products.js"></script>
<script type="text/javascript">
function mloadpage()
{
	if(mdivid!="")
	{
		document.getElementById('main_'+mdivid).style.display="block";
		document.getElementById('maincat_td_'+mdivid).style.backgroundColor="#FFAD23";
	}
	if(cdivid!="")
	{
		document.getElementById('sub_'+cdivid).style.display="block";
		document.getElementById('subcat_td_'+cdivid).style.backgroundColor="#FFAD23";
	}
}
</script>
<script type="text/javascript">
	hs.graphicsDir = 'images/graphics/';
	hs.captionText ="<a onclick='hs.close();'><img src='images/close.gif' /></a>",
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
	<div style="padding:0 0 0 785px;"><img border="0" src="<?=$_SERVER['HTTP_HOST']?>images/icons.png"></div>
	<div style="padding: 0pt 0pt 0pt 43px; margin-top: -25px; position: relative;"><img border="0" src="<?=$_SERVER['HTTP_HOST']?>images/gift_ideasmain.png"></div>
	<div>
	  <table cellpadding="0" cellspacing="0" width="724" align="center" border="0">
		<tr>
		  <td>
		  <div style="width:850px; margin:auto;-moz-border-radius: 20px;-webkit-border-radius: 20px;-khtml-border-radius: 20px;border-radius: 20px; background-color:#FFF;padding:10px;">
			  <table width="100%" style="-moz-border-radius: 0.5em;-webkit-border-radius: 0.5em;-khtml-border-radius: 0.5em;border-radius: 0.5em;" border="0">
			    <tr>
					<td style="background-color:#FFFFFF;height:40px; font-family:Arial; font-weight:bold; font-size:16px;color:#003399; padding-left:15px;" width="240">Click items below <br /> to see pricing</td>
					<td width="70%" align="right">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<? if(isloggedIn()){?>
								 <td height="12" valign="bottom" align="left"><img src="<?=$_SERVER['HTTP_HOST']?>images/top_left_curve.png" alt="top left curve" /></td>
								 <td width="20" valign="top" align="right" style="background:url(<?=$_SERVER['HTTP_HOST']?>images/shadow_top.png) repeat-x bottom; font-size:2px;padding-left:11px"><a href="shoppingcart.php" class="header_links_ez"><img border="0" src="<?=$_SERVER['HTTP_HOST']?>images/shop_img.png" /></a></td>
								 <td align="left" valign="top" style="background:url(<?=$_SERVER['HTTP_HOST']?>images/shadow_top.png) repeat-x bottom; font-size:2px;padding-left:11px">&nbsp;&nbsp;<a href="shoppingcart.php" class="header_links_ez"> <?=$cart_pdt_num?> <? if($cart_pdt_num==1) {?> Item In Cart<? }else{?> Items In Cart<? }?></a></td>
								 <td style="background:url(<?=$_SERVER['HTTP_HOST']?>images/shadow_top.png) repeat-x bottom; font-size:2px;padding-left:11px">&nbsp;</td>
								 <td valign="top" align="left" style="background:url(<?=$_SERVER['HTTP_HOST']?>images/shadow_top.png) repeat-x bottom; font-size:2px;padding-left:11px"><? if($cart_pdt_num!=0) {?><a href="shoppingcart.php" class="header_links_ez">View Cart</a><? }?></td>
								 <td valign="bottom"><img src="<?=$_SERVER['HTTP_HOST']?>images/top_right_curve.png" /></td>
								 <? } else {?>
								 <td>&nbsp;</td>
								 <? } ?>
							</tr>
						</table>
					</td>
			    </tr>
				<tr>
					<td valign="top" style="padding-top:10px;" colspan="2">
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
							   <td valign="top" style="padding-top:5px;" id="tr_divs" width="240">
									<table cellpadding="1" cellspacing="0" width="240" >
									<? 	$mainezimag_query=mysql_query("SELECT * FROM `toon_main_category` WHERE `mcat_display`='1' ORDER BY `mcat_priority` ASC");
										while($mainezimg_row = mysql_fetch_array($mainezimag_query))
										{?>
										<tr><td colspan="2" ><img src="<?=$_SERVER['HTTP_HOST']?>images/giftnav.png"  width="240"/></td></tr>
										<tr ><td colspan="2" id="maincat_td_<?=$mainezimg_row['mcat_id']?>"><img src="<?=$_SERVER['HTTP_HOST']?>images/giftleftarrow.png"  style="padding-left:10px;"/><a style="font-size:16px; font-family:arial; font-weight:bold; color:#000066;text-decoration:none;padding-left:10px;" id="x<?=$mainezimg_row['mcat_id']?>"  href="maincategory/<?=$mainezimg_row['mcat_id']?>/merchandise_learn.html" onclick="MainCollapse('<?=$mainezimg_row['mcat_id']?>')" <? if($mcatid!=$mainezimg_row['mcat_id']){?> onmouseover="maincat_td_mouseover('<?=$mainezimg_row['mcat_id']?>')" onmouseout="maincat_td_mouseout('<?=$mainezimg_row['mcat_id']?>')" <? }?> ><?=$mainezimg_row['mcat_name'] ?></a></td></tr>
										<tr><td >
											<div id="<?='main_'.$mainezimg_row['mcat_id']?>" style="display: none;">
											<table cellpadding="1" cellspacing="0" width="100%" >
										<? 	$subezimag_query = mysql_query("SELECT * FROM `toon_ez_categories` WHERE mcat_id = ".$mainezimg_row['mcat_id']." AND `ecat_display`='1' ORDER BY `ecat_priority` ASC");
											while($subezimg_row = mysql_fetch_array($subezimag_query))
											{ ?>
											<tr><td colspan="2" style="border-top: 1px solid rgb(153, 153, 153);"></td></tr>
											<tr><td width="100%" colspan="2" id="subcat_td_<?=$subezimg_row['ecat_id']?>"><img src="<?=$_SERVER['HTTP_HOST']?>images/giftleftarrow.png"  style="padding-left:10px;"/><a class="text_blue" style="text-decoration:none;padding-left:10px;" id="x<?=$subezimg_row['ecat_id']?>" href="subcategory/<?=$mainezimg_row['mcat_id']?>/<?=$subezimg_row['ecat_id']?>/merchandise_learn.html" onclick="SubCollapse('<?=$subezimg_row['ecat_id']?>')" <? if($cat_id!=$subezimg_row['ecat_id']){?> onmouseover="subcat_td_mouseover('<?=$subezimg_row['ecat_id']?>')" onmouseout="subcat_td_mouseout('<?=$subezimg_row['ecat_id']?>')" <? } ?>><b><?=$subezimg_row['ecat_name']?></b></a></td></tr>
											<tr><td ><div id="<?='sub_'.$subezimg_row['ecat_id']?>" style="display: none;"><table width="100%">
											<? $ezimag_subpro = mysql_query("SELECT * FROM `toon_ez_products` WHERE ecat_id = ".$subezimg_row['ecat_id']." AND `ezproduct_display`='1' ORDER BY `ezproduct_priority` ASC");
											while($ezimg_subpro_row=mysql_fetch_array($ezimag_subpro))
											 { 
												$j++;?>
											<tr><td colspan="2" style="border-top: 1px solid rgb(153, 153, 153);"></td></tr>
											<tr onmouseover="td_mouseover('<?=$j?>')" id="td_<?=$j?>" onmouseout="td_mouseout('<?=$j?>')">
												<td class="grey_txt" width="100%"><img src="<?=$_SERVER['HTTP_HOST']?>images/giftleftarrow.png"  style="padding-left:10px;"/><a style="text-decoration:none; color:#000066;padding-left:10px;" class="grey_txt"  href="<?=$_SERVER['HTTP_HOST']?>ezbuilder.php?opro_id=<?=$ezimg_subpro_row['ezproduct_id'] ?>"><?=$ezimg_subpro_row['ezproduct_name'] ?></a></td>
												<td class="grey_txt"  style="text-align:right;"><a style="text-decoration:none; color:#000066;" class="grey_txt" href="<<?=$_SERVER['HTTP_HOST']?>ezbuilder.php?opro_id=<?=$ezimg_subpro_row['ezproduct_id'] ?>"><?=number_format($ezimg_subpro_row['ezproduct_price'],2); ?></a></td>
											</tr> 
											<? 
											}?>
											</table></div>
											</td></tr>
										<? } ?>
										<!--<input type="hidden" name="subtotal_cnt" id="subtotal_cnt" value="<?=$jj?>" />-->
										</table></div></td></tr>
										<? } ?>
										 <tr><td colspan="2" ><img src="<?=$_SERVER['HTTP_HOST']?>images/giftnav.png"  width="240"/></td></tr>
										 <input type="hidden" name="subtotal_cnt" id="subtotal_cnt" value="<?=$jj?>" />
										 <input type="hidden" name="maintotal_cnt" id="maintotal_cnt" value="<?=$qq?>" />
								   </table>
								   <table>
									   <tr>
										  <td style="padding-top:50px; padding-left:25px;"><img border="0" src="<?=$_SERVER['HTTP_HOST']?>images/world_wide_shopping.png" width="190"></td>
									   </tr>
								   </table> 
							  </td>
							  <script>mloadpage()</script>
								<td width="2%">&nbsp;</td>
								<td style="padding-top:5px;padding-left:5px;" valign="top" width="70%">
									<table cellpadding="0" cellspacing="0" width="99%">
									<div style="border-radius:55px;-moz-border-radius:25px;-webkit-border-radius:25px;-khtml-border-radius: 25px;">
									<? if($cat_id=="")
									   { 
										$imagecnt=1;
										$colori=0;
										while($subimages_row=mysql_fetch_array($subimages_query)) 
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
											}	
											  ?>
											<tr><td colspan="3"><img src="<?=$_SERVER['HTTP_HOST']?>images/<?=$bgimg1?>.png" border="0" width="600" height="12"/></td></tr>	 
											<tr>
												<td style="background:url(<?=$_SERVER['HTTP_HOST']?>images/<?=$bgimg2?>.png);">
													<table cellpadding="1" cellspacing="1" width="99%"  border="0">
														<tr><td height="5"></td></tr>
														<tr>
															<td  style="padding:0 5px 0 5px;width:240px;"><a href="<?=$_SERVER['HTTP_HOST']?>z_uploads/EZ_category_images/<?=$subimages_row['ecat_image']?>" onclick="return hs.expand(this)"><img src="<? echo $_SERVER['HTTP_HOST']?>z_uploads/EZ_category_images/<?=$subimages_row['ecat_image']?>" border="0" alt="<?=$maincatimages_row['ecat_name']?>" title="<?=$maincatimages_row['ecat_name']?>" style="border: 1px solid #CCCCCC;" width="240" /></a></td>
															<td valign="top">
																<table cellspacing="2" cellpadding="2" width="100%">
																	<tr>
																		<td><a href="subcategory/<?=$mcatid?>/<?=$subimages_row['ecat_id']?>/merchandise_learn.html" style="text-decoration:none"><span class="text_blue" style="color:#FFFF00;font-size:16px !important;"><b><?=$subimages_row['ecat_name']?></b></span></a></td>
																	</tr>
																	<tr>
																	<td style="font-family:Arial, Helvetica, sans-serif;color:#FFF;font-size:13px; list-style-image:url(<?=$_SERVER['HTTP_HOST']?>images/sqr.png);"><?=$subimages_row['ecat_description']?></td>
															   </tr>
																	<tr><td height="10"></td></tr>
																	<? $ezpdt_query = mysql_query("SELECT * FROM `toon_ez_products` WHERE `ecat_id`=".$subimages_row['ecat_id']." AND `ezproduct_display`='1' ORDER BY `ezproduct_priority` ASC");								   
																	$ezpdt_row=mysql_fetch_array($ezpdt_query) ?>
																	<tr>
																<? if($ezpdt_row['ezproduct_id']!="")
																{ ?>
																   <td align="right" style="padding-left:10px;"><a href="<?=$_SERVER['HTTP_HOST']?>ezbuilder.php?opro_id=<?=$ezpdt_row['ezproduct_id']?>"><img src="<?=$_SERVER['HTTP_HOST']?>images/createnow.png" style="border:none;" id="image_<?=$imagecnt?>" alt="create now" title="Create now" /></a></td>
																</tr><? }?>
																</table>
															</td>
														</tr>
														<tr><td height="5"></td></tr>
													</table>
												</td>
											</tr>
											<tr><td colspan="3"><img src="<?=$_SERVER['HTTP_HOST']?>images/<?=$bgimg3?>.png" border="0" width="600" height="12"/></td></tr>	 
											<tr><td colspan="3" height="10" ></td></tr>
											<? $imagecnt++;
											$colori++;
											}
										}
										 else 
										 {
										  $colori=0;
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
											}	
										 ?>
										 <tr><td colspan="3"><img src="<?=$_SERVER['HTTP_HOST']?>images/<?=$bgimg1?>.png" border="0" width="600" height="12"/></td></tr>
										 <tr>
											<td style="background:url(<?=$_SERVER['HTTP_HOST']?>images/<?=$bgimg2?>.png);">
												<table cellpadding="1" cellspacing="1" width="99%" >
													<tr>
														<tr><td height="5"></td></tr>
														<tr>
															<td style="padding:0 5px 0 5px;width:240px;"><a href="<?=$_SERVER['HTTP_HOST']?>z_uploads/EZ_category_images/<?=$ez_cat_row['ecat_image']?>" onclick="return hs.expand(this)"><img src="<? echo $_SERVER['HTTP_HOST']?>z_uploads/EZ_category_images/<?=$ez_cat_row['ecat_image']?>" border="0" alt="<?=$maincatimages_row['ecat_name']?>" title="<?=$maincatimages_row['ecat_name']?>" style="border: 1px solid #CCCCCC;" width="240" /></a></td>
															<td valign="top">
																<table cellspacing="2" cellpadding="2">
																	<tr>
																		<td><font class="text_blue" style="color:#FFFF00;font-size:16px !important;"><b><?=$ez_cat_row['ecat_name']?></b></font></td>
																	</tr>
																	<tr>
																		<td style="font-family:Arial, Helvetica, sans-serif;color:#FFF;font-size:13px;list-style-image:url(<?=$_SERVER['HTTP_HOST']?>images/sqr.png);"><?=$ez_cat_row['ecat_description']?></td>
																   </tr>
																	<? $ezimages_row=mysql_fetch_array($ezimages_query) ?>
																	<tr>
																		<td align="right" style="padding-left:10px;"><? if($ezimages_row['ezproduct_id']!="") { ?> <a href="<?=$_SERVER['HTTP_HOST']?>ezbuilder.php?opro_id=<?=$ezimages_row['ezproduct_id']?>"><img src="<?=$_SERVER['HTTP_HOST']?>images/createnow.png" style="border:none;" id="image_1" alt="create now" title="Create now" /></a> </td><? } ?>
																	</tr>												  
																</table>
															</td>
														</tr>
														<tr><td height="5"></td></tr>
													</tr>  
												</table>
											</td>
										 </tr>
										 <tr><td colspan="3"><img src="<?=$_SERVER['HTTP_HOST']?>images/<?=$bgimg3?>.png" border="0" width="600" height="12"/></td></tr>	
										 <tr><td colspan="3" height="10"></td></tr>
										<?
										$colori++;
										
										 }?>
									 </div>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			  </table>
			</div>
		  </td>
		</tr>
	  </table>
	</div>
  	<div style="height:60px">&nbsp;</div>
</div>

<!--content ends-->
<!--footer-->
<? include (DIR_INCLUDES.'footer.php') ?>
