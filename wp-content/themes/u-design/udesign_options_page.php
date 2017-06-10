<?php

// Avoid direct calls to this file where wp core files not present
if (!function_exists ('add_action')) {
		header('Status: 403 Forbidden');
		header('HTTP/1.1 403 Forbidden');
		exit();
}

global $udesign_options, $google_webfonts, $google_webfonts_variants, $google_webfonts_subsets;
$udesign_options  = get_option('udesign_options');
include( get_template_directory() . '/scripts/admin/google-fonts/udesign-google-web-fonts.php' );
$google_webfonts = maybe_unserialize( udesign_google_fonts_families() );
$google_webfonts_variants = maybe_unserialize( udesign_google_fonts_variants() );
$google_fonts_variants_descriptions = udesign_google_fonts_variants_descriptions();
$google_webfonts_subsets = maybe_unserialize( udesign_google_fonts_subsets() );

$recaptcha_languages = array( "Arabic" => "ar", "Bulgarian" => "bg", "Catalan" => "ca", "Chinese (Simplified)" => "zh-CN", "Chinese (Traditional)" => "zh-TW", "Croatian" => "hr", "Czech" => "cs", "Danish" => "da", "Dutch" => "nl", "English (UK)" => "en-GB", "English (US)" => "en", "Filipino" => "fil", "Finnish" => "fi", "French" => "fr", "French (Canadian)" => "fr-CA", "German" => "de", "German (Austria)" => "de-AT", "German (Switzerland)" => "de-CH", "Greek" => "el", "Hebrew" => "iw", "Hindi" => "hi", "Hungarain" => "hu", "Indonesian" => "id", "Italian" => "it", "Japanese" => "ja", "Korean" => "ko", "Latvian" => "lv", "Lithuanian" => "lt", "Norwegian" => "no", "Persian" => "fa", "Polish" => "pl", "Portuguese" => "pt", "Portuguese (Brazil)" => "pt-BR", "Portuguese (Portugal)" => "pt-PT", "Romanian" => "ro", "Russian" => "ru", "Serbian" => "sr", "Slovak" => "sk", "Slovenian" => "sl", "Spanish" => "es", "Spanish (Latin America)" => "es-419", "Swedish" => "sv", "Thai" => "th", "Turkish" => "tr", "Ukrainian" => "uk", "Vietnamese" => "vi" );

// Class for the theme options
class UDesign_Theme_Options {

	/**
	 * PHP5 constructor.
	 */
        public function __construct() {
            add_action('admin_menu', array(&$this, 'udesign_admin_menu'));
            add_action('admin_init', array(&$this, 'register_udesign_theme_settings'));
            add_action('admin_post_save_udesign_options', array(&$this, 'on_save_changes'));
        }
        /**
	 * PHP4 construction (backward compatibility).
	 */
	public function UDesign_Theme_Options() {
            // This will NOT invoked, unless a sub-class that extends `UDesign_Theme_Options` calls it. In that case, call the new-style constructor to keep compatibility.
            self::__construct();
        }


	function init_udesign_theme_options() {
	    global $udesign_options;
	    if( $udesign_options['reset_to_defaults'] == 'yes' ) delete_option( "udesign_options");
	    if (! get_option("udesign_options")) {
		add_option( "udesign_options",
		    array( // intitialize the 'udesign_options' array with the following key => value pairs:
			    "reset_to_defaults" => '',
			    "custom_styles" => '',
			    "udesign_settings_page_last_saved_version" => UDESIGN_VERSION, // set a flag to indicate which version of the theme was the U-Design Settings page last saved by the user
			    "color_scheme" => "1",
			    "custom_logo_img" => "",
			    "top_area_height" => 110,
			    "logo_width" => 150,
			    "logo_height" => 85,
			    "logo_position_center" => "",
			    "slogan_distance_from_the_top" => 100,
			    "slogan_distance_from_the_left" => 0,
			    "slogan_font_size" => "12",
			    "top_page_phone_number" => "Call Us Free: 1-800-123-4567",
			    "enable_search" => "yes",
			    "enable_page_peel" => "",
			    "page_peel_url" => '',
			    "enable_feedback" => "",
			    "feedback_url" => '',
			    "feedback_position_fixed" => '',
			    "enable_prettyPhoto_script" => "yes",
			    "udesign_pretty_photo_style_theme" => "dark_rounded",
			    "udesign_disable_pretty_photo_gallery_overlay" => "",
			    "show_breadcrumbs" => "yes",
			    "disable_the_theme_update_notifier" => "no",
			    "enable_udesign_schema_tags" => "",
			    "udesign_disable_img_cropping" => "",
			    "udesign_enable_retina_images" => "",
			    "disable_smooth_scrolling_on_pages" => "",
			    "enable_default_style_css" => "no",
			    "fixed_main_menu" => "",
			    "fixed_menu_logo_disabled" => "",
                            "fixed_menu_logo" => "",
			    "add_fixed_menu_shadow" => "",
			    "remove_fixed_menu_background_image" => "",
			    "remove_fixed_menu_on_mobile_devices" => "",
			    "main_menu_alignment" => "right",
			    "main_menu_vertical_positioning" => 0,
			    "show_menu_auto_arrows" => "yes",
			    "show_menu_drop_shadows" => "",
			    "remove_border_under_menu" => "",
			    "enable_secondary_menu_bar" => "",
			    "secondary_menu_text_area_1" => get_udesign_text_area_1_dummy_content(),
			    "secondary_menu_text_area_1_alignment" => "left",
			    "secondary_menu_text_area_1_width" => 0,
			    "secondary_menu_text_area_2" => get_udesign_social_icons_html(),
			    "secondary_menu_text_area_2_alignment" => "right",
			    "secondary_menu_text_area_2_width" => 0,
			    "secondary_menu_term_id" => "select_menu",
			    "secondary_menu_text_alignment" => "center",
			    "secondary_menu_width" => 0,
			    "secondary_menu_items_order" => 'not_applicable',
			    "page_title_position" => "position1",
			    "home_page_col_1_fixed" => "",
			    "remove_default_page_sidebar" => "",
			    "pages_sidebar" => "left",
			    "pages_sidebar_2" => "left",
			    "pages_sidebar_3" => "left",
			    "pages_sidebar_4" => "left",
			    "pages_sidebar_5" => "left",
			    "pages_sidebar_6" => "left",
			    "pages_sidebar_7" => "left",
			    "pages_sidebar_8" => "left",
			    "sitemap_sidebar" => "right",
			    "show_comments_on_pages" => "no",
			    "max_theme_width" => "no",
			    "global_theme_width" => 960,
			    "global_sidebar_width" => 33,
			    "enable_google_web_fonts" => "",
			    "google_web_fonts_assoc" => array(),
			    "general_font_family" => "Arial",
			    "general_font_variant" => "",
			    "general_font_subset" => "",
			    "general_font_size" => "12",
                            "general_font_line_height" => "1.7",
			    "top_nav_font_family" => "Arial",
			    "top_nav_font_variant" => "",
			    "top_nav_font_subset" => "",
			    "top_nav_font_size" => "14",
			    "headings_font_family" => "Tahoma",
			    "headings_font_variant" => "",
			    "headings_font_subset" => "",
			    "headings_font_size_coefficient" => "1.0",
                            "headings_font_line_height" => "1.2",
			    "heading1_font_settings_enabled" => "",
			    "heading2_font_settings_enabled" => "",
			    "heading3_font_settings_enabled" => "",
			    "heading4_font_settings_enabled" => "",
			    "heading5_font_settings_enabled" => "",
			    "heading6_font_settings_enabled" => "",
			    "heading1_font_family" => "Tahoma",
			    "heading1_font_variant" => "",
			    "heading1_font_subset" => "",
			    "heading1_font_size" => "1.85",
                            "heading1_font_line_height" => "1.2",
			    "heading2_font_family" => "Tahoma",
			    "heading2_font_variant" => "",
			    "heading2_font_subset" => "",
			    "heading2_font_size" => "1.65",
                            "heading2_font_line_height" => "1.2",
			    "heading3_font_family" => "Tahoma",
			    "heading3_font_variant" => "",
			    "heading3_font_subset" => "",
			    "heading3_font_size" => "1.50",
                            "heading3_font_line_height" => "1.2",
			    "heading4_font_family" => "Tahoma",
			    "heading4_font_variant" => "",
			    "heading4_font_subset" => "",
			    "heading4_font_size" => "1.35",
                            "heading4_font_line_height" => "1.2",
			    "heading5_font_family" => "Tahoma",
			    "heading5_font_variant" => "",
			    "heading5_font_subset" => "",
			    "heading5_font_size" => "1.25",
                            "heading5_font_line_height" => "1.2",
			    "heading6_font_family" => "Tahoma",
			    "heading6_font_variant" => "",
			    "heading6_font_subset" => "",
			    "heading6_font_size" => "1.10",
                            "heading6_font_line_height" => "1.2",
			    "custom_colors_switch" => "disable",
			    "body_text_color" => "333333",
			    "main_link_color" => "FE5E08",
			    "main_link_color_hover" => "333333",
			    "main_headings_color" => "333333",
			    "top_bg_color" => "FBFBFB",
			    "top_text_color" => "999999",
			    "top_nav_background_color" => "FBFBFB",
			    "top_nav_background_opacity" => 0,
			    "top_nav_link_color" => "999999",
			    "top_nav_active_link_color" => "F95A09",
			    "top_nav_hover_link_color" => "777777",
			    "dropdown_nav_link_color" => "777777",
			    "dropdown_nav_hover_link_color" => "222222",
			    "dropdown_nav_background_color" => "EEEEEE",
			    "dropdown_nav_background_opacity" => 0.95,
                            "sec_menu_bg_color" => "212121",
			    "sec_menu_bg_opacity" => 0.95,
                            "sec_menu_text_color" => "EBEBEB",
                            "sec_menu_link_color" => "A3A3A3",
                            "sec_menu_link_hover_color" => "FF8400",
			    "page_title_color" => "333333",
			    "header_bg_color" => "FFFFFF",
			    "page_title_bg_color" => "FFFFFF",
			    "main_content_bg" => "FFFFFF",
			    "widget_title_color" => "333333",
			    "widget_text_color" => "333333",
			    "widget_bg_color" => "F8F8F8",
			    "bottom_bg_color" => "F5F5F5",
			    "bottom_title_color" => "FE5E08",
			    "bottom_text_color" => "333333",
			    "bottom_link_color" => "3D6E97",
			    "bottom_hover_link_color" => "000000",
			    "footer_bg_color" => "EAEAEA",
			    "footer_text_color" => "797979",
			    "footer_link_color" => "3D6E97",
			    "footer_hover_link_color" => "000000",
			    "top_bg_img" => "",
			    "top_bg_img_repeat" => "no-repeat",
			    "top_bg_img_position_horizontal" => "center",
			    "top_bg_img_position_vertical" => "top",
			    "header_bg_img" => "",
			    "header_bg_img_repeat" => "no-repeat",
			    "header_bg_img_position_horizontal" => "center",
			    "header_bg_img_position_vertical" => "top",
			    "home_page_before_content_bg_img" => "",
			    "home_page_before_content_bg_img_repeat" => "no-repeat",
			    "home_page_before_content_bg_img_position_horizontal" => "center",
			    "home_page_before_content_bg_img_position_vertical" => "top",
			    "page_title_bg_img" => "",
			    "page_title_bg_img_repeat" => "no-repeat",
			    "page_title_bg_img_position_horizontal" => "center",
			    "page_title_bg_img_position_vertical" => "top",
			    "main_content_bg_img" => "",
			    "main_content_bg_img_repeat" => "no-repeat",
			    "main_content_bg_img_position_horizontal" => "center",
			    "main_content_bg_img_position_vertical" => "top",
			    "bottom_bg_img" => "",
			    "bottom_bg_img_repeat" => "no-repeat",
			    "bottom_bg_img_position_horizontal" => "center",
			    "bottom_bg_img_position_vertical" => "top",
			    "footer_bg_img" => "",
			    "footer_bg_img_repeat" => "no-repeat",
			    "footer_bg_img_position_horizontal" => "center",
			    "footer_bg_img_position_vertical" => "top",
			    "one_continuous_bg_img" => "",
			    "one_continuous_bg_img_repeat" => "no-repeat",
			    "one_continuous_bg_img_position_horizontal" => "center",
			    "one_continuous_bg_img_position_vertical" => "top",
			    "one_continuous_bg_img_fixed" => "",
			    "one_continuous_bg_img_with_other_bg_imgs" => "",
			    "udesign_remove_horizontal_rulers" => "",
			    "save_current_colors_as_array" => "",
			    "saved_custom_colors_array" => array(),
			    "chosen_custom_colors" => '',
			    "chosen_custom_colors_admin_task" => '',
			    "current_slider" => '8',
			    "c1_slides_order_str" => "1",
			    "c1_slide_img_url_1" => esc_url_raw( get_template_directory_uri().'/sliders/cycle/cycle1/images/914x374_slide_01.jpg' ),
			    "c1_transition_type_1" => 'fade',
			    "c1_slide_link_url_1" => '',
			    "c1_slide_link_target_1" => 'self',
			    "c1_slide_image_alt_tag_1" => '',
			    "c1_speed" => 1000,
			    "c1_timeout" => 5000,
			    "c1_sync" => "yes",
			    "c1_remove_image_frame" => "",
			    "c1_remove_3d_shadow" => "yes",
			    "c2_slides_order_str" => "1",
			    "c2_slide_img_url_1" => esc_url_raw( get_template_directory_uri().'/sliders/cycle/cycle2/images/476x287_slide_01.jpg' ),
			    "c2_transition_type_1" => 'fade',
			    "c2_slide_link_url_1" => '',
			    "c2_slide_link_target_1" => 'self',
			    "c2_slide_image_alt_tag_1" => '',
			    "c2_slide_default_info_txt_1" => get_c2_slide_default_info_txt(),
			    "c2_slide_button_txt_1" => "Read More",
			    "c2_slide_button_style_1" => 'dark',
			    "c2_speed" => 1500,
			    "c2_timeout" => 5000,
			    "c2_sync" => "yes",
			    "c2_text_transition_on" => "yes",
			    "c2_text_color" => "333333",
			    "c2_slider_text_size" => "1.2",
			    "c2_slider_text_line_height" => "1.7",
			    "c3_slides_order_str" => "1",
			    "c3_slide_img_url_1" => esc_url_raw( get_template_directory_uri().'/sliders/cycle/cycle3/images/940x430_slide_01.jpg' ),
			    "c3_slide_img2_url_1" => esc_url_raw( get_template_directory_uri().'/sliders/cycle/cycle3/images/940x430_slide_02.png' ),
			    "c3_slide_link_url_1" => '',
			    "c3_slide_link_target_1" => 'self',
			    "c3_slide_image_alt_tag_1" => '',
			    "c3_slide_default_info_txt_1" => get_c3_slide_default_info_txt(),
			    "c3_timeout" => 5000,
			    "c3_autostop" => "",
			    "c3_text_color" => "FFFFFF",
			    "c3_slider_text_size" => "1.2",
			    "c3_slider_text_line_height" => "1.7",
			    "no_slider_text" => "Home",
			    "rev_slider_shortcode" => "",
			    "portfolio_categories" => array(),
			    "portfolio_pages_ids_array" => array(),
			    "portfolio_title_posistion" => "below",
			    "portfolio_sidebar" => "left",
			    "show_portfolio_postmetadata" => "yes",
			    "udesign_single_portfolio_postmetadata_location" => "alignbottom",
			    "show_portfolio_postmetadata_author" => "",
			    "show_portfolio_postmetadata_tags" => "",
			    "show_portfolio_comments" => "yes",
			    "remove_single_portfolio_sidebar" => "",
			    "show_single_portfolio_navigation" => "",
			    "blog_sidebar" => "right",
			    "show_excerpt" => "yes",
			    "excerpt_length_in_words" => 47,
			    "blog_button_text" => "Read more",
			    "exclude_portfolio_from_blog" => "yes",
			    "exclude_portfolio_from_recent_posts_widget" => "",
			    "exclude_portfolio_from_archives_widget" => "",
			    "exclude_portfolio_from_main_query" => "",
			    "show_postmetadata_author" => "",
			    "show_postmetadata_tags" => "",
			    "show_archive_for_string" => "",
			    "udesign_comment_field_to_bottom" => "",
			    "show_comments_are_closed_message" => "",
			    "remove_blog_sidebar" => "",
			    "remove_archive_sidebar" => "",
			    "remove_single_sidebar" => "",
			    "udesign_single_view_postmetadata_location" => "alignbottom",
			    "show_single_post_navigation" => "",
			    "display_post_image_in_single_post" => "",
			    "enable_custom_featured_image" => "",
			    "featured_image_width" => 150,
			    "featured_image_height" => 150,
			    "force_image_dimention" => "",
			    "featured_image_alignment" => "alignleft",
			    "remove_featured_image_frame" => "",
			    "show_contact_fields" => "yes",
			    "contact_field_name1" => "Address:",
			    "contact_field_value1" => "123 Street Name, Suite #",
			    "contact_field_value2" => "City, State 12345, Country",
			    "contact_field_name3" => "Phone:",
			    "contact_field_value3" => "(123) 123-4567",
			    "contact_field_name4" => "Fax:",
			    "contact_field_value4" => "(123) 123-4567",
			    "contact_field_name5" => "Toll Free:",
			    "contact_field_value5" => "(800) 123-4567",
			    "contact_sidebar" => "left",
			    "remove_contact_sidebar" => "",
			    "NA_phone_format" => "", // North American phone number check, disabled by default
			    "email_receipients" => get_option('admin_email'),
			    "recaptcha_enabled" => "no",
			    "recaptcha_publickey" => "",
			    "recaptcha_privatekey" => "",
			    "recaptcha_lang" => "en",
			    "copyright_message" => '&copy; 2016 <strong>U-Design</strong>',
			    "show_wp_link_in_footer" => "yes",
			    "show_udesign_affiliate_link" => "",
			    "affiliate_username" => "",
			    "show_entries_rss_in_footer" => "yes",
			    "show_comments_rss_in_footer" => "yes",
			    "udesign_sticky_footer" => "",
			    "google_analytics" => "",
			    "enable_responsive" => "",
			    "responsive_logo_img" => "",
			    "responsive_logo_height" => 150,
			    "responsive_remove_secondary_menu" => "",
			    "responsive_remove_slider_area" => "",
			    "responsive_remove_bg_images_960-720" => "",
			    "responsive_menu" => "responsive_menu_1",
			    "menu_2_screen_width" => "",
			    "responsive_pinch_to_zoom" => "",
			    "responsive_disable_pretty_photo_at_width" => 0,
			    "show_udesign_action_hooks" => ""
                        )
		);
	    }
	    //Add more options here if needed
	    //if (! get_option("another_of_my_options")) {
	    //    add_option("another_of_my_options", "Hi there!!!");
	    //}
	}

	function register_udesign_theme_settings() {
	    register_setting( 'udesign_options_page', 'udesign_options', array(&$this, 'validate_options') );
	    // register_setting( 'udesign_options_page', array(&$this, 'another_of_my_options') );         
        }
        
	//extend the admin menu
	function udesign_admin_menu() {
		$this->init_udesign_theme_options();
		// Add the U-Design options menu
		$this->pagehook = add_menu_page('U-Design Theme', esc_html__('U-Design', 'udesign'), who_can_edit_udesign_theme_options(), 'udesign_options_page', array(&$this, 'udesign_generate_options_page'), 'dashicons-star-filled');
		add_action('load-'.$this->pagehook, array(&$this, 'on_load_page'));
	}

	function on_load_page() {
                global $udesign_options, $google_webfonts_variants, $google_fonts_variants_descriptions, $google_webfonts_subsets;
                $enable_google_web_fonts = isset( $udesign_options['enable_google_web_fonts'] ) ? $udesign_options['enable_google_web_fonts'] : '';
                
		wp_enqueue_style('style', get_template_directory_uri().'/scripts/admin/style.css', false, '1.0', 'screen');
                wp_enqueue_media();
                
                // load the select2 script css
                wp_enqueue_style('u-design-select2', get_template_directory_uri() . '/scripts/admin/select2/css/select2.min.css', false, '4.0.2', 'screen');
                // load the "select2" scripts
                wp_enqueue_script('u-design-select2', get_template_directory_uri() . '/scripts/admin/select2/js/select2.min.js', array('jquery'), '4.0.2', true);
                
                // Load the main admin scripts for the theme's settings page
		//wp_register_script('admin-scripts', get_template_directory_uri().'/scripts/admin/scripts.js', array('jquery'), UDESIGN_VERSION, true);
		wp_register_script('admin-scripts', get_template_directory_uri().'/scripts/admin/scripts.min.js', array('jquery'), UDESIGN_VERSION, true);
		wp_enqueue_script('admin-scripts');
                wp_localize_script( 'admin-scripts', 'admin_scripts_params', array(
                                        'enable_google_web_fonts' => $enable_google_web_fonts,
                                        'google_webfonts_variants' => $google_webfonts_variants,
                                        'google_fonts_variants_descriptions' => $google_fonts_variants_descriptions,
                                        'google_webfonts_subsets' => $google_webfonts_subsets,
                                        'font_family_select2_placeholder' => esc_html__('Choose a Font', 'udesign'),
                                        'custom_colors_switch' => $udesign_options['custom_colors_switch'],
                                        'current_slider' => $udesign_options['current_slider']
                                    )
                                  );
                
		// load tablednd scripts for all sliders except Revolution slider
                if ( $udesign_options['current_slider'] != 8) {
                    wp_register_script('tablednd', get_template_directory_uri().'/scripts/admin/jquery.tablednd.js', array('jquery'), '0.6', true);
                    wp_enqueue_script('tablednd');
                    wp_register_script('sliders-scripts', get_template_directory_uri().'/scripts/admin/sliders.scripts.js', array('jquery','tablednd'), '1.0', true);
                    wp_enqueue_script('sliders-scripts');
                }
		//load color picker scripts
		wp_enqueue_style('ud-colorpicker-style', get_template_directory_uri().'/scripts/admin/colorpicker/css/colorpicker.css', false, '1.0', 'screen');
		wp_register_script('ud-colorpicker', get_template_directory_uri().'/scripts/admin/colorpicker/js/colorpicker.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script('ud-colorpicker');
                
                
                // jQuery validation script
                wp_enqueue_script('jquery_validate_lib', get_template_directory_uri()."/scripts/jquery-validate/jquery.validate.min.js", array('jquery'), '1.11.1', false);
                wp_enqueue_script('masked_input_plugin', get_template_directory_uri()."/scripts/masked-input-plugin/jquery.maskedinput.min.js", array('jquery'), '1.3.1', false);
                
                
                
                global $wp_scripts;
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-slider');
                wp_enqueue_script('jquery-ui-tooltip');
                wp_enqueue_script('jquery-ui-sortable');
                wp_enqueue_script('jquery-ui-resizable');
                // get the jquery ui object
                $queryui = $wp_scripts->query('jquery-ui-core');
                // load the jquery ui theme
                $scheme = is_ssl() ? 'https://' : 'http://';
                $url = $scheme . "code.jquery.com/ui/".$queryui->ver."/themes/flick/jquery-ui.min.css";
                wp_enqueue_style('jquery-ui-flick', $url, false, null);

                
		// load javascripts to allow drag/drop, expand/collapse and hide/show of boxes
		wp_enqueue_script('common');
		wp_enqueue_script('wp-lists');
		wp_enqueue_script('postbox');

		add_meta_box('udesign-help-options-metabox', esc_html__('Help', 'udesign'), array(&$this, 'help_options_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('udesign-general-options-metabox', esc_html__('General Options', 'udesign'), array(&$this, 'general_options_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('udesign-menus-options-metabox', esc_html__('Menus Options', 'udesign'), array(&$this, 'menus_options_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('udesign-layout-options-metabox', esc_html__('Layout Options', 'udesign'), array(&$this, 'layout_options_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('udesign-font-settings-metabox', esc_html__('Font Settings', 'udesign'), array(&$this, 'font_settings_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('udesign-custom-colors-metabox', esc_html__('Custom Colors', 'udesign'), array(&$this, 'custom_colors_options_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('udesign-front-page-options-metabox', esc_html__('Front Page Sliders', 'udesign'), array(&$this, 'front_page_options_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('udesign-portfolio-section-options-metabox', esc_html__('Portfolio Section', 'udesign'), array(&$this, 'portfolio_section_options_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('udesign-blog-section-options-metabox', esc_html__('Blog Section', 'udesign'), array(&$this, 'blog_section_options_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('udesign-contact_page-options-metabox', esc_html__('Contact Page', 'udesign'), array(&$this, 'contact_page_options_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('udesign-footer-options-metabox', esc_html__('Footer Options', 'udesign'), array(&$this, 'footer_options_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('udesign-statistics-options-metabox', esc_html__('Statistics', 'udesign'), array(&$this, 'statistics_options_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('udesign-responsive-options-metabox', esc_html__('Responsive Layout', 'udesign'), array(&$this, 'responsive_options_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('udesign-advanced-options-metabox', esc_html__('Advanced Options', 'udesign'), array(&$this, 'advanced_options_contentbox'), $this->pagehook, 'normal', 'core');
                
                // get the current user ID
                if ( current_user_can('manage_options') ) {
                    $curr_user = get_current_user_id();
                    // close metaboxes when the U-Design options page is visited for the very first time
                    if ( !get_user_meta( $curr_user, "closedpostboxes_$this->pagehook", false ) ) {
                        update_user_meta( 
                                $curr_user, 
                                "closedpostboxes_$this->pagehook", 
                                array(
                                    // 'udesign-help-options-metabox', 
                                    'udesign-general-options-metabox', 
                                    'udesign-menus-options-metabox', 
                                    'udesign-layout-options-metabox', 
                                    'udesign-font-settings-metabox', 
                                    'udesign-custom-colors-metabox', 
                                    'udesign-front-page-options-metabox', 
                                    'udesign-portfolio-section-options-metabox', 
                                    'udesign-blog-section-options-metabox', 
                                    'udesign-contact_page-options-metabox', 
                                    'udesign-footer-options-metabox', 
                                    'udesign-statistics-options-metabox', 
                                    'udesign-responsive-options-metabox',
                                    // 'udesign-advanced-options-metabox'
                                )
                         );
                    }
                    
                    // hide the "Advanced Options" metabox by default. The user can toggle this option from the "Screen Options"
                    if ( '' == get_user_meta( $curr_user, "udesign_hidden_metaboxes_by_default", array( 'udesign-advanced-options-metabox' ) ) ) {
                        update_user_meta( $curr_user, "metaboxhidden_$this->pagehook", array( 'udesign-advanced-options-metabox' ) );
                        // add the following user specific meta to know which metabox options need to be hidden by default.
                        add_user_meta( $curr_user, "udesign_hidden_metaboxes_by_default", array( 'udesign-advanced-options-metabox' ), true );
                    }
                    
                }
        }

	function udesign_generate_options_page() {

		// global screen column value to be able to have a sidebar in WordPress 2.8+
		global $screen_layout_columns, $udesign_options;

		/* Messages to display saved and reset */
		if ( isset($_GET['settings-updated']) || isset($_GET['updated']) ) { 
                    echo '<div id="message" class="updated fade"><p><strong>'.esc_html__('Settings saved.', 'udesign').'</strong></p></div>';
                    
                    $file_was_included = true; // used in preventing direct access of 'styles/custom/custom_style.php'
                    // Update custom styles css file
                    $udesign_custom_style_css = trailingslashit( get_template_directory() ) . 'styles/custom/custom_style.css';
                    if ( is_writable($udesign_custom_style_css) ) {
                        set_theme_mod( 'udesign_custom_styles_use_css_file', 'yes' );
                        include_once( trailingslashit( get_template_directory() ) . 'styles/custom/custom_style.php' );
                        set_theme_mod( 'udesign_custom_style_last_modified', @filemtime( $udesign_custom_style_css ) );
                    } else {
                        remove_theme_mod( 'udesign_custom_styles_use_css_file' );
                    }
                }
                
		//if ( $_GET['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.esc_html__('Settings reset.', 'udesign').'</strong></p></div>'; ?>
		<div id="udesign-metaboxes-general" class="wrap">
		    <div style="float:left; padding:0 10px 10px 0;"><img src="<?php echo get_template_directory_uri(); ?>/scripts/admin/images/u-design-logo-small.png" /></div>
		    <h1 style="padding-top:25px; padding-bottom: 30px;"><?php printf( __('Options <small>(version %1$s)</small>', 'udesign'), UDESIGN_VERSION ); ?></h1>
<?php 
		    $theme_home_directory = substr(strrchr( get_template_directory(), "/" ), 1 );
		    if ( $theme_home_directory != 'u-design' || strpos(get_template_directory(), '/U-Design-WP-Theme/u-design') || strpos(get_template_directory(), '/u-design/u-design') ) {
			echo '<div id="message" class="error fade"><p>The current directory structure to the theme is not valid! The CORRECT path is: <code>wp-content/themes/u-design/...(theme files)</code></p>
				<p style="line-height:1.5;">You have either not installed the theme correctly or have renamed the theme home directory. In either case the theme will not function properly.
				    Pease refer to <a href="http://support.envato.com/index.php?/Knowledgebase/Article/View/269/0/my-wordpress-theme-isnt-working-what-should-i-do" target="_blank">this guide</a> or preview the Documentation included in the "Help" section below to install the theme correctly. Also, don\'t forget to unzip the zip file you downloaded from ThemeForest after purchase, the actual theme zip file would be inside the extracted folder as "u-design.zip"</p></div>';
		    }
?>
		    <form id="udesign_options_submit_form" method="post" action="options.php">
<?php			settings_fields( 'udesign_options_page' ); // Checks that the user can update options and also redirect the user back to the correct admin page (this form).
			$options = get_option('udesign_options');
			// Allows the 'closed' state of metaboxes to be remembered
			wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false );
			// Allows the order of metaboxes to be remembered
			wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>

			<div id="poststuff" class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
				<div id="post-body" class="has-sidebar">
					<div id="post-body-content" class="has-sidebar-content">
<?php					    do_meta_boxes($this->pagehook, 'normal', $options); ?>
<?php					    do_meta_boxes($this->pagehook, 'additional', $options); ?>
					    <div class="udesign-settings-main-submit-wrapper">
                                                <div class="submit">
                                                    <input type="hidden" id="udesign_submit" value="1" name="udesign_submit" />
                                                    <input class="button-primary left" type="submit" name="form-submit" value="<?php esc_attr_e('Save Changes', 'udesign') ?>" />
                                                    <span class="spinner"></span>
                                                </div>
                                                <label for="reset_to_defaults" class="reset-to-defaults">
						    <input name="udesign_options[reset_to_defaults]" type="checkbox" id="reset_to_defaults" value="yes" />
						    <?php esc_attr_e('Reset to defaults', 'udesign') ?>
						</label>
					    </div>
					</div>
				</div>
				<br class="clear"/>
			</div>
		    </form>
<?php		    /* The reset button */; ?>
<!--		    <form method="post">
			<p class="submit">
			    <input name="reset" type="submit" value="Reset" />
			    <input type="hidden" name="action" value="reset" />
			</p>
		    </form> -->
		</div>
		<script type="text/javascript">
		    //<![CDATA[
		    jQuery(document).ready( function($) {
			    // close postboxes that should be closed
			    $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			    // postboxes setup
			    postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
                            
                            // Confirm the reset
                            $('#reset_to_defaults').click(function() {
                                if ( $(this).is(':checked') ) {
                                    this.checked = confirm("Are you sure you want to reset all options?");
                                    $(this).trigger("change");
                                }
                            });
		    });
		    //]]>
		</script>
<?php	}

	/**
	 * Validate user input
	 *
	 * @param array $input, an array of user input
	 * @return array Return an input array of sanitized input
	 */
	function validate_options( $input ) {
		global $udesign_options, $google_webfonts, $google_webfonts_variants, $google_webfonts_subsets, $portfolio_pages_array;

                $input['reset_to_defaults'] = $input['reset_to_defaults'];
                $input['custom_styles'] = $udesign_options['custom_styles'];
                $input['udesign_settings_page_last_saved_version'] = UDESIGN_VERSION;
                $input['color_scheme'] = $udesign_options['color_scheme'];
                
		// General Options
		$input['custom_logo_img'] = esc_url_raw($input['custom_logo_img']);
		$input['top_area_height'] = is_numeric( $input['top_area_height'] ) ? absint($input['top_area_height']) : $udesign_options['top_area_height'];
		$input['logo_width'] = is_numeric( $input['logo_width'] ) ? absint($input['logo_width']) : $udesign_options['logo_width'];
		$input['logo_height'] = is_numeric( $input['logo_height'] ) ? absint($input['logo_height']) : $udesign_options['logo_height'];
		$input['logo_position_center'] = $input['logo_position_center'];
		$input['slogan_distance_from_the_top'] =  ( $input['slogan_distance_from_the_top'] ) ? absint($input['slogan_distance_from_the_top']) : $udesign_options['slogan_distance_from_the_top'];
		$input['slogan_distance_from_the_left'] =  ( preg_match('/^0*([0-9]{1}|[0-9]{1,2}|[0-3]{1}[0-9]{1,2}|400)$/', $input['slogan_distance_from_the_left']) )  ? ($input['slogan_distance_from_the_left']) : $udesign_options['slogan_distance_from_the_left'];
		$input['slogan_font_size'] = (  $input['slogan_font_size'] ) ? $input['slogan_font_size'] : $udesign_options['slogan_font_size'];
		$input['top_page_phone_number'] = trim(stripslashes($input['top_page_phone_number']));
                $input['enable_search'] = ( isset($input['enable_search']) ) ? $input['enable_search'] : 'no';
                $input['enable_page_peel'] = $input['enable_page_peel'];
		$input['page_peel_url'] = esc_url_raw($input['page_peel_url']);
                $input['enable_feedback'] = $input['enable_feedback'];
		$input['feedback_url'] = esc_url_raw($input['feedback_url']);
                $input['feedback_position_fixed'] = $input['feedback_position_fixed'];
                $input['enable_prettyPhoto_script'] = $input['enable_prettyPhoto_script'];
		$input['udesign_pretty_photo_style_theme'] = ($input['udesign_pretty_photo_style_theme']) ? $input['udesign_pretty_photo_style_theme'] : $udesign_options['udesign_pretty_photo_style_theme'];
                $input['udesign_disable_pretty_photo_gallery_overlay'] = $input['udesign_disable_pretty_photo_gallery_overlay'];
                $input['disable_the_theme_update_notifier'] = $input['disable_the_theme_update_notifier'];
                $input['enable_udesign_schema_tags'] = $input['enable_udesign_schema_tags'];
                $input['udesign_disable_img_cropping'] = $input['udesign_disable_img_cropping'];
                $input['udesign_enable_retina_images'] = $input['udesign_enable_retina_images'];
                $input['disable_smooth_scrolling_on_pages'] = $input['disable_smooth_scrolling_on_pages'];
                $input['enable_default_style_css'] = $input['enable_default_style_css'];

		// Main Menu Options
                $input['fixed_main_menu'] = $input['fixed_main_menu'];
                $input['fixed_menu_logo_disabled'] = $input['fixed_menu_logo_disabled'];
		$input['fixed_menu_logo'] = esc_url_raw($input['fixed_menu_logo']);
                $input['add_fixed_menu_shadow'] = $input['add_fixed_menu_shadow'];
                $input['remove_fixed_menu_background_image'] = $input['remove_fixed_menu_background_image'];
                $input['remove_fixed_menu_on_mobile_devices'] = $input['remove_fixed_menu_on_mobile_devices'];
		$input['main_menu_alignment'] = ($input['main_menu_alignment']) ? $input['main_menu_alignment'] : $udesign_options['main_menu_alignment'];
		$input['main_menu_vertical_positioning'] =  ( $input['main_menu_vertical_positioning'] >= 0  ) ? $input['main_menu_vertical_positioning'] : $udesign_options['main_menu_vertical_positioning'];
                $input['show_menu_drop_shadows'] = $input['show_menu_drop_shadows'];
                $input['remove_border_under_menu'] = $input['remove_border_under_menu'];
		// Secondary Menu Options
                $input['enable_secondary_menu_bar'] = $input['enable_secondary_menu_bar'];
		$input['secondary_menu_text_area_1'] = stripslashes($input['secondary_menu_text_area_1']);
		$input['secondary_menu_text_area_2'] = stripslashes($input['secondary_menu_text_area_2']);
		$input['secondary_menu_term_id'] = ($input['secondary_menu_term_id']) ? $input['secondary_menu_term_id'] : $udesign_options['secondary_menu_term_id'];
		$input['secondary_menu_text_area_1_alignment'] = ($input['secondary_menu_text_area_1_alignment']) ? $input['secondary_menu_text_area_1_alignment'] : $udesign_options['secondary_menu_text_area_1_alignment'];
		$input['secondary_menu_text_area_2_alignment'] = ($input['secondary_menu_text_area_2_alignment']) ? $input['secondary_menu_text_area_2_alignment'] : $udesign_options['secondary_menu_text_area_2_alignment'];
		$input['secondary_menu_text_alignment'] = ($input['secondary_menu_text_alignment']) ? $input['secondary_menu_text_alignment'] : $udesign_options['secondary_menu_text_alignment'];
                // make sure the total secondary menu bar items' width don't exceed 24
                $secondary_menu_total_width_is_ok = ( $input['secondary_menu_text_area_1_width'] + $input['secondary_menu_text_area_2_width'] + $input['secondary_menu_width'] <= 24 ) ? true : false;
                $input['secondary_menu_text_area_1_width'] = ( $secondary_menu_total_width_is_ok ) ? $input['secondary_menu_text_area_1_width'] : $udesign_options['secondary_menu_text_area_1_width'];
                $input['secondary_menu_text_area_2_width'] = ( $secondary_menu_total_width_is_ok ) ? $input['secondary_menu_text_area_2_width'] : $udesign_options['secondary_menu_text_area_2_width'];
                $input['secondary_menu_width'] = ( $secondary_menu_total_width_is_ok ) ? $input['secondary_menu_width'] : $udesign_options['secondary_menu_width'];
		$input['secondary_menu_items_order'] = ($input['secondary_menu_items_order']) ? $input['secondary_menu_items_order'] : $udesign_options['secondary_menu_items_order'];
                
                // Layout Options
		$input['page_title_position'] = (  $input['page_title_position'] ) ? $input['page_title_position'] : $udesign_options['page_title_position'];
                $input['home_page_col_1_fixed'] = $input['home_page_col_1_fixed'];
                $input['remove_default_page_sidebar'] = $input['remove_default_page_sidebar'];
		$input['pages_sidebar'] = ($input['pages_sidebar']) ? $input['pages_sidebar'] : $udesign_options['pages_sidebar'];
		$input['pages_sidebar_2'] = ($input['pages_sidebar_2']) ? $input['pages_sidebar_2'] : $udesign_options['pages_sidebar_2'];
		$input['pages_sidebar_3'] = ($input['pages_sidebar_3']) ? $input['pages_sidebar_3'] : $udesign_options['pages_sidebar_3'];
		$input['pages_sidebar_4'] = ($input['pages_sidebar_4']) ? $input['pages_sidebar_4'] : $udesign_options['pages_sidebar_4'];
		$input['pages_sidebar_5'] = ($input['pages_sidebar_5']) ? $input['pages_sidebar_5'] : $udesign_options['pages_sidebar_5'];
		$input['pages_sidebar_6'] = ($input['pages_sidebar_6']) ? $input['pages_sidebar_6'] : $udesign_options['pages_sidebar_6'];
		$input['pages_sidebar_7'] = ($input['pages_sidebar_7']) ? $input['pages_sidebar_7'] : $udesign_options['pages_sidebar_7'];
		$input['pages_sidebar_8'] = ($input['pages_sidebar_8']) ? $input['pages_sidebar_8'] : $udesign_options['pages_sidebar_8'];
		$input['sitemap_sidebar'] = ($input['sitemap_sidebar']) ? $input['sitemap_sidebar'] : $udesign_options['sitemap_sidebar'];
                $input['show_comments_on_pages'] = $input['show_comments_on_pages'];
                $input['max_theme_width'] = $input['max_theme_width'];
		$input['global_theme_width'] = ( is_numeric( $input['global_theme_width']  ) && $input['global_theme_width'] > 959 && $input['global_theme_width'] < 1601 ) ? $input['global_theme_width'] : $udesign_options['global_theme_width'];
		$input['global_sidebar_width'] = ( is_numeric( $input['global_sidebar_width']  ) && $input['global_sidebar_width'] > 19 && $input['global_sidebar_width'] < 51 ) ? $input['global_sidebar_width'] : $udesign_options['global_sidebar_width'];
                
		// Font Settings
                $gf_general_font = $gf_top_nav_font = $gf_headings_font = $gf_heading1_font = $gf_heading2_font = $gf_heading3_font = $gf_heading4_font = $gf_heading5_font = $gf_heading6_font = $google_font_name_and_variant = $google_font_subsets = array();
                
                // General Body Text Font
		if( $input['general_font_family'] && ( in_array( $input['general_font_family'], $google_webfonts ) ) ) { // If a Google Web Font is selected
                    $input['general_font_variant'] = ( $input['general_font_variant'] ) ? $input['general_font_variant'] : $udesign_options['general_font_variant'];
                    $input['general_font_subset'] = ( $input['general_font_subset'] ) ? $input['general_font_subset'] : $udesign_options['general_font_subset'];
                    // Generate specially formatted array containing all of the above font options to be parsed later in "functions.php" for the browser
                    $gf_general_font = array( $input['general_font_family'] => array( "font_variant" => $input['general_font_variant'], "font_subset" => $input['general_font_subset'] ) );
                } else { // the case when generic font is selected
                    $input['general_font_family'] = ( $input['general_font_family'] ) ? $input['general_font_family'] : $udesign_options['general_font_family'];
                }
		$input['general_font_size'] = ( $input['general_font_size'] ) ? $input['general_font_size'] : $udesign_options['general_font_size'];
                $input['general_font_line_height'] = ( is_numeric( $input['general_font_line_height'] ) && $input['general_font_line_height'] >= 0.2 && $input['general_font_line_height'] <= 5.0 ) ? abs($input['general_font_line_height']) : $udesign_options['general_font_line_height'];
		
                // Top Navination Font
		if( $input['top_nav_font_family'] && ( in_array( $input['top_nav_font_family'], $google_webfonts ) ) ) { // If a Google Web Font is selected
                    $input['top_nav_font_variant'] = ( $input['top_nav_font_variant'] ) ? $input['top_nav_font_variant'] : $udesign_options['top_nav_font_variant'];
                    $input['top_nav_font_subset'] = ( $input['top_nav_font_subset'] ) ? $input['top_nav_font_subset'] : $udesign_options['top_nav_font_subset'];
                    // Generate specially formatted array containing all of the above font options to be parsed later in "functions.php" for the browser
                    $gf_top_nav_font = array( $input['top_nav_font_family'] => array( "font_variant" => $input['top_nav_font_variant'], "font_subset" => $input['top_nav_font_subset'] ) );
                } else { // the case when generic font is selected
                    $input['top_nav_font_family'] = ( $input['top_nav_font_family'] ) ? $input['top_nav_font_family'] : $udesign_options['top_nav_font_family'];
                }
		$input['top_nav_font_size'] = ( $input['top_nav_font_size'] ) ? $input['top_nav_font_size'] : $udesign_options['top_nav_font_size'];
                
                // Headings Fonts
		if( $input['headings_font_family'] && ( in_array( $input['headings_font_family'], $google_webfonts ) ) ) { // If a Google Web Font is selected
                    $input['headings_font_variant'] = ( $input['headings_font_variant'] ) ? $input['headings_font_variant'] : $udesign_options['headings_font_variant'];
                    $input['headings_font_subset'] = ( $input['headings_font_subset'] ) ? $input['headings_font_subset'] : $udesign_options['headings_font_subset'];
                    // Generate specially formatted array containing all of the above font options to be parsed later in "functions.php" for the browser
                    $gf_headings_font = array( $input['headings_font_family'] => array( "font_variant" => $input['headings_font_variant'], "font_subset" => $input['headings_font_subset'] ) );
                } else { // the case when generic font is selected
                    $input['headings_font_family'] = ( $input['headings_font_family'] ) ? $input['headings_font_family'] : $udesign_options['headings_font_family'];
                }
		$input['headings_font_size_coefficient'] = ( $input['headings_font_size_coefficient'] ) ? $input['headings_font_size_coefficient'] : $udesign_options['headings_font_size_coefficient'];
                $input['headings_font_line_height'] = ( is_numeric( $input['headings_font_line_height'] ) && $input['headings_font_line_height'] >= 0.2 && $input['headings_font_line_height'] <= 5.0 ) ? abs($input['headings_font_line_height']) : $udesign_options['headings_font_line_height'];

                /**
                 *  Heading 1 through 6
                 * 
                 *  Dynamically generated names:
                 *      'heading1_font_family', 'heading1_font_variant', 'heading1_font_subset', 'heading1_font_size', 'heading1_font_line_height'
                 *      'heading2_font_family', 'heading2_font_variant', 'heading2_font_subset', 'heading2_font_size', 'heading2_font_line_height'
                 *      'heading3_font_family', 'heading3_font_variant', 'heading3_font_subset', 'heading3_font_size', 'heading3_font_line_height'
                 *      'heading4_font_family', 'heading4_font_variant', 'heading4_font_subset', 'heading4_font_size', 'heading4_font_line_height'
                 *      'heading5_font_family', 'heading5_font_variant', 'heading5_font_subset', 'heading5_font_size', 'heading5_font_line_height'
                 *      'heading6_font_family', 'heading6_font_variant', 'heading6_font_subset', 'heading6_font_size', 'heading6_font_line_height'
                 * 
                 *  Dynamically generated variables:
                 *      $gf_heading1_font, $gf_heading2_font, $gf_heading3_font, $gf_heading4_font, $gf_heading5_font, $gf_heading6_font
                 * 
                 */
                for ( $i = 1; $i <= 6; $i++ ) {
                    if( $input['heading'.$i.'_font_family'] && ( in_array( $input['heading'.$i.'_font_family'], $google_webfonts ) ) ) { // If a Google Web Font is selected
                        $input['heading'.$i.'_font_variant'] = ( $input['heading'.$i.'_font_variant'] ) ? $input['heading'.$i.'_font_variant'] : $udesign_options['heading'.$i.'_font_variant'];
                        $input['heading'.$i.'_font_subset'] = ( $input['heading'.$i.'_font_subset'] ) ? $input['heading'.$i.'_font_subset'] : $udesign_options['heading'.$i.'_font_subset'];
                        // Generate specially formatted array containing all of the above font options to be parsed later in "functions.php" for the browser
                        ${'gf_heading'.$i.'_font'} = array( $input['heading'.$i.'_font_family'] => array( "font_variant" => $input['heading'.$i.'_font_variant'], "font_subset" => $input['heading'.$i.'_font_subset'] ) );
                    } else { // the case when generic font is selected
                        $input['heading'.$i.'_font_family'] = ( $input['heading'.$i.'_font_family'] ) ? $input['heading'.$i.'_font_family'] : $udesign_options['heading'.$i.'_font_family'];
                    }
                    $input['heading'.$i.'_font_size'] = ( $input['heading'.$i.'_font_size'] ) ? $input['heading'.$i.'_font_size'] : $udesign_options['heading'.$i.'_font_size'];
                    $input['heading'.$i.'_font_line_height'] = ( is_numeric( $input['heading'.$i.'_font_line_height'] ) && $input['heading'.$i.'_font_line_height'] >= 0.2 && $input['heading'.$i.'_font_line_height'] <= 5.0 ) ? abs($input['heading'.$i.'_font_line_height']) : $udesign_options['heading'.$i.'_font_line_height'];
                }
                
                // Make sure Googe Fonts are enabled before proceeding with generating the final 'google_web_fonts_assoc' array
		if( isset($input['enable_google_web_fonts']) && $input['enable_google_web_fonts'] == 'yes' && 
                                            (!empty($gf_general_font) || !empty($gf_top_nav_font) || !empty($gf_headings_font) || 
                                             !empty($gf_heading1_font) || !empty($gf_heading2_font) || !empty($gf_heading3_font) ||
                                             !empty($gf_heading4_font) || !empty($gf_heading5_font) || !empty($gf_heading6_font) ) ) {
                    // This array will merge two or more arrays recursively
                    $all_selected_gfs = array_merge_recursive( $gf_general_font, $gf_top_nav_font, $gf_headings_font, $gf_heading1_font, $gf_heading2_font, $gf_heading3_font, $gf_heading4_font, $gf_heading5_font, $gf_heading6_font );
                    foreach( $all_selected_gfs as $font_name => $font_optns ) {
                        $google_font_variants = ( is_array($font_optns['font_variant']) ) ? implode(",", array_unique($font_optns['font_variant'])) : $font_optns['font_variant'];
                        $google_font_subsets[] = ( is_array($font_optns['font_subset']) ) ? implode(",", array_unique($font_optns['font_subset'])) : $font_optns['font_subset'];
                        $font = $font_name . ":" . $google_font_variants;
                        $google_font_name_and_variant[] = $font;
                    }
                    $input['google_web_fonts_assoc'] = array( 
                                    'font_name_and_variant'  =>  $google_font_name_and_variant,
                                    'font_subsets'           =>  array_unique($google_font_subsets)
                            );
		} else { // if disabled clear the 'google_web_fonts_assoc' array
			unset($input['google_web_fonts_assoc']);
			$input['google_web_fonts_assoc'] = array();
		}
                
                
                
		// Custom Colors
		if(isset($input['save_current_colors_as_array']) && $input['save_current_colors_as_array'] == 'yes') {
		    $color_array_name = date_i18n('Y-m-d-H-i-s');
		    $udesign_options['saved_custom_colors_array'][$color_array_name] = array(
					"body_text_color"		=> $input['body_text_color'],
					"main_link_color"		=> $input['main_link_color'],
					"main_link_color_hover"		=> $input['main_link_color_hover'],
					"main_headings_color"		=> $input['main_headings_color'],
					"top_bg_color"			=> $input['top_bg_color'],
					"top_text_color"		=> $input['top_text_color'],
					"top_nav_background_color"	=> $input['top_nav_background_color'],
                                        "top_nav_background_opacity" => ( is_numeric( $input['top_nav_background_opacity'] ) && $input['top_nav_background_opacity'] >= 0 && $input['top_nav_background_opacity'] <= 1 ) ? abs($input['top_nav_background_opacity']) : $udesign_options['top_nav_background_opacity'],
					"top_nav_link_color"		=> $input['top_nav_link_color'],
					"top_nav_active_link_color"	=> $input['top_nav_active_link_color'],
					"top_nav_hover_link_color"	=> $input['top_nav_hover_link_color'],
					"dropdown_nav_link_color"	=> $input['dropdown_nav_link_color'],
					"dropdown_nav_hover_link_color"	=> $input['dropdown_nav_hover_link_color'],
					"dropdown_nav_background_color"	=> $input['dropdown_nav_background_color'],
                                        "dropdown_nav_background_opacity" => ( is_numeric( $input['dropdown_nav_background_opacity'] ) && $input['dropdown_nav_background_opacity'] >= 0 && $input['dropdown_nav_background_opacity'] <= 1 ) ? abs($input['dropdown_nav_background_opacity']) : $udesign_options['dropdown_nav_background_opacity'],
					"sec_menu_bg_color"             => $input['sec_menu_bg_color'],
                                        "sec_menu_bg_opacity"           => ( is_numeric( $input['sec_menu_bg_opacity'] ) && $input['sec_menu_bg_opacity'] >= 0 && $input['sec_menu_bg_opacity'] <= 1 ) ? abs($input['sec_menu_bg_opacity']) : $udesign_options['sec_menu_bg_opacity'],
                                        "sec_menu_text_color"           => $input['sec_menu_text_color'],
                                        "sec_menu_link_color"           => $input['sec_menu_link_color'],
                                        "sec_menu_link_hover_color"	=> $input['sec_menu_link_hover_color'],
					"page_title_color"		=> $input['page_title_color'],
					"page_title_bg_color"		=> $input['page_title_bg_color'],
					"header_bg_color"		=> $input['header_bg_color'],
					"main_content_bg"		=> $input['main_content_bg'],
					"widget_title_color"		=> $input['widget_title_color'],
					"widget_text_color"		=> $input['widget_text_color'],
					"widget_bg_color"		=> $input['widget_bg_color'],
		    			"bottom_bg_color"		=> $input['bottom_bg_color'],
					"bottom_title_color"		=> $input['bottom_title_color'],
					"bottom_text_color"		=> $input['bottom_text_color'],
					"bottom_link_color"		=> $input['bottom_link_color'],
					"bottom_hover_link_color"	=> $input['bottom_hover_link_color'],
		    			"footer_bg_color"		=> $input['footer_bg_color'],
					"footer_text_color"		=> $input['footer_text_color'],
					"footer_link_color"		=> $input['footer_link_color'],
					"footer_hover_link_color"	=> $input['footer_hover_link_color'],
					"top_bg_img"                    => esc_url_raw($input['top_bg_img']),
					"top_bg_img_repeat"             => $input['top_bg_img_repeat'],
					"top_bg_img_position_horizontal"=> $input['top_bg_img_position_horizontal'],
					"top_bg_img_position_vertical"  => $input['top_bg_img_position_vertical'],
					"header_bg_img"                 => esc_url_raw($input['header_bg_img']),
					"header_bg_img_repeat"          => $input['header_bg_img_repeat'],
					"header_bg_img_position_horizontal"=> $input['header_bg_img_position_horizontal'],
					"header_bg_img_position_vertical"  => $input['header_bg_img_position_vertical'],
					"home_page_before_content_bg_img"  => esc_url_raw($input['home_page_before_content_bg_img']),
					"home_page_before_content_bg_img_repeat"  => $input['home_page_before_content_bg_img_repeat'],
					"home_page_before_content_bg_img_position_horizontal"=> $input['home_page_before_content_bg_img_position_horizontal'],
					"home_page_before_content_bg_img_position_vertical"  => $input['home_page_before_content_bg_img_position_vertical'],
					"page_title_bg_img"              => esc_url_raw($input['page_title_bg_img']),
					"page_title_bg_img_repeat"       => $input['page_title_bg_img_repeat'],
					"page_title_bg_img_position_horizontal"=> $input['page_title_bg_img_position_horizontal'],
					"page_title_bg_img_position_vertical"  => $input['page_title_bg_img_position_vertical'],
					"main_content_bg_img"            => esc_url_raw($input['main_content_bg_img']),
					"main_content_bg_img_repeat"     => $input['main_content_bg_img_repeat'],
					"main_content_bg_img_position_horizontal"=> $input['main_content_bg_img_position_horizontal'],
					"main_content_bg_img_position_vertical"  => $input['main_content_bg_img_position_vertical'],
					"bottom_bg_img"            => esc_url_raw($input['bottom_bg_img']),
					"bottom_bg_img_repeat"     => $input['bottom_bg_img_repeat'],
					"bottom_bg_img_position_horizontal"=> $input['bottom_bg_img_position_horizontal'],
					"bottom_bg_img_position_vertical"  => $input['bottom_bg_img_position_vertical'],
					"footer_bg_img"            => esc_url_raw($input['footer_bg_img']),
					"footer_bg_img_repeat"     => $input['footer_bg_img_repeat'],
					"footer_bg_img_position_horizontal"=> $input['footer_bg_img_position_horizontal'],
					"footer_bg_img_position_vertical"  => $input['footer_bg_img_position_vertical'],
					"one_continuous_bg_img"            => esc_url_raw($input['one_continuous_bg_img']),
					"one_continuous_bg_img_repeat"     => $input['one_continuous_bg_img_repeat'],
					"one_continuous_bg_img_position_horizontal"=> $input['one_continuous_bg_img_position_horizontal'],
					"one_continuous_bg_img_position_vertical"  => $input['one_continuous_bg_img_position_vertical'],
					"one_continuous_bg_img_fixed"  => $input['one_continuous_bg_img_fixed'],
					"one_continuous_bg_img_with_other_bg_imgs"  => $input['one_continuous_bg_img_with_other_bg_imgs'],
					"udesign_remove_horizontal_rulers"  => $input['udesign_remove_horizontal_rulers']
		    );
		    $input['saved_custom_colors_array'] = $udesign_options['saved_custom_colors_array'];
		    $input['save_current_colors_as_array'] = ''; // clear the checkbox
		} else {
		    // preserve the 'saved_custom_colors_array'
		    $input['saved_custom_colors_array'] = $udesign_options['saved_custom_colors_array'];
		}
		if( isset($input['chosen_custom_colors']) && $input['chosen_custom_colors'] != '' && $input['chosen_custom_colors'] != 'default' ) {
		    if( $input['chosen_custom_colors_admin_task'] == 'load') { // load a specific color scheme
			$chosen_colors_array = $input['saved_custom_colors_array'][$input['chosen_custom_colors']];
			$input['body_text_color'] = ( ctype_alnum($chosen_colors_array['body_text_color']) ) ? strtoupper(stripslashes($chosen_colors_array['body_text_color'])) : $udesign_options['body_text_color'];
			$input['main_link_color'] = ( ctype_alnum($chosen_colors_array['main_link_color']) ) ? strtoupper(stripslashes($chosen_colors_array['main_link_color'])) : $udesign_options['main_link_color'];
			$input['main_link_color_hover'] = ( ctype_alnum($chosen_colors_array['main_link_color_hover']) ) ? strtoupper(stripslashes($chosen_colors_array['main_link_color_hover'])) : $udesign_options['main_link_color_hover'];
			$input['main_headings_color'] = ( ctype_alnum($chosen_colors_array['main_headings_color']) ) ? strtoupper(stripslashes($chosen_colors_array['main_headings_color'])) : $udesign_options['main_headings_color'];
			$input['top_bg_color'] = ( ctype_alnum($chosen_colors_array['top_bg_color']) ) ? strtoupper(stripslashes($chosen_colors_array['top_bg_color'])) : $udesign_options['top_bg_color'];
			$input['top_text_color'] = ( ctype_alnum($chosen_colors_array['top_text_color']) ) ? strtoupper(stripslashes($chosen_colors_array['top_text_color'])) : $udesign_options['top_text_color'];
			$input['top_nav_background_color'] = ( ctype_alnum($chosen_colors_array['top_nav_background_color']) ) ? strtoupper(stripslashes($chosen_colors_array['top_nav_background_color'])) : $udesign_options['top_nav_background_color'];
                        $input['top_nav_background_opacity'] = ( is_numeric( $chosen_colors_array['top_nav_background_opacity'] ) && $chosen_colors_array['top_nav_background_opacity'] >= 0 && $chosen_colors_array['top_nav_background_opacity'] <= 1 ) ? abs($chosen_colors_array['top_nav_background_opacity']) : $udesign_options['top_nav_background_opacity'];
			$input['top_nav_link_color'] = ( ctype_alnum($chosen_colors_array['top_nav_link_color']) ) ? strtoupper(stripslashes($chosen_colors_array['top_nav_link_color'])) : $udesign_options['top_nav_link_color'];
			$input['top_nav_active_link_color'] = ( ctype_alnum($chosen_colors_array['top_nav_active_link_color']) ) ? strtoupper(stripslashes($chosen_colors_array['top_nav_active_link_color'])) : $udesign_options['top_nav_active_link_color'];
			$input['top_nav_hover_link_color'] = ( ctype_alnum($chosen_colors_array['top_nav_hover_link_color']) ) ? strtoupper(stripslashes($chosen_colors_array['top_nav_hover_link_color'])) : $udesign_options['top_nav_hover_link_color'];
			$input['dropdown_nav_link_color'] = ( ctype_alnum($chosen_colors_array['dropdown_nav_link_color']) ) ? strtoupper(stripslashes($chosen_colors_array['dropdown_nav_link_color'])) : $udesign_options['dropdown_nav_link_color'];
			$input['dropdown_nav_hover_link_color'] = ( ctype_alnum($chosen_colors_array['dropdown_nav_hover_link_color']) ) ? strtoupper(stripslashes($chosen_colors_array['dropdown_nav_hover_link_color'])) : $udesign_options['dropdown_nav_hover_link_color'];
			$input['dropdown_nav_background_color'] = ( ctype_alnum($chosen_colors_array['dropdown_nav_background_color']) ) ? strtoupper(stripslashes($chosen_colors_array['dropdown_nav_background_color'])) : $udesign_options['dropdown_nav_background_color'];
                        $input['dropdown_nav_background_opacity'] = ( is_numeric( $chosen_colors_array['dropdown_nav_background_opacity'] ) && $chosen_colors_array['dropdown_nav_background_opacity'] >= 0 && $chosen_colors_array['dropdown_nav_background_opacity'] <= 1 ) ? abs($chosen_colors_array['dropdown_nav_background_opacity']) : $udesign_options['dropdown_nav_background_opacity'];
			$input['sec_menu_bg_color'] = ( ctype_alnum($chosen_colors_array['sec_menu_bg_color']) ) ? strtoupper(stripslashes($chosen_colors_array['sec_menu_bg_color'])) : $udesign_options['sec_menu_bg_color'];
                        $input['sec_menu_bg_opacity'] = ( is_numeric( $chosen_colors_array['sec_menu_bg_opacity'] ) && $chosen_colors_array['sec_menu_bg_opacity'] >= 0 && $chosen_colors_array['sec_menu_bg_opacity'] <= 1 ) ? abs($chosen_colors_array['sec_menu_bg_opacity']) : $udesign_options['sec_menu_bg_opacity'];
			$input['sec_menu_text_color'] = ( ctype_alnum($chosen_colors_array['sec_menu_text_color']) ) ? strtoupper(stripslashes($chosen_colors_array['sec_menu_text_color'])) : $udesign_options['sec_menu_text_color'];
			$input['sec_menu_link_color'] = ( ctype_alnum($chosen_colors_array['sec_menu_link_color']) ) ? strtoupper(stripslashes($chosen_colors_array['sec_menu_link_color'])) : $udesign_options['sec_menu_link_color'];
			$input['sec_menu_link_hover_color'] = ( ctype_alnum($chosen_colors_array['sec_menu_link_hover_color']) ) ? strtoupper(stripslashes($chosen_colors_array['sec_menu_link_hover_color'])) : $udesign_options['sec_menu_link_hover_color'];
			$input['page_title_color'] = ( ctype_alnum($chosen_colors_array['page_title_color']) ) ? strtoupper(stripslashes($chosen_colors_array['page_title_color'])) : $udesign_options['page_title_color'];
			$input['page_title_bg_color'] = ( ctype_alnum($chosen_colors_array['page_title_bg_color']) ) ? strtoupper(stripslashes($chosen_colors_array['page_title_bg_color'])) : $udesign_options['page_title_bg_color'];
			$input['header_bg_color'] = ( ctype_alnum($chosen_colors_array['header_bg_color']) ) ? strtoupper(stripslashes($chosen_colors_array['header_bg_color'])) : $udesign_options['header_bg_color'];
			$input['main_content_bg'] = ( ctype_alnum($chosen_colors_array['main_content_bg']) ) ? strtoupper(stripslashes($chosen_colors_array['main_content_bg'])) : $udesign_options['main_content_bg'];
			$input['widget_title_color'] = ( ctype_alnum($chosen_colors_array['widget_title_color']) ) ? strtoupper(stripslashes($chosen_colors_array['widget_title_color'])) : $udesign_options['widget_title_color'];
			$input['widget_text_color'] = ( ctype_alnum($chosen_colors_array['widget_text_color']) ) ? strtoupper(stripslashes($chosen_colors_array['widget_text_color'])) : $udesign_options['widget_text_color'];
			$input['widget_bg_color'] = ( ctype_alnum($chosen_colors_array['widget_bg_color']) ) ? strtoupper(stripslashes($chosen_colors_array['widget_bg_color'])) : $udesign_options['widget_bg_color'];
			$input['bottom_bg_color'] = ( ctype_alnum($chosen_colors_array['bottom_bg_color']) ) ? strtoupper(stripslashes($chosen_colors_array['bottom_bg_color'])) : $udesign_options['bottom_bg_color'];
			$input['bottom_title_color'] = ( ctype_alnum($chosen_colors_array['bottom_title_color']) ) ? strtoupper(stripslashes($chosen_colors_array['bottom_title_color'])) : $udesign_options['bottom_title_color'];
			$input['bottom_text_color'] = ( ctype_alnum($chosen_colors_array['bottom_text_color']) ) ? strtoupper(stripslashes($chosen_colors_array['bottom_text_color'])) : $udesign_options['bottom_text_color'];
			$input['bottom_link_color'] = ( ctype_alnum($chosen_colors_array['bottom_link_color']) ) ? strtoupper(stripslashes($chosen_colors_array['bottom_link_color'])) : $udesign_options['bottom_link_color'];
			$input['bottom_hover_link_color'] = ( ctype_alnum($chosen_colors_array['bottom_hover_link_color']) ) ? strtoupper(stripslashes($chosen_colors_array['bottom_hover_link_color'])) : $udesign_options['bottom_hover_link_color'];
			$input['footer_bg_color'] = ( ctype_alnum($chosen_colors_array['footer_bg_color']) ) ? strtoupper(stripslashes($chosen_colors_array['footer_bg_color'])) : $udesign_options['footer_bg_color'];
			$input['footer_text_color'] = ( ctype_alnum($chosen_colors_array['footer_text_color']) ) ? strtoupper(stripslashes($chosen_colors_array['footer_text_color'])) : $udesign_options['footer_text_color'];
			$input['footer_link_color'] = ( ctype_alnum($chosen_colors_array['footer_link_color']) ) ? strtoupper(stripslashes($chosen_colors_array['footer_link_color'])) : $udesign_options['footer_link_color'];
			$input['footer_hover_link_color'] = ( ctype_alnum($chosen_colors_array['footer_hover_link_color']) ) ? strtoupper(stripslashes($chosen_colors_array['footer_hover_link_color'])) : $udesign_options['footer_hover_link_color'];
                        $input['top_bg_img'] = esc_url_raw($chosen_colors_array['top_bg_img']);
                        $input['top_bg_img_repeat'] = $chosen_colors_array['top_bg_img_repeat'];
                        $input['top_bg_img_position_horizontal'] = $chosen_colors_array['top_bg_img_position_horizontal'];
                        $input['top_bg_img_position_vertical'] = $chosen_colors_array['top_bg_img_position_vertical'];
                        $input['header_bg_img'] = esc_url_raw($chosen_colors_array['header_bg_img']);
                        $input['header_bg_img_repeat'] = $chosen_colors_array['header_bg_img_repeat'];
                        $input['header_bg_img_position_horizontal'] = $chosen_colors_array['header_bg_img_position_horizontal'];
                        $input['header_bg_img_position_vertical'] = $chosen_colors_array['header_bg_img_position_vertical'];
                        $input['home_page_before_content_bg_img'] = esc_url_raw($chosen_colors_array['home_page_before_content_bg_img']);
                        $input['home_page_before_content_bg_img_repeat'] = $chosen_colors_array['home_page_before_content_bg_img_repeat'];
                        $input['home_page_before_content_bg_img_position_horizontal'] = $chosen_colors_array['home_page_before_content_bg_img_position_horizontal'];
                        $input['home_page_before_content_bg_img_position_vertical'] = $chosen_colors_array['home_page_before_content_bg_img_position_vertical'];
                        $input['page_title_bg_img'] = esc_url_raw($chosen_colors_array['page_title_bg_img']);
                        $input['page_title_bg_img_repeat'] = $chosen_colors_array['page_title_bg_img_repeat'];
                        $input['page_title_bg_img_position_horizontal'] = $chosen_colors_array['page_title_bg_img_position_horizontal'];
                        $input['page_title_bg_img_position_vertical'] = $chosen_colors_array['page_title_bg_img_position_vertical'];
                        $input['main_content_bg_img'] = esc_url_raw($chosen_colors_array['main_content_bg_img']);
                        $input['main_content_bg_img_repeat'] = $chosen_colors_array['main_content_bg_img_repeat'];
                        $input['main_content_bg_img_position_horizontal'] = $chosen_colors_array['main_content_bg_img_position_horizontal'];
                        $input['main_content_bg_img_position_vertical'] = $chosen_colors_array['main_content_bg_img_position_vertical'];
                        $input['bottom_bg_img'] = esc_url_raw($chosen_colors_array['bottom_bg_img']);
                        $input['bottom_bg_img_repeat'] = $chosen_colors_array['bottom_bg_img_repeat'];
                        $input['bottom_bg_img_position_horizontal'] = $chosen_colors_array['bottom_bg_img_position_horizontal'];
                        $input['bottom_bg_img_position_vertical'] = $chosen_colors_array['bottom_bg_img_position_vertical'];
                        $input['footer_bg_img'] = esc_url_raw($chosen_colors_array['footer_bg_img']);
                        $input['footer_bg_img_repeat'] = $chosen_colors_array['footer_bg_img_repeat'];
                        $input['footer_bg_img_position_horizontal'] = $chosen_colors_array['footer_bg_img_position_horizontal'];
                        $input['footer_bg_img_position_vertical'] = $chosen_colors_array['footer_bg_img_position_vertical'];
                        $input['one_continuous_bg_img'] = esc_url_raw($chosen_colors_array['one_continuous_bg_img']);
                        $input['one_continuous_bg_img_repeat'] = $chosen_colors_array['one_continuous_bg_img_repeat'];
                        $input['one_continuous_bg_img_position_horizontal'] = $chosen_colors_array['one_continuous_bg_img_position_horizontal'];
                        $input['one_continuous_bg_img_position_vertical'] = $chosen_colors_array['one_continuous_bg_img_position_vertical'];
                        $input['one_continuous_bg_img_fixed'] = $chosen_colors_array['one_continuous_bg_img_fixed'];
                        $input['one_continuous_bg_img_with_other_bg_imgs'] = $chosen_colors_array['one_continuous_bg_img_with_other_bg_imgs'];
                        $input['udesign_remove_horizontal_rulers'] = $chosen_colors_array['udesign_remove_horizontal_rulers'];
		    } elseif ( $input['chosen_custom_colors_admin_task'] == 'delete' ) { // delete the selected color schemes
			unset( $input['saved_custom_colors_array'][$input['chosen_custom_colors']] );
		    }
		} elseif( isset($input['chosen_custom_colors']) && $input['chosen_custom_colors'] == 'default' ) {
		    if( $input['chosen_custom_colors_admin_task'] == 'load') { // load a default color scheme
			$input['body_text_color'] = '333333';
			$input['main_link_color'] = 'FE5E08';
			$input['main_link_color_hover'] = '333333';
			$input['main_headings_color'] = '333333';
			$input['top_bg_color'] = 'FBFBFB';
			$input['top_text_color'] = '999999';
			$input['top_nav_background_color'] = 'FBFBFB';
                        $input['top_nav_background_opacity'] = 0;
			$input['top_nav_link_color'] = '999999';
			$input['top_nav_active_link_color'] = 'F95A09';
			$input['top_nav_hover_link_color'] = '777777';
			$input['dropdown_nav_link_color'] = '777777';
			$input['dropdown_nav_hover_link_color'] = '222222';
			$input['dropdown_nav_background_color'] = 'EEEEEE';
                        $input['dropdown_nav_background_opacity'] = 0.95;
			$input['sec_menu_bg_color'] = '212121';
                        $input['sec_menu_bg_opacity'] = 0.95;
			$input['sec_menu_text_color'] = 'EBEBEB';
			$input['sec_menu_link_color'] = 'A3A3A3';
			$input['sec_menu_link_hover_color'] = 'FF8400';
			$input['page_title_color'] = '333333';
			$input['page_title_bg_color'] = 'FFFFFF';
			$input['header_bg_color'] = 'FFFFFF';
			$input['main_content_bg'] = 'FFFFFF';
			$input['widget_title_color'] = '333333';
			$input['widget_text_color'] = '333333';
			$input['widget_bg_color'] = 'F8F8F8';
			$input['bottom_bg_color'] = 'F5F5F5';
			$input['bottom_title_color'] = 'FE5E08';
			$input['bottom_text_color'] = '333333';
			$input['bottom_link_color'] = '3D6E97';
			$input['bottom_hover_link_color'] = '000000';
			$input['footer_bg_color'] = 'EAEAEA';
			$input['footer_text_color'] = '797979';
			$input['footer_link_color'] = '3D6E97';
			$input['footer_hover_link_color'] = '000000';
                        $input['top_bg_img'] = '';
                        $input['top_bg_img_repeat'] = 'no-repeat';
                        $input['top_bg_img_position_horizontal'] = 'center';
                        $input['top_bg_img_position_vertical'] = 'top';
                        $input['header_bg_img'] = '';
                        $input['header_bg_img_repeat'] = 'no-repeat';
                        $input['header_bg_img_position_horizontal'] = 'center';
                        $input['header_bg_img_position_vertical'] = 'top';
                        $input['home_page_before_content_bg_img'] = '';
                        $input['home_page_before_content_bg_img_repeat'] = 'no-repeat';
                        $input['home_page_before_content_bg_img_position_horizontal'] = 'center';
                        $input['home_page_before_content_bg_img_position_vertical'] = 'top';
                        $input['page_title_bg_img'] = '';
                        $input['page_title_bg_img_repeat'] = 'no-repeat';
                        $input['page_title_bg_img_position_horizontal'] = 'center';
                        $input['page_title_bg_img_position_vertical'] = 'top';
                        $input['main_content_bg_img'] = '';
                        $input['main_content_bg_img_repeat'] = 'no-repeat';
                        $input['main_content_bg_img_position_horizontal'] = 'center';
                        $input['main_content_bg_img_position_vertical'] = 'top';
                        $input['bottom_bg_img'] = '';
                        $input['bottom_bg_img_repeat'] = 'no-repeat';
                        $input['bottom_bg_img_position_horizontal'] = 'center';
                        $input['bottom_bg_img_position_vertical'] = 'top';
                        $input['footer_bg_img'] = '';
                        $input['footer_bg_img_repeat'] = 'no-repeat';
                        $input['footer_bg_img_position_horizontal'] = 'center';
                        $input['footer_bg_img_position_vertical'] = 'top';
                        $input['one_continuous_bg_img'] = '';
                        $input['one_continuous_bg_img_repeat'] = 'no-repeat';
                        $input['one_continuous_bg_img_position_horizontal'] = 'center';
                        $input['one_continuous_bg_img_position_vertical'] = 'top';
                        $input['one_continuous_bg_img_fixed'] = '';
                        $input['one_continuous_bg_img_with_other_bg_imgs'] = '';
                        $input['udesign_remove_horizontal_rulers'] = '';
		    }
		} else { // save user input
		    $input['body_text_color'] = ( ctype_alnum($input['body_text_color']) ) ? strtoupper(stripslashes($input['body_text_color'])) : $udesign_options['body_text_color'];
		    $input['main_link_color'] = ( ctype_alnum($input['main_link_color']) ) ? strtoupper(stripslashes($input['main_link_color'])) : $udesign_options['main_link_color'];
		    $input['main_link_color_hover'] = ( ctype_alnum($input['main_link_color_hover']) ) ? strtoupper(stripslashes($input['main_link_color_hover'])) : $udesign_options['main_link_color_hover'];
		    $input['main_headings_color'] = ( ctype_alnum($input['main_headings_color']) ) ? strtoupper(stripslashes($input['main_headings_color'])) : $udesign_options['main_headings_color'];
		    $input['top_bg_color'] = ( ctype_alnum($input['top_bg_color']) ) ? strtoupper(stripslashes($input['top_bg_color'])) : $udesign_options['top_bg_color'];
		    $input['top_text_color'] = ( ctype_alnum($input['top_text_color']) ) ? strtoupper(stripslashes($input['top_text_color'])) : $udesign_options['top_text_color'];
		    $input['top_nav_background_color'] = ( ctype_alnum($input['top_nav_background_color']) ) ? strtoupper(stripslashes($input['top_nav_background_color'])) : $udesign_options['top_nav_background_color'];
                    $input['top_nav_background_opacity'] = ( is_numeric( $input['top_nav_background_opacity'] ) && $input['top_nav_background_opacity'] >= 0 && $input['top_nav_background_opacity'] <= 1 ) ? abs($input['top_nav_background_opacity']) : $udesign_options['top_nav_background_opacity'];
		    $input['top_nav_link_color'] = ( ctype_alnum($input['top_nav_link_color']) ) ? strtoupper(stripslashes($input['top_nav_link_color'])) : $udesign_options['top_nav_link_color'];
		    $input['top_nav_active_link_color'] = ( ctype_alnum($input['top_nav_active_link_color']) ) ? strtoupper(stripslashes($input['top_nav_active_link_color'])) : $udesign_options['top_nav_active_link_color'];
		    $input['top_nav_hover_link_color'] = ( ctype_alnum($input['top_nav_hover_link_color']) ) ? strtoupper(stripslashes($input['top_nav_hover_link_color'])) : $udesign_options['top_nav_hover_link_color'];
		    $input['dropdown_nav_link_color'] = ( ctype_alnum($input['dropdown_nav_link_color']) ) ? strtoupper(stripslashes($input['dropdown_nav_link_color'])) : $udesign_options['dropdown_nav_link_color'];
		    $input['dropdown_nav_hover_link_color'] = ( ctype_alnum($input['dropdown_nav_hover_link_color']) ) ? strtoupper(stripslashes($input['dropdown_nav_hover_link_color'])) : $udesign_options['dropdown_nav_hover_link_color'];
		    $input['dropdown_nav_background_color'] = ( ctype_alnum($input['dropdown_nav_background_color']) ) ? strtoupper(stripslashes($input['dropdown_nav_background_color'])) : $udesign_options['dropdown_nav_background_color'];
                    $input['dropdown_nav_background_opacity'] = ( is_numeric( $input['dropdown_nav_background_opacity'] ) && $input['dropdown_nav_background_opacity'] >= 0 && $input['dropdown_nav_background_opacity'] <= 1 ) ? abs($input['dropdown_nav_background_opacity']) : $udesign_options['dropdown_nav_background_opacity'];
		    $input['sec_menu_bg_color'] = ( ctype_alnum($input['sec_menu_bg_color']) ) ? strtoupper(stripslashes($input['sec_menu_bg_color'])) : $udesign_options['sec_menu_bg_color'];
                    $input['sec_menu_bg_opacity'] = ( is_numeric( $input['sec_menu_bg_opacity'] ) && $input['sec_menu_bg_opacity'] >= 0 && $input['sec_menu_bg_opacity'] <= 1 ) ? abs($input['sec_menu_bg_opacity']) : $udesign_options['sec_menu_bg_opacity'];
		    $input['sec_menu_text_color'] = ( ctype_alnum($input['sec_menu_text_color']) ) ? strtoupper(stripslashes($input['sec_menu_text_color'])) : $udesign_options['sec_menu_text_color'];
		    $input['sec_menu_link_color'] = ( ctype_alnum($input['sec_menu_link_color']) ) ? strtoupper(stripslashes($input['sec_menu_link_color'])) : $udesign_options['sec_menu_link_color'];
		    $input['sec_menu_link_hover_color'] = ( ctype_alnum($input['sec_menu_link_hover_color']) ) ? strtoupper(stripslashes($input['sec_menu_link_hover_color'])) : $udesign_options['sec_menu_link_hover_color'];
		    $input['page_title_color'] = ( ctype_alnum($input['page_title_color']) ) ? strtoupper(stripslashes($input['page_title_color'])) : $udesign_options['page_title_color'];
		    $input['page_title_bg_color'] = ( ctype_alnum($input['page_title_bg_color']) ) ? strtoupper(stripslashes($input['page_title_bg_color'])) : $udesign_options['page_title_bg_color'];
		    $input['header_bg_color'] = ( ctype_alnum($input['header_bg_color']) ) ? strtoupper(stripslashes($input['header_bg_color'])) : $udesign_options['header_bg_color'];
		    $input['main_content_bg'] = ( ctype_alnum($input['main_content_bg']) ) ? strtoupper(stripslashes($input['main_content_bg'])) : $udesign_options['main_content_bg'];
                    $input['widget_title_color'] = ( ctype_alnum($input['widget_title_color']) ) ? strtoupper(stripslashes($input['widget_title_color'])) : $udesign_options['widget_title_color'];
		    $input['widget_text_color'] = ( ctype_alnum($input['widget_text_color']) ) ? strtoupper(stripslashes($input['widget_text_color'])) : $udesign_options['widget_text_color'];
		    $input['widget_bg_color'] = ( ctype_alnum($input['widget_bg_color']) ) ? strtoupper(stripslashes($input['widget_bg_color'])) : $udesign_options['widget_bg_color'];
		    $input['bottom_bg_color'] = ( ctype_alnum($input['bottom_bg_color']) ) ? strtoupper(stripslashes($input['bottom_bg_color'])) : $udesign_options['bottom_bg_color'];
		    $input['bottom_title_color'] = ( ctype_alnum($input['bottom_title_color']) ) ? strtoupper(stripslashes($input['bottom_title_color'])) : $udesign_options['bottom_title_color'];
		    $input['bottom_text_color'] = ( ctype_alnum($input['bottom_text_color']) ) ? strtoupper(stripslashes($input['bottom_text_color'])) : $udesign_options['bottom_text_color'];
		    $input['bottom_link_color'] = ( ctype_alnum($input['bottom_link_color']) ) ? strtoupper(stripslashes($input['bottom_link_color'])) : $udesign_options['bottom_link_color'];
		    $input['bottom_hover_link_color'] = ( ctype_alnum($input['bottom_hover_link_color']) ) ? strtoupper(stripslashes($input['bottom_hover_link_color'])) : $udesign_options['bottom_hover_link_color'];
		    $input['footer_bg_color'] = ( ctype_alnum($input['footer_bg_color']) ) ? strtoupper(stripslashes($input['footer_bg_color'])) : $udesign_options['footer_bg_color'];
		    $input['footer_text_color'] = ( ctype_alnum($input['footer_text_color']) ) ? strtoupper(stripslashes($input['footer_text_color'])) : $udesign_options['footer_text_color'];
		    $input['footer_link_color'] = ( ctype_alnum($input['footer_link_color']) ) ? strtoupper(stripslashes($input['footer_link_color'])) : $udesign_options['footer_link_color'];
		    $input['footer_hover_link_color'] = ( ctype_alnum($input['footer_hover_link_color']) ) ? strtoupper(stripslashes($input['footer_hover_link_color'])) : $udesign_options['footer_hover_link_color'];
		    $input['top_bg_img'] = esc_url_raw($input['top_bg_img']);
                    $input['top_bg_img_repeat'] = $input['top_bg_img_repeat'];
                    $input['top_bg_img_position_horizontal'] = $input['top_bg_img_position_horizontal'];
                    $input['top_bg_img_position_vertical'] = $input['top_bg_img_position_vertical'];
		    $input['header_bg_img'] = esc_url_raw($input['header_bg_img']);
                    $input['header_bg_img_repeat'] = $input['header_bg_img_repeat'];
                    $input['header_bg_img_position_horizontal'] = $input['header_bg_img_position_horizontal'];
                    $input['header_bg_img_position_vertical'] = $input['header_bg_img_position_vertical'];
		    $input['home_page_before_content_bg_img'] = esc_url_raw($input['home_page_before_content_bg_img']);
                    $input['home_page_before_content_bg_img_repeat'] = $input['home_page_before_content_bg_img_repeat'];
                    $input['home_page_before_content_bg_img_position_horizontal'] = $input['home_page_before_content_bg_img_position_horizontal'];
                    $input['home_page_before_content_bg_img_position_vertical'] = $input['home_page_before_content_bg_img_position_vertical'];
		    $input['page_title_bg_img'] = esc_url_raw($input['page_title_bg_img']);
                    $input['page_title_bg_img_repeat'] = $input['page_title_bg_img_repeat'];
                    $input['page_title_bg_img_position_horizontal'] = $input['page_title_bg_img_position_horizontal'];
                    $input['page_title_bg_img_position_vertical'] = $input['page_title_bg_img_position_vertical'];
		    $input['main_content_bg_img'] = esc_url_raw($input['main_content_bg_img']);
                    $input['main_content_bg_img_repeat'] = $input['main_content_bg_img_repeat'];
                    $input['main_content_bg_img_position_horizontal'] = $input['main_content_bg_img_position_horizontal'];
                    $input['main_content_bg_img_position_vertical'] = $input['main_content_bg_img_position_vertical'];
		    $input['bottom_bg_img'] = esc_url_raw($input['bottom_bg_img']);
                    $input['bottom_bg_img_repeat'] = $input['bottom_bg_img_repeat'];
                    $input['bottom_bg_img_position_horizontal'] = $input['bottom_bg_img_position_horizontal'];
                    $input['bottom_bg_img_position_vertical'] = $input['bottom_bg_img_position_vertical'];
		    $input['footer_bg_img'] = esc_url_raw($input['footer_bg_img']);
                    $input['footer_bg_img_repeat'] = $input['footer_bg_img_repeat'];
                    $input['footer_bg_img_position_horizontal'] = $input['footer_bg_img_position_horizontal'];
                    $input['footer_bg_img_position_vertical'] = $input['footer_bg_img_position_vertical'];
		    $input['one_continuous_bg_img'] = esc_url_raw($input['one_continuous_bg_img']);
                    $input['one_continuous_bg_img_repeat'] = $input['one_continuous_bg_img_repeat'];
                    $input['one_continuous_bg_img_position_horizontal'] = $input['one_continuous_bg_img_position_horizontal'];
                    $input['one_continuous_bg_img_position_vertical'] = $input['one_continuous_bg_img_position_vertical'];
                    $input['one_continuous_bg_img_fixed'] = $input['one_continuous_bg_img_fixed'];
                    $input['one_continuous_bg_img_with_other_bg_imgs'] = $input['one_continuous_bg_img_with_other_bg_imgs'];
                    $input['udesign_remove_horizontal_rulers'] = $input['udesign_remove_horizontal_rulers'];
		}

		// Front Page Sliders
		$input['current_slider'] = ( $input['current_slider'] ) ? $input['current_slider'] : $udesign_options['current_slider'];

		// Cycle 1
		$input['c1_slides_order_str'] = ($input['c1_slides_order_str']) ? $input['c1_slides_order_str'] : $udesign_options['c1_slides_order_str'];
		$c1_slides_array = explode( ',', $input['c1_slides_order_str'] );
		foreach( $c1_slides_array as $slide_row_number ) {
		    $input['c1_slide_img_url_'.$slide_row_number] = ($input['c1_slide_img_url_'.$slide_row_number]) ? esc_url_raw($input['c1_slide_img_url_'.$slide_row_number]) : $udesign_options['c1_slide_img_url_'.$slide_row_number];
		    $input['c1_transition_type_'.$slide_row_number] = (  $input['c1_transition_type_'.$slide_row_number] ) ? $input['c1_transition_type_'.$slide_row_number] : $udesign_options['c1_transition_type_'.$slide_row_number];
		    if ($input['c1_slide_link_url_'.$slide_row_number] == ' ') { // if space then remove url from field
			$input['c1_slide_link_url_'.$slide_row_number] = '';
		    } elseif ($input['c1_slide_link_url_'.$slide_row_number] == '') { // if blank then grab the previously saved value for the link
			$input['c1_slide_link_url_'.$slide_row_number] = $udesign_options['c1_slide_link_url_'.$slide_row_number];
		    } else { // if some url, clean it, format it an save it
			$input['c1_slide_link_url_'.$slide_row_number] = esc_url_raw($input['c1_slide_link_url_'.$slide_row_number]);
		    }
		    $input['c1_slide_link_target_'.$slide_row_number] = (  $input['c1_slide_link_target_'.$slide_row_number] ) ? $input['c1_slide_link_target_'.$slide_row_number] : $udesign_options['c1_slide_link_target_'.$slide_row_number];
		    $input['c1_slide_image_alt_tag_'.$slide_row_number] = ($input['c1_slide_image_alt_tag_'.$slide_row_number]) ? trim(stripslashes($input['c1_slide_image_alt_tag_'.$slide_row_number])) : $udesign_options['c1_slide_image_alt_tag_'.$slide_row_number];
		}
		$input['c1_speed'] = is_numeric( $input['c1_speed'] ) ? absint($input['c1_speed']) : $udesign_options['c1_speed'];
		$input['c1_timeout'] = is_numeric( $input['c1_timeout'] ) ? absint($input['c1_timeout']) : $udesign_options['c1_timeout'];

		// Cycle 2
		$input['c2_slides_order_str'] = ($input['c2_slides_order_str']) ? $input['c2_slides_order_str'] : $udesign_options['c2_slides_order_str'];
		$c2_slides_array = explode( ',', $input['c2_slides_order_str'] );
		foreach( $c2_slides_array as $slide_row_number ) {
		    $input['c2_slide_img_url_'.$slide_row_number] = ($input['c2_slide_img_url_'.$slide_row_number]) ? esc_url_raw($input['c2_slide_img_url_'.$slide_row_number]) : $udesign_options['c2_slide_img_url_'.$slide_row_number];
		    $input['c2_transition_type_'.$slide_row_number] = (  $input['c2_transition_type_'.$slide_row_number] ) ? $input['c2_transition_type_'.$slide_row_number] : $udesign_options['c2_transition_type_'.$slide_row_number];
		    if ($input['c2_slide_link_url_'.$slide_row_number] == ' ') { // if space then remove url from field
			$input['c2_slide_link_url_'.$slide_row_number] = '';
		    } elseif ($input['c2_slide_link_url_'.$slide_row_number] == '') { // if blank then grab the previously saved value for the link
			$input['c2_slide_link_url_'.$slide_row_number] = $udesign_options['c2_slide_link_url_'.$slide_row_number];
		    } else { // if some url, clean it, format it and save it
			$input['c2_slide_link_url_'.$slide_row_number] = esc_url_raw($input['c2_slide_link_url_'.$slide_row_number]);
		    }
		    $input['c2_slide_link_target_'.$slide_row_number] = (  $input['c2_slide_link_target_'.$slide_row_number] ) ? $input['c2_slide_link_target_'.$slide_row_number] : $udesign_options['c2_slide_link_target_'.$slide_row_number];
		    $input['c2_slide_image_alt_tag_'.$slide_row_number] = ($input['c2_slide_image_alt_tag_'.$slide_row_number]) ? trim(stripslashes($input['c2_slide_image_alt_tag_'.$slide_row_number])) : $udesign_options['c2_slide_image_alt_tag_'.$slide_row_number];
		    $input['c2_slide_default_info_txt_'.$slide_row_number] = ($input['c2_slide_default_info_txt_'.$slide_row_number]) ? stripslashes($input['c2_slide_default_info_txt_'.$slide_row_number]) : $udesign_options['c2_slide_default_info_txt_'.$slide_row_number];
		    $input['c2_slide_button_txt_'.$slide_row_number] = ($input['c2_slide_button_txt_'.$slide_row_number]) ? stripslashes($input['c2_slide_button_txt_'.$slide_row_number]) : $udesign_options['c2_slide_button_txt_'.$slide_row_number];
		    $input['c2_slide_button_style_'.$slide_row_number] = (  $input['c2_slide_button_style_'.$slide_row_number] ) ? $input['c2_slide_button_style_'.$slide_row_number] : $udesign_options['c2_slide_button_style_'.$slide_row_number];
		}
		$input['c2_speed'] = is_numeric( $input['c2_speed'] ) ? absint($input['c2_speed']) : $udesign_options['c2_speed'];
		$input['c2_timeout'] = is_numeric( $input['c2_timeout'] ) ? absint($input['c2_timeout']) : $udesign_options['c2_timeout'];
		$input['c2_text_color'] = ( ctype_alnum($input['c2_text_color']) ) ? strtoupper(stripslashes($input['c2_text_color'])) : $udesign_options['c2_text_color'];
		$input['c2_slider_text_size'] = (  $input['c2_slider_text_size'] ) ? $input['c2_slider_text_size'] : $udesign_options['c2_slider_text_size'];
		$input['c2_slider_text_line_height'] = (  $input['c2_slider_text_line_height'] ) ? $input['c2_slider_text_line_height'] : $udesign_options['c2_slider_text_line_height'];
                

		// Cycle 3
		$input['c3_slides_order_str'] = ($input['c3_slides_order_str']) ? $input['c3_slides_order_str'] : $udesign_options['c3_slides_order_str'];
		$c3_slides_array = explode( ',', $input['c3_slides_order_str'] );
		foreach( $c3_slides_array as $slide_row_number ) {
                    if ($input['c3_slide_img_url_'.$slide_row_number] == ' ') { // if space then remove url from field
			$input['c3_slide_img_url_'.$slide_row_number] = '';
		    } elseif ($input['c3_slide_img_url_'.$slide_row_number] == '') { // if blank then grab the previously saved value for the link
			$input['c3_slide_img_url_'.$slide_row_number] = $udesign_options['c3_slide_img_url_'.$slide_row_number];
		    } else { // if some url, clean it, format it and save it
			$input['c3_slide_img_url_'.$slide_row_number] = esc_url_raw($input['c3_slide_img_url_'.$slide_row_number]);
                    }
                    if ($input['c3_slide_link_url_'.$slide_row_number] == ' ') { // if space then remove url from field
			$input['c3_slide_link_url_'.$slide_row_number] = '';
		    } elseif ($input['c3_slide_link_url_'.$slide_row_number] == '') { // if blank then grab the previously saved value for the link
			$input['c3_slide_link_url_'.$slide_row_number] = $udesign_options['c3_slide_link_url_'.$slide_row_number];
		    } else { // if some url, clean it, format it and save it
			$input['c3_slide_link_url_'.$slide_row_number] = esc_url_raw($input['c3_slide_link_url_'.$slide_row_number]);
		    }
                    if ($input['c3_slide_img2_url_'.$slide_row_number] == ' ') { // if space then remove url from field
			$input['c3_slide_img2_url_'.$slide_row_number] = '';
		    } elseif ($input['c3_slide_img2_url_'.$slide_row_number] == '') { // if blank then grab the previously saved value for the link
			$input['c3_slide_img2_url_'.$slide_row_number] = $udesign_options['c3_slide_img2_url_'.$slide_row_number];
		    } else { // if some url, clean it, format it and save it
			$input['c3_slide_img2_url_'.$slide_row_number] = esc_url_raw($input['c3_slide_img2_url_'.$slide_row_number]);
                    }
		    $input['c3_slide_link_target_'.$slide_row_number] = (  $input['c3_slide_link_target_'.$slide_row_number] ) ? $input['c3_slide_link_target_'.$slide_row_number] : $udesign_options['c3_slide_link_target_'.$slide_row_number];
		    $input['c3_slide_image_alt_tag_'.$slide_row_number] = ($input['c3_slide_image_alt_tag_'.$slide_row_number]) ? trim(stripslashes($input['c3_slide_image_alt_tag_'.$slide_row_number])) : $udesign_options['c3_slide_image_alt_tag_'.$slide_row_number];
		    $input['c3_slide_default_info_txt_'.$slide_row_number] = ($input['c3_slide_default_info_txt_'.$slide_row_number]) ? stripslashes(trim($input['c3_slide_default_info_txt_'.$slide_row_number])) : $udesign_options['c3_slide_default_info_txt_'.$slide_row_number];
		}
		$input['c3_timeout'] = is_numeric( $input['c3_timeout'] ) ? absint($input['c3_timeout']) : $udesign_options['c3_timeout'];
		$input['c3_text_color'] = ( ctype_alnum($input['c3_text_color']) ) ? strtoupper(stripslashes($input['c3_text_color'])) : $udesign_options['c3_text_color'];
		$input['c3_slider_text_size'] = (  $input['c3_slider_text_size'] ) ? $input['c3_slider_text_size'] : $udesign_options['c3_slider_text_size'];
		$input['c3_slider_text_line_height'] = (  $input['c3_slider_text_line_height'] ) ? $input['c3_slider_text_line_height'] : $udesign_options['c3_slider_text_line_height'];
               

		// No slider
		$input['no_slider_text'] = stripslashes($input['no_slider_text']);
                
		// Revolution slider
		$input['rev_slider_shortcode'] = $input['rev_slider_shortcode'];

		// Portfolio Section
                $input['portfolio_categories'] = array(); // reset the $input['portfolio_categories'] option
                $input['portfolio_pages_ids_array'] = array();  // reset the $input['portfolio_pages_ids_array'] option
		foreach ( $portfolio_pages_array as $portfolio_page_obj ) {
		    $port_page_ID = $portfolio_page_obj->ID;
		    if ( $input['portfolio_cat_for_page_'.$port_page_ID] !== '0' ) { // as long as the category has been assigned to a portfolio page, '0' means NOT
                        $input['portfolio_categories'][] = $input['portfolio_cat_for_page_'.$port_page_ID]; // add new values to the array
                        $input['portfolio_pages_ids_array'][] = $port_page_ID; // add new values to the 'portfolio_pages_ids_array' array
                    }
		    $input['portfolio_items_per_page_for_page_'.$port_page_ID] = ( is_numeric( $input['portfolio_items_per_page_for_page_'.$port_page_ID] ) && $input['portfolio_items_per_page_for_page_'.$port_page_ID] > 0 ) ? absint($input['portfolio_items_per_page_for_page_'.$port_page_ID]) : $udesign_options['portfolio_items_per_page_for_page_'.$port_page_ID];
                    $input['portfolio_do_not_link_adjacent_items_'.$port_page_ID] = $input['portfolio_do_not_link_adjacent_items_'.$port_page_ID];
		}
		$input['portfolio_categories'] = array_unique( $input['portfolio_categories'] );
		$input['portfolio_title_posistion'] = ($input['portfolio_title_posistion']) ? $input['portfolio_title_posistion'] : $udesign_options['portfolio_title_posistion'];
		$input['portfolio_sidebar'] = ($input['portfolio_sidebar']) ? $input['portfolio_sidebar'] : $udesign_options['portfolio_sidebar'];
                $input['show_portfolio_postmetadata'] = $input['show_portfolio_postmetadata'];
		$input['udesign_single_portfolio_postmetadata_location'] = (  $input['udesign_single_portfolio_postmetadata_location'] ) ? $input['udesign_single_portfolio_postmetadata_location'] : $udesign_options['udesign_single_portfolio_postmetadata_location'];
                $input['show_portfolio_postmetadata_author'] = $input['show_portfolio_postmetadata_author'];
                $input['show_portfolio_postmetadata_tags'] = $input['show_portfolio_postmetadata_tags'];
                $input['show_portfolio_comments'] = $input['show_portfolio_comments'];
                $input['remove_single_portfolio_sidebar'] = $input['remove_single_portfolio_sidebar'];
                $input['show_single_portfolio_navigation'] = $input['show_single_portfolio_navigation'];

		// Blog Section
		$input['blog_sidebar'] = ($input['blog_sidebar']) ? $input['blog_sidebar'] : $udesign_options['blog_sidebar'];
                $input['show_excerpt'] = $input['show_excerpt'];
		$input['excerpt_length_in_words'] = is_numeric( $input['excerpt_length_in_words'] ) ? absint($input['excerpt_length_in_words']) : $udesign_options['excerpt_length_in_words'];
		$input['blog_button_text'] = trim(stripslashes($input['blog_button_text']));
		$input['exclude_portfolio_from_blog'] = $input['exclude_portfolio_from_blog'];
		$input['exclude_portfolio_from_recent_posts_widget'] = $input['exclude_portfolio_from_recent_posts_widget'];
		$input['exclude_portfolio_from_archives_widget'] = $input['exclude_portfolio_from_archives_widget'];
		$input['exclude_portfolio_from_main_query'] = $input['exclude_portfolio_from_main_query'];
                $input['show_postmetadata_author'] = $input['show_postmetadata_author'];
                $input['show_postmetadata_tags'] = $input['show_postmetadata_tags'];
                $input['show_archive_for_string'] = $input['show_archive_for_string'];
                $input['udesign_comment_field_to_bottom'] = $input['udesign_comment_field_to_bottom'];
                $input['show_comments_are_closed_message'] = $input['show_comments_are_closed_message'];
                $input['remove_blog_sidebar'] = $input['remove_blog_sidebar'];
                $input['remove_archive_sidebar'] = $input['remove_archive_sidebar'];
                $input['remove_single_sidebar'] = $input['remove_single_sidebar'];
		$input['udesign_single_view_postmetadata_location'] = (  $input['udesign_single_view_postmetadata_location'] ) ? $input['udesign_single_view_postmetadata_location'] : $udesign_options['udesign_single_view_postmetadata_location'];
                $input['show_single_post_navigation'] = $input['show_single_post_navigation'];
                $input['display_post_image_in_single_post'] = $input['display_post_image_in_single_post'];
                $input['enable_custom_featured_image'] = $input['enable_custom_featured_image'];
		$input['featured_image_width'] = is_numeric( $input['featured_image_width'] ) ? absint($input['featured_image_width']) : $udesign_options['featured_image_width'];
		$input['featured_image_height'] = is_numeric( $input['featured_image_height'] ) ? absint($input['featured_image_height']) : $udesign_options['featured_image_height'];
                $input['force_image_dimention'] = $input['force_image_dimention'];
		$input['featured_image_alignment'] = (  $input['featured_image_alignment'] ) ? $input['featured_image_alignment'] : $udesign_options['featured_image_alignment'];
                $input['remove_featured_image_frame'] = $input['remove_featured_image_frame'];
                
		// Contact Page
		$input['contact_field_name1'] = stripslashes($input['contact_field_name1']);
		$input['contact_field_value1'] = stripslashes($input['contact_field_value1']);
		$input['contact_field_name2'] = stripslashes($input['contact_field_name2']);
		$input['contact_field_value2'] = stripslashes($input['contact_field_value2']);
		$input['contact_field_name3'] = stripslashes($input['contact_field_name3']);
		$input['contact_field_value3'] = stripslashes($input['contact_field_value3']);
		$input['contact_field_name4'] = stripslashes($input['contact_field_name4']);
		$input['contact_field_value4'] = stripslashes($input['contact_field_value4']);
		$input['contact_field_name5'] = stripslashes($input['contact_field_name5']);
		$input['contact_field_value5'] = stripslashes($input['contact_field_value5']);
		$input['contact_field_name6'] = stripslashes($input['contact_field_name6']);
		$input['contact_field_value6'] = stripslashes($input['contact_field_value6']);
		$input['contact_field_name7'] = stripslashes($input['contact_field_name7']);
		$input['contact_field_value7'] = stripslashes($input['contact_field_value7']);
		$input['contact_sidebar'] = ($input['contact_sidebar']) ? $input['contact_sidebar'] : $udesign_options['contact_sidebar'];
                $input['remove_contact_sidebar'] = $input['remove_contact_sidebar'];
                $input['NA_phone_format'] = $input['NA_phone_format'];
		$email_receipients = $this->email_receipients_are_valid($input['email_receipients']); // validate email(s)
		$input['email_receipients'] = ( $email_receipients ) ?  $email_receipients: $udesign_options['email_receipients'];
		$input['recaptcha_publickey'] = trim(stripslashes($input['recaptcha_publickey']));
		$input['recaptcha_privatekey'] = trim(stripslashes($input['recaptcha_privatekey']));
		$input['recaptcha_enabled'] = ($input['recaptcha_publickey'] && $input['recaptcha_privatekey']) ? $input['recaptcha_enabled'] : 'no'; // disable ReCAPTCHA if publickey and privatekey are empty
		$input['recaptcha_lang'] = (  $input['recaptcha_lang'] ) ? $input['recaptcha_lang'] : $udesign_options['recaptcha_lang'];

		// Footer Options
		$input['copyright_message'] = stripslashes($input['copyright_message']);
                $input['show_wp_link_in_footer'] = $input['show_wp_link_in_footer'];
                $input['show_entries_rss_in_footer'] = $input['show_entries_rss_in_footer'];
                $input['show_comments_rss_in_footer'] = $input['show_comments_rss_in_footer'];
		$input['show_udesign_affiliate_link'] = $input['show_udesign_affiliate_link'];
		$input['affiliate_username'] = str_replace (" ", "", $input['affiliate_username']);
                $input['udesign_sticky_footer'] = $input['udesign_sticky_footer'];
                
                // Responsive
                $input['enable_responsive'] = $input['enable_responsive'];
		$input['responsive_logo_img'] = esc_url_raw($input['responsive_logo_img']);
		$input['responsive_logo_height'] = is_numeric( $input['responsive_logo_height'] ) ? absint($input['responsive_logo_height']) : $udesign_options['responsive_logo_height'];
                $input['responsive_remove_secondary_menu'] = $input['responsive_remove_secondary_menu'];
                $input['responsive_remove_slider_area'] = $input['responsive_remove_slider_area'];
                $input['responsive_remove_bg_images_960-720'] = $input['responsive_remove_bg_images_960-720'];
		$input['responsive_menu'] = (  $input['responsive_menu'] ) ? $input['responsive_menu'] : $udesign_options['responsive_menu'];
                $input['menu_2_screen_width'] = $input['menu_2_screen_width'];
                $input['responsive_pinch_to_zoom'] = $input['responsive_pinch_to_zoom'];
		$input['responsive_disable_pretty_photo_at_width'] = is_numeric( $input['responsive_disable_pretty_photo_at_width'] ) ? absint($input['responsive_disable_pretty_photo_at_width']) : $udesign_options['responsive_disable_pretty_photo_at_width'];

		// Statistics
		$input['google_analytics'] = stripslashes($input['google_analytics']);
                
                // Advanced Options
                $input['show_udesign_action_hooks'] = $input['show_udesign_action_hooks'];
                
		return $input;
	}

	function on_save_changes() {
		// user permission check
		if ( !current_user_can('manage_options') )
			wp_die( esc_html__("Cheatin' uh?", 'udesign') );
		// cross check the given referer
		check_admin_referer( 'udesign_options_page-options' );
		//lets redirect the post request into get request (you may add additional params at the url, if you need to show save results
		wp_redirect($_POST['_wp_http_referer']);
	}
        
	/**
	 * Validate email receipient(s) email addresses
	 *
	 * @param string $receipients, a string of CSV email addresses
	 * @return bool|mixed False on failure or a string of properly formatted CSV email addresses otherwise
	 */
	function email_receipients_are_valid ( $receipients ) {
	    	$emails_array = explode( ",", $receipients );
		foreach ( $emails_array as $email ) {
		    if ( !is_email( trim($email) ) )
			return false;
		}
		return implode( ', ', array_map( 'trim', $emails_array) ); // trim white spaced from beginning and end of email addresses
	}



	/**************************************************************************************/
	/**** Below you will find the callback method for each of the registered metaboxes ****/
	/**************************************************************************************/

	function help_options_contentbox( $options ) { ?>
		<p style="margin-left:5px;"><?php esc_html_e('U-Design theme help resources:', 'udesign'); ?></p>
		<ul style="list-style-type:none; margin:5px 5px 10px 20px;">
		    <li><?php echo '<div><a href="'.get_template_directory_uri().'/scripts/documentation/index.html" title="'.esc_html__('Open the documentation', 'udesign').'" target="_blank">'.esc_html__('Documentation', 'udesign').'</a></div>'; ?></li>
		    <li><?php echo '<div><a title="'.esc_html__('Go to the Support Forum', 'udesign').'" href="http://dreamthemedesign.com/u-design-support/" target="_blank">'.esc_html__('Support Forum', 'udesign').'</a>'; ?> (<span class="description"><?php  printf( __('You should be able to register yourself with the Support Forum %1$sHERE%2$s.', 'udesign'), '<a target="_blank" title="Support Forum Registration" href="http://dreamthemedesign.com/u-design-support/">', '</a>' ); ?></span>)</div></li>
		    <li><?php echo '<div><a title="'.esc_html__('Go to the Video Tutorials', 'udesign').'" href="http://www.youtube.com/user/internq7" target="_blank">'.esc_html__('Video Tutorials (Author\'s YouTube Tutorials Channel)', 'udesign').'</a></div>'; ?></li>
		    <li><?php echo '<div><a title="'.esc_html__('Go to the U-Design Demo Site', 'udesign').'" href="http://www.universallyacclaimed.com/wp-themes/u-design/" target="_blank">'.esc_html__('U-Design Demo Site', 'udesign').'</a></div>'; ?></li>
		    <li><?php echo '<div><a title="'.esc_html__('Go to the U-Design Shortcodes examples', 'udesign').'" href="http://www.universallyacclaimed.com/wp-themes/u-design/?page_id=59" target="_blank">'.esc_html__('U-Design Shortcodes', 'udesign').'</a></div>'; ?></li>
		    <li><?php echo '<div><a title="'.esc_html__('Go to the "Get the Code" page', 'udesign').'" href="http://www.universallyacclaimed.com/wp-themes/u-design/?page_id=1417" target="_blank">'.esc_html__('Get the Code: All of the Home page examples source code is available here.', 'udesign').'</a></div>'; ?></li>
		</ul>
<?php	}

	function general_options_contentbox( $options ) { ?>
                
                <h4 class="u-design-settings-page-headers"><?php esc_html_e('Logo', 'udesign'); ?></h4>
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('URL', 'udesign'); ?></th>
			    <td>
                                <div style="margin-bottom:5px;  padding:0; float:left;">
                                    <label for="custom_logo_img"><?php esc_html_e('Enter a URL or upload an image for your logo:', 'udesign'); ?></label><br />
                                    <input name="udesign_options[custom_logo_img]" type="text" id="custom_logo_img" value="<?php if( $options['custom_logo_img'] ){ echo esc_url($options['custom_logo_img']); } ?>" size="65" />
                                    <input id="upload_logo_button" type="button" value="<?php esc_attr_e('Upload Logo', 'udesign'); ?>" class="button-secondary" />
                                </div>
                                <div class="clear"></div>
				<span class="description"><?php esc_html_e('To upload an image click on "Upload Logo" button. Once you upload or choose your image click the "Choose Image" button to insert it into the text field above.', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Link Dimensions', 'udesign'); ?></th>
			    <td>
				<input name="udesign_options[logo_width]" type="text" id="logo_width" value="<?php echo esc_attr($options['logo_width']); ?>" size="5" maxlength="4" />
				<span> X </span>
				<input name="udesign_options[logo_height]" type="text" id="logo_height" value="<?php echo esc_attr($options['logo_height']); ?>" size="5" maxlength="4" />
				px <?php esc_html_e("(Width X Height) in pixels.", 'udesign'); ?><br/> <span class="description"><?php esc_html_e("Make sure to accurately enter the logo's width and height. This option will not resize the logo but will define the logo link (clickable area over the logo).", 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Position', 'udesign'); ?></th>
			    <td>
				<label for="logo_position_center">
				    <input name="udesign_options[logo_position_center]" type="checkbox" id="logo_position_center" value="yes" <?php checked('yes', $options['logo_position_center']); ?> />
				    <?php esc_html_e('Center the logo instead of the default position on the left. ', 'udesign'); ?>
				</label>
                                <span class="description"><br/><?php esc_html_e("Please Note: In order for this to work make sure the logo width you've provided in the option above is an accurate representation of the logo's width. ", 'udesign'); ?></span>
                                <div class="clear"></div>
                                <div class="submit" style="padding:10px 0 0 80px; float:right; clear:both;">
                                    <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
                                    <input class="button-primary right" type="submit" name="form-submit" value="<?php esc_attr_e('Save Changes', 'udesign') ?>" />
                                    <span class="spinner"></span>
                                </div>
			    </td>
			</tr>
		    </tbody>
                </table>
                <h4 class="u-design-settings-page-headers"><?php esc_html_e('Tagline', 'udesign'); ?></h4>
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><label for="slogan_distance_from_the_top"><?php esc_html_e('Position', 'udesign'); ?></label></th>
			    <td>
                                <fieldset>
                                    <input name="udesign_options[slogan_distance_from_the_top]" type="text" id="slogan_distance_from_the_top" value="<?php echo esc_attr($options['slogan_distance_from_the_top']); ?>" size="5" maxlength="3" />
                                    <span> px <?php esc_html_e('from the top.', 'udesign'); ?></span>
                                </fieldset><br />
                                <fieldset>
                                    <input name="udesign_options[slogan_distance_from_the_left]" type="text" id="slogan_distance_from_the_left" value="<?php echo esc_attr($options['slogan_distance_from_the_left']); ?>" size="5" maxlength="3" />
                                    <span> px <?php esc_html_e('from the left. Enter a number between 0 and 400.', 'udesign'); ?></span><br />
                                    <span class="description"><?php  printf( __('Please note that the actual Slogan text can be changed or deleted at %1$sSettings %2$s General%3$s <strong>Tagline</strong> option.', 'udesign'), '<a title="'.esc_html__('Go to the "General Settings" page', 'udesign').'" href="options-general.php">', '&rarr;', '</a>' ); ?></span>
                                </fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Font Size', 'udesign'); ?></th>
			    <td>
				<label for="slogan_font_size">
					<select name="udesign_options[slogan_font_size]" id="slogan_font_size">
                                            <?php for ($index = 8; $index < 37; $index++) {
                                                $selected_val = ( $options['slogan_font_size'] ) ? $options['slogan_font_size'] : '12';
                                                $selected = ( $selected_val == $index ) ? $selected = ' selected="selected"' : '';
                                                $default_text = ($index == "12") ? esc_html__('(Default)', 'udesign') : '';
                                                echo '<option value="'.$index.'"'.$selected.'>'.$index.'px '.$default_text.'</option>';
                                            } ?>
                                        </select>
				</label>
                                <div class="clear"></div>
                                <div class="submit" style="padding:10px 0 0 80px; float:right; clear:both;">
                                    <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
                                    <input class="button-primary right" type="submit" name="form-submit" value="<?php esc_attr_e('Save Changes', 'udesign') ?>" />
                                    <span class="spinner"></span>
                                </div>
                            </td>
			</tr>
                    </tbody>
                </table>
                <h4 class="u-design-settings-page-headers"><?php esc_html_e('Top Area', 'udesign'); ?></h4>
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Height', 'udesign'); ?></th>
			    <td>
				<input name="udesign_options[top_area_height]" type="text" id="top_area_height" value="<?php echo esc_attr($options['top_area_height']); ?>" size="5" maxlength="4" />
				px <?php esc_html_e('in pixels.', 'udesign'); ?><br /><span class="description">
				<?php esc_html_e('Note: the minimum recommended height is 55px.', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Search Box', 'udesign'); ?></th>
			    <td>
				<label for="enable_search">
				    <input name="udesign_options[enable_search]" type="checkbox" id="enable_search" value="yes" <?php checked('yes', $options['enable_search']); ?> />
				    <?php esc_html_e('Enable the Search box displayed in the top area of the page.', 'udesign'); ?>
				</label>
                                <div class="clear"></div>
                                <div class="submit" style="padding:10px 0 0 80px; float:right; clear:both;">
                                    <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
                                    <input class="button-primary right" type="submit" name="form-submit" value="<?php esc_attr_e('Save Changes', 'udesign') ?>" />
                                    <span class="spinner"></span>
                                </div>
			    </td>
			</tr>
		    </tbody>
		</table>
                <h4 class="u-design-settings-page-headers"><?php esc_html_e('Call to action', 'udesign'); ?></h4>
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Phone Number Information', 'udesign'); ?></th>
			    <td>
				<input name="udesign_options[top_page_phone_number]" type="text" id="top_page_phone_number" value="<?php if ($options['top_page_phone_number']) { echo esc_attr($options['top_page_phone_number'], 'udesign'); } ?>" size="30" maxlength="500" />
				<br /><?php esc_html_e('Use this field to provide a phone number or any other piece of information.  It is displayed near the search box located at the top right corner of the theme.', 'udesign'); ?>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Page Peel', 'udesign'); ?></th>
			    <td>
                                <fieldset>
                                    <label for="enable_page_peel">
                                        <input name="udesign_options[enable_page_peel]" type="checkbox" id="enable_page_peel" value="yes" <?php checked('yes', $options['enable_page_peel']); ?> />
                                        <?php esc_html_e('Display the page curl/peel located in the top right corner of the site. Could be used for your FeedBurner subscription or advertising.', 'udesign'); ?>
                                    </label><br />
                                    <label for="page_peel_url"><?php esc_html_e('Enter a URL:', 'udesign'); ?></label>
                                    <input name="udesign_options[page_peel_url]" type="text" id="page_peel_url" value="<?php if ($options['page_peel_url']) { echo esc_attr($options['page_peel_url'], 'udesign'); } ?>" size="50" maxlength="100" />
                                </fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Feedback Button', 'udesign'); ?></th>
			    <td>
                                <fieldset>
                                    <label for="enable_feedback">
                                        <input name="udesign_options[enable_feedback]" type="checkbox" id="enable_feedback" value="yes" <?php checked('yes', $options['enable_feedback']); ?> />
                                        <?php esc_html_e('Display the Feedback button located in the most left side of the site.', 'udesign'); ?>
                                    </label><br />
                                    <label for="feedback_url"><?php esc_html_e('Enter a URL:', 'udesign'); ?></label>
                                    <input name="udesign_options[feedback_url]" type="text" id="feedback_url" value="<?php if ($options['feedback_url']) { echo esc_attr($options['feedback_url'], 'udesign'); } ?>" size="50" maxlength="100" />
                                </fieldset>
                                <fieldset>
                                    <label for="feedback_position_fixed">
                                        <input name="udesign_options[feedback_position_fixed]" type="checkbox" id="feedback_position_fixed" value="yes" <?php checked('yes', $options['feedback_position_fixed']); ?> />
                                        <?php esc_html_e('Fix the position of the "Feedback" button to prevent it from scrolling with the page.', 'udesign'); ?>
                                    </label>
                                </fieldset>
                                <div class="clear"></div>
                                <div class="submit" style="padding:10px 0 0 80px; float:right; clear:both;">
                                    <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
                                    <input class="button-primary right" type="submit" name="form-submit" value="<?php esc_attr_e('Save Changes', 'udesign') ?>" />
                                    <span class="spinner"></span>
                                </div>
			    </td>
			</tr>
		    </tbody>
		</table>
                <h4 class="u-design-settings-page-headers"><?php esc_html_e('prettyPhoto', 'udesign'); ?></h4>
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Enable', 'udesign'); ?></th>
			    <td>
				<label for="enable_prettyPhoto_script">
				    <input name="udesign_options[enable_prettyPhoto_script]" type="checkbox" id="enable_prettyPhoto_script" value="yes" <?php checked('yes', $options['enable_prettyPhoto_script']); ?> />
                                    <?php esc_html_e('Enable prettyPhoto lightbox script.', 'udesign'); ?> 
                                </label><br />
                                <span class="description"><?php printf( __('In case of conflicts with some other lightbox plugins you may wish to disable the %1$sprettyPhoto%2$s script.', 'udesign'), '<a href="http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/" target="_blank" title="Go to prettyPhoto website">', '</a>'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Style Themes', 'udesign'); ?></th>
			    <td>
				<?php esc_html_e('Theme:', 'udesign'); ?>
                                <select name="udesign_options[udesign_pretty_photo_style_theme]" id="udesign_pretty_photo_style_theme">
                                    <option value="dark_rounded"<?php echo ($options['udesign_pretty_photo_style_theme'] == 'dark_rounded') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('dark_rounded', 'udesign'); ?></option>
                                    <option value="dark_square"<?php echo ($options['udesign_pretty_photo_style_theme'] == 'dark_square') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('dark_square', 'udesign'); ?></option>
                                    <option value="light_rounded"<?php echo ($options['udesign_pretty_photo_style_theme'] == 'light_rounded') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('light_rounded', 'udesign'); ?></option>
                                    <option value="light_square"<?php echo ($options['udesign_pretty_photo_style_theme'] == 'light_square') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('light_square', 'udesign'); ?></option>
                                    <option value="pp_default"<?php echo ($options['udesign_pretty_photo_style_theme'] == 'pp_default') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('pp_default', 'udesign'); ?></option>
                                    <option value="facebook"<?php echo ($options['udesign_pretty_photo_style_theme'] == 'facebook') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('facebook', 'udesign'); ?></option>
                                </select>
				<br /><span class="description"><?php esc_html_e('This option allows you to choose from a few prettyPhoto style themes available by default.', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Gallery Overlay', 'udesign'); ?></th>
			    <td>
				<label for="udesign_disable_pretty_photo_gallery_overlay">
				    <input name="udesign_options[udesign_disable_pretty_photo_gallery_overlay]" type="checkbox" id="udesign_disable_pretty_photo_gallery_overlay" value="yes" <?php checked('yes', $options['udesign_disable_pretty_photo_gallery_overlay']); ?> />
                                    <?php esc_html_e('Disable the mini gallery of thumbnails that overlays the preview image on mouse over.', 'udesign'); ?>
				</label>
                                <div class="clear"></div>
                                <div class="submit" style="padding:10px 0 0 80px; float:right; clear:both;">
                                    <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
                                    <input class="button-primary right" type="submit" name="form-submit" value="<?php esc_attr_e('Save Changes', 'udesign') ?>" />
                                    <span class="spinner"></span>
                                </div>
			    </td>
			</tr>
		    </tbody>
		</table>
                <h4 class="u-design-settings-page-headers"><?php esc_html_e('General', 'udesign'); ?></h4>
<?php           $show_breadcrumbs = isset( $options['show_breadcrumbs'] ) ? $options['show_breadcrumbs'] : ''; ?>
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Breadcrumbs', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Show Breadcrumbs', 'udesign'); ?></span></legend>
				<label for="show_breadcrumbs">
				    <input name="udesign_options[show_breadcrumbs]" type="checkbox" id="show_breadcrumbs" value="yes" <?php checked('yes', $show_breadcrumbs); ?> />
				    <?php esc_html_e('Show Breadcrumbs', 'udesign'); ?>
				</label>
				</fieldset>
                             </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php printf( __('Theme Update Notifier', 'udesign'), '<code>', '</code>'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Disable Theme Update Notifier', 'udesign'); ?></span></legend>
				<label for="disable_the_theme_update_notifier">
				    <input name="udesign_options[disable_the_theme_update_notifier]" type="checkbox" id="disable_the_theme_update_notifier" value="yes" <?php checked('yes', $options['disable_the_theme_update_notifier']); ?> />
                                    <?php esc_html_e("Disable notifications for new theme updates.", 'udesign'); ?>
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Schema.org Tags', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Enable Schema.org Tags', 'udesign'); ?></span></legend>
				<label for="enable_udesign_schema_tags">
				    <input name="udesign_options[enable_udesign_schema_tags]" type="checkbox" id="enable_udesign_schema_tags" value="yes" <?php checked('yes', $options['enable_udesign_schema_tags']); ?> />
                                    <?php esc_html_e("This option will enable schema.org tags within the theme where applicable.", 'udesign'); ?>
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Disable Image Cropping', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Disable Image Cropping', 'udesign'); ?></span></legend>
				<label for="udesign_disable_img_cropping">
				    <input name="udesign_options[udesign_disable_img_cropping]" type="checkbox" id="udesign_disable_img_cropping" value="yes" <?php checked('yes', $options['udesign_disable_img_cropping']); ?> />
                                    <?php esc_html_e("Disable image cropping when generating thumbnail images in sections like Blog, Portfolio, 'U-Design: Recent Posts' widget, etc.", 'udesign'); ?>
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Retina for Cropped Images', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Enable Retina for Cropped Images', 'udesign'); ?></span></legend>
				<label for="udesign_enable_retina_images">
				    <input name="udesign_options[udesign_enable_retina_images]" type="checkbox" id="udesign_enable_retina_images" value="yes" <?php checked('yes', $options['udesign_enable_retina_images']); ?> />
                                    <?php esc_html_e("Enable automatic retina images for cropped images (those usually are thumbnail images in sections like Blog, Portfolio, 'U-Design: Recent Posts' widget, etc.)", 'udesign'); ?>
                                </label><br /> 
                                <span class="description"><?php esc_html_e("If enabled, a double pixel ratio will be used for the cropped images. In order for this option to be applied the above 'Disable Image Cropping' option should not be checked. This option can be overwritten for individual portfolio thumbnails by the use of custom fields (see documentation for more information).", 'udesign'); ?></span>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Smooth Scrolling', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Disable Smooth Scrolling', 'udesign'); ?></span></legend>
				<label for="disable_smooth_scrolling_on_pages">
				    <input name="udesign_options[disable_smooth_scrolling_on_pages]" type="checkbox" id="disable_smooth_scrolling_on_pages" value="yes" <?php checked('yes', $options['disable_smooth_scrolling_on_pages']); ?> />
                                    <?php esc_html_e("This option will disable the smooth scrolling to an anchor link on same pages.", 'udesign'); ?>
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php printf( __('Custom Styles', 'udesign'), '<code>', '</code>'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Enable "style.css"', 'udesign'); ?></span></legend>
				<label for="enable_default_style_css">
				    <input name="udesign_options[enable_default_style_css]" type="checkbox" id="enable_default_style_css" value="yes" <?php checked('yes', $options['enable_default_style_css']); ?> />
                                    <?php printf( __('Enable the %1$sstyle.css%2$s located in the theme\'s root folder. You can then edit that file from %3$sAppearance %4$s Edit%5$s to add any custom CSS. You would also need to enable this option if you want to use a %6$schild theme%7$s.', 'udesign'), '<code>', '</code>', '<a href="theme-editor.php">', '&rarr;', '</a>', '<a target="_blank" title="More Info on WordPress Child Themes..." href="http://codex.wordpress.org/Child_Themes">', '</a>'); ?>
				</label>
				</fieldset>
			    </td>
			</tr>
		    </tbody>
		</table>
<?php		display_save_changes_button(); ?>
<?php	}

	function menus_options_contentbox( $options ) { ?>
                
                <h4 class="u-design-settings-page-headers"><?php esc_html_e('Main Menu', 'udesign'); ?></h4>
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('"Stay-On-Top" Main Menu', 'udesign'); ?></th>
                            <td>
                                <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('"Stay-On-Top" the Main Menu', 'udesign'); ?></span></legend>
                                <label for="fixed_main_menu">
                                    <input name="udesign_options[fixed_main_menu]" type="checkbox" id="fixed_main_menu" value="yes" <?php checked('yes', $options['fixed_main_menu']); ?> />
                                    <?php esc_html_e("Fix the main navigation bar to stay on top of the page once header has been scrolled past.", 'udesign'); ?>
                                </label>
                                </fieldset>
                            </td>
                        </tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('"Stay-On-Top" Main Menu Logo (optional)', 'udesign'); ?></th>
			    <td>
                                <div style="margin-bottom:5px;  padding:0; float:left;">
                                    <label for="fixed_menu_logo"><?php esc_html_e('Enter a URL or upload an image for your "Stay-On-Top" menu logo:', 'udesign'); ?></label><br />
                                    <input name="udesign_options[fixed_menu_logo]" type="text" id="fixed_menu_logo" value="<?php if( $options['fixed_menu_logo'] ){ echo esc_url($options['fixed_menu_logo']); } ?>" size="65" />
                                    <input id="upload_fixed_menu_logo_button" type="button" value="<?php esc_attr_e('Upload Logo', 'udesign'); ?>" class="button-secondary" />
                                </div>
                                <div class="clear"></div>
                                <span class="description"><?php esc_html_e('You may use this option to specify a logo for the "Stay-On-Top" menu. Please note, this is optional, the fallback is the the main logo (scaled down version).', 'udesign'); ?></span>
			    </td>
			</tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('Disable the "Stay-On-Top" Main Menu Logo', 'udesign'); ?></th>
                            <td>
                                <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('"Stay-On-Top" the Main Menu', 'udesign'); ?></span></legend>
                                <label for="fixed_menu_logo_disabled">
                                    <input name="udesign_options[fixed_menu_logo_disabled]" type="checkbox" id="fixed_menu_logo_disabled" value="yes" <?php checked('yes', $options['fixed_menu_logo_disabled']); ?> />
                                    <?php esc_html_e('Selecting this option will remove the logo from the "Stay-On-Top" menu.', 'udesign'); ?>
                                </label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('"Stay-On-Top" Menu Shadow', 'udesign'); ?></th>
                            <td>
                                <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('"Stay-On-Top" Menu Shadow', 'udesign'); ?></span></legend>
                                <label for="add_fixed_menu_shadow">
                                    <input name="udesign_options[add_fixed_menu_shadow]" type="checkbox" id="add_fixed_menu_shadow" value="yes" <?php checked('yes', $options['add_fixed_menu_shadow']); ?> />
                                    <?php esc_html_e("Add shadow to the Stay-On-Top menu.", 'udesign'); ?>
                                </label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('"Stay-On-Top" Remove Background Image', 'udesign'); ?></th>
                            <td>
                                <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('"Stay-On-Top" Remove Background Image', 'udesign'); ?></span></legend>
                                <label for="remove_fixed_menu_background_image">
                                    <input name="udesign_options[remove_fixed_menu_background_image]" type="checkbox" id="remove_fixed_menu_background_image" value="yes" <?php checked('yes', $options['remove_fixed_menu_background_image']); ?> />
                                    <?php esc_html_e("Remove the background image behind the Stay-On-Top menu, in which case the background color assigned to the Main Menu or Top Area will be used instead.", 'udesign'); ?>
                                </label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('Disable "Stay-On-Top" Menu on Mobile Devices', 'udesign'); ?></th>
                            <td>
                                <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Disable "Stay-On-Top" Menu on Mobile Devices', 'udesign'); ?></span></legend>
                                <label for="remove_fixed_menu_on_mobile_devices">
                                    <input name="udesign_options[remove_fixed_menu_on_mobile_devices]" type="checkbox" id="remove_fixed_menu_on_mobile_devices" value="yes" <?php checked('yes', $options['remove_fixed_menu_on_mobile_devices']); ?> />
                                    <?php esc_html_e("This option will disable the Stay-On-Top menu on mobile devices only.", 'udesign'); ?>
                                    <span class="description">(<?php esc_html_e("It only applies for non-responsive layout.", 'udesign'); ?>)</span>
                                </label>
                                </fieldset>
                                <div class="clear"></div>
                                <div class="submit" style="padding:10px 0 0 80px; float:right; clear:both;">
                                    <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
                                    <input class="button-primary right" type="submit" name="form-submit" value="<?php esc_attr_e('Save Changes', 'udesign') ?>" />
                                    <span class="spinner"></span>
                                </div>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('Main Menu Alignment', 'udesign'); ?></th>
                            <td>
                                <?php esc_html_e('Choose alignment:', 'udesign'); ?>
                                <select name="udesign_options[main_menu_alignment]" id="main_menu_alignment">
                                    <option value="right"<?php echo ($options['main_menu_alignment'] == 'right') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('right', 'udesign'); ?></option>
                                    <option value="left"<?php echo ($options['main_menu_alignment'] == 'left') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('left', 'udesign'); ?></option>
                                    <option value="center"<?php echo ($options['main_menu_alignment'] == 'center') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('center', 'udesign'); ?></option>
                                </select>
                                <span class="description"><?php esc_html_e('This option sets the main navigation menu alignment.', 'udesign'); ?></span>
                            </td>
                        </tr>
			<tr valign="top">
			    <th scope="row"><label for="main_menu_vertical_positioning"><?php esc_html_e('Main Menu Vertical Positioning', 'udesign'); ?></label></th>
			    <td>
				<input name="udesign_options[main_menu_vertical_positioning]" type="text" id="main_menu_vertical_positioning" value="<?php echo ($options['main_menu_vertical_positioning']) ? esc_attr($options['main_menu_vertical_positioning']) : 0; ?>" size="5" maxlength="3" />
				<span> px. <?php esc_html_e('This option allows you to move the menu vertically towards the top or bottom of the Top Area ("0" is the default which places the menu at the bottom).', 'udesign'); ?></span>
			    </td>
			</tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('Main Menu Auto Arrows', 'udesign'); ?></th>
                            <td>
                                <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Main Menu Auto Arrows', 'udesign'); ?></span></legend>
                                <label for="show_menu_auto_arrows">
                                    <input name="udesign_options[show_menu_auto_arrows]" type="checkbox" id="show_menu_auto_arrows" value="yes" <?php checked('yes', $options['show_menu_auto_arrows']); ?> />
                                    <?php esc_html_e("Show the top navigation menu's auto arrows. Those are the arrows indicating a submenu. ", 'udesign'); ?>
                                </label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('Submenu Drop Shadow', 'udesign'); ?></th>
                            <td>
                                <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Submenu Drop Shadow', 'udesign'); ?></span></legend>
                                <label for="show_menu_drop_shadows">
                                    <input name="udesign_options[show_menu_drop_shadows]" type="checkbox" id="show_menu_drop_shadows" value="yes" <?php checked('yes', $options['show_menu_drop_shadows']); ?> />
                                    <?php esc_html_e("Enable drop shadow for the submenu. ", 'udesign'); ?>
                                </label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('Border Under the Menu', 'udesign'); ?></th>
                            <td>
                                <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Border Under the Menu', 'udesign'); ?></span></legend>
                                <label for="remove_border_under_menu">
                                    <input name="udesign_options[remove_border_under_menu]" type="checkbox" id="remove_border_under_menu" value="yes" <?php checked('yes', $options['remove_border_under_menu']); ?> />
                                    <?php esc_html_e("Remove the border line located under the menu. ", 'udesign'); ?>
                                </label>
                                </fieldset>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h4 class="u-design-settings-page-headers"><?php esc_html_e('Secondary Menu', 'udesign'); ?></h4>
		<table class="form-table">
		    <tbody>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('Enable Secondary Menu Bar', 'udesign'); ?></th>
                            <td>
                                <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Enable Secondary Menu Bar', 'udesign'); ?></span></legend>
                                <label for="enable_secondary_menu_bar">
                                    <input name="udesign_options[enable_secondary_menu_bar]" type="checkbox" id="enable_secondary_menu_bar" value="yes" <?php checked('yes', $options['enable_secondary_menu_bar']); ?> />
                                    <?php esc_html_e("Toggle the visibility for the secondary menu bar. ", 'udesign'); ?>
                                    <div style="margin-top:10px;">
                                        <span class="description"><?php printf( __('You may customize the colors of the secondary navigation bar from %1$sCustom Colors %2$s Secondary Menu Colors%3$s section.', 'udesign'), '<strong>', '&rarr;' ,'</strong>'); ?></span>
                                    </div>
                                </label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr id="sec_nav_text_area_1_options" valign="top">
			    <th scope="row" id="sec_nav_text_area_1_options_header"><?php esc_html_e('Text Area 1', 'udesign'); ?></th>
			    <td class="sec_nav_td_options_wrapper">
				<span class="description sec_nav_txt_area_1_description"><?php esc_html_e('You could use this area to add text, phone number, or other information. You may use HTML tags.', 'udesign'); ?></span>
				<textarea style="width: 98%;" id="secondary_menu_text_area_1" rows="2" cols="60" name="udesign_options[secondary_menu_text_area_1]"><?php if( $options['secondary_menu_text_area_1'] ){ echo esc_attr($options['secondary_menu_text_area_1']); } ?></textarea>
                                <div class="clear" style="margin-bottom: 3px;"></div>
                                <div id="text_area_1_dummy_content"><?php echo get_udesign_text_area_1_dummy_content(); ?></div>
                                <a id="insert_text_area_1_dummy_content" href=""><?php esc_html_e('Restore Default Content', 'udesign'); ?></a>
                                
                                <div class="clear" style="margin-bottom: 15px;"></div>
                                <label for="secondary_menu_text_area_1_alignment"><?php esc_html_e('Text alignment:', 'udesign'); ?></label>
                                <select name="udesign_options[secondary_menu_text_area_1_alignment]" id="secondary_menu_text_area_1_alignment">
                                    <option value="left"<?php echo ($options['secondary_menu_text_area_1_alignment'] == 'left') ? ' selected="selected"' : ''; ?> style="min-width:60px;"><?php esc_attr_e('left', 'udesign'); ?></option>
                                    <option value="right"<?php echo ($options['secondary_menu_text_area_1_alignment'] == 'right') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('right', 'udesign'); ?></option>
                                    <option value="center"<?php echo ($options['secondary_menu_text_area_1_alignment'] == 'center') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('center', 'udesign'); ?></option>
                                </select>
                                <span class="description"><?php esc_html_e('This option sets the text alignment for the Text Area 1.', 'udesign'); ?></span>
                                <div class="clear" style="margin-bottom: 10px;"></div>
                                <div class="sec-nav-width-opt-wrapper">
                                    <label for="secondary_menu_text_area_1_width"><?php esc_html_e('Select width:', 'udesign'); ?></label>
                                    <select name="udesign_options[secondary_menu_text_area_1_width]" id="secondary_menu_text_area_1_width">
<?php                                   for ( $x = 0; $x <= 24; $x++ ) : 
                                            if ( !isset($options['secondary_menu_text_area_1_width']) && $x == 0 ) { // default value case
                                                $is_selected = ' selected="selected"';
                                            } else {
                                                $is_selected = ( $options['secondary_menu_text_area_1_width'] == $x ) ? ' selected="selected"' : '';
                                            } ?>
                                            <option value="<?php echo $x; ?>"<?php echo $is_selected; ?>>grid_<?php echo ($x == 0) ? $x . esc_html__(" &nbsp;(Hide)", 'udesign') : $x; ?></option>
<?php                                   endfor; ?>
                                    </select>
                                    <span class="description"><?php esc_html_e('The total including the other two areas combined should add up to grid_24.', 'udesign'); ?></span>
                                </div>
<?php                           // The following button is use for closing the Thickbox modal only ?>
                                <p id="sec_nav_txt_area_1_btn" style="display:none;">
                                    <input type="button" onclick="tb_remove();" class="button-primary" value="<?php echo __('Save Changes', 'udesign'); ?>" />
                                </p>
			    </td>
			</tr>
                        <tr id="sec_nav_text_area_2_options" valign="top">
			    <th scope="row" id="sec_nav_text_area_2_options_header"><?php esc_html_e('Text Area 2', 'udesign'); ?></th>
			    <td class="sec_nav_td_options_wrapper">
				<span class="description sec_nav_txt_area_2_description"><?php esc_html_e('You could use this area to add text, phone number, or other information. You may use HTML tags.', 'udesign'); ?></span>
				<textarea style="width: 98%;" id="secondary_menu_text_area_2" rows="2" cols="60" name="udesign_options[secondary_menu_text_area_2]"><?php if( $options['secondary_menu_text_area_2'] ){ echo esc_attr($options['secondary_menu_text_area_2']); } ?></textarea>
                                <div class="clear" style="margin-bottom: 3px;"></div>
                                <div id="text_area_2_dummy_content"><?php echo get_udesign_social_icons_html(); ?></div>
                                <a id="insert_text_area_2_dummy_content" href=""><?php esc_html_e('Restore Default Icons', 'udesign'); ?></a>
                                
                                <div class="clear" style="margin-bottom: 10px;"></div>
                                <label for="secondary_menu_text_area_2_alignment"><?php esc_html_e('Text alignment:', 'udesign'); ?></label>
                                <select name="udesign_options[secondary_menu_text_area_2_alignment]" id="secondary_menu_text_area_2_alignment">
                                    <option value="right"<?php echo ($options['secondary_menu_text_area_2_alignment'] == 'right') ? ' selected="selected"' : ''; ?> style="min-width:60px;"><?php esc_attr_e('right', 'udesign'); ?></option>
                                    <option value="left"<?php echo ($options['secondary_menu_text_area_2_alignment'] == 'left') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('left', 'udesign'); ?></option>
                                    <option value="center"<?php echo ($options['secondary_menu_text_area_2_alignment'] == 'center') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('center', 'udesign'); ?></option>
                                </select>
                                <span class="description"><?php esc_html_e('This option sets the text alignment for the Text Area 2.', 'udesign'); ?></span>
                                <div class="clear" style="margin-bottom: 10px;"></div>
                                <div class="sec-nav-width-opt-wrapper">
                                    <label for="secondary_menu_text_area_2_width"><?php esc_html_e('Select width:', 'udesign'); ?></label>
                                    <select name="udesign_options[secondary_menu_text_area_2_width]" id="secondary_menu_text_area_2_width">
<?php                                   for ( $x = 0; $x <= 24; $x++ ) : 
                                            if ( !isset($options['secondary_menu_text_area_2_width']) && $x == 0 ) { // default value case
                                                $is_selected = ' selected="selected"';
                                            } else {
                                                $is_selected = ( $options['secondary_menu_text_area_2_width'] == $x ) ? ' selected="selected"' : '';
                                            } ?>
                                            <option value="<?php echo $x; ?>"<?php echo $is_selected; ?>>grid_<?php echo ($x == 0) ? $x . esc_html__(" &nbsp;(Hide)", 'udesign') : $x; ?></option>
<?php                                   endfor; ?>
                                    </select>
                                    <span class="description"><?php esc_html_e('The total including the other two areas combined should add up to grid_24.', 'udesign'); ?></span>
                                </div>
<?php                           // The following button is use for closing the Thickbox modal only ?>
                                <p id="sec_nav_txt_area_2_btn" style="display:none;">
                                    <input type="button" onclick="tb_remove();" class="button-primary" value="<?php echo __('Save Changes', 'udesign'); ?>" />
                                </p>
			    </td>
			</tr>
                        <tr id="sec_nav_menu_options" valign="top">
			    <th scope="row" id="sec_nav_menu_options_header"><?php esc_html_e('Choose a Menu', 'udesign'); ?></th>
			    <td class="sec_nav_td_options_wrapper">
                                <select name="udesign_options[secondary_menu_term_id]" id="secondary_menu_term_id">
                                    <option selected="selected" value="select_menu">&mdash; <?php esc_html_e('Select Menu', 'udesign'); ?> &mdash;</option>
<?php                               $available_menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
                                    foreach ( $available_menus as $menu ): ?>
                                        <option value="<?php echo $menu->term_id; ?>"<?php echo ($options['secondary_menu_term_id'] == $menu->term_id) ? ' selected="selected"' : ''; ?>><?php echo $menu->name; ?></option>
<?php                               endforeach; ?>
                                </select>
				<?php esc_html_e('This option allows you to assign a menu to the secondary nativation bar. Please note that only the top level menu items will be displayed (submenus are excluded).', 'udesign'); ?> 
                                <span class="description"><?php printf( __('If there are no menus listed above you may create one from the %1$sAppearance %2$s Menus%3$s section.', 'udesign'), 
                                        '<a title="'.esc_html__('This link will open in a new window the WordPress Menus Editor section.', 'udesign').'" target="_blank" href="nav-menus.php">', '&rarr;', '</a>'); ?></span>
                                <div class="clear" style="margin-bottom: 10px;"></div>
                                <label for="secondary_menu_text_alignment"><?php esc_html_e('Text alignment:', 'udesign'); ?></label>
                                <select name="udesign_options[secondary_menu_text_alignment]" id="secondary_menu_text_alignment">
                                    <option value="center"<?php echo ($options['secondary_menu_text_alignment'] == 'center') ? ' selected="selected"' : ''; ?> style="min-width:60px;"><?php esc_attr_e('center', 'udesign'); ?></option>
                                    <option value="left"<?php echo ($options['secondary_menu_text_alignment'] == 'left') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('left', 'udesign'); ?></option>
                                    <option value="right"<?php echo ($options['secondary_menu_text_alignment'] == 'right') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('right', 'udesign'); ?></option>
                                </select>
                                <span class="description"><?php esc_html_e('This option sets the text alignment for the menu.', 'udesign'); ?></span>
                                <div class="clear" style="margin-bottom: 10px;"></div>
                                <div class="sec-nav-width-opt-wrapper">
                                    <label for="secondary_menu_width"><?php esc_html_e('Select width:', 'udesign'); ?></label>
                                    <select name="udesign_options[secondary_menu_width]" id="secondary_menu_width">
<?php                                   for ( $x = 0; $x <= 24; $x++ ) : 
                                            if ( !isset($options['secondary_menu_width']) && $x == 0 ) { // default value case
                                                $is_selected = ' selected="selected"';
                                            } else {
                                                $is_selected = ( $options['secondary_menu_width'] == $x ) ? ' selected="selected"' : '';
                                            } ?>
                                            <option value="<?php echo $x; ?>"<?php echo $is_selected; ?>>grid_<?php echo ($x == 0) ? $x . esc_html__(" &nbsp;(Hide)", 'udesign') : $x; ?></option>
<?php                                   endfor; ?>
                                    </select>
                                    <span class="description"><?php esc_html_e('The total including the other two areas combined should add up to grid_24.', 'udesign'); ?></span>
                                </div>
<?php                           // The following button is use for closing the Thickbox modal only ?>
                                <p id="sec_nav_menu_btn" style="display:none;">
                                    <input type="button" onclick="tb_remove();" class="button-primary" value="<?php echo __('Save Changes', 'udesign'); ?>" />
                                </p>
                            </td>
                        </tr>
                        <tr id="sec_nav_items_order_option" valign="top" style="background-color:#FCFCFC; border:1px solid #DDDDDD;">
                            <th scope="row"><?php esc_html_e('Choose Order', 'udesign'); ?></th>
			    <td style="padding-top: 20px; padding-bottom: 20px;">
                                <select name="udesign_options[secondary_menu_items_order]" id="secondary_menu_items_order">
                                    <option value="not_applicable"<?php echo ($options['secondary_menu_items_order'] == 'not_applicable') ? ' selected="selected"' : ''; ?>>No Items Available</option>
                                    <option value="txt1|menu|txt2"<?php echo ($options['secondary_menu_items_order'] == 'txt1|menu|txt2') ? ' selected="selected"' : ''; ?>>Text Area 1 | Menu | Text Area 2</option>
                                    <option value="txt1|txt2|menu"<?php echo ($options['secondary_menu_items_order'] == 'txt1|txt2|menu') ? ' selected="selected"' : ''; ?>>Text Area 1 | Text Area 2 | Menu</option>
                                    <option value="menu|txt1|txt2"<?php echo ($options['secondary_menu_items_order'] == 'menu|txt1|txt2') ? ' selected="selected"' : ''; ?>>Menu | Text Area 1 | Text Area 2</option>
                                    <option value="menu|txt2|txt1"<?php echo ($options['secondary_menu_items_order'] == 'menu|txt2|txt1') ? ' selected="selected"' : ''; ?>>Menu | Text Area 2 | Text Area 1</option>
                                    <option value="txt2|menu|txt1"<?php echo ($options['secondary_menu_items_order'] == 'txt2|menu|txt1') ? ' selected="selected"' : ''; ?>>Text Area 2 | Menu | Text Area 1</option>
                                    <option value="txt2|txt1|menu"<?php echo ($options['secondary_menu_items_order'] == 'txt2|txt1|menu') ? ' selected="selected"' : ''; ?>>Text Area 2 | Text Area 1 | Menu</option>
                                    <option value="txt1|menu"<?php echo ($options['secondary_menu_items_order'] == 'txt1|menu') ? ' selected="selected"' : ''; ?>>Text Area 1 | Menu</option>
                                    <option value="menu|txt1"<?php echo ($options['secondary_menu_items_order'] == 'menu|txt1') ? ' selected="selected"' : ''; ?>>Menu | Text Area 1</option>
                                    <option value="txt2|menu"<?php echo ($options['secondary_menu_items_order'] == 'txt2|menu') ? ' selected="selected"' : ''; ?>>Text Area 2 | Menu</option>
                                    <option value="menu|txt2"<?php echo ($options['secondary_menu_items_order'] == 'menu|txt2') ? ' selected="selected"' : ''; ?>>Menu | Text Area 2</option>
                                    <option value="txt1|txt2"<?php echo ($options['secondary_menu_items_order'] == 'txt1|txt2') ? ' selected="selected"' : ''; ?>>Text Area 1 | Text Area 2</option>
                                    <option value="txt2|txt1"<?php echo ($options['secondary_menu_items_order'] == 'txt2|txt1') ? ' selected="selected"' : ''; ?>>Text Area 2 | Text Area 1</option>
                                    <option value="txt1"<?php echo ($options['secondary_menu_items_order'] == 'txt1') ? ' selected="selected"' : ''; ?>>Text Area 1</option>
                                    <option value="txt2"<?php echo ($options['secondary_menu_items_order'] == 'txt2') ? ' selected="selected"' : ''; ?>>Text Area 2</option>
                                    <option value="menu"<?php echo ($options['secondary_menu_items_order'] == 'menu') ? ' selected="selected"' : ''; ?>>Menu</option>
                                </select>
				<?php esc_html_e('This option allows you to assign the order in which the secondary menu items will be shown.', 'udesign'); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <?php add_thickbox(); ?>
                <div id="sec-nav-bar-simulator-wrapper">
                    <div class="ui-widget ui-helper-clearfix">
                        <span class="description"><?php esc_html_e('Drag and Drop items in this menu simulator area from the dashed border area below to add them to the menu. Drag and drop horizontally to change order or resize to set desired width:', 'udesign'); ?></span>
                        <ul id="sec-nav-bar-items-simulator-list" class="sec-nav-bar-items-list ui-helper-reset ui-helper-clearfix sec-nav-bar-connected-sortable"></ul>
                        <div class="clear" style="height: 30px;"></div>
                        <span class="description"><?php esc_html_e('Drop items in this area to remove them from the menu:', 'udesign'); ?></span>
                        <ul id="sec-nav-bar-items-list" class="sec-nav-bar-items-list ui-helper-reset ui-helper-clearfix sec-nav-bar-connected-sortable"></ul>
                    </div>
                </div>
                <div class="clear"></div>
                
                
<?php		display_save_changes_button(); ?>
<?php	}

	function layout_options_contentbox( $options ) { ?>
                
                <div style="background-color:#FCFCFC; border:1px solid #DDDDDD; margin:6px 0 0;  padding:15px 15px 5px;">
		  <table class="form-table">
		    <tbody>
                        <tr valign="top">
                            <th scope="row" style="padding-right:0"><?php esc_html_e('Page Title', 'udesign'); ?></th>
                            <td>
                                <label for="page_title_position" class="link-target" style="float:left; display:inline-block;">
                                        <select name="udesign_options[page_title_position]" id="page_title_position">
                                            <option value="position1"<?php echo ($options['page_title_position'] == 'position1') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Title Position 1', 'udesign'); ?></option>
                                            <option value="position2"<?php echo ($options['page_title_position'] == 'position2') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Title Position 2', 'udesign'); ?></option>
                                            <option value="remove1"<?php echo ($options['page_title_position'] == 'remove1') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('Remove Title (SEO-Friendly)', 'udesign'); ?></option>
                                            <option value="remove2"<?php echo ($options['page_title_position'] == 'remove2') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Remove Title Completely', 'udesign'); ?></option>
                                        </select>
                                </label>
                                <div class="submit" style="padding-left:20px; float:left; display:inline-block;">
				    <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
				    <input class="button-secondary left" type="submit" name="form-submit" value="<?php esc_attr_e('Update', 'udesign'); ?>" />
                                    <span class="spinner"></span>
				</div>
                                <ul style="float:left; margin-bottom:0;">
                                    <li><strong><?php esc_html_e('Title Position 1', 'udesign'); ?></strong> - <?php esc_html_e('Display Title immediately under the Main Menu, it spans the full width of page.', 'udesign'); ?></li>
                                    <li><strong><?php esc_html_e('Title Position 2', 'udesign'); ?></strong> - <?php esc_html_e('Display Title inside Main Content, it spans the main content width.', 'udesign'); ?></li>
                                    <li><strong><?php esc_html_e('Remove Title (SEO-Friendly)', 'udesign'); ?></strong> - <?php esc_html_e('Remove Title visually, so that human visitors will not see it, yet it will still be served as an "h1" heading to search engine spiders.', 'udesign'); ?></li>
                                    <li><strong><?php esc_html_e('Remove Title Completely', 'udesign'); ?></strong> - <?php esc_html_e(' ... just as it says! A word of caution, when using this option keep in mind that your pages will be left without an "h1" heading. It is your responsibility to look after that.', 'udesign'); ?></li>
                                </ul>
                            </td>
                        </tr>
		    </tbody>
                  </table>
                </div>
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Home Page Column 1', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Home Page Column 1', 'udesign'); ?></span></legend>
				    <label for="home_page_col_1_fixed">
					<input name="udesign_options[home_page_col_1_fixed]" type="checkbox" id="home_page_col_1_fixed" value="yes" <?php checked('yes', $options['home_page_col_1_fixed']); ?> />
					<?php esc_html_e('Set the width of the "Home Page Column 1" Widget Area as constant 1/3 width (Applies only to a two column layout, in other words having the first widget area "Home Page Column 1" in combination with any of the other widget areas being active).', 'udesign'); ?><br />
				    </label>
				</fieldset>
			    </td>
			</tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('Remove Sidebar from Default Pages', 'udesign'); ?></th>
                            <td>
                                <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Remove Sidebar from Default Pages', 'udesign'); ?></span></legend>
                                <label for="remove_default_page_sidebar">
                                    <input name="udesign_options[remove_default_page_sidebar]" type="checkbox" id="remove_default_page_sidebar" value="yes" <?php checked('yes', $options['remove_default_page_sidebar']); ?> />
                                    <?php esc_html_e('Remove the sidebar from the default page template. This will make all pages that have been assigned "Default Template" full width.', 'udesign'); ?><br />
                                </label>
                                </fieldset>
                            </td>
                        </tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Default Pages Sidebar Position', 'udesign'); ?></th>
			    <td>
				<?php esc_html_e('Choose position:', 'udesign'); ?><br />
				<label><input type="radio" name="udesign_options[pages_sidebar]" id="pages_sidebar_left" value="left" <?php checked('left', $options['pages_sidebar']); ?> /> <?php esc_html_e('Left', 'udesign'); ?></label>&nbsp;&nbsp;
				<label><input type="radio" name="udesign_options[pages_sidebar]" id="pages_sidebar_right" value="right" <?php checked('right', $options['pages_sidebar']); ?> /> <?php esc_html_e('Right', 'udesign'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="description"><?php esc_html_e('This is the sidebar position for all pages assigned with "Default Template".', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Default Pages Sidebar 2 Position', 'udesign'); ?></th>
			    <td>
				<?php esc_html_e('Choose position:', 'udesign'); ?><br />
				<label><input type="radio" name="udesign_options[pages_sidebar_2]" id="pages_sidebar_2_left" value="left" <?php checked('left', $options['pages_sidebar_2']); ?> /> <?php esc_html_e('Left', 'udesign'); ?></label>&nbsp;&nbsp;
				<label><input type="radio" name="udesign_options[pages_sidebar_2]" id="pages_sidebar_2_right" value="right" <?php checked('right', $options['pages_sidebar_2']); ?> /> <?php esc_html_e('Right', 'udesign'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="description"><?php esc_html_e('This is the sidebar position for all pages assigned with "Page Template 2".', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Default Pages Sidebar 3 Position', 'udesign'); ?></th>
			    <td>
				<?php esc_html_e('Choose position:', 'udesign'); ?><br />
				<label><input type="radio" name="udesign_options[pages_sidebar_3]" id="pages_sidebar_3_left" value="left" <?php checked('left', $options['pages_sidebar_3']); ?> /> <?php esc_html_e('Left', 'udesign'); ?></label>&nbsp;&nbsp;
				<label><input type="radio" name="udesign_options[pages_sidebar_3]" id="pages_sidebar_3_right" value="right" <?php checked('right', $options['pages_sidebar_3']); ?> /> <?php esc_html_e('Right', 'udesign'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="description"><?php esc_html_e('This is the sidebar position for all pages assigned with "Page Template 3".', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Default Pages Sidebar 4 Position', 'udesign'); ?></th>
			    <td>
				<?php esc_html_e('Choose position:', 'udesign'); ?><br />
				<label><input type="radio" name="udesign_options[pages_sidebar_4]" id="pages_sidebar_4_left" value="left" <?php checked('left', $options['pages_sidebar_4']); ?> /> <?php esc_html_e('Left', 'udesign'); ?></label>&nbsp;&nbsp;
				<label><input type="radio" name="udesign_options[pages_sidebar_4]" id="pages_sidebar_4_right" value="right" <?php checked('right', $options['pages_sidebar_4']); ?> /> <?php esc_html_e('Right', 'udesign'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="description"><?php esc_html_e('This is the sidebar position for all pages assigned with "Page Template 4".', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Default Pages Sidebar 5 Position', 'udesign'); ?></th>
			    <td>
				<?php esc_html_e('Choose position:', 'udesign'); ?><br />
				<label><input type="radio" name="udesign_options[pages_sidebar_5]" id="pages_sidebar_5_left" value="left" <?php checked('left', $options['pages_sidebar_5']); ?> /> <?php esc_html_e('Left', 'udesign'); ?></label>&nbsp;&nbsp;
				<label><input type="radio" name="udesign_options[pages_sidebar_5]" id="pages_sidebar_5_right" value="right" <?php checked('right', $options['pages_sidebar_5']); ?> /> <?php esc_html_e('Right', 'udesign'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="description"><?php esc_html_e('This is the sidebar position for all pages assigned with "Page Template 5".', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Default Pages Sidebar 6 Position', 'udesign'); ?></th>
			    <td>
				<?php esc_html_e('Choose position:', 'udesign'); ?><br />
				<label><input type="radio" name="udesign_options[pages_sidebar_6]" id="pages_sidebar_6_left" value="left" <?php checked('left', $options['pages_sidebar_6']); ?> /> <?php esc_html_e('Left', 'udesign'); ?></label>&nbsp;&nbsp;
				<label><input type="radio" name="udesign_options[pages_sidebar_6]" id="pages_sidebar_6_right" value="right" <?php checked('right', $options['pages_sidebar_6']); ?> /> <?php esc_html_e('Right', 'udesign'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="description"><?php esc_html_e('This is the sidebar position for all pages assigned with "Page Template 6".', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Default Pages Sidebar 7 Position', 'udesign'); ?></th>
			    <td>
				<?php esc_html_e('Choose position:', 'udesign'); ?><br />
				<label><input type="radio" name="udesign_options[pages_sidebar_7]" id="pages_sidebar_7_left" value="left" <?php checked('left', $options['pages_sidebar_7']); ?> /> <?php esc_html_e('Left', 'udesign'); ?></label>&nbsp;&nbsp;
				<label><input type="radio" name="udesign_options[pages_sidebar_7]" id="pages_sidebar_7_right" value="right" <?php checked('right', $options['pages_sidebar_7']); ?> /> <?php esc_html_e('Right', 'udesign'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="description"><?php esc_html_e('This is the sidebar position for all pages assigned with "Page Template 7".', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Default Pages Sidebar 8 Position', 'udesign'); ?></th>
			    <td>
				<?php esc_html_e('Choose position:', 'udesign'); ?><br />
				<label><input type="radio" name="udesign_options[pages_sidebar_8]" id="pages_sidebar_8_left" value="left" <?php checked('left', $options['pages_sidebar_8']); ?> /> <?php esc_html_e('Left', 'udesign'); ?></label>&nbsp;&nbsp;
				<label><input type="radio" name="udesign_options[pages_sidebar_8]" id="pages_sidebar_8_right" value="right" <?php checked('right', $options['pages_sidebar_8']); ?> /> <?php esc_html_e('Right', 'udesign'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="description"><?php esc_html_e('This is the sidebar position for all pages assigned with "Page Template 8".', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Sitemap Page Sidebar Position', 'udesign'); ?></th>
			    <td>
				<?php esc_html_e('Choose position:', 'udesign'); ?><br />
				<label><input type="radio" name="udesign_options[sitemap_sidebar]" id="sitemap_sidebar_left" value="left" <?php checked('left', $options['sitemap_sidebar']); ?> /> <?php esc_html_e('Left', 'udesign'); ?></label>&nbsp;&nbsp;
				<label><input type="radio" name="udesign_options[sitemap_sidebar]" id="sitemap_sidebar_right" value="right" <?php checked('right', $options['sitemap_sidebar']); ?> /> <?php esc_html_e('Right', 'udesign'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="description"><?php esc_html_e('This is the sidebar position for all pages assigned with "Sitemap page" template.', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Show Comments on Pages', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Show Comments on Pages', 'udesign'); ?></span></legend>
				<label for="show_comments_on_pages">
				    <input name="udesign_options[show_comments_on_pages]" type="checkbox" id="show_comments_on_pages" value="yes" <?php checked('yes', $options['show_comments_on_pages']); ?> />
				    <?php esc_html_e("Show Comments on Pages. Those are the pages assigned with the 'Default Page', 'Page Template 2', ..., 'Page Template 8' and 'Full-width Page' templates. Additionally, you can 'Allow' these comments from the individual page's configuration.", 'udesign'); ?>
				</label>
				</fieldset>
                                
                                <div class="clear"></div>
                                <div class="submit" style="padding:10px 0 0 80px; float:right; clear:both;">
                                    <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
                                    <input class="button-primary right" type="submit" name="form-submit" value="<?php esc_attr_e('Save Changes', 'udesign') ?>" />
                                    <span class="spinner"></span>
                                </div>
			    </td>
			</tr>
		    </tbody>
		</table>
                
                <div style="margin:10px 0; padding:15px 15px 20px; display:block; background-color:#F8F8F1; border:1px solid #DDD;">
                  <h2 style="color:#ff4d00; margin: 2px 0; padding:0;"><?php esc_html_e('Greater than 960px Theme Width Fluid Layout', 'udesign'); ?></h2>
                  <p><span class="description"><?php esc_html_e("In Fluid Layout the widths of elements such as the main content block, sidebar, columns, etc. are converted to percentages rather than fixed width in pixels. This allows resizing of those elements to be relative to the browser window width. This section allows you to set the overall theme and sidebar width. The theme width can only be greater than the default 960px and will only exhibit fluid behaviour in widths greater than the default 960px width. If the site is viewed in a device or browser with width less than 960px then the theme will behave as a standard fixed width theme with 960px width frame, unless of course Responsive layout is enabled.", 'udesign'); ?></span></p>
		  <table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Enable Maximum Width', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Enable Maximum Width', 'udesign'); ?></span></legend>
				<label for="max_theme_width">
				    <input name="udesign_options[max_theme_width]" type="checkbox" id="max_theme_width" value="yes" <?php checked('yes', $options['max_theme_width']); ?> />
				    <?php esc_html_e("Set the theme width to the maximum possible browser or device width.", 'udesign'); ?>
                                    <span class="description"><?php esc_html_e('(Fluid Layout)', 'udesign'); ?></span>
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top" id="global_theme_width_slide_bar_wrapper">
			    <th scope="row" style="padding-right:0"><?php esc_html_e('Global Theme Width', 'udesign'); ?></th>
			    <td>
                                <div id="global_theme_width_slide_bar"></div>
				<input name="udesign_options[global_theme_width]" type="text" id="global_theme_width" value="<?php echo ( $options['global_theme_width'] ) ? esc_attr($options['global_theme_width']) : '960'; ?>" size="5" maxlength="4" />px. 
                                <span class="description"><?php esc_html_e('(Width) in pixels.', 'udesign'); ?></span>
                                <?php esc_html_e('This option is about the overall theme width and it will be applied to all pages. You may specify a range between 960px and 1600px.', 'udesign'); ?>
                                <span class="description"><?php esc_html_e('(default: 960)', 'udesign'); ?></span>
                            </td>
                        </tr>
			<tr valign="top">
			    <th scope="row" style="padding-right:0"><?php esc_html_e('Global Sidebar Width', 'udesign'); ?></th>
			    <td>
                                <div id="global_sidebar_width_slide_bar"></div>
				<input name="udesign_options[global_sidebar_width]" type="text" id="global_sidebar_width" value="<?php echo ( $options['global_sidebar_width'] ) ? esc_attr($options['global_sidebar_width']) : '33'; ?>" size="5" maxlength="6" />%. 
                                <span class="description"><?php esc_html_e('(Width) in percentage.', 'udesign'); ?></span>
                                <?php esc_html_e('This option is about the overall sidebar width and it will be applied to all pages. You may specify a range between 20% and 50%.', 'udesign'); ?>
                                <span class="description"><?php esc_html_e('(default: 33)', 'udesign'); ?></span>

                            </td>
                        </tr>
		    </tbody>
                  </table>
                </div>
<?php		display_save_changes_button(); ?>
<?php	}

	function font_settings_contentbox( $options ) {
                $enable_google_web_fonts = isset( $options['enable_google_web_fonts'] ) ? $options['enable_google_web_fonts']: '';
                $heading1_font_settings_enabled = isset( $options['heading1_font_settings_enabled'] ) ? $options['heading1_font_settings_enabled']: '';
                $heading2_font_settings_enabled = isset( $options['heading2_font_settings_enabled'] ) ? $options['heading2_font_settings_enabled']: '';
                $heading3_font_settings_enabled = isset( $options['heading3_font_settings_enabled'] ) ? $options['heading3_font_settings_enabled']: '';
                $heading4_font_settings_enabled = isset( $options['heading4_font_settings_enabled'] ) ? $options['heading4_font_settings_enabled']: '';
                $heading5_font_settings_enabled = isset( $options['heading5_font_settings_enabled'] ) ? $options['heading5_font_settings_enabled']: '';
                $heading6_font_settings_enabled = isset( $options['heading6_font_settings_enabled'] ) ? $options['heading6_font_settings_enabled']: ''; ?>
		<table class="form-table">
		    <tbody>
			<tr valign="top" style="background-color: #fcfcfc; border: 1px solid #dddddd;">
			    <th scope="row" style="padding-top:20px;padding-bottom:20px;"><?php esc_html_e('Google Fonts', 'udesign'); ?></th>
			    <td style="padding-top:20px;padding-bottom:20px;">
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Google Fonts', 'udesign'); ?></span></legend>
                                    <label for="enable_google_web_fonts" style="display:inline-block; float:left;">
                                        <input name="udesign_options[enable_google_web_fonts]" type="checkbox" id="enable_google_web_fonts" value="yes" <?php checked('yes', $enable_google_web_fonts); ?> />
                                        <?php esc_html_e('Enable Google Fonts', 'udesign'); ?>
                                    </label>
                                    <div class="submit" style="padding-left:20px; float:left; display:inline-block;">
                                        <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
                                        <input class="button-secondary left" type="submit" name="form-submit" value="<?php esc_attr_e('Update', 'udesign'); ?>" />
                                        <span class="spinner"></span>
                                    </div>
                                    <div class="clear"></div>
                                    <?php esc_html_e('You may preview all available Google fonts at', 'udesign'); ?> <a title="<?php esc_html_e('Google Fonts directory', 'udesign'); ?>" href="http://www.google.com/fonts/" target="_blank"><?php esc_html_e('Google Fonts directory', 'udesign'); ?></a>.
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('General (body) text', 'udesign'); ?></th>
			    <td>
                                <?php echo get_udesign_fonts_select_options( "general", "general", $options['general_font_family'], $enable_google_web_fonts, $options, "pixels", "12" ); ?>
                                <div class="clear" style="margin-bottom: 10px;"></div>
				<label for="general_font_line_height" style="float:left; margin-right:7px; line-height:2;"><?php esc_html_e('Line Height: ', 'udesign'); ?></label>
                                <input name="udesign_options[general_font_line_height]" type="text" id="general_font_line_height" value="<?php echo ($options['general_font_line_height']) ? esc_attr($options['general_font_line_height']) : '1.7'; ?>" size="5" maxlength="4" />
                                <?php esc_html_e('This option can be used to specify the line height for the general body text. Range from 0.2 to 5.0 (default: 1.7)', 'udesign'); ?>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Main Menu', 'udesign'); ?></th>
			    <td>
                                <?php echo get_udesign_fonts_select_options( "top_nav", "top-nav", $options['top_nav_font_family'], $enable_google_web_fonts, $options, "pixels", "14" ); ?>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Headings', 'udesign'); ?></th>
			    <td>
				<div style="float:left; margin-bottom:7px;"><?php esc_html_e("The following settings are applied to all headings (h1, h2, h3, h4, h5 and h6) as well as the tagline (slogan) text:", 'udesign'); ?></div>
                                <div class="clear"></div>
                                <?php echo get_udesign_fonts_select_options( "headings", "headings", $options['headings_font_family'], $enable_google_web_fonts, $options, "coefficient", "1.0" ); ?>
                                <div class="clear" style="margin-bottom: 10px;"></div>
				<label for="headings_font_line_height" style="float:left; margin-right:7px; line-height:2;"><?php esc_html_e('Line Height: ', 'udesign'); ?></label>
                                <input name="udesign_options[headings_font_line_height]" type="text" id="headings_font_line_height" value="<?php echo ($options['headings_font_line_height']) ? esc_attr($options['headings_font_line_height']) : '1.2'; ?>" size="5" maxlength="4" />
                                <?php esc_html_e('This option can be used to specify the line height for the headings. Range from 0.2 to 5.0 (default: 1.2)', 'udesign'); ?>
                               
                                <div class="clear" style="margin-top: 40px;"></div>
                                <h4 class="headings-section-switch-title"><?php esc_html_e('Individual Headings overwrites:', 'udesign'); ?></h4>
                                <div class="headings-section-switch-wrapper">
                                    <label for="heading1_font_settings_enabled" class="heading1-font-settings-enabled">
                                        <input name="udesign_options[heading1_font_settings_enabled]" type="checkbox" id="heading1_font_settings_enabled" value="yes" <?php checked('yes', $heading1_font_settings_enabled); ?> />
                                        <?php esc_html_e('Heading 1', 'udesign'); ?>
                                    </label> 
                                    <label for="heading2_font_settings_enabled" class="heading2-font-settings-enabled">
                                        <input name="udesign_options[heading2_font_settings_enabled]" type="checkbox" id="heading2_font_settings_enabled" value="yes" <?php checked('yes', $heading2_font_settings_enabled); ?> />
                                        <?php esc_html_e('Heading 2', 'udesign'); ?>
                                    </label>
                                    <label for="heading3_font_settings_enabled" class="heading3-font-settings-enabled">
                                        <input name="udesign_options[heading3_font_settings_enabled]" type="checkbox" id="heading3_font_settings_enabled" value="yes" <?php checked('yes', $heading3_font_settings_enabled); ?> />
                                        <?php esc_html_e('Heading 3', 'udesign'); ?>
                                    </label>
                                    <label for="heading4_font_settings_enabled" class="heading4-font-settings-enabled">
                                        <input name="udesign_options[heading4_font_settings_enabled]" type="checkbox" id="heading4_font_settings_enabled" value="yes" <?php checked('yes', $heading4_font_settings_enabled); ?> />
                                        <?php esc_html_e('Heading 4', 'udesign'); ?>
                                    </label>
                                    <label for="heading5_font_settings_enabled" class="heading5-font-settings-enabled">
                                        <input name="udesign_options[heading5_font_settings_enabled]" type="checkbox" id="heading5_font_settings_enabled" value="yes" <?php checked('yes', $heading5_font_settings_enabled); ?> />
                                        <?php esc_html_e('Heading 5', 'udesign'); ?>
                                    </label>
                                    <label for="heading6_font_settings_enabled" class="heading6-font-settings-enabled">
                                        <input name="udesign_options[heading6_font_settings_enabled]" type="checkbox" id="heading6_font_settings_enabled" value="yes" <?php checked('yes', $heading6_font_settings_enabled); ?> />
                                        <?php esc_html_e('Heading 6', 'udesign'); ?>
                                    </label>
                                </div>
			    </td>
			</tr>
                        <tr valign="top" id="heading1_font_settings_option"<?php if( !$heading1_font_settings_enabled ) echo ' class="hide"'; ?>>
			    <th scope="row"><?php esc_html_e('Heading 1', 'udesign'); ?></th>
			    <td>
                                <?php echo get_udesign_fonts_select_options( "heading1", "heading1", $options['heading1_font_family'], $enable_google_web_fonts, $options, "ems", "1.85" ); ?>
                                <div class="clear" style="margin-bottom: 10px;"></div>
				<label for="heading1_font_line_height" style="float:left; margin-right:7px; line-height:2;"><?php esc_html_e('Line Height: ', 'udesign'); ?></label>
                                <input name="udesign_options[heading1_font_line_height]" type="text" id="heading1_font_line_height" value="<?php echo ($options['heading1_font_line_height']) ? esc_attr($options['heading1_font_line_height']) : '1.2'; ?>" size="5" maxlength="4" />
                                &nbsp;&nbsp;<span class="description"><?php esc_html_e('(min: 0.2, max: 5.0, default: 1.2)', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top" id="heading2_font_settings_option"<?php if( !$heading2_font_settings_enabled ) echo ' class="hide"'; ?>>
			    <th scope="row"><?php esc_html_e('Heading 2', 'udesign'); ?></th>
			    <td>
                                <?php echo get_udesign_fonts_select_options( "heading2", "heading2", $options['heading2_font_family'], $enable_google_web_fonts, $options, "ems", "1.65" ); ?>
                                <div class="clear" style="margin-bottom: 10px;"></div>
				<label for="heading2_font_line_height" style="float:left; margin-right:7px; line-height:2;"><?php esc_html_e('Line Height: ', 'udesign'); ?></label>
                                <input name="udesign_options[heading2_font_line_height]" type="text" id="heading2_font_line_height" value="<?php echo ($options['heading2_font_line_height']) ? esc_attr($options['heading2_font_line_height']) : '1.2'; ?>" size="5" maxlength="4" />
                                &nbsp;&nbsp;<span class="description"><?php esc_html_e('(min: 0.2, max: 5.0, default: 1.2)', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top" id="heading3_font_settings_option"<?php if( !$heading3_font_settings_enabled ) echo ' class="hide"'; ?>>
			    <th scope="row"><?php esc_html_e('Heading 3', 'udesign'); ?></th>
			    <td>
                                <?php echo get_udesign_fonts_select_options( "heading3", "heading3", $options['heading3_font_family'], $enable_google_web_fonts, $options, "ems", "1.50" ); ?>
                                <div class="clear" style="margin-bottom: 10px;"></div>
				<label for="heading3_font_line_height" style="float:left; margin-right:7px; line-height:2;"><?php esc_html_e('Line Height: ', 'udesign'); ?></label>
                                <input name="udesign_options[heading3_font_line_height]" type="text" id="heading3_font_line_height" value="<?php echo ($options['heading3_font_line_height']) ? esc_attr($options['heading3_font_line_height']) : '1.2'; ?>" size="5" maxlength="4" />
                                &nbsp;&nbsp;<span class="description"><?php esc_html_e('(min: 0.2, max: 5.0, default: 1.2)', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top" id="heading4_font_settings_option"<?php if( !$heading4_font_settings_enabled ) echo ' class="hide"'; ?>>
			    <th scope="row"><?php esc_html_e('Heading 4', 'udesign'); ?></th>
			    <td>
                                <?php echo get_udesign_fonts_select_options( "heading4", "heading4", $options['heading4_font_family'], $enable_google_web_fonts, $options, "ems", "1.35" ); ?>
                                <div class="clear" style="margin-bottom: 10px;"></div>
				<label for="heading4_font_line_height" style="float:left; margin-right:7px; line-height:2;"><?php esc_html_e('Line Height: ', 'udesign'); ?></label>
                                <input name="udesign_options[heading4_font_line_height]" type="text" id="heading4_font_line_height" value="<?php echo ($options['heading4_font_line_height']) ? esc_attr($options['heading4_font_line_height']) : '1.2'; ?>" size="5" maxlength="4" />
                                &nbsp;&nbsp;<span class="description"><?php esc_html_e('(min: 0.2, max: 5.0, default: 1.2)', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top" id="heading5_font_settings_option"<?php if( !$heading5_font_settings_enabled ) echo ' class="hide"'; ?>>
			    <th scope="row"><?php esc_html_e('Heading 5', 'udesign'); ?></th>
			    <td>
                                <?php echo get_udesign_fonts_select_options( "heading5", "heading5", $options['heading5_font_family'], $enable_google_web_fonts, $options, "ems", "1.25" ); ?>
                                <div class="clear" style="margin-bottom: 10px;"></div>
				<label for="heading5_font_line_height" style="float:left; margin-right:7px; line-height:2;"><?php esc_html_e('Line Height: ', 'udesign'); ?></label>
                                <input name="udesign_options[heading5_font_line_height]" type="text" id="heading5_font_line_height" value="<?php echo ($options['heading5_font_line_height']) ? esc_attr($options['heading5_font_line_height']) : '1.2'; ?>" size="5" maxlength="4" />
                                &nbsp;&nbsp;<span class="description"><?php esc_html_e('(min: 0.2, max: 5.0, default: 1.2)', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top" id="heading6_font_settings_option"<?php if( !$heading6_font_settings_enabled ) echo ' class="hide"'; ?>>
			    <th scope="row"><?php esc_html_e('Heading 6', 'udesign'); ?></th>
			    <td>
                                <?php echo get_udesign_fonts_select_options( "heading6", "heading6", $options['heading6_font_family'], $enable_google_web_fonts, $options, "ems", "1.10" ); ?>
                                <div class="clear" style="margin-bottom: 10px;"></div>
				<label for="heading6_font_line_height" style="float:left; margin-right:7px; line-height:2;"><?php esc_html_e('Line Height: ', 'udesign'); ?></label>
                                <input name="udesign_options[heading6_font_line_height]" type="text" id="heading6_font_line_height" value="<?php echo ($options['heading6_font_line_height']) ? esc_attr($options['heading6_font_line_height']) : '1.2'; ?>" size="5" maxlength="4" />
                                &nbsp;&nbsp;<span class="description"><?php esc_html_e('(min: 0.2, max: 5.0, default: 1.2)', 'udesign'); ?></span>
			    </td>
			</tr>
		    </tbody>
		</table>
<?php		display_save_changes_button(); ?>
<?php	}

        function custom_colors_options_contentbox( $options ) { ?>
    		<table class="form-table" style="background-color:#FCFCFC; border:1px solid #DDDDDD;">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Custom Colors Switch', 'udesign'); ?></th>
			    <td>
				<span class="description"><?php esc_html_e("If enabled this option will overwrite the default CSS styles.", 'udesign'); ?></span><br />
				<?php esc_html_e('Custom colors option:', 'udesign'); ?><br />
				<label><input type="radio" name="udesign_options[custom_colors_switch]" id="custom_colors_switch_enable" value="enable" <?php checked('enable', $options['custom_colors_switch']); ?> /> <?php esc_html_e('Enable', 'udesign'); ?></label>&nbsp;&nbsp;
				<label><input type="radio" name="udesign_options[custom_colors_switch]" id="custom_colors_switch_disable" value="disable" <?php checked('disable', $options['custom_colors_switch']); ?> /> <?php esc_html_e('Disable', 'udesign'); ?></label>
				<br />
				<div class="submit" style="padding:10px 0 0 80px; float:left; clear:both;">
				    <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
				    <input class="button-secondary left" type="submit" name="form-submit" value="<?php esc_attr_e('Update', 'udesign'); ?>" />
                                    <span class="spinner"></span>
				</div>
<?php				if ( $options['custom_colors_switch'] == 'enable' ) : ?>
				    <div style="padding-top:10px; clear:both;"><?php esc_html_e('Continue with the section below to customize the colors...', 'udesign'); ?></div>
<?php				else : ?>
				    <input style="display:none;" name="udesign_options[one_continuous_bg_img_fixed]" type="checkbox" id="one_continuous_bg_img_fixed" value="yes" <?php checked('yes', $options['one_continuous_bg_img_fixed']); ?> />
<?php				endif; ?>
			    </td>
			</tr>
		    </tbody>
		</table>
                
<?php		if ( $options['custom_colors_switch'] == 'enable' ) : ?>
                    <h4 class="u-design-settings-page-headers"><?php esc_html_e('General Text and Link Colors', 'udesign'); ?></h4>
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Body Text Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="bodyTextColor">
					<div style="background-color: #<?php echo ($options['body_text_color']) ? esc_attr($options['body_text_color']) : '333333'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[body_text_color]" id="body_text_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['body_text_color']) ? esc_attr($options['body_text_color']) : '333333'; ?>" />
				    <?php esc_html_e("Main body text color affecting the entire site.", 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Link Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="mainLinkColor">
					<div style="background-color: #<?php echo ($options['main_link_color']) ? esc_attr($options['main_link_color']) : 'FE5E08'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[main_link_color]" id="main_link_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['main_link_color']) ? esc_attr($options['main_link_color']) : 'FE5E08'; ?>" />
				    <?php esc_html_e("Main link color affecting the entire site.", 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Link Hover Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="mainLinkColorHover">
					<div style="background-color: #<?php echo ($options['main_link_color_hover']) ? esc_attr($options['main_link_color_hover']) : '333333'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[main_link_color_hover]" id="main_link_color_hover" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['main_link_color_hover']) ? esc_attr($options['main_link_color_hover']) : '333333'; ?>" />
				    <?php esc_html_e("This is the link hover color.", 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Headings Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="mainHeadingsColor">
					<div style="background-color: #<?php echo ($options['main_headings_color']) ? esc_attr($options['main_headings_color']) : '333333'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[main_headings_color]" id="main_headings_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['main_headings_color']) ? esc_attr($options['main_headings_color']) : '333333'; ?>" />
				    <?php esc_html_e("This is the color for general H1, H2, H3, H4 ,H5 ,H6 Headings where applicable.", 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
                    <h4 id="top-area-background" class="u-design-settings-page-headers"><?php esc_html_e('Top Section Colors', 'udesign'); ?></h4>
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Top Area Background', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="topBGcolorSelector">
					<div style="background-color: #<?php echo ($options['top_bg_color']) ? esc_attr($options['top_bg_color']) : 'FBFBFB'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[top_bg_color]" id="top_bg_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['top_bg_color']) ? esc_attr($options['top_bg_color']) : 'FBFBFB'; ?>" />
				    <?php esc_html_e("Site's top section background color. This is the section with the logo, slogan, phone number and search box, immediately above the menu.", 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Top Area Text Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="topTextcolorSelector">
					<div style="background-color: #<?php echo ($options['top_text_color']) ? esc_attr($options['top_text_color']) : '999999'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[top_text_color]" id="top_text_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['top_text_color']) ? esc_attr($options['top_text_color']) : '999999'; ?>" />
				    <?php esc_html_e("This color affects the slogan, phone number and search text.", 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
                    
                    <div class="clear"></div>
                    <div class="submit" style="padding:10px 0 0 80px; float:right; clear:both;">
                        <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
                        <input class="button-primary right" type="submit" name="form-submit" value="<?php esc_attr_e('Save Changes', 'udesign') ?>" />
                        <span class="spinner"></span>
                    </div>
                    <div class="clear"></div>
                            
                    <h4 class="u-design-settings-page-headers"><?php esc_html_e('Main Menu Colors', 'udesign'); ?></h4>
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Background Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="topNavBackgroundColor">
					<div style="background-color: #<?php echo ($options['top_nav_background_color']) ? esc_attr($options['top_nav_background_color']) : 'FBFBFB'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[top_nav_background_color]" id="top_nav_background_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['top_nav_background_color']) ? esc_attr($options['top_nav_background_color']) : 'FBFBFB'; ?>" />
				    <?php esc_html_e('This is the background color of the main menu.', 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
                    <table class="form-table" style="margin-top: 0;">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Background Opacity', 'udesign'); ?></th>
				<td>
                                    <input name="udesign_options[top_nav_background_opacity]" type="text" id="top_nav_background_opacity" value="<?php echo ( isset( $options['top_nav_background_opacity'] ) ) ? esc_attr( $options['top_nav_background_opacity'] ) : '0'; ?>" size="5" maxlength="4" />
                                    <?php esc_html_e('This option can be used to specify the opacity of the background. From 0 (fully transparent) to 1.0 (fully opaque).', 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
                    <table class="form-table" style="margin-top: 0;">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Link Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="topNavLinkColor">
					<div style="background-color: #<?php echo ($options['top_nav_link_color']) ? esc_attr($options['top_nav_link_color']) : '999999'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[top_nav_link_color]" id="top_nav_link_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['top_nav_link_color']) ? esc_attr($options['top_nav_link_color']) : '999999'; ?>" />
				    <?php esc_html_e('This is the color of the main menu links.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Active Link Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="topNavActiveLinkColor">
					<div style="background-color: #<?php echo ($options['top_nav_active_link_color']) ? esc_attr($options['top_nav_active_link_color']) : 'F95A09'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[top_nav_active_link_color]" id="top_nav_active_link_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['top_nav_active_link_color']) ? esc_attr($options['top_nav_active_link_color']) : 'F95A09'; ?>" />
				    <?php esc_html_e('This is the color of the main menu active/selected link.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Hover Link Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="topNavHoverLinkColor">
					<div style="background-color: #<?php echo ($options['top_nav_hover_link_color']) ? esc_attr($options['top_nav_hover_link_color']) : '777777'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[top_nav_hover_link_color]" id="top_nav_hover_link_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['top_nav_hover_link_color']) ? esc_attr($options['top_nav_hover_link_color']) : '777777'; ?>" />
				    <?php esc_html_e('This is the color of the main menu hover link.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Dropdown Menu Link Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="dropdownNavLinkColor">
					<div style="background-color: #<?php echo ($options['dropdown_nav_link_color']) ? esc_attr($options['dropdown_nav_link_color']) : '777777'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[dropdown_nav_link_color]" id="dropdown_nav_link_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['dropdown_nav_link_color']) ? esc_attr($options['dropdown_nav_link_color']) : '777777'; ?>" />
				    <?php esc_html_e('This is the color of the main menu dropdown (submenu) links.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Dropdown Menu Hover Link Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="dropdownNavHoverLinkColor">
					<div style="background-color: #<?php echo ($options['dropdown_nav_hover_link_color']) ? esc_attr($options['dropdown_nav_hover_link_color']) : '222222'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[dropdown_nav_hover_link_color]" id="dropdown_nav_hover_link_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['dropdown_nav_hover_link_color']) ? esc_attr($options['dropdown_nav_hover_link_color']) : '222222'; ?>" />
				    <?php esc_html_e('This is the color of the main menu dropdown (submenu) hover link.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Dropdown Menu Background Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="dropdownNavBackgroundColor">
					<div style="background-color: #<?php echo ($options['dropdown_nav_background_color']) ? esc_attr($options['dropdown_nav_background_color']) : 'EEEEEE'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[dropdown_nav_background_color]" id="dropdown_nav_background_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['dropdown_nav_background_color']) ? esc_attr($options['dropdown_nav_background_color']) : 'EEEEEE'; ?>" />
				    <?php esc_html_e('This is the color of the main menu dropdown (submenu) background.', 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
                    <table class="form-table" style="margin-top: 0;">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Dropdown Menu Background Opacity', 'udesign'); ?></th>
				<td>
                                    <input name="udesign_options[dropdown_nav_background_opacity]" type="text" id="dropdown_nav_background_opacity" value="<?php echo ( isset( $options['dropdown_nav_background_opacity'] ) ) ? esc_attr( $options['dropdown_nav_background_opacity'] ) : '0.95'; ?>" size="5" maxlength="4" />
                                    <?php esc_html_e('This option can be used to specify the opacity of the background. From 0 (fully transparent) to 1.0 (fully opaque).', 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
                    
                    <h4 id="sec-nav-section-colors" class="u-design-settings-page-headers"><?php esc_html_e('Secondary Menu Colors', 'udesign'); ?></h4>
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Background Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="secMenuBGColorSelector">
					<div style="background-color: #<?php echo ($options['sec_menu_bg_color']) ? esc_attr($options['sec_menu_bg_color']) : '212121'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[sec_menu_bg_color]" id="sec_menu_bg_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['sec_menu_bg_color']) ? esc_attr($options['sec_menu_bg_color']) : '212121'; ?>" />
				    <?php esc_html_e("This is the secondary menu's background color.", 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
                    <table class="form-table" style="margin-top: 0;">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Background Opacity', 'udesign'); ?></th>
				<td>
                                    <input name="udesign_options[sec_menu_bg_opacity]" type="text" id="sec_menu_bg_opacity" value="<?php echo ( isset( $options['sec_menu_bg_opacity'] ) ) ? esc_attr( $options['sec_menu_bg_opacity'] ) : '0.95'; ?>" size="5" maxlength="4" />
                                    <?php esc_html_e('This option can be used to specify the opacity of the background. From 0 (fully transparent) to 1.0 (fully opaque).', 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
                    <table class="form-table" style="margin-top: 0;">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Text Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="secMenuTextColorSelector">
					<div style="background-color: #<?php echo ($options['sec_menu_text_color']) ? esc_attr($options['sec_menu_text_color']) : 'EBEBEB'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[sec_menu_text_color]" id="sec_menu_text_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['sec_menu_text_color']) ? esc_attr($options['sec_menu_text_color']) : 'EBEBEB'; ?>" />
				    <?php esc_html_e("This is the general text color.", 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Link Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="secMenuLinkColorSelector">
					<div style="background-color: #<?php echo ($options['sec_menu_link_color']) ? esc_attr($options['sec_menu_link_color']) : 'A3A3A3'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[sec_menu_link_color]" id="sec_menu_link_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['sec_menu_link_color']) ? esc_attr($options['sec_menu_link_color']) : 'A3A3A3'; ?>" />
				    <?php esc_html_e("This is the menu's link color.", 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Link Hover Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="secMenuLinkHoverColorSelector">
					<div style="background-color: #<?php echo ($options['sec_menu_link_hover_color']) ? esc_attr($options['sec_menu_link_hover_color']) : 'FF8400'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[sec_menu_link_hover_color]" id="sec_menu_link_hover_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['sec_menu_link_hover_color']) ? esc_attr($options['sec_menu_link_hover_color']) : 'FF8400'; ?>" />
				    <?php esc_html_e("This is the menu's link hover color.", 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
                    
                    <div class="clear"></div>
                    <div class="submit" style="padding:10px 0 0 80px; float:right; clear:both;">
                        <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
                        <input class="button-primary right" type="submit" name="form-submit" value="<?php esc_attr_e('Save Changes', 'udesign') ?>" />
                        <span class="spinner"></span>
                    </div>
                    <div class="clear"></div>
                    
                    <h4 class="u-design-settings-page-headers"><?php esc_html_e('Midsection Colors', 'udesign'); ?></h4>
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Page Title Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="pageTitleColor">
					<div style="background-color: #<?php echo ($options['page_title_color']) ? esc_attr($options['page_title_color']) : '333333'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[page_title_color]" id="page_title_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['page_title_color']) ? esc_attr($options['page_title_color']) : '333333'; ?>" />
				    <?php esc_html_e('This is the color for the title of pages/posts/archives, etc. located in the area underneath the menu.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Page Title Background Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="pageTitleBGcolorSelector">
					<div style="background-color: #<?php echo ($options['page_title_bg_color']) ? esc_attr($options['page_title_bg_color']) : 'FFFFFF'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[page_title_bg_color]" id="page_title_bg_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['page_title_bg_color']) ? esc_attr($options['page_title_bg_color']) : 'FFFFFF'; ?>" />
				    <?php esc_html_e('This is the background color behind the page titles.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Header/Slider Background', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="headerBGcolorSelector">
					<div style="background-color: #<?php echo ($options['header_bg_color']) ? esc_attr($options['header_bg_color']) : 'FFFFFF'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[header_bg_color]" id="header_bg_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['header_bg_color']) ? esc_attr($options['header_bg_color']) : 'FFFFFF'; ?>" />
				    <?php esc_html_e('This is the background color behind the home page sliders.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Main Content Area Background', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="mainContentBG">
					<div style="background-color: #<?php echo ($options['main_content_bg']) ? esc_attr($options['main_content_bg']) : 'FFFFFF'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[main_content_bg]" id="main_content_bg" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['main_content_bg']) ? esc_attr($options['main_content_bg']) : 'FFFFFF'; ?>" />
				    <?php esc_html_e('This is the color of the main content wrapper background.', 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
                    <h4 class="u-design-settings-page-headers"><?php esc_html_e('Home Page Before Content Widget Area Colors', 'udesign'); ?></h4>
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Title Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="widgetTitleColor">
					<div style="background-color: #<?php echo ($options['widget_title_color']) ? esc_attr($options['widget_title_color']) : '333333'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[widget_title_color]" id="widget_title_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['widget_title_color']) ? esc_attr($options['widget_title_color']) : '333333'; ?>" />
				    <?php esc_html_e('This is the color for the title of widgets used in this Widget Area, usually an "H3" Headings.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Text Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="widgetTextColor">
					<div style="background-color: #<?php echo ($options['widget_text_color']) ? esc_attr($options['widget_text_color']) : '333333'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[widget_text_color]" id="widget_text_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['widget_text_color']) ? esc_attr($options['widget_text_color']) : '333333'; ?>" />
				    <?php esc_html_e('This is the default text color applied to this Widget Area.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Background Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="widgetBGColor">
					<div style="background-color: #<?php echo ($options['widget_bg_color']) ? esc_attr($options['widget_bg_color']) : 'F8F8F8'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[widget_bg_color]" id="widget_bg_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['widget_bg_color']) ? esc_attr($options['widget_bg_color']) : 'F8F8F8'; ?>" />
				    <?php esc_html_e('This is the background color.', 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
                    
                    <div class="clear"></div>
                    <div class="submit" style="padding:10px 0 0 80px; float:right; clear:both;">
                        <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
                        <input class="button-primary right" type="submit" name="form-submit" value="<?php esc_attr_e('Save Changes', 'udesign') ?>" />
                        <span class="spinner"></span>
                    </div>
                    <div class="clear"></div>
                    
                    <h4 class="u-design-settings-page-headers"><?php esc_html_e('Bottom Area Colors', 'udesign'); ?></h4>
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Bottom Background Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="bottomBGColor">
					<div style="background-color: #<?php echo ($options['bottom_bg_color']) ? esc_attr($options['bottom_bg_color']) : 'F5F5F5'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[bottom_bg_color]" id="bottom_bg_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['bottom_bg_color']) ? esc_attr($options['bottom_bg_color']) : 'F5F5F5'; ?>" />
				    <?php esc_html_e('This is the background color for the bottom area.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Bottom Titles Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="bottomTitleColor">
					<div style="background-color: #<?php echo ($options['bottom_title_color']) ? esc_attr($options['bottom_title_color']) : 'FE5E08'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[bottom_title_color]" id="bottom_title_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['bottom_title_color']) ? esc_attr($options['bottom_title_color']) : 'FE5E08'; ?>" />
				    <?php esc_html_e('This is the color applied to the bottom area widget titles.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Bottom Text Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="bottomTextColor">
					<div style="background-color: #<?php echo ($options['bottom_text_color']) ? esc_attr($options['bottom_text_color']) : '333333'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[bottom_text_color]" id="bottom_text_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['bottom_text_color']) ? esc_attr($options['bottom_text_color']) : '333333'; ?>" />
				    <?php esc_html_e('This is the default text color applied to the bottom area.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Bottom Link Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="bottomLinkColor">
					<div style="background-color: #<?php echo ($options['bottom_link_color']) ? esc_attr($options['bottom_link_color']) : '3D6E97'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[bottom_link_color]" id="bottom_link_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['bottom_link_color']) ? esc_attr($options['bottom_link_color']) : '3D6E97'; ?>" />
				    <?php esc_html_e('This is the bottom area link color.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Bottom Link Hover Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="bottomHoverLinkColor">
					<div style="background-color: #<?php echo ($options['bottom_hover_link_color']) ? esc_attr($options['bottom_hover_link_color']) : '000000'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[bottom_hover_link_color]" id="bottom_hover_link_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['bottom_hover_link_color']) ? esc_attr($options['bottom_hover_link_color']) : '000000'; ?>" />
				    <?php esc_html_e('This is the bottom area link hover color.', 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
                    <h4 class="u-design-settings-page-headers"><?php esc_html_e('Footer Area Colors', 'udesign'); ?></h4>
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Footer Background Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="footerBGColor">
					<div style="background-color: #<?php echo ($options['footer_bg_color']) ? esc_attr($options['footer_bg_color']) : 'EAEAEA'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[footer_bg_color]" id="footer_bg_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['footer_bg_color']) ? esc_attr($options['footer_bg_color']) : 'EAEAEA'; ?>" />
				    <?php esc_html_e('This is the footer background color.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Footer Text Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="footerTextColor">
					<div style="background-color: #<?php echo ($options['footer_text_color']) ? esc_attr($options['footer_text_color']) : '797979'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[footer_text_color]" id="footer_text_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['footer_text_color']) ? esc_attr($options['footer_text_color']) : '797979'; ?>" />
				    <?php esc_html_e('This is the footer general text color.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Footer Link Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="footerLinkColor">
					<div style="background-color: #<?php echo ($options['footer_link_color']) ? esc_attr($options['footer_link_color']) : '3D6E97'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[footer_link_color]" id="footer_link_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['footer_link_color']) ? esc_attr($options['footer_link_color']) : '3D6E97'; ?>" />
				    <?php esc_html_e('This is the footer link color.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Footer Link Hover Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="footerHoverLinkColor">
					<div style="background-color: #<?php echo ($options['footer_hover_link_color']) ? esc_attr($options['footer_hover_link_color']) : '000000'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[footer_hover_link_color]" id="footer_hover_link_color" type="text" maxlength="6" size="7" style="margin:2px 10px 0 0" value="<?php echo ($options['footer_hover_link_color']) ? esc_attr($options['footer_hover_link_color']) : '000000'; ?>" />
				    <?php esc_html_e('This is the footer link hover color.', 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
<?php		    display_save_changes_button(); ?>

                   
		    <div style="margin:10px;">
                        <h4 class="u-design-settings-page-headers"><?php esc_html_e('Background Images', 'udesign'); ?></h4>
                        <p style="margin: 10px 10px 15px;"><span class="description"><?php esc_html_e("Tip: To upload an image click on 'Upload Image' button below. Once the image is uploaded it will give you various options. Click on 'Insert into Post' button. Once you click on 'Insert into Post', link with the uploaded image will be inserted into the corresponding text field below. The background image is placed according to the background-position property. If 'No Repeat' is specified (see below), the image is placed at the element's top center position.", 'udesign'); ?></span></p>
                        <table class="form-table" style="background-color:#FCFCFC; border:1px solid #EBEBEB;">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e('Top Area Background Image', 'udesign'); ?></th>
                                    <td>
                                        <div style="padding:0; float:left;">
                                            <label for="top_bg_img"><?php esc_html_e('Enter a URL or upload an image:', 'udesign'); ?></label><br />
                                            <input name="udesign_options[top_bg_img]" type="text" id="top_bg_img" value="<?php if( $options['top_bg_img'] ){ echo esc_url($options['top_bg_img']); } ?>" size="65" />
                                            <input id="upload_top_bg_img_button" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary" />
                                        </div>
                                        <div class="clear"></div>
                                        <div style="margin:10px 10px 2px 0; float:left;">
                                            <?php esc_html_e('Background  Properties:', 'udesign'); ?>
                                            <select name="udesign_options[top_bg_img_repeat]" id="top_bg_img_repeat">
                                                <option value="no-repeat"<?php echo ($options['top_bg_img_repeat'] == 'no-repeat') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('No Repeat', 'udesign'); ?></option>
                                                <option value="repeat-x"<?php echo ($options['top_bg_img_repeat'] == 'repeat-x') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Horizontally', 'udesign'); ?></option>
                                                <option value="repeat-y"<?php echo ($options['top_bg_img_repeat'] == 'repeat-y') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Vertically', 'udesign'); ?></option>
                                                <option value="repeat"<?php echo ($options['top_bg_img_repeat'] == 'repeat') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('Repeat both Vertically and Horizontally', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Horizontal:', 'udesign'); ?>
                                            <select name="udesign_options[top_bg_img_position_horizontal]" id="top_bg_img_position_horizontal">
                                                <option value="center"<?php echo ($options['top_bg_img_position_horizontal'] == 'center') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="left"<?php echo ($options['top_bg_img_position_horizontal'] == 'left') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('left', 'udesign'); ?></option>
                                                <option value="right"<?php echo ($options['top_bg_img_position_horizontal'] == 'right') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('right', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Vertical:', 'udesign'); ?>
                                            <select name="udesign_options[top_bg_img_position_vertical]" id="top_bg_img_position_vertical">
                                                <option value="top"<?php echo ($options['top_bg_img_position_vertical'] == 'top') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('top', 'udesign'); ?></option>
                                                <option value="center"<?php echo ($options['top_bg_img_position_vertical'] == 'center') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="bottom"<?php echo ($options['top_bg_img_position_vertical'] == 'bottom') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('bottom', 'udesign'); ?></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="form-table" style="background-color:#FCFCFC; border:1px solid #EBEBEB;">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e('Home Page Header/Slider Background Image', 'udesign'); ?></th>
                                    <td>
                                        <div style="padding:0; float:left;">
                                            <label for="header_bg_img"><?php esc_html_e('Enter a URL or upload an image:', 'udesign'); ?></label><br />
                                            <input name="udesign_options[header_bg_img]" type="text" id="header_bg_img" value="<?php if( $options['header_bg_img'] ){ echo esc_url($options['header_bg_img']); } ?>" size="65" />
                                            <input id="upload_header_bg_img_button" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary" />
                                        </div>
                                        <div class="clear"></div>
                                        <div style="margin:10px 10px 2px 0; float:left;">
                                            <?php esc_html_e('Background  Properties:', 'udesign'); ?>
                                            <select name="udesign_options[header_bg_img_repeat]" id="header_bg_img_repeat">
                                                <option value="no-repeat"<?php echo ($options['header_bg_img_repeat'] == 'no-repeat') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('No Repeat', 'udesign'); ?></option>
                                                <option value="repeat-x"<?php echo ($options['header_bg_img_repeat'] == 'repeat-x') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Horizontally', 'udesign'); ?></option>
                                                <option value="repeat-y"<?php echo ($options['header_bg_img_repeat'] == 'repeat-y') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Vertically', 'udesign'); ?></option>
                                                <option value="repeat"<?php echo ($options['header_bg_img_repeat'] == 'repeat') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('Repeat both Vertically and Horizontally', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Horizontal:', 'udesign'); ?>
                                            <select name="udesign_options[header_bg_img_position_horizontal]" id="header_bg_img_position_horizontal">
                                                <option value="center"<?php echo ($options['header_bg_img_position_horizontal'] == 'center') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="left"<?php echo ($options['header_bg_img_position_horizontal'] == 'left') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('left', 'udesign'); ?></option>
                                                <option value="right"<?php echo ($options['header_bg_img_position_horizontal'] == 'right') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('right', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Vertical:', 'udesign'); ?>
                                            <select name="udesign_options[header_bg_img_position_vertical]" id="header_bg_img_position_vertical">
                                                <option value="top"<?php echo ($options['header_bg_img_position_vertical'] == 'top') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('top', 'udesign'); ?></option>
                                                <option value="center"<?php echo ($options['header_bg_img_position_vertical'] == 'center') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="bottom"<?php echo ($options['header_bg_img_position_vertical'] == 'bottom') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('bottom', 'udesign'); ?></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="form-table" style="background-color:#FCFCFC; border:1px solid #EBEBEB;">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e('Home Page Before Content Background Image', 'udesign'); ?></th>
                                    <td>
                                        <div style="padding:0; float:left;">
                                            <label for="home_page_before_content_bg_img"><?php esc_html_e('Enter a URL or upload an image:', 'udesign'); ?></label><br />
                                            <input name="udesign_options[home_page_before_content_bg_img]" type="text" id="home_page_before_content_bg_img" value="<?php if( $options['home_page_before_content_bg_img'] ){ echo esc_url($options['home_page_before_content_bg_img']); } ?>" size="65" />
                                            <input id="upload_home_page_before_content_bg_img_button" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary" />
                                        </div>
                                        <div class="clear"></div>
                                        <div style="margin:10px 10px 2px 0; float:left;">
                                            <?php esc_html_e('Background  Properties:', 'udesign'); ?>
                                            <select name="udesign_options[home_page_before_content_bg_img_repeat]" id="home_page_before_content_bg_img_repeat">
                                                <option value="no-repeat"<?php echo ($options['home_page_before_content_bg_img_repeat'] == 'no-repeat') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('No Repeat', 'udesign'); ?></option>
                                                <option value="repeat-x"<?php echo ($options['home_page_before_content_bg_img_repeat'] == 'repeat-x') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Horizontally', 'udesign'); ?></option>
                                                <option value="repeat-y"<?php echo ($options['home_page_before_content_bg_img_repeat'] == 'repeat-y') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Vertically', 'udesign'); ?></option>
                                                <option value="repeat"<?php echo ($options['home_page_before_content_bg_img_repeat'] == 'repeat') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('Repeat both Vertically and Horizontally', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Horizontal:', 'udesign'); ?>
                                            <select name="udesign_options[home_page_before_content_bg_img_position_horizontal]" id="home_page_before_content_bg_img_position_horizontal">
                                                <option value="center"<?php echo ($options['home_page_before_content_bg_img_position_horizontal'] == 'center') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="left"<?php echo ($options['home_page_before_content_bg_img_position_horizontal'] == 'left') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('left', 'udesign'); ?></option>
                                                <option value="right"<?php echo ($options['home_page_before_content_bg_img_position_horizontal'] == 'right') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('right', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Vertical:', 'udesign'); ?>
                                            <select name="udesign_options[home_page_before_content_bg_img_position_vertical]" id="home_page_before_content_bg_img_position_vertical">
                                                <option value="top"<?php echo ($options['home_page_before_content_bg_img_position_vertical'] == 'top') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('top', 'udesign'); ?></option>
                                                <option value="center"<?php echo ($options['home_page_before_content_bg_img_position_vertical'] == 'center') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="bottom"<?php echo ($options['home_page_before_content_bg_img_position_vertical'] == 'bottom') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('bottom', 'udesign'); ?></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="form-table" style="background-color:#FCFCFC; border:1px solid #EBEBEB;">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e('Page Title Background Image', 'udesign'); ?></th>
                                    <td>
                                        <div style="padding:0; float:left;">
                                            <label for="page_title_bg_img"><?php esc_html_e('Enter a URL or upload an image:', 'udesign'); ?></label><br />
                                            <input name="udesign_options[page_title_bg_img]" type="text" id="page_title_bg_img" value="<?php if( $options['page_title_bg_img'] ){ echo esc_url($options['page_title_bg_img']); } ?>" size="65" />
                                            <input id="upload_page_title_bg_img_button" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary" />
                                        </div>
                                        <div class="clear"></div>
                                        <div style="margin:10px 10px 2px 0; float:left;">
                                            <?php esc_html_e('Background  Properties:', 'udesign'); ?>
                                            <select name="udesign_options[page_title_bg_img_repeat]" id="page_title_bg_img_repeat">
                                                <option value="no-repeat"<?php echo ($options['page_title_bg_img_repeat'] == 'no-repeat') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('No Repeat', 'udesign'); ?></option>
                                                <option value="repeat-x"<?php echo ($options['page_title_bg_img_repeat'] == 'repeat-x') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Horizontally', 'udesign'); ?></option>
                                                <option value="repeat-y"<?php echo ($options['page_title_bg_img_repeat'] == 'repeat-y') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Vertically', 'udesign'); ?></option>
                                                <option value="repeat"<?php echo ($options['page_title_bg_img_repeat'] == 'repeat') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('Repeat both Vertically and Horizontally', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Horizontal:', 'udesign'); ?>
                                            <select name="udesign_options[page_title_bg_img_position_horizontal]" id="page_title_bg_img_position_horizontal">
                                                <option value="center"<?php echo ($options['page_title_bg_img_position_horizontal'] == 'center') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="left"<?php echo ($options['page_title_bg_img_position_horizontal'] == 'left') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('left', 'udesign'); ?></option>
                                                <option value="right"<?php echo ($options['page_title_bg_img_position_horizontal'] == 'right') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('right', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Vertical:', 'udesign'); ?>
                                            <select name="udesign_options[page_title_bg_img_position_vertical]" id="page_title_bg_img_position_vertical">
                                                <option value="top"<?php echo ($options['page_title_bg_img_position_vertical'] == 'top') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('top', 'udesign'); ?></option>
                                                <option value="center"<?php echo ($options['page_title_bg_img_position_vertical'] == 'center') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="bottom"<?php echo ($options['page_title_bg_img_position_vertical'] == 'bottom') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('bottom', 'udesign'); ?></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="form-table" style="background-color:#FCFCFC; border:1px solid #EBEBEB;">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e('Main Content Background Image', 'udesign'); ?></th>
                                    <td>
                                        <div style="padding:0; float:left;">
                                            <label for="main_content_bg_img"><?php esc_html_e('Enter a URL or upload an image:', 'udesign'); ?></label><br />
                                            <input name="udesign_options[main_content_bg_img]" type="text" id="main_content_bg_img" value="<?php if( $options['main_content_bg_img'] ){ echo esc_url($options['main_content_bg_img']); } ?>" size="65" />
                                            <input id="upload_main_bg_img_button" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary" />
                                        </div>
                                        <div class="clear"></div>
                                        <div style="margin:10px 10px 2px 0; float:left;">
                                            <?php esc_html_e('Background Properties:', 'udesign'); ?>
                                            <select name="udesign_options[main_content_bg_img_repeat]" id="main_content_bg_img_repeat">
                                                <option value="no-repeat"<?php echo ($options['main_content_bg_img_repeat'] == 'no-repeat') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('No Repeat', 'udesign'); ?></option>
                                                <option value="repeat-x"<?php echo ($options['main_content_bg_img_repeat'] == 'repeat-x') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Horizontally', 'udesign'); ?></option>
                                                <option value="repeat-y"<?php echo ($options['main_content_bg_img_repeat'] == 'repeat-y') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Vertically', 'udesign'); ?></option>
                                                <option value="repeat"<?php echo ($options['main_content_bg_img_repeat'] == 'repeat') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('Repeat both Vertically and Horizontally', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Horizontal:', 'udesign'); ?>
                                            <select name="udesign_options[main_content_bg_img_position_horizontal]" id="main_content_bg_img_position_horizontal">
                                                <option value="center"<?php echo ($options['main_content_bg_img_position_horizontal'] == 'center') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="left"<?php echo ($options['main_content_bg_img_position_horizontal'] == 'left') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('left', 'udesign'); ?></option>
                                                <option value="right"<?php echo ($options['main_content_bg_img_position_horizontal'] == 'right') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('right', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Vertical:', 'udesign'); ?>
                                            <select name="udesign_options[main_content_bg_img_position_vertical]" id="main_content_bg_img_position_vertical">
                                                <option value="top"<?php echo ($options['main_content_bg_img_position_vertical'] == 'top') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('top', 'udesign'); ?></option>
                                                <option value="center"<?php echo ($options['main_content_bg_img_position_vertical'] == 'center') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="bottom"<?php echo ($options['main_content_bg_img_position_vertical'] == 'bottom') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('bottom', 'udesign'); ?></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="form-table" style="background-color:#FCFCFC; border:1px solid #EBEBEB;">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e('Bottom Area Background Image', 'udesign'); ?></th>
                                    <td>
                                        <div style="padding:0; float:left;">
                                            <label for="bottom_bg_img"><?php esc_html_e('Enter a URL or upload an image:', 'udesign'); ?></label><br />
                                            <input name="udesign_options[bottom_bg_img]" type="text" id="bottom_bg_img" value="<?php if( $options['bottom_bg_img'] ){ echo esc_url($options['bottom_bg_img']); } ?>" size="65" />
                                            <input id="upload_bottom_bg_img_button" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary" />
                                        </div>
                                        <div class="clear"></div>
                                        <div style="margin:10px 10px 2px 0; float:left;">
                                            <?php esc_html_e('Background Properties:', 'udesign'); ?>
                                            <select name="udesign_options[bottom_bg_img_repeat]" id="bottom_bg_img_repeat">
                                                <option value="no-repeat"<?php echo ($options['bottom_bg_img_repeat'] == 'no-repeat') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('No Repeat', 'udesign'); ?></option>
                                                <option value="repeat-x"<?php echo ($options['bottom_bg_img_repeat'] == 'repeat-x') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Horizontally', 'udesign'); ?></option>
                                                <option value="repeat-y"<?php echo ($options['bottom_bg_img_repeat'] == 'repeat-y') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Vertically', 'udesign'); ?></option>
                                                <option value="repeat"<?php echo ($options['bottom_bg_img_repeat'] == 'repeat') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('Repeat both Vertically and Horizontally', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Horizontal:', 'udesign'); ?>
                                            <select name="udesign_options[bottom_bg_img_position_horizontal]" id="bottom_bg_img_position_horizontal">
                                                <option value="center"<?php echo ($options['bottom_bg_img_position_horizontal'] == 'center') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="left"<?php echo ($options['bottom_bg_img_position_horizontal'] == 'left') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('left', 'udesign'); ?></option>
                                                <option value="right"<?php echo ($options['bottom_bg_img_position_horizontal'] == 'right') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('right', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Vertical:', 'udesign'); ?>
                                            <select name="udesign_options[bottom_bg_img_position_vertical]" id="bottom_bg_img_position_vertical">
                                                <option value="top"<?php echo ($options['bottom_bg_img_position_vertical'] == 'top') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('top', 'udesign'); ?></option>
                                                <option value="center"<?php echo ($options['bottom_bg_img_position_vertical'] == 'center') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="bottom"<?php echo ($options['bottom_bg_img_position_vertical'] == 'bottom') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('bottom', 'udesign'); ?></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="form-table" style="background-color:#FCFCFC; border:1px solid #EBEBEB;">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e('Footer Background Image', 'udesign'); ?></th>
                                    <td>
                                        <div style="padding:0; float:left;">
                                            <label for="footer_bg_img"><?php esc_html_e('Enter a URL or upload an image:', 'udesign'); ?></label><br />
                                            <input name="udesign_options[footer_bg_img]" type="text" id="footer_bg_img" value="<?php if( $options['footer_bg_img'] ){ echo esc_url($options['footer_bg_img']); } ?>" size="65" />
                                            <input id="upload_footer_bg_img_button" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary" />
                                        </div>
                                        <div class="clear"></div>
                                        <div style="margin:10px 10px 2px 0; float:left;">
                                            <?php esc_html_e('Background Properties:', 'udesign'); ?>
                                            <select name="udesign_options[footer_bg_img_repeat]" id="footer_bg_img_repeat">
                                                <option value="no-repeat"<?php echo ($options['footer_bg_img_repeat'] == 'no-repeat') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('No Repeat', 'udesign'); ?></option>
                                                <option value="repeat-x"<?php echo ($options['footer_bg_img_repeat'] == 'repeat-x') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Horizontally', 'udesign'); ?></option>
                                                <option value="repeat-y"<?php echo ($options['footer_bg_img_repeat'] == 'repeat-y') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Vertically', 'udesign'); ?></option>
                                                <option value="repeat"<?php echo ($options['footer_bg_img_repeat'] == 'repeat') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('Repeat both Vertically and Horizontally', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Horizontal:', 'udesign'); ?>
                                            <select name="udesign_options[footer_bg_img_position_horizontal]" id="footer_bg_img_position_horizontal">
                                                <option value="center"<?php echo ($options['footer_bg_img_position_horizontal'] == 'center') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="left"<?php echo ($options['footer_bg_img_position_horizontal'] == 'left') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('left', 'udesign'); ?></option>
                                                <option value="right"<?php echo ($options['footer_bg_img_position_horizontal'] == 'right') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('right', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Vertical:', 'udesign'); ?>
                                            <select name="udesign_options[footer_bg_img_position_vertical]" id="footer_bg_img_position_vertical">
                                                <option value="top"<?php echo ($options['footer_bg_img_position_vertical'] == 'top') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('top', 'udesign'); ?></option>
                                                <option value="center"<?php echo ($options['footer_bg_img_position_vertical'] == 'center') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="bottom"<?php echo ($options['footer_bg_img_position_vertical'] == 'bottom') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('bottom', 'udesign'); ?></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="form-table" style="background-color:#F0F5F5; border:1px solid #DDE6E7;">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e('One Continuous Background Image That Will Span Across All Sections', 'udesign'); ?></th>
                                    <td>
                                        <div style="padding:0; float:left;">
                                            <label for="one_continuous_bg_img"><?php esc_html_e('Enter a URL or upload an image:', 'udesign'); ?></label><br />
                                            <input name="udesign_options[one_continuous_bg_img]" type="text" id="one_continuous_bg_img" value="<?php if( $options['one_continuous_bg_img'] ){ echo esc_url($options['one_continuous_bg_img']); } ?>" size="65" />
                                            <input id="upload_one_continuous_bg_img_button" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary" />
                                        </div>
                                        <div class="clear"></div>
                                        <div style="margin:10px 10px 10px 0; float:left;">
                                            <?php esc_html_e('Background Properties:', 'udesign'); ?>
                                            <select name="udesign_options[one_continuous_bg_img_repeat]" id="one_continuous_bg_img_repeat">
                                                <option value="no-repeat"<?php echo ($options['one_continuous_bg_img_repeat'] == 'no-repeat') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('No Repeat', 'udesign'); ?></option>
                                                <option value="repeat-x"<?php echo ($options['one_continuous_bg_img_repeat'] == 'repeat-x') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Horizontally', 'udesign'); ?></option>
                                                <option value="repeat-y"<?php echo ($options['one_continuous_bg_img_repeat'] == 'repeat-y') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Repeat only Vertically', 'udesign'); ?></option>
                                                <option value="repeat"<?php echo ($options['one_continuous_bg_img_repeat'] == 'repeat') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('Repeat both Vertically and Horizontally', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Horizontal:', 'udesign'); ?>
                                            <select name="udesign_options[one_continuous_bg_img_position_horizontal]" id="one_continuous_bg_img_position_horizontal">
                                                <option value="center"<?php echo ($options['one_continuous_bg_img_position_horizontal'] == 'center') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="left"<?php echo ($options['one_continuous_bg_img_position_horizontal'] == 'left') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('left', 'udesign'); ?></option>
                                                <option value="right"<?php echo ($options['one_continuous_bg_img_position_horizontal'] == 'right') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('right', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('Vertical:', 'udesign'); ?>
                                            <select name="udesign_options[one_continuous_bg_img_position_vertical]" id="one_continuous_bg_img_position_vertical">
                                                <option value="top"<?php echo ($options['one_continuous_bg_img_position_vertical'] == 'top') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('top', 'udesign'); ?></option>
                                                <option value="center"<?php echo ($options['one_continuous_bg_img_position_vertical'] == 'center') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('center', 'udesign'); ?></option>
                                                <option value="bottom"<?php echo ($options['one_continuous_bg_img_position_vertical'] == 'bottom') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('bottom', 'udesign'); ?></option>
                                            </select>
                                        </div>
                                        <div class="clear"></div>
                                        <div><span class="description" style="color:#A60000;"><?php printf( __('For Background color  %1$sTop Area Background %2$s%3$s  will be used.', 'udesign'), '<a title="Go To Top Area Background..." href="#top-area-background">', '&rarr;', '</a>'); ?></span></div>
                                        
                                        <fieldset style="margin-top:5px;"><legend class="screen-reader-text"><span><?php esc_html_e('Fixed Position', 'udesign'); ?></span></legend>
                                            <label for="one_continuous_bg_img_fixed">
                                                <input name="udesign_options[one_continuous_bg_img_fixed]" type="checkbox" id="one_continuous_bg_img_fixed" value="yes" <?php checked('yes', $options['one_continuous_bg_img_fixed']); ?> />
                                                <?php esc_html_e("Fix the position of the background image so that it is not scrollable.", 'udesign'); ?><br />
                                            </label>
                                        </fieldset>
                                        <fieldset style="margin-top:5px;"><legend class="screen-reader-text"><span><?php esc_html_e("Allow Other Sections' Images", 'udesign'); ?></span></legend>
                                            <label for="one_continuous_bg_img_with_other_bg_imgs">
                                                <input name="udesign_options[one_continuous_bg_img_with_other_bg_imgs]" type="checkbox" id="one_continuous_bg_img_with_other_bg_imgs" value="yes" <?php checked('yes', $options['one_continuous_bg_img_with_other_bg_imgs']); ?> />
                                                <?php esc_html_e("Enable background images from other sections to show as well, you can achieve sort of layered layout.", 'udesign'); ?><br />
                                            </label>
                                        </fieldset>
                                        <div class="clear"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="form-table">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e('Remove Horizontal Rulers', 'udesign'); ?></th>
                                    <td>
                                        <fieldset style="margin-top:5px;"><legend class="screen-reader-text"><span><?php esc_html_e("Remove Horizontal Rulers", 'udesign'); ?></span></legend>
                                            <label for="udesign_remove_horizontal_rulers">
                                                <input name="udesign_options[udesign_remove_horizontal_rulers]" type="checkbox" id="udesign_remove_horizontal_rulers" value="yes" <?php checked('yes', $options['udesign_remove_horizontal_rulers']); ?> />
                                                <?php esc_html_e("This option will allow you to remove the horizontal ruler lines that are enabled by default for some sections.", 'udesign'); ?><br />
                                            </label>
                                            <div style="margin-top:10px;"><span class="description"><?php printf( __('Note: If you wish to remove the border line under the top navigation menu, the option for that is located under: %1$s Menus Options %2$s Main Menu %2$s Border Under the Menu %3$s', 'udesign'), '<br /><strong>', '&rarr;', '</strong>'); ?></span></div>
                                        </fieldset>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="clear"></div>
                    </div>
<?php		    display_save_changes_button(); ?>
                    
<?php               $save_current_colors_as_array = isset( $options['save_current_colors_as_array'] ) ? $options['save_current_colors_as_array']: ''; ?>
		    <div id="administrative-tasks" style="margin:20px 10px 17px; padding:20px; display:block; background-color:#F8F8F1; border:1px solid #DDD;">
			<h2 style="color:#ff4d00; margin-top: 2px; padding:0;"><?php esc_html_e('Administrative Tasks:', 'udesign'); ?></h2>
			<label for="save_current_colors_as_array">
			    <input name="udesign_options[save_current_colors_as_array]" type="checkbox" id="save_current_colors_as_array" value="yes" <?php checked('yes', $save_current_colors_as_array); ?> />
			    <strong><?php esc_html_e('Save the current custom colors.', 'udesign'); ?></strong>
			</label>
			<p><span class="description"><?php esc_html_e('A Color Scheme will be saved with an automatic name generated from the current time stamp. Once saved you will be able to choose it from the dropdown below and load it at a later time.', 'udesign'); ?></span>
			    <div class="submit" style="padding:0 0 10px; float:left; clear:both; display:block;">
				<input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
				<input class="button-secondary left" type="submit" name="form-submit" value="<?php esc_attr_e('Save', 'udesign'); ?>" />
                                <span class="spinner"></span>
			    </div>
			</p>
			<div class="clear"></div>

			<p><strong><?php esc_html_e('Choose a custom color scheme from the first dropdown below and then choose a task to perform from the second dropdown, then hit the "Update" button.', 'udesign'); ?></strong></p>
			<select name="udesign_options[chosen_custom_colors]" id="chosen_custom_colors">
				<option value="" style="padding:0 10px;">--<?php esc_html_e('Custom Color Schemes', 'udesign'); ?>--</option>
				<option value="default">0. Default Colors</option>
<?php				if( !empty($options['saved_custom_colors_array']) ) {
				    foreach ( array_keys($options['saved_custom_colors_array']) as $key => $custom_color_name ) { // get just the keys, since they contain the names
					echo '<option value="'.$custom_color_name.'">'.($key+1).'. '.$custom_color_name.'</option>';
				    }
				} ?>
			</select> <span style="font-size:18px;">&rarr; </span>
			<select name="udesign_options[chosen_custom_colors_admin_task]" id="chosen_custom_colors_admin_task">
				<option value="" style="padding:0 10px;">--<?php esc_html_e('Choose Admin Task', 'udesign'); ?>--</option>
				<option value="load">Load</option>
				<option value="delete">Delete</option>
			</select>
			<p><span class="description"><?php esc_html_e('Note: The "Default Colors" cannot be deleted.', 'udesign'); ?></span></p>
			<p>
			    <div class="submit" style="padding:0; float:left; clear:both; display:block;">
				<input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
				<input class="button-secondary left" type="submit" name="form-submit" value="<?php esc_attr_e('Update', 'udesign'); ?>" />
                                <span class="spinner"></span>
			    </div>
			</p>
			<div class="clear"></div>
		    </div>
<?php		endif; ?>

<?php	}

	function front_page_options_contentbox( $options ) {
		$current_slider = $options['current_slider']; ?>

		<table class="form-table" style="background-color:#FCFCFC; border:1px solid #DDDDDD;">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Current Slider', 'udesign'); ?></th>
			    <td>
				<label for="current_slider"><?php esc_html_e('Choose a slider:', 'udesign'); ?></label>
				<br />
				<select name="udesign_options[current_slider]" id="current_slider">
				    <option value="4"<?php echo ($current_slider == '4') ? ' selected="selected"' : ''; ?>><?php esc_html_e('Cycle 1 (full width image)', 'udesign'); ?></option>
				    <option value="5"<?php echo ($current_slider == '5') ? ' selected="selected"' : ''; ?>><?php esc_html_e('Cycle 2 (image with text)', 'udesign'); ?></option>
				    <option value="6"<?php echo ($current_slider == '6') ? ' selected="selected"' : ''; ?>><?php esc_html_e('Cycle 3 (image with sliding text)', 'udesign'); ?></option>
				    <option value="8"<?php echo ($current_slider == '8') ? ' selected="selected"' : ''; ?>><?php esc_html_e('Revolution Slider', 'udesign'); ?></option>
				    <option value="7"<?php echo ($current_slider == '7') ? ' selected="selected"' : ''; ?>><?php esc_html_e('No Slider', 'udesign'); ?></option>
				</select>
				<div class="clear"></div>
				<div class="submit" style="padding:10px 0 0 80px; float:left; clear:both;">
				    <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
				    <input class="button-secondary right" type="submit" name="form-submit" value="<?php esc_attr_e('Save & Activate', 'udesign'); ?>" />
                                    <span class="spinner"></span>
				</div>
<?php				if ( $current_slider != '7' ) : ?>
				    <div style="padding-top:10px; clear:both;"><?php esc_html_e('Continue with the section below to customize the slider...', 'udesign'); ?></div>
<?php				endif; ?>
			    </td>
			</tr>
		    </tbody>
		</table>

<?php		if ( $current_slider == '4' ) :
		    $c1_slides_order_str = $options['c1_slides_order_str'];
		    $c1_slides_array = explode( ',', $options['c1_slides_order_str'] );
		    $c1_speed = $options['c1_speed'];
		    $c1_timeout = $options['c1_timeout'];
		    $c1_sync = $options['c1_sync']; // see the other slides' forms to add an invisible instance of this checkbox to preserver the state
		    $c1_remove_3d_shadow = $options['c1_remove_3d_shadow'];  ?>
		    <!-- Add invisible fields from the other sliders' forms to preserve their state. (this is only necessary for checkboxes and some text fields)  -->
		    <input style="display:none;" name="udesign_options[c2_sync]" type="checkbox" id="c2_sync" value="yes" <?php checked('yes', $options['c2_sync']); ?> />
		    <input style="display:none;" name="udesign_options[c2_text_transition_on]" type="checkbox" id="c2_text_transition_on" value="yes" <?php checked('yes', $options['c2_text_transition_on']); ?> />
		    <input style="display:none;" name="udesign_options[c3_autostop]" type="checkbox" id="c3_autostop" value="yes" <?php checked('yes', $options['c3_autostop']); ?> />
		    <input name="udesign_options[no_slider_text]" type="hidden" id="no_slider_text" value="<?php if ($options['no_slider_text']) { echo esc_attr($options['no_slider_text']); } ?>" />
		    <input name="udesign_options[rev_slider_shortcode]" type="hidden" id="rev_slider_shortcode" value="<?php if ($options['rev_slider_shortcode']) { echo esc_attr($options['rev_slider_shortcode']); } ?>" />


		    <h2 style="color:#2680AA; margin-top: 2px; padding:20px 10px 0;"><?php esc_html_e('Cycle 1 Slider Settings:', 'udesign'); ?></h2>
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><label for="c1_speed"><?php esc_html_e('Transition Speed', 'udesign'); ?></label></th>
				<td>
				    <input name="udesign_options[c1_speed]" type="text" id="c1_speed" value="<?php echo esc_attr($c1_speed); ?>" size="5" maxlength="6" />
				    <span><?php esc_html_e('Speed of the transition.', 'udesign'); ?></span>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><label for="c1_timeout"><?php esc_html_e('Timeout', 'udesign'); ?></label></th>
				<td>
				    <input name="udesign_options[c1_timeout]" type="text" id="c1_timeout" value="<?php echo esc_attr($c1_timeout); ?>" size="5" maxlength="6" />
				    <span><?php esc_html_e('Milliseconds between slide transitions (0 to disable auto advance).', 'udesign'); ?></span>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Sync', 'udesign'); ?></th>
				<td>
				    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Sync', 'udesign'); ?></span></legend>
				    <label for="c1_sync">
					<input name="udesign_options[c1_sync]" type="checkbox" id="c1_sync" value="yes" <?php checked('yes', $c1_sync); ?> />
					<?php esc_html_e('Toggle this option to see how some effects behave differently (such as blind, curtain, and zoom).', 'udesign'); ?>
				    </label>
				    </fieldset>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Image Frame', 'udesign'); ?></th>
				<td>
				    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Image Frame', 'udesign'); ?></span></legend>
				    <label for="c1_remove_image_frame">
					<input name="udesign_options[c1_remove_image_frame]" type="checkbox" id="c1_remove_image_frame" value="yes" <?php checked('yes', $options['c1_remove_image_frame']); ?> />
					<?php esc_html_e('Remove the image frame with the border around the image?', 'udesign'); ?><br />
					<span class="description"><?php esc_html_e('With the frame enabled (default state) image dimension is 914px by 374px (width by height). Without the frame image dimension is 940px by 400px. Depending on which option is selected, create and upload images with the corresponding dimensions for optimal quality.', 'udesign'); ?></span>
				    </label>
				    </fieldset>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('3D Shadow', 'udesign'); ?></th>
				<td>
				    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('3D Shadow', 'udesign'); ?></span></legend>
				    <label for="c1_remove_3d_shadow">
					<input name="udesign_options[c1_remove_3d_shadow]" type="checkbox" id="c1_remove_3d_shadow" value="yes" <?php checked('yes', $c1_remove_3d_shadow); ?> />
					<?php esc_html_e('Remove the 3D shadow under the slider', 'udesign'); ?>
				    </label>
				    </fieldset>
				</td>
			    </tr>
			</tbody>
		    </table>
		    <?php display_save_changes_button(); ?>

		    <input name="udesign_options[c1_slides_order_str]" type="hidden" id="c1_slides_order_str" value="<?php if ($c1_slides_order_str){ echo esc_attr($c1_slides_order_str); }?>" />
		    <div class="add-row" style></div>
		    <table id="c1-table-slides" class="c1-table-slides">
			<tbody>
    <?php		    foreach( $c1_slides_array as $position=>$slide_row_number ) : ?>
				<tr id="<?php echo $slide_row_number; ?>" class="row-style">
				    <td class="dragHandle showDragHandle" style="width:30px; padding:15px 20px;">&nbsp;</td>
				    <td class="deleteSlide" style="margin:10px 10px; width:30px; padding:5px 15px;">&nbsp;</td>
				    <td class="position" style="padding:15px 20px; width:40px; font-weight:bold; font-size:20px; text-align:center; height:110px"><?php echo $position+1; ?></td>
				    <td style="padding:0 10px 10px 20px; width:100%" valign="top">
                                        <div class="c1_slide_upload_section" style="padding:10px 0; float:left;">
                                            <label style="float:left; margin:1px; font-weight:bold;" for="c1_slide_img_url_<?php echo $slide_row_number; ?>"><?php esc_html_e('Enter a URL or upload an image:', 'udesign'); ?></label><br />
                                            <input class="c1_slide_img_url_field" name="udesign_options[c1_slide_img_url_<?php echo $slide_row_number; ?>]" type="text" id="c1_slide_img_url_<?php echo $slide_row_number; ?>" value="<?php if( $options['c1_slide_img_url_'.$slide_row_number] ){ echo esc_url($options['c1_slide_img_url_'.$slide_row_number]); } ?>" size="65" />
                                            <input id="c1_slide_upload_button_<?php echo $slide_row_number; ?>" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary c1_slide_img_url_btn" />
                                            <a class="info-help" style="margin:0 5px 0 10px;" title="Click the 'Upload Image' button. Once you've selected or uploaded an image (see documentation for proper dimensions), look for the 'Insert into Post' button and click it.">HELP</a>
                                        </div>
                                        <div class="clear"></div>
					<div class="transition-type" style="padding:7px 5px 0 0; float:left;">
					    <select name="udesign_options[c1_transition_type_<?php echo $slide_row_number; ?>]" id="c1_transition_type_<?php echo $slide_row_number; ?>">
						<option value="fade"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'fade') ? ' selected="selected"' : ''; ?>>fade</option>
						<option value="curtainX"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'curtainX') ? ' selected="selected"' : ''; ?>>curtainX</option>
						<option value="curtainY"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'curtainY') ? ' selected="selected"' : ''; ?>>curtainY</option>
						<option value="turnUp"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'turnUp') ? ' selected="selected"' : ''; ?>>turnUp</option>
						<option value="turnDown"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'turnDown') ? ' selected="selected"' : ''; ?>>turnDown</option>
						<option value="wipe"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'wipe') ? ' selected="selected"' : ''; ?>>wipe</option>
						<option value="scrollHorz"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'scrollHorz') ? ' selected="selected"' : ''; ?>>scrollHorz</option>
						<option value="scrollVert"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'scrollVert') ? ' selected="selected"' : ''; ?>>scrollVert</option>
						<option value="growX"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'growX') ? ' selected="selected"' : ''; ?>>growX</option>
						<option value="growY"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'growY') ? ' selected="selected"' : ''; ?>>growY</option>
						<option value="scrollUp"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'scrollUp') ? ' selected="selected"' : ''; ?>>scrollUp</option>
						<option value="scrollDown"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'scrollDown') ? ' selected="selected"' : ''; ?>>scrollDown</option>
						<option value="shuffle"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'shuffle') ? ' selected="selected"' : ''; ?>>shuffle</option>
						<option value="blindX"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'blindX') ? ' selected="selected"' : ''; ?>>blindX</option>
						<option value="blindY"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'blindY') ? ' selected="selected"' : ''; ?>>blindY</option>
						<option value="blindZ"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'blindZ') ? ' selected="selected"' : ''; ?>>blindZ</option>
						<option value="cover"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'cover') ? ' selected="selected"' : ''; ?>>cover</option>
						<option value="fadeZoom"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'fadeZoom') ? ' selected="selected"' : ''; ?>>fadeZoom</option>
						<option value="scrollLeft"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'scrollLeft') ? ' selected="selected"' : ''; ?>>scrollLeft</option>
						<option value="scrollRight"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'scrollRight') ? ' selected="selected"' : ''; ?>>scrollRight</option>
						<option value="slideX"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'slideX') ? ' selected="selected"' : ''; ?>>slideX</option>
						<option value="slideY"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'slideY') ? ' selected="selected"' : ''; ?>>slideY</option>
						<option value="toss"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'toss') ? ' selected="selected"' : ''; ?>>toss</option>
						<option value="turnLeft"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'turnLeft') ? ' selected="selected"' : ''; ?>>turnLeft</option>
						<option value="turnRight"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'turnRight') ? ' selected="selected"' : ''; ?>>turnRight</option>
						<option value="uncover"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'uncover') ? ' selected="selected"' : ''; ?>>uncover</option>
						<option value="zoom"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'zoom') ? ' selected="selected"' : ''; ?>>zoom</option>
						<option value="none"<?php echo ($options['c1_transition_type_'.$slide_row_number] == 'none') ? ' selected="selected"' : ''; ?>>none</option>
					    </select>
					    <span><?php esc_html_e('Transition effect.', 'udesign'); ?></span>
					</div>
					<div id="c1_slide_link_url_<?php echo $slide_row_number; ?>" class="slide-link" style="padding:20px 5px 0; clear:both;">
					    <label for="c1_slide_link_url_<?php echo $slide_row_number; ?>"><?php esc_html_e('Link:', 'udesign'); ?> </label>
					    <input name="udesign_options[c1_slide_link_url_<?php echo $slide_row_number; ?>]" type="text" id="c1_slide_link_url_<?php echo $slide_row_number; ?>" value="<?php if ($options['c1_slide_link_url_'.$slide_row_number]){ echo esc_url($options['c1_slide_link_url_'.$slide_row_number]); }?>" size="30" />
					    <label for="c1_slide_link_target_<?php echo $slide_row_number; ?>">
						<?php esc_html_e('Target: ', 'udesign'); ?>
						<select name="udesign_options[c1_slide_link_target_<?php echo $slide_row_number; ?>]" id="c1_slide_link_target_<?php echo $slide_row_number; ?>">
						    <option value="self"<?php echo ($options['c1_slide_link_target_'.$slide_row_number] == 'self') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('self', 'udesign'); ?></option>
						    <option value="blank"<?php echo ($options['c1_slide_link_target_'.$slide_row_number] == 'blank') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('blank', 'udesign'); ?></option>
						</select>
					    </label>
                                            <div class="slide-alt-tag" style="display:inline-block;">
                                                <label for="c1_slide_image_alt_tag_<?php echo $slide_row_number; ?>" style="margin-left:10px;"><?php esc_html_e('Alt Tag:', 'udesign'); ?> </label> 
                                                <input name="udesign_options[c1_slide_image_alt_tag_<?php echo $slide_row_number; ?>]" type="text" id="c1_slide_image_alt_tag_<?php echo $slide_row_number; ?>" value="<?php echo esc_attr($options['c1_slide_image_alt_tag_'.$slide_row_number]); ?>" size="20" />
                                            </div>
                                            <div><span style="line-height: 1.5; font-size: 12px;" class="description" style="margin:5px 0;float:left;"><?php esc_html_e('(To clear a text field above, replace it with a single space)', 'udesign'); ?></span></div>
					</div>
				    </td>
				</tr>
    <?php		    endforeach; ?>
			</tbody>
		    </table>
		    <table id="c1-clone-table" style="display:none;">
			<tbody>
			    <tr id="999" class="row-style">
				<td class="dragHandle showDragHandle" style="width:30px; padding:15px 20px;">&nbsp;</td>
				<td class="deleteSlide" style="margin:10px 10px; width:30px; padding:5px 15px;">&nbsp;</td>
				<td class="position" style="padding:15px 20px; width:40px; font-weight:bold; font-size:20px; text-align:center; height:110px">999</td>
				<td style="padding:0 10px 10px 20px; width:100%" valign="top">
                                    <div class="c1_slide_upload_section" style="padding:10px 0; float:left;">
                                        <label style="float:left; margin:1px; font-weight:bold;" for="c1_slide_img_url_999"><?php esc_html_e('Enter a URL or upload an image:', 'udesign'); ?></label><br />
                                        <input class="c1_slide_img_url_field" name="udesign_options[c1_slide_img_url_999]" type="text" id="c1_slide_img_url_999" value="" size="65" />
                                        <input id="c1_slide_upload_button_999" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary c1_slide_img_url_btn" />
                                        <a class="info-help" style="margin:0 5px 0 10px;" title="Click the 'Upload Image' button. Once you've selected or uploaded an image (see documentation for proper dimensions), look for the 'Insert into Post' button and click it.">HELP</a>
                                    </div>
                                    <div class="clear"></div>
				    <div class="transition-type" style="padding:7px 5px 0 0; float:left;">
					<select name="udesign_options[c1_transition_type_999]" id="c1_transition_type_999">
					    <option value="fade" selected="selected">fade</option>
					    <option value="curtainX">curtainX</option>
					    <option value="curtainY">curtainY</option>
					    <option value="turnUp">turnUp</option>
					    <option value="turnDown">turnDown</option>
					    <option value="wipe">wipe</option>
					    <option value="scrollHorz">scrollHorz</option>
					    <option value="scrollVert">scrollVert</option>
					    <option value="growX">growX</option>
					    <option value="growY">growY</option>
					    <option value="scrollUp">scrollUp</option>
					    <option value="scrollDown">scrollDown</option>
					    <option value="shuffle">shuffle</option>
					    <option value="blindX">blindX</option>
					    <option value="blindY">blindY</option>
					    <option value="blindZ">blindZ</option>
					    <option value="cover">cover</option>
					    <option value="fadeZoom">fadeZoom</option>
					    <option value="scrollLeft">scrollLeft</option>
					    <option value="scrollRight">scrollRight</option>
					    <option value="slideX">slideX</option>
					    <option value="slideY">slideY</option>
					    <option value="toss">toss</option>
					    <option value="turnLeft">turnLeft</option>
					    <option value="turnRight">turnRight</option>
					    <option value="uncover">uncover</option>
					    <option value="zoom">zoom</option>
					    <option value="none">none</option>
					</select>
					<span><?php esc_html_e('Transition effect.', 'udesign'); ?></span>
				    </div>
				    <div id="c1_slide_link_url_999" class="slide-link" style="padding:20px 5px 0; clear:both;">
					<label for="c1_slide_link_url_999" class="link-url"><?php esc_html_e('Link:', 'udesign'); ?> </label>
					<input name="udesign_options[c1_slide_link_url_999]" type="text" id="c1_slide_link_url_999" value="" size="30" />
					<label for="c1_slide_link_target_999" class="link-target">
						<?php esc_html_e('Target: ', 'udesign'); ?>
						<select name="udesign_options[c1_slide_link_target_999]" id="c1_slide_link_target_999">
						    <option value="self" selected="selected"><?php esc_attr_e('self', 'udesign'); ?></option>
						    <option value="blank"><?php esc_attr_e('blank', 'udesign'); ?></option>
						</select>
					</label>
                                        <div class="slide-alt-tag" style="display:inline-block;">
                                            <label for="c1_slide_image_alt_tag_999" style="margin-left:10px;"><?php esc_html_e('Alt Tag:', 'udesign'); ?> </label>
                                            <input name="udesign_options[c1_slide_image_alt_tag_999]" type="text" id="c1_slide_image_alt_tag_999" value="" size="20" />
                                        </div>
                                        <div><span style="line-height: 1.5; font-size: 12px;" class="description" style="margin:5px 0;float:left;"><?php esc_html_e('(To clear a text field above, replace it with a single space)', 'udesign'); ?></span></div>
				    </div>
				</td>
			    </tr>
			</tbody>
		    </table>

<?php		elseif ( $current_slider == '5' ) :
		    $c2_slides_order_str = $options['c2_slides_order_str'];
		    $c2_slides_array = explode( ',', $options['c2_slides_order_str'] );
		    $c2_speed = $options['c2_speed'];
		    $c2_timeout = $options['c2_timeout'];
		    $c2_sync = $options['c2_sync']; // see the other slides' forms to add an invisible instance of this checkbox to preserver the state
		    $c2_text_color = $options['c2_text_color'];  ?>
		    <!-- Add invisible fields from the other sliders' forms to preserve their state. (this is only necessary for checkboxes and some text fields)  -->
		    <input style="display:none;" name="udesign_options[c1_sync]" type="checkbox" id="c1_sync" value="yes" <?php checked('yes', $options['c1_sync']); ?> />
		    <input style="display:none;" name="udesign_options[c1_remove_image_frame]" type="checkbox" id="c1_remove_image_frame" value="yes" <?php checked('yes', $options['c1_remove_image_frame']); ?> />
		    <input style="display:none;" name="udesign_options[c1_remove_3d_shadow]" type="checkbox" id="c1_remove_3d_shadow" value="yes" <?php checked('yes', $options['c1_remove_3d_shadow']); ?> />
		    <input style="display:none;" name="udesign_options[c3_autostop]" type="checkbox" id="c3_autostop" value="yes" <?php checked('yes', $options['c3_autostop']); ?> />
		    <input name="udesign_options[no_slider_text]" type="hidden" id="no_slider_text" value="<?php if ($options['no_slider_text']) { echo esc_attr($options['no_slider_text']); } ?>" />
		    <input name="udesign_options[rev_slider_shortcode]" type="hidden" id="rev_slider_shortcode" value="<?php if ($options['rev_slider_shortcode']) { echo esc_attr($options['rev_slider_shortcode']); } ?>" />


		    <h2 style="color:#2680AA; margin-top: 2px; padding:20px 10px 0;"><?php esc_html_e('Cycle 2 Slider Settings:', 'udesign'); ?></h2>
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><label for="c2_speed"><?php esc_html_e('Transition Speed', 'udesign'); ?></label></th>
				<td>
				    <input name="udesign_options[c2_speed]" type="text" id="c2_speed" value="<?php echo esc_attr($c2_speed); ?>" size="5" maxlength="6" />
				    <span><?php esc_html_e('Speed of the transition.', 'udesign'); ?></span>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><label for="c2_timeout"><?php esc_html_e('Timeout', 'udesign'); ?></label></th>
				<td>
				    <input name="udesign_options[c2_timeout]" type="text" id="c2_timeout" value="<?php echo esc_attr($c2_timeout); ?>" size="5" maxlength="6" />
				    <span><?php esc_html_e('Milliseconds between slide transitions (0 to disable auto advance).', 'udesign'); ?></span>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Sync', 'udesign'); ?></th>
				<td>
				    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Sync', 'udesign'); ?></span></legend>
				    <label for="c2_sync">
					<input name="udesign_options[c2_sync]" type="checkbox" id="c2_sync" value="yes" <?php checked('yes', $c2_sync); ?> />
					<?php esc_html_e('Toggle this option to see how some effects behave differently (such as blind, curtain, and zoom).', 'udesign'); ?>
				    </label>
				    </fieldset>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Enable Transition on Text', 'udesign'); ?></th>
				<td>
				    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Enable Transition on Text', 'udesign'); ?></span></legend>
				    <label for="c2_text_transition_on">
					<input name="udesign_options[c2_text_transition_on]" type="checkbox" id="c2_text_transition_on" value="yes" <?php checked('yes', $options['c2_text_transition_on']); ?> />
					<?php esc_html_e('Toggle this option to enable/disable the transition effect on the info text. If disabled (unchecked) then the text will disapear for the duration of the transition.', 'udesign'); ?>
				    </label>
				    </fieldset>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Text Size', 'udesign'); ?></th>
				<td>
				    <label for="c2_slider_text_size">
					    <?php esc_html_e('Font Size: ', 'udesign'); ?>
					    <select name="udesign_options[c2_slider_text_size]" id="c2_slider_text_size">
						<option value="1.0"<?php echo ($options['c2_slider_text_size'] == '1.0') ? ' selected="selected"' : ''; ?>>1.0em</option>
						<option value="1.1"<?php echo ($options['c2_slider_text_size'] == '1.1') ? ' selected="selected"' : ''; ?>>1.1em</option>
						<option value="1.2"<?php echo ($options['c2_slider_text_size'] == '1.2') ? ' selected="selected"' : ''; ?> style="padding-right:7px;">1.2em (Default)</option>
						<option value="1.3"<?php echo ($options['c2_slider_text_size'] == '1.3') ? ' selected="selected"' : ''; ?>>1.3em</option>
						<option value="1.4"<?php echo ($options['c2_slider_text_size'] == '1.4') ? ' selected="selected"' : ''; ?>>1.4em</option>
						<option value="1.5"<?php echo ($options['c2_slider_text_size'] == '1.5') ? ' selected="selected"' : ''; ?>>1.5em</option>
						<option value="1.6"<?php echo ($options['c2_slider_text_size'] == '1.6') ? ' selected="selected"' : ''; ?>>1.6em</option>
						<option value="1.7"<?php echo ($options['c2_slider_text_size'] == '1.7') ? ' selected="selected"' : ''; ?>>1.7em</option>
						<option value="1.8"<?php echo ($options['c2_slider_text_size'] == '1.8') ? ' selected="selected"' : ''; ?>>1.8em</option>
						<option value="1.9"<?php echo ($options['c2_slider_text_size'] == '1.9') ? ' selected="selected"' : ''; ?>>1.9em</option>
						<option value="2.0"<?php echo ($options['c2_slider_text_size'] == '2.0') ? ' selected="selected"' : ''; ?>>2.0em</option>
					    </select>
				    </label>
				    <br />
				    <?php esc_html_e('When using "em" you are specifying size relative to the general font size.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Text Line Height', 'udesign'); ?></th>
				<td>
				    <label for="c2_slider_text_line_height">
					    <?php esc_html_e('Line Height: ', 'udesign'); ?>
					    <select name="udesign_options[c2_slider_text_line_height]" id="c2_slider_text_line_height">
						<option value="0.5"<?php echo ($options['c2_slider_text_line_height'] == '0.5') ? ' selected="selected"' : ''; ?>>0.5</option>
						<option value="0.6"<?php echo ($options['c2_slider_text_line_height'] == '0.6') ? ' selected="selected"' : ''; ?>>0.6</option>
						<option value="0.7"<?php echo ($options['c2_slider_text_line_height'] == '0.7') ? ' selected="selected"' : ''; ?>>0.7</option>
						<option value="0.8"<?php echo ($options['c2_slider_text_line_height'] == '0.8') ? ' selected="selected"' : ''; ?>>0.8</option>
						<option value="0.9"<?php echo ($options['c2_slider_text_line_height'] == '0.9') ? ' selected="selected"' : ''; ?>>0.9</option>
						<option value="1.0"<?php echo ($options['c2_slider_text_line_height'] == '1.0') ? ' selected="selected"' : ''; ?>>1.0</option>
						<option value="1.1"<?php echo ($options['c2_slider_text_line_height'] == '1.1') ? ' selected="selected"' : ''; ?>>1.1</option>
						<option value="1.2"<?php echo ($options['c2_slider_text_line_height'] == '1.2') ? ' selected="selected"' : ''; ?>>1.2</option>
						<option value="1.3"<?php echo ($options['c2_slider_text_line_height'] == '1.3') ? ' selected="selected"' : ''; ?>>1.3</option>
						<option value="1.4"<?php echo ($options['c2_slider_text_line_height'] == '1.4') ? ' selected="selected"' : ''; ?>>1.4</option>
						<option value="1.5"<?php echo ($options['c2_slider_text_line_height'] == '1.5') ? ' selected="selected"' : ''; ?>>1.5</option>
						<option value="1.6"<?php echo ($options['c2_slider_text_line_height'] == '1.6') ? ' selected="selected"' : ''; ?>>1.6</option>
						<option value="1.7"<?php echo ($options['c2_slider_text_line_height'] == '1.7') ? ' selected="selected"' : ''; ?> style="padding-right:7px;">1.7 (Default)</option>
						<option value="1.8"<?php echo ($options['c2_slider_text_line_height'] == '1.8') ? ' selected="selected"' : ''; ?>>1.8</option>
						<option value="1.9"<?php echo ($options['c2_slider_text_line_height'] == '1.9') ? ' selected="selected"' : ''; ?>>1.9</option>
						<option value="2.0"<?php echo ($options['c2_slider_text_line_height'] == '2.0') ? ' selected="selected"' : ''; ?>>2.0</option>
						<option value="2.1"<?php echo ($options['c2_slider_text_line_height'] == '2.1') ? ' selected="selected"' : ''; ?>>2.1</option>
						<option value="2.2"<?php echo ($options['c2_slider_text_line_height'] == '2.2') ? ' selected="selected"' : ''; ?>>2.2</option>
						<option value="2.3"<?php echo ($options['c2_slider_text_line_height'] == '2.3') ? ' selected="selected"' : ''; ?>>2.3</option>
						<option value="2.4"<?php echo ($options['c2_slider_text_line_height'] == '2.4') ? ' selected="selected"' : ''; ?>>2.4</option>
						<option value="2.5"<?php echo ($options['c2_slider_text_line_height'] == '2.5') ? ' selected="selected"' : ''; ?>>2.5</option>
						<option value="2.6"<?php echo ($options['c2_slider_text_line_height'] == '2.6') ? ' selected="selected"' : ''; ?>>2.6</option>
					    </select>
				    </label>
				</td>
			    </tr>
			</tbody>
		    </table>

		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Text Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="c2-colorSelector1">
					<div style="background-color: #<?php echo ($c2_text_color) ? esc_attr($c2_text_color) : '333333'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[c2_text_color]" id="c2_text_color" type="text" maxlength="6" size="6" style="margin:2px 10px 0 0" value="<?php echo ($c2_text_color) ? esc_attr($c2_text_color) : '333333'; ?>" />
				    <?php esc_html_e('Slider text color including the Title.', 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
		    <?php display_save_changes_button(); ?>


		    <input name="udesign_options[c2_slides_order_str]" type="hidden" id="c2_slides_order_str" value="<?php if ($c2_slides_order_str){ echo esc_attr($c2_slides_order_str); }?>" />
		    <div class="add-row" style></div>
		    <table id="c2-table-slides" class="c2-table-slides">
			<tbody>
    <?php		    foreach( $c2_slides_array as $position=>$slide_row_number ) : ?>
				<tr id="<?php echo $slide_row_number; ?>" class="row-style">
				    <td class="dragHandle showDragHandle" style="width:30px; padding:15px 20px;">&nbsp;</td>
				    <td class="deleteSlide" style="margin:10px 10px; width:30px; padding:5px 15px;">&nbsp;</td>
				    <td class="position" style="padding:15px 20px; width:40px; font-weight:bold; font-size:20px; text-align:center; height:110px"><?php echo $position+1; ?></td>
				    <td style="padding:10px 10px 10px 20px; width:100%" valign="top">
					<div class="c2_slide_img_url" style="padding:7px 5px 0 0; float:left; display:inline;">
                                            <label style="font-weight:bold;" for="c2_slide_img_url_<?php echo $slide_row_number; ?>"><?php esc_html_e('Image:', 'udesign'); ?></label>
                                            <input class="c2_slide_img_url_field" name="udesign_options[c2_slide_img_url_<?php echo $slide_row_number; ?>]" type="text" id="c2_slide_img_url_<?php echo $slide_row_number; ?>" value="<?php if ($options['c2_slide_img_url_'.$slide_row_number]){ echo esc_url($options['c2_slide_img_url_'.$slide_row_number]); }?>" size="65" />
                                            <input id="c2_slide_upload_button_<?php echo $slide_row_number; ?>" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary c2_slide_img_url_btn" />
                                            <a class="info-help" style="margin:0 5px 0 10px;" title="Click the 'Upload Image' button. Once you've selected or uploaded an image (see documentation for proper dimensions), look for the 'Insert into Post' button and click it.">HELP</a>
					</div>
					<div class="transition-type" style="padding:10px 5px 0 0; clear:both;">
					    <strong><?php esc_html_e('Transition:', 'udesign'); ?></strong>
					    <select name="udesign_options[c2_transition_type_<?php echo $slide_row_number; ?>]" id="c2_transition_type_<?php echo $slide_row_number; ?>">
						<option value="fade"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'fade') ? ' selected="selected"' : ''; ?>>fade</option>
						<option value="curtainX"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'curtainX') ? ' selected="selected"' : ''; ?>>curtainX</option>
						<option value="curtainY"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'curtainY') ? ' selected="selected"' : ''; ?>>curtainY</option>
						<option value="turnUp"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'turnUp') ? ' selected="selected"' : ''; ?>>turnUp</option>
						<option value="turnDown"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'turnDown') ? ' selected="selected"' : ''; ?>>turnDown</option>
						<option value="wipe"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'wipe') ? ' selected="selected"' : ''; ?>>wipe</option>
						<option value="scrollHorz"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'scrollHorz') ? ' selected="selected"' : ''; ?>>scrollHorz</option>
						<option value="scrollVert"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'scrollVert') ? ' selected="selected"' : ''; ?>>scrollVert</option>
						<option value="growX"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'growX') ? ' selected="selected"' : ''; ?>>growX</option>
						<option value="growY"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'growY') ? ' selected="selected"' : ''; ?>>growY</option>
						<option value="scrollUp"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'scrollUp') ? ' selected="selected"' : ''; ?>>scrollUp</option>
						<option value="scrollDown"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'scrollDown') ? ' selected="selected"' : ''; ?>>scrollDown</option>
						<option value="shuffle"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'shuffle') ? ' selected="selected"' : ''; ?>>shuffle</option>
						<option value="blindX"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'blindX') ? ' selected="selected"' : ''; ?>>blindX</option>
						<option value="blindY"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'blindY') ? ' selected="selected"' : ''; ?>>blindY</option>
						<option value="blindZ"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'blindZ') ? ' selected="selected"' : ''; ?>>blindZ</option>
						<option value="cover"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'cover') ? ' selected="selected"' : ''; ?>>cover</option>
						<option value="fadeZoom"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'fadeZoom') ? ' selected="selected"' : ''; ?>>fadeZoom</option>
						<option value="scrollLeft"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'scrollLeft') ? ' selected="selected"' : ''; ?>>scrollLeft</option>
						<option value="scrollRight"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'scrollRight') ? ' selected="selected"' : ''; ?>>scrollRight</option>
						<option value="slideX"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'slideX') ? ' selected="selected"' : ''; ?>>slideX</option>
						<option value="slideY"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'slideY') ? ' selected="selected"' : ''; ?>>slideY</option>
						<option value="toss"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'toss') ? ' selected="selected"' : ''; ?>>toss</option>
						<option value="turnLeft"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'turnLeft') ? ' selected="selected"' : ''; ?>>turnLeft</option>
						<option value="turnRight"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'turnRight') ? ' selected="selected"' : ''; ?>>turnRight</option>
						<option value="uncover"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'uncover') ? ' selected="selected"' : ''; ?>>uncover</option>
						<option value="zoom"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'zoom') ? ' selected="selected"' : ''; ?>>zoom</option>
						<option value="none"<?php echo ($options['c2_transition_type_'.$slide_row_number] == 'none') ? ' selected="selected"' : ''; ?>>none</option>
					    </select>
					</div>
					<div id="c2_slide_link_url_<?php echo $slide_row_number; ?>" class="slide-link" style="padding:10px 5px 0 0; clear:both;">
					    <label for="c2_slide_link_url_<?php echo $slide_row_number; ?>" style="font-weight:bold;"><?php esc_html_e('Link:', 'udesign'); ?> </label>
					    <input name="udesign_options[c2_slide_link_url_<?php echo $slide_row_number; ?>]" type="text" id="c2_slide_link_url_<?php echo $slide_row_number; ?>" value="<?php if ($options['c2_slide_link_url_'.$slide_row_number]){ echo esc_url($options['c2_slide_link_url_'.$slide_row_number]); }?>" size="30" />
					    <label for="c2_slide_link_target_<?php echo $slide_row_number; ?>">
						<?php esc_html_e('Target: ', 'udesign'); ?>
						<select name="udesign_options[c2_slide_link_target_<?php echo $slide_row_number; ?>]" id="c2_slide_link_target_<?php echo $slide_row_number; ?>">
						    <option value="self"<?php echo ($options['c2_slide_link_target_'.$slide_row_number] == 'self') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('self', 'udesign'); ?></option>
						    <option value="blank"<?php echo ($options['c2_slide_link_target_'.$slide_row_number] == 'blank') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('blank', 'udesign'); ?></option>
						</select>
					    </label>
                                            <div class="slide-alt-tag" style="display:inline-block;">
                                                <label for="c2_slide_image_alt_tag_<?php echo $slide_row_number; ?>" style="margin-left:10px;"><?php esc_html_e('Alt Tag:', 'udesign'); ?> </label> 
                                                <input name="udesign_options[c2_slide_image_alt_tag_<?php echo $slide_row_number; ?>]" type="text" id="c2_slide_image_alt_tag_<?php echo $slide_row_number; ?>" value="<?php echo esc_attr($options['c2_slide_image_alt_tag_'.$slide_row_number]); ?>" size="20" />
                                            </div>
					</div>
					<div class="slide-info-text" style="padding:10px 5px 0 0; width:60%; float:left; display:inline;">
					    <strong><?php esc_html_e('Slide text', 'udesign'); ?></strong> <span class="description" style="margin:20px 0;"><?php esc_html_e('(You could use text and/or html)', 'udesign'); ?></span>:<br />
					    <textarea name="udesign_options[c2_slide_default_info_txt_<?php echo $slide_row_number; ?>]" class="code"
							style="width:97%; font-size:12px; margin: 5px 0;" id="c2_slide_default_info_txt_<?php echo $slide_row_number; ?>"
							rows="4" cols="60"><?php echo ( $options['c2_slide_default_info_txt_'.$slide_row_number] ) ? esc_attr($options['c2_slide_default_info_txt_'.$slide_row_number]) : ''; ?></textarea>
					</div>
					<div class="slide-button" style="padding-top:10px; float:left; display:inline; width:35%">
					    <label for="c2_slide_button_txt_<?php echo $slide_row_number; ?>" class="slide-button-text" style="font-weight:bold;"><?php esc_html_e('Button Text:', 'udesign'); ?> </label><br />
					    <input name="udesign_options[c2_slide_button_txt_<?php echo $slide_row_number; ?>]" type="text" id="c2_slide_button_txt_<?php echo $slide_row_number; ?>" value="<?php echo esc_attr($options['c2_slide_button_txt_'.$slide_row_number]); ?>" size="20" /><br />
					    <label for="c2_slide_button_style_<?php echo $slide_row_number; ?>" class="slide-button-style" style="margin-top:5px;font-weight:bold; float:left;"><?php esc_html_e('Button Style: ', 'udesign'); ?>
						<select name="udesign_options[c2_slide_button_style_<?php echo $slide_row_number; ?>]" id="c2_slide_button_style_<?php echo $slide_row_number; ?>">
						    <option value="dark"<?php echo ($options['c2_slide_button_style_'.$slide_row_number] == 'dark') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('Dark', 'udesign'); ?></option>
						    <option value="light"<?php echo ($options['c2_slide_button_style_'.$slide_row_number] == 'light') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Light', 'udesign'); ?></option>
						</select>
					    </label><br />
					    <span class="description" style="float:left;padding:5px; display:block; line-height:1.4; font-size:12px;"><?php _e('The button is activated only if a <strong>Link</strong> is provided. To remove the button just replace the link with a single space.', 'udesign'); ?></span>
					</div>
				    </td>
				</tr>
    <?php		    endforeach; ?>
			</tbody>
		    </table>
		    <table id="c2-clone-table" style="display:none;">
			<tbody>
			    <tr id="999" class="row-style">
				<td class="dragHandle showDragHandle" style="width:30px; padding:15px 20px;">&nbsp;</td>
				<td class="deleteSlide" style="margin:10px 10px; width:30px; padding:5px 15px;">&nbsp;</td>
				<td class="position" style="padding:15px 20px; width:40px; font-weight:bold; font-size:20px; text-align:center; height:110px">999</td>
				<td style="padding:10px 10px 10px 20px; width:100%" valign="top">
				    <div class="c2_slide_img_url" style="padding:7px 5px 0 0; float:left; display:inline;">
                                        <label style="font-weight:bold;" for="c2_slide_img_url_999"><?php esc_html_e('Image:', 'udesign'); ?></label>
                                        <input class="c2_slide_img_url_field" name="udesign_options[c2_slide_img_url_999]" type="text" id="c2_slide_img_url_999" value="" size="65" />
                                        <input id="c2_slide_upload_button_999" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary c2_slide_img_url_btn" />
                                        <a class="info-help" style="margin:0 5px 0 10px;" title="Click the 'Upload Image' button. Once you've selected or uploaded an image (see documentation for proper dimensions), look for the 'Insert into Post' button and click it.">HELP</a>
				    </div>
				    <div class="transition-type" style="padding:10px 5px 0 0; clear:both;">
					<strong><?php esc_html_e('Transition:', 'udesign'); ?></strong>
					<select name="udesign_options[c2_transition_type_999]" id="c2_transition_type_999">
					    <option value="fade" selected="selected">fade</option>
					    <option value="curtainX">curtainX</option>
					    <option value="curtainY">curtainY</option>
					    <option value="turnUp">turnUp</option>
					    <option value="turnDown">turnDown</option>
					    <option value="wipe">wipe</option>
					    <option value="scrollHorz">scrollHorz</option>
					    <option value="scrollVert">scrollVert</option>
					    <option value="growX">growX</option>
					    <option value="growY">growY</option>
					    <option value="scrollUp">scrollUp</option>
					    <option value="scrollDown">scrollDown</option>
					    <option value="shuffle">shuffle</option>
					    <option value="blindX">blindX</option>
					    <option value="blindY">blindY</option>
					    <option value="blindZ">blindZ</option>
					    <option value="cover">cover</option>
					    <option value="fadeZoom">fadeZoom</option>
					    <option value="scrollLeft">scrollLeft</option>
					    <option value="scrollRight">scrollRight</option>
					    <option value="slideX">slideX</option>
					    <option value="slideY">slideY</option>
					    <option value="toss">toss</option>
					    <option value="turnLeft">turnLeft</option>
					    <option value="turnRight">turnRight</option>
					    <option value="uncover">uncover</option>
					    <option value="zoom">zoom</option>
					    <option value="none">none</option>
					</select>
				    </div>
				    <div id="c2_slide_link_url_999" class="slide-link" style="padding:10px 5px 0 0; clear:both;">
					<label for="c2_slide_link_url_999" class="link-url" style="font-weight:bold;"><?php esc_html_e('Link:', 'udesign'); ?> </label>
					<input name="udesign_options[c2_slide_link_url_999]" type="text" id="c2_slide_link_url_999" value="" size="30" />
					<label for="c2_slide_link_target_999" class="link-target">
						<?php esc_html_e('Target: ', 'udesign'); ?>
						<select name="udesign_options[c2_slide_link_target_999]" id="c2_slide_link_target_999">
						    <option value="self" selected="selected"><?php esc_attr_e('self', 'udesign'); ?></option>
						    <option value="blank"><?php esc_attr_e('blank', 'udesign'); ?></option>
						</select>
					</label>
                                        <div class="slide-alt-tag" style="display:inline-block;">
                                            <label for="c2_slide_image_alt_tag_999" style="margin-left:10px;"><?php esc_html_e('Alt Tag:', 'udesign'); ?> </label>
                                            <input name="udesign_options[c2_slide_image_alt_tag_999]" type="text" id="c2_slide_image_alt_tag_999" value="" size="20" />
                                        </div>
				    </div>
				    <div class="slide-info-text" style="padding:10px 5px 0 0; width:60%; float:left; display:inline;">
					<strong><?php esc_html_e('Slide text', 'udesign'); ?></strong> <span class="description" style="margin:20px 0;"><?php esc_html_e('(You could use text and/or html)', 'udesign'); ?></span>:<br />
					<textarea name="udesign_options[c2_slide_default_info_txt_999]" class="code"
						    style="width:97%; font-size:12px; margin: 5px 0;" id="c2_slide_default_info_txt_999"
						    rows="4" cols="60"><?php echo get_c2_slide_default_info_txt(); ?></textarea>
				    </div>
				    <div class="slide-button" style="padding-top:10px; float:left; display:inline; width:35%">
					<label for="c2_slide_button_txt_999" class="slide-button-text" style="font-weight:bold;"><?php esc_html_e('Button Text:', 'udesign'); ?> </label><br />
					<input name="udesign_options[c2_slide_button_txt_999]" type="text" id="c2_slide_button_txt_999" value="<?php echo esc_attr($options['c2_slide_button_txt_1']); ?>" size="20" /><br />
					<label for="c2_slide_button_style_999" class="slide-button-style" style="margin-top:5px;font-weight:bold; float:left;"><?php esc_html_e('Button Style: ', 'udesign'); ?>
					    <select name="udesign_options[c2_slide_button_style_999]" id="c2_slide_button_style_999">
						<option value="dark" selected="selected" style="padding-right:10px;"><?php esc_attr_e('Dark', 'udesign'); ?></option>
						<option value="light"><?php esc_attr_e('Light', 'udesign'); ?></option>
					    </select>
					</label><br />
					<span class="description" style="float:left; padding:5px; display:block; line-height:17px;"><?php _e('The button is activated only if a <strong>Link</strong> is provided. To remove the button just replace the link with a single space.', 'udesign'); ?></span>
				    </div>
				</td>
			    </tr>
			</tbody>
		    </table>

<?php		elseif ( $current_slider == '6' ) :
		    $c3_slides_order_str = $options['c3_slides_order_str'];
		    $c3_slides_array = explode( ',', $options['c3_slides_order_str'] );
		    $c3_timeout = $options['c3_timeout'];
		    $c3_text_color = $options['c3_text_color'];  ?>
		    <!-- Add invisible fields from the other sliders' forms to preserve their state. (this is only necessary for checkboxes and some text fields)  -->
		    <input style="display:none;" name="udesign_options[c1_sync]" type="checkbox" id="c1_sync" value="yes" <?php checked('yes', $options['c1_sync']); ?> />
		    <input style="display:none;" name="udesign_options[c1_remove_image_frame]" type="checkbox" id="c1_remove_image_frame" value="yes" <?php checked('yes', $options['c1_remove_image_frame']); ?> />
		    <input style="display:none;" name="udesign_options[c1_remove_3d_shadow]" type="checkbox" id="c1_remove_3d_shadow" value="yes" <?php checked('yes', $options['c1_remove_3d_shadow']); ?> />
		    <input style="display:none;" name="udesign_options[c2_sync]" type="checkbox" id="c2_sync" value="yes" <?php checked('yes', $options['c2_sync']); ?> />
		    <input style="display:none;" name="udesign_options[c2_text_transition_on]" type="checkbox" id="c2_text_transition_on" value="yes" <?php checked('yes', $options['c2_text_transition_on']); ?> />
		    <input name="udesign_options[no_slider_text]" type="hidden" id="no_slider_text" value="<?php if ($options['no_slider_text']) { echo esc_attr($options['no_slider_text']); } ?>" />
		    <input name="udesign_options[rev_slider_shortcode]" type="hidden" id="rev_slider_shortcode" value="<?php if ($options['rev_slider_shortcode']) { echo esc_attr($options['rev_slider_shortcode']); } ?>" />


		    <h2 style="color:#2680AA; margin-top: 2px; padding:20px 10px 0;"><?php esc_html_e('Cycle 3 Slider Settings:', 'udesign'); ?></h2>
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><label for="c3_timeout"><?php esc_html_e('Timeout', 'udesign'); ?></label></th>
				<td>
				    <input name="udesign_options[c3_timeout]" type="text" id="c3_timeout" value="<?php echo esc_attr($c3_timeout); ?>" size="5" maxlength="6" />
				    <span><?php esc_html_e('Milliseconds between slide transitions (0 to disable auto advance).', 'udesign'); ?></span>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Autostop', 'udesign'); ?></th>
				<td>
				    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Autostop', 'udesign'); ?></span></legend>
				    <label for="c3_autostop">
					<input name="udesign_options[c3_autostop]" type="checkbox" id="c3_autostop" value="yes" <?php checked('yes', $options['c3_autostop']); ?> />
					<?php esc_html_e('End slideshow after the last slide.', 'udesign'); ?><br />
				    </label>
				    </fieldset>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Text Size', 'udesign'); ?></th>
				<td>
				    <label for="c3_slider_text_size">
					    <?php esc_html_e('Font Size: ', 'udesign'); ?>
					    <select name="udesign_options[c3_slider_text_size]" id="c3_slider_text_size">
						<option value="1.0"<?php echo ($options['c3_slider_text_size'] == '1.0') ? ' selected="selected"' : ''; ?>>1.0em</option>
						<option value="1.1"<?php echo ($options['c3_slider_text_size'] == '1.1') ? ' selected="selected"' : ''; ?>>1.1em</option>
						<option value="1.2"<?php echo ($options['c3_slider_text_size'] == '1.2') ? ' selected="selected"' : ''; ?> style="padding-right:7px;">1.2em (Default)</option>
						<option value="1.3"<?php echo ($options['c3_slider_text_size'] == '1.3') ? ' selected="selected"' : ''; ?>>1.3em</option>
						<option value="1.4"<?php echo ($options['c3_slider_text_size'] == '1.4') ? ' selected="selected"' : ''; ?>>1.4em</option>
						<option value="1.5"<?php echo ($options['c3_slider_text_size'] == '1.5') ? ' selected="selected"' : ''; ?>>1.5em</option>
						<option value="1.6"<?php echo ($options['c3_slider_text_size'] == '1.6') ? ' selected="selected"' : ''; ?>>1.6em</option>
						<option value="1.7"<?php echo ($options['c3_slider_text_size'] == '1.7') ? ' selected="selected"' : ''; ?>>1.7em</option>
						<option value="1.8"<?php echo ($options['c3_slider_text_size'] == '1.8') ? ' selected="selected"' : ''; ?>>1.8em</option>
						<option value="1.9"<?php echo ($options['c3_slider_text_size'] == '1.9') ? ' selected="selected"' : ''; ?>>1.9em</option>
						<option value="2.0"<?php echo ($options['c3_slider_text_size'] == '2.0') ? ' selected="selected"' : ''; ?>>2.0em</option>
					    </select>
				    </label>
				    <br />
				    <?php esc_html_e('When using "em" you are specifying size relative to the general font size.', 'udesign'); ?>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Text Line Height', 'udesign'); ?></th>
				<td>
				    <label for="c3_slider_text_line_height">
					    <?php esc_html_e('Line Height: ', 'udesign'); ?>
					    <select name="udesign_options[c3_slider_text_line_height]" id="c3_slider_text_line_height">
						<option value="0.5"<?php echo ($options['c3_slider_text_line_height'] == '0.5') ? ' selected="selected"' : ''; ?>>0.5</option>
						<option value="0.6"<?php echo ($options['c3_slider_text_line_height'] == '0.6') ? ' selected="selected"' : ''; ?>>0.6</option>
						<option value="0.7"<?php echo ($options['c3_slider_text_line_height'] == '0.7') ? ' selected="selected"' : ''; ?>>0.7</option>
						<option value="0.8"<?php echo ($options['c3_slider_text_line_height'] == '0.8') ? ' selected="selected"' : ''; ?>>0.8</option>
						<option value="0.9"<?php echo ($options['c3_slider_text_line_height'] == '0.9') ? ' selected="selected"' : ''; ?>>0.9</option>
						<option value="1.0"<?php echo ($options['c3_slider_text_line_height'] == '1.0') ? ' selected="selected"' : ''; ?>>1.0</option>
						<option value="1.1"<?php echo ($options['c3_slider_text_line_height'] == '1.1') ? ' selected="selected"' : ''; ?>>1.1</option>
						<option value="1.2"<?php echo ($options['c3_slider_text_line_height'] == '1.2') ? ' selected="selected"' : ''; ?>>1.2</option>
						<option value="1.3"<?php echo ($options['c3_slider_text_line_height'] == '1.3') ? ' selected="selected"' : ''; ?>>1.3</option>
						<option value="1.4"<?php echo ($options['c3_slider_text_line_height'] == '1.4') ? ' selected="selected"' : ''; ?>>1.4</option>
						<option value="1.5"<?php echo ($options['c3_slider_text_line_height'] == '1.5') ? ' selected="selected"' : ''; ?>>1.5</option>
						<option value="1.6"<?php echo ($options['c3_slider_text_line_height'] == '1.6') ? ' selected="selected"' : ''; ?>>1.6</option>
						<option value="1.7"<?php echo ($options['c3_slider_text_line_height'] == '1.7') ? ' selected="selected"' : ''; ?> style="padding-right:7px;">1.7 (Default)</option>
						<option value="1.8"<?php echo ($options['c3_slider_text_line_height'] == '1.8') ? ' selected="selected"' : ''; ?>>1.8</option>
						<option value="1.9"<?php echo ($options['c3_slider_text_line_height'] == '1.9') ? ' selected="selected"' : ''; ?>>1.9</option>
						<option value="2.0"<?php echo ($options['c3_slider_text_line_height'] == '2.0') ? ' selected="selected"' : ''; ?>>2.0</option>
						<option value="2.1"<?php echo ($options['c3_slider_text_line_height'] == '2.1') ? ' selected="selected"' : ''; ?>>2.1</option>
						<option value="2.2"<?php echo ($options['c3_slider_text_line_height'] == '2.2') ? ' selected="selected"' : ''; ?>>2.2</option>
						<option value="2.3"<?php echo ($options['c3_slider_text_line_height'] == '2.3') ? ' selected="selected"' : ''; ?>>2.3</option>
						<option value="2.4"<?php echo ($options['c3_slider_text_line_height'] == '2.4') ? ' selected="selected"' : ''; ?>>2.4</option>
						<option value="2.5"<?php echo ($options['c3_slider_text_line_height'] == '2.5') ? ' selected="selected"' : ''; ?>>2.5</option>
						<option value="2.6"<?php echo ($options['c3_slider_text_line_height'] == '2.6') ? ' selected="selected"' : ''; ?>>2.6</option>
					    </select>
				    </label>
				</td>
			    </tr>
			</tbody>
		    </table>

		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Text Color', 'udesign'); ?></th>
				<td style="width:37px; padding:4px 4px">
				    <div id="c3-colorSelector1">
					<div style="background-color: #<?php echo ($c3_text_color) ? esc_attr($c3_text_color) : 'FFFFFF'; ?>;"></div>
				    </div>
				</td>
				<td>
				    <input name="udesign_options[c3_text_color]" id="c3_text_color" type="text" maxlength="6" size="6" style="margin:2px 10px 0 0" value="<?php echo ($c3_text_color) ? esc_attr($c3_text_color) : 'FFFFFF'; ?>" />
				    <?php esc_html_e('Slider text color.', 'udesign'); ?>
				</td>
			    </tr>
			</tbody>
		    </table>
		    <?php display_save_changes_button(); ?>


		    <input name="udesign_options[c3_slides_order_str]" type="hidden" id="c3_slides_order_str" value="<?php if ($c3_slides_order_str){ echo esc_attr($c3_slides_order_str); }?>" />
		    <div class="add-row" style></div>
		    <table id="c3-table-slides" class="c3-table-slides">
			<tbody>
    <?php		    foreach( $c3_slides_array as $position=>$slide_row_number ) : ?>
				<tr id="<?php echo $slide_row_number; ?>" class="row-style">
				    <td class="dragHandle showDragHandle" style="width:30px; padding:15px 20px;">&nbsp;</td>
				    <td class="deleteSlide" style="margin:10px 10px; width:30px; padding:5px 15px;">&nbsp;</td>
				    <td class="position" style="padding:15px 20px; width:40px; font-weight:bold; font-size:20px; text-align:center; height:110px"><?php echo $position+1; ?></td>
				    <td style="padding:10px 10px 10px 20px; width:100%" valign="top">
					<div class="c3_slide_img_url" style="padding:7px 5px 0 0; float:left; display:inline;">
                                            <label style="font-weight:bold;" for="c3_slide_img_url_<?php echo $slide_row_number; ?>"><?php esc_html_e('Image:', 'udesign'); ?></label>
                                            <input class="c3_slide_img_url_field" name="udesign_options[c3_slide_img_url_<?php echo $slide_row_number; ?>]" type="text" id="c3_slide_img_url_<?php echo $slide_row_number; ?>" value="<?php if ($options['c3_slide_img_url_'.$slide_row_number]){ echo esc_url($options['c3_slide_img_url_'.$slide_row_number]); }?>" size="65" />
                                            <input id="c3_slide_upload_button_<?php echo $slide_row_number; ?>" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary c3_slide_img_url_btn" />
                                            <a class="info-help" style="margin:0 5px 0 10px;" title="Click the 'Upload Image' button. Once you've selected or uploaded an image (see documentation for proper dimensions), look for the 'Insert into Post' button and click it.">HELP</a>
					</div>
 
					<div id="c3_slide_link_url_<?php echo $slide_row_number; ?>" class="slide-link" style="padding:5px 5px 10px 0; clear:both;">
					    <label for="c3_slide_link_url_<?php echo $slide_row_number; ?>" style="font-weight:bold;"><?php esc_html_e('Image Link:', 'udesign'); ?> </label>
					    <input name="udesign_options[c3_slide_link_url_<?php echo $slide_row_number; ?>]" type="text" id="c3_slide_link_url_<?php echo $slide_row_number; ?>" value="<?php if ($options['c3_slide_link_url_'.$slide_row_number]){ echo esc_url($options['c3_slide_link_url_'.$slide_row_number]); }?>" size="30" />
					    <label for="c3_slide_link_target_<?php echo $slide_row_number; ?>">
						<?php esc_html_e('Target: ', 'udesign'); ?>
						<select name="udesign_options[c3_slide_link_target_<?php echo $slide_row_number; ?>]" id="c3_slide_link_target_<?php echo $slide_row_number; ?>">
						    <option value="self"<?php echo ($options['c3_slide_link_target_'.$slide_row_number] == 'self') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('self', 'udesign'); ?></option>
						    <option value="blank"<?php echo ($options['c3_slide_link_target_'.$slide_row_number] == 'blank') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('blank', 'udesign'); ?></option>
						</select>
					    </label>
                                            <div class="slide-alt-tag" style="display:inline-block;">
                                                <label for="c3_slide_image_alt_tag_<?php echo $slide_row_number; ?>" style="margin-left:10px;"><?php esc_html_e('Alt Tag:', 'udesign'); ?> </label> 
                                                <input name="udesign_options[c3_slide_image_alt_tag_<?php echo $slide_row_number; ?>]" type="text" id="c3_slide_image_alt_tag_<?php echo $slide_row_number; ?>" value="<?php echo esc_attr($options['c3_slide_image_alt_tag_'.$slide_row_number]); ?>" size="20" />
                                            </div>
                                            <div><span style="line-height: 1.5; font-size: 12px;" class="description" style="margin:5px 0;float:left;"><?php esc_html_e('(To clear a text field above, replace it with a single space)', 'udesign'); ?></span></div>
					</div>

                                        <div class="c3_slide_img2_url" style="padding:10px 5px 0 0; float:left; display:inline; clear:left;">
                                            <label style="font-weight:bold;" for="c3_slide_img2_url_<?php echo $slide_row_number; ?>"><?php esc_html_e('Image 2:', 'udesign'); ?></label>
                                            <input class="c3_slide_img2_url_field" name="udesign_options[c3_slide_img2_url_<?php echo $slide_row_number; ?>]" type="text" id="c3_slide_img2_url_<?php echo $slide_row_number; ?>" value="<?php if ($options['c3_slide_img2_url_'.$slide_row_number]){ echo esc_url($options['c3_slide_img2_url_'.$slide_row_number]); }?>" size="65" />
                                            <input id="c3_slide_upload_button2_<?php echo $slide_row_number; ?>" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary c3_slide_img2_url_btn" />
                                            <a class="info-help" style="margin:0 5px 0 10px;" title="Click the 'Upload Image' button. Once you've selected or uploaded an image (see documentation for proper dimensions), look for the 'Insert into Post' button and click it.">HELP</a>
					</div>
                                        
					<div class="slide-info-text" style="padding:10px 5px 0 0; width:100%; float:left; clear:both;">
					    <strong><?php esc_html_e('Slide text', 'udesign'); ?></strong> <span class="description" style="margin:20px 0;"><?php esc_html_e('(You could use text and/or html)', 'udesign'); ?></span>:<br />
					    <textarea name="udesign_options[c3_slide_default_info_txt_<?php echo $slide_row_number; ?>]" class="code"
							style="float:left; width:70%; display:inline; font-size:12px; margin: 5px 0;" id="c3_slide_default_info_txt_<?php echo $slide_row_number; ?>"
							rows="3" cols="70"><?php echo ( $options['c3_slide_default_info_txt_'.$slide_row_number] ) ? esc_attr($options['c3_slide_default_info_txt_'.$slide_row_number]) : ''; ?></textarea>
					</div>
				    </td>
				</tr>
    <?php		    endforeach; ?>
			</tbody>
		    </table>
		    <table id="c3-clone-table" style="display:none;">
			<tbody>
			    <tr id="999" class="row-style">
				<td class="dragHandle showDragHandle" style="width:30px; padding:15px 20px;">&nbsp;</td>
				<td class="deleteSlide" style="margin:10px 10px; width:30px; padding:5px 15px;">&nbsp;</td>
				<td class="position" style="padding:15px 20px; width:40px; font-weight:bold; font-size:20px; text-align:center; height:110px">999</td>
				<td style="padding:10px 10px 10px 20px; width:100%" valign="top">
				    <div class="c3_slide_img_url" style="padding:7px 5px 0 0; float:left; display:inline;">
                                        <label style="font-weight:bold;" for="c3_slide_img_url_999"><?php esc_html_e('Image:', 'udesign'); ?></label>
                                        <input class="c3_slide_img_url_field" name="udesign_options[c3_slide_img_url_999]" type="text" id="c3_slide_img_url_999" value="" size="65" />
                                        <input id="c3_slide_upload_button_999" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary c3_slide_img_url_btn" />
                                        <a class="info-help" style="margin:0 5px 0 10px;" title="Click the 'Upload Image' button. Once you've selected or uploaded an image (see documentation for proper dimensions), look for the 'Insert into Post' button and click it.">HELP</a>
				    </div>
                                    
				    <div id="c3_slide_link_url_999" class="slide-link" style="padding:5px 5px 10px 0; clear:both;">
					<label for="c3_slide_link_url_999" class="link-url" style="font-weight:bold;"><?php esc_html_e('Image Link:', 'udesign'); ?> </label>
					<input name="udesign_options[c3_slide_link_url_999]" type="text" id="c3_slide_link_url_999" value="" size="30" />
					<label for="c3_slide_link_target_999" class="link-target">
						<?php esc_html_e('Target: ', 'udesign'); ?>
						<select name="udesign_options[c3_slide_link_target_999]" id="c3_slide_link_target_999">
						    <option value="self" selected="selected"><?php esc_attr_e('self', 'udesign'); ?></option>
						    <option value="blank"><?php esc_attr_e('blank', 'udesign'); ?></option>
						</select>
					</label>
                                        <div class="slide-alt-tag" style="display:inline-block;">
                                            <label for="c3_slide_image_alt_tag_999" style="margin-left:10px;"><?php esc_html_e('Alt Tag:', 'udesign'); ?> </label>
                                            <input name="udesign_options[c3_slide_image_alt_tag_999]" type="text" id="c3_slide_image_alt_tag_999" value="" size="20" />
                                        </div>
                                        <div><span style="line-height: 1.5; font-size: 12px;" class="description" style="margin:5px 0;float:left;"><?php esc_html_e('(To clear a text field above, replace it with a single space)', 'udesign'); ?></span></div>
				    </div>
                                    
                                    <div class="c3_slide_img2_url" style="padding:10px 5px 0 0; float:left; display:inline; clear:left;">
                                        <label style="font-weight:bold;" for="c3_slide_img2_url_999"><?php esc_html_e('Image 2:', 'udesign'); ?></label>
                                        <input class="c3_slide_img2_url_field" name="udesign_options[c3_slide_img2_url_999]" type="text" id="c3_slide_img2_url_999" value="" size="65" />
                                        <input id="c3_slide_upload_button2_999" type="button" value="<?php esc_attr_e('Upload Image', 'udesign'); ?>" class="button-secondary c3_slide_img2_url_btn" />
                                        <a class="info-help" style="margin:0 5px 0 10px;" title="Click the 'Upload Image' button. Once you've selected or uploaded an image (see documentation for proper dimensions), look for the 'Insert into Post' button and click it.">HELP</a>
				    </div>
                                    
				    <div class="slide-info-text" style="padding:10px 5px 0 0; width:100%; float:left; clear:both;">
					<strong><?php esc_html_e('Slide text', 'udesign'); ?></strong> <span class="description" style="margin:20px 0;"><?php esc_html_e('(You could use text and/or html)', 'udesign'); ?></span>:<br />
					<textarea name="udesign_options[c3_slide_default_info_txt_999]" class="code"
						    style="float:left; width:70%; display:inline; font-size:12px; margin: 5px 0;" id="c3_slide_default_info_txt_999"
						    rows="3" cols="70"><?php echo get_c3_slide_default_info_txt(); ?></textarea>
				    </div>
				</td>
			    </tr>
			</tbody>
		    </table>

<?php		elseif ( $current_slider == '7' ) : // No slider 
                    $c1_sync = isset($options['c1_sync']) ? $options['c1_sync'] : '';
                    $c1_remove_image_frame = isset($options['c1_remove_image_frame']) ? $options['c1_remove_image_frame'] : '';
                    $c1_remove_3d_shadow = isset($options['c1_remove_3d_shadow']) ? $options['c1_remove_3d_shadow'] : '';
                    $c2_sync = isset($options['c2_sync']) ? $options['c2_sync'] : '';
                    $c2_text_transition_on = isset($options['c2_text_transition_on']) ? $options['c2_text_transition_on'] : '';
                    $c3_autostop = isset($options['c3_autostop']) ? $options['c3_autostop'] : ''; ?>
		    <!-- Add invisible fields from the other sliders' forms to preserve their state. (this is only necessary for checkboxes and some text fields)  -->
		    <input style="display:none;" name="udesign_options[c1_sync]" type="checkbox" id="c1_sync" value="yes" <?php checked('yes', $c1_sync); ?> />
		    <input style="display:none;" name="udesign_options[c1_remove_image_frame]" type="checkbox" id="c1_remove_image_frame" value="yes" <?php checked('yes', $c1_remove_image_frame); ?> />
		    <input style="display:none;" name="udesign_options[c1_remove_3d_shadow]" type="checkbox" id="c1_remove_3d_shadow" value="yes" <?php checked('yes', $c1_remove_3d_shadow); ?> />
		    <input style="display:none;" name="udesign_options[c2_sync]" type="checkbox" id="c2_sync" value="yes" <?php checked('yes', $c2_sync); ?> />
		    <input style="display:none;" name="udesign_options[c2_text_transition_on]" type="checkbox" id="c2_text_transition_on" value="yes" <?php checked('yes', $c2_text_transition_on); ?> />
		    <input style="display:none;" name="udesign_options[c3_autostop]" type="checkbox" id="c3_autostop" value="yes" <?php checked('yes', $c3_autostop); ?> />
		    <input name="udesign_options[rev_slider_shortcode]" type="hidden" id="rev_slider_shortcode" value="<?php if ($options['rev_slider_shortcode']) { echo esc_attr($options['rev_slider_shortcode']); } ?>" />

		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Title Text', 'udesign'); ?></th>
				<td>
				    <?php esc_html_e('Change the Title:', 'udesign'); ?> <input name="udesign_options[no_slider_text]" type="text" id="no_slider_text" value="<?php if ($options['no_slider_text']) { echo esc_attr($options['no_slider_text']); } ?>" size="35" maxlength="1000" />
				    <br />
				    <span class="description"><?php esc_html_e('This is the title text displayed in the place of the slider on the home page', 'udesign'); ?></span>
				</td>
			    </tr>
			</tbody>
		    </table>

<?php		elseif ( $current_slider == '8' ) : // Revolution Slider 
                    $c1_sync = isset($options['c1_sync']) ? $options['c1_sync'] : '';
                    $c1_remove_image_frame = isset($options['c1_remove_image_frame']) ? $options['c1_remove_image_frame'] : '';
                    $c1_remove_3d_shadow = isset($options['c1_remove_3d_shadow']) ? $options['c1_remove_3d_shadow'] : '';
                    $c2_sync = isset($options['c2_sync']) ? $options['c2_sync'] : '';
                    $c2_text_transition_on = isset($options['c2_text_transition_on']) ? $options['c2_text_transition_on'] : '';
                    $c3_autostop = isset($options['c3_autostop']) ? $options['c3_autostop'] : ''; ?>
		    <!-- Add invisible fields from the other sliders' forms to preserve their state. (this is only necessary for checkboxes and some text fields)  -->
		    <input style="display:none;" name="udesign_options[c1_sync]" type="checkbox" id="c1_sync" value="yes" <?php checked('yes', $c1_sync); ?> />
		    <input style="display:none;" name="udesign_options[c1_remove_image_frame]" type="checkbox" id="c1_remove_image_frame" value="yes" <?php checked('yes', $c1_remove_image_frame); ?> />
		    <input style="display:none;" name="udesign_options[c1_remove_3d_shadow]" type="checkbox" id="c1_remove_3d_shadow" value="yes" <?php checked('yes', $c1_remove_3d_shadow); ?> />
		    <input style="display:none;" name="udesign_options[c2_sync]" type="checkbox" id="c2_sync" value="yes" <?php checked('yes', $c2_sync); ?> />
		    <input style="display:none;" name="udesign_options[c2_text_transition_on]" type="checkbox" id="c2_text_transition_on" value="yes" <?php checked('yes', $c2_text_transition_on); ?> />
		    <input style="display:none;" name="udesign_options[c3_autostop]" type="checkbox" id="c3_autostop" value="yes" <?php checked('yes', $c3_autostop); ?> />
		    <input name="udesign_options[no_slider_text]" type="hidden" id="no_slider_text" value="<?php if ($options['no_slider_text']) { echo esc_attr($options['no_slider_text']); } ?>" />

<?php               if ( !is_plugin_active('revslider/revslider.php') ) : ?>
                        <div style="background-color:#FFEBE8; border:1px solid #C00; padding:0 0.8em; margin:10px 0;">
                            <p style="font-weight:bold;"><?php printf( __('You need  to install the "Revolution Slider" first before using this feature. You may install the slider through the %1$sInstall Plugins%2$s section.', 'udesign'), '<a href="admin.php?page=udesign_related_plugins">', '</a>' ); ?></p>
                        </div>
<?php               else : ?>
                        <table class="form-table">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e('Revolution Slider', 'udesign'); ?></th>
                                    <td>
  <?php                                 $slider = new RevSlider();
                                        $arrSliders = $slider->getArrSliders();
                                        if( empty( $arrSliders ) ) : ?>
                                            <div style="background-color:#FFFFE0; border:1px solid #E6DB55; padding:0 0.8em; margin:0;">
                                                <p style="font-weight:bold; margin:7px 0;"><?php  printf( __('No sliders found!  Please create a new slider from the %1$sRevolution Slider%2$s page.', 'udesign'), '<a href="admin.php?page=revslider">', '</a>' ); ?></p>
                                            </div>
<?php                                   else : ?>
                                            <label for="current_rev_slider"><?php esc_html_e('Choose a Revolution Slider:', 'udesign'); ?></label>
                                            <select name="udesign_options[rev_slider_shortcode]" id="current_rev_slider">
                                                    <option value=""<?php echo ($options['rev_slider_shortcode'] == '') ? ' selected="selected"' : ''; ?>><?php esc_html_e('--Select Slider--', 'udesign'); ?></option> 
<?php                                           foreach( $arrSliders as $slider ): ?>
                                                    <option value='<?php esc_attr_e( $slider->getShortcode() ); ?>'<?php echo ($slider->getShortcode() == $options['rev_slider_shortcode']) ? ' selected="selected"' : ''; ?>><?php echo $slider->getTitle(); ?></option> 
<?php                                           endforeach; ?>
                                            </select><br />
                                            <span class="description"><?php  printf( __('To create additional sliders or to configure the existing ones please refer to the %1$sRevolution Slider%2$s page.', 'udesign'), '<a title="'.esc_html__('Go to Revolution Slider page', 'udesign').'" href="admin.php?page=revslider">', '</a>' ); ?></span><br />
                                            <span class="description"><?php  printf( __('For help please refer to the %1$sDocumentation%2$s.', 'udesign'), '<a title="'.esc_html__('Go to the Documentation', 'udesign').'" target="_blank" href="'.get_template_directory_uri().'/scripts/documentation/index.html#revslider-description">', '</a>' ); ?></span>
                                            <div class="clear"></div>
<?php                                   endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
<?php               endif; ?>
    
<?php		endif;
		display_save_changes_button();
	}

	function portfolio_section_options_contentbox( $options ) {
		global $portfolio_pages_array;
		$portfolio_title_posistion = $options['portfolio_title_posistion'];
		$portfolio_sidebar = $options['portfolio_sidebar']; ?>
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Portfolio Pages', 'udesign'); ?></th>
			    <td>
				<?php esc_html_e('Use this area to assign Portfolio Categories to their respective Portfolio pages.', 'udesign'); ?><br />
				<?php esc_html_e('Firstly though, you have to create the Portfolio page(s) and assign the "Portfolio page" template to it.', 'udesign'); ?><br />
				<?php esc_html_e("If you don't see any categories in the dropdown(s) below it's because you haven't created any yet, in that case go to 'Posts &rarr; Categories' and create a 'Portfolio' category there. Also don't forget to save all your Portfolio related Posts and sub categories under that category.", 'udesign'); ?><br />
<?php				foreach ($portfolio_pages_array as $portfolio_page_obj) :
				    $port_page_ID = $portfolio_page_obj->ID; ?>
				    <div style="margin-bottom:10px; float:left; background-color:#FCFCFC; padding:7px; border:1px solid #ddd;">
                                        <div style="margin-bottom:10px; float:left;">
                                            <?php esc_html_e('To Portfolio page', 'udesign'); ?> <strong><?php echo $portfolio_page_obj->post_title; ?></strong> (page ID: <strong><?php echo $port_page_ID; ?></strong>) <br />
                                            <?php esc_html_e('assign the Category:', 'udesign'); ?> <?php wp_dropdown_categories("show_option_all=".esc_html__('Select Category', 'udesign')."&hierarchical=1&orderby=name&selected={$options['portfolio_cat_for_page_'.$port_page_ID]}&name=udesign_options[portfolio_cat_for_page_{$port_page_ID}]&class=postform"); ?><br />
                                            <?php esc_html_e('with', 'udesign'); ?> <input name="udesign_options[portfolio_items_per_page_for_page_<?php echo $port_page_ID ?>]" type="text" id="portfolio_items_per_page_for_page_<?php echo $port_page_ID ?>" value="<?php echo ($options['portfolio_items_per_page_for_page_'.$port_page_ID]) ? esc_attr($options['portfolio_items_per_page_for_page_'.$port_page_ID]) : '6'; ?>" size="5" maxlength="5" /> <?php esc_html_e('items per page.', 'udesign'); ?><br />
                                        </div>
                                        <div style="float:left; clear:left;">
                                            <label for="portfolio_do_not_link_adjacent_items_<?php echo $port_page_ID ?>">
                                                <input name="udesign_options[portfolio_do_not_link_adjacent_items_<?php echo $port_page_ID ?>]" type="checkbox" id="portfolio_do_not_link_adjacent_items_<?php echo $port_page_ID ?>" value="yes" <?php checked('yes', $options['portfolio_do_not_link_adjacent_items_'.$port_page_ID]); ?> />&nbsp;
                                                <strong><?php esc_html_e('Do not link adjacent items in this category as gallery.', 'udesign'); ?></strong>
                                            </label> 
                                            <span class="description"><?php esc_html_e('(Remove the ability to go to the next or previous item when previewing with prettyPhoto lightbox)', 'udesign'); ?></span>
                                        </div>
				    </div>
<?php				endforeach; ?>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Portfolio Title Position', 'udesign'); ?></th>
			    <td>
				<?php esc_html_e('Choose position:', 'udesign'); ?><br />
				<label><input type="radio" name="udesign_options[portfolio_title_posistion]" id="portfolio_title_posistion_below" value="below" <?php checked('below', $portfolio_title_posistion); ?> /> <?php esc_html_e('Below', 'udesign'); ?></label>&nbsp;&nbsp;
				<label><input type="radio" name="udesign_options[portfolio_title_posistion]" id="portfolio_title_posistion_above" value="above" <?php checked('above', $portfolio_title_posistion); ?> /> <?php esc_html_e('Above', 'udesign'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="description"><?php esc_html_e('This is the post title shown with every thumbnail. Choose whether you would like to have it displayed above the Thumbnail or just below it.', 'udesign'); ?></span>
			    </td>
			</tr>
		    </tbody>
		</table>

		<div style="background-color:#FCFCFC; border:1px solid #DDDDDD; margin-bottom:5px; padding-bottom:15px;">
		    <p style="padding:10px 5px;"><?php esc_html_e('The following settings refer to the individual portfolio item post (single post view)', 'udesign'); ?></p>
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Sidebar Position', 'udesign'); ?></th>
				<td>
				    <?php esc_html_e('Choose position:', 'udesign'); ?><br />
				    <label><input type="radio" name="udesign_options[portfolio_sidebar]" id="portfolio_sidebar_left" value="left" <?php checked('left', $portfolio_sidebar); ?> /> <?php esc_html_e('Left', 'udesign'); ?></label>&nbsp;&nbsp;
				    <label><input type="radio" name="udesign_options[portfolio_sidebar]" id="portfolio_sidebar_right" value="right" <?php checked('right', $portfolio_sidebar); ?> /> <?php esc_html_e('Right', 'udesign'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				    <span class="description"><?php esc_html_e("This is the sidebar shown on individual portfolio items' posts", 'udesign'); ?></span>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Portfolio Postmetadata', 'udesign'); ?></th>
				<td>
				    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Portfolio Postmetadata', 'udesign'); ?></span></legend>
				    <label for="show_portfolio_postmetadata">
					<input name="udesign_options[show_portfolio_postmetadata]" type="checkbox" id="show_portfolio_postmetadata" value="yes" <?php checked('yes', $options['show_portfolio_postmetadata']); ?> />
					<?php esc_html_e('Show Portfolio Post Metadata box (Single View).', 'udesign'); ?><br />
					<span class="description"><?php esc_html_e('This is the info block containing the information about Author, Date, Categories, Comments in a single view portfolio post.', 'udesign'); ?></span>
				    </label>
				    </fieldset>
				</td>
			    </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Portfolio Postmetadata Location', 'udesign'); ?></th>
                                <td>
                                    <label for="udesign_single_portfolio_postmetadata_location" class="link-target">
                                            <?php esc_html_e('Choose Location: ', 'udesign'); ?>
                                            <select name="udesign_options[udesign_single_portfolio_postmetadata_location]" id="udesign_single_portfolio_postmetadata_location">
                                                <option value="alignbottom"<?php echo ($options['udesign_single_portfolio_postmetadata_location'] == 'alignbottom') ? ' selected="selected"' : ''; ?> style="min-width:70px;"><?php esc_attr_e('Bottom', 'udesign'); ?></option>
                                                <option value="aligntop"<?php echo ($options['udesign_single_portfolio_postmetadata_location'] == 'aligntop') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Top', 'udesign'); ?></option>
                                            </select>
                                            <?php esc_html_e('This is the location of the block containing the information about Author, Date, Categories, Comments in a single view portfolio post.', 'udesign'); ?><br />
                                    </label>
                                </td>
                            </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Portfolio Post Author', 'udesign'); ?></th>
				<td>
				    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Portfolio Post Author', 'udesign'); ?></span></legend>
				    <label for="show_portfolio_postmetadata_author">
					<input name="udesign_options[show_portfolio_postmetadata_author]" type="checkbox" id="show_portfolio_postmetadata_author" value="yes" <?php checked('yes', $options['show_portfolio_postmetadata_author']); ?> />
					<?php esc_html_e('Show Author Name ("Portfolio Post Metadata" needs to be enabled for this option)', 'udesign'); ?><br />
					<span class="description"><?php printf( __('The following text: "Written by: Author Name" will be added to the postmetadata box. The author\'s name will be displayed as specified under %1$sUsers %2$s Your Profile%3$s <strong>Display name publicly as</strong> field and linking it to the author\'s page.', 'udesign'), '<a title="'.esc_html__('Go to your Profile', 'udesign').'" href="profile.php">', '&rarr;', '</a>' ); ?></span>
				    </label>
				    </fieldset>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Portfolio Post Tags', 'udesign'); ?></th>
				<td>
				    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Portfolio Post Tags', 'udesign'); ?></span></legend>
				    <label for="show_portfolio_postmetadata_tags">
					<input name="udesign_options[show_portfolio_postmetadata_tags]" type="checkbox" id="show_portfolio_postmetadata_tags" value="yes" <?php checked('yes', $options['show_portfolio_postmetadata_tags']); ?> />
					<?php esc_html_e('Show Portfolio Post Tags', 'udesign'); ?><br />
				    </label>
				    </fieldset>
				</td>
			    </tr>
			    <tr valign="top">
				<th scope="row"><?php esc_html_e('Show Comment Area', 'udesign'); ?></th>
				<td>
				    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Show Comment Area', 'udesign'); ?></span></legend>
				    <label for="show_portfolio_comments">
					<input name="udesign_options[show_portfolio_comments]" type="checkbox" id="show_portfolio_comments" value="yes" <?php checked('yes', $options['show_portfolio_comments']); ?> />
					<?php esc_html_e('Show comment area in portfolio posts (Single View)', 'udesign'); ?>
				    </label>
				    </fieldset>
				</td>
			    </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Full-width Single Post View Page', 'udesign'); ?></th>
                                <td>
                                    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Full-width Single Post View Page', 'udesign'); ?></span></legend>
                                    <label for="remove_single_portfolio_sidebar">
                                        <input name="udesign_options[remove_single_portfolio_sidebar]" type="checkbox" id="remove_single_portfolio_sidebar" value="yes" <?php checked('yes', $options['remove_single_portfolio_sidebar']); ?> />
                                        <?php esc_html_e('Remove the sidebar from single post view portfolio pages.', 'udesign'); ?><br />
                                    </label>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Single Portfolio Post Navigation Links', 'udesign'); ?></th>
                                <td>
                                    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Single Portfolio Post Navigation Links', 'udesign'); ?></span></legend>
                                    <label for="show_single_portfolio_navigation">
                                        <input name="udesign_options[show_single_portfolio_navigation]" type="checkbox" id="show_single_portfolio_navigation" value="yes" <?php checked('yes', $options['show_single_portfolio_navigation']); ?> />
                                        <?php esc_html_e('Show "Previous" and "Next" navigation links on a single post view portfolio pages.', 'udesign'); ?><br />
                                    </label>
                                    </fieldset>
                                </td>
                            </tr>
			</tbody>
		    </table>
		</div>
<?php		display_save_changes_button(); ?>
<?php	}

	function blog_section_options_contentbox( $options ) {
		$blog_sidebar = $options['blog_sidebar']; ?>
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Sidebar Position', 'udesign'); ?></th>
			    <td><?php  ?>
				<?php esc_html_e('Choose position:', 'udesign'); ?> <br />
				<label><input type="radio" name="udesign_options[blog_sidebar]" id="blog_sidebar_left" value="left" <?php checked('left', $blog_sidebar); ?> /> <?php esc_html_e('Left', 'udesign'); ?></label>&nbsp;&nbsp;
				<label><input type="radio" name="udesign_options[blog_sidebar]" id="blog_sidebar_right" value="right" <?php checked('right', $blog_sidebar); ?> /> <?php esc_html_e('Right', 'udesign'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="description"><?php esc_html_e('This is the sidebar shown on blog pages', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Show Excerpt', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Show Excerpt', 'udesign'); ?></span></legend>
				<label for="show_excerpt">
				    <input name="udesign_options[show_excerpt]" type="checkbox" id="show_excerpt" value="yes" <?php checked('yes', $options['show_excerpt']); ?> />
				    <?php esc_html_e('Show the excerpt instead of the full post content on the Blog page.', 'udesign'); ?>
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><label for="excerpt_length_in_words"><?php esc_html_e('Excerpt Length', 'udesign'); ?></label></th>
			    <td>
				<?php esc_html_e('Change the excerpt length:', 'udesign'); ?> <input name="udesign_options[excerpt_length_in_words]" type="text" id="excerpt_length_in_words" value="<?php echo esc_attr( $options['excerpt_length_in_words'] ); ?>" size="5" maxlength="5" /> 
				<span class="description"><?php esc_html_e('This number refers to the number of words to show.', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('"Read more" Link', 'udesign'); ?></th>
			    <td>
				<input name="udesign_options[blog_button_text]" type="text" id="blog_button_text" value="<?php if ($options['blog_button_text']) { echo esc_attr($options['blog_button_text']); } ?>" size="30" maxlength="100" />
				<?php esc_html_e("Enter the text for the post's 'Read more' link.  Leave blank to hide it.", 'udesign'); ?>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Exclude Portfolio(s) from Blog', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Exclude Portfolio(s) from Blog', 'udesign'); ?></span></legend>
				<label for="exclude_portfolio_from_blog">
				    <input name="udesign_options[exclude_portfolio_from_blog]" type="checkbox" id="exclude_portfolio_from_blog" value="yes" <?php checked('yes', $options['exclude_portfolio_from_blog']); ?> />
				    <?php esc_html_e('Exclude portfolio categories and posts from the blog and archive pages.', 'udesign'); ?><br />
				    <span class="description"><?php esc_html_e('Note: If a portfolio category has children categories those will also be excluded although they may not necessarily be assigned a portfolio page template themselves.', 'udesign'); ?></span>
				</label>
				</fieldset>
                                <strong><?php esc_html_e('Extended exclusion:', 'udesign'); ?></strong>
                                <div class="clear"></div>
                                <div style="margin-left: 20px;">
                                    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Exclude Portfolio Entries from Recent Posts Widget', 'udesign'); ?></span></legend>
                                        <label for="exclude_portfolio_from_recent_posts_widget"><strong><?php esc_html_e('"Recent Posts" Widget : ', 'udesign'); ?></strong>  <br />
                                        <input name="udesign_options[exclude_portfolio_from_recent_posts_widget]" type="checkbox" id="exclude_portfolio_from_recent_posts_widget" value="yes" <?php checked('yes', $options['exclude_portfolio_from_recent_posts_widget']); ?> />
                                        <?php printf( esc_html__('Enabling this option will exlude portfolio related entries from the %sRecent Posts%s widget.', 'udesign'), '<em>', '</em>'); ?>
                                    </label>
                                    </fieldset>
                                    <div class="clear"></div>
                                    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Exclude Portfolio(s) from Archives Widget', 'udesign'); ?></span></legend>
                                        <label for="exclude_portfolio_from_archives_widget"><strong><?php esc_html_e('"Archives" Widget : ', 'udesign'); ?></strong>  <br />
                                        <input name="udesign_options[exclude_portfolio_from_archives_widget]" type="checkbox" id="exclude_portfolio_from_archives_widget" value="yes" <?php checked('yes', $options['exclude_portfolio_from_archives_widget']); ?> />
                                        <?php printf( esc_html__('Enabling this option will exlude portfolio related entries from the %sArchives%s widget.', 'udesign'), '<em>', '</em>'); ?>
                                    </label>
                                    </fieldset>
                                    <div class="clear"></div>
                                    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Exclude Portfolio(s) from Main Query', 'udesign'); ?></span></legend>
                                    <label for="exclude_portfolio_from_main_query"><strong><?php esc_html_e('Main Query : ', 'udesign'); ?></strong> <br />
                                        <input name="udesign_options[exclude_portfolio_from_main_query]" type="checkbox" id="exclude_portfolio_from_main_query" value="yes" <?php checked('yes', $options['exclude_portfolio_from_main_query']); ?> />
                                        <?php printf( esc_html__('Enabling this option will exlude portfolio categories and posts from the %1$sWordPress Main Query%2$s (note that the %1$sRecent Posts%2$s widget will also be affected).', 'udesign'), 
                                                '<em>', '</em>'); ?>
                                    </label>
                                    </fieldset>
                                </div>
                                <div class="clear"></div>
                                <div class="submit" style="padding:10px 0 0 80px; float:right; clear:both;">
                                    <input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
                                    <input class="button-primary right" type="submit" name="form-submit" value="<?php esc_attr_e('Save Changes', 'udesign') ?>" />
                                    <span class="spinner"></span>
                                </div>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Show Post Author', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Show Post Author', 'udesign'); ?></span></legend>
				<label for="show_postmetadata_author">
				    <input name="udesign_options[show_postmetadata_author]" type="checkbox" id="show_postmetadata_author" value="yes" <?php checked('yes', $options['show_postmetadata_author']); ?> />
				    <?php esc_html_e('Show Author Name', 'udesign'); ?><br />
				    <span class="description"><?php  printf( __('The following text: "Written by: Author Name" will be added to the postmetadata box. The author\'s name will be displayed as specified under %1$sUsers %2$s Your Profile%3$s <strong>Display name publicly as</strong> field and linking it to the author\'s page.', 'udesign'), '<a title="'.esc_html__('Go to Your Profile', 'udesign').'" href="profile.php">', '&rarr;', '</a>' ); ?></span>
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Post Tags', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Post Tags', 'udesign'); ?></span></legend>
				<label for="show_postmetadata_tags">
				    <input name="udesign_options[show_postmetadata_tags]" type="checkbox" id="show_postmetadata_tags" value="yes" <?php checked('yes', $options['show_postmetadata_tags']); ?> />
				    <?php esc_html_e('Show Post Tags', 'udesign'); ?><br />
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Category Archive Title', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Category Archive Title', 'udesign'); ?></span></legend>
				<label for="show_archive_for_string">
				    <input name="udesign_options[show_archive_for_string]" type="checkbox" id="show_archive_for_string" value="yes" <?php checked('yes', $options['show_archive_for_string']); ?> />
				    <?php esc_html_e('Remove the "Archive for the \'...\' Category" string from the category archive title.', 'udesign'); ?><br />
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Move Comment Text Field to Bottom', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Move Comment Text Field to Bottom', 'udesign'); ?></span></legend>
				<label for="udesign_comment_field_to_bottom">
				    <input name="udesign_options[udesign_comment_field_to_bottom]" type="checkbox" id="udesign_comment_field_to_bottom" value="yes" <?php checked('yes', $options['udesign_comment_field_to_bottom']); ?> />
				    <?php esc_html_e('In WordPress 4.4 the comment textarea was moved to the top above the Name, Email, and Website fields which is supposed to be better from usability and accessibility point of view. This option will move back the comment text field to the bottom if you so wish.', 'udesign'); ?><br />
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('"Comments are closed" message', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('"Comments are closed" message', 'udesign'); ?></span></legend>
				<label for="show_comments_are_closed_message">
				    <input name="udesign_options[show_comments_are_closed_message]" type="checkbox" id="show_comments_are_closed_message" value="yes" <?php checked('yes', $options['show_comments_are_closed_message']); ?> />
				    <?php esc_html_e('Show "Comments are closed" message for posts where the comments have been disabled, otherwise no message will be displayed.', 'udesign'); ?><br />
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Full-width Blog Page', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Full-width Blog Page', 'udesign'); ?></span></legend>
				<label for="remove_blog_sidebar">
				    <input name="udesign_options[remove_blog_sidebar]" type="checkbox" id="remove_blog_sidebar" value="yes" <?php checked('yes', $options['remove_blog_sidebar']); ?> />
				    <?php esc_html_e('Remove the sidebar from Blog pages.', 'udesign'); ?><br />
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Full-width Archive Page', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Full-width Archive Page', 'udesign'); ?></span></legend>
				<label for="remove_archive_sidebar">
				    <input name="udesign_options[remove_archive_sidebar]" type="checkbox" id="remove_archive_sidebar" value="yes" <?php checked('yes', $options['remove_archive_sidebar']); ?> />
				    <?php esc_html_e('Remove the sidebar from Archive pages (e.g. Category archives, Date archives, Tag archives, etc.).', 'udesign'); ?><br />
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Full-width Single Post View Page', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Full-width Single Post View Page', 'udesign'); ?></span></legend>
				<label for="remove_single_sidebar">
				    <input name="udesign_options[remove_single_sidebar]" type="checkbox" id="remove_single_sidebar" value="yes" <?php checked('yes', $options['remove_single_sidebar']); ?> />
				    <?php esc_html_e('Remove the sidebar from Single Post View pages.', 'udesign'); ?><br />
				</label>
				</fieldset>
			    </td>
			</tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('Single View Postmetadata Location', 'udesign'); ?></th>
                            <td>
                                <label for="udesign_single_view_postmetadata_location" class="link-target">
                                        <?php esc_html_e('Choose Location: ', 'udesign'); ?>
                                        <select name="udesign_options[udesign_single_view_postmetadata_location]" id="udesign_single_view_postmetadata_location">
                                            <option value="alignbottom"<?php echo ($options['udesign_single_view_postmetadata_location'] == 'alignbottom') ? ' selected="selected"' : ''; ?> style="min-width: 70px;"><?php esc_attr_e('Bottom', 'udesign'); ?></option>
                                            <option value="aligntop"<?php echo ($options['udesign_single_view_postmetadata_location'] == 'aligntop') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Top', 'udesign'); ?></option>
                                            <option value="alignnone"<?php echo ($options['udesign_single_view_postmetadata_location'] == 'alignnone') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('None', 'udesign'); ?></option>
                                        </select>
                                        <?php esc_html_e('This is the location of the block containing the information about Author, Date, Categories, Comments in a single view post.', 'udesign'); ?><br />
                                </label>
                            </td>
                        </tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Single Post Navigation Links', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Single Post Navigation Links', 'udesign'); ?></span></legend>
				<label for="show_single_post_navigation">
				    <input name="udesign_options[show_single_post_navigation]" type="checkbox" id="show_single_post_navigation" value="yes" <?php checked('yes', $options['show_single_post_navigation']); ?> />
				    <?php esc_html_e('Show "Previous" and "Next" navigation links on a single post view pages.', 'udesign'); ?><br />
				</label>
				</fieldset>
			    </td>
			</tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('Post Image in Single Post View', 'udesign'); ?></th>
                            <td>
                                <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Post Image in Single Post View', 'udesign'); ?></span></legend>
                                <label for="display_post_image_in_single_post">
                                    <input name="udesign_options[display_post_image_in_single_post]" type="checkbox" id="display_post_image_in_single_post" value="yes" <?php checked('yes', $options['display_post_image_in_single_post']); ?> />
                                    <?php esc_html_e('Display the post image in single post view.', 'udesign'); ?><br />
                                </label>
                                </fieldset>
                            </td>
                        </tr>
		    </tbody>
		</table>
<?php		display_save_changes_button(); ?>

                <div style="margin:10px 3px; padding:15px 20px 20px; display:block; background-color:#F8F8F1; border:1px solid #DDD;">
                    <h2 style="color:#ff4d00; margin: 2px 0; padding:0;"><?php esc_html_e('Blog and Archive Section "Featured Image":', 'udesign'); ?></h2>
                    <p><span class="description"><?php esc_html_e('Use this section to set the Post "Featured Image" the way it will be shown on the Blog and Archive Pages for each post. Please note, that if you have "post_image" custom field specified in a post, it will be given priority over the post "Featured Image", so if you would like to use the "Featured Image" do not use the custom field "post_image".', 'udesign'); ?></span></p>
                    <table class="form-table">
                        <tbody>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Enable This Section', 'udesign'); ?></th>
                                <td>
                                    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Enable Custom "Featured Image"', 'udesign'); ?></span></legend>
                                    <label for="enable_custom_featured_image">
                                        <input name="udesign_options[enable_custom_featured_image]" type="checkbox" id="enable_custom_featured_image" value="yes" <?php checked('yes', $options['enable_custom_featured_image']); ?> />
                                        <?php esc_html_e('Select this option to apply the settings below to the "Featured Image".', 'udesign'); ?><br />
                                    </label>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><label for="featured_image_width"><?php esc_html_e('Image Width', 'udesign'); ?></label></th>
                                <td>
                                    <input name="udesign_options[featured_image_width]" type="text" id="featured_image_width" value="<?php echo esc_attr($options['featured_image_width']); ?>" size="5" maxlength="4" />
                                    <span><?php esc_html_e('Apply this image width in pixels.', 'udesign'); ?></span>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><label for="featured_image_height"><?php esc_html_e('Image Height', 'udesign'); ?></label></th>
                                <td>
                                    <input name="udesign_options[featured_image_height]" type="text" id="featured_image_height" value="<?php echo esc_attr($options['featured_image_height']); ?>" size="5" maxlength="4" />
                                    <span><?php esc_html_e('Apply this image height in pixels.', 'udesign'); ?></span>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Force Image Dimensions', 'udesign'); ?></th>
                                <td>
                                    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Enable Custom "Featured Image"', 'udesign'); ?></span></legend>
                                    <label for="force_image_dimention">
                                        <input name="udesign_options[force_image_dimention]" type="checkbox" id="force_image_dimention" value="yes" <?php checked('yes', $options['force_image_dimention']); ?> />
                                        <?php esc_html_e('Select this option to force cropping and resizing the images which is recommended if you would like all images to be of the same specified dimensions.', 'udesign'); ?><br />
                                    </label>
                                    </fieldset>
                                    <span class="description"><?php esc_html_e('(This option would only be considered if image cropping is enabled (default) from the "General Options" section)', 'udesign'); ?></span>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Image Alignment', 'udesign'); ?></th>
                                <td>
                                    <label for="featured_image_alignment" class="link-target">
                                            <?php esc_html_e('Choose Alignment: ', 'udesign'); ?>
                                            <select name="udesign_options[featured_image_alignment]" id="featured_image_alignment">
                                                <option value="alignleft"<?php echo ($options['featured_image_alignment'] == 'alignleft') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Left', 'udesign'); ?></option>
                                                <option value="aligncenter"<?php echo ($options['featured_image_alignment'] == 'aligncenter') ? ' selected="selected"' : ''; ?> style="padding-right:10px;"><?php esc_attr_e('Center', 'udesign'); ?></option>
                                                <option value="alignright"<?php echo ($options['featured_image_alignment'] == 'alignright') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Right', 'udesign'); ?></option>
                                            </select>
                                    </label>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Remove Image Frame', 'udesign'); ?></th>
                                <td>
                                    <fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Remove Image Frame', 'udesign'); ?></span></legend>
                                    <label for="remove_featured_image_frame">
                                        <input name="udesign_options[remove_featured_image_frame]" type="checkbox" id="remove_featured_image_frame" value="yes" <?php checked('yes', $options['remove_featured_image_frame']); ?> />
                                        <?php esc_html_e('This option will remove the image frame.', 'udesign'); ?><br />
                                    </label>
                                    </fieldset>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
<?php		display_save_changes_button(); ?>
<?php	}

	function contact_page_options_contentbox( $options ) {
                global $recaptcha_languages;
		$show_contact_fields = $options['show_contact_fields'];
		$contact_field_name1 = $options['contact_field_name1'];
		$contact_field_value1 = $options['contact_field_value1'];
		$contact_field_name2 = $options['contact_field_name2'];
		$contact_field_value2 = $options['contact_field_value2'];
		$contact_field_name3 = $options['contact_field_name3'];
		$contact_field_value3 = $options['contact_field_value3'];
		$contact_field_name4 = $options['contact_field_name4'];
		$contact_field_value4 = $options['contact_field_value4'];
		$contact_field_name5 = $options['contact_field_name5'];
		$contact_field_value5 = $options['contact_field_value5'];
		$contact_field_name6 = $options['contact_field_name6'];
		$contact_field_value6 = $options['contact_field_value6'];
		$contact_field_name7 = $options['contact_field_name7'];
		$contact_field_value7 = $options['contact_field_value7'];
		$contact_sidebar = $options['contact_sidebar'];
		$remove_contact_sidebar = $options['remove_contact_sidebar'];
		$NA_phone_format = $options['NA_phone_format'];
		$email_receipients = $options['email_receipients']; ?>
		<h4><?php esc_html_e('Enable Contact Information Section', 'udesign'); ?></h4>
		<fieldset style="margin: 10px 20px 20px"><legend class="screen-reader-text"><span><?php esc_html_e('Enable Contact Info Fields', 'udesign'); ?></span></legend>
		    <label for="show_contact_fields">
			<input name="udesign_options[show_contact_fields]" type="checkbox" id="show_contact_fields" value="yes" <?php checked('yes', $show_contact_fields); ?> />
			<?php esc_html_e('Enable the contact fields (see below for description)', 'udesign'); ?>
		    </label>
		</fieldset>
		<h4><?php esc_html_e('Contact Fields', 'udesign'); ?></h4>
		<p style="margin:5px 20px">
		    <?php _e('The fields below provide a way to display additional contact information such as Company Name, Address, Phone, etc. on the contact page in a pre-formatted layout. An example of a field pair could be <strong>Telephone: (123) 123-4567</strong>, where you would enter the "<strong>Telephone:</strong>" part in the first field and "<strong>(123) 123-4567</strong>" in the second (under the same "Line #") respectively.', 'udesign'); ?><br /><br />
		    <?php esc_html_e('Line 1:', 'udesign'); ?> <br />
		    <input name="udesign_options[contact_field_name1]" type="text" id="contact_field_name1" value="<?php if ($contact_field_name1){echo esc_attr($contact_field_name1);}?>" size="30" maxlength="50" />
			     <input name="udesign_options[contact_field_value1]" type="text" id="contact_field_value1" value="<?php if ($contact_field_value1){echo esc_attr($contact_field_value1);}?>" size="50" maxlength="500" /><br/>
		    <?php esc_html_e('Line 2:', 'udesign'); ?> <br />
		    <input name="udesign_options[contact_field_name2]" type="text" id="contact_field_name2" value="<?php if ($contact_field_name2){echo esc_attr($contact_field_name2);}?>" size="30" maxlength="50" />
			     <input name="udesign_options[contact_field_value2]" type="text" id="contact_field_value2" value="<?php if ($contact_field_value2){echo esc_attr($contact_field_value2);}?>" size="50" maxlength="500" /><br/>
		    <?php esc_html_e('Line 3:', 'udesign'); ?> <br />
		    <input name="udesign_options[contact_field_name3]" type="text" id="contact_field_name3" value="<?php if ($contact_field_name3){echo esc_attr($contact_field_name3);}?>" size="30" maxlength="50" />
			     <input name="udesign_options[contact_field_value3]" type="text" id="contact_field_value3" value="<?php if ($contact_field_value3){echo esc_attr($contact_field_value3);}?>" size="50" maxlength="500" /><br/>
		    <?php esc_html_e('Line 4:', 'udesign'); ?> <br />
		    <input name="udesign_options[contact_field_name4]" type="text" id="contact_field_name4" value="<?php if ($contact_field_name4){echo esc_attr($contact_field_name4);}?>" size="30" maxlength="50" />
			     <input name="udesign_options[contact_field_value4]" type="text" id="contact_field_value4" value="<?php if ($contact_field_value4){echo esc_attr($contact_field_value4);}?>" size="50" maxlength="500" /><br/>
		    <?php esc_html_e('Line 5:', 'udesign'); ?> <br />
		    <input name="udesign_options[contact_field_name5]" type="text" id="contact_field_name5" value="<?php if ($contact_field_name5){echo esc_attr($contact_field_name5);}?>" size="30" maxlength="50" />
			     <input name="udesign_options[contact_field_value5]" type="text" id="contact_field_value5" value="<?php if ($contact_field_value5){echo esc_attr($contact_field_value5);}?>" size="50" maxlength="500" /><br/>
		    <?php esc_html_e('Line 6:', 'udesign'); ?> <br />
		    <input name="udesign_options[contact_field_name6]" type="text" id="contact_field_name6" value="<?php if ($contact_field_name6){echo esc_attr($contact_field_name6);}?>" size="30" maxlength="50" />
			     <input name="udesign_options[contact_field_value6]" type="text" id="contact_field_value6" value="<?php if ($contact_field_value6){echo esc_attr($contact_field_value6);}?>" size="50" maxlength="500" /><br/>
		    <?php esc_html_e('Line 7:', 'udesign'); ?> <br />
		    <input name="udesign_options[contact_field_name7]" type="text" id="contact_field_name7" value="<?php if ($contact_field_name7){echo esc_attr($contact_field_name7);}?>" size="30" maxlength="50" />
			     <input name="udesign_options[contact_field_value7]" type="text" id="contact_field_value7" value="<?php if ($contact_field_value7){echo esc_attr($contact_field_value7);}?>" size="50" maxlength="500" /><br/><br/>
		    <span class="description"><?php esc_html_e('Some html tags and inline styling could be used for formatting here, e.g.', 'udesign'); ?> &lt;em&gt;<?php esc_html_e('Address', 'udesign'); ?>:&lt;/em&gt; <?php esc_html_e('or', 'udesign'); ?> &lt;span style=&quot;color:red;&quot;&gt;<?php esc_html_e('Address', 'udesign'); ?>:&lt;/span&gt;</span>
		</p>
		<h4><?php esc_html_e('Sidebar Position', 'udesign'); ?></h4>
		<p><?php esc_html_e('Choose position:', 'udesign'); ?><br />
		    <label style="margin:20px"><input type="radio" name="udesign_options[contact_sidebar]" id="contact_sidebar_left" value="left" <?php checked('left', $contact_sidebar); ?> /> <?php esc_html_e('Left', 'udesign'); ?></label>&nbsp;
		    <label><input type="radio" name="udesign_options[contact_sidebar]" id="contact_sidebar_right" value="right" <?php checked('right', $contact_sidebar); ?> /> <?php esc_html_e('Right', 'udesign'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
		    <span class="description"><?php esc_html_e('This is the sidebar shown on the Contact page', 'udesign'); ?></span>
		</p>
		<h4><?php esc_html_e('Remove Sidebar', 'udesign'); ?></h4>
		<fieldset style="margin: 10px 20px 20px"><legend class="screen-reader-text"><span><?php esc_html_e('Remove Sidebar', 'udesign') ?></span></legend>
		    <label for="remove_contact_sidebar">
			<input name="udesign_options[remove_contact_sidebar]" type="checkbox" id="remove_contact_sidebar" value="yes" <?php checked('yes', $remove_contact_sidebar); ?> />
			<?php esc_html_e('Remove the sidebar from the Contact page, which will make it a full-width page layout.', 'udesign'); ?><br />
		    </label>
		</fieldset>
		<h4><?php esc_html_e('Phone Number validation', 'udesign'); ?></h4>
		<p><?php esc_html_e('This is the field displayed in the E-mail form on the Contact page template. If checked, the validation for North American phone numbers will be enabled.', 'udesign'); ?></p>
		<fieldset style="margin: 10px 20px 20px"><legend class="screen-reader-text"><span><?php esc_html_e('Enable North American phone number validation', 'udesign') ?></span></legend>
		    <label for="NA_phone_format">
			<input name="udesign_options[NA_phone_format]" type="checkbox" id="NA_phone_format" value="yes" <?php checked('yes', $NA_phone_format); ?> />
			<?php esc_html_e('Enable North American phone number validation in the contact email form', 'udesign'); ?><br />
		    </label>
		</fieldset>
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('E-mail Recipient(s)', 'udesign'); ?></th>
			    <td>
				<?php esc_html_e("Please enter recipient's email address, comma-separate multiple recipients:", 'udesign'); ?><br />
				<textarea style="width: 98%;" id="email_receipients" rows="2" cols="60" name="udesign_options[email_receipients]"><?php if( $email_receipients ){ echo esc_attr($email_receipients); } ?></textarea><br />
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Enable reCAPTCHA', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Enable reCAPTCHA', 'udesign'); ?></span></legend>
				<label for="recaptcha_enabled">
				    <input name="udesign_options[recaptcha_enabled]" type="checkbox" id="recaptcha_enabled" value="yes" <?php checked( 'yes', $options['recaptcha_enabled']); ?> />
				    <?php printf( esc_html__('Add reCAPTCHA to the email form for extra security (for more information visit %s)', 'udesign'), '<a title="'.esc_html__('Go to www.reCAPTCHA.net', 'udesign').'" href="https://www.google.com/recaptcha/" target="_blank">www.google.com/recaptcha/</a>' ); ?>
				</label><br />
				<span class="description"><?php esc_html_e('Please note: reCAPTCHA will be automatically disabled if the two fields below are empty!', 'udesign'); ?></span>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('reCAPTCHA Public Key', 'udesign'); ?></th>
			    <td>
				<input name="udesign_options[recaptcha_publickey]" type="text" id="recaptcha_publickey" value="<?php if ($options['recaptcha_publickey']) { echo esc_attr($options['recaptcha_publickey']); } ?>" size="55" maxlength="100" />
				<br /><?php esc_html_e('To use reCAPTCHA you must get an API public key from', 'udesign'); ?> <a title="<?php esc_html_e('Go to www.reCAPTCHA.net', 'udesign') ?>" href="https://www.google.com/recaptcha/" target="_blank">www.google.com/recaptcha/</a>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('reCAPTCHA Private Key', 'udesign'); ?></th>
			    <td>
				<input name="udesign_options[recaptcha_privatekey]" type="text" id="recaptcha_privatekey" value="<?php if ($options['recaptcha_privatekey']) { echo esc_attr($options['recaptcha_privatekey']); } ?>" size="55" maxlength="100" />
				<br /><?php esc_html_e('To use reCAPTCHA you must get an API private key from', 'udesign'); ?> <a title="<?php esc_html_e('Go to www.reCAPTCHA.net', 'udesign') ?>" href="https://www.google.com/recaptcha/" target="_blank">www.google.com/recaptcha/</a><br />
				<span class="description"><?php esc_html_e('This key is used when communicating between your server and the reCAPTCHA server. Be sure to keep it a secret.', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('reCAPTCHA Language', 'udesign'); ?></th>
			    <td>
				<label for="recaptcha_lang" class="link-target">
					<?php esc_html_e('Language: ', 'udesign'); ?>
					<select name="udesign_options[recaptcha_lang]" id="recaptcha_lang">
<?php                                       foreach ($recaptcha_languages as $lang => $code) : ?>
                                                <option value="<?php echo $code; ?>"<?php echo ($options['recaptcha_lang'] == $code) ? ' selected="selected"' : ''; ?>><?php echo $lang; ?></option>
<?php                                       endforeach; ?>
					</select>
				</label>
			    </td>
			</tr>
		    </tbody>
		</table>
<?php		display_save_changes_button(); ?>
<?php	}

	function footer_options_contentbox( $options ) {
		$copyright_message = $options['copyright_message'];
		$show_wp_link_in_footer = $options['show_wp_link_in_footer'];
		$show_entries_rss_in_footer = $options['show_entries_rss_in_footer'];
		$show_comments_rss_in_footer = $options['show_comments_rss_in_footer']; ?>
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Copyright Message', 'udesign'); ?></th>
			    <td>
				<textarea style="width: 98%;" id="copyright_message" rows="2" cols="60" name="udesign_options[copyright_message]"><?php if( $copyright_message ){ echo esc_attr($copyright_message); } ?></textarea>
				<br />
				<span class="description"><?php esc_html_e('Copyright message displayed in the footer.', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('WordPress credits link', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('WordPress credits link', 'udesign'); ?></span></legend>
				<label for="show_wp_link_in_footer">
				    <input name="udesign_options[show_wp_link_in_footer]" type="checkbox" id="show_wp_link_in_footer" value="yes" <?php checked('yes', $show_wp_link_in_footer); ?> />
				    <?php printf( esc_html__('Show "is proudly powered by %s" in footer?', 'udesign'), '<strong>WordPress</strong>' ); ?>
				</label>
				</fieldset>
			    </td>
			</tr>
		    </tbody>
		  </table>
                <div style="background-color:#FCFCFC; border:1px solid #DDDDDD; margin:6px 0 0; padding-bottom:8px;">
		  <table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Your "U-Design" Affiliate Link', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Your "U-Design" Affiliate Link', 'udesign'); ?></span></legend>
				<label for="show_udesign_affiliate_link">
				    <input name="udesign_options[show_udesign_affiliate_link]" type="checkbox" id="show_udesign_affiliate_link" value="yes" <?php checked('yes', $options['show_udesign_affiliate_link']); ?> />
				    <?php printf( esc_html__('Show %1$sThemeForest Affiliate%2$s link in footer?', 'udesign'), '<a target="_blank" title="More information on the ThemeForest Affiliate Program" href="http://themeforest.net/make_money/affiliate_program/">', '</a>' ); ?>
				</label>
                                <label style="margin-left:20px;" for="affiliate_username"><?php printf( esc_html__('ThemeForest %1$susername%2$s:', 'udesign'), '<strong>','</strong>' ); ?></label>
				<input name="udesign_options[affiliate_username]" type="text" id="affiliate_username" value="<?php if ($options['affiliate_username']) { echo esc_attr($options['affiliate_username']); } ?>" size="15" maxlength="100" />
				<span class="description"><?php esc_html_e('(case-sensitive)', 'udesign'); ?></span>
                                <br /><?php printf( esc_html__('Would you like to make money with "U-Design"? Refer new ThemeForest users to the "U-Design" theme and ThemeForest will pay you 30&#37; of their first purchase or cash deposit!! Click %1$shere%2$s for more information.', 'udesign'), '<a target="_blank" title="More information on the ThemeForest Affiliate Program" href="http://themeforest.net/make_money/affiliate_program/">', '</a>' ); ?>
				</fieldset>
			    </td>
			</tr>
		    </tbody>
		  </table>
                </div>
		  <table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Entries (RSS) link', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Entries (RSS) link', 'udesign'); ?></span></legend>
				<label for="show_entries_rss_in_footer">
				    <input name="udesign_options[show_entries_rss_in_footer]" type="checkbox" id="show_entries_rss_in_footer" value="yes" <?php checked('yes', $show_entries_rss_in_footer); ?> />
				    <?php esc_html_e('Show "Entries (RSS)" link in footer?', 'udesign'); ?>
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Comments (RSS) link', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Comments (RSS) link', 'udesign'); ?></span></legend>
				<label for="show_comments_rss_in_footer">
				    <input name="udesign_options[show_comments_rss_in_footer]" type="checkbox" id="show_comments_rss_in_footer" value="yes" <?php checked('yes', $show_comments_rss_in_footer); ?> />
				    <?php esc_html_e('Show "Comments (RSS)" link in footer?', 'udesign'); ?>
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('"Sticky" Footer', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('"Sticky" Footer', 'udesign'); ?></span></legend>
				<label for="udesign_sticky_footer">
				    <input name="udesign_options[udesign_sticky_footer]" type="checkbox" id="udesign_sticky_footer" value="yes" <?php checked('yes', $options['udesign_sticky_footer']); ?> />
				    <?php esc_html_e('Have the footer stay at the bottom of the page on pages that have very little content.', 'udesign'); ?>
                                </label>
				</fieldset>
			    </td>
			</tr>
		    </tbody>
		</table>
<?php		display_save_changes_button(); ?>
<?php	}

	function statistics_options_contentbox( $options ) {
		$google_analytics = $options['google_analytics']; ?>
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			<th scope="row"><label for="google_analytics"><?php esc_html_e('Google Analytics', 'udesign'); ?></label></th>
			<td>
			    <textarea class="code" style="width: 98%;" id="google_analytics" rows="10" cols="60" name="udesign_options[google_analytics]"><?php if( $google_analytics ){ esc_attr_e($google_analytics); } ?></textarea>
			    <br />
			    <span class="description"><?php esc_html_e('Paste your Google Analytics or other tracking code here. It will be inserted just before the closing &lt;/head&gt; tag.', 'udesign'); ?></span>
			</td>
			</tr>
		    </tbody>
		</table>
<?php		display_save_changes_button(); ?>
<?php	}

	function responsive_options_contentbox( $options ) { ?>
                
    		<table class="form-table" style="background-color:#FCFCFC; border:1px solid #DDDDDD;">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('General Information', 'udesign'); ?></th>
			    <td>
				<span class="description"><?php esc_html_e("960px is the theme's default width. If responsive is enabled the theme will resize automatically to adjust to the size of the browser window or the type of device being used based on the following three breakpoints:", 'udesign'); ?></span><br />
                                <div style="padding-left:5px;">
                                    <span class="description"><?php esc_html_e("1 ) Breakpoint 1 - [ 960px to 720px ]", 'udesign'); ?></span><br />
                                    <span class="description"><?php esc_html_e("2 ) Breakpoint 2 - [ 720px to 480px ]", 'udesign'); ?></span><br />
                                    <span class="description"><?php esc_html_e("3 ) Breakpoint 3 - [ smaller than 480px ]", 'udesign'); ?></span><br />
                                </div>
			    </td>
			</tr>
		    </tbody>
		</table>
                
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Enable Responsive', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Enable Responsive', 'udesign'); ?></span></legend>
				<label for="enable_responsive">
				    <input name="udesign_options[enable_responsive]" type="checkbox" id="enable_responsive" value="yes" <?php checked('yes', $options['enable_responsive']); ?> />
				    <?php esc_html_e('Enable responsive layout.', 'udesign'); ?>
                                </label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Responsive Logo (optional)', 'udesign'); ?></th>
			    <td>
                                <div style="margin-bottom:5px;  padding:0; float:left;">
                                    <label for="responsive_logo_img"><?php esc_html_e("Enter a URL or upload an image for your alternative logo:", 'udesign'); ?></label><br />
                                    <input name="udesign_options[responsive_logo_img]" type="text" id="responsive_logo_img" value="<?php if( $options['responsive_logo_img'] ){ echo esc_url($options['responsive_logo_img']); } ?>" size="65" />
                                    <input id="upload_responsive_logo_button" type="button" value="<?php esc_attr_e('Upload Logo', 'udesign'); ?>" class="button-secondary" />
                                </div>
                                <div class="clear"></div>
                                <span class="description"><?php esc_html_e("An alternative logo will be loaded ONLY in the case Breakpoints 2 and 3. Please note, this is optional, in most cases you won't need an alternative logo but in some cases might be handy. In either case the theme will resize (if necessary) and center the logo automatically.", 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Responsive Logo Height', 'udesign'); ?></th>
			    <td>
				<input name="udesign_options[responsive_logo_height]" type="text" id="responsive_logo_height" value="<?php echo esc_attr($options['responsive_logo_height']); ?>" size="5" maxlength="4" />px 
                                <span class="description"><?php esc_html_e('(Height) in pixels.  Note: The width is automatically adjusted to the maximum allowed width.', 'udesign'); ?></span>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Remove Secondary Menu', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Remove Secondary Menu', 'udesign'); ?></span></legend>
				<label for="responsive_remove_secondary_menu">
				    <input name="udesign_options[responsive_remove_secondary_menu]" type="checkbox" id="responsive_remove_secondary_menu" value="yes" <?php checked('yes', $options['responsive_remove_secondary_menu']); ?> />
				    <?php esc_html_e('Remove the secondary menu completely from the top of the page for the Breakpoints 2 and 3.', 'udesign'); ?>
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Remove the Slider Area', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Remove the Slider Area', 'udesign'); ?></span></legend>
				<label for="responsive_remove_slider_area">
				    <input name="udesign_options[responsive_remove_slider_area]" type="checkbox" id="responsive_remove_slider_area" value="yes" <?php checked('yes', $options['responsive_remove_slider_area']); ?> />
				    <?php esc_html_e('Remove the Slider Area completely from the home page for the Breakpoints 2 and 3.', 'udesign'); ?>
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Remove Background Images', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Remove Background Images', 'udesign'); ?></span></legend>
				<label for="responsive_remove_bg_images_960-720">
				    <input name="udesign_options[responsive_remove_bg_images_960-720]" type="checkbox" id="responsive_remove_bg_images_960-720" value="yes" <?php checked('yes', $options['responsive_remove_bg_images_960-720']); ?> />
				    <?php esc_html_e("Remove all background images for Breakpoint 1. Those are the background images that have been assigned through the theme's 'Custom Colors' section.", 'udesign'); ?>
                                    <span class="description"><?php esc_html_e("(Note: The background images will be replaced with their corresponding background colors for those respective sections. Also, by default the background images will be removed automatically for Breakpoints 2 and 3 respectively)", 'udesign'); ?></span>
				</label>
				</fieldset>
			    </td>
			</tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e('Responsive Menu', 'udesign'); ?></th>
                            <td>
                                <label for="responsive_menu" class="link-target" style="float:left; display:inline-block;">
                                        <select name="udesign_options[responsive_menu]" id="responsive_menu">
                                            <option value="responsive_menu_1"<?php echo ($options['responsive_menu'] == 'responsive_menu_1') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Responsive Menu 1', 'udesign'); ?></option>
                                            <option value="responsive_menu_2"<?php echo ($options['responsive_menu'] == 'responsive_menu_2') ? ' selected="selected"' : ''; ?>><?php esc_attr_e('Responsive Menu 2', 'udesign'); ?></option>
                                        </select>
                                    <?php esc_html_e("Choose a menu to be used for Breakpoints 2 and 3.", 'udesign'); ?>
                                </label>
                                <div class="clear"></div>
                                <fieldset class="menu_2_screen_width" style="margin-top: 10px;"><legend class="screen-reader-text"><span><?php esc_html_e('Responsive Menu 2 Threshold', 'udesign'); ?></span></legend>
                                    <label for="menu_2_screen_width">
                                        <input name="udesign_options[menu_2_screen_width]" type="checkbox" id="menu_2_screen_width" value="yes" <?php checked('yes', $options['menu_2_screen_width']); ?> />
                                        <?php esc_html_e('Enable "Responsive Menu 2" starting at Breakpoint 1.', 'udesign'); ?>
                                    </label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Pinch-to-Zoom', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Pinch-to-Zoom', 'udesign'); ?></span></legend>
				<label for="responsive_pinch_to_zoom">
				    <input name="udesign_options[responsive_pinch_to_zoom]" type="checkbox" id="responsive_pinch_to_zoom" value="yes" <?php checked('yes', $options['responsive_pinch_to_zoom']); ?> />
				    <?php esc_html_e("Enable pinch-to-zoom on mobile devices. Adds the ability to zoom in on images, text, links, etc. which could come really handy in some situations.", 'udesign'); ?>
				</label>
				</fieldset>
			    </td>
			</tr>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Disable prettyPhoto', 'udesign'); ?></th>
			    <td>
                                <div id="disable_pp_at_width_slide_bar"></div>
				<input name="udesign_options[responsive_disable_pretty_photo_at_width]" type="text" id="responsive_disable_pretty_photo_at_width" value="<?php echo ( $options['responsive_disable_pretty_photo_at_width'] ) ? esc_attr($options['responsive_disable_pretty_photo_at_width']) : '0'; ?>" size="5" maxlength="4" />px. 
                                <span class="description"><?php esc_html_e('(Width) in pixels.', 'udesign'); ?></span>
                                <?php esc_html_e('This is the device width or browser width at which the prettyPhoto lightbox effect will be disabled, anything smaller than that width will not have prettyPhoto enabled. This is especially useful for widths smaller than the Breakpoint 3 - [ 480px ], but a value slightly greater than that could be a good start, for instance "600". To disable this option set the width to "0".', 'udesign'); ?>
			    </td>
			</tr>
		    </tbody>
		  </table>
<?php		display_save_changes_button(); ?>
<?php	}

	function advanced_options_contentbox( $options ) { ?>
                
                <p style="margin: 10px 0 10px;"><span class="description"><?php esc_html_e("The options in this section are generally offered to assist more advanced users with deeper knowledge of WordPress programming.", 'udesign'); ?></span></p>
		<table class="form-table">
		    <tbody>
			<tr valign="top">
			    <th scope="row"><?php esc_html_e('Show Action Hook Locations', 'udesign'); ?></th>
			    <td>
				<fieldset><legend class="screen-reader-text"><span><?php esc_html_e('Show Action Hook Locations', 'udesign'); ?></span></legend>
				<label for="show_udesign_action_hooks">
				    <input name="udesign_options[show_udesign_action_hooks]" type="checkbox" id="show_udesign_action_hooks" value="yes" <?php checked('yes', $options['show_udesign_action_hooks']); ?> />
				    <?php esc_html_e('Enabling this option will allow you to see in the front end the exact locations of the U-Design action hooks located within the "body" tags.', 'udesign'); ?>
                                </label>
				</fieldset>
			    </td>
			</tr>
		    </tbody>
		  </table>
<?php		display_save_changes_button(); ?>
<?php	}

} // end of UDESIGN_Theme_Options Class



function display_save_changes_button() {
	    echo ('
		    <table class="form-table">
			<tbody>
			    <tr valign="top">
				<th scope="row">&nbsp;</th>
				<td>
				    <div class="submit" style="padding:10px 0 0 80px; float:right; clear:both;">
					<input type="hidden" id="udesign_submit" value="1" name="udesign_submit"/>
					<input class="button-primary right" type="submit" name="form-submit" value="'.esc_attr__('Save Changes', 'udesign').'" />
                                        <span class="spinner"></span>
				    </div>
				</td>
			    </tr>
			</tbody>
		    </table>');
}

function get_c2_slide_default_info_txt() {
    return <<<XML
<h2>Title Goes Here...</h2>

<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>

<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
XML;
}

function get_c3_slide_default_info_txt() {
    return <<<XML
<div style="width:400px; height:100px; top:300px; left:220px; position:absolute; z-index:9999;">
    <p style="text-align:left;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
</div>
XML;
}

function get_udesign_social_icons_html() {
    return <<<XML
<ul class="ud-social-icons">
    <li><a title="Twitter" href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
    <li><a title="Facebook" href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
    <li><a title="Google+" href="https://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
    <li><a title="LinkedIn" href="https://www.linkedin.com/"><i class="fa fa-linkedin"></i></a></li>
    <li><a title="Instagram" href="http://instagram.com/"><i class="fa fa-instagram"></i></a></li>
    <li><a title="Yelp" href="http://www.yelp.com/"><i class="fa fa-yelp"></i></a></li>
    <li><a title="YouTube" href="https://www.youtube.com/"><i class="fa fa-youtube-play"></i></a></li>
    <li><a title="Flickr" href="https://www.flickr.com/"><i class="fa fa-flickr"></i></a></li>
    <li><a title="Pinterest" href="https://www.pinterest.com/"><i class="fa fa-pinterest"></i></a></li>
</ul>
XML;
}

/**
 * This function will generate the fonts select options for the "Font Settings" section
 * If used in new locations make sure to update the necessary new classes and ID in the appropriate CSS file
 * The following "udesign_options" were dynamically substittuded in this function:
 *      "general_font_family","general_font_variant","general_font_subset","general_font_size"
 *      "top_nav_font_family","top_nav_font_variant","top_nav_font_subset","top_nav_font_size"
 *      "headings_font_family","headings_font_variant","headings_font_subset","headings_font_size_coefficient"
 *      "heading1_font_family","heading1_font_variant","heading1_font_subset","heading1_font_size"
 *      "heading2_font_family","heading2_font_variant","heading2_font_subset","heading2_font_size"
 *      "heading3_font_family","heading3_font_variant","heading3_font_subset","heading3_font_size"
 *      "heading4_font_family","heading4_font_variant","heading4_font_subset","heading4_font_size"
 *      "heading5_font_family","heading5_font_variant","heading5_font_subset","heading5_font_size"
 *      "heading6_font_family","heading6_font_variant","heading6_font_subset","heading6_font_size"
 * 
 * @param string $option_name_prefix For example if the select name attribute should be "udesign_options[top_nav_font_family]" then $option_name_prefix should be "top_nav"
 * @param string $class_prefix For example if the class is supposed to be "top-nav-font-family" then $class_prefix should be "top-nav"
 * @param string $the_font_family This is font family option for the current setting
 * @param string $enable_google_web_fonts "yes" or "no" respectively
 * @param array $options This one is passed from the Options Settings of the page
 * @param string $font_size_units Acceptable values: "pixels", "ems" or "coefficient"
 * @param string $default_font_size Some unit in pixels (eg. "12") or coefficient (eg. "1.0")
 * 
 * @return string HTML
 */
function get_udesign_fonts_select_options( $option_name_prefix = "general", $class_prefix = "general", $the_font_family = "Arial", $enable_google_web_fonts = "" , $options, $font_size_units = "pixels", $default_font_size = "12") {
    global $google_webfonts, $google_webfonts_variants, $google_fonts_variants_descriptions, $google_webfonts_subsets;
    $google_font_selected = false;
    ob_start(); ?>
				<label for="<?php echo $option_name_prefix; ?>_font_family"  class="<?php echo $option_name_prefix; ?>_font_family">
					<?php esc_html_e('Font Family: ', 'udesign'); ?><br />
					<select name="udesign_options[<?php echo $option_name_prefix; ?>_font_family]" id="<?php echo $option_name_prefix; ?>_font_family" class="<?php echo $class_prefix; ?>-font-family">
                                            <optgroup label="<?php esc_html_e('Generic Fonts:', 'udesign'); ?>">
                                                <option value="Arial"<?php echo ($the_font_family == 'Arial') ? ' selected="selected"' : ''; ?>>Arial</option>
                                                <option value="Comic Sans MS"<?php echo ($the_font_family == 'Comic Sans MS') ? ' selected="selected"' : ''; ?>>Comic Sans MS</option>
                                                <option value="FreeSans"<?php echo ($the_font_family == 'FreeSans') ? ' selected="selected"' : ''; ?>>FreeSans</option>
                                                <option value="Georgia"<?php echo ($the_font_family == 'Georgia') ? ' selected="selected"' : ''; ?>>Georgia</option>
                                                <option value="Lucida Sans Unicode"<?php echo ($the_font_family == 'Lucida Sans Unicode') ? ' selected="selected"' : ''; ?>>Lucida Sans Unicode</option>
                                                <option value="Palatino Linotype"<?php echo ($the_font_family == 'Palatino Linotype') ? ' selected="selected"' : ''; ?>>Palatino Linotype</option>
                                                <option value="Symbol"<?php echo ($the_font_family == 'Symbol') ? ' selected="selected"' : ''; ?>>Symbol</option>
                                                <option value="Tahoma"<?php echo ($the_font_family == 'Tahoma') ? ' selected="selected"' : ''; ?>>Tahoma</option>
                                                <option value="Times New Roman"<?php echo ($the_font_family == 'Times New Roman') ? ' selected="selected"' : ''; ?>>Times New Roman</option>
                                                <option value="Trebuchet MS"<?php echo ($the_font_family == 'Trebuchet MS') ? ' selected="selected"' : ''; ?>>Trebuchet MS</option>
                                                <option value="Verdana"<?php echo ($the_font_family == 'Verdana') ? ' selected="selected"' : ''; ?>>Verdana</option>
                                            </optgroup>
<?php					    if( $enable_google_web_fonts == 'yes' ) : ?>
                                            <optgroup label="Google Web Fonts:"><?php 
                                                foreach ($google_webfonts as $id => $font_name) {
						    if( $options[$option_name_prefix.'_font_family'] == $font_name ) {$make_current_font_selected = ' selected="selected"'; $google_font_selected = $id;}
                                                    else {$make_current_font_selected = '';}
                                                    echo '<option value="'.$font_name.'"'.$make_current_font_selected.' data-font-id="'.$id.'">'.$font_name.'</option>';
                                                } ?>
                                            </optgroup>
<?php 					    endif; ?>
					</select>
				</label>
<?php				if( $enable_google_web_fonts == 'yes' ) : 
                                    $hide_class = ( $google_font_selected ) ? '' : ' hide'; ?>
                                    <label for="<?php echo $option_name_prefix; ?>_font_variants" class="<?php echo $option_name_prefix; ?>_font_variants<?php echo $hide_class; ?>">
                                        <?php esc_html_e('Font Variant: ', 'udesign'); ?><br />
                                        <select name="udesign_options[<?php echo $option_name_prefix; ?>_font_variant]" class="<?php echo $class_prefix; ?>-font-variants" style="width:180px;"><?php 
                                            foreach ($google_webfonts_variants[$google_font_selected]['text'] as $variant) {
                                                $selected_val = ( $options[$option_name_prefix.'_font_variant'] ) ? $options[$option_name_prefix.'_font_variant'] : 'regular';
						$make_current_variant_selected = ( $selected_val == $variant ) ? $make_current_variant_selected = ' selected="selected"' : '';
                                                echo '<option value="'.$variant.'"'.$make_current_variant_selected.'>'.$google_fonts_variants_descriptions[$variant].'</option>';
                                            } ?>
                                        </select>
                                    </label>
                                    <label for="<?php echo $option_name_prefix; ?>_font_subsets" class="<?php echo $option_name_prefix; ?>_font_subsets<?php echo $hide_class;?>">
                                        <?php esc_html_e('Font Subset: ', 'udesign'); ?><br />
                                        <select name="udesign_options[<?php echo $option_name_prefix; ?>_font_subset]" class="<?php echo $class_prefix; ?>-font-subsets" style="width:160px;"><?php 
                                            foreach ($google_webfonts_subsets[$google_font_selected]['text'] as $subset) {
                                                $selected_val = ( $options[$option_name_prefix.'_font_subset'] ) ? $options[$option_name_prefix.'_font_subset'] : 'latin';
						$make_current_subset_selected = ( $selected_val == $subset ) ? $make_current_subset_selected = ' selected="selected"' : '';
                                                echo '<option value="'.$subset.'"'.$make_current_subset_selected.'>'.$subset.'</option>';
                                            } ?>
                                        </select>
                                    </label>
<?php 				endif; ?>
                
<?php                           if ( $font_size_units == "pixels" ) : ?>
                                    <label for="<?php echo $option_name_prefix; ?>_font_size" class="<?php echo $option_name_prefix; ?>_font_size">
                                            <?php esc_html_e('Font Size: ', 'udesign'); ?>
                                            <select name="udesign_options[<?php echo $option_name_prefix; ?>_font_size]" id="<?php echo $option_name_prefix; ?>_font_size" class="<?php echo $class_prefix; ?>-font-size">
                                                <?php for ($index = 8; $index < 37; $index++) {
                                                    $selected_val = ( $options[$option_name_prefix.'_font_size'] ) ? $options[$option_name_prefix.'_font_size'] : $default_font_size;
                                                    $selected = ( $selected_val == $index ) ? $selected = ' selected="selected"' : '';
                                                    $default_text = ($index == $default_font_size) ? esc_html__('(Default)', 'udesign') : '';
                                                    echo '<option value="'.$index.'"'.$selected.'>'.$index.'px '.$default_text.'</option>';
                                                } ?>
                                            </select>
                                    </label>
<?php                           elseif( $font_size_units == "ems" ) : ?>
                                    <label for="<?php echo $option_name_prefix; ?>_font_size" class="<?php echo $option_name_prefix; ?>_font_size">
                                            <?php esc_html_e('Font Size Coefficient: ', 'udesign'); ?><br />
                                            <select name="udesign_options[<?php echo $option_name_prefix; ?>_font_size]" id="<?php echo $option_name_prefix; ?>_font_size" class="<?php echo $class_prefix; ?>-font-size">
                                                <?php 
                                                $start = 1.05;
                                                $increment = 0.05;
                                                for ($i = 0; $i < 100; $i++){
                                                    $ems = sprintf('%0.2f', $start + $increment * $i);
                                                    $selected_val = ( $options[$option_name_prefix.'_font_size'] ) ? $options[$option_name_prefix.'_font_size'] : $default_font_size;
                                                    $selected = ( $selected_val == $ems ) ? $selected = ' selected="selected"' : '';
                                                    $default_text = ($ems == $default_font_size) ? esc_html__('(Default)', 'udesign') : '';
                                                    echo '<option value="'.$ems.'"'.$selected.'>'.$ems.'em '.$default_text.'</option>';
                                                } ?>
                                            </select>
                                    </label>
                                    <div style="clear:both;"><span class="description"><?php esc_html_e('The Font Size Coefficient is multiplied by the actual heading size in "em".', 'udesign'); ?></span></div>
<?php                           else : ?>
                                    <label for="<?php echo $option_name_prefix; ?>_size_coefficient" class="<?php echo $option_name_prefix; ?>_font_size">
                                            <?php esc_html_e('Font Size Coefficient: ', 'udesign'); ?><br />
                                            <select name="udesign_options[<?php echo $option_name_prefix; ?>_font_size_coefficient]" id="<?php echo $option_name_prefix; ?>_font_size_coefficient" class="<?php echo $class_prefix; ?>-font-size">
                                                <?php 
                                                $start = 0.2;
                                                $increment = 0.2;
                                                for ($i = 0; $i < 20; $i++){
                                                    $coefficient = sprintf('%0.1f', $start + $increment * $i);
                                                    $selected_val = ( $options[$option_name_prefix.'_font_size_coefficient'] ) ? $options[$option_name_prefix.'_font_size_coefficient'] : $default_font_size;
                                                    $selected = ( $selected_val == $coefficient ) ? $selected = ' selected="selected"' : '';
                                                    $default_text = ($coefficient == $default_font_size) ? esc_html__('(Default)', 'udesign') : '';
                                                    echo '<option value="'.$coefficient.'"'.$selected.'>'.$coefficient.' '.$default_text.'</option>';
                                                } ?>
                                            </select>
                                    </label>
                                    <div style="clear:both;"><span class="description"><?php esc_html_e('The Font Size Coefficient is multiplied by the actual heading size in "em".', 'udesign'); ?></span></div>
<?php                           endif; ?>
    <?php 
    return ob_get_clean();
}


function get_udesign_text_area_1_dummy_content() {
    $admin_email = get_option('admin_email');
    return <<<XML
Questions? &nbsp; <i class="fa fa-phone"></i> <a href="tel:+0009876543">+(000) 987-6543</a> &nbsp; <i class="fa fa-envelope-o"></i> [safe_email]{$admin_email}[/safe_email]
XML;
}

// let's begin...
new UDesign_Theme_Options();




