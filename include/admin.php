<?php
/*---------- Admin ----------*/
/**
 * Create and display admin panel shortcode
 **/

add_action( 'admin_menu', 'wpyr_add_admin_menu' );
add_action( 'admin_init', 'wpyr_settings_init' );
add_action( 'admin_enqueue_scripts', 'wpyr_admin_css_scripts', 10, 1 );


#load custom script for this admin page
function wpyr_admin_css_scripts() {
	//if not this admin page
	$hook = get_current_screen();
	if ( $hook->id != 'settings_page_yr-weather-option' ) return;

	wp_register_script( 'wpyr_admin_js', WPYR_PLUGINURL . 'assets/js/wpyr_admin.js', array( 'jquery', 'wp-color-picker', 'ace_code_highlighter_js' ), '1.0.0', true );
	$translation_array = array(
		'placeholder_css' => __( 'Create custom CSS to style the elements on your page. Use the help-tab in the upper right corner for more info...', 'yr-weather' ),
		'placeholder_html' => __( 'Create custom layout with HTML code and use the keywords below to place data in your layout. Use help-tab in the upper right corner to read more...', 'yr-weather' ),
		'placeholder_upload_button' => __( 'Select image', 'yr-weather' )
	);
	wp_localize_script( 'wpyr_admin_js', 'wpyr_translate', $translation_array );

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_media();
	wp_enqueue_script( 'ace_code_highlighter_js', WPYR_PLUGINURL . 'assets/js/ace/ace.js', '', '1.0.0', true );
	wp_enqueue_script( 'ace_css_js', WPYR_PLUGINURL . 'assets/js/ace/mode-css.js', array( 'ace_code_highlighter_js' ), '1.0.0', true );
	wp_enqueue_script( 'ace_html_js', WPYR_PLUGINURL . 'assets/js/ace/mode-html.js', array( 'ace_code_highlighter_js' ), '1.0.0', true );
	wp_enqueue_script( 'wpyr_admin_js' );
	wp_register_style( 'weather-admin_css', WPYR_PLUGINURL . 'assets/css/admin-weather.css', false, '1.0.0', true );
	wp_enqueue_style( 'weather-admin_css' );
}

$wpyr_settings_tabs = array();

#create options menu-option
function wpyr_add_admin_menu() {
	global $wpyr_setting_page;
	$wpyr_setting_page = add_submenu_page(
		'options-general.php',
		__( 'Yr Weather Options', 'yr-weather' ),
		__( 'Weather Options', 'yr-weather' ),
		'manage_options',
		'yr-weather-option',
		'wpyr_weather_options_page'
	);
	add_action( 'load-' . $wpyr_setting_page, 'codex_wpyr_help_tab' );
}

