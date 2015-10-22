<? 
include("includes/configuration.php");
//require_once('mcapi/inc/MCAPI.class.php');
	
//Caricature MailChimp Key
$apikey = 'd7229a6dbbe5df2b5bb2f6430fdbefd4-us2';
	
if(isset($_POST['news_email_x']))
{
	$email_news=$_POST['email_news'];
	$fname_news=$_POST['fname_news'];
	$lname_news=$_POST['lname_news'];
	mysql_query ("INSERT INTO `toon_newsletter` (`nltr_email`, `nltr_fname`, `nltr_lname`) VALUES ('$email_news', '$fname_news', '$lname_news')");
	
	$api = new MCAPI($apikey);
	$mergeVars = array('FNAME'=>$fname_news,'LNAME'=>$lname_news);

	#List Id of Newsletters
	//$listID = '97aad3ac02';
	
	#List Id of Caricature Toons
	$listID = 'dbde0db1cb';
	
	if($api->listSubscribe($listID, $email_news, $mergeVars) === true) 
	{
		// It worked!	
		$msg='* Please check your email to confirm registration';
		$newsprocess = "success";
	}
	else
	{
		// An error ocurred, return error message	
		$msg='Error: ' . $api->errorMessage;
	}
}

if(isset($_POST['tellfriend_x']))
{
	$fromname=$_POST['fromname'];
	$from=$_POST['fromemail'];
	$toname=$_POST['toname'];
	$to=$_POST['toemail'];
	$subject='Your Friend Wants You To Know About Us';
	$message ='Hi '.$toname.'<br><br>

	Your friend '.$fromname.' at '.$from.' thought you might be interested in the Caricature Toons website and has asked up to send you this email.<br><br>
	
	We create fun looking Caricature Toons and cater to the Caricature community. Ordering is easy. All we need is a picture.<br><br>
	
	We’re so confident you’ll like your Toon that we provide a100% money back guarantee if your not completely satisfied. We also have some great products you can display your Toon on or present as a gift.<br><br>
	
	To learn more please check us out at www.toonsforu.com<br><br>
	
	If at anytime you have questions or require assistance, please email us at '.$_CONFIG['email_contact_us'].'<br><br>
	
	Life should always be fun!!!<br><br>
	
	The Captoon<br>
	www.toonsforu.com

	';
	$header = "From: ".$from."\n";
	$header .= "MIME-Verson: 1.1\n";
	$header .= "Content-type:text/html; charset=iso-8859-1\n";
	mail($to,$subject,$message,$header);
	$msg='* Your invitation sent successfully';
	
	$api = new MCAPI($apikey);
	
	#List Id of Tell a friend
	//$listID = '2750d5d763';
	
	#List Id of Caricature Toons
	$listID = 'dbde0db1cb';
	
	//Add FROM details
	$mergeVars = array('FNAME'=>$fromname);
	if($api->listSubscribe($listID, $from, $mergeVars) === true) {
		// It worked!
	}else{
		// An error ocurred, return error message	
		$msg.='<br><br>Error: ' . $api->errorMessage;
	}
	
	//Add TO details
	$mergeVars = array('FNAME'=>$toname);
	if($api->listSubscribe($listID, $to, $mergeVars) === true) {
		// It worked!
		$tellafrnd = "success";
	}else{
		// An error ocurred, return error message	
		$msg.='<br><br>Error: ' . $api->errorMessage;
	}
}

$title_text = "Coupons and Promotional Codes for caricatures:";
include (DIR_INCLUDES.'header.php');

