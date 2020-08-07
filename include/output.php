<?php

/*---------- Output ----------*/
/**
* Define custom template for post type 
* TODO: bruk wp_list_categories i template for achive
* Ikke lag autofill hvis det ikke finnes poster
* Bruk filter[the_excerpt] på søkeresultater.
**/

$wpyr_default_css = "";




/*----- INJECT CSS -----*/
add_action('wp_head','wpyr_add_wp_head');
function wpyr_add_wp_head() {
	global $wpyr_default_css;
	$options = wpyr_get_option();
	
	echo "<style type\"text/css\" id=\"custom-wprs\">\n";
	echo $wpyr_default_css . "\n";
	$options = wpyr_get_option();
	if ( $options['wpyr_template_css_area'] != '' ) {
        $css_width  = $options['wpyr_gen_iconwidth_text'];
        $css_height = $options['wpyr_gen_iconheight_text'];
        $css_color  = $options['wpyr_gen_iconcolor_text'];
        $css_templ  = $options['wpyr_template_css_area'];
        $css_templ = str_replace(array('_width_','_height_','_color_'),array($css_width,$css_height,$css_color),$css_templ);
		echo $css_templ . "\n";
	}
	echo "</style>\n";
}


/*----- DEFAULT TEMPLATE -----*/
function wpyr_defaul_template () {
    $wpyr_templ  = '[@symbol]';
    $wpyr_templ .= '<p>[@description]<br><br>';
    $wpyr_templ .= '[@place]<br>';
    $wpyr_templ .= '[@date-time]<br>';
    $wpyr_templ .= '[Temperature]: [@temperature]&deg; [@temp-unit]<br>';
    $wpyr_templ .= '[Precipitation]: [@precipitation] mm<br>';
    $wpyr_templ .= '[Wind]: [@windSpeed] m/s [@windDirection] ([@windDegree]&deg;)<br>';
    $wpyr_templ .= '[Atmospheric-pressure]: [@pressure] [@pressure-scale] <br><br></p>';
	return $wpyr_templ;
}


/*----- LANGUAGE -----*/

