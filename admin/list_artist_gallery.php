<?
include('includes/configuration.php');
$user = $_REQUEST['artist'];
$img_id=$_REQUEST['img_id'];
if($img_id)
{	
	$query="select * from toon_artist_gallery where agal_id='$img_id'";
	$img_name=mysql_fetch_array(mysql_query($query));
	mysql_query("delete from toon_artist_gallery where agal_id='$img_id'");
	@unlink(DIR_ARTIST_GALLERY.$img_name['agal_image']);
	@unlink(DIR_ARTIST_GALLERY.$img_name['opro_image']);
}
$artist_name=mysql_fetch_assoc(mysql_query("SELECT `user_fname` FROM `toon_users` WHERE `user_id`='$user'"));
$artist=artist_gallery($user);
include ('includes/header.php');
?>
<link rel="stylesheet" type="text/css" href="../styles/highslide.css" />
<script type="text/javascript" src="../javascripts/highslide-with-html.js"></script>
<script type="text/javascript">
	hs.graphicsDir = '../images/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.numberPosition = 'caption';
	hs.dimmingOpacity = 0.75;

	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
	function show_confirm()
	{
		var r=confirm("Do you really want to delete this image?");
		return r;
    
	}
	</script>
<table cellpadding="0" cellspacing="10" border="0" width="97%">
 <tr>
  <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
  <td align="center"  valign="top">
    <table cellpadding="0" cellspacing="0" width="100%" class="table_border">
     <tr class="table_titlebar"><td class="main_heading" width="100%" colspan="4"><?=$artist_name['user_fname']?>
            's Gallery</td></tr>
      <?php /*?><tr>
          <td height="40" colspan="2" align="right" style="padding-right:18px;"><input type="submit" name="submit" value="Add To Gallery"onclick="window.location='add_gal.php?artist=<?=$user;?>'" /></td>

        </tr><?php */?>
       <tr><td height="10"></td></tr> 
      <tr>
      	<td width="2%">&nbsp;</td>
      	<td align="center">
		<?
			$count=count($artist);
			if ($count)
			{?>
		    <table cellpadding="0" cellspacing="0" width="100%" >

      <tr>
       <? 
	   $j=1;
	   $i=0;
	   while($artist[$i])
	   {	//$imgpath=DIR_CARICATURE_IMAGES;
	   ?>
       	  <? if($artist[$i]['opro_image']!=""){
		  		$j++;
				//$imgpath=DIR_CART_IMAGES;
		  ?>
          <td>
         	 <a href="<?=DIR_ARTIST_GALLERY.$artist[$i]['opro_image']?>" onclick="return hs.expand(this)"><img src="<? echo '../includes/imageProcess.php?image='.$artist[$i]['opro_image'].'&type=artist&size=100' ?>" border="0" /></a>
          	 <div class="img_text"><?=$artist[$i]['agal_code']?></div>
          </td>
		  <? }?>
          <td>
         	 <a href="<?=DIR_ARTIST_GALLERY.$artist[$i]['agal_image']?>" onclick="return hs.expand(this)"><img src="<? echo '../includes/imageProcess.php?image='.$artist[$i]['agal_image'].'&type=artist&size=100' ?>" border="0" /></a><a onclick="return show_confirm()" href="list_artist_gallery.php?img_id=<?=$artist[$i]['agal_id'];?>&artist=<?=$user;?>"><img border="0" src="images/delete.png" title="Delete this image" alt="Delete this image"/></a>
          </td>
          
          
       <?
	   $i++; 
	   if($j%4==0)
	   {
	   	echo "</tr><tr><td colspan='4' height='10'></td></tr><tr>";
	   }
	   $j++;
	   }?>
       </tr> 
        <tr>
          <td height="40" colspan="4"></td>
        </tr>
      </table>
	    <? }else
			{?>
				<table align="center">
			<tr>
				<td class="no_details_msg">No images in the gallery.</td>
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
