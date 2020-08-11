<?php
/*---------- Help ----------*/
/**
 * Create help tabs for admin panel 
 * TODO: 
 **/

# add help tabs
//add_action('admin_head', 'codex_wpyr_help_tab');

function codex_wpyr_help_tab() {
	$screen = get_current_screen();

	$about_help = '<h3>' . __( 'About Yr Weather', 'yr-weather' ) . '</h3>'
	. '<p>' . __( 'This plugin use the weather service from <a href="https://yr.no">yr.no</a> to provide forecast for single point in time or sequence of hour-by-hour forecast by using shortcodes to be implemented on pages or posts.', 'yr-weather' ) . '</p>'
	. '<p>' . __( 'You can set your default settings and create templates for the shortcodes in these preferences. You can also override many of these preferences by adding attributes to individual shorcode implementations.', 'yr-weather' ) . '</p>'
	. '<p>' . __( 'This plugin is provided as full version, free-to-use under GPLv3 license. The yr.no weather service is a governmental service financed for by Norwegian tax-payers and are free to use under Creative Commons license.', 'yr-weather' ) . '</p>'
	. '<p>' . __( 'The weather symbols "outline" and "black" are made by the author of this plugin, and published under GPLv3 license. The symbols are loosely based on the weather icons provided by the yr.no weather service. The color weather icons are property of yr.no weather service and published under free-to-use MIT license on <a href="https://github.com/nrkno/yr-weather-symbols">GitHub</a>.', 'yr-weather' ) . '<br />&nbsp;</p>'
	. '<p>' . __( "This plugin do not collect any user data, and comply with the European GDPR Directive.", 'yr-weather' ) . '<br />&nbsp;</p>'
	. '<p>' . __( "Yr Weather Shortcode", 'yr-weather' ) . ' ' . __( "version", 'yr-weather' ) . ' ' . VERSION . '<br />&nbsp;</p>';
	$general_help = "<h3>" . __( 'General options for Yr Weather', 'yr-weather' ) . "</h3>
<table>
  <tbody>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">" . __( "Default place", "yr-weather" ) . "</th>
      <td valign=\"top\">" . __( 'The default location for weather forecast. To obtain correct definition of your location, go to <a href="https://yr.no" target="_blank">yr.no</a> and search for your location. Copy part of the URL from between "place/" and to the last "/" :', "yr-weather" ) . "<br>"
	. __( '<pre>https://www.yr.no/place/<span style="background-color: #ffff00;">Norway/Oslo/Oslo/Oslo</span>/?spr=eng</pre>', "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">" . __( "Offset", "yr-weather" ) . "</th>
      <td valign=\"top\">" . __( 'The offset in hours for the forecast. Using the @offset tag in your template will output a descriptive offset text like <em>"3 hours from now"</em> in your forecast or forecast loop. ', "yr-weather" ) . "<br>&nbsp;
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">" . __( "Icon set", "yr-weather" ) . "</th>
      <td valign=\"top\">" . __( 'You can choose from several different icon sets. The outline/black icons can be further modified with the options below. As a general rule you will need to use <em>fatter</em> icons, or color icons for smaller sizes.', "yr-weather" ) . "<br>&nbsp;
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">" . __( "Icon width and Icon height", "yr-weather" ) . "</th>
      <td valign=\"top\">" . __( 'Use any CSS definition like <em>100px</em>, <em>3em</em> or <em>100vw</em>.', "yr-weather" ) . "<br>&nbsp;
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">" . __( "Small icons", "yr-weather" ) . "</th>
      <td valign=\"top\">" . __( 'Choose the icon set for the smaller symbols you can implement in your template ([@symbol-temp] [@symbol-wind] [@symbol-dir] [@symbol-precip] [@symbol-pressure]). As a general rule you will need to use <em>fatter</em> icons for smaller sizes.', "yr-weather" ) . "<br>&nbsp;
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">" . __( "Small icon width and height", "yr-weather" ) . "</th>
      <td valign=\"top\">" . __( 'Will apply to the icons/symbols you implement in your template. Use any CSS definition like <em>50px</em>, <em>3em</em> or <em>5vw</em>.', "yr-weather" ) . "<br>&nbsp;
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">" . __( "Use icon as color-mask", "yr-weather" ) . "</th>
      <td valign=\"top\">" . __( 'This this will let you add a color tint to the weather icons.', "yr-weather" ) . "<br>&nbsp;
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">" . __( "Icon mask color", "yr-weather" ) . "</th>
      <td valign=\"top\">" . __( 'The color used to tint the icons. The <em>outline</em> and <em>black</em> icons are black and transparent, and the color is achieved by coloring the background and using the icon as mask.', "yr-weather" ) . "<br>&nbsp;
	  </td>
    </tr>
  </tbody>
</table>";
	$options_template = "<h3>" . __( 'Template options for Yr Weather', 'yr-weather' ) . "</h3>
<table>
  <tbody>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">" . __( "Custom CSS", "yr-weather" ) . "</th>
      <td valign=\"top\">" . __( "Insert custom CSS to style the display of shortcodes. This CSS will be written to the <head> tag, but for optimized performance it is best practice to implement CSS-code in your theme.", "yr-weather" ) . "<br>" . __( 'You can use the tags <em style="color:green">_width_</em>, <em style="color:green">_height_</em> and <em style="color:green">_color_</em> to implement these from the General Options.', "yr-weather" ) . "<br>&nbsp;</td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\">" . __( "Custom HTML for single", "yr-weather" ) . "</th>
      <td valign=\"top\">" . __( "You can create your own custom layout that will be used in the shortcode. Use the tags listed below to place data-elements in your layout. The <em>Translatable texts</em> can be used to implement translatable texts to your layout.", "yr-weather" ) . "<br />&nbsp;</td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\">" . __( "Custom HTML for loop", "yr-weather" ) . "</th>
      <td valign=\"top\">" . __( "This HTML code will be used to display a sequence of forecasts with the shortcode. You can use all the tags above to implement data- and translatable texts", "yr-weather" ) . "<br>" . __( "In addition you can define a container to embrace the loop. Use the [@loop-start] and [@loop-end] tags to mark the start and end of the template for the individual forecasts.", "yr-weather" ) . "<br>" . __( "If you do not use the [@loop-start] and [@loop-end] tags, a &lt;DIV&gt; tag with the class from <em>Class for container</em> will be added.", "yr-weather" ) . "<br>&nbsp;</td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\">" . __( "Use single template for loop", "yr-weather" ) . "</th>
      <td valign=\"top\">" . __( "This option force use the <em>Custom HTML for single</em> in a loop/sequence of forecasts. If you have defined a loop template with [@loop-start] and [@loop-end], the template between these tags will be replaced by the single-template.", "yr-weather" ) . "<br>&nbsp;</td>
    </tr>
   <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\">" . __( "Class for container", "yr-weather" ) . "</th>
      <td valign=\"top\">" . __( "If you don't define a <em>Custom HTML for loop</em> or don't use the [@loop-start] and [@loop-end] tags, a &lt;DIV&gt; tag with this class will be added around the sequence/loop.", "yr-weather" ) . "<br>&nbsp;</td>
    </tr>
  </tbody>
</table>";
	$options_datatags_help = "<h3>" . __( 'Data tags for templates', 'yr-weather' ) . "</h3>
<p>" . __( "To implement weather data in your template you can use these tags.", "yr-weather" ) . "</p><table>
  <tbody>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@symbol]</th>
      <td valign=\"top\">" . __( "Creates a complete image tag for current weather symbol", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@symbol-url]</th>
      <td valign=\"top\">" . __( "URL to current weather symbol", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@place]</th>
      <td valign=\"top\">" . __( "Current location for weather forecast", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@date]</th>
      <td valign=\"top\">" . __( "Formatted and localized date as <em>August 1.</em>", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@date-time]</th>
      <td valign=\"top\">" . __( "Formatted and localized date and time of forecast as <em>August 1, 11.00 - 12.00</em>", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@time-from]</th>
      <td valign=\"top\">" . __( "Start of current forcast in hours as <em>11.00</em>", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@time-to]</th>
      <td valign=\"top\">" . __( "End of current forecast in hours as <em>12.00</em>", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@offset]</th>
      <td valign=\"top\">" . __( "Descriptive text for time of forecast as <em>In the next hour</em> or <em>3 hours from now</em>", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@offset-lowercase]</th>
      <td valign=\"top\">" . __( "Same as above but without capital letter (e.g for use mid-sentence)", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@description]</th>
      <td valign=\"top\">" . __( "A short description of current weather as <em>Cloudy</em>, <em>Fair</em>, <em>Light rain and thunder</em>", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@description-lowercase]</th>
      <td valign=\"top\">" . __( "Same as above but without capital letter (e.g for use mid-sentence)", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@temperature]</th>
      <td valign=\"top\">" . __( "Numeric representation of current temperature in degrees Celsius", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@temperature-f]</th>
      <td valign=\"top\">" . __( "Numeric representation of current temperature in degrees Fahrenheit", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@precipitation]</th>
      <td valign=\"top\">" . __( "Numeric representation of current precipitation in millimeter", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@pressure]</th>
      <td valign=\"top\">" . __( "Numeric representation of current barometric pressure in hPa, accurate to 1 decimal", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@windSpeed]</th>
      <td valign=\"top\">" . __( "Numeric representation of current wind speed in m/s", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@windDirection]</th>
      <td valign=\"top\">" . __( "Localized general direction of current wind as N, NNW, NW etc.", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@windDirection-int]</th>
      <td valign=\"top\">" . __( "Same as above but non-localized (e.g international English, N, NNW, NW etc.)", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@windText]</th>
      <td valign=\"top\">" . __( "Descriptive localized general direction of current wind as North, North-Northwest, Northwest etc.", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@windText-lowercase]</th>
      <td valign=\"top\">" . __( "Same as above but without capital letter (e.g for use mid-sentence)", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@windDegree]</th>
      <td valign=\"top\">" . __( "Numeric representation of current wind direction in degrees, accurate to 1 decimal", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@symbol-temp]</th>
      <td valign=\"top\">" . __( "Static image to represent temperature (thermometer)", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@symbol-wind]</th>
      <td valign=\"top\">" . __( "Static image to represent wind (curly lines)", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@symbol-dir]</th>
      <td valign=\"top\">" . __( "Dynamic image to represent general wind direction as N, NNW, NW etc. (arrow in circle)", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@symbol-precip]</th>
      <td valign=\"top\">" . __( "Static image to represent precipitation (umbrella)", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@symbol-pressure]</th>
      <td valign=\"top\">" . __( "Static image to represent atmospheric pressure (barometer)", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@temp-unit]</th>
      <td valign=\"top\">" . __( "Unit of temperature in dataset (e.g Celsius)", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@temp-unit]</th>
      <td valign=\"top\">" . __( "Correct spelling of Fahrenheit", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@pressure-scale]</th>
      <td valign=\"top\">" . __( "Unit of pressure in dataset (e.g hPa)", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@altitude]</th>
      <td valign=\"top\">" . __( "Altitude of current location", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@latitude]</th>
      <td valign=\"top\">" . __( "Latitude of current location, can be used to implement map (will require additional programming or plugin)", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@longitude]</th>
      <td valign=\"top\">" . __( "Longitude of current location, can be used to implement map", "yr-weather" ) . "
	  </td>
    </tr>
  </tbody>
</table>";
	$options_translate_help = "<h3>" . __( 'Translatable texts for templates', 'yr-weather' ) . "</h3>
<p>" . __( "There are several translatable <em>words</em> you can use in your template.", "yr-weather" ) . " "
	. __( "These are frequently used weather related words that will be shown in a localized translation.", "yr-weather" ) . " "
	. __( "The translatable texts below should be fairly self-explanatory.", "yr-weather" ) . " "
	. __( "And remember you can write most of the words starting with a capital letter, and the translation will start with a capital letter.", "yr-weather" ) . "</p><p>
[time] [from] [to] [and] [in] [at] [hour] [hours] [place] [precipitation] [wind] [windspeed] [wind-direction] 
[temperature] [degrees] [degree-symbol] [pressure] [air-pressure] [atmospheric-pressure] [barometric-pressure] 
[weather] [the-weather] [altitude] [MAS] [meters-above-sea] [latitude] [longitude]</p><p>"
	. __( "<strong>Note:</strong> if this plugin is not translated to your language, you can use a Wordpress plugin like <em>Loco Translate</em> to make the translation.", "yr-weather" ) . "</p>";
	$options_looptags_help = "<h3>" . __( 'Tags for loop in template', 'yr-weather' ) . "</h3>
<p>" . __( "In the template for loops you can use all the data tags, but additionally you have the option to define HTML-code for container surrounding the loop.", "yr-weather" ) . " "
	. __( "To separate the template for the loop from the container you must add [@loop-start] and [@loop-end].", "yr-weather" ) . " <br>"
	. __( "If you don't add these tags, a &lt;DIV&gt; tag with the class from <em>Class for container</em> will be added.", "yr-weather" ) . "</p><p>"
	. __( "Note: you have to use the attributes <strong><em>offset</em></strong> and <strong><em>end</em></strong> in the shortcode to enable loop.", "yr-weather" ) . "</p>
<table>
  <tbody>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@loop-start]</th>
      <td valign=\"top\">" . __( "This tag must be added after the surrounding container, before the code in the actual loop.", "yr-weather" ) . "
	  </td>
    </tr>
    <tr>
      <th align=\"left\"  scope=\"row\" valign=\"top\" width=\"25%\">[@loop-end]</th>
      <td valign=\"top\">" . __( "This tag must be added after the code in the actual loop, before the closing of the surrounding container.", "yr-weather" ) . "<br>"
	. __( "Take extra care to make sure you close every tag in the surrounding container.", "yr-weather" ) . "
	  </td>
    </tr>
  </tbody>
