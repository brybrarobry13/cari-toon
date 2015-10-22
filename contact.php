<? include("includes/configuration.php");
//require_once('mcapi/inc/MCAPI.class.php');
$title_text = "About Us:Contact Us:";
include (DIR_INCLUDES.'header.php'); 
//echo $_CONFIG['email_admin'];

//Caricature MailChimp Key
$apikey = 'd7229a6dbbe5df2b5bb2f6430fdbefd4-us2';

if(isset($_POST['news_email_x']))
{
	$email_news=$_POST['email_news'];
	$fname_news=$_POST['fname_news'];
	$lname_news=$_POST['lname_news'];
	mysql_query ("INSERT INTO `toon_newsletter` (`nltr_email`, `nltr_fname`, `nltr_lname`) VALUES ('$email_news', '$fname_news', '$lname_news')");
	
	$api = new MCAPI($apikey);
	
	$mergeVars = array('FNAME'=>$fname_news,
					   'LNAME'=>$lname_news);

	#List Id of Newsletters
	//$listID = '97aad3ac02';
	
	#List Id of Caricature Toons
	$listID = 'dbde0db1cb';
	
	if($api->listSubscribe($listID, $email_news, $mergeVars) === true) {
		// It worked!	
		$msg='* Please check your email to confirm registration';
		$newsprocess = "success";
	}else{
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
	
	We&rsquo;re so confident you&rsquo;ll like your Toon that we provide a100% money back guarantee if your not completely satisfied. We also have some great products you can display your Toon on or present as a gift.<br><br>
	
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
	$tellafrnd ="success";
	
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
		
	}else{
		// An error ocurred, return error message	
		$msg.='<br><br>Error: ' . $api->errorMessage;
	}
}
	
	
?> 
<link rel="stylesheet" type="text/css" href="styles/highslide/highslide.css" />
<script type="text/javascript" src="javascripts/highslide-with-html.js"></script>
<script type="text/javascript">
hs.graphicsDir = 'styles/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>

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

		<!--header ends-->
		<!--content starts--><div style="float: left; width: 190px; padding: 10px 0px 0px 25px; height: 0px;position:absolute;z-index:1000;"><a href="terms.php"><img src="images/guarantee-seal.png" width="190px" border="0" /></a></div>
		<div id="content">
			<div style="height:20px;"></div>			
			<div>
				<div class="left_margin"><img src="images/contact_top_left_curve.gif" /></div>
				<div class="contact_middle_strip"></div>
				<div class="float_left"><img src="images/contact_top_right_curve.gif" /></div>
				<div class="clear_right">&nbsp;</div>
				<div class="contact_bottom_strip" style="background-color:#FFFFFF">
				<div style="display:table;width:100%;">
				<div style="display:table-row">
						<div style="display:table-cell;float:left;width:50%;">
							<div style="float:left;width:100%;">
                    <div class="align_center" style="width:300px;"><img src="images/contact_us_txt.gif" alt="contact us" title="Contact us" /></div>
					
					
                   		 <div class="text_blue" style="padding-left:15px;width:300px;float:left">
                    <div>
                      <p>At Caricature Toons we aim to please and want to make sure your 100% Satisfied with your Caricature Toon.</p>
                      &nbsp;
                      <p>If you require any assistance, please do not hesitate to email us and we'll promptly get back to you.</p>
                      &nbsp;
                      <p>If you have an order related question, please include your name and order number. </p>&nbsp;
					  <div class="align_center"><a href="mailto:<?=$_CONFIG['email_contact_us']?>?subject=Message - Support Request"><img src="images/send_email.gif" border="0" alt="send email" title="Send email" /></a></div>
					  
                      
    				</div>
                    <!--div align="center" style="padding-bottom:8px">
                        <div><img src="images/home.png" alt="address" title="Address" /></div><div><b>Address</b></div>
                    </div>
                    <div align="center">
                        <p>1890 Beaver Ridge Circle<br />
                        Suite A<br />
                        Norcross, GA 30071<br/>
						415.935.6285<br/><br/></p>
                     </div-->   
                      <div>  <br />
                        <a href="" onclick="return hs.htmlExpand(this,{headingText: 'Join Us'})">Artist's Click here</a>, if your great at creating custom caricatures from images and would like to join our team.<div class="highslide-maincontent"><span class="text_blue"><p>We're constantly on the lookout for great Caricature Artists with unique Caricature Toon styles and a passion to bring a smile to our customers faces. If you think our customers would love your Caricature Toon style, we'd love to see your Caricature Samples.
