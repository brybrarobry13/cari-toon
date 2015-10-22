<? 
	include("includes/configuration.php");
	$title_text = "Caricature links:t-shirts, Gifts, poster arts:";
	include (DIR_INCLUDES.'header.php');
	include_once(DIR_FUNCTIONS."static.php");
	$static_code='PAGE_COOL_LINKS';
	$static=get_staticdetails($static_code); 
//	$sql_cool_category = "SELECT * FROM toon_cool_categories";
	$sql_cool_category = "SELECT toon_cool_categories.*, toon_cool_coupon.*,if(toon_cool_coupon.cct_id!=0,cct_category_name,'zzzzzzzzzzcategory') as catname
	FROM toon_cool_coupon
	LEFT JOIN toon_cool_categories
	ON toon_cool_categories.cct_id = toon_cool_coupon.cct_id
	WHERE cc_flag='O' 
	ORDER BY cc_priority ASC";
	$rs_cool_category=mysql_query($sql_cool_category);
	$number_cool_category=mysql_num_rows($rs_cool_category);
  
?>

<link href="styles/style.css" rel="stylesheet" type="text/css" />
		<!--header ends-->
		<!--content starts-->
		<div id="content">
		<div style="height:5px;"></div>
		<div align="center" style="width:90%;margin-left:53px;">
				<div align="left" style="text-align:left;" class="header_text">Below are some great links to triathlon and non-triathlon related products and services. Some are printing related services that you may want to use to display your Caricature Toons or images. <a href="order-caricature.php" >Click here to order caricatures.</a> </div>
		</div>
				<div style="clear:both;padding-top:10px">
				<div style="float:left">
					<div style="float:left; padding-left:30px"><img src="images/white_curve_top_left.gif" /></div>
					<div class="buy_now_white_curve_top_middle_strip" style="height:28px; width:870px;float:left">&nbsp;</div>
					<div style="float:left"><img src="images/white_curve_top_right.gif" /></div>
				</div>
				<div style="clear:both;">
                    <div class="price_white_curve_middle_border" style="width:780px;float:left;margin-left:30px;padding-left:130px"><img src="images/cool.gif" alt="cool links and coupons" title="Cool links and coupons" style="padding-left:90px" /></div>
					<div style="width:910px;float:left;margin-left:30px;" class="price_white_curve_middle_border">
						<div style="margin-top:20px;padding-left:55px;" >
							<div style="float:left;width:795px;margin-left:5px">
								<div>
									<div style="float:left;"><img src="images/merchandise_top_left.gif"  /></div>
									<div class="blue_box_middle_top_strip1" style="width:750px;float:left; height:19px;"></div>
									<div style="float:left"><img src="images/merchandise_top_right.gif" /></div>
								</div>	
						  <div  align="center" style="clear:both;width:788px;min-height:80px;padding-top:20px;border-left:solid 2px #0a4fa4;border-right:solid 2px #0a4fa4;">
						  
                          <table width="95%" cellpadding="2" cellspacing="2" class="special_ofrs_txt" style="padding-left:20px;padding-bottom:10px" border="0">
                          
                          <?
						  $pre_cat="";
							   if($number_cool_category!=0)
							   {
                          	   	while($row_cool_category=mysql_fetch_assoc($rs_cool_category))
	   						   	{
								
								if($row_cool_category['cct_category_name'])
								{
							
								$category_name=$row_cool_category['cct_category_name'];
								if($row_cool_category['cct_id']=="0")
								{
									//echo "dfdsf";
									$category_name="No category";
								}
								
								if ($category_name != $pre_cat) {
								?>
                                	<tr><td style=" color:#006;" colspan="2"><img src="images/star_red.gif" /><b style="color:#044BA2;"><?=$category_name;?></b></td></tr>
								<?
                                }
	   					  		?>
                              <tr>
							  
                                    <td align="center" style="color:#044BA2; font-style:Elephant" width="15%"><? if($row_cool_category['cc_photo']){?>
										<div  align="center" style="vertical-align:top;"><img src="<?='includes/imageProcess.php?image='.$row_cool_category['cc_photo'].'&type=coollink&size=100';?>" border="0" height="40" /></div><? }?>
                                    </td>
                               
                                <?	}?>
                               
                                    <td valign="top" width="85%">
                                      <table width="95%" cellpadding="0" cellspacing="0" class="special_ofrs_txt">
                                      <?
											$cc_link = $row_cool_category['cc_link'];
											
											//$cc_link = str_replace("http://","",$row_cool_link['cc_link']);
											//$cc_link = str_replace("https://","",$cc_link);
                                            ?>
                                            <tr>
                                                <td align="left"  width="40%" >
                                                	<table width="100%" cellpadding="0" cellspacing="0">
														<tr>
															<td >
															<!--img src="images/star_red.gif" align="left" /--> 
															<a href="<?=$cc_link?>" target="_blank" style="color:#FF0000">
																<?=stripslashes($row_cool_category['cc_link_name']);?>
															</a>
															</td>
														 </tr>
														 <tr>
															<td ><?=$row_cool_category['cc_desc'];?></td>
														</tr>
													</table>
                                                </td>
                                             </tr>
                                      </table>
                                    </td>
                                </tr>
                               
                                <?
								$pre_cat=$row_cool_category['cct_category_name'];
                                }//end of while($row_cool_category..
								}
								else
								{
								?>
								<tr>
									<td style="color:#FF0000" align="center">No Cool Links !</td>
								</tr>
								<? }
	   					  		?>
                          </table>
                        
             
						  </div>
							  <div>
									<div style="float:left;"><img src="images/curve_blueborderleftbt.gif"  /></div>
									<div style="width:750px;float:left; height:17px;border-bottom:solid 2px #0a4fa4;"></div>
									<div style="float:left"><img src="images/curve_blueborderrightbt.gif"/></div>
							</div>
					 </div>
					 </div>
		</div>
		
		
		
		<div style="float:left">
					<div style="float:left; padding-left:30px"><img src="images/special_btm_left_curve.gif" /></div>
					<div class="white_btm_middle_strip" style="height:28px; width:870px;float:left">&nbsp;</div>
					<div style="float:left"><img src="images/contact_btm_right_curve.gif" /></div>
				</div>
	
		</div>
		<div style="height:10px; clear:both;"></div>
	</div>
		
	</div>
		<!--content ends-->	
		<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>