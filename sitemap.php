<?  include("includes/configuration.php");
	include(DIR_INCLUDES.'functions/orders.php');
	include (DIR_INCLUDES.'header.php'); 
	
	 $artistquery=  "SELECT U . *,PT.user_id,SUM(product_price) as totalprice,SUM(product_turnaroundtime) as totalturntime FROM `toon_users` U, `toon_user_types` UT ,`toon_products` PT WHERE U.`utype_id` = UT.`utype_id` AND U.`user_id` = PT.`user_id` AND U.`user_status` = 'Active' AND U.`user_delete` = '0' AND UT.`utype_name` = 'Artist' AND PT.`product_delete`=0 GROUP BY PT.user_id";
	$row_artists=mysql_query($artistquery);
	$toonsideas_query="SELECT * FROM `toons_ideas`";
	$row_toonsideas=mysql_query($toonsideas_query);
	 $ezproducts_query = "SELECT * FROM `toon_main_category` WHERE `mcat_display`='1' ORDER BY `mcat_priority` ASC";
	$row_ezproducts=mysql_query($ezproducts_query);
	
?>
<!--header ends-->
<!--content starts-->

<link href="styles/style.css" rel="stylesheet" type="text/css" />
<table cellpadding="0" cellspacing="0">
  <tr>
    <td width="70%"><table cellpadding="0" cellspacing="0" width="724" align="center">
        <tr>
          <td height="12" valign="bottom" align="left"><img src="images/top_left_curve.png" /></td>
          <td style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;">&nbsp;</td>
          <td><img src="images/top_right_curve.png" /></td>
        </tr>
        <tr>
          <td width="17" style="background:url(images/left_shadow.png) repeat-y right;width:17px;"><img src="images/blank.png" /></td>
          <td><form method="post" action="<?=$_SERVER['PHP_SELF']?>" >
              <div style="width:800px; margin:auto;background:#FFFFFF;">
                <div style="height:10px;"></div>
                <div style="background-color:#ff6e01;color:#FFFFFF;font-size:25px;font-family:Arial, Helvetica, sans-serif; padding-left:20px;"><b>Caricature Toons Site Map</b></div>
                <div style="height:10px;"></div>
                <div style="margin-left:20px;margin-right:30px;border:solid 1px #cecece;">
                 <div style="margin-left:20px;margin-top:20px;margin-right:30px;font-size:18px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>index.php" style="text-decoration:none;color: #044BA2 !important;"><b>Home</b></a></div>
				 <div style="margin-left:20px;margin-top:15px;margin-right:30px;font-size:18px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>index.php" style="text-decoration:none;color: #044BA2 !important;"><b>Styles & Prices</b></a></div>
				 <div style="margin-left:20px;margin-top:15px;margin-right:30px;font-size:18px;" class="text_blue" ><b>Artists Gallery</b></div>
				 <? while($artist_list_details=mysql_fetch_assoc($row_artists))
				 { ?>
				  <ul style="margin: 5px 0pt 5px 20px;">
                  	<li>
                    	<div style="margin-left:5px;margin-right:30px; font-size:16px !important;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>artist/<?=$artist_list_details['user_id'] ?>/art-gall.html" style="text-decoration:none;color: #06F !important;"><b><? echo $artist_list_details['user_fname'];?></b></a></div>
                    </li>
                  </ul>
				  <? } ?>
				 <div style="margin-left:20px;margin-top:20px;margin-right:30px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>caricatures/toons-ideas/" style="text-decoration:none;color: #044BA2 !important;font-size:18px;"><b>Toon Ideas</b></a></div>
				 <? while($toonsideas_list_details=mysql_fetch_assoc($row_toonsideas))
				 { ?>
				  <ul style="margin: 5px 0pt 5px 20px;">
                  	<li>
                    	<div style="margin-left:5px;margin-right:30px; font-size:16px !important;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>caricatures/toons-ideas/gallery/<?=$toonsideas_list_details['ti_ref_link']?>" style="text-decoration:none;color: #06F !important;"><b><? echo $toonsideas_list_details['ti_ref_name'];?></b></a></div>
                    </li>
                  </ul>
				  <? } ?>
				 <div style="margin-left:20px;margin-top:15px;margin-right:30px;font-size:18px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>alogin.php" style="text-decoration:none;color: #044BA2 !important;"><b>My Toons</b></a></div>
				 <div style="margin-left:20px;margin-top:15px;margin-right:30px;font-size:18px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>order-caricature.php" style="text-decoration:none;color: #044BA2 !important;"><b>Order Now</b></a></div>
				 <div style="margin-left:20px;margin-top:15px;margin-right:30px;font-size:18px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>buy-caricature-gift.php" style="text-decoration:none;color: #044BA2 !important;"><b>Gift Ideas</b></a></div>
				 <? while($ezproducts_list_details=mysql_fetch_assoc($row_ezproducts))
				 { ?>
				  <ul style="margin: 5px 0pt 5px 20px;">
                  	<li>
                    	<div style="margin-left:5px;margin-right:30px; font-size:16px !important;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>maincategory/<?=$ezproducts_list_details['mcat_id']?>/merchandise_learn.html" style="text-decoration:none;color: #06F !important;"><b><? echo $ezproducts_list_details['mcat_name'];?></b></a></div>
                    </li>
                  </ul>
				<? }?>
				 <div style="margin-left:20px;margin-top:15px;margin-right:30px;font-size:18px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>contact.php" style="text-decoration:none;color: #044BA2 !important;"><b>Contact</b></a></div>
				 <div style="margin-left:20px;margin-top:15px;margin-right:30px;font-size:18px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>join-our-team.php" style="text-decoration:none;color: #044BA2 !important;"><b>Join Our Team</b></a></div>
			
			 <div style="margin-left:20px;margin-top:15px;margin-right:30px;font-size:18px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>affiliates-program.php" style="text-decoration:none;color: #044BA2 !important;"><b>Affiliates</b></a></div>
			  <div style="margin-left:20px;margin-top:15px;margin-right:30px;font-size:18px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>faqs.php" style="text-decoration:none;color: #044BA2 !important;"><b>FAQ’s</b></a></div>
			   <div style="margin-left:20px;margin-top:15px;margin-right:30px;font-size:18px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>cool-links.php" style="text-decoration:none;color: #044BA2 !important;"><b>Cool Links</b></a></div>
			    <div style="margin-left:20px;margin-top:15px;margin-right:30px;font-size:18px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>/special-deals.php" style="text-decoration:none;color: #044BA2 !important;"><b>Coupons</b></a></div>	 
				<div style="margin-left:20px;margin-top:15px;margin-right:30px;font-size:18px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>privacy.php" style="text-decoration:none;color: #044BA2 !important;"><b>Privacy Policy</b></a></div>	 
				<div style="margin-left:20px;margin-top:15px;margin-right:30px;font-size:18px;" class="text_blue"><a href="<?=$_SERVER['HTTP_HOST']?>terms.php" style="text-decoration:none;color: #044BA2 !important;"><b>Terms and Conditions</b></a></div>	 
                  <div style="height:20px;"></div>
                  <div style="height:25px;"></div>
                </div>
                <div class="height20"></div>
              </div>
            </form></td>
          <td style="background:url(images/right_shadow.png) repeat-y left"><img src="images/blank.png" /></td>
        </tr>
        <tr>
          <td><img src="images/btm_left_curve.png" /></td>
          <td style="background:url(images/shadow_btm.png) repeat-x top;"><img src="images/blank.png" /></td>
          <td><img src="images/btm_right_curve.png" /></td>
        </tr>
      </table></td>
  </tr>
</table>
<!--content ends-->
<!--footer-->
<? include (DIR_INCLUDES.'footer.php') ?>
