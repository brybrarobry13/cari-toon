<?
include('includes/configuration.php');
$img_id =$_REQUEST['img_id'];
$del=$_REQUEST['del'];

if($img_id && $del)
{
	$del = mysql_query("delete FROM `toon_img_phrase` WHERE `img_id`='$img_id'");
}

$sele="SELECT * FROM `toon_img_phrase`";
$result=mysql_query($sele);



include ('includes/header.php');
?>
<script>
function confirmation()
{
	if(confirm("Do you really want to delete?"))
	{
		return true;
	}
	return false;	
}
</script>
<table cellpadding="0" cellspacing="10" border="0" width="97%">
  <tr>
    <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
	<td align="center" valign="top">
	  <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
	   <tr class="table_titlebar">
	   <td class="main_heading" height="30" colspan="4">Caricature Phrases</td>
	   </tr>
	    <tr>
	 <td height="40" colspan="2" align="right" style="padding-right:18px;">
	 <input type="submit" name="submit" value="Add Phrase"onclick="window.location='edit_phrase.php'" /></td>
		</tr>
		
		  <tr>
          <td width="1%">&nbsp;</td>
          <td width="94%" align="center">
		  <? $number=mysql_num_rows($result);
		  if ($number!=0)
		{
		  
		  ?>
		  <form action="" method="post" name="phrases">
		   <table cellpadding="4" cellspacing="0" width="95%" class="table_border" border="0" >
		   <tr class="heading_bg">
		   <td class="sub_heading" height="30">Caricature Description</td>
		   <td class="sub_heading" height="30">Actions</td>
		   </tr>
		    <?
		   while($row=mysql_fetch_assoc($result))
		   {
				$id = $row['img_id'];
				$description = $row['img_phrase'];
		   ?>
		       <tr>
			   <td align="left" class="table_details"><?=$row['img_phrase'];?></td>
			   <td align="left" class="table_details"><a href="edit_phrase.php?img_id=<?=$row['img_id'];?>" class="anger_tags">
			   <img border="0" src="images/edit.png" title="Modify this Phrase" alt="Modify this Phrase" /></a> 
			   <a onclick="return confirmation()"href="img_phrases.php?img_id=<?=$row['img_id'];?>&del=1">
			   <img border="0" src="images/delete.png" title="Delete this Phrase" alt="Delete this Phrase"/></a></td>
			   </tr><? }?>
		   </table>
		  </form><? }?>
		  </td>
		  </tr>
		  
	  </table>
	</td>
   </tr> 
 </table>
<?	include("includes/footer.php");?>