$rs_spo=mysql_query("SELECT * FROM `toon_special_offers` WHERE (current_date() <= `spo_startdate` OR current_date() BETWEEN `spo_startdate` AND `spo_enddate`) AND `spo_product`='Toon product'");
$rs_ez_spo=mysql_query("SELECT * FROM `toon_special_offers` WHERE (current_date() <= `spo_startdate` OR current_date() BETWEEN `spo_startdate` AND `spo_enddate`) AND `spo_product`='ez product'");
$no1=mysql_num_rows($rs_spo);
$no2=mysql_num_rows($rs_ez_spo);
?> 
<script>
function tellfriend()
{
    if(document.getElementById('fromname').value=='')
			{
				document.getElementById('fromname_error').style.display='block';
				return false;
			}
		else
			{
				document.getElementById('fromname_error').style.display='none';
			}
if(document.getElementById('fromemail').value=='')
			{
				document.getElementById('fromemail_error').style.display='block';
				return false;
			}
		else
			{
				document.getElementById('fromemail_error').style.display='none';
			}
if(document.getElementById('toname').value=='')
			{
				document.getElementById('toname_error').style.display='block';
				return false;
			}
		else
			{
				document.getElementById('toname_error').style.display='none';
			}
if(document.getElementById('toemail').value=='')
			{
				document.getElementById('toemail_error').style.display='block';
				return false;
			}
		else
			{
				document.getElementById('toemail_error').style.display='none';
			}
}
function validateemail()
{
if(document.getElementById('fname_news').value=='')
			{
				document.getElementById('fname_error').style.display='block';
				return false;
			}
		else
			{
				document.getElementById('fname_error').style.display='none';
			}
if(document.getElementById('lname_news').value=='')
			{
				document.getElementById('lname_error').style.display='block';
				return false;
			}
		else
			{
				document.getElementById('lname_error').style.display='none';
			}
if(document.getElementById('email_news').value=='')
			{
				document.getElementById('email_error').style.display='block';
				return false;
			}
		else
			{
				document.getElementById('email_error').style.display='none';
			}

}
function checkemail(myForm)
	{
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.email_news.value))
		{
			return true;
		}
			document.getElementById("valid_email_error").style.display="block";
			return false;
	}
function checkemail1(myForm)
	{
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.fromemail.value))
		{
			document.getElementById("valid_email_error_from").style.display="none";
		}
		else
		{
			document.getElementById("valid_email_error_from").style.display="block";
			return false;
		}
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.toemail.value))
		{
			document.getElementById("valid_email_error_to").style.display="none";
		}
		else
		{
			document.getElementById("valid_email_error_to").style.display="block";
			return false;
		}
		return true;
	}
