<?  include('includes/configuration.php');
	$sortby=$_REQUEST['sortby'];
	$status_sort=$_REQUEST['sortbystatus'];
	$sortbydate=$_REQUEST['sortbydate'];
	$searchword = $_REQUEST['keyword'];
	$first_date=$_REQUEST['first_date'];
	$last_date=$_REQUEST['last_date'];
	
	if($status_sort!="" && $status_sort!="artist")
	{
		$sortbystatus='AND T.order_status=\''.$status_sort.'\'';
	}
	if($sortbydate=='date_range' && $first_date!="" && $last_date!=""  )
	{
		$sortbydate='AND DATE(T.order_date) BETWEEN \''.$first_date.'\' AND \''.$last_date.'\' ' ;
	}
	$sortorder=$_REQUEST['sortorder'];
	if($sortorder=='ascending')
	{
		$sort_order='ASC';
	}
	else
	{
		$sort_order='DESC';
	}
	if($sortby=='date')
	{
		$sort_by='T.order_date';
	}
	elseif($sortby=='artist')
	{
		$sort_by='TA.user_fname';
	}
	else
	{
		$sort_by='T.order_date';
	}

	$order_id=$_REQUEST['order_id'];
	if($order_id)
	{  
		$delete=mysql_query("DELETE FROM `toon_orders` WHERE `order_id`='$order_id'");
		$delete1=mysql_query("DELETE FROM `toon_messages` WHERE `order_id`='$order_id'");
	}
	
	#Old Query
	/*$sql_content="SELECT T.*,TP.`product_title`,TP.`product_wholesale_price`,TP.`product_turnaroundtime`,CONCAT(TA.`user_fname`,' ',TA.`user_lname`) AS `artist`, CONCAT(TC.`user_fname`,' ',TC.`user_lname`) AS `customer`,TPA.* FROM `toon_orders` T,`toon_products` TP,`toon_users`TA ,`toon_users`TC ,`toon_payments` TPA WHERE T.`product_id`=TP.`product_id` AND T.user_id = TC.user_id AND T.artist_id=TA.user_id AND T.order_status!='pending' AND TPA.order_id=T.order_id $sortbystatus $sortbydate ";*/
	
	#New Query
	$sql_content="SELECT T.*, TP.`product_title`, TP.`product_wholesale_price`, TP.`product_turnaroundtime`, CONCAT(TA.`user_fname`,' ',TA.`user_lname`) AS `artist`, CONCAT(TC.`user_fname`,' ',TC.`user_lname`) AS `customer`, TPA.`payment_id`, TPA.`user_id`, TPA.`payment_txn_id`, TPA.`payment_amount`, TPA.`payment_status`, TPA.`payment_date` FROM `toon_products` TP, `toon_users` TA, `toon_users` TC, `toon_orders` T LEFT JOIN `toon_payments` TPA ON T.order_id=TPA.order_id WHERE T.`product_id`=TP.`product_id` AND T.user_id = TC.user_id AND T.artist_id = TA.user_id AND T.order_status!='pending' $sortbystatus $sortbydate ";	 

if($searchword !="" && $searchword !="Enter keyword")
	{
	  if($status_sort=='artist')
	  {
		$sql_content.=" AND (
						TA.`user_fname` LIKE '%$searchword%' 
						OR TA.`user_lname` LIKE '%$searchword%' 
						) ";
		}
	  else
	  {
	  	$sql_content.=" AND (
						TA.`user_fname` LIKE '%$searchword%' 
						OR T.`order_id` = '$searchword' 
						OR TPA.`payment_txn_id` = '$searchword'
						OR TA.`user_lname` LIKE '%$searchword%' 
						OR TC.`user_fname` LIKE '%$searchword%' 
						OR TC.`user_lname` LIKE '%$searchword%'
						) ";
	  }
		
	}
	$sql_content.="GROUP BY T.`order_id` ORDER BY $sort_by $sort_order";
	//echo $sql_content;
