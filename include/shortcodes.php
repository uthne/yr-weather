<?php
/*---------- Shortcode ----------*/
/**
 * TODO: 
 **/

add_shortcode( 'wpyr_weather', 'wpyr_weather_shortcode' );

function wpyr_weather_shortcode( $atts ) {
	$wpyr_out = '';
	$options = wpyr_get_option();
	$icon_path = plugin_dir_url( __DIR__ ) . 'assets/svg/';
	extract( shortcode_atts( array(
		'icon' => '',
		'smallicon' => '',
		'place' => '',
		'offset' => '',
		'width' => '',
		'height' => '',
		'smallwidth' => '',
		'smallheight' => '',
		'mask' => '',
		'color' => '',
		'end' => '',
		'interval' => ''
	), $atts ) );

	/*--- SORT OUT TEMPLATE ---*/
	$isloop = ( $offset != '' && $end != '' ) ? true : false;
	$pre_template = $post_template = '';

	if ( $isloop ) {
		if ( $end > 47 )$end = "47";
		if ( $offset > $end )$offset = $end;
		$pre_template = '<div class="' . $options[ 'wpyr_template_loopclass_text' ] . '">';
		$post_template = '</div>';
		if ( !$options[ 'wpyr_template_loop_area' ] ) {
			if ( isset( $options[ 'wpyr_template_loop_checkbox' ] ) && $options[ 'wpyr_template_html_area' ] && $options[ 'wpyr_template_html_area' ] != '' ) {
				$template = $options[ 'wpyr_template_html_area' ];
			} else {
				$template = wpyr_defaul_template();
			}
		} else {
			$raw_template = $options[ 'wpyr_template_loop_area' ];
			if ( stristr( $raw_template, '[@loop-start]' ) && stristr( $raw_template, '[@loop-end]' ) ) {
				$arr_template = wpyr_split_template( $raw_template );
				$pre_template = $arr_template[ 0 ];
				$template = $arr_template[ 1 ];
				$post_template = $arr_template[ 2 ];
			} else {
				$template = $options[ 'wpyr_template_loop_area' ];
			}
			if ( isset( $options[ 'wpyr_template_loop_checkbox' ] ) && $options[ 'wpyr_template_html_area' ] && $options[ 'wpyr_template_html_area' ] != '' ) {
				$template = $options[ 'wpyr_template_html_area' ];
			}
		}
	} else {
		$offset = ( $offset != "" ) ? $offset : $options[ 'wpyr_gen_offset_select' ];
		if ( $offset > 47 )$offset = "47";
		$end = $offset;
		if ( $options[ 'wpyr_template_html_area' ] && $options[ 'wpyr_template_html_area' ] != '' ) {
			$template = $options[ 'wpyr_template_html_area' ];
		} else {
			$template = wpyr_defaul_template();
		}
	}

	/*--- SORT OUT SETTINGS ---*/
	$place = ( $place != "" ) ? $place : $options[ 'wpyr_gen_place_text' ];
	$icon_set = ( $icon != "" ) ? $icon : $options[ 'wpyr_gen_icon_select' ];
	$icon_url = plugin_dir_url( __DIR__ ) . 'assets/img/svg/' . $icon_set . '/';
	if ( $mask != '' ) {
		$mask = ( $mask == 'yes' ) ? $mask = '1' : '0';
	} else {
		$mask = ( $options[ 'wpyr_gen_colorfilter_checkbox' ] == '1' ) ? $mask = '1' : '0';
	}
	$height = ( $height != '' ) ? $height : $options[ 'wpyr_gen_iconheight_text' ];
	$width = ( $width != '' ) ? $width : $options[ 'wpyr_gen_iconwidth_text' ];
	$color = ( $color != '' ) ? $color : $options[ 'wpyr_gen_iconcolor_text' ];

	$smallicon_set = ( $smallicon != "" ) ? $smallicon : $options[ 'wpyr_gen_smallicon_select' ];
	$smallicon_url = plugin_dir_url( __DIR__ ) . 'assets/img/svg/' . $smallicon_set . '/';
	$smallheight = ( $smallheight != '' ) ? $smallheight : $options[ 'wpyr_gen_smalliconheight_text' ];
	$smallwidth = ( $smallwidth != '' ) ? $smallwidth : $options[ 'wpyr_gen_smalliconwidth_text' ];
	$interval = ( $interval != '' ) ? $interval : 1;

	/*--- MAKE IMAGE TAGS ---*/
	$symbol_temp = wpyr_make_figure( $smallicon_url . 'temp.svg', $smallheight, $smallwidth, $smallicon_set, $color, $mask, 'wpyr-small-symbol' );
	$symbol_wind = wpyr_make_figure( $smallicon_url . 'wind.svg', $smallheight, $smallwidth, $smallicon_set, $color, $mask, 'wpyr-small-symbol' );
	$symbol_precip = wpyr_make_figure( $smallicon_url . 'precip.svg', $smallheight, $smallwidth, $smallicon_set, $color, $mask, 'wpyr-small-symbol' );
	$symbol_pressure = wpyr_make_figure( $smallicon_url . 'baro.svg', $smallheight, $smallwidth, $smallicon_set, $color, $mask, 'wpyr-small-symbol' );


	/*--- GET DATA FROM YR.NO AND DECODE JSON  ---*/
	$xmlstr = get_xml_from_url( 'https://www.yr.no/sted/' . $place . '/varsel_time_for_time.xml' );
	$xmlobj = xmlstr_to_array( $xmlstr );
	$forecast = $xmlobj[ 'forecast' ][ 'tabular' ][ 'time' ];

	$place = $xmlobj[ 'location' ][ 'name' ];
	$altitude = $xmlobj[ 'location' ][ 'location' ][ '@attributes' ][ 'altitude' ];
	$latitude = $xmlobj[ 'location' ][ 'location' ][ '@attributes' ][ 'latitude' ];
	$longitude = $xmlobj[ 'location' ][ 'location' ][ '@attributes' ][ 'longitude' ];

	if ( $isloop && $pre_template != '' )$wpyr_out .= $pre_template;

	/*--- LOOP START ---*/
	for ( $i = $offset; $i <= $end; $i += $interval ) {
		$description = $forecast[ $i ][ 'symbol' ][ '@attributes' ][ 'var' ];
		$description = str_replace( array( 'm', 'n', 'd' ), array( '', '', '' ), $description );
		$Description = wpyr_translate_description( $description );
		$symbol = $forecast[ $i ][ 'symbol' ][ '@attributes' ][ 'number' ];
		$symbol_name = $forecast[ $i ][ 'symbol' ][ '@attributes' ][ 'var' ];
		$symbol_url = $icon_url . $symbol_name . '.svg';
		$precipitation = $forecast[ $i ][ 'precipitation' ][ '@attributes' ][ 'value' ];
		$windDirection = $forecast[ $i ][ 'windDirection' ][ '@attributes' ][ 'code' ]; // W S E N etc
		$windDirTranlate = wpyr_translate_direction( $windDirection );
		$Windtext = wpyr_describe_direction( $windDirection );
		$windDegree = $forecast[ $i ][ 'windDirection' ][ '@attributes' ][ 'deg' ]; // 260 etc
		$windSpeed = $forecast[ $i ][ 'windSpeed' ][ '@attributes' ][ 'mps' ]; // mps
		$temp_unit = $forecast[ $i ][ 'temperature' ][ '@attributes' ][ 'unit' ];
		$temperature = $forecast[ $i ][ 'temperature' ][ '@attributes' ][ 'value' ];
		$temperature_f = intval( ( ( $temperature / 5 ) * 9 ) + 32 );
		$pressure_scale = $forecast[ $i ][ 'pressure' ][ '@attributes' ][ 'unit' ];
		$pressure = $forecast[ $i ][ 'pressure' ][ '@attributes' ][ 'value' ];
		$time_from = $forecast[ $i ][ '@attributes' ][ 'from' ];
		$time_to = $forecast[ $i ][ '@attributes' ][ 'to' ];

		switch ( $i ) {
			case "0":
				$Offset_html = __( 'In the next hour', 'yr-weather' );
				break;
			case "1":
				$Offset_html = __( 'In one hour', 'yr-weather' );
				break;
			case "2":
				$Offset_html = __( 'Two hours from now', 'yr-weather' );
				break;
			default:
				$Offset_html = $i . " " . __( 'hours from now', 'yr-weather' );
		}

		/*--- MAKE TIME AND DATE ---*/
		$date_out = wpyr_make_date( $time_from );
		$datetime_out = wpyr_make_compdate( $time_from, $time_to );
		$from_out = wpyr_make_hour( $time_from );
		$to_out = wpyr_make_hour( $time_to );

		/*--- MAKE MORE IMAGE TAGS ---*/
		$symbol_html = wpyr_make_figure( $symbol_url, $height, $width, $icon_set, $color, $mask );
		$dir_icon = strtolower( $windDirection ) . '.svg';
		$symbol_dir = wpyr_make_figure( $smallicon_url . $dir_icon, $smallheight, $smallwidth, $smallicon_set, $color, $mask, 'wpyr-small-symbol' );

		/*--- MAKE OUTPUT ---*/
		$temp = str_replace(
			array( '[@symbol]', '[@symbol-url]', '[@place]', '[@description]', '[@description-lowercase]', '[@date-time]', '[@date]', '[@time-from]', '[@time-to]', '[@offset]', '[@offset-lowercase]', '[@temperature]', '[@temperature-f]', '[@precipitation]', '[@windSpeed]', '[@windDirection]', '[@windDirection-int]', '[@windText]', '[@windText-lowercase]', '[@windDegree]', '[@pressure]', '[@symbol-temp]', '[@symbol-wind]', '[@symbol-dir]', '[@symbol-precip]', '[@symbol-pressure]', '[@temp-unit]', '[@temp-unit-f]', '[@pressure-scale]', '[@altitude]', '[@latitude]', '[@longitude]' ),
			array( $symbol_html, $symbol_url, $place, $Description, strtolower( $Description ), $datetime_out, $date_out, $from_out, $to_out, $Offset_html, strtolower( $Offset_html ), $temperature, $temperature_f, $precipitation, $windSpeed, $windDirTranlate, $windDirection, $Windtext, strtolower( $Windtext ), $windDegree, $pressure, $symbol_temp, $symbol_wind, $symbol_dir, $symbol_precip, $symbol_pressure, $temp_unit, "Fahrenheit", $pressure_scale, $altitude, $latitude, $longitude ), $template
		);
		$wpyr_out .= wpyr_translate_template( $temp );

	}
	/*--- LOOP END ---*/

	if ( $isloop && $post_template != '' ) {
		$wpyr_out .= $post_template;
		$wpyr_out = str_replace(
			array( '[@place]', '[@altitude]', '[@latitude]', '[@longitude]' ),
			array( $place, $altitude, $latitude, $longitude ), $wpyr_out
		);
		$wpyr_out = wpyr_translate_template( $wpyr_out );
	}

	return $wpyr_out;
}

