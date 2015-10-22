
<?
function getoption_values($option)
	{
		if($option=='USA'||$option=='US'){
				$values = array("AL"       =>       "Alabama",
			"AK"       =>       "Alaska",
			"AS"       =>       "American Samoa",
			"AZ"       =>       "Arizona",
			"AR"       =>       "Arkansas",
			"AE"       =>       "Armed Forces Africa",
			"AA"       =>       "Armed Forces Americas",
			"AC"       =>       "Armed Forces Canada",
			"AE"       =>       "Armed Forces Europe",
			"AM"       =>       "Armed Forces Middle East",
			"AP"       =>       "Armed Forces Pacific",
			"CA"       =>       "California",
			"CO"       =>       "Colorado",
			"CT"       =>       "Connecticut",
			"DE"       =>       "Delaware",
			"DC"       =>       "District Of Columbia",
			"FM"       =>       "Fed. States Of Micronesia",
			"FP"       =>       "Fleet Post Office ",
			"FL"       =>       "Florida",
			"GA"       =>       "Georgia",
			"GU"       =>       "Guam",
			"HI"       =>       "Hawaii",
			"ID"       =>       "Idaho",
			"IL"       =>       "Illinois",
			"IN"       =>       "Indiana",
			"IA"       =>       "Iowa",
			"KS"       =>       "Kansas",
			"KY"       =>       "Kentucky",
			"LA"       =>       "Louisiana",
			"ME"       =>       "Maine",
			"MH"       =>       "Marshall Islands",
			"MD"       =>       "Maryland",
			"MA"       =>       "Massachusetts",
			"MI"       =>       "Michigan",
			"MN"       =>       "Minnesota",
			"MS"       =>       "Mississippi",
			"MO"       =>       "Missouri",
			"MT"       =>       "Montana",
			"NE"       =>       "Nebraska",
			"NV"       =>       "Nevada",
			"NH"       =>       "New Hampshire",
			"NJ"       =>       "New Jersey",
			"NM"       =>       "New Mexico",
			"NY"       =>       "New York",
			"NL"       =>       "Newfoundland and Labrador",
			"NC"       =>       "North Carolina",
			"ND"       =>       "North Dakota",
			"MP"       =>       "Northern Mariana Islands",
			"OH"       =>       "Ohio",
			"OK"       =>       "Oklahoma",
			"OR"       =>       "Oregon",
			"PW"       =>       "Palau",
			"PA"       =>       "Pennsylvania",
			"PR"       =>       "Puerto Rico",
			"RI"       =>       "Rhode Island",
			"SC"       =>       "South Carolina",
			"SD"       =>       "South Dakota",
			"TN"       =>       "Tennessee",
			"TX"       =>       "Texas",
			"UT"       =>       "Utah",
			"VT"       =>       "Vermont",
			"VI"       =>       "Virgin Islands",
			"VA"       =>       "Virginia",
			"WA"       =>       "Washington",
			"WV"       =>       "West Virginia",
			"WI"       =>       "Wisconsin",
			"WY"       =>       "Wyoming",
			"YK"       =>       "Yukon",
			"YT"       =>       "Yukon");}
        if($option=='CAN'||$option=='CA')	 {	
								$values = array ("AB"       =>       "Alberta",
			"BC"       =>       "British Columbia",
			"MB"       =>       "Manitoba",
			"NB"       =>       "New Brunswick",
			"NF"       =>       "Newfoundland",
			"NT"       =>       "Northwest Territory",
			"NS"       =>       "Nova Scotia",
			"NU"       =>       "Nunavut",
			"ON"       =>       "Ontario",
			"PE"       =>       "Prince Edward Island",
			"QC"       =>       "Quebec",
			"SK"       =>       "Saskatchewan",
			"YT"       =>       "Yukon");
						
					}
		if($option!=0&& $option!=1)	
					{
					$values = array ('NUS' => 'Non US State');
					}			
					
					return $values;
							
		
    }
$country=$_REQUEST['country'];
$type=$_REQUEST['type'];
$states=getoption_values($country); 

if($type!='ez')
{
	foreach($states as $key => $value)
		{
			$countrys.='<option value="'.$key.'" <? if($name==$user_row[user_country]) echo \'selected="selected"\';?> '.$value.'</option>';
		 }
	echo '<select name="bill_state" id="bill_state" style="width:196px;"><option value="">--Select State--</option>'.$countrys.'</select>';
 }
 else
 {
 	foreach($states as $key => $value)
		{
			$countrys.='<option value="'.$key.'" <? if($name==$ship_state) echo \'selected="selected"\';?> '.$value.'</option>';
		 }
		 echo '<select name="state" id="state" onblur="shipping_price()" style="width:196px;"><option value="">--Select State--</option>'.$countrys.'</select>';
 }
 ?>