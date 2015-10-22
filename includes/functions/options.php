<?
	function getoption_values($option,$opt_id=NULL,$add=NULL)
	{
		switch($option)
		{
			case "image_types":
								$values = array('0' => 'bmp',
												'1' => 'gif',
												'2' => 'jpeg',
												'3' => 'png',
												'4' => 'tiff',
												'5' => 'wbmp',
												'6' => 'jpg');
			break;
			
			case "state": 		if($add=='CAN'||$add=='CA'){
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
													"YT"       =>       "Yukon");}
								else
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
													"YT"       =>       "Yukon");
								break;
		
		case "country": 		$values = array("AFG" => "AFGHANISTAN",
												"DZA" => "ALGERIA",
												"ASM" => "AMERICAN SAMOA",
												"AND" => "ANDORRA",
												"AIA" => "ANGUILLA",
												"ATG" => "ANTIGUA AND BARBUDA",
												"ARG" => "Argentina",
												"ARM" => "ARMENIA",
												"ABW" => "Aruba",
												"AUS" => "Australia",
												"AUT" => "Austria",
												"AZE" => "AZERBAIJAN",
												"BHS" => "Bahamas",
												"BHR" => "BAHRAIN",
												"BGD" => "BANGLADESH",
												"BRB" => "Barbados",
												"BLR" => "BELARUS",
												"BEL" => "Belgium",
												"BLZ" => "BELIZE",
												"BEN" => "BENIN",
												"BMU" => "Bermuda",
												"BTN" => "BHUTAN",
												"BOL" => "BOLIVIA",
												"BIH" => "BOSNIA AND HERZEGOWINA",
												"BWA" => "BOTSWANA",
												"BRA" => "Brazil",
												"BRN" => "BRUNEI DARUSSALAM",
												"BGR" => "BULGARIA",
												"BFA" => "BURKINA FASO",
												"BDI" => "BURUNDI",
												"KHM" => "CAMBODIA",
												"CMR" => "CAMEROON",
												"CAN" => "CANADA",
												"CPV" => "CAPE VERDE",
												"CYM" => "CAYMAN ISLANDS",
												"CAF" => "CENTRAL AFRICAN REPUBLIC",
												"TCD" => "CHAD",
												"CHL" => "Chile",
												"CHN" => "China",
												"CXR" => "CHRISTMAS ISLAND",
												"CCK" => "COCOS (KEELING) ISLANDS",
												"COL" => "Colombia",
												"COG" => "CONGO",
												"COK" => "COOK ISLANDS",
												"CRI" => "Costa Rica",
												"CIV" => "COTE D&apos;IVOIRE",
												"HRV" => "CROATIA (local name: Hrvatska)",
												"CYP" => "Cyprus",
												"CZE" => "Czech Republic",
												"DNK" => "Denmark",
												"DJI" => "DJIBOUTI",
												"DMA" => "DOMINICA",
												"DOM" => "DOMINICAN REPUBLIC",
												"TLS" => "EAST TIMOR",
												"ECU" => "ECUADOR",
												"EGY" => "EGYPT",
												"SLV" => "EL SALVADOR",
												"GNQ" => "EQUATORIAL GUINEA",
												"ERI" => "ERITREA",
												"EST" => "Estonia",
												"ETH" => "ETHIOPIA",
												"FLK" => "FALKLAND ISLANDS (MALVINAS)",
												"FRO" => "FAROE ISLANDS",
												"FJI" => "FIJI",
												"FIN" => "Finland",
												"FRA" => "France",
												"FXX" => "FRANCE, METROPOLITAN",
												"GUF" => "FRENCH GUIANA",
												"PYF" => "FRENCH POLYNESIA",
												"GAB" => "GABON",
												"GMB" => "GAMBIA",
												"GEO" => "GEORGIA",
												"DEU" => "Germany",
												"GHA" => "GHANA",
												"GIB" => "GIBRALTAR",
												"GRC" => "Greece",
												"GRL" => "GREENLAND",
												"GRD" => "GRENADA",
												"GLP" => "GUADELOUPE",
												"GUM" => "GUAM",
												"GTM" => "GUATEMALA",
												"GIN" => "GUINEA",
												"GNB" => "GUINEA-BISSAU",
												"GUY" => "Guyana",
												"HTI" => "HAITI",
												"HND" => "HONDURAS",
												"HKG" => "Hong Kong",
												"HUN" => "Hungary",
												"ISL" => "Iceland",
												"IND" => "India",
												"IDN" => "Indonesia",
												"IRQ" => "IRAQ",
												"IRL" => "Ireland",
												"ISR" => "Israel",
												"ITA" => "Italy",
												"JAM" => "Jamaica",
												"JPN" => "Japan",
												"JOR" => "JORDAN",
												"KAZ" => "Kazakhstan",
												"KEN" => "KENYA",
												"KIR" => "KIRIBATI",
												"KOR" => "Korea",
												"KWT" => "KUWAIT",
												"KGZ" => "KYRGYZSTAN",
												"LAO" => "LAO PEOPLE&apos;S DEMOCRATIC REPUBLIC",
												"LVA" => "LATVIA",
												"LBN" => "LEBANON",
												"LSO" => "LESOTHO",
												"LBR" => "LIBERIA",
												"LIE" => "Liechtenstein",
												"LTU" => "LITHUANIA",
												"LUX" => "Luxembourg",
												"MAC" => "Macau",
												"MKD" => "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF",
												"MDG" => "MADAGASCAR",
												"MWI" => "MALAWI",
												"MYS" => "Malaysia",
												"MDV" => "MALDIVES",
												"MLI" => "MALI",
												"MLT" => "Malta",
												"MHL" => "MARSHALL ISLANDS",
												"MTQ" => "MARTINIQUE",
												"MRT" => "MAURITANIA",
												"MUS" => "MAURITIUS",
												"MYT" => "MAYOTTE",
												"MEX" => "Mexico",
												"FSM" => "MICRONESIA, FEDERATED STATES OF",
												"MDA" => "MOLDOVA, REPUBLIC OF",
												"MCO" => "MONACO",
												"MNG" => "MONGOLIA",
												"MNE" => "Montenegro",
												"MSR" => "MONTSERRAT",
												"MAR" => "MOROCCO",
												"MOZ" => "MOZAMBIQUE",
												"MMR" => "MYANMAR",
												"NAM" => "NAMIBIA",
												"NPL" => "NEPAL",
												"NLD" => "Netherlands",
												"ANT" => "NETHERLANDS ANTILLES",
												"NCL" => "NEW CALEDONIA",
												"NZL" => "New Zealand",
												"NIC" => "NICARAGUA",
												"NER" => "NIGER",
												"NIU" => "NIUE",
												"NFK" => "NORFOLK ISLAND",
												"MNP" => "NORTHERN MARIANA ISLANDS",
												"NOR" => "Norway",
												"OMN" => "OMAN",
												"PAK" => "PAKISTAN",
												"PLW" => "PALAU",
												"PAN" => "PANAMA",
												"PNG" => "PAPUA NEW GUINEA",
												"PRY" => "PARAGUAY",
												"PER" => "Peru",
												"PHL" => "Philippines",
												"PCN" => "PITCAIRN",
												"POL" => "Poland",
												"PRT" => "Portugal",
												"PRI" => "PUERTO RICO",
												"QAT" => "QATAR",
												"REU" => "REUNION",
												"ROU" => "ROMANIA",
												"RUS" => "Russian Federation",
												"RWA" => "RWANDA",
												"KNA" => "SAINT KITTS AND NEVIS",
												"LCA" => "SAINT LUCIA",
												"VCT" => "SAINT VINCENT AND THE GRENADINES",
												"WSM" => "SAMOA",
												"SMR" => "SAN MARINO",
												"STP" => "SAO TOME AND PRINCIPE",
												"SAU" => "Saudi Arabia",
												"SEN" => "SENEGAL",
												"SRB" => "Serbia",
												"SYC" => "SEYCHELLES",
												"SGP" => "Singapore",
												"SVK" => "SLOVAKIA (Slovak Republic)",
												"SVN" => "Slovenia",
												"SLB" => "SOLOMON ISLANDS",
												"ZAF" => "South Africa",
												"SGS" => "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS",
												"ESP" => "Spain",
												"LKA" => "Sri Lanka",
												"SHN" => "ST. HELENA",
												"SPM" => "ST. PIERRE AND MIQUELON",
												"SUR" => "SURINAME",
												"SWZ" => "SWAZILAND",
												"SWE" => "Sweden",
												"CHE" => "Switzerland",
												"TWN" => "Taiwan",
												"TZA" => "TANZANIA, UNITED REPUBLIC OF",
												"THA" => "Thailand",
												"TGO" => "TOGO",
												"TKL" => "TOKELAU",
												"TON" => "TONGA",
												"TTO" => "Trinidad and Tobago",
												"TUN" => "TUNISIA",
												"TUR" => "Turkey",
												"TKM" => "TURKMENISTAN",
												"TCA" => "Turks and Caicos Islands",
												"TUV" => "TUVALU",
												"UGA" => "UGANDA",
												"UKR" => "UKRAINE",
												"ARE" => "UNITED ARAB EMIRATES",
												"GBR" => "United Kingdom",
												"USA" => "United States",
												"URY" => "URUGUAY",
												"UZB" => "UZBEKISTAN",
												"VUT" => "VANUATU",
												"VAT" => "VATICAN CITY STATE (HOLY SEE)",
												"VEN" => "Venezuela",
												"VNM" => "Viet Nam",
												"VGB" => "VIRGIN ISLANDS (BRITISH)",
												"VIR" => "VIRGIN ISLANDS (U.S.)",
												"WLF" => "WALLIS AND FUTUNA ISLANDS",
												"YEM" => "YEMEN",
												"ZRE" => "ZAIRE",
												"ZMB" => "ZAMBIA",
												"ZWE" => "ZIMBABWE");

								break;	
				case "bill_country": 		$values = array ('AF' => 'Afghanistan',
												'AL' => 'Albania',
												'DZ' => 'Algeria',
												'AS' => 'American Samoa',
												'AD' => 'Andorra',
												'AO' => 'Angola',
												'AI' => 'Anguilla',
												'AQ' => 'Antarctica',
												'AG' => 'Antigua and Barbuda',
												'AR' => 'Argentina',
												'AM' => 'Armenia',
												'AW' => 'Aruba',
												'AU' => 'Australia',
												'AT' => 'Austria',
												'AZ' => 'Azerbaijan',
												'BS' => 'Bahamas',
												'BH' => 'Bahrain',
												'BD' => 'Bangladesh',
												'BB' => 'Barbados',
												'BY' => 'Belarus',
												'BE' => 'Belgium',
												'BZ' => 'Belize',
												'BJ' => 'Benin',
												'BM' => 'Bermuda',
												'BT' => 'Bhutan',
												'BO' => 'Bolivia',
												'BA' => 'Bosnia and Herzegowina',
												'BW' => 'Botswana',
												'BV' => 'Bouvet Island',
												'BR' => 'Brazil',
												'IO' => 'British Indian Ocean Territory',
												'BN' => 'Brunei Darussalam',
												'BG' => 'Bulgaria',
												'BF' => 'Burkina Faso',
												'BI' => 'Burundi',
												'KH' => 'Cambodia',
												'CM' => 'Cameroon',
												'CA' => 'CANADA',
												'CV' => 'Cape Verde',
												'KY' => 'Cayman Islands',
												'CF' => 'Central African Republic',
												'TD' => 'Chad',
												'CL' => 'Chile',
												'CN' => 'China',
												'CX' => 'Christmas Island',
												'CC' => 'Cocos (Keeling) Islands',
												'CO' => 'Colombia',
												'KM' => 'Comoros',
												'CG' => 'Congo',
												'CK' => 'Cook Islands',
												'CR' => 'Costa Rica',
												'CI' => 'Cote D\'Ivoire',
												'HR' => 'Croatia',
												'CU' => 'Cuba',
												'CY' => 'Cyprus',
												'CZ' => 'Czech Republic',
												'DK' => 'Denmark',
												'DJ' => 'Djibouti',
												'DM' => 'Dominica',
												'DO' => 'Dominican Republic',
												'TP' => 'East Timor',
												'EC' => 'Ecuador',
												'EG' => 'Egypt',
												'SV' => 'El Salvador',
												'GQ' => 'Equatorial Guinea',
												'ER' => 'Eritrea',
												'EE' => 'Estonia',
												'ET' => 'Ethiopia',
												'FK' => 'Falkland Islands (Malvinas)',
												'FO' => 'Faroe Islands',
												'FJ' => 'Fiji',
												'FI' => 'Finland',
												'FR' => 'France',
												'FX' => 'France, Metropolitan',
												'GF' => 'French Guiana',
												'PF' => 'French Polynesia',
												'TF' => 'French Southern Territories',
												'GA' => 'Gabon',
												'GM' => 'Gambia',
												'GE' => 'Georgia',
												'DE' => 'Germany',
												'GH' => 'Ghana',
												'GI' => 'Gibraltar',
												'GR' => 'Greece',
												'GL' => 'Greenland',
												'GD' => 'Grenada',
												'GP' => 'Guadeloupe',
												'GU' => 'Guam',
												'GT' => 'Guatemala',
												'GN' => 'Guinea',
												'GW' => 'Guinea-bissau',
												'GY' => 'Guyana',
												'HT' => 'Haiti',
												'HM' => 'Heard and Mc Donald Islands',
												'HN' => 'Honduras',
												'HK' => 'Hong Kong',
												'HU' => 'Hungary',
												'IS' => 'Iceland',
												'IN' => 'India',
												'ID' => 'Indonesia',
												'IR' => 'Iran (Islamic Republic of)',
												'IQ' => 'Iraq',
												'IE' => 'Ireland',
												'IL' => 'Israel',
												'IT' => 'Italy',
												'JM' => 'Jamaica',
												'JP' => 'Japan',
												'JO' => 'Jordan',
												'KZ' => 'Kazakhstan',
												'KE' => 'Kenya',
												'KI' => 'Kiribati',
												'KP' => 'Democratic People\'s Republic of Korea',
												'KR' => 'Republic of Korea',
												'KW' => 'Kuwait',
												'KG' => 'Kyrgyzstan',
												'LA' => 'Lao People\'s Democratic Republic',
												'LV' => 'Latvia',
												'LB' => 'Lebanon',
												'LS' => 'Lesotho',
												'LR' => 'Liberia',
												'LY' => 'Libyan Arab Jamahiriya',
												'LI' => 'Liechtenstein',
												'LT' => 'Lithuania',
												'LU' => 'Luxembourg',
												'MO' => 'Macau',
												'MK' => 'Macedonia, The Former Yugoslav Republic of',
												'MG' => 'Madagascar',
												'MW' => 'Malawi',
												'MY' => 'Malaysia',
												'MV' => 'Maldives',
												'ML' => 'Mali',
												'MT' => 'Malta',
												'MH' => 'Marshall Islands',
												'MQ' => 'Martinique',
												'MR' => 'Mauritania',
												'MU' => 'Mauritius',
												'YT' => 'Mayotte',
												'MX' => 'Mexico',
												'FM' => 'Micronesia, Federated States of',
												'MD' => 'Moldova, Republic of',
												'MC' => 'Monaco',
												'MN' => 'Mongolia',
												'MS' => 'Montserrat',
												'MA' => 'Morocco',
												'MZ' => 'Mozambique',
												'MM' => 'Myanmar',
												'NA' => 'Namibia',
												'NR' => 'Nauru',
												'NP' => 'Nepal',
												'NL' => 'Netherlands',
												'AN' => 'Netherlands Antilles',
												'NC' => 'New Caledonia',
												'NZ' => 'New Zealand',
												'NI' => 'Nicaragua',
												'NE' => 'Niger',
												'NG' => 'Nigeria',
												'NU' => 'Niue',
												'NF' => 'Norfolk Island',
												'MP' => 'Northern Mariana Islands',
												'NO' => 'Norway',
												'OM' => 'Oman',
												'PK' => 'Pakistan',
												'PW' => 'Palau',
												'PA' => 'Panama',
												'PG' => 'Papua New Guinea',
												'PY' => 'Paraguay',
												'PE' => 'Peru',
												'PH' => 'Philippines',
												'PN' => 'Pitcairn',
												'PL' => 'Poland',
												'PT' => 'Portugal',
												'PR' => 'Puerto Rico',
												'QA' => 'Qatar',
												'RE' => 'Reunion',
												'RO' => 'Romania',
												'RU' => 'Russian Federation',
												'RW' => 'Rwanda',
												'KN' => 'Saint Kitts and Nevis',
												'LC' => 'Saint Lucia',
												'VC' => 'Saint Vincent and the Grenadines',
												'WS' => 'Samoa',
												'SM' => 'San Marino',
												'ST' => 'Sao Tome and Principe',
												'SA' => 'Saudi Arabia',
												'SN' => 'Senegal',
												'SC' => 'Seychelles',
												'SL' => 'Sierra Leone',
												'SG' => 'Singapore',
												'SK' => 'Slovakia (Slovak Republic)',
												'SI' => 'Slovenia',
												'SB' => 'Solomon Islands',
												'SO' => 'Somalia',
												'ZA' => 'South Africa',
												'GS' => 'South Georgia and the South Sandwich Islands',
												'ES' => 'Spain',
												'LK' => 'Sri Lanka',
												'SH' => 'St. Helena',
												'PM' => 'St. Pierre and Miquelon',
												'SD' => 'Sudan',
												'SR' => 'Suriname',
												'SJ' => 'Svalbard and Jan Mayen Islands',
												'SZ' => 'Swaziland',
												'SE' => 'Sweden',
												'CH' => 'Switzerland',
												'SY' => 'Syrian Arab Republic',
												'TW' => 'Taiwan',
												'TJ' => 'Tajikistan',
												'TZ' => 'Tanzania, United Republic of',
												'TH' => 'Thailand',
												'TG' => 'Togo',
												'TK' => 'Tokelau',
												'TO' => 'Tonga',
												'TT' => 'Trinidad and Tobago',
												'TN' => 'Tunisia',
												'TR' => 'Turkey',
												'TM' => 'Turkmenistan',
												'TC' => 'Turks and Caicos Islands',
												'TV' => 'Tuvalu',
												'UG' => 'Uganda',
												'UA' => 'Ukraine',
												'AE' => 'United Arab Emirates',
												'GB' => 'United Kingdom',
												'US' => 'United States',
												'UM' => 'United States Minor Outlying Islands',
												'UY' => 'Uruguay',
												'UZ' => 'Uzbekistan',
												'VU' => 'Vanuatu',
												'VA' => 'Vatican City State (Holy See)',
												'VE' => 'Venezuela',
												'VN' => 'Viet Nam',
												'VG' => 'Virgin Islands (British)',
												'VI' => 'Virgin Islands (U.S.)',
												'WF' => 'Wallis and Futuna Islands',
												'EH' => 'Western Sahara',
												'YE' => 'Yemen',
												'YU' => 'Yugoslavia',
												'ZR' => 'Zaire',
												'ZM' => 'Zambia',
												'ZW' => 'Zimbabwe' );

								break;
		}
		
		if($opt_id == NULL)
			return $values;
		else
			return $values[$opt_id];
	}
?>