/*--- FUNCTIONS ---*/
function wpyr_make_figure( $url = '', $height = '', $width = '', $icon_set = 'color', $color = '', $mask = '0', $class = 'wpyr-symbol' ) {
	if ( $url == '' ) return;
	$figure_color = ( $color != '' ) ? ' background-color: ' . $color . '; ': '';
	$figure_height = ( $height != '' ) ? ' height: ' . $height . '; ': '';
	$figure_width = ( $width != '' ) ? ' width: ' . $width . '; ': '';
	if ( $mask != '1' || $icon_set == 'color' ) {
		$figure_html = '<img src="' . $url . '" style="' . $figure_height . $figure_width . ' max-width:100%;" class="' . $class . '">';
	} else {
		$figure_html = '<div style="mask: url(' . $url . '); -webkit-mask: url(' . $url . ')  no-repeat center; ' . $figure_height . $figure_width . ' max-width:100%; ' . $figure_color . '" class="' . $class . '"></div>';
	}
	return $figure_html;
}
function wpyr_split_template( $templ ) {
	$arr1 = explode( '[@loop-start]', $templ );
	$arr2 = explode( '[@loop-end]', $arr1[ 1 ] );
	$ret1 = $arr1[ 0 ];
	$ret2 = $arr2[ 0 ];
	$ret3 = $arr2[ 1 ];
	return array( $ret1, $ret2, $ret3 );
}
function wpyr_make_compdate( $time_from, $time_to ) {
	if ( !$time_from || !$time_to ) return;
	$time_from_date = explode( "T", $time_from );
	$time_to_date = explode( "T", $time_to );
	$l = explode( '_', get_locale() );
	$c = $l[ 1 ];
	$format = ( in_array( $c, array( 'US', 'CA', 'IE', 'ZA', 'CN', 'JP', 'KR', 'TW', 'HU', 'MN', 'LT', 'KE', ) ) ) ? "F j, " : "j. F, ";
	if ( $time_from_date[ 0 ] == $time_to_date[ 0 ] ) {
		$comp_date = date_i18n( $format, strtotime( $time_from_date[ 0 ] ) ) . substr( $time_from_date[ 1 ], 0, -3 ) . ' - ' . substr( $time_to_date[ 1 ], 0, -3 );
	} else {
		$comp_date = date_i18n( $format, strtotime( $time_from_date[ 0 ] ) ) . substr( $time_from_date[ 1 ], 0, -3 ) . ' - ' . date( "j. F, ", strtotime( $time_to_date[ 0 ] ) ) . substr( $time_to_date[ 1 ], 0, -3 );
	}
	return $comp_date;
}
function wpyr_make_hour( $time ) {
	if ( !$time ) return '';
	$time_from_date = explode( "T", $time );
	$hour = substr( $time_from_date[ 1 ], 0, -3 );
	return $hour;
}
function wpyr_make_date( $time_from ) {
	if ( !$time_from ) return;
	$l = explode( '_', get_locale() );
	$c = $l[ 1 ];
	$format = ( in_array( $c, array( 'US', 'CA', 'IE', 'ZA', 'CN', 'JP', 'KR', 'TW', 'HU', 'MN', 'LT', 'KE', ) ) ) ? "F j, " : "j. F, ";
	$time_from_date = explode( "T", $time_from );
	$comp_date = date_i18n( $format, strtotime( $time_from_date[ 0 ] ) );
	return $comp_date;
}
?>