#add settings fields and draw form
function wpyr_settings_init() {
	global $wpyr_settings_tabs;

	//general tab
	$wpyr_settings_tabs[ 'weather_general' ] = __( 'General', 'yr-weather' );
	register_setting( 'weather_general', 'wpyr_settings' );
	add_settings_section(
		'wpyr_general_section',
		__( 'General opions for Yr Weather shortcodes', 'yr-weather' ),
		'wpyr_general_section_callback',
		'weather_general'
	);
	add_settings_field(
		'wpyr_gen_place_text',
		__( 'Default place', 'yr-weather' ),
		'wpyr_gen_place_text_render',
		'weather_general',
		'wpyr_general_section'
	);
	add_settings_field(
		'wpyr_gen_offset_select',
		__( 'Offset', 'yr-weather' ),
		'wpyr_gen_offset_select_render',
		'weather_general',
		'wpyr_general_section'
	);
	add_settings_field(
		'wpyr_gen_icon_select',
		__( 'Icon set', 'yr-weather' ),
		'wpyr_gen_icon_select_render',
		'weather_general',
		'wpyr_general_section'
	);
	add_settings_field(
		'wpyr_gen_iconwidth_text',
		__( 'Icon width', 'yr-weather' ),
		'wpyr_gen_iconwidth_text_render',
		'weather_general',
		'wpyr_general_section'
	);
	add_settings_field(
		'wpyr_gen_iconheight_text',
		__( 'Icon height', 'yr-weather' ),
		'wpyr_gen_iconheight_text_render',
		'weather_general',
		'wpyr_general_section'
	);
	add_settings_field(
		'wpyr_gen_smallicon_select',
		__( 'Small icons', 'yr-weather' ),
		'wpyr_gen_smallicon_select_render',
		'weather_general',
		'wpyr_general_section'
	);
	add_settings_field(
		'wpyr_gen_smalliconwidth_text',
		__( 'Small icon width', 'yr-weather' ),
		'wpyr_gen_smalliconwidth_text_render',
		'weather_general',
		'wpyr_general_section'
	);
	add_settings_field(
		'wpyr_gen_smalliconheight_text',
		__( 'Small icon height', 'yr-weather' ),
		'wpyr_gen_smalliconheight_text_render',
		'weather_general',
		'wpyr_general_section'
	);
	add_settings_field(
		'wpyr_gen_colorfilter_checkbox',
		__( 'Use icon as color-mask', 'yr-weather' ),
		'wpyr_gen_colorfilter_checkbox_render',
		'weather_general',
		'wpyr_general_section'
	);
	add_settings_field(
		'wpyr_gen_iconcolor_text',
		__( 'Icon color', 'yr-weather' ),
		'wpyr_gen_iconcolor_text_render',
		'weather_general',
		'wpyr_general_section'
	);
	add_settings_field(
		'wpyr_gen_reset_checkbox',
		__( 'Reset', 'yr-weather' ),
		'wpyr_gen_reset_checkbox_render',
		'weather_general',
		'wpyr_general_section'
	);

	//template tab
	$wpyr_settings_tabs[ 'weather_template' ] = __( 'Templates', 'yr-weather' );
	register_setting( 'weather_template', 'wpyr_template_settings' );
	add_settings_section(
		'wpyr_template_section',
		__( 'Template options for Yr Weather shortcodes', 'yr-weather' ),
		'wpyr_template_section_callback',
		'weather_template'
	);
	add_settings_field(
		'wpyr_template_css_area',
		__( 'Custom CSS', 'yr-weather' ),
		'wpyr_template_css_area_render',
		'weather_template',
		'wpyr_template_section'
	);
	add_settings_field(
		'wpyr_template_html_area',
		__( 'Custom HTML for single', 'yr-weather' ),
		'wpyr_template_html_area_render',
		'weather_template',
		'wpyr_template_section'
	);
	add_settings_field(
		'wpyr_template_loop_area',
		__( 'Custom HTML for loop', 'yr-weather' ),
		'wpyr_template_loop_area_render',
		'weather_template',
		'wpyr_template_section'
	);
	add_settings_field(
		'wpyr_template_loop_checkbox',
		__( 'Use single template for loop', 'yr-weather' ),
		'wpyr_template_loop_checkbox_render',
		'weather_template',
		'wpyr_template_section'
	);
	add_settings_field(
		'wpyr_template_loopclass_text',
		__( 'Class for container', 'yr-weather' ),
		'wpyr_template_loopclass_text_render',
		'weather_template',
		'wpyr_template_section'
	);

	//shortcodes tab
	$wpyr_settings_tabs[ 'weather_shortcode' ] = __( 'Shortcode', 'yr-weather' );
	register_setting( 'weather_shortcode', 'wpyr_shortcode_settings' );
	add_settings_section(
		'wpyr_shortcode_section',
		__( 'Shortcode for Yr Weather', 'yr-weather' ),
		'wpyr_shortcode_section_callback',
		'weather_shortcode'
	);
}