</table>";
	$options_shortcode = "<h3>" . __( 'Shortcodes for Yr Weather', 'yr-weather' ) . "</h3>
<p>" . __( "There are only one shortcode in this plugin, but all the options make it very versatile. For a full list of attributes and functionality please look in the <em>Shortcodes</em> tab in the main window.", "yr-weather" ) . '</p>
<em style="color:blue">[wpyr_weather place="Norway/Oslo/Oslo/Oslo" offset="6" end="18" interval="2" icon="fat" width="200px" height="200px" smallicon="black" smallwidth="50px" smallheight="50px" mask="yes" color="rgba(0,0,0,0.5)</em></p><p>';

	// Setup help tab args.
	$args_about = array(
		'id' => 'wpyr_about_tab', //unique id for the tab
		'title' => __( 'About Yr Weather', 'yr-weather' ), //unique visible title for the tab
		'content' => $about_help //actual help text
	);
	$args_general = array(
		'id' => 'wpyr_general_tab', //unique id for the tab
		'title' => __( 'General Options', 'yr-weather' ), //unique visible title for the tab
		'content' => $general_help //actual help text
	);
	$args_template = array(
		'id' => 'wpyr_template_tab', //unique id for the tab
		'title' => __( 'Template Options', 'yr-weather' ), //unique visible title for the tab
		'content' => $options_template //actual help text
	);
	$args_datatags = array(
		'id' => 'wpyr_datatags_tab', //unique id for the tab
		'title' => __( 'Data Tags', 'yr-weather' ), //unique visible title for the tab
		'content' => $options_datatags_help //actual help text
	);
	$args_looptags = array(
		'id' => 'wpyr_looptags_tab', //unique id for the tab
		'title' => __( 'Loop Tags', 'yr-weather' ), //unique visible title for the tab
		'content' => $options_looptags_help //actual help text
	);
	$args_translate = array(
		'id' => 'wpyr_translate_tab', //unique id for the tab
		'title' => __( 'Translatable texts', 'yr-weather' ), //unique visible title for the tab
		'content' => $options_translate_help //actual help text
	);
	$args_shortcode = array(
		'id' => 'wpyr_shortcode_tab', //unique id for the tab
		'title' => __( 'Shortcodes', 'yr-weather' ), //unique visible title for the tab
		'content' => $options_shortcode //actual help text
	);
	// Add the help tab.
	$screen->add_help_tab( $args_about );
	$screen->add_help_tab( $args_general );
	$screen->add_help_tab( $args_template );
	$screen->add_help_tab( $args_datatags );
	$screen->add_help_tab( $args_looptags );
	$screen->add_help_tab( $args_translate );
	$screen->add_help_tab( $args_shortcode );
}
?>