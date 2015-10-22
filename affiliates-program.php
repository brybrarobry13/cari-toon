<? 
	include("includes/configuration.php");
	$title_text = "Affiliates Program:";
	include (DIR_INCLUDES.'header.php'); 
	include_once(DIR_FUNCTIONS."static.php");
	$static_code='PAGE_AFFILIATES';
	$static=get_staticdetails($static_code);
?> 
		<!--header ends-->
		<!--content starts-->
		<link href="styles/style.css" rel="stylesheet" type="text/css" />
		
		<div id="content">
		
		<div class="affliate_man_banner"><img src="images/caricature.png" border="0" alt="Caricaturetoons affiliate program" title="Caricaturetoons affiliate program"/></div>
			<div class="height80"></div>
			<div > 
				<div class="affliate_top_left_position"><img src="images/contact_top_left_curve.gif" /></div>
				<div class="buy_now_middlestrip affliate_middle_strip"></div>
				<div class="float_left"><img src="images/contact_top_right_curve.gif" /></div>
				<div class="clear_right">&nbsp;</div>
				<div class="affliate_content_middle_strip affliate_content_position">
				
			<div align="center" class="height_130"></div>	
			
			<div class="text_blue marginleft_10">
				<div><?php echo $static;?></div>
            <div align="center" style="padding-top:10px;"><a href="http://www.shareasale.com/shareasale.cfm?merchantID=27079" target="_blank"><img border="0" src="images/signme.gif" alt="sign up now" title="Sign up now" /></a></div>
			</div>		
			</div>
				<div class="affliate_top_left_position"><img src="images/contact_btm_left_curve.gif" /></div>
				<div class="contact_middle_strip_btm affliate_curve_middlestrip_position"></div>
				<div class="float_left"><img src="images/contact_btm_right_curve.gif" /></div>
				<div class="contact_btm">&nbsp;</div>
		</div>
		<div class="affliate_road_img_position"><img alt="affliate road"  src="images/road.gif" border="0" /></div>
		
		</div>
		<!--content ends-->	
		<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>