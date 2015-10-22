<? 
	include("includes/configuration.php");
	include (DIR_INCLUDES.'functions/encryption.php');
	@$encrypt_obj = new AzDGCrypt(1074);
	if(isset($_POST['forgot_password_x']))
	{
		$user_email=$_POST['email'];
		$sql_user="SELECT * FROM `toon_users` WHERE `user_email`='$user_email'"; 
		$rs_emailExists= mysql_query($sql_user);
		$user_email_row=mysql_fetch_array($rs_emailExists);
		$userExists = mysql_num_rows($rs_emailExists);
		if($userExists!='0')
		{
			$from=$_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
			$header = "From: ".$from."\n";
			$header .= "MIME-Verson: 1.1\n";
			$header .= "Content-type:text/html; charset=iso-8859-1\n";
			$to=$user_email_row['user_email'];
			$subject='Your Caricature Toons Password';
			$message ="Hi ".$user_email_row['user_fname'].",<br><br>

Below is your Caricature Toons Password.<br><br>

password : ".$encrypt_obj->decrypt($user_email_row['user_password'])."<br>
email id : ".$user_email."<br><br>

To login, go to ".$_CONFIG['site_url']."alogin.php<br><br>

If at anytime you have questions or require assistance, please email us at<br>
".$_CONFIG['email_contact_us']."<br><br>

Life should always be fun!!!<br><br>

The Captoon,<br>
www.caricaturetoons.com";
			
			mail($to,$subject,$message,$header);
		$msg="Your Password has been sent to your mail";


		}
		else
		{
		$msg_error="This email is not registered";
		}
	}
	
	
		include (DIR_INCLUDES.'header.php');
?> 
<script language="javascript" type="text/javascript">
function validate()
{

	hide();
	
	if(document.getElementById("email").value=="")
	{
		document.getElementById("email_div").style.display="block";
		return false;
	}
		
		return true;
}
function hide()
{
	
	document.getElementById("email_div").style.display="none";
	
}
</script>
		<!--header ends-->
		<!--content starts-->
		<link href="styles/style.css" rel="stylesheet" type="text/css" />
		<form action="<?=$_SERVER['PHP_SELF'];?>" method="post" onsubmit="return validate();">
		<div id="content">
			<div class="height80"></div>
			<div align="left" style="width:58%;margin-left:190px;">
				<div align="left" style="text-align:left;" class="header_text">Retrieving your Caricature Toons Password is easy. Enter email below and you're back into the world of custom work-of-art caricatures.</div>
			</div>
			<div style="height:20px;"></div>									
			<div>
				<div class="buy_now_curvepadding" style="margin-left:160px;background-repeat:no-repeat"><img src="images/white_curve_top_left.gif" /></div>
				<div class="buy_now_white_curve_top_middle_strip profile_sttings_whiteCurve_middle_strip"></div>
				<div><img src="images/white_curve_top_right.gif" /></div>				
				<div class="price_white_curve_middle_border profile_sttings_middle_content" style="clear:both;">
					<div style="padding-bottom:30px" align="center"><img src="images/resetpassword.gif"  border="0" alt="reset password" title="Reset password"/></div>
					<div>
                     <div align="center" style="padding-bottom:20px;"<? if($msg){echo 'class="div_text_green"';}else{ echo 'class="div_text"'; }?>><?=$msg?><?=$msg_error?></div>
                      <div id="email_div" style="display:none;padding-bottom:20px;padding-left:110px" class="div_text" align="center">*Please enter your email</div>
                                        
                    </div>
					<div>
						<div class="text_blue reset_password_txt" style="padding-left:130px" >* Please Enter Your Email:</div>
						<div style="float:left;padding-left:10px"><input type="text" width="45px" name="email" id="email" value="<?=$row[user_email];?>"/></div>
					</div>
					
					
                    
					<div class="clear_both">
						<div class="reset_password_cancel_btn"><a href="alogin.php"><img src="images/cancel.gif" border="0" alt="cancel" title="Cancel" /></a></div>
					  	<div class="get_password_btn"><input type="image" name="forgot_password" src="images/getpassword.gif" border="0" alt="get password" title="Get password" /></a></div>
					</div>
					<div class="clear_both">&nbsp;</div>
				</div>
				
				<div>
					<div class="buy_now_curvepadding profile_sttings_btm_curve"><img src="images/contact_btm_left_curve.gif" /></div>
					<div class="white_btm_middle_strip profile_sttings_whiteCurve_middle_strip"></div>
					<div class="curve_right_position"><img src="images/contact_btm_right_curve.gif" /></div>
				</div>
			</div>
			<div class="profile_btm_height">&nbsp;</div>
			<div class="height80"></div>
			
			
		</div>
		</form>
		<!--content ends-->	
		<!--footer-->	
<? 
 
include (DIR_INCLUDES.'footer.php') ;
?>
