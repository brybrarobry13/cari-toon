<? include ("includes/configuration.php"); 
$message="";
if(isset($_POST['update']))
{	
	$new_contact_us=$_POST["package_contact_email"];
	$new_site_url=$_POST["site_url"];
	$new_site_name=$_POST["site_name"];
	$new_admin_email=$_POST["admin_email"];
	$new_web_title=$_POST["web_title"];
	$new_keywords=$_POST["keywords"];
	$new_description=$_POST["description"];
	$new_outgoing_email=$_POST["package_out_email"];
	$new_twitter_username=$_POST["twitter_username"];
	$new_facebook_username=$_POST["facebook_username"];
	$new_youtube_username=$_POST["youtube_username"];
	$new_blog_username=$_POST["blog_username"];
	$new_google_ads=$_POST["google_ads"];
	$paypal_uname=$_POST["paypal_uname"];
	$paypal_password=$_POST["paypal_password"];
	$paypal_signature=$_POST["paypal_signature"];
	$paypal_mode=$_POST["paypal_mode"];
	
	
	$update_contact_us=mysql_query("update toon_configuration set config_value='$new_contact_us' where config_code='EMAIL_CONTACT_US'");
	$update_site_url=mysql_query("update toon_configuration set config_value='$new_site_url' where config_code='SITE_URL'");
	$update_site_name=mysql_query("update toon_configuration set config_value='$new_site_name' where config_code='SITE_NAME'");
	$update_admin_email=mysql_query("update toon_configuration set config_value='$new_admin_email' where config_code='EMAIL_ADMIN'");
	$update_title=mysql_query("update toon_configuration set config_value='$new_web_title' where config_code='SITE_TITLE'");
	$update_keywords=mysql_query("update toon_configuration set config_value='$new_keywords' where config_code='SITE_META_KEYWORDS'");
	$update_description=mysql_query("update toon_configuration set config_value='$new_description' where config_code='SITE_META_DESCRIPTION'");
	$update_out_email=mysql_query("update toon_configuration set config_value='$new_outgoing_email' where config_code='EMAIL_OUTGOING'");
	$update_twitter_username=mysql_query("update toon_configuration set config_value='$new_twitter_username' where config_code='TWITTER_USERNAME'");
	$update_facebook_username=mysql_query("update toon_configuration set config_value='$new_facebook_username' where config_code='FACEBOOK_USERNAME'");
	$update_youtube_username=mysql_query("update toon_configuration set config_value='$new_youtube_username' where config_code='YOUTUBE_USERNAME'");
	$update_blog_username=mysql_query("update toon_configuration set config_value='$new_blog_username' where config_code='BLOG_USERNAME'");
	$update_google_ads=mysql_query("update toon_configuration set config_value='$new_google_ads' where config_code='GOOGLE_ADS'");
	$update_paypal_username=mysql_query("update toon_configuration set config_value='$paypal_uname' where config_code='PAYPAL_API_USERNAME'");
	$update_paypal_password=mysql_query("update toon_configuration set config_value='$paypal_password' where config_code='PAYPAL_API_PASSWORD'");
	$update_paypal_signature=mysql_query("update toon_configuration set config_value='$paypal_signature' where config_code='PAYPAL_API_SIGNATURE'");
	$update_paypal_mode=mysql_query("update toon_configuration set config_value='$paypal_mode' where config_code='PAYPAL_MODE'");
	
	$message="Details Updated Successfully";
}

