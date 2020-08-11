// JavaScript Document

( function( global, $ ) {
    var CSSeditor, HTMLeditor,
        syncCSS = function() {
            jQuery( '#wpyr_template_css_area' ).val( CSSeditor.getSession().getValue() );
            jQuery( '#wpyr_template_html_area' ).val( HTMLeditor.getSession().getValue() );
            jQuery( '#wpyr_template_loop_area' ).val( LOOPeditor.getSession().getValue() );
        },
        loadAce = function() {
            CSSeditor = ace.edit( 'css_area' );
            global.safecss_editor = CSSeditor;
            CSSeditor.getSession().setUseWrapMode( true );
            CSSeditor.setShowPrintMargin( false );
            CSSeditor.getSession().setValue( $( '#wpyr_template_css_area' ).val() );
            CSSeditor.getSession().setMode( "ace/mode/css" );
            jQuery.fn.spin&&$( '#css_area_container' ).spin( false );
			
            HTMLeditor = ace.edit( 'html_area' );
			global.safehtml_editor = HTMLeditor;
            HTMLeditor.getSession().setUseWrapMode( true );
            HTMLeditor.setShowPrintMargin( false );
            HTMLeditor.getSession().setValue( $( '#wpyr_template_html_area' ).val() );
            HTMLeditor.getSession().setMode( "ace/mode/html" );
            jQuery.fn.spin&&$( '#html_area_container' ).spin( false );

			LOOPeditor = ace.edit( 'loop_area' );
			global.safehtml_editor = LOOPeditor;
            LOOPeditor.getSession().setUseWrapMode( true );
            LOOPeditor.setShowPrintMargin( false );
            LOOPeditor.getSession().setValue( $( '#wpyr_template_loop_area' ).val() );
            LOOPeditor.getSession().setMode( "ace/mode/html" );
            jQuery.fn.spin&&$( '#loop_area_container' ).spin( false );

			jQuery( '#yr_weather_options' ).submit( syncCSS );
			
			CSSeditor.on("input", updateCSS);
			setTimeout(updateCSS, 100);
			HTMLeditor.on("input", updateHTML);
			setTimeout(updateHTML, 100);
			LOOPeditor.on("input", updateLOOP);
			setTimeout(updateLOOP, 100);
        },
		updateCSS = function() {
    		var shouldShow = !CSSeditor.session.getValue().length;
    		var node = CSSeditor.renderer.emptyMessageNode;
   			if (!shouldShow && node) {
        		CSSeditor.renderer.scroller.removeChild(CSSeditor.renderer.emptyMessageNode);
        		CSSeditor.renderer.emptyMessageNode = null;
    		} else if (shouldShow && !node) {
        		node = CSSeditor.renderer.emptyMessageNode = document.createElement("div");
        		node.textContent = wpyr_translate.placeholder_css;
        		node.className = "ace_invisible ace_emptyMessage";
        		node.style.padding = "0 9px";
        		CSSeditor.renderer.scroller.appendChild(node);
			}
        },
		updateHTML = function() {
    		var shouldShow2 = !HTMLeditor.session.getValue().length;
    		var node2 = HTMLeditor.renderer.emptyMessageNode;
   			if (!shouldShow2 && node2) {
        		HTMLeditor.renderer.scroller.removeChild(HTMLeditor.renderer.emptyMessageNode);
        		HTMLeditor.renderer.emptyMessageNode = null;
    		} else if (shouldShow2 && !node2) {
        		node2 = HTMLeditor.renderer.emptyMessageNode = document.createElement("div");
        		node2.textContent = wpyr_translate.placeholder_html;
        		node2.className = "ace_invisible ace_emptyMessage";
        		node2.style.padding = "0 9px";
        		HTMLeditor.renderer.scroller.appendChild(node2);
			}
		},
		updateLOOP = function() {
    		var shouldShow3 = !LOOPeditor.session.getValue().length;
    		var node3 = LOOPeditor.renderer.emptyMessageNode;
   			if (!shouldShow3 && node3) {
        		LOOPeditor.renderer.scroller.removeChild(LOOPeditor.renderer.emptyMessageNode);
        		LOOPeditor.renderer.emptyMessageNode = null;
    		} else if (shouldShow3 && !node3) {
        		node3 = LOOPeditor.renderer.emptyMessageNode = document.createElement("div");
        		node3.textContent = wpyr_translate.placeholder_html;
        		node3.className = "ace_invisible ace_emptyMessage";
        		node3.style.padding = "0 9px";
        		LOOPeditor.renderer.scroller.appendChild(node3);
			}
		};
    if ( $.browser.msie&&parseInt( $.browser.version, 10 ) <= 7 ) {
        jQuery( '#css_area_container' ).hide();
        jQuery( '#wpyr_template_css_area' ).show();
        jQuery( '#html_area_container' ).hide();
        jQuery( '#wpyr_template_html_area' ).show();
        jQuery( '#loop_area_container' ).hide();
        jQuery( '#wpyr_template_loop_area' ).show();
        return false;
    } else {
        jQuery( global ).load( loadAce );
    }
    global.aceSyncCSS = syncCSS;
} )( this, jQuery );

jQuery( document ).ready(function(e) {
	var wpyr_colorpicker_opts = {
		defaultColor: false,
		// a callback to fire whenever the color changes to a valid color
		change: function(event, ui){},
		// a callback to fire when the input is emptied or an invalid color
		clear: function() {},
		// hide the color picker controls on load
		hide: true,
		// show a group of common colors beneath the square
		// or, supply an array of colors to customize further
		palettes: true
	};
	jQuery('#wpyr_gen_iconcolor_text').wpColorPicker(wpyr_colorpicker_opts);
	jQuery('.allowCopy').click(function() {
     	jQuery(this).focus();
     	jQuery(this).select();
     	document.execCommand('copy');
   });
});