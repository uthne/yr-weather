<?php
/*
Plugin Name: Yr Weather shortcodes
Plugin URI: https://uthne.net/
Description: Shortcodes for implementing weather forecast from Norwegian weather service Yr. 
Text Domain: yr-weather
Domain Path: /languages
Version: 1.0
Author: Kjetil Uthne Hansen
Author URI: https://uthne.net/
License: GPLv2
*/

#load textdomain for translations
add_action( 'plugins_loaded', 'wpyr_load_textdomain' );
function wpyr_load_textdomain() {
  load_plugin_textdomain( 'yr-weather', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' ); 
}

define ('WPYR_PLUGINPATH', plugin_dir_path(  __FILE__  ));
define ('WPYR_PLUGINURL', plugins_url('yr-weather/'));

const VERSION = '1.0';


function wpyr_get_option() {
	$general = (array) get_option( 'wpyr_settings' );
	$template = (array) get_option( 'wpyr_template_settings' );
	return array_merge($general, $template);
}

/*----- INSTALL -----*/
# register activation hook, flush rewriterules and set default values on first activation
register_activation_hook( __FILE__, 'wpyr_plugin_activate' );

function wpyr_plugin_activate() {
	$opts = get_option('wpyr_settings');
	if(!get_option('wpyr_settings') || $opts['wpyr_gen_reset_checkbox'] == '1') {
        //not present, so add
        $wpyr_defaults = array( 
			'wpyr_gen_place_text' => 'Norway/Oslo/Oslo/Oslo',
			'wpyr_gen_icon_select' => 'normal',
			'wpyr_gen_offset_select' => '0',
			'wpyr_gen_colorfilter_checkbox' => '0',
			'wpyr_gen_iconheight_text' => '100px',
			'wpyr_gen_iconwidth_text' => '100px',
			'wpyr_gen_smallicon_select' => 'fat',
			'wpyr_gen_smalliconheight_text' => '50px',
			'wpyr_gen_smalliconwidth_text' => '50px',
			'wpyr_gen_colorfilter_checkbox' => '0',
			'wpyr_gen_iconcolor_text' => '',
			'wpyr_gen_reset_checkbox' => ''
        );
		if (!get_option('wpyr_settings')) {
        	add_option('wpyr_settings', $wpyr_defaults);
		} else {
			update_option('wpyr_settings', $wpyr_defaults);
		}
    }
	if(!get_option('wpyr_template_settings') || $opts['wpyr_gen_reset_checkbox'] == '1') {
        //not present, so add
        $wpyr_defaults = array( 
			'wpyr_template_css_area' => '',
			'wpyr_template_html_area' => '',
			'wpyr_template_loop_area' => '',
			'wpyr_template_loop_checkbox' => '1',
			'wpyr_template_loopclass_text' => 'weather-container'
        );
		if (!get_option('wpyr_template_settings')) {
        	add_option('wpyr_template_settings', $wpyr_defaults);
		} else {
			update_option('wpyr_template_settings', $wpyr_defaults);
		}
    }
}


/*---- LOAD INCLUDE FILES -----*/

require_once(WPYR_PLUGINPATH . 'include/functions.php');
require_once(WPYR_PLUGINPATH . 'include/admin.php');
require_once(WPYR_PLUGINPATH . 'include/shortcodes.php');
require_once(WPYR_PLUGINPATH . 'include/output.php');

if ( is_admin() ) 
{
	require_once(WPYR_PLUGINPATH . 'include/help.php');
}

?>