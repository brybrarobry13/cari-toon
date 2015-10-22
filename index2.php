<?
//if ($_SERVER['HTTPS'] != "on") { 
//	header('Location: https://www.caricaturetoons.com/');
//}
	include("includes/configuration.php");
	$title_text = "Personlized Caricatures online:";
	
	include (DIR_INCLUDES.'header.php');  
?>
		<!--header ends-->
		<!--content starts-->
		<div style="height:5px;"></div>
		<div align="center" style="width:49%;margin-left:390px;">
				<div align="left" style="clear:left;text-align:left;" class="header_text">Welcome to Caricature Toons, we love taking photo images and transforming them into great looking caricatures.  Order yours Today.</div>
		</div>	
		<div id="content" style="height:580px">
			<div class="runner_img"><img src="images/runner.gif"  alt="runner" title="Runner" /></div>
            <div class="cyclist_img"><a href="info.php" class="header_links">More Info</a></div>
            <div class="cyclist">
            <img src="images/cyclist_new.png" border="0" alt="cyclist" title="Cyclist" id="cycle"/>
            </div>
            <div class="personalized_txt_img" style="z-index:1">
            <!--<a href="#"><img src="images/orange.gif" width="225" alt="personalized caricatures" title="Personalized caricatures" id="bottom" align="baseline" border="0" style="z-index:0; margin-left:490px; position:absolute;"></a>-->
            <img src="images/orange.gif" alt="personalized caricatures" title="Personalized caricatures" width="225"/>
            </div>
            <div class="starting_at_txt_img" style="z-index:1">
            <!--<a href="#"><img src="images/grn.gif" width="225" alt="starting at just" title="Starting at just" id="right" align="baseline" border="0" style="z-index:0; margin-top:60px; position:absolute;" /></a>-->
            <img src="images/grn.gif" alt="starting at just" title="Starting at just" width="225"/>
            </div>
            <div class="money_back">
            <!--<a href="#"><img src="images/blue.gif" width="225" alt="money back quarantee" title="Money back quarantee" id="left" align="baseline" border="0" style="z-index:0; margin-top:175px; position:absolute;" /></a>-->
            <img src="images/blue.gif" alt="money back quarantee" title="Money back quarantee" width="225"/>
            </div>
            <div class="order_cool">
            <!--<a href="#"><img src="images/pink.gif" width="225" alt="money back quarantee" title="Money back quarantee" id="up" align="baseline" border="0" style="z-index:0; margin-left:335px; position:absolute;"></a>-->
            <img src="images/pink.gif" alt="money back quarantee" width="225" title="Money back quarantee" />
            </div>
          <div class="video_blue"><img src="images/video_blue.png" alt="money back quarantee" title="Money back quarantee" /></div>
			<div>            	
			  <div class="follow_us_img"><img src="images/follow_us_images_new.gif" alt="follow us" title="Follow us"  border="0" usemap="#Map4" />
			    <map name="Map4" id="Map4">
			      <area shape="poly" coords="6,65,6,20,12,14,56,14,62,19,63,64,57,70,13,71" href="<?=$_CONFIG['facebook_username']?>" target="_blank" alt="FACE BOOK" />
			      <area shape="poly" coords="6,128,6,83,12,78,55,77,62,83,64,128,57,134,13,134" href="<?=$_CONFIG['twitter_username']?>" target="_blank" alt="TWITTER" />
			      <area shape="poly" coords="6,149,11,143,57,143,63,151,63,194,55,201,14,201,5,193" href="<?=$_CONFIG['youtube_username']?>" target="_blank" alt="YOU TUBE" />
			    </map>
			  </div>
		  		<div class="height">&nbsp;</div>
            </div>
			<div class="height"></div>
		</div>
		<div style="height:25px;"></div>
		<div style="text-align:center;padding: 0 15px 0 15px;" class="header_text"><b>Welcome to Caricature Toons, we love taking photo images and transforming them into great looking caricatures. Order yours Today. Getting started is easy! Just upload your images, describe your vision, pick a caricaturist and tell us how many people you want in your Caricature Toon. We'll notify you the minute your Caricature Toon is ready and place it in the My Toons section. From there you'll be able to view your proofs and communicate with the Artist directly. Once your 100% satisfied, you can download your Royalty Free Caricature Toon. Or check out the Buy Products section to see the cool ways you can display your Caricature Toon. They make Great Gifts and we ship worldwide.</b></div>
		
		<!--content ends-->	
		<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>