/* ----- GENERAL SETTINGS ----- */
#functions for rendering general settings
function wpyr_general_section_callback() {
	echo __( 'This is the general settings for Yr weather shortcodes.', 'yr-weather' );
	echo '<br />' . __( 'Use the Help-tab in the upper right corner for more info on settings.', 'yr-weather' );
}
function wpyr_gen_place_text_render() {
	$options = wpyr_get_option();
	?>
	<input type='text' name='wpyr_settings[wpyr_gen_place_text]' value='<?php echo $options[' wpyr_gen_place_text ']; ?>' placeholder="Norway/Oslo/Oslo/Oslo"> &nbsp;
	<?php _e( 'See Help-tab in upper right corner on how to get correct place.','yr-weather' );
}
function wpyr_gen_offset_select_render() { 
	$options = wpyr_get_option();

?>
	<select name='wpyr_settings[wpyr_gen_offset_select]'>
		<option value="0" <?php if($options[ 'wpyr_gen_offset_select']=="0" ) echo( ' selected'); ?>>
			<?php _e('Now','yr-weather'); ?>
		</option>
		<?php for ($i = 1; $i < 48; $i++) { ?>
		<option value="<?php echo($i); ?>" <?php if($options[ 'wpyr_gen_offset_select']==$i) echo( ' selected'); ?>>
			<?php echo($i); ?>
		</option>
		<?php } ?>
	</select>&nbsp;
	<?php _e( 'Hours offset to forecast.','yr-weather' ); ?><br/>
	<div style="float:left;margin: 5px 0 0 0;"><em>
	<!--?php _e( 'Icon Set can also be selected with shorcode attribute.','yr-weather' ); ?></em-->
</div>
<?php
}
function wpyr_gen_icon_select_render() { 
	$options = wpyr_get_option();
?>
<select name='wpyr_settings[wpyr_gen_icon_select]'>
	<option value="thin"<?php if($options['wpyr_gen_icon_select'] == "thin") echo(' selected'); ?>><?php _e('Outline Thin','yr-weather'); ?></option>
	<option value="normal"<?php if($options['wpyr_gen_icon_select'] == "normal") echo(' selected'); ?>><?php _e('Outline Normal','yr-weather'); ?></option>
	<option value="fat"<?php if($options['wpyr_gen_icon_select'] == "fat") echo(' selected'); ?>><?php _e('Outline Fat','yr-weather'); ?></option>
	<option value="black"<?php if($options['wpyr_gen_icon_select'] == "black") echo(' selected'); ?>><?php _e('Black','yr-weather'); ?></option>
	<option value="color"<?php if($options['wpyr_gen_icon_select'] == "color") echo(' selected'); ?>><?php _e('Yr Color V.3.0','yr-weather'); ?></option> 
</select>&nbsp;
<?php _e( 'Select icon set to use as standard.','yr-weather' ); ?><br />
<div style="float:left;margin: 5px 0 0 0;"><em>
	<!--?php _e( 'Icon Set can also be selected with shorcode attribute.','yr-weather' ); ?></em-->
</div>
<?php
}
function wpyr_gen_iconwidth_text_render() { 
	$options = wpyr_get_option();
	?>
<input type='text' name='wpyr_settings[wpyr_gen_iconwidth_text]' value='<?php echo $options['wpyr_gen_iconwidth_text']; ?>'> &nbsp;&nbsp;
<?php _e( 'Write css width, i.e 100px, 100%, 10vw etc.','yr-weather' );
}
function wpyr_gen_iconheight_text_render() { 
	$options = wpyr_get_option();
	?>
<input type='text' name='wpyr_settings[wpyr_gen_iconheight_text]' value='<?php echo $options['wpyr_gen_iconheight_text']; ?>'> &nbsp;
<?php _e( 'Write css height, i.e 100px, 10vw, 10vw etc.','yr-weather' );
}
function wpyr_gen_smallicon_select_render() { 
	$options = wpyr_get_option();
?>
<select name='wpyr_settings[wpyr_gen_smallicon_select]'>
	<option value="thin"<?php if($options['wpyr_gen_smallicon_select'] == "thin") echo(' selected'); ?>><?php _e('Outline Thin','yr-weather'); ?></option>
	<option value="normal"<?php if($options['wpyr_gen_smallicon_select'] == "normal") echo(' selected'); ?>><?php _e('Outline Normal','yr-weather'); ?></option>
	<option value="fat"<?php if($options['wpyr_gen_smallicon_select'] == "fat") echo(' selected'); ?>><?php _e('Outline Fat','yr-weather'); ?></option>
	<option value="black"<?php if($options['wpyr_gen_smallicon_select'] == "black") echo(' selected'); ?>><?php _e('Black','yr-weather'); ?></option>
</select>&nbsp;
<?php _e( 'Icon set for symbols like temperature, wind, direction, barometer, precipitation etc.','yr-weather' ); ?><br />
<div style="float:left;margin: 5px 0 0 0;"><em>
	<!--?php _e( 'Icon Set can also be selected with shorcode attribute.','yr-weather' ); ?></em-->
</div>
<?php
}
function wpyr_gen_smalliconwidth_text_render() { 
	$options = wpyr_get_option();
	?>
<input type='text' name='wpyr_settings[wpyr_gen_smalliconwidth_text]' value='<?php echo $options['wpyr_gen_smalliconwidth_text']; ?>'> &nbsp;&nbsp;
<?php _e( 'Write css width, i.e 50px, 50%, 5vw etc.','yr-weather' );
}

