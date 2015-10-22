<? 
	include("includes/configuration.php");
	include (DIR_INCLUDES.'header.php');
	$user_id=$_SESSION['sess_tt_uid'];
	$sql_content="SELECT TOP.*,T.user_id,T.order_id,T.order_status FROM `toon_order_products` TOP,`toon_orders` T WHERE   T.`order_id`=TOP.`order_id` AND (T.`order_status`='Completed' OR T.`order_status`='artist paid') AND T.`user_id` ='$user_id' ORDER BY TOP.`opro_posted` DESC ";
	$rs_content = mysql_query($sql_content); 
	$number=mysql_num_rows($rs_content);
?> 
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
</script>

		<!--header ends-->
		<!--content starts-->
		<link href="styles/style.css" rel="stylesheet" type="text/css" />
		
		<div id="content">
			<div class="height80"></div>
			<div align="left" style="width:58%;margin-left:210px;">
				<div align="left" style="text-align:left;" class="header_text">Thanks for trusting us with your Caricature Toon. You can now download the high-resolution images, order a gift to display your toon, or even order more caricatures.</div>
			</div>
			<div style="height:20px;"></div>
			<div>
				<div class="buy_now_curvepadding contact_margin"><img src="images/white_curve_top_left.gif" /></div>
				<div class="buy_now_white_curve_top_middle_strip previous_whiteCurve_middle_strip"></div>
				<div class="clear_right"><img src="images/white_curve_top_right.gif" /></div>							
				<div class="finish_white_curve_middle_border contact_margin_both">
				<div style="padding-left:120px;height:70px;"><img src="images/PRVUS_TOONS.gif" border="0" alt="previous finishes" title="Previous finishes" /></div>
					<?
						if($number==0)
						{
						?>
						<div class="div_text" style="padding-top:50px;padding-left:250px;padding-bottom:50px">No Previous Toons</div>
						<?
						}
					?>
					<? 
					while($content=mysql_fetch_assoc($rs_content))
					   { 
					?>
					<div style="clear:both;margin-left:20px">
                        <div  class="orange_txt" style="padding-left:50px;float:left">Order #<?=$content['order_id'] ?></div>
					
						<div class="gallery_position_previousfinishes" style="clear:both">
								<div class="gallery_bg">
                                	<div class="gallery_first_img" align="center" style="line-height:120px;vertical-align:middle;">
                                    	&nbsp;<img src="<?='includes/imageProcess.php?image='.$content['opro_caricature'].'&type=caricature&size=110';?>" border="0"/>
                                    </div>
							  </div>
                              <div class="price_enlarge_btn_first_img"  >
								<a href="z_uploads/caricature_images/<?=$content['opro_caricature'] ?>" onclick="return hs.expand(this)"><img src="images/enlargebutton.gif" border="0" alt="enlarge" title="Enlarge"  /></a></div>
							</div>
					         
                        <div style="float:left;margin-left:70px">
							<div style="padding-top:10px;float:left"><a href="download_previousfinishes.php?opro_id=<?=$content['opro_id']?>"><img src="images/download.gif" border="0" alt="download toon" title="Download toon" /></a></div>
							<div style="padding-top:10px;float:left;clear:both"><a href="buy-caricature-gift.php"><img src="images/buy_gifts.gif" border="0" alt="order products" title="Order Products" /></a></div>
                            <div style="padding-top:10px;float:left;clear:both"><a href="order-caricature.php"><img src="images/order_new_toon.gif" border="0" alt="order new toon" title="Order new toon" /></a></div>
                        </div>
					</div>	
					<div style="clear:both;height:50px">&nbsp;</div>
					<?	
					   }
					?>
                    </div>
			</div>
			<div>
				<div class="buy_now_curvepadding" style="padding-left:170px"><img src="images/contact_btm_left_curve.gif" /></div>
				<div class="white_btm_middle_strip previous_whiteCurve_middle_strip"></div>
				<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif" /></div>
			</div>
			<div style="clear:both;height:50px;">&nbsp;</div>
			<div>&nbsp;</div>
		</div>
		
		<!--content ends-->	
		<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>