<? 
	include("includes/configuration.php");
	require_once('mcapi/inc/MCAPI.class.php');
	include (DIR_INCLUDES.'functions/encryption.php');
	include (DIR_INCLUDES.'registration_process.php');
	include (DIR_INCLUDES.'login_process.php');
	include (DIR_INCLUDES.'header.php'); 
?> 
<script language="javascript" type="text/javascript" src="javascripts/reg_validation.js"></script>
<script language="javascript" type="text/javascript" src="javascripts/login_validation.js"></script>

		<!--header ends-->
		<!--content starts-->
		<link href="styles/style.css" rel="stylesheet" type="text/css" />
		
		<div id="content">
		<? if($_REQUEST['back_to']=='order-caricature.php'){?>
			<div class="clear_both">
				<div class="buynow_toon_img"></div>
				<span class="buynow_toon_img"><img src="images/buy_now_toon.gif" alt="lady toon" title="Lady toon" /></span>
				<div class="ordering_img"><img src="images/ordering.gif" border="0" alt="order caricaturetoon is easy" title="Ordering a caricature" /></div>
				<div class="text_blue" style="padding-left:50px;padding-right:250px;padding-top:25px;clear:left;">Theres nothing more fun than a Caricature Toon, whether it's for yourself or as a gift. Getting started is easy and once it's done, we can put your Caricature Toon on some pretty cool gifts.</div>
				<div class="buy_now_txt_btm_space"></div>
			</div>
			<? }else {?><div style="height:20px;"></div><? }?>
			<div style="clear:both;">
			<!--div class="header_text" style="padding:0 120px 20px 130px;">Thanks again for your Caricature Toons order. Our caricature artist aim to please and when your caricature cartoon is complete they will upload it to this section for your review. Communicating with your caricature artist is easy, just click on the talk to your Toonist link and an instant messaging system appears. If you see the envelope green that means your artist has left you a message. Once you&prime;re happy with your caricature cartoon just click the approved link and it will automatically download for you. Also, don&prime;t forget to check out our <a href="buy-caricature-gift.php">Buy Products</a> section, we have some great gift ideas to display your caricature on. 