function wpyr_gen_smalliconheight_text_render() { 
	$options = wpyr_get_option();
	?>
<input type='text' name='wpyr_settings[wpyr_gen_smalliconheight_text]' value='<?php echo $options['wpyr_gen_smalliconheight_text']; ?>'> &nbsp;
<?php _e( 'Write css height, i.e 50px, 5em, 5vw etc.','yr-weather' );
}

function wpyr_gen_colorfilter_checkbox_render() { 
	$options = wpyr_get_option();
	?>
<input type='checkbox' name='wpyr_settings[wpyr_gen_colorfilter_checkbox]' 
	<?php if(isset($options['wpyr_gen_colorfilter_checkbox'])) checked( $options['wpyr_gen_colorfilter_checkbox'], 1 ); ?> value='1'>&nbsp;
	<?php _e( 'Add color to icon.','yr-weather' ); ?><br />
	<?php
}
function wpyr_gen_iconcolor_text_render() { 
	$options = wpyr_get_option();
	?>
<input type='text' id="wpyr_gen_iconcolor_text" name='wpyr_settings[wpyr_gen_iconcolor_text]' value='<?php echo $options['wpyr_gen_iconcolor_text']; ?>'> &nbsp;
<?php _e( 'Defines a color tint to icon mask.','yr-weather' );
}

function wpyr_gen_reset_checkbox_render() { 
	$options = wpyr_get_option();
	?>
<input type='checkbox' name='wpyr_settings[wpyr_gen_reset_checkbox]' 
	<?php if(isset( $options['wpyr_gen_reset_checkbox'] )) checked( $options['wpyr_gen_reset_checkbox'], 1 ); ?> value='1'>&nbsp;
	<?php _e( 'Check to force default options when plugin is deactivated and reactivated.','yr-weather' ); ?><br />
	<?php
}