function wpyr_translate_template($str) {
    $wpyr_Time = __( 'Time', 'yr-weather' );
	
    $wpyr_From = __( 'From', 'yr-weather' );
    $wpyr_Hour = __( 'Hour', 'yr-weather' );
    $wpyr_hours = __( 'hours', 'yr-weather' );
    $wpyr_Hours = __( 'Hours', 'yr-weather' );
    $wpyr_To = __( 'To', 'yr-weather' );
    $wpyr_Place = __( 'Place', 'yr-weather' );
    $wpyr_Precipitation = __( 'Precipitation', 'yr-weather' );
    $wpyr_Wind = __( 'Wind', 'yr-weather' );
    $wpyr_Windspeed = __( 'Windspeed', 'yr-weather' );
    $wpyr_Wind_direction = __( 'Wind-direction', 'yr-weather' );
    $wpyr_Temperature = __( 'Temperature', 'yr-weather' );
    $wpyr_Pressure = __( 'Pressure', 'yr-weather' );
    $wpyr_Air_pressure = __( 'Air pressure', 'yr-weather' );
    $wpyr_Atmospheric_pressure = __( 'Atmospheric pressure', 'yr-weather' );
    $wpyr_Barometric_pressure = __( 'Barometric pressure', 'yr-weather' );
    $wpyr_Altitude = __( 'Altitude', 'yr-weather' );
    $wpyr_MAS = __( 'MAS', 'yr-weather' );
    $wpyr_meters_above_sea = __( 'Meters above sea level', 'yr-weather' );
    $wpyr_Latitude = __( 'Latitude', 'yr-weather' );
    $wpyr_Longitude = __( 'Longitude', 'yr-weather' );
	$wpyr_Degrees = __( 'Degrees', 'yr-weather' );
	$wpyr_And = __( 'And', 'yr-weather' );
	$wpyr_In = __( 'In', 'yr-weather' );
	$wpyr_At = __( 'At', 'yr-weather' );
	$wpyr_Weather = __( 'Weather', 'yr-weather' );
	$wpyr_The_weather = __( 'The weather', 'yr-weather' );

    $ret_str = str_replace(
        array(
			'[time]','[Time]',
			'[from]','[From]',
			'[hour]','[Hour]',
			'[hours]','[Hours]',
			'[to]','[To]',
			'[place]','[Place]',
			'[precipitation]','[Precipitation]',
			'[wind]','[Wind]',
			'[windspeed]','[Windspeed]',
			'[wind-direction]','[Wind-direction]',
			'[temperature]','[Temperature]',
			'[pressure]','[Pressure]',
			'[air_pressure]','[Air-pressure]',
			'[atmospheric-pressure]','[Atmospheric-pressure]',
			'[barometric-pressure]','[Barometric-pressure]',
			'[altitude]','[Altitude]',
			'[MAS]',
			'[meters_above_sea]',
			'[latitude]','[Latitude]',
			'[longitude]','[Longitude]',
			'[and]','[And]',
			'[degrees]','[Degrees]',
			'[degree-symbol]',
			'[in]','[In]',
			'[at]','[At]',
			'[weather]','[Weather]',
			'[the-weather]','[The-weather]'
		),
		array( 
			strtolower($wpyr_Time),$wpyr_Time,
			strtolower($wpyr_From),$wpyr_From,
			strtolower($wpyr_Hour),$wpyr_Hour,
			strtolower($wpyr_Hours),$wpyr_Hours,
			strtolower($wpyr_To),$wpyr_To,
			strtolower($wpyr_Place),$wpyr_Place,
			strtolower($wpyr_Precipitation),$wpyr_Precipitation,
			strtolower($wpyr_Wind),$wpyr_Wind,
			strtolower($wpyr_Windspeed),$wpyr_Windspeed,
			strtolower($wpyr_Wind_direction),$wpyr_Wind_direction,
			strtolower($wpyr_Temperature),$wpyr_Temperature,
			strtolower($wpyr_Pressure),$wpyr_Pressure,
			strtolower($wpyr_Air_pressure),$wpyr_Air_pressure,
			strtolower($wpyr_Atmospheric_pressure),$wpyr_Atmospheric_pressure,
			strtolower($wpyr_Barometric_pressure),$wpyr_Barometric_pressure,
			strtolower($wpyr_Altitude),$wpyr_Altitude,
			$wpyr_MAS,
			$wpyr_meters_above_sea,
			strtolower($wpyr_Latitude),$wpyr_Latitude,
			strtolower($wpyr_Longitude),$wpyr_Longitude,
			strtolower($wpyr_And),$wpyr_And,
			strtolower($wpyr_Degrees),$wpyr_Degrees,
			"&deg;",
			strtolower($wpyr_In),$wpyr_In,
			strtolower($wpyr_At),$wpyr_At,
			strtolower($wpyr_Weather),$wpyr_Weather,
			strtolower($wpyr_The_weather),$wpyr_The_weather
		),
        $str);

    return $ret_str;
}


