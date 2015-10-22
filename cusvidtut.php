<? 
	include("includes/configuration.php");
	include(DIR_FUNCTIONS.'options.php');
	/*include_once(DIR_FUNCTIONS."static.php");
	$static_code='PAGE_HELP';
	$help = get_staticdetails($static_code);*/
	
	$user_id		  	  = $_SESSION['sess_tt_uid'];//Fetching the userid
	$getuserDetails 	  = getUserDetails($user_id);//Fetching the user details according to the userid
	if($getuserDetails['utype_id']==2)
	{
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
		<!--header ends-->
		<!--content starts-->
		<link href="styles/style.css" rel="stylesheet" type="text/css" />
		
		<div id="content">
			<div class="height80"></div>
			<div align="center" style="width:74%;margin-left:120px;">
				<div align="left" style="clear:left;text-align:left;" class="header_text">Check out our video tutorials on how to order your Caricature Toons. We love creating caricatures and if you have any questions, especially if your not sure about images, please do not hesitate to email us at <a href="mailto:<?=$_CONFIG['email_contact_us']?>"><?=$_CONFIG['email_contact_us']?></a>.</div>
			</div>
			<div style="height:20px;"></div>
			<? if($getuserDetails['utype_id']==2)
			{ ?>
			<div>
				<div class="gallery_curvepadding"><img src="images/white_curve_top_left.gif" /></div>
				<div class="buy_now_white_curve_top_middle_strip gallery_whiteCurve_middle_strip"></div>
				<div class="clear_right"><img src="images/white_curve_top_right.gif" /></div>	
				
					<div class="price_white_curve_middle_border" style="margin-left:110px;margin-right:124px;width:740px">
					<div style="float:left;margin-left:200px" class="div_text"><?=$size_error?></div>
					<div style="float:left;margin-left:200px" class="div_text"><?=$type_error?></div>

					<div>
						<div style="height:60px;clear:left;text-align:center;"><img src="show_text/<? echo base64_encode("How to Process Your Orders");?>/15/" border="0" alt="how to Process Your Orders" title="How to Process Your Orders"  /></div>
						<div style="height:344px;clear:left;text-align:center;">
						<object style="height: 344px; width: 425px"><param name="movie" value="http://www.youtube.com/v/H-SRmOgIKdQ"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><embed src="http://www.youtube.com/v/H-SRmOgIKdQ" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="425" height="344"></object>
						</div>
					</div>
					</div>
				
			<div>
				<div class="gallery_curvepadding"><img src="images/contact_btm_left_curve.gif"/></div>
				<div class="white_btm_middle_strip gallery_whiteCurve_middle_strip"></div>
				<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif"/></div>
			</div>
			<div style="clear:both; height:5px;">&nbsp;</div>
			</div>
			<div>&nbsp;</div>
			<div>
				<div class="gallery_curvepadding"><img src="images/white_curve_top_left.gif" /></div>
				<div class="buy_now_white_curve_top_middle_strip gallery_whiteCurve_middle_strip"></div>
				<div class="clear_right"><img src="images/white_curve_top_right.gif" /></div>	
				
					<div class="price_white_curve_middle_border" style="margin-left:110px;margin-right:124px;width:740px">
					<div style="float:left;margin-left:200px" class="div_text"><?=$size_error?></div>
					<div style="float:left;margin-left:200px" class="div_text"><?=$type_error?></div>

					<div>
						<div style="height:60px;clear:left;text-align:center;"><img src="show_text/<? echo base64_encode("How to Set up Your Gallery");?>/15/" border="0" alt="how to Set up Your Gallery" title="How to Set up Your Gallery"  /></div>
						<div style="height:344px;clear:left;text-align:center;">
						<object style="height: 344px; width: 425px"><param name="movie" value="http://www.youtube.com/v/ohlhky7_zuY"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><embed src="http://www.youtube.com/v/ohlhky7_zuY" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="425" height="344"></object>
					</div>
					</div>
					</div>
				
			<div>
				<div class="gallery_curvepadding"><img src="images/contact_btm_left_curve.gif"/></div>
				<div class="white_btm_middle_strip gallery_whiteCurve_middle_strip"></div>
				<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif"/></div>
			</div>
			<div style="clear:both; height:5px;">&nbsp;</div>
			</div>
			<div>&nbsp;</div>
			<? } else { ?>
			<div>
				<div class="gallery_curvepadding"><img src="images/white_curve_top_left.gif" /></div>
				<div class="buy_now_white_curve_top_middle_strip gallery_whiteCurve_middle_strip"></div>
				<div class="clear_right"><img src="images/white_curve_top_right.gif" /></div>	
				
					<div class="price_white_curve_middle_border" style="margin-left:110px;margin-right:124px;width:740px">
					<div style="float:left;margin-left:200px" class="div_text"><?=$size_error?></div>
					<div style="float:left;margin-left:200px" class="div_text"><?=$type_error?></div>

					<div>
						<div style="height:60px;clear:left;text-align:center;"><img src="show_text/<? echo base64_encode("How to Create Your Toon");?>/15/" border="0" alt="how to Create Your Toon" title="How to Create Your Toon" /></div>
						<div style="height:344px;clear:left;text-align:center;">
						<object style="height: 344px; width: 425px"><param name="movie" value="http://www.youtube.com/v/XAAiArRLsb4"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><embed src="http://www.youtube.com/v/XAAiArRLsb4" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="425" height="344"></object>
					</div>
					</div>
					</div>
				
			<div>
				<div class="gallery_curvepadding"><img src="images/contact_btm_left_curve.gif"/></div>
				<div class="white_btm_middle_strip gallery_whiteCurve_middle_strip"></div>
				<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif"/></div>
			</div>
			<div style="clear:both; height:5px;">&nbsp;</div>
			</div>
			<? } ?>
			<div>&nbsp;</div>
		</div>
		
		
		<!--content ends-->	
		<!--footer-->	
<? if($getuserDetails['utype_id']==2)
{
include (DIR_INCLUDES.'artist_footer.php');
}
else
{
include (DIR_INCLUDES.'footer.php') ;
} ?>