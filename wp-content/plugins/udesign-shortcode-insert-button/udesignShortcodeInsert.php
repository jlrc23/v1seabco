<?php 
/*
Plugin Name: U-Design Shortcode Insert Button
Plugin URI: 
Description: This plugin adds a button to the TinyMCE editor that allows a user to insert a <a title="Visit the U-Design Theme page" href="http://themeforest.net/item/udesign-wordpress-theme/253220?ref=internq7">U-Design Theme</a> specific shortcode into a post or page.
Author: Andon
Version: 1.1.8
Author URI: http://themeforest.net/user/internq7/portfolio?ref=internq7

"U-Design Shortcode Insert Button" requires the following:
- U-Design WordPress theme ( <a title="Visit the U-Design Theme page" href="http://themeforest.net/item/udesign-wordpress-theme/253220?ref=internq7">U-Design Theme</a> )
- TinyMCE V1.60+
- WordPress 2.6+

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

class UDesign_Shortcode_Insert {

	/**
	 * PHP5 constructor.
	 */
        public function __construct() {
            
		global $wp_version;
		// The current version
		define('udesignShortcodeInsert_VERSION', '1.1.8');
		
		// Check for WP2.6 installation
		if ( !defined ( 'IS_WP26' ) ) {
                    define( 'IS_WP26', version_compare($wp_version, '2.6', '>=' ) );
                }
                
		// This works only in WP2.6 or higher
		if ( IS_WP26 == false ) {
                    function udesign_shortcode_insert_admin_notice() {
                        echo '<div id="message" class="error fade"><p><strong>' . __( 'Sorry, udesignShortcodeInsert works only under WordPress 2.6 or higher', "udesignSI" ) . '</strong></p></div>';
                    }
                    add_action( 'admin_notices', 'udesign_shortcode_insert_admin_notice' );
                    return;
		}
		
		// define URL
		define( 'udesignShortcodeInsert_ABSPATH', WP_PLUGIN_DIR.'/'.plugin_basename( dirname(__FILE__) ).'/' );
		define( 'udesignShortcodeInsert_URLPATH', WP_PLUGIN_URL.'/'.plugin_basename( dirname(__FILE__) ).'/' );
		//define('udesignShortcodeInsert_TAXONOMY', 'wt_tag');
		
		include_once ( dirname (__FILE__)."/tinymce/tinymce.php" );
                
        }
        
        /**
	 * PHP4 construction (backward compatibility).
	 */
	public function UDesign_Shortcode_Insert() {
            // This will NOT invoked, unless a sub-class that extends `UDesign_Shortcode_Insert` calls it. In that case, call the new-style constructor to keep compatibility.
            self::__construct();
        }
        

}

function udesign_shortcode_insert_plugin_init() {
    global $udesignShortcodeInsert;
    $udesignShortcodeInsert = new UDesign_Shortcode_Insert();
}

// Start this plugin once all other plugins are fully loaded
add_action( 'plugins_loaded', 'udesign_shortcode_insert_plugin_init' );