</script>
<link href="styles/style.css" rel="stylesheet" type="text/css" />

	<div id="content">
		<div style="height:5px;"></div>
        <div style="clear:both;padding-top:10px">
        <div style="float:left">
            <div style="float:left; padding-left:30px"><img src="images/white_curve_top_left.gif" /></div>
            <div class="buy_now_white_curve_top_middle_strip" style="height:28px; width:870px;float:left">&nbsp;</div>
            <div style="float:left"><img src="images/white_curve_top_right.gif" /></div>
        </div>
        <div style="clear:both;">
            <div style="width:910px;float:left;margin-left:30px;" class="price_white_curve_middle_border">
			<div style="clear:both;padding-left:320px;padding-top:20px;padding-bottom:0px"><img src="images/winfree.png" alt="win free" title="win free" width="300" height="32" /></div>
            <div style="clear:both;padding-left:350px;padding-top:20px;padding-bottom:20px"><img src="images/specialoffers.gif" alt="special ofers" title="Special offers" /></div>
            <div align="center" style="padding-bottom:20px" class="div_text_green"><?=$msg?>
				<? if($newsprocess=="success") { ?>
                    <!-- Google Code for Newsletter Sign-Up Conversion Page -->
                    <script type="text/javascript">
                    /* <![CDATA[ */
                    var google_conversion_id = 956900108;
                    var google_conversion_language = "en";
                    var google_conversion_format = "3";
                    var google_conversion_color = "ffffff";
                    var google_conversion_label = "CH3HCNzhlgMQjMakyAM";
                    var google_conversion_value = 0;
                    /* ]]> */
                    </script>
                    <script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
                    </script>
                    <noscript>
                    <div style="display:inline;">
                    <img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/956900108/?label=CH3HCNzhlgMQjMakyAM&amp;guid=ON&amp;script=0"/>
                    </div>
                    </noscript>
                <? } ?>
                <? if($tellafrnd=="success") { ?>
                    <!-- Google Code for Tell a Friend Conversion Page -->
                    <script type="text/javascript">
                    /* <![CDATA[ */
                    var google_conversion_id = 956900108;
                    var google_conversion_language = "en";
                    var google_conversion_format = "3";
                    var google_conversion_color = "ffffff";
                    var google_conversion_label = "paG8CNTilgMQjMakyAM";
                    var google_conversion_value = 0;
                    /* ]]> */
                    </script>
                    <script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
                    </script>
                    <noscript>
                    <div style="display:inline;">
                    <img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/956900108/?label=paG8CNTilgMQjMakyAM&amp;guid=ON&amp;script=0"/>
                    </div>
                    </noscript>
                <? } ?>
            </div>
                <div>
                    <div style="float:left;;margin-left:50px;">
                        <div>
                            <div style="float:left;"><img src="images/curve_blueborderlefttop.gif"  /></div>
                            <div class="blue_box_middle_top_strip" style="width:312px;float:left; height:19px;"></div>
                            <div style="float:left"><img src="images/curve_blueborderrighttop.gif" /></div>
                        </div>	
                        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="return checkemail(this)" style="margin:0px;">
                  <div  class="blue_box_middle_content_strip" style="clear:both;width:350px;height:200px">
                        <div style="padding-left:4px;"><img src="images/posted.gif" alt="keep me posted" title="Keep me posted" /></div>
                        <div class="text_blue" style="padding-left:10px;">Email me any special Caricature Toons Offers or new drawing styles. You can unsubscribe at any time.</div>
                        <div style="clear:both;">
                        <div class="div_text" style="display:none;margin-top:10px;clear:both;margin-left:10px;" id="fname_error">*Please enter first name</div>
                        <div class="div_text" style="display:none;margin-top:10px;clear:both;margin-left:10px;" id="lname_error">*Please enter last name</div>
                        <div class="div_text" style="display:none;margin-top:10px;clear:both;margin-left:10px;" id="email_error">*Please enter email</div>
                        <div class="div_text" style="display:none;margin-top:10px;clear:both;margin-left:10px;" id="valid_email_error">*Please enter  valid email</div>
                            <div style="clear:both">
                            <div class="text_blue" style="float:left;margin-left:10px;clear:both;margin-top:6px;">Enter Your First Name</div>
                            <div style="float:left;margin-top:6px;padding-left:10px"><input type="text" name="fname_news" id="fname_news"  style="width:120px;" /></div>
                            </div>
                            <div style="clear:both">
                            <div class="text_blue" style="float:left;margin-left:10px;clear:both;margin-top:6px;">Enter Your Last Name</div>
                            <div style="float:left;margin-top:6px;padding-left:10px"><input type="text" name="lname_news" id="lname_news"  style="width:120px;" /></div>
                            </div>
                            <div style="clear:both">
                            <div class="text_blue" style="float:left;margin-left:115px;clear:both;margin-top:6px;">Email</div>
                            <div style="float:left;margin-top:6px;padding-left:10px"><input type="text" name="email_news" id="email_news"  style="width:120px;" /></div>
                            </div>
                            <div style="clear:both;padding-left:110px;padding-top:6px"><input type="image" name="news_email" onclick="return validateemail()" src="images/submit.gif" border="0" alt="submit" title="Submit" /></div>
                        </div>
                        
                  </div>
                        </form>
                      <div>
                            <div style="float:left;"><img src="images/curve_blueborderleftbt.gif"  /></div>
                            <div class="blue_box_btm_middle_strip_sp" style="width:312px;float:left; height:19px;"></div>
                            <div style="float:left"><img src="images/curve_blueborderrightbt.gif"/></div>
                    </div>
                    </div>
                    <div style="float:left">&nbsp;</div>
                    <div style="margin-left:500px">
                        <div>
                            <div style="float:left"><img src="images/curve_blueborderlefttop.gif"/></div>
                            <div class="blue_box_middle_top_strip" style="width:310px; height:19px;float:left"></div>
                            <div><img src="images/curve_blueborderrighttop.gif" /></div>
                    </div>
                        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="return checkemail1(this)"  style="margin:0px;">
                    <div class="blue_box_middle_content_strip" style="width:348px;height:200px">
                        <div><img src="images/tell_a_friend.gif" alt="tell a friend" title="Tell a friend"/></div>
                        <div class="div_text" style="display:none;clear:right;margin-left:10px;padding-top:10px" id="valid_email_error_from">*Please enter your valid email</div>
                        <div class="div_text" style="display:none;clear:right;margin-left:10px;padding-top:10px" id="valid_email_error_to">*Please enter your friend's valid email</div>
                        <div class="div_text" style="display:none;clear:right;margin-left:10px;padding-top:10px" id="fromname_error">*Please enter your name</div>
                        <div class="div_text" style="display:none;clear:right;margin-left:10px;padding-top:10px" id="fromemail_error">*Please enter your email</div>
                        <div class="div_text" style="display:none;clear:right;margin-left:10px;padding-top:10px" id="toname_error">*Please enter your friend's name</div>
                        <div class="div_text" style="display:none;clear:right;margin-left:10px;padding-top:10px" id="toemail_error">*Please enter your friend's email</div>
                        <div style="margin-top:5px">
                            <div class="text_blue" style="float:left;margin-left:10px;">Enter your name</div>
                            <div style="margin-left:140px" ><input type="text" name="fromname" id="fromname"  /></div>
                        </div>	
                        <div style="margin-top:5px">
                            <div class="text_blue" style="float:left; margin-left:10px">Your Email</div>
                            <div style="margin-left:140px"><input type="text" name="fromemail" id="fromemail"  /></div>
                        </div>
                        <div style="margin-top:5px">
                            <div class="text_blue" style="float:left; margin-left:10px">Friends Name</div>
                            <div style="margin-left:140px"><input type="text" name="toname" id="toname"  /></div>
                        </div>
                        <div style="margin-top:5px">
                            <div class="text_blue" style="float:left; margin-left:10px">Friends Email</div>
                            <div style="margin-left:140px"><input type="text" name="toemail" id="toemail"  /></div>
                        </div>
                        
                        <div style="text-align:center; margin-top:5px"><input type="image" onclick="return tellfriend()" name="tellfriend" src="images/submit.gif" border="0" alt="submit" title="Submit"/></div>
                        
                        
                    
                    </div>
                        </form>
                    <div>
                        <div style="float:left"><img src="images/curve_blueborderleftbt.gif"/></div>
                        <div class="blue_box_btm_middle_strip_sp" style="width:310px; height:19px; float:left"></div>
                        <div><img src="images/curve_blueborderrightbt.gif"/></div>
                    </div>
                    
                </div>
				<div style="width:450px;padding-left:55px;padding-top:5px;" class="header_text">* Once a month we choose  a winnetr from people who are our mailing list</br> and announce the winner in one of our monthly email blasts. </div>
				<div style="height:30px;"></div>
				<div align="left" style="width:60%;margin-left:180px;">
					<div align="left" style="text-align:left;" class="header_text">Check out our coupons, deals and special caricatures offers as well as other great deals below.</div>
				</div>			
                </div>
				
				<? if($no1!=0 or $no2!=0) {?>
				<div id="spl">
                <div class="text_blue" style="margin-top:30px; margin-left:100px; vertical-align:bottom" ><img src="images/specialoffers_small.gif" alt="current deals" title="Current Deals" /></div>
                <div style="margin-top:10px;padding-left:55px;" >
                    <div style="float:left;width:795px;margin-left:5px; margin-bottom:15px;">
                        <div>
                            <div style="float:left;"><img src="images/merchandise_top_left.gif"  /></div>
                            <div class="blue_box_middle_top_strip1" style="width:750px;float:left; height:19px;"></div>
                            <div style="float:left"><img src="images/merchandise_top_right.gif" /></div>
                        </div>	
                  <div  align="center" style="clear:both;width:788px;min-height:80px;padding-top:20px;border-left:solid 2px #0a4fa4;border-right:solid 2px #0a4fa4;">
                    <div style="clear:both;margin-left:20px;color:#044BA2;font-family:Arial, Helvetica, sans-serif;font-size:16px; font-weight:bold;margin-right:20px;margin-bottom:7px; text-align:left;">Toon Products</div>
                    <?
                    $number=mysql_num_rows($rs_spo);
                    if ($number!=0)
                    {
                       while($row_spo=mysql_fetch_assoc($rs_spo))
                       {
                       ?>
                            <div style="clear:both;margin-left:40px;color:#ff6e01;font-family:Arial, Helvetica, sans-serif;font-size:12px;margin-right:20px; text-align:left;"><?=$row_spo['spo_title']?> : <?=$row_spo['spo_description']?></div>
                              
                        <?
                       }
                    }
                    else
                    {
                    ?>
                        <div style="clear:both;margin-left:40px;color:#FF0000;font-family:Arial, Helvetica, sans-serif;font-size:12px;margin-right:20px; text-align:left;"><!--No Special Offers!--></div>         
                    
                    <? } ?>
                    <div style="clear:both;margin-left:20px;color:#044BA2;font-family:Arial, Helvetica, sans-serif;font-size:16px; font-weight:bold;margin-right:20px;margin-bottom:7px;margin-top:20px; text-align:left;">EZ Products</div>
                    <? 
                    $number=mysql_num_rows($rs_ez_spo);
                    if ($number!=0)
                    {
                       while($row_ez_spo=mysql_fetch_assoc($rs_ez_spo))
                       {
                       ?>
                        	<div style="clear:both;margin-left:40px;color:#ff6e01;font-family:Arial, Helvetica, sans-serif;font-size:12px;margin-right:20px; text-align:left;"><?=$row_ez_spo['spo_title']?> : <?=$row_ez_spo['spo_description']?></div>
                       <?
                       }
                    }
                    else
                    {
                    ?>
                    	<div style="clear:both;margin-left:40px;color:#FF0000;font-family:Arial, Helvetica, sans-serif;font-size:12px;margin-right:20px; text-align:left;"><!--No Special Offers!--></div>
                     
                     <? } ?>
                            <div style="clear:both;margin-left:20px;color:#044BA2;font-family:Arial, Helvetica, sans-serif;font-size:12px;margin-right:20px;margin-top:25px; text-align:left;">Note:- Any of our special offers do not require you to place a coupon code. We automatically calculate the discount at checkout</div>
                  </div>
                      <div>
                            <div style="float:left;"><img src="images/curve_blueborderleftbt.gif"  /></div>
                            <div style="width:750px;float:left; height:17px;border-bottom:solid 2px #0a4fa4;"></div>
                            <div style="float:left"><img src="images/curve_blueborderrightbt.gif"/></div>
                    </div>
             </div>
             </div>            
			 </div>  <? }?>         
                <div class="text_blue" style="padding-top:30px;margin-left:100px"><img src="images/currentdeal.gif" alt="current deals" title="Current Deals" /> 
				   <span class="header_text" >Check out some great deals from some great websites</span> </div>
                
				<div style="margin-top:10px;padding-left:55px;" >
                    <div style="float:left;width:795px;margin-left:5px">
                        <div>
                            <div style="float:left;"><img src="images/merchandise_top_left.gif"  /></div>
                            <div class="blue_box_middle_top_strip1" style="width:750px;float:left; height:19px;"></div>
                            <div style="float:left"><img src="images/merchandise_top_right.gif" /></div>
                        </div>	
                  <div  align="center" style="clear:both;width:788px;min-height:80px;padding-top:20px;border-left:solid 2px #0a4fa4;border-right:solid 2px #0a4fa4;">
                  <?  $sql_coup_link="SELECT * FROM `toon_cool_coupon` WHERE `cc_flag`='1' ORDER BY `ref_priority` ASC";
				    $rs_coup_link=mysql_query($sql_coup_link);		
					$number=mysql_num_rows($rs_coup_link);
					if ($number!=0)
					{
				  ?>
                  <table width="90%" cellpadding="0" cellspacing="0" class="special_ofrs_txt" border="0" align="center">

                  <?  $sql_coupon_catid="SELECT `cc_category` FROM `toon_cool_coupon` WHERE `cc_flag`='1' GROUP BY `cc_category` ORDER BY `ref_priority` ASC";
					  $rs_coupon_catid=mysql_query($sql_coupon_catid);
					  while($row_coupon_catid=mysql_fetch_assoc($rs_coupon_catid))
	   		 		  {
					  $sql_coupon_link="SELECT * FROM `toon_cool_coupon` WHERE `cc_flag`='1' AND `cc_category`=".$row_coupon_catid['cc_category']." ORDER BY `ref_priority` ASC";
					  $rs_coupon_link=mysql_query($sql_coupon_link);
                      $rs_coupon_cat=mysql_query("SELECT * FROM `toon_coupon_category` WHERE `cu_id`=".$row_coupon_catid['cc_category']." ORDER BY `cu_priority` ASC");
					  $row_coupon_cat=mysql_fetch_assoc($rs_coupon_cat); ?>
					  <tr>
                       	 <td align="left" colspan="2" style="font-size:16px; color:#044BA2;"><img src="images/star_red.gif" /><b><?=$row_coupon_cat['cu_category_name']?></b></td>
                      </tr>
                      <tr><td height="10" colspan="2"></td></tr>
					  <? while($row_coupon_link=mysql_fetch_assoc($rs_coupon_link)) { ?>
                        <tr>
                            <td align="center" width="17%"><? if($row_coupon_link['cc_photo']!="") { ?><img src="<?='includes/imageProcess.php?image='.$row_coupon_link['cc_photo'].'&type=coupon&size=100';?>" border="0" height="40"/><? } ?></td>
                            <td align="left"  width="83%">&nbsp;<b><?=stripslashes($row_coupon_link['cc_link_name']);?></b><br/><?=$row_coupon_link['cc_desc'];?> - <a href="http://<?=str_replace("http://","",$row_coupon_link['cc_link']);?>" target="_blank" style="color:#FF3333">View coupons</a></td>
                        </tr>
						<tr><td height="5"></td></tr>
                  <?   } }
                  ?>
                 </table>
                 <?
					} else {
				 ?>
       	    	     <table align="center">
          		     <tr>
          				  <td style="color:#FF0000">No Coupons!</td>
            		 </tr>
        			 </table>
           		 <? } ?>
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


<? include (DIR_INCLUDES.'footer.php') ?>