function wpyr_translate_description($str,$small=false) {
    $clearsky =  __("Clear sky", 'yr-weather');
    $fair =  __("Fair", "yr-weather");
    $partlycloudy =  __("Partly cloudy", "yr-weather");
    $cloudy =  __("Cloudy", "yr-weather");
    $lighshowers =  __("Light rain showers", "yr-weather");
    $rainshowers =  __("Rain showers", "yr-weather");
    $heavyshowers =  __("Heavy rain showers", "yr-weather");
    $lightshowersthunder =  __("Light rain showers and thunder", "yr-weather");
    $rainshowersthunder =  __("Rain showers and thunder", "yr-weather");
    $heavyshowersthunder =  __("Heavy rain showers and thunder", "yr-weather");
    $lightsleetshower =  __("Light sleet showers", "yr-weather");
    $sleetshower =  __("Sleet showers", "yr-weather");
    $heavysleetshower =  __("Heavy sleet showers", "yr-weather");
    $lightsleetshowerthunder =  __("Light sleet showers and thunder", "yr-weather");
    $sleetshowerthunder =  __("Sleet showers and thunder", "yr-weather");
    $heavysleetshowerthunder =  __("Heavy sleet showers and thunder", "yr-weather");
    $lightsnowshower =  __("Light snow showers", "yr-weather");
    $snowshower =  __("Snow showers", "yr-weather");
    $heavysnowshower =  __("Heavy snow showers", "yr-weather");
    $lightsnowshowerthunder =  __("Light snow showers and thunder", "yr-weather");
    $snowshowerthunder =  __("Snow showers and thunder", "yr-weather");
    $heavysnowshowerthunder =  __("Heavy snow showers and thunder", "yr-weather");
    $lightrain =  __("Light rain", "yr-weather");
    $rain =  __("Rain", "yr-weather");
    $heavyrain =  __("Heavy rain", "yr-weather");
    $lightrainthunder =  __("Light rain and thunder", "yr-weather");
    $rainthunder =  __("Rain and thunder", "yr-weather");
    $heavyrainthunder =  __("Heavy rain and thunder", "yr-weather");
    $lightsleet =  __("Light sleet", "yr-weather");
    $sleet =  __("Sleet", "yr-weather");
    $heavysleet =  __("Heavy sleet", "yr-weather");
    $lightsleetthunder =  __("Light sleet and thunder", "yr-weather");
    $sleetthunder =  __("Sleet and thunder", "yr-weather");
    $heavysleetthunder =  __("Heavy sleet and thunder", "yr-weather");
    $lightsnow =  __("Light snow", "yr-weather");
    $snow =  __("Snow", "yr-weather");
    $heavysnow =  __("Heavy snow", "yr-weather");
    $lightsnowthunder =  __("Light snow and thunder", "yr-weather");
    $snowthunder =  __("Snow and thunder", "yr-weather");
    $heavysnowthunder =  __("Heavy snow and thunder", "yr-weather");
    $fog =  __("Fog", 'yr-weather');
    $ret_str = str_replace(
        array("01","02","03","04","40","05","41","24","06","25","42","07","43","26","20","27","44","08","45","28","21","29","46","09","10","30","22","11","47","12","48","31","23","32","49","13","50","33","14","34","15"),
		array($clearsky,$fair,$partlycloudy,$cloudy,$lighshowers,$rainshowers,$heavyshowers,$lightshowersthunder,$rainshowersthunder,$heavyshowersthunder,$lightsleetshower,$sleetshower,$heavysleetshower,$lightsleetshowerthunder,$sleetshowerthunder,$heavysleetshowerthunder,$lightsnowshower,$snowshower,$heavysnowshower,$lightsnowshowerthunder,$snowshowerthunder,$heavysnowshowerthunder,$lightrain,$rain,$heavyrain,$lightrainthunder,$rainthunder,$heavyrainthunder,$lightsleet,$sleet,$heavysleet,$lightsleetthunder,$sleetthunder,$heavysleetthunder,$lightsnow,$snow,$heavysnow,$lightsnowthunder,$snowthunder,$heavysnowthunder,$fog),
        $str);
	if ($small == true) {
		$ret_str = strtolower($ret_str);
	}
    return $ret_str;
}
 //$norsk=array("Klarvær","Lettskyet","Delvis skyet","Skyet","Lette regnbyger","Regnbyger","Kraftige regnbyger","Lette regnbyger og torden","Regnbyger og torden","Kraftige regnbyger og torden","Lette sluddbyger","Sluddbyger","Kraftige sluddbyger","Lette sluddbyger og torden","Sluddbyger og torden","Kraftige sluddbyger og torden","Lette snøbyger","Snøbyger","Kraftige snøbyger","Lette snøbyger og torden","Snøbyger og torden","Kraftige snøbyger og torden","Lett regn","Regn","Kraftig regn","Lett regn og torden","Regn og torden","Kraftig regn og torden","Lett sludd","Sludd","Kraftig sludd","Lett sludd og torden","Sludd og torden","Kraftig sludd og torden","Lett snø","Snø","Kraftig snø","Lett snø og torden","Snø og torden","Kraftig snø og torden","Tåke");

