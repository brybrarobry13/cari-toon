<?
include('includes/configuration.php');

$select_artist="SELECT * FROM `toon_users` WHERE `utype_id`=2 AND `user_delete`=0";
$details_artist = mysql_query($select_artist);
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
     <tr class="table_titlebar"><td class="main_heading" width="100%" colspan="4">Artists</td></tr>
      <tr><td height="40px;"></td></tr>
      <tr>
      	<td width="2%">&nbsp;</td>
      	<td align="center">
		<?
			$count=mysql_num_rows($details_artist);
			if ($count)
			{?>
         <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="heading_bg">
              <td class="sub_heading">Artist</td>
              <td class="sub_heading">Products</td>
          </tr>
           <tr><td colspan="2" height="5"></td></tr>
           <?
           while($artists=mysql_fetch_assoc($details_artist))
           {?>
           <tr><td colspan="2" height="5"></td></tr>
            <tr>
              <td align="left" class="table_details"><?=$artists['user_fname'].' '.$artists['user_lname']?></td>
              <td align="left" class="table_details"><a href="list_artist_products.php?artist=<?=$artists['user_id']?>">Show Products</a></td>
            </tr>
           <? }?>
            
            <tr>
              <td height="40" colspan="4"></td>
            </tr>
          </table>
	    <? }else
			{?>
          <table align="center">
                <tr>
                    <td class="no_details_msg">No artist registered so far</td>
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