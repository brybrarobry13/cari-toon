<? 
	include("includes/configuration.php");
	$user_id=$_SESSION['sess_tt_uid'];
	$order_id=$_REQUEST['ord_id'];
	$artist_id=$_REQUEST['art_id'];
	$sql_content="SELECT TOP.*,T.user_id,T.order_id,TP.* FROM `toon_order_products` TOP,`toon_orders` T,`toon_proofs` TP WHERE TOP.`opro_id`=TP.`opro_id` AND T.`order_id`=TOP.`order_id` AND (T.`user_id` ='$user_id' OR T.`artist_id`='$user_id') AND T.`order_id` = '$order_id' ORDER BY TP.`proof_posted` DESC ";
	$rs_content = mysql_query($sql_content);
	$number_rs_content=mysql_num_rows($rs_content);
	if($artist_id==$user_id)
	{
	$u_id=$artist_id;
	 include (DIR_INCLUDES.'artist_header.php');
	}
	else
	{
		include (DIR_INCLUDES.'header.php');
	}
	 
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
			<div align="left" style="width:59%;margin-left:210px;">
				<div align="left" style="text-align:left;" class="header_text">Below is your previous Caricature Toon Proofs. If you require any additional Caricatures changes, no problem, your Artist aims to please.</div>
			</div>
			<div style="height:20px;"></div>
			<div>
				<div class="buy_now_curvepadding" style="margin-left:190px"><img src="images/white_curve_top_left.gif" /></div>
				<div class="buy_now_white_curve_top_middle_strip previous_whiteCurve_middle_strip"></div>
				<div class="clear_right"><img src="images/white_curve_top_right.gif" /></div>							
				<div class="finish_white_curve_middle_border" style="margin-left:190px;margin-right:194px;">
					<div style="padding-left:120px;height:70px;"><img src="images/previous_proofes.gif" border="0" alt="previous proofs" title="Previous proofs" /></div>
					<?
						if($number_rs_content==0)
						{
						?>
						<div class="div_text" style="float:left;margin-left:250px;margin-top:50px;margin-bottom:50px;">No Previous proofs</div>
						<?
						}
					?>
					<? while($content=mysql_fetch_assoc($rs_content))
					   { 
					?>
					<div style="float:left; width:200px;margin-left:60px;margin-top:25px;">
					<div  class="orange_txt" >Date:<? echo date('m-d-Y',strtotime($content['proof_posted'])); ?></div>
					<div>
						<div style="float:left;">
							<div><img src="<? echo 'includes/imageProcess.php?image='.$content['proof_image'].'&type=proof&size=200' ?>" border="0" /></div>
							<div ><a href="<?='includes/imageProcess.php?image='.$content['proof_image'].'&type=proof&size=1000';?>" onclick="return hs.expand(this)"><img src="images/enlargebutton2.gif" border="0" alt="enlarge" title="Enlarge" /></a></div>
						</div>
					</div>
					</div>
				    <?	
					   }
					?>
					<div style="clear:both">&nbsp;</div>
				</div>
				
				<div>
					<div class="buy_now_curvepadding" style="margin-left:190px;"><img src="images/contact_btm_left_curve.gif" /></div>
					<div class="white_btm_middle_strip previous_whiteCurve_middle_strip"></div>
					<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif" /></div>
				</div>
			</div>
			<div>&nbsp;</div>
		</div>
		
		<!--content ends-->	
		<!--footer-->	
<? if($artist_id==$user_id)
	{
	 include (DIR_INCLUDES.'artist_footer.php');
	}
	else
	{
		include (DIR_INCLUDES.'footer.php');
	} ?>