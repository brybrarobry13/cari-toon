<? 
	include("includes/configuration.php");
	include (DIR_INCLUDES.'header.php');
	$opro_id = $_REQUEST['opro_id'];
	if($opro_id != "")
	{
		$opro_table = mysql_query("SELECT * FROM `toon_order_products` where `opro_id`='$opro_id'");
		$opro_details = mysql_fetch_array($opro_table);
		$opro_caricature	=	$opro_details['opro_caricature'];
	} 
?> 

		<!--header ends-->
		<!--content starts-->
		<link href="styles/style.css" rel="stylesheet" type="text/css" />
		
		<div id="content">
			<div class="height80"></div>
			<div align="center" style="width:62%;margin-left:200px;">
				<div align="left" style="text-align:left;" class="header_text">Thanks for trusting us with your Caricature Toon. You can now download the high-resolution caricature toon image, order a gift to display your Caricatures. Hopefully you like it so much you'll tell your friends about us. </div>
			</div>
			<div style="height:20px;"></div>
			<div>
				<div class="buy_now_curvepadding" style="padding-left:150px;"><img src="images/white_curve_top_left.gif" /></div>
				<div class="buy_now_white_curve_top_middle_strip profile_sttings_whiteCurve_middle_strip"></div>
				<div class="clear_right"><img src="images/white_curve_top_right.gif" /></div>							
				<div class="price_white_curve_middle_border" style="margin-left:170px;margin-right:184px;">
					<div style="float:left">
						<div style="float:left;margin-left:10px"><img src="images/finish_line.gif" border="0" alt="Finish Line" title="Finish Line"/></div>
					</div>
                    <div style="clear:both">&nbsp;</div>
                    <div style="float:left;margin-left:75px">
						<div style="float:left"><img src="<?='includes/imageProcess.php?image='.$opro_caricature.'&type=caricature&size=200';?>" border="0"/></div>
					</div>
					<div style="float:left;margin-left:50px;margin-top:10px">
							<div style="float:left;clear:both"><a href="download_finish.php?opro_id=<?=$opro_id?>"><img src="images/download.gif" border="0" alt="Download Toon" title="Download Toon" /></a></div>
							<div style="float:left;clear:both;margin-top:15px"><a href="buy-caricature-gift.php"><img src="images/buy_gifts.gif" border="0" alt="Order Products" title="Order Products"  /></a></div>
                            <div style="float:left;clear:both;margin-top:15px"><a href="order-caricature.php"><img src="images/order_new_toon.gif" border="0" alt="Order New Toons" title="Order New Toons" /></a></div>
					</div>
					<div style="clear:both">&nbsp;</div>
				</div>
				
				<div>
					<div class="buy_now_curvepadding" style="padding-left:150px;"><img src="images/contact_btm_left_curve.gif" /></div>
					<div class="white_btm_middle_strip profile_sttings_whiteCurve_middle_strip"></div>
					<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif" /></div>
				</div>
			</div>
			<div style="height:90px">&nbsp;</div>
		</div>
		
		<!--content ends-->	
		<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>