$common_configure=mysql_query("SELECT * FROM toon_configuration");
$setting_rows = array();
$i=0;
while($row = mysql_fetch_array($common_configure,MYSQL_ASSOC)){
	$setting_rows[$i] = $row;
	$i++;
}
for($j=0;$j<count($setting_rows);$j++)
{
if($setting_rows[$j]['config_code']=='EMAIL_CONTACT_US')
	{
	$contact_email=$setting_rows[$j]['config_value'];
	}	
if($setting_rows[$j]['config_code']=='SITE_URL')
	{
	$url=$setting_rows[$j]['config_value'];
	}
if($setting_rows[$j]['config_code']=='SITE_NAME')
	{
	$name=$setting_rows[$j]['config_value'];
	}
if($setting_rows[$j]['config_code']=='EMAIL_ADMIN')
	{
	$admin_email=$setting_rows[$j]['config_value'];
	}	
if($setting_rows[$j]['config_code']=='SITE_TITLE')
	{
	$title=$setting_rows[$j]['config_value'];
	}
if($setting_rows[$j]['config_code']=='SITE_META_KEYWORDS')
	{
	$meta_keywords=$setting_rows[$j]['config_value'];
	}
if($setting_rows[$j]['config_code']=='SITE_META_DESCRIPTION')
	{
	$meta_descrip=$setting_rows[$j]['config_value'];
	}
if($setting_rows[$j]['config_code']=='EMAIL_OUTGOING')
	{
	$outgoing_email=$setting_rows[$j]['config_value'];
	}	
if($setting_rows[$j]['config_code']=='TWITTER_USERNAME')
	{
	$twitter_uname=$setting_rows[$j]['config_value'];
	}	
if($setting_rows[$j]['config_code']=='FACEBOOK_USERNAME')
	{
	$facebk_uname=$setting_rows[$j]['config_value'];
	}	
	if($setting_rows[$j]['config_code']=='YOUTUBE_USERNAME')
	{
		$utube_uname=$setting_rows[$j]['config_value'];
	}
	if($setting_rows[$j]['config_code']=='BLOG_USERNAME')
	{
		$blog_uname=$setting_rows[$j]['config_value'];
	}
	if($setting_rows[$j]['config_code']=='GOOGLE_ADS')
	{
		$google_ads=$setting_rows[$j]['config_value'];
	}
	if($setting_rows[$j]['config_code']=='PAYPAL_API_USERNAME')
	{
		$paypal_uname=$setting_rows[$j]['config_value'];
	}
	if($setting_rows[$j]['config_code']=='PAYPAL_API_PASSWORD')
	{
		$paypal_password=$setting_rows[$j]['config_value'];
	}
	if($setting_rows[$j]['config_code']=='PAYPAL_API_SIGNATURE')
	{
		$paypal_signature=$setting_rows[$j]['config_value'];
	}
	if($setting_rows[$j]['config_code']=='PAYPAL_MODE')
	{
		$paypal_mode=$setting_rows[$j]['config_value'];
	}
}
	 include ("includes/header.php");?>
<script language="javascript" type="text/javascript" src="javascripts/settings.js"></script>

