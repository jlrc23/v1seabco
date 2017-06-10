<?php
/*
Plugin Name: U-Design WooCommerce Integration
Plugin URI: 
Description: Make the U-Design WordPress theme compatible with WooCommerce plugin.
Author: Andon
Version: 2.1.18
Author URI: http://themeforest.net/user/AndonDesign/portfolio?ref=AndonDesign
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


class UDesign_Woo_Commerce {
	var $plugin_path;
	var $plugin_url;
	
	public function __construct() {
		// Set Plugin Path
		$this->plugin_path = dirname(__FILE__);
	
		// Set Plugin URL
		$this->plugin_url = WP_PLUGIN_URL . '/u-design-woocommerce';
		
	        // Init Hook
	        add_action( 'wp_enqueue_scripts', array(&$this, 'init'), 20 );
                add_action('plugins_loaded', array($this, 'udesign_woocommerce_plugin'));
	}
        
        public function init() {
            // Enqueue plugin files (front end)
            if ( !is_admin() ) $this->udesign_woocommerce_enqueue_plugin_files();
            
            // Load the textdomain function
            $this->load_udesign_woocommerce_textdomain();
        }
        
	protected function udesign_woocommerce_enqueue_plugin_files() {
            wp_enqueue_style('u-design-woocommerce-styles', $this->plugin_url . '/css/udesign-woocommerce-style.css', false, '2.1.18');
            global $udesign_options;
            if ( $udesign_options['enable_responsive'] ) {
                wp_enqueue_style('u-design-woocommerce-responsive', $this->plugin_url . '/css/udesign-woocommerce-responsive.css', false, '2.1.18');
            }
            if ( is_shop() || is_product() || is_product_category() ) {
                // remove theme's default breadcrumbs from WC's shop and products pages
                remove_action('udesign_page_content_top', 'udesign_display_breadcrumbs');
                // remove default WC title on single products pages
                function remove_default_wc_title() { return false; }
                add_filter( 'woocommerce_show_page_title', 'remove_default_wc_title' );
            }
        }
        
        public function load_udesign_woocommerce_textdomain() {
            $domain = 'udesign-woocommerce';
            $locale = apply_filters('plugin_locale', get_locale(), $domain);

            load_textdomain( $domain, WP_LANG_DIR.'/u-design-woocommerce/'.$domain.'-'.$locale.'.mo' );
            load_plugin_textdomain( $domain, false, dirname( plugin_basename(__FILE__) ).'/languages/' );
        }
        
        public function udesign_woocommerce_plugin() {
                
                // Declare WooCommerce support
                add_theme_support('woocommerce');
                
                // Load the plugin's text domain for translations
                if (function_exists('load_plugin_textdomain')) {
                    load_plugin_textdomain( 'udesign-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
                }
            
                /**
                 * Load respective lightbox gallery for single product pages
                 */
                if ( version_compare( WC_VERSION, '3.0.0', '<' ) ) {
                    // Prevent prettyPhoto script from being loaded twice, once by the theme and once by the WooCommerce plugin. Dequeue the ones loaded by WooCommerce
                    function udesign_wc_init_scripts() {
                        if ( wp_script_is("prettyPhoto") || wp_style_is("prettyPhoto-init") ) {
                            wp_dequeue_script( 'prettyPhoto' );
                            wp_dequeue_script( 'prettyPhoto-init' );
                        }
                    }            
                    function udesign_wc_init_styles() {
                        if ( wp_style_is("woocommerce_prettyPhoto_css") ) {
                            wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
                        }
                    }
                    add_action('wp_enqueue_scripts', 'udesign_wc_init_styles', 12);
                    add_action('wp_enqueue_scripts', 'udesign_wc_init_scripts', 12);
            
                    // change data-rel to rel for the prettyPhoto link  attribute
                    function change_rel_attr_for_wc_prettyPhoto ($image_thumbnail_html){
                        $pattern = '/' . preg_quote( 'data-rel="prettyPhoto', '/' ) . '/';
                        //$pattern = '/data-rel="prettyPhoto/';
                        $replacement = 'rel="prettyPhoto'; 
                        return preg_replace( $pattern, $replacement, $image_thumbnail_html );
                    }
                    add_filter( 'woocommerce_single_product_image_html', 'change_rel_attr_for_wc_prettyPhoto', 20);
                    add_filter( 'woocommerce_single_product_image_thumbnail_html', 'change_rel_attr_for_wc_prettyPhoto', 20);
                } else { // if WooComm 3.0.0+
                    /**
                     * Added in WC 3.0.0 (2017-04-04)
                     * New gallery on single product pages with better mobile support, using PhotoSwipe and Zoom. 
                     * Declare support with add_theme_support() – wc-product-gallery-zoom, wc-product-gallery-lightbox, wc-product-gallery-slider
                     */
                    //add_theme_support( 'wc-product-gallery-zoom' );
                    add_theme_support( 'wc-product-gallery-lightbox' );
                    //add_theme_support( 'wc-product-gallery-slider' );
                }
                
                    
                // Register widgets
                include_once( 'widgets/widget-ud-wc-cart.php' );
                
                function udesign_wc_post_thumbnails_setup() {
                    remove_theme_support( 'post-thumbnails' );
                    add_theme_support( 'post-thumbnails', array( 'post', 'page', 'movie', 'product' ) );
                }
                add_action('after_setup_theme', 'udesign_wc_post_thumbnails_setup');

                 // Remove the WooCommerce Logout link from main menu
                remove_filter( 'wp_nav_menu_items', 'woocommerce_nav_menu_items' );

                // First unhook the WooCommerce wrappers
                remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
                remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

                
                function udesign_theme_wrapper_start() {
                    global $udesign_options;
                    $content_position = ( $udesign_options['pages_sidebar_8'] == 'left' ) ? 'grid_16 push_8' : 'grid_16';
                    echo '<div id="content-container" class="container_24">';
                    echo '    <div id="main-content" class="'.$content_position.'">';
                    echo '        <div class="main-content-padding">';
                }
                function udesign_theme_wrapper_end() {
                    echo '        </div><!-- end main-content-padding -->';
                    echo '    </div><!-- end main-content -->';
                    if( sidebar_exist('PagesSidebar8') ) { get_sidebar('PagesSidebar8'); }
                    echo '</div><!-- end content-container -->';
                }
                // Then hook in functions to display the wrappers the "U-Design" theme requires:
                add_action('woocommerce_before_main_content', 'udesign_theme_wrapper_start', 10);
                add_action('woocommerce_after_main_content', 'udesign_theme_wrapper_end', 10);



                // Remove the Sidebar
                remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

                
                // Replace default WooCommerce Breadcrumb
                // Note: see "udesign_woocommerce_enqueue_plugin_files()" above for the removeal of theme's default breadcrumbs on shop and products pages
                remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
                function udesign_wc_breadcrumbs() {
                    global $udesign_options;
                    if ( isset( $udesign_options['show_breadcrumbs'] ) && $udesign_options['show_breadcrumbs'] == 'yes') {
                        add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 9 );
                    } else {
                        function udesign_wc_no_breadcrumbs() { echo '<div class="no-breadcrumbs-padding"></div>'; }
                        add_action( 'woocommerce_before_main_content', 'udesign_wc_no_breadcrumbs' , 9 );
                    }
                     
                }
                add_action('after_setup_theme', 'udesign_wc_breadcrumbs');
                
                function udesign_woocommerce_breadcrumbs() {
                    $delimiter = ( is_rtl() ) ? '&larr;' : '&rarr;';
                    return array(
                            'delimiter'  => '<span class="breadarrow"> '.$delimiter.' </span>',
                            'wrap_before'  => '<div id="breadcrumbs-container" class="container_24"><p class="breadcrumbs" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
                            'wrap_after' => '</p></div>',
                            'before'   => '',
                            'after'   => '',
                            'home'    => __( 'Home', 'udesign-woocommerce' ),
                        );
                }
                add_filter( 'woocommerce_breadcrumb_defaults', 'udesign_woocommerce_breadcrumbs' ); 
                
                
                // Set WooCommerce image dimensions
                global $pagenow;
                if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action('init', 'woo_install_theme', 1);
                function woo_install_theme() {
                    update_option( 'woocommerce_catalog_image_width', '180' );
                    update_option( 'woocommerce_catalog_image_height', '180' );
                    update_option( 'woocommerce_single_image_width', '442' );
                    update_option( 'woocommerce_single_image_height', '442' );
                    update_option( 'woocommerce_thumbnail_image_width', '200' );
                    update_option( 'woocommerce_thumbnail_image_height', '200' );

                    // Hard Crop [0 = false, 1 = true]
                    update_option( 'woocommerce_catalog_image_crop', 0 );
                    update_option( 'woocommerce_single_image_crop', 0 );
                    update_option( 'woocommerce_thumbnail_image_crop', 0 );
                }
                
                // Change number related products
                add_filter('woocommerce_output_related_products_args', 'udesign_change_number_related_products');
                function udesign_change_number_related_products( $args ) {
                    $args['posts_per_page'] = 3; // number of related products
                    $args['columns'] = 3; // number of columns per row
                    $args['orderby'] = 'rand'; // display products in random order
                    return $args;
                }
                
                // Style the WooCommerce Login Widget with the consisntent for the theme bullet list style 
                function udesign_woocommerce_filter_widget( $params ) {
                    switch( _get_widget_id_base($params[0]['widget_id']) ) {
                        case 'woocommerce_login':
                        case 'product_categories':
                        case 'woocommerce_product_categories':
                              $params[0]['before_widget'] = str_replace( 'substitute_widget_class', 'custom-formatting', $params[0]['before_widget'] ); // add the 'custom-formatting' class
                              return $params;
                              break;
                        default:
                              return $params;
                    }
                }
                add_filter('dynamic_sidebar_params','udesign_woocommerce_filter_widget');
               
                // Fix the bullet padding for "Product Categories" widget when empty
                function wc_product_cats_widget_args( $cat_args ) {
                    $cat_args['show_option_none']  = '<span style="padding:5px 5px 5px 22px; display:block;">' . __('No product categories exist.', 'udesign-woocommerce') . '</span>';
                    return $cat_args;
                }
                add_filter( 'woocommerce_product_categories_widget_args', 'wc_product_cats_widget_args' );
         
                
                // Fix the posts' count under a product category into the a-tag when listing the categories
                function udesign_woocommerce_product_categories_widget_args( $html ) {
                    $html = preg_replace( '/\<\/a\> \<span class=\"count\"\>\((.*)\)\<\/span\>/', ' <span class="posts-counter">($1)</span></a>', $html );
                    return $html;
                }
                add_filter('wp_list_categories', 'udesign_woocommerce_product_categories_widget_args');
                
                
                // Remove the product rating display on product loops
                remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

                // Add Dynamic Styles
                function udesign_wc_insert_dynamic_css() {
                    global $udesign_options;
                    $css  = "\r\n";
                    $css .= '<style type="text/css">';
                    $css .=     'ul.products li.product .price .from, .order-info mark  { color:#'.$udesign_options['body_text_color'].'; }';
                    $css .= '</style>';
                    echo $css;
                }
                add_action('wp_head', 'udesign_wc_insert_dynamic_css');
                
                // Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
                function udesign_woocommerce_header_add_to_cart_fragment( $fragments ) {
                        global $woocommerce;
                        ob_start();
                        ?>
                        <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'udesign-woocommerce'); ?>"><?php echo sprintf(_n('Cart: %d item', 'Cart: %d items', $woocommerce->cart->cart_contents_count, 'udesign-woocommerce'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
                        <?php
                        $fragments['a.cart-contents'] = ob_get_clean();
                        return $fragments;
                }
                add_filter('woocommerce_add_to_cart_fragments', 'udesign_woocommerce_header_add_to_cart_fragment');
                
                // add custom pagination with WP-PageNavi
                if( function_exists('wp_pagenavi') ) {
                    remove_action('woocommerce_pagination', 'woocommerce_pagination', 10);
                    function woocommerce_pagination() {
                        wp_pagenavi(); 		
                    }
                    add_action( 'woocommerce_pagination', 'woocommerce_pagination', 10);
                }
                
                                
                // Remove custom frame from WooCommerce widget images when this option is enabled for theme's "Blog Section"
                function udesign_wc_widget_thumbnails_cleanup() {
                    if ( has_filter( 'post_thumbnail_html', 'udesign_post_image_html' ) ) {
                        // Filter the "Featured Image" with this theme's custom image frame with alignment. Exclude the WooCommerce widget images
                        function udesign_woocommerce_post_image_html( $html, $post_id, $post_image_id ) {
                            if ( !preg_match('/shop_thumbnail|shop_catalog/', $html) ) {
                                $html = preg_replace('/title=\"(.*?)\"/', '', $html);
                                preg_match( '/aligncenter|alignleft|alignright/', $html, $matches );
                                $image_alignment = ( isset( $matches[0] ) ) ? $matches[0] : '';
                                $html = preg_replace('/aligncenter|alignleft|alignright/', 'alignnone', $html);
                                $html = '<span class="custom-frame '.$image_alignment.'"><a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $html . '</a></span>';
                                if( $image_alignment == 'aligncenter' ) $html = '<div style="text-align:center;">'.$html.'</div>';
                            }
                            return $html;
                        }
                        remove_filter( 'post_thumbnail_html', 'udesign_post_image_html' );
                        add_filter( 'post_thumbnail_html', 'udesign_woocommerce_post_image_html', 10, 3 );
                    }
                }
                add_action('after_setup_theme', 'udesign_wc_widget_thumbnails_cleanup');
                
        }
        
}


// Get the current theme name (always from parent theme)
$curr_theme_obj = ( function_exists('wp_get_theme') ) ? wp_get_theme() : false;
if ( $curr_theme_obj && $curr_theme_obj->exists() ) { // if WordPress v3.4+
    $curr_theme = ( $curr_theme_obj->parent() ) ? $curr_theme_obj->parent() : $curr_theme_obj;
    $curr_theme_name = $curr_theme->get('Name');
} else {
    $curr_theme_name = get_current_theme();
}

// Check if "U-Design" theme and WooCommerce are currently active, and only then run this plugin...
if ( ( $curr_theme_name == "U-Design" ) && in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    $uDesignWooCommerce = new UDesign_Woo_Commerce();
}