/* ----- TEMPLATES SETTINGS ----- */
#functions for rendering template settings
function wpyr_template_section_callback() { 
	echo __( 'This is the settings for templates for Yr Weather shortcodes.','yr-weather' );
	echo '<br />' . __( 'Use the Help-tab in the upper right corner for more info on settings.','yr-weather' );
}
function wpyr_template_css_area_render() { 
	global $wpyr_default_css;
	$options = wpyr_get_option();
	?>
<div id="css_area_container">
    <div name="css_area" id="css_area" style="border: 1px solid #DFDFDF; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; width: 80%; height: 200px; position: relative;"></div>
</div>
<textarea style="display:none;" id="wpyr_template_css_area" name="wpyr_template_settings[wpyr_template_css_area]"><?php
	if(!isset($options['wpyr_template_css_area']) 
		|| $options['wpyr_template_css_area'] != '' ) echo $options['wpyr_template_css_area']; ?></textarea>
        <?php
		echo ('<em>');
		_e( 'This CSS will be written to the &lt;head&gt; tag, but for optimized performance it is best practice to implement CSS-code in your theme.','yr-weather' );
		echo ('</em>
		<br>' ); } function wpyr_template_html_area_render() { global $wpyr_default_css; $options = wpyr_get_option(); ?>
		<div id="html_area_container">
			<div name="html_area" id="html_area" style="border: 1px solid #DFDFDF; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; width: 80%; height: 200px; position: relative;"></div>
		</div>
		<textarea style="display:none;" id="wpyr_template_html_area" name='wpyr_template_settings[wpyr_template_html_area]'><?php
	if(!isset($options['wpyr_template_html_area']) 
		|| $options['wpyr_template_html_area'] != '' ) echo $options['wpyr_template_html_area']; ?></textarea> <br/>
		<?php  
		echo ('<strong>');
		_e( 'Use these tags to include weather data in your layout:','yr-weather' );
		echo ('</strong><br>' );
		echo ('[@symbol] [@symbol-url] [@place] [@date] [@date-time] [@time-from] [@time-to] [@offset] [@offset-lowercase]<br>
		[@description] [@description-lowercase] [@temperature] [@temperature-f] [@precipitation] [@pressure]<br>
		[@windSpeed] [@windDirection] [@windDirection-int] [@windText] [@windText-lowercase] [@windDegree]<br>
		[@symbol-temp] [@symbol-wind] [@symbol-dir] [@symbol-precip] [@symbol-pressure]<br>     
		[@temp-unit] [@temp-unit-f] [@pressure-scale] [@altitude] [@latitude] [@longitude]<br><br>' );
		echo ('<strong>');
		_e( 'Translatable texts (also with first letter capitalized):','yr-weather' );
		echo ('</strong><br>' );
		echo ('[time] [from] [to] [and] [in] [at] [hour] [hours] [place] [precipitation] [wind] [windspeed] [wind-direction]<br>
		[temperature] [degrees] [degree-symbol] [pressure] [air-pressure] [atmospheric-pressure] [barometric-pressure]<br>
		[weather] [the-weather] [altitude] [MAS] [meters-above-sea] [latitude] [longitude]<br><br>' );
	
}
function wpyr_template_loop_area_render() { 
	global $wpyr_default_css;
	$options = wpyr_get_option();
	?>
		<div id="loop_area_container">
			<div name="loop_area" id="loop_area" style="border: 1px solid #DFDFDF; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; width: 80%; height: 200px; position: relative;"></div>
		</div>
		<textarea style="display:none;" id="wpyr_template_loop_area" name='wpyr_template_settings[wpyr_template_loop_area]'><?php
	if(!isset($options['wpyr_template_loop_area']) 
		|| $options['wpyr_template_loop_area'] != '' ) echo $options['wpyr_template_loop_area']; ?></textarea> <br/>
		<?php  
		echo ('<strong>');
		_e( 'Use all tags above, and the following to mark start and end of loop:','yr-weather' );
		echo ('</strong><br>' );
		echo ('[@loop-start] [@loop-end] <br><br>' );
	
}
function wpyr_template_loop_checkbox_render() { 
	$options = wpyr_get_option();
	?>
		<input type='checkbox' name='wpyr_template_settings[wpyr_template_loop_checkbox]' <?php if(isset( $options[ 'wpyr_template_loop_checkbox'])) checked( $options[ 'wpyr_template_loop_checkbox'], 1 ); ?> value='1'>&nbsp;
		<?php _e( 'Use single template in loop shortcode.','yr-weather' ); ?><br/>
		<?php
		}

		function wpyr_template_loopclass_text_render() {
			$options = wpyr_get_option();
			?>
		<input type='text' id="wpyr_template_loopclass_text" name='wpyr_template_settings[wpyr_template_loopclass_text]' value='<?php echo $options[' wpyr_template_loopclass_text ']; ?>'> &nbsp;
		<?php _e( 'Class of outer container (if loop template is not defined).','yr-weather' );
}

/* ----- SHORTCODES ----- */
#functions for rendering search settings
function wpyr_shortcode_section_callback() { 
?>
<table>
	<tbody>
		<tr>
			<td colspan="2" valign="top">
				<?php _e("These are the shortcodes and attributes for Yr Weather.","yr-weather" ); ?><br/>&nbsp;<br/>
			</td>
		</tr>
		<tr>
			<th align="left" scope="row" valign="top" width="15%">[wpyr_weather]</th>
			<td valign="top">
				<?php _e("Using the shortcode without any attributes will render the weather forecast as defined in the shortcode settings. You can however add several variables, or attributes to override these settings","yr-weather"); ?><br/>&nbsp;
				<table>
					<tr>
						<th align="left" scope="row" valign="top" width="15%">place</th>
						<td valign="top">
							<?php _e("Set the location for the weather forecast. See help-tab in upper right corner for more information on how to obtain correct location.","yr-weather"); ?>
						</td>
					</tr>
					<tr>
						<th align="left" scope="row" valign="top" width="15%">offset</th>
						<td valign="top">
							<?php _e('You can offset the time of forecast from 0 to 47 hours, i.e offset="24".',"yr-weather"); ?>
						</td>
					</tr>
					<tr>
						<th align="left" scope="row" valign="top" width="15%">icon</th>
						<td valign="top">
							<?php _e("Use this to select the icon set. You can choose <em>thin</em>, <em>normal</em>, <em>fat</em>, <em>black</em> or <em>color</em>.","yr-weather"); ?>
						</td>
					</tr>
					<tr>
						<th align="left" scope="row" valign="top" width="15%">width</th>
						<td valign="top">
							<?php _e("The width of the icon, use any CSS definition, like <em>100px</em>, <em>100%</em> or <em>25vw</em>.","yr-weather"); ?>
						</td>
					</tr>
					<tr>
						<th align="left" scope="row" valign="top" width="15%">height</th>
						<td valign="top">
							<?php _e("The height of the icon, use any CSS definition except %, like <em>100px</em>, <em>10em</em> or <em>auto</em>.","yr-weather"); ?>
						</td>
					</tr>
					<tr>
						<th align="left" scope="row" valign="top" width="15%">smallicon</th>
						<td valign="top">
							<?php _e("Icon set for symbols like temperature, wind, direction, barometer, precipitation etc in your template. You can choose <em>thin</em>, <em>normal</em>, <em>fat</em>, <em>black</em> or <em>color</em>.","yr-weather"); ?>
						</td>
					</tr>
					<tr>
						<th align="left" scope="row" valign="top" width="15%">smallwidth</th>
						<td valign="top">
							<?php _e("The width of the smallicon, use any CSS definition, like <em>100px</em>, <em>100%</em> or <em>25vw</em>.","yr-weather"); ?>
						</td>
					</tr>
					<tr>
						<th align="left" scope="row" valign="top" width="15%">smallheight</th>
						<td valign="top">
							<?php _e("The height of the smallicon, use any CSS definition except %, like <em>100px</em>, <em>10em</em> or <em>auto</em>.","yr-weather"); ?>
						</td>
					</tr>
					<tr>
						<th align="left" scope="row" valign="top" width="15%">mask</th>
						<td valign="top">
							<?php _e("<em>yes</em> or <em>no</em> if the icon should be used as a color mask.","yr-weather"); ?>
						</td>
					</tr>
					<tr>
						<th align="left" scope="row" valign="top" width="15%">color</th>
						<td valign="top">
							<?php _e("The color to be applied to the icon color mask. Use CSS definition such as <em>#ff0000</em> or <em>rgba(255,0,0,0.5)</em>","yr-weather"); ?>
						</td>
					</tr>
				</table><br>
				<em style="color:blue">
					<?php _e('[wpyr_weather place="Norway/Oslo/Oslo/Oslo" offset="3" icon="fat" width="200px" height="200px" mask="yes" color="rgba(0,0,0,0.5)"]',"yr-weather"); ?>
				</em>
				<br/>&nbsp;</td>
		</tr>
		<tr>
			<th align="left" scope="row" valign="top" width="15%">[wpyr_weather <br>offset="0" <br>end="47"]</th>
			<td valign="top">
				<?php _e("Use the same shortcode but add the <em>end</em> attribute with the <em>offset</em> attribute to make a loop/sequence of forecasts. You can use all the other attributes in a loop shortcode as well. There will only be one call to the yr.no to collect weather data for a loop/sequence","yr-weather"); ?> <br/>&nbsp;
				<table width=100%>
					<tr>
						<th align="left" scope="row" valign="top" width="15%">offset</th>
						<td valign="top">
							<?php _e('You can offset the start of forecast from 0 to 47 hours, i.e offset="6".',"yr-weather"); ?>
						</td>
					</tr>
					<tr>
						<th align="left" scope="row" valign="top" width="15%">end</th>
						<td valign="top">
							<?php _e('Number of hours to the last forecast from 0 to 47 hours, i.e end="18".',"yr-weather"); ?>
						</td>
					</tr>
					<tr>
						<th align="left" scope="row" valign="top" width="15%">interval</th>
						<td valign="top">
							<?php _e('Number of hours between each forecast, i.e interval="2".',"yr-weather"); ?>
						</td>
					</tr>
				</table><br>
				<em style="color:blue">
					<?php _e('[wpyr_weather offset="6" end="18" interval="2"]',"yr-weather"); ?>
				</em>
				<br/>&nbsp;</td>
		</tr>
	</tbody>
</table>
<?php
}

/* ----- TABS ----- */
#function for rendering tabs
function wpyr_options_tabs() {
	global $wpyr_settings_tabs;
	$current_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'weather_general';

	echo '<h2 class="nav-tab-wrapper">';
	foreach ( $wpyr_settings_tabs as $tab_key => $tab_caption ) {
		$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
		echo '<a class="nav-tab ' . $active . '" href="?page=yr-weather-option' . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
	}
	echo '</h2>';
}

/* ----- OPTIONS PAGE ----- */
#function for rendering options page (with tabs
function wpyr_weather_options_page() {
	$current_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'weather_general';
	?>
<div class="wrap">
	<?php wpyr_options_tabs(); ?>
	<form id='yr_weather_options' action='options.php' method='post'>

		<?php 
	settings_fields( $current_tab );
	do_settings_sections( $current_tab );
	if ( $current_tab != 'weather_shortcode' ) submit_button();
?>
	</form>
</div>
<?php
}
?>