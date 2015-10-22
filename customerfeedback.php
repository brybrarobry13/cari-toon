<? include("includes/configuration.php");
$title_text = "Caricature Customer Feedback:";
$order_id=$_GET['ordid'];

if(isset($_POST['submit']))	
{
	$rating=$_POST['rating'];
	$comments=$_POST['comments'];
	$order_id=$_POST['ordid'];
	mysql_query("UPDATE `toon_orders` SET `review_rating`='$rating',`review_comment`='$comments',`review_date`=NOW() WHERE `order_id`='$order_id'");
	echo "<script>window.opener.location.href = window.opener.location.href;window.close();</script>";
}					
?> 
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<!--header ends-->
<!--content starts-->
	<form name="rating" method="post" action="customerfeedback.php" enctype="multipart/form-data">
	<div>
	<input type="hidden" value="<?=$order_id?>"  name="ordid" />
		<div>
			<div style="float:left;background-color:#C1FFC1;width:50px;height:40px;padding-top:5px;"><img src="images/tick.png" ></div>
			<div style="text-align:left;padding-left:50px;padding-top:5px;normal 14px Arial;background-color:#F5F5F5;height:40px;"><b>Order Completed!</b></div>
		</div>
		<div style="height:15px;"></div>
	
		<div style="padding-left:50px;padding-top:5px;" class="review_text" ><img src="images/arrow.jpg">&nbsp;&nbsp;&nbsp;PLEASE RATE YOUR EXPERIENCE WITH THE ARTIST&nbsp;&nbsp;&nbsp;<img src="images/icon_green.png" border="0" width="15" height="20"/><input type="radio" value="1" name="rating" id="rating" <? if($rating=="1") { ?> checked="checked" <? } ?>/>&nbsp;&nbsp;<img src="images/icon_red.png" border="0" width="15" height="20"/><input type="radio" value="0" name="rating" id="rating" <? if($rating=="0") { ?> checked="checked" <? } ?>></div>
		<div style="height:15px;"></div>
		
		<div style="padding-left:50PX;"><span class="header_text"><textarea cols="68" rows="5" name="comments"></textarea></span></div>
		<div style="height:10px;"></div>
		<div style="padding-left:550px;"><input type="submit" value="submit" name="submit"></div>
	</div>
	</form>
	
<!--content ends-->	
<!--footer-->	