<br/><br/>
To join our team is a simple process, just <a href="mailto:<?=$_CONFIG['email_contact_us']?> <<?=$_CONFIG['email_contact_us']?>>?subject=Artist Submission">email</a> us at least a few samples of the Caricature Toons you&prime;ve done previously, along with the original photographs that your customer supplied. If we think our customers would love your caricature artist style, we'll send you our pricing, turnaround and quality requirements along with a Caricature Artist Letter of Understanding Agreement. Simply fill out the paperwork and we&prime;ll give you access to set up your gallery and start promoting your caricatures online immediately. 
<br/><br />
The best part is our Artists love the fact that we take care of all the marketing, promotion and administration. All you have to do is what Great Caricature Artists do best, take customer photos and transform them into great looking Caricature Toons.
<br/>
</span>
</div>
                       </div>
                        
                    </div>
					</div>
						</div>
										
						<div style="display:table-cell;width:50%;vertical-align:top;text-align:left;padding-right:20px;">
							<div style="display:table">
							<div style="height:10px;"></div>
                            <div align="center" class="div_text_green"><?=$msg?>
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
                                <? if($tellafrnd=="success") {  ?>
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
							<div style="display:table-row">
							<div style="display:table-cell;padding-left:40px;">
							<img src="images/specialoffers.gif" alt="special ofers" title="Special offers" />
							</div>
							</div>
								<div style="height:15px;"></div>
								<div style="display:table-row">
									<div style="display:table-cell">
											<div>
                            <div style="float:left;"><img src="images/curve_blueborderlefttop.gif"  /></div>
                            <div class="blue_box_middle_top_strip" style="width:312px;float:left; height:19px;"></div>
                            <div style="float:left"><img src="images/curve_blueborderrighttop.gif" /></div>
                        </div>	
                        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="return checkemail(this)" style="margin:0px;">
                  <div  class="blue_box_middle_content_strip" style="clear:both;width:350px;height:200px">
                        <div style="padding-left:4px;"><img src="images/posted.gif" alt="keep me posted" title="Keep me posted" /></div>
                        <div class="text_blue" style="padding-left:10px;"><img src="images/winfree.png" alt="winfree" title="winfree" /></div>
						<div style="height:5px;"></div>
						 <div class="text_blue" style="padding-left:10px;">Join our Mailing List </div>
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
                            <div style="clear:both;padding-left:158px;padding-top:6px"><input type="image" name="news_email" onclick="return validateemail()" src="images/submit.gif" border="0" alt="submit" title="Submit" /></div>
                        </div>
                        
                  </div>
                        </form>
                      <div>
                            <div style="float:left;"><img src="images/curve_blueborderleftbt.gif"  /></div>
                            <div class="blue_box_btm_middle_strip_sp" style="width:312px;float:left; height:19px;"></div>
                            <div style="float:left"><img src="images/curve_blueborderrightbt.gif"/></div>
                    </div>
									</div>
								</div>
								<div style="height:20px;"></div>
							<div style="display:table-row">
								<div style="display:table-cell">
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
                        
                        <div style="text-align:center; margin-top:5px;padding-left: 30px;"><input type="image" onclick="return tellfriend()" name="tellfriend" src="images/submit.gif" border="0" alt="submit" title="Submit"/></div>
                        
                        
                    
                    </div>
                        </form>
                    				<div>
                        <div style="float:left"><img src="images/curve_blueborderleftbt.gif"/></div>
                        <div class="blue_box_btm_middle_strip_sp" style="width:310px; height:19px; float:left"></div>
                        <div><img src="images/curve_blueborderrightbt.gif"/></div>
                    </div>
                    
								</div>
							</div>
						</div>
					<div>
				</div>
				</div>
				
				</div>
				</div>
				  
				  <div style="clear:both"></div>
					
				</div>
				<div class="left_margin"><img src="images/contact_us_btm_left_curve.gif" /></div>
				<div class="contact_us_middle_strip_btm contact_middle_strip_btm_properties"></div>
				<div class="float_left"><img src="images/conatct_us_btm_right_curve.gif" /></div>
				<div class="contact_btm"></div>
            </div>
		</div>
		<div style="width: 450px; line-height: 17px; padding-left: 260px;" class="header_text">* Once a month we choose a winner from people who are our mailing list</div>
        <div style="width: 450px; line-height: 17px; padding-left: 268px;" class="header_text">and announce the winner in one of our monthly email blasts.</div>
		<div style="height:15px;"></div>
		<div class="header_text" style="padding:0 30px 0 30px;">
        We pride our self on great customer service and try to have a real person available when you need us, whether you have questions or want to give feedback or you're a caricature artist that wants to work for us, we're available. Our Caricature Toon Helpers are very prompt and usually get back to you same day. With that said, if you’ve ordered a Caricature, you can also always communicate directly with your Caricature Artist at anytime.<br /><br />
        At Caricature Toons our toon helpers can answer all your questions. Whether it's about creating caricatures or ordering cool gifting products we can help. We want to make sure you are 100% satisfied with our caricature cartoons and strive to offer the best possible customer experience possible and create RAVINGLY happy customers who love their Caricatures and will tell their friends about us.<br /><br />
        Our mission is to offer some of the highest quality caricatures you can order online at a price you can afford. Our uniqueness lies in the fact that we offer a wide variety of caricature artists' styles and prices and we're sure one's ideal to suit your tastes and budget. Many of our caricature artists are well known and legends in the field. <br /><br />
        It's awesome to make caricatures for yourself and others. They make lovely birthday, retirement, anniversary, engagement and all occasion gifts, not to mention awesome avatars. They can be used on various items as well such as mugs, water bottles, T-shirts, aprons, mouse pads, tote bags, buttons, coasters, luggage tags, playing cards, tiles, framed posters, canvas, cards and stickers. Be sure to check out our <a href="buy-caricature-gift.php">Buy Products</a> section to take a look at all the cool gifts you can order. <br /><br />
        Our artists only need 7 days or less, and your caricature toon will be yours to cherish forever. We are so confident in our caricature artists' abilities, we provide you a risk free 100% money back guarantee if you're not completely pleased with the end result.<br /><br />
        If you happen to need our help or want to give feedback, please do not hesitate to <a href="mailto:<?=$_CONFIG['email_contact_us']?> <?=$_CONFIG['email_contact_us']?>subject=Artist Submission">email</a> or give us a phone call and one of our toon helpers will get back to you ASAP.  

</div>
<div style="height:20px;"/></div>
		<!--content ends-->	
		<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>