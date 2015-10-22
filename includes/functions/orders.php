<?
		function price($no_people=NULL,$pdct_id,$pcode,$props)
		{
			if(!$no_people) {
				$no_people=1;
			}
			$price_query	= mysql_query("SELECT * FROM `toon_products` WHERE `product_id`='$pdct_id'");
			$price_row		= mysql_fetch_array($price_query);
			//$pcode_query=mysql_query("SELECT * FROM `toon_promo` WHERE `promo_code`='$pcode' AND promo_expiry > current_date() AND `promo_product_type`='Toon product'");
			$pcode_query	= mysql_query("SELECT * FROM `toon_promo` WHERE `promo_code`='$pcode' AND current_date() BETWEEN `promo_start_date` AND `promo_expiry` AND `promo_product_type`='Toon product' AND `promo_isused` = '0'");			
			$pcode_row		= mysql_fetch_array($pcode_query);
			
			$spo_query 		= mysql_query("SELECT * FROM `toon_special_offers` WHERE current_date() BETWEEN `spo_startdate` AND `spo_enddate` AND `spo_product`='Toon product'");
			$number_spo		= mysql_num_rows($spo_query);	
			$row_spo 		= mysql_fetch_assoc($spo_query);
			$spc_query 		= mysql_query("SELECT * FROM `toon_special_coupons` WHERE `spc_code`='$pcode' AND `spc_product`='Toon product' AND `spc_isused` = '0'");
			$number_spc		= mysql_num_rows($spc_query);	
			$row_spc 		= mysql_fetch_assoc($spc_query);
			
			if($number_spc > 0)
			{
			 	$total 		= $row_spc['spc_product_price'];
			 	$discount 	= 0;
			 	$balance	= $total-$discount; 
				$total		= round($total,2);
				$discount	= round($discount,2);
				$balance	= round($balance,2);
				echo "Here: " . $discount;
				return $price_details=array("$total","$discount","$balance");
			} else {
			 	
				$price=$price_row['product_price'];
				if($no_people > 1)
					$price = $price +($price_row['product_additionalCopy_price']*($no_people-1));
				//$price = $price + ($price_row['product_price']*($no_people-1));
				if($props > 1)
					$price = $price +($price_row['product_additionalCopy_price']*($props-1));
				//$price = $price + ($price_row['product_price']*($props-1));
				
				$total=	$price;
				if($pcode_row['promo_discount']!=0 && $pcode_row['promo_discount']!='' && ($pcode_row['promo_discount']>$row_spo['spo_discount']))
				{
					if($total>$pcode_row['promo_amount'])
					{
						if($pcode_row['promo_type']==0)
						{
							$discount	= ($price*$pcode_row['promo_discount'])/100;
						}
						else
						{
							$discount	= $pcode_row['promo_discount'];
						}
					}
					else
					{
						if($number_spo!=0)
						{
							$discount	= $total*($row_spo['spo_discount']/100);
						}
						else
						{
							$discount	= 0;
						}
					}
					$balance	= $total-$discount; 
					$total		= round($total,2);
					$discount	= round($discount,2);
					$balance	= round($balance,2);
					return $price_details=array("$total","$discount","$balance");
				}
				else
				{
					if($number_spo!=0)
					{
						$discount	= $total*($row_spo['spo_discount']/100);
						$balance	= $total-$discount;
					}
					else
					{
						$balance	= $total;
						$discount	= 0;
					}
					$total		= round($total,2);
					$discount	= round($discount,2);
					$balance	= round($balance,2);
					return $price_details=array("$total","$discount","$balance");
				}
			}
		}
		
		function rsum($v, $w)
		{
			$v += $w['totalprice'];
			round($v,2);
			return $v;
		}
		
		function ezprice_details()
		{
			$u_id=$_SESSION['sess_tt_uid'];
			
			$cartarray_rs=mysql_query("SELECT * FROM `toon_cart` WHERE `user_id`=$u_id AND `cart_status`='active'");
			$cartarray_row=mysql_fetch_assoc($cartarray_rs);
			$cart=unserialize(base64_decode($cartarray_row['cart_array']));
			$total_product_price=array_reduce($cart, "rsum");
			$pcode=$cartarray_row['promo_code'];
			if($pcode!="")
				{
					$pcode_query=mysql_query("SELECT * FROM `toon_promo` WHERE `promo_code`='$pcode' AND current_date() BETWEEN `promo_start_date` AND `promo_expiry` AND `promo_product_type`='ez product' AND `promo_isused` = '0'");
					//$pcode_query=mysql_query("SELECT * FROM `toon_promo` WHERE `promo_code`='$pcode' AND current_date() >= `promo_start_date` AND current_date() <= `promo_expiry` AND `promo_product_type`='ez product' AND `promo_isused` = '0'");
					$pcode_row=mysql_fetch_array($pcode_query);
					
					$spc_query = mysql_query("SELECT * FROM `toon_special_coupons` WHERE `spc_code`='$pcode' AND `spc_product`='ez product' AND `spc_isused` = '0'");
					$number_spc=mysql_num_rows($spc_query);	
					$row_spc = mysql_fetch_array($spc_query);
					
					if($number_spc > 0)
					{
						$discount=0;
						$total_product_price = $row_spc['spc_product_price'];
					} else {
			
						if($pcode_row['promo_discount']!=0 && $pcode_row['promo_discount']!='')
						{
							if($total_product_price>$pcode_row['promo_amount'])
							{
								if($pcode_row['promo_type']==0)
									{
										$discount=($total_product_price* $pcode_row['promo_discount'])/100;
									}
								else
									{
										$discount=$pcode_row['promo_discount'];
									}
							}
						}
				   		else
						{
							$discount=0;
						}
					}
					
				}
			else
				{
					$spo_ez_query = mysql_query("SELECT * FROM `toon_special_offers` WHERE current_date() BETWEEN `spo_startdate` AND `spo_enddate` AND `spo_product`='ez product'");
					$number_spo_ez = mysql_num_rows($spo_ez_query);
					$spo_ez_row = mysql_fetch_assoc($spo_ez_query);
					if($number_spo_ez!=0)
					{
						$discount = ($total_product_price* $spo_ez_row['spo_discount'])/100;
					}
					else
					{
					$discount=0;
					}
				}
				
				$total_product_price=round($total_product_price,2);
				$discount=round($discount,2);
				
				$pricedetails=array();
				$pricedetails['totalprice']=$total_product_price;
				$pricedetails['discount']=$discount;
				return($pricedetails);
				
		}
?>