function wpyr_translate_direction($str, $small=false) {
	switch ($str) {
        case "N":
            $ret_str =__('N', 'yr-weather' );
            break;
        case "NNE":
            $ret_str =__('NNE', 'yr-weather' ); 
            break;
        case "NE":
            $ret_str =__('NE', 'yr-weather' ); 
            break;
        case "ENE":
            $ret_str =__('ENE', 'yr-weather' ); 
            break;
        case "E":
            $ret_str =__('E', 'yr-weather' ); 
            break;
        case "ESE":
            $ret_str =__('ESE', 'yr-weather' ); 
            break;
        case "SE":
            $ret_str =__('SE', 'yr-weather' ); 
        case "SSE":
            $ret_str =__('SSE', 'yr-weather' ); 
            break;
        case "S":
            $ret_str =__('S', 'yr-weather' ); 
        case "SSW":
            $ret_str =__('SSW', 'yr-weather' ); 
            break;
        case "SW":
            $ret_str =__('SW', 'yr-weather' ); 
        case "WSW":
            $ret_str =__('WSW', 'yr-weather' ); 
            break;
        case "W":
            $ret_str =__('W', 'yr-weather' ); 
            break;
        case "WNW":
            $ret_str =__('WNW', 'yr-weather' ); 
            break;
        case "NW":
            $ret_str =__('NW', 'yr-weather' ); 
            break;
        case "NNW":
            $ret_str =__('NNW', 'yr-weather' ); 
            break;
  		default:
    		$ret_str = $str;
	}
	if ($small == true) {
		$ret_str = strtolower($ret_str);
	}
    return $ret_str;
}



function wpyr_describe_direction($str, $small=false) {
	switch ($str) {
        case "N":
            $ret_str =__('North', 'yr-weather' );
            break;
        case "NNE":
            $ret_str =__('North-Norteast', 'yr-weather' ); 
            break;
        case "NE":
            $ret_str =__('Norteast', 'yr-weather' ); 
            break;
        case "ENE":
            $ret_str =__('East-Northeast', 'yr-weather' ); 
            break;
        case "E":
            $ret_str =__('East', 'yr-weather' ); 
            break;
        case "ESE":
            $ret_str =__('East-Southeast', 'yr-weather' ); 
            break;
        case "SE":
            $ret_str =__('Southeast', 'yr-weather' ); 
        case "SSE":
            $ret_str =__('South-Southeast', 'yr-weather' ); 
            break;
        case "S":
            $ret_str =__('South', 'yr-weather' ); 
        case "SSW":
            $ret_str =__('South-Southwest', 'yr-weather' ); 
            break;
        case "SW":
            $ret_str =__('Southwest', 'yr-weather' ); 
        case "WSW":
            $ret_str =__('West-Southwest', 'yr-weather' ); 
            break;
        case "W":
            $ret_str =__('West', 'yr-weather' ); 
            break;
        case "WNW":
            $ret_str =__('West-Northwest', 'yr-weather' ); 
            break;
        case "NW":
            $ret_str =__('Northwest', 'yr-weather' ); 
            break;
        case "NNW":
            $ret_str =__('North-Northwest', 'yr-weather' ); 
            break;
  		default:
    		$ret_str = $str;
	}
	if ($small == true) {
		$ret_str = strtolower($ret_str);
	}
    return $ret_str;
}

?>