</div-->
			<? if($_REQUEST['back_to']=='order-caricature.php'){?>
			<div style="float:left;">
					<div class="float_left">
						<div class="buy_now_curvepadding"><img src="images/contact_top_left_curve.gif" /></div>
						<div class="buy_now_middlestrip buy_now_miidlestrip_properties"></div>
						<div class="float_left"><img src="images/contact_top_right_curve.gif" /></div>
						<div class="buynow_space">&nbsp;</div>
						<div class="buy_now_content_middlestrip buy_now_content_middlestrip_prperty">
						<div class="hieght_35"></div>
						<div class="clear_both">
							<div class="buy_now_numbers"><img src="images/1.gif" alt="one" title="One" /></div>
							<div class="buy_now_left_txt buy_now_left_txt_properties">Register or Login</div>
						</div>
						<div class="clear_both buy_now_left_menu_nxt_line">
							<div class="buy_now_numbers"><img src="images/2.gif" alt="two" title="Two" /></div>
							<div class="buy_now_left_txt_properties buy_now_left_txt">Upload your photo(s)</div>
						</div>
						<div class="buy_now_left_menu_nxt_line clear_both">
							<div class="buy_now_numbers"><img src="images/3.gif" alt="three" title="Three" /></div>
							<div class="buy_now_left_txt buy_now_left_txt_properties">Choose an Artist Style</div>
						</div>
						<div class="clear_both buy_now_left_menu_nxt_line">
							<div class="buy_now_numbers"><img src="images/4.gif" alt="four" title="Four" /></div>
							<div class="buy_now_left_txt buy_now_left_txt_properties">Select number of people</div>
						</div>
						<div class="clear_both buy_now_left_menu_nxt_line">
							<div class="buy_now_numbers"><img src="images/5.gif" alt="five" title="Five" /></div>
							<div class="buy_now_left_txt buy_now_left_txt_properties">Order Gifts</div>
						</div>
						<div class="buy_now_left_txt buy_now_left_txt_properties">(Optional)</div>
					</div>
						<div class="buy_now_curvepadding"><img src="images/contact_btm_left_curve.gif" /></div>
						<div class="contact_middle_strip_btm buy_now_btm_strip_properties"></div>
						<div class="float_left"><img src="images/contact_btm_right_curve.gif" /></div>
					</div>
			</div><? }else {?><Div style="width:115px;float:left;">&nbsp;</Div><? }?>
			<div style="float:left">
				<div class="float_left">
						<div class="buy_now_top_left_curve_properties"><img src="images/contact_top_left_curve.gif" /></div>
						<div class="buy_now_middlestrip buy_now_content_strip_properties"><div style="padding:10px 0 0 200px;position:absolute;" ><img src="images/winfree.png" width="300" height="32" /></div></div>
						<div class="float_left"><img src="images/contact_top_right_curve.gif" /></div>
						<div class="buy_now_box_space">&nbsp;</div>
					  <div class="buy_now_content_middlestrip buy_now_box_content_prepperties">
						
						<form action="<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>" method="post" onsubmit="return checkemail(this)">
						<div class="buy_now_top_left_curve_properties">
							<div class="float_left"><img src="images/white_curve_top_left.gif" /></div>
							<div class="buy_now_white_curve_top_middle_strip buy_now_white_curve_top_middle_properties"></div>
							<div class="clear_right"><img src="images/white_curve_top_right.gif" /></div>							
							<div class="white_bx_middle_width white_curve_middle_border">
							<div class="clear_both register_img_properties"><img src="images/new_user.png" alt="new user" title="New User" /></div>
							<div class="clear_both">
							
								<div id="error_fname" style="display:none" class="div_text"> *Please enter first name</div>
								<div id="error_lname" style="display:none" class="div_text">*Please enter last name</div>
								<div id="error_email" style="display:none" class="div_text"> *Please enter email</div>
								<div id="error_re_email" style="display:none" class="div_text"> *Please re-enter email</div>
								<div id="error_password" style="display:none" class="div_text"> *Please enter password</div>
								<div id="len_password" style="display:none" class="div_text"> *Password must have minimum 6 characters</div>
								<div id="error_re_password" style="display:none" class="div_text"> *Please re-enter password</div>
								<div id="correct_password" style="display:none" class="div_text">*Please enter same password</div>
								<div id="validemail" style="display:none" class="div_text">*Please enter valid email</div>
								<div id="correct_email" style="display:none" class="div_text">*Please enter same email</div>
								<div id="$reg_msg" style="display:block" class="div_text"><? echo $reg_msg; ?></div>

								<div class="register_content_properties register_content_txt">FIRST NAME:</div>
								<div class="register_txt_field_position"><input  type="text" value="<? echo $firstname?>" name="firstname" id="fname" class="text_field_properties" /></div>
							</div>
							<div class="clear_both">
								<div class="register_content_txt register_last_name_properties">LAST NAME:</div>
								<div class="last_name_txt_filed_properties"><input  type="text" value="<? echo $lastname?>" name="lastname" id="lname" class="text_field_properties" /></div>
							</div>
							<div class="clear_both">
								<div class="register_content_txt register_last_name_properties">EMAIL:</div>
								<div class="last_name_txt_filed_properties"><input  type="text" value="<? echo $email?>" name="email" id="email" class="text_field_properties" /></div>
							</div>
							<div class="clear_both">
								<div class="register_last_name_properties register_content_txt">RE-ENTER EMAIL:</div>
								<div class="last_name_txt_filed_properties"><input  type="text" value="" name="reenteremail" id="re_email" class="text_field_properties" /></div>
							</div>
							<div class="clear_both">
								<div class="register_content_txt register_last_name_properties">PASSWORD:</div>
								<div class="last_name_txt_filed_properties"><input id="password"  type="password" value="" name="password" class="text_field_properties" /></div>
							</div>
							<div class="clear_both">
								<div class="register_content_txt register_last_name_properties">RE-ENTER PASSWORD:</div>
								<div class="last_name_txt_filed_properties"><input id="re_password" type="password" value="" name="repassword" class="text_field_properties" /></div>
							</div>
							<div class="clear_both">
								<div class="register_mailing_txt_properties"><input type="checkbox" name="newsletter" value="1" checked="checked"/></div>
								<div class="register_content_txt register_mailing_txt_alignment">Include me on your mailing list Unsubcribe any time</div>
								<div class="order_btn_properties"><input type="image" onclick="return reg_validation()" src="images/register.png" name="submit" border="0" alt="register" title="Register"/></a></div>
							</div>
							</div>
							<div class="float_left"><img src="images/contact_btm_left_curve.gif" /></div>
							<div class="white_btm_middle_strip buy_now_white_curve_top_middle_properties"></div>
							<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif" /></div>
						</div>
						</form>
						<form action="<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>" method="post">
						<div class="buy_now_top_left_curve_properties">
							<div class="float_left"><img src="images/white_curve_top_left.gif" /></div>
							<div class="buy_now_white_curve_top_middle_strip athlate_top_white_curve_properties"></div>
							<div class="clear_right"><img src="images/white_curve_top_right.gif" /></div>							
							<div class="white_curve_middle_border width_290">
							<div class="athlete_imag_posotion"><img src="images/athletlogin.gif" alt="athlete login" title="Athlete login" /></div>
							
							<div id="error_login_email" style="display:none" class="div_text"> *Please enter email</div>
							<div id="error_login_password" style="display:none" class="div_text"> *Please enter password</div>
							<div id="login_msg" style="display:block" class="div_text"> <? echo $login_msg;?></div>
							
							<div class="register_content_txt athlete_email_adresss">EMAIL ADDRESS</div>
							<div>
								<div class="athlete_email_text_field_position"><img src="images/mail_unread.gif" border="0" alt="email" title="email" /></div>
								<div class="athlete_txt_field_properties"><input type="text" id="login_email" name="login_email" value="<? echo $login_email?>"  class="athlate_txt_field_properties"/></div>
							</div>
							<div class="register_content_txt athlete_password_field">PASSWORD</div>
							<div class="clear_both">
								<div class="password_icon_buy_now"><img src="images/passwordicon.gif" border="0" alt="password" title="Password" /></div>
								<div><input type="password" id="login_password" name="login_password" class="athlate_txt_field_properties" /></div>
							</div>
							<div class="clear_both">
								<div class="buy_now_chekbox"><input  type="checkbox" checked="checked" value="cookie" name="cookie"/> </div>
                                <div>
								<div class="register_content_txt remember_txt">REMEMBER ME</div>
                                <div class="register_content_txt" style="padding-top:32px;float:left;padding-left:23px"><a href="rpasswd.php" style="text-decoration:none" class="register_content_txt">FORGOT PASSWORD </a></div>
                                </div>
							</div>
							<? if($_REQUEST['back_to']=='order-caricature.php') {?><input type="hidden" value="order-caricature.php" name="backto" /><div class="contact_btm"></div><div class="go_my_stuff_btn" ><input type="image" name="login" onclick="return login_validation()" src="images/order_2.jpg" border="0" alt="order" title="Order" /></div><? }else {?> <div style="height:10px">&nbsp;</div> <div class="go_my_stuff_btn"><input type="hidden" value="order-caricature.php" name="backto" /><input type="image" name="login" onclick="return login_validation()" src="images/mystuffimage.gif" border="0" alt="go to my toons" title="Go to my toons" /></div> <? }?>
							</div>
							<div class="float_left"><img src="images/contact_btm_left_curve.gif" /></div>
							<div class="white_btm_middle_strip athlate_top_white_curve_properties"></div>
							<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif" /></div>
						</div>
						</form>
						
					</div>
						<div class="buy_now_top_left_curve_properties"><img src="images/contact_btm_left_curve.gif" /></div>
						<div class="contact_middle_strip_btm athlete_btm_middle_strip"></div>
						<div class="float_left"><img src="images/contact_btm_right_curve.gif" /></div>
					</div>
			</div>
			
			<div class="clear_both" style="height:10px;"></div>
			<div>
			<div style="float:left;padding:0 0px 0px 125px;"><a href="join-our-team.php" style="text-decoration:none;"><img src="images/artists.png" border="0"  /></a></div>
			<div style="padding: 0pt 0pt 0pt 450px; line-height: 17px;" class="header_text">* Once a month we choose a winnetr from people who are our mailing list</div>
            <div style="padding:0 0 0 522px; line-height: 17px;" class="header_text">and announce the winner in one of our monthly email blasts.</div>
			</div>
			<div class="clear_both" style="height:5px;"></div>
		</div></div>
		<!--content ends-->	
		<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>