<form action="settings.php" method="post">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Manage Settings</td>
          </tr>
		  <tr>
		  <td height="20" colspan="4"></td>
		  </tr>
          <tr>
            <td align="center" class="no_details_msg settings_div">
             	 <div id="div_site_url" style="display:none;">Enter Site URL</div>
              	 <div id="div_site_name" style="display:none;">Enter Site Name</div>
               	<div id="div_web_title" style="display:none;">Enter Site Title</div>
			   	<div id="div_admin_email" style="display:none;">Enter Admin Email</div>
				<div id="div2_admin_email" style="display:none;">Enter Correct Admin Email iD
				</div>	
				<div id="div_out_email" style="display:none;">Enter Outgoing Email</div>
				<div id="div2_out_email" style="display:none;">Enter the Correct Outgoing Email</div>
				<div id="div_contact_email" style="display:none;">Enter Contact Us Email</div>
				<div id="div2_contact_email" style="display:none;">Enter the Correct  Contact Us Email</div>
              	<div id="div_keywords" style="display:none;">Enter Keywords</div>
              	<div id="div_description" style="display:none;">Enter Description</div>
              	<div id="div_twitter_username" style="display:none;">Enter Twitter URL</div>
				<div id="div_facebook_username" style="display:none;">Enter Facebook URL</div>
              	<div id="div_youtube_username" style="display:none;">Enter Youtube URL</div>
                <div id="div_blog_username" style="display:none;">Enter Blog URL</div>
                <div id="div_google_ads" style="display:none;">Enter Google Ads</div>
              	<div id="div_paypal_uname" style="display:none;">Enter Paypal API Username</div>
              	<div id="div_paypal_password" style="display:none;">Enter Payial API Password</div>
				<div id="div_paypal_signature" style="display:none;">Enter Paypal Signature</div>
              	<div id="div_err_msg" style="display:block;"><?=$message?></div></td>
          </tr>
          <tr>
            <td width="90%" align="center" valign="top"><table border="0" cellpadding="4" cellspacing="0" width="65%" align="center" class="table_details">
                <tr>
                  <td height="16" colspan="2"></td>
                </tr>
                <tr>
                  <td>Site URL*</td>
                  <td><input type="text" name="site_url" class="settings"  id="site_url"  value="<?=$url;?>"/></td>
                </tr>
                <tr>
                  <td>Site Name*</td>
                  <td><input type="text" name="site_name" class="settings"  id="site_name"  value="<?=$name;?>"/></td>
                </tr>
                <tr>
                  <td>Site Title:</td>
                  <td><input type="text" name="web_title" id="web_title" class="settings" value="<?=$title;?>"/>
                  </td>
                </tr>
                <tr>
                  <td>Admin Email*</td>
                  <td><input type="text" name="admin_email" id="admin_email" class="settings" value="<?=$admin_email;?>"/></td>
                </tr>
                <tr>
                  <td>Outgoing Email*</td>
                  <td><input type="text" name="package_out_email" id="package_out_email" class="settings" value="<?=$outgoing_email;?>"/></td>
                </tr>
                <tr>
                  <td>Contact Us Email*</td>
                  <td><input type="text" name="package_contact_email" id="package_contact_email" class="settings" value="<?=$contact_email;?>"/></td>
                </tr>
                <tr>
                  <td>Keywords*</td>
                  <td><input type="text" name="keywords" id="keywords" class="settings" value="<?=$meta_keywords;?>"/></td>
                </tr>
                <tr>
                  <td>Description*</td>
                  <td><input type="text" name="description" id="description" class="settings" value="<?=$meta_descrip;?>"/></td>
                </tr>
                <tr>
                  <td>Twitter URL*</td>
                  <td><input type="text" name="twitter_username" id="twitter_username" class="settings" value="<?=$twitter_uname;?>"/></td>
                </tr>
                <tr>
                  <td>Facebook URL*</td>
                  <td><input type="text" name="facebook_username" id="facebook_username" class="settings" value="<?=$facebk_uname;?>"/></td>
                </tr>
                <tr>
                  <td>Youtube URL*</td>
                  <td><input type="text" name="youtube_username" id="youtube_username" class="settings" value="<?=$utube_uname;?>"/></td>
                </tr>
                <tr>
                  <td>Blog URL*</td>
                  <td><input type="text" name="blog_username" id="blog_username" class="settings" value="<?=$blog_uname;?>"/></td>
                </tr>
                <tr>
                  <td valign="top">Google Ads*</td>
                  <td><textarea name="google_ads" id="google_ads" class="settings" style="height:150px; width:300px;"><?=$google_ads;?></textarea></td>
                </tr>
                <tr>
                  <td>Paypal API Username*</td>
                  <td><input type="text" name="paypal_uname" id="paypal_uname" class="settings" value="<?=$paypal_uname;?>"/></td>
                </tr>
                <tr>
                  <td>Paypal API Password*</td>
                  <td><input type="text" name="paypal_password" id="paypal_password" class="settings" value="<?=$paypal_password;?>"/></td>
                </tr>
                 <tr>
                  <td>Paypal API Signature*</td>
                  <td><textarea name="paypal_signature" id="paypal_signature" class="settings" style="height:60px;"><?=$paypal_signature;?></textarea></td>
                </tr>
                <tr>
                  <td>Paypal Mode*</td>
                  <td><select name="paypal_mode" id="paypal_mode">
                      <option value="sandbox" <? if($paypal_mode=='sandbox'){?> selected="selected"<? }?>>Test</option>
                      <option value="" <? if($paypal_mode==''){?> selected="selected"<? }?>>Live</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="update" value="update" id="update" onclick="return validate()"/></td>
                </tr>
              </table></td>
            <td width="10%">&nbsp;</td>
          </tr>
          <tr>
            <td height="40" colspan="4"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<? include ("includes/footer.php"); ?>