$rs_content = mysql_query($sql_content);
if(isset($_POST['download']))
{	
	$exel_headding="Ord. No. \t Artist \t Customer \t Whole sale Price($) \t Retail sale Price($) \t Status \t Ordered Date \t Completed Date \t <:nextline:> ";
	$exel_content="";
	for($val=0;$val<=$_POST['content_no'];$val++)
	{
		$exel_content.=$_POST['excel_data'.$val];
	}
$whole_sale=$_POST['whole_sale'];
$retail_sale=$_POST['retail_sale'];
$exel_total="\t \t Total \t ".$whole_sale." \t ".$retail_sale."  \t <:nextline:>";
$filename ="Oreders".date('dMy').".xls";
$contents1=$exel_headding.$exel_content.$exel_total;
$contents = str_replace("<:nextline:>","\n",$contents1);
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $contents;
exit();

}
include ('includes/header.php');
?>
<link rel="stylesheet" href="styles/datechooser.css" type="text/css" />
<script language="javascript" type="text/javascript" src="javascripts/datechooser.js"></script>
<script language="javascript" type="text/javascript" src="javascripts/date-functions.js"></script>
<script type="text/javascript">
function show_confirm()
{
	var r=confirm("Do you really want to delete this order?");
	return r;
    
}
</script>
<script>
function search_default()
{
	document.getElementById('Search_box').value='';
}
function search_set()
{
	if(document.getElementById('Search_box').value=='')
		document.getElementById('Search_box').value='Enter keyword';
}
</script>
<table cellpadding="0" cellspacing="10" border="0" width="97%">
<tr>
	<td height="40px;"></td>
    <td>
    <form name="calender" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <table cellpadding="0" cellspacing="2" width="100%">
        	<tr>
            	<td colspan="2"><input type="checkbox" name="sortbydate" value="date_range" <? if($sortbydate){?> checked="checked"<? }?> id="sort_check" /> Sort By Date Range
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <input type="text" id="first_date" value="<?=$first_date?>" name="first_date" readonly="readonly" />
                    <img align="absmiddle" src="images/calendar.gif" width="20" onclick="showChooser(this, 'first_date', 'cal_from', 1900, 2028, 'Y-m-d', false);" />
                    <div class="dateChooser" id="cal_from" style="DISPLAY: none; VISIBILITY: hidden; WIDTH: 155px"></div>
             </td>
             <td style="padding-left:216px">
                   <select name="sortbystatus" onchange="document.calender.submit()" >
                        <option value="">All</option>
                        <option value="paid" <? if($status_sort=='paid') { echo 'selected="selected"';}?>>Not Started</option>
                        <option value="Work In Progress" <? if($status_sort=='Work In Progress') { echo 'selected="selected"';}?>>In process </option>
                        <option value="waiting for approval" <? if($status_sort=='waiting for approval') { echo 'selected="selected"';}?>>Waiting For Approval</option>
                        <option value="Completed" <? if($status_sort=='Completed') { echo 'selected="selected"';}?>>Completed</option>
                        <option value="artist paid" <? if($status_sort=='artist paid') { echo 'selected="selected"';}?>>Artist Paid</option>
                        <option value="Refunded" <? if($status_sort=='Refunded') { echo 'selected="selected"';}?>>Artist Refunded</option>
                        <option value="artist" <? if($status_sort=='artist') { echo 'selected="selected"';}?>>Artist</option>
                        <!--<option value="Not Paid" <? if($status_sort=='Not Paid') { echo 'selected="selected"';}?>>Artist Not Paid</option>-->
                    </select>
                
                </td>
            </tr>
            <tr>
            	<td width="50%">
                    <input type="text" value="<?=$last_date?>" id="last_date" name="last_date" readonly="readonly" />
                    <img align="absmiddle" src="images/calendar.gif" width="20" onclick="showChooser(this, 'last_date', 'last_from', 1900, 2028, 'Y-m-d', false);" />
                    <div class="dateChooser" id="last_from" style="DISPLAY: none; VISIBILITY: hidden; WIDTH: 155px"></div>
                </td>
                 
                <td align="right">
                <input name="keyword" id="Search_box" class="textField_search" value="<? if($searchword) {echo $searchword;}else{ echo "Enter keyword";} ?>" type="text" onClick="search_default()" onBlur="search_set()" >
                <input type="image" src="images/search.gif">
                </td>
            </tr>
             
        </table>
    </form>
    </td>
 </tr>
 <tr>
  <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
  <td align="center" valign="top">
    <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
     <tr class="table_titlebar"><td class="main_heading" height="30" width="100%" colspan="4">Orders</td></tr>
     <tr><td height="40px;"></td><td align="right" valign="middle"></td></tr>
      <tr>
      	<td width="2%">&nbsp;</td>
      	<td align="center">
		<?
			$count=mysql_num_rows($rs_content);
			if ($count)
			{?>
            	<form action="orders.php" method="post">
				  <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
                  <tr class="heading_bg">
                      <td width="3%" class="sub_heading">Ord. No.</td>
                      <td class="sub_heading">Transaction ID</td>
                      <td class="sub_heading"><a class="sub_heading" style="padding-left:0px" href="orders.php?sortby=artist&sortorder=<? if($sort_order=='DESC'){echo 'ascending';}else{echo 'descending';}?>">Artist</a></td>
                      <td class="sub_heading">Customer</td>
                      <td class="sub_heading">Whole sale Price($)</td>
                      <td class="sub_heading">Order Price($)</td>
                      <td class="sub_heading">Status</td>
                      <td class="sub_heading"><a class="sub_heading" style="padding-left:0px" href="orders.php?sortby=date&sortorder=<? if($sort_order=='DESC'){echo 'ascending';}else{echo 'descending';}?>">Ordered Date</a></td>
                      <td class="sub_heading">Completed Date</td>
                      <td class="sub_heading">Actions</td>
                  </tr>
                   <?
                   $i=0;
                   while($content=mysql_fetch_assoc($rs_content))
                   {
                        
                        $deadline =mysql_fetch_array(mysql_query("SELECT DATE_ADD('$content[order_date]', INTERVAL '$content[product_turnaroundtime]' DAY),NOW() AS `today`"));
                   ?>
                    <tr>
                      <td align="left" class="table_details" ><span style="text-decoration:none;<? if($deadline[0]<$deadline['today']&&($content['order_status']=='Paid' || $content['order_status']=='waiting for approval')) {?> color:#FF0000<? }else {?> color:#000000;<? }?>"><?=$content['order_id']?></span></td>
                      <td align="left" class="table_details" ><? if($content['payment_txn_id']!=''){ echo $content['payment_txn_id']; } else { echo "- -"; }?></td>
                      
                      <td align="left" class="table_details" <? if($deadline[0]<$deadline['today']&&($content['order_status']=='Paid' || $content['order_status']=='waiting for approval')) {?>style="color:#FF0000"<? }?> ><?=$content['artist']?></td>
                      <td align="left" class="table_details" <? if($deadline[0]<$deadline['today']&&($content['order_status']=='Paid' || $content['order_status']=='waiting for approval')) {?>style="color:#FF0000"<? }?> ><?=$content['customer']?></td>
                      <td align="left" class="table_details" <? if($deadline[0]<$deadline['today']&&($content['order_status']=='Paid' || $content['order_status']=='waiting for approval')) {?>style="color:#FF0000"<? }?> ><? if($content['order_status']=='Refunded'){echo '(';}?><?=number_format(round($content['order_wholesale_price'],2),2)?><? if($content['order_status']=='Refunded'){echo ')';}?></td>
                      <td align="left" class="table_details" <? if($deadline[0]<$deadline['today']&&($content['order_status']=='Paid' || $content['order_status']=='waiting for approval')) {?>style="color:#FF0000"<? }?> ><? if($content['order_status']=='Refunded'){echo '(';}?><?=number_format($content['order_price'],2);?><? if($content['order_status']=='Refunded'){echo ')';}?></td>
                      <td align="left" class="table_details" <? if($deadline[0]<$deadline['today']&&($content['order_status']=='Paid' || $content['order_status']=='waiting for approval')) {echo'style="color:#FF0000"'; }if($content['order_status']=="Completed"){echo 'style="color:#00FF00"';}?> ><?=$content['order_status']?></td>
                      <td align="left" class="table_details" <? if($deadline[0]<$deadline['today']&&($content['order_status']=='Paid' || $content['order_status']=='waiting for approval')) {?>style="color:#FF0000"<? }?> ><? echo date('m-d-Y',strtotime($content['order_date']))?></td>
                      <td align="center" class="table_details" <? if($deadline[0]<$deadline['today']&&($content['order_status']=='Paid' || $content['order_status']=='waiting for approval')) {?>style="color:#FF0000"<? }?> ><? if($content['order_status']=='Completed'||$content['order_status']=='artist paid'){ echo date('m-d-Y',strtotime($content['order_completed_date']));}else {echo '-';}?></td>
                      <td align="left" class="table_details"><a href="order_details.php?order_id=<?=$content['order_id'];?>"><img border="0" src="images/edit.png" title="View Deatils" alt="View Deatils"/></a><a onclick="return show_confirm()" href="orders.php?order_id=<?=$content['order_id'];?>&del"><img border="0" src="images/delete.png" title="Delete this Order" alt="Delete this Order"/></a><a href="toonist_messaging.php?ord_id=<?=$content['order_id']?>"><img border="0" src="images/chat.png" title="Chat" alt="Chat"/></a></td>
                    </tr>
                   
                   <? 
                   if($content['order_status']=='Refunded')
                   {
                   $whole_sale_total-=$content['order_wholesale_price'];
                    $total-=$content['order_price'];
                   }
                   else
                   {
                    $whole_sale_total+=$content['order_wholesale_price'];
                    $total+=$content['order_price'];
                    }
                    if($content['order_status']=='Completed'||$content['order_status']=='artist paid')
                    {
                    $complted=date('m-d-Y',strtotime($content['order_completed_date']));
                    }
                    else 
                    {
                    $complted='-';
                    }
                    $excel_content=$content['order_id']."\t".$content['artist']."\t".$content['customer']."\t".round($content['order_wholesale_price'],2)."\t".number_format($content['order_price'],2)."\t".$content['order_status']."\t".date('m-d-Y',strtotime($content['order_date']))."\t".$complted."\t <:nextline:>";
                    $i++;
                    ?>
                   <input type="hidden" value="<? echo str_replace('"',"",$excel_content);?>" name="excel_data<?=$i?>" />
                    <?
                   }?>
                   <input type="hidden" name="content_no" value="<?=$i?>" />
                   <input type="hidden" name="whole_sale" value="<?=round($whole_sale_total,2)?>" />
                   <input type="hidden" name="retail_sale" value="<?=round($total,2)?>" />
                   <tr>
                        <td colspan="9">&nbsp;</td>
                   </tr>
                    <tr>
                        <td></td><td></td><td class="table_details"><b>Total :</b></td><td class="table_details"><b>$&nbsp;<?=number_format(round($whole_sale_total,2),2);?></b></td><td class="table_details"><b>$&nbsp;<?=number_format(round($total,2),2);?></b></td><td></td><td></td><td></td><td></td>
                    </tr>
                    <tr>
                      <td height="40" colspan="7"></td><td><input type="submit" name="download" value="Download" /></td>
                    </tr>
                    <tr>
                      <td height="40" colspan="4"></td>
                    </tr>
                  </table>
      			</form>
	    <? }else
			{?>
				<table align="center">
			<tr>
				<td class="no_details_msg">No orders submitted</td>
			</tr>
		</table>
			<? } ?>
	   </td>
      <td width="2%">&nbsp;</td>
    </tr>
      <tr><td height="40" colspan="4"></td></tr>
   </table>
  </td>
 </tr>
</table>
<?	include("includes/footer.php");?>