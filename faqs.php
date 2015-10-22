<? 
	include("includes/configuration.php");
	$title_text = "About Us:FAQs:";
	include (DIR_INCLUDES.'header.php'); 
	include_once(DIR_FUNCTIONS."static.php");
	$static_code='PAGE_FAQS';
	$static=get_staticdetails($static_code);
?>
<!--header ends-->
<!--content starts-->
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<div id="content">
  <div style="height:5px;"></div>
  <div>
    <div class="faq_top_curve"><img src="images/contact_top_left_curve.gif" /></div>
    <div class="buy_now_middlestrip faq_top_middlestrip_position"></div>
    <div class="float_left"><img src="images/contact_top_right_curve.gif" /></div>
    <div class="clear_right">&nbsp;</div>
    <div class="affliate_content_middle_strip faq_content_position">
      <div class="text_blue line_space" style="padding-left: 30px"><?php echo $static;?></div>
    </div>
    <div class="faq_top_curve"><img src="images/contact_btm_left_curve.gif" /></div>
    <div class="contact_middle_strip_btm faq_btm_strip_position"></div>
    <div class="float_left"><img src="images/contact_btm_right_curve.gif" /></div>
    <div class="height_1 clear_both">&nbsp;</div>
  </div>
</div>
<!--content ends-->
<!--footer-->
<? include (DIR_INCLUDES.'footer.php') ?>
