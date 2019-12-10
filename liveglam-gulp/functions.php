<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
// Start writing your functions here

// Include the TGM_Plugin_Activation class.
require_once get_theme_file_path( '/inc/class-tgm-plugin-activation.php');
add_action( 'tgmpa_register', 'liveglam_register_required_plugins' );

function liveglam_theme_support() {
    add_theme_support( 'automatic-feed-links' );

    add_theme_support( 'title-tag' );

    if ( ! current_theme_supports( 'post-thumbnails' ) ) {
        add_theme_support( 'post-thumbnails' );
    }

    add_theme_support( 'woocommerce' );

    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    add_theme_support( 'post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
    ) );
  add_theme_support( 'yoast-seo-breadcrumbs' );
}

add_action( 'after_setup_theme', 'liveglam_theme_support' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function liveglam_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'liveglam_content_width', 1600 );
}
add_action( 'after_setup_theme', 'liveglam_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function liveglam_widgets_init() {

    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'liveglam' ),
        'id'            => 'sidebar-1',
        'description'   => 'The main sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Shop Sidebar', 'liveglam' ),
        'id'            => 'sidebar-shop',
        'description'   => 'The sidebar for the shop pages',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Area 1', 'liveglam' ),
        'id'            => 'footer-area-1',
        'description'   => 'The sidebar for footer column 1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Area 2', 'liveglam' ),
        'id'            => 'footer-area-2',
        'description'   => 'The sidebar for footer column 2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Area 3', 'liveglam' ),
        'id'            => 'footer-area-3',
        'description'   => 'The sidebar for footer column 3',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Area 4', 'liveglam' ),
        'id'            => 'footer-area-4',
        'description'   => 'The sidebar for footer column 4',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'liveglam_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function liveglam_scripts() {

    global $liveglam_admin;

    wp_enqueue_style( 'liveglam-style', get_stylesheet_uri() );

    wp_enqueue_style( 'liveglam-accordion-style','' );

    wp_enqueue_script( 'liveglam-skip-link-focus-fix', get_stylesheet_directory_uri() . '/assets/js/skip-link-focus-fix.min.js', array(), '20130115', true );

    if ($liveglam_admin['opt-smoothscroller'] == true){

        wp_enqueue_script( 'liveglam-smoothscrolling', get_stylesheet_directory_uri() . '/assets/js/smoothscrolling.min.js', array('jquery'), '', true );
    }

    wp_enqueue_script( 'jquery-ui-accordion' );

    wp_enqueue_script( 'liveglam-theme-custom-js', get_stylesheet_directory_uri() . '/assets/js/theme-custom-js.min.js', array('jquery'), '', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'liveglam_scripts', 30 );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

// Change Excerpt length
function liveglam_custom_excerpt_length( $length ) {
    return 50;
}
add_filter( 'excerpt_length', 'liveglam_custom_excerpt_length', 999 );

// Set woocommerce max related products
function woo_related_products_limit() {
    global $product;
    $args['posts_per_page'] = 6;
    return $args;
}

// Ensure cart contents update when products are added to the cart via AJAX
add_filter( 'woocommerce_add_to_cart_fragments', 'liveglam_woocommerce_header_add_to_cart_fragment' );
function liveglam_woocommerce_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    ?>

    <?php if ( class_exists( 'WooCommerce' ) ) { ?>

        <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_html_e( 'View your shopping cart', 'livegla_new'); ?>">
            <div class="header-cart-icon-wrapper">
                <div class="header-cart-icon">
                </div>
                <div class="cart-counter"><?php echo WC()->cart->cart_contents_count; ?>
                </div>
            </div>
        </a>

    <?php } ?>


    <?php

    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}

function liveglam_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin pre-packaged with a theme.

        array(
            'name'          => 'Advanced Filters', // The plugin name
            'slug'          => 'ct-woofiltering', // The plugin slug (typically the folder name)
            'source'            => 'http://demo.elusivethemes.com/plugins/ct-woofiltering.zip', // The plugin source
            'required'          => false, // If false, the plugin is only 'recommended' instead of required
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
        ),

        array(
            'name'          => 'Woocommerce', // The plugin name
            'slug'          => 'woocommerce', // The plugin slug (typically the folder name)
            'required'          => false, // If false, the plugin is only 'recommended' instead of required
        )

    );

    $theme_text_domain = 'Liveglam';

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'tgmpa' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'tgmpa'  ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'tgmpa'  ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'tgmpa'  ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'tgmpa'  ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'tgmpa'  ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'tgmpa'  ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'tgmpa'  ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'tgmpa'  ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'tgmpa'  ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'tgmpa'  ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );
}

//* Customize [...] in WordPress excerpts
add_filter( 'the_excerpt', 'liveglam_read_more_custom_excerpt' );
function liveglam_read_more_custom_excerpt( $text ) {
    if ( strpos( $text, '[&hellip;]') ) {
        $excerpt = str_replace( '[&hellip;]', '...', $text );
    } else {
        $excerpt = $text . '...';
    }
    return $excerpt;
}

function newrelic_admin() {
  if (extension_loaded('newrelic')) {
    //load monitoring for wp-admin
    newrelic_set_appname('Backend');
  }
}
add_action( 'admin_init', 'newrelic_admin', 1 );

//do not use drop-down custom fields for Yoast SEO
add_filter('postmeta_form_limit','postmeta_form_limit',1);
function postmeta_form_limit(){
  return 0;
}

if( function_exists('acf_add_local_field_group') ):

  acf_add_local_field_group(array(
    'key' => 'group_5a49bef1ecd76',
    'title' => 'Blog Category',
    'fields' => array(
      array(
        'key' => 'field_5a49bf3155101',
        'label' => 'Category Color',
        'name' => 'category_color',
        'type' => 'color_picker',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'taxonomy',
          'operator' => '==',
          'value' => 'category',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
  ));

endif;

function dj_limit_postmeta( $string, $post ) {
  return array(null);
}
add_filter( 'postmeta_form_keys', 'dj_limit_postmeta', 10, 3 );

/* Disable WordPress Admin Bar for all users but admins. */
show_admin_bar(true);
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
  if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
  }
}

//increase action scheduler batch size
function eg_increase_action_scheduler_batch_size( $batch_size ) {
  if (!empty(AS_BATCH_SIZE)) return AS_BATCH_SIZE;
  return 500;
}

function eg_increase_action_scheduler_concurrent_batches( $concurrent_batches ) {
  if (!empty(AS_CONCURRENT_PROCESSES)) return AS_CONCURRENT_PROCESSES;
  return 10;
}
add_filter( 'action_scheduler_queue_runner_concurrent_batches', 'eg_increase_action_scheduler_concurrent_batches' );

add_filter( 'action_scheduler_queue_runner_batch_size', 'eg_increase_action_scheduler_batch_size' );

function removingDashboardWidgets()
{
  remove_meta_box( 'woocommerce_dashboard_status', 'dashboard', 'normal');
  remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', 'removingDashboardWidgets' );

/*Disable access to wp-admin except admin*/
add_action('admin_init', 'no_mo_dashboard');
function no_mo_dashboard(){
  global $current_user;
  if (is_user_logged_in()) {
      $roles_allow = array('administrator', 'wpseo_manager', 'wpseo_editor', 'shop_manager', 'duo_security', 'editor', 'cha', 'lg_editor', 'shop_manager_l1', 'cha_manager', 'fulfillment_manager', 'ui_ux_designer', 'chff_coordinator', 'assistant_fulfillment_manager', 'community_associate', 'director_bizdev_ops', 'shop_manager_live', 'influencer_manager', 'content_manager', 'community_manager', 'cro_manager', 'communications_manager');
    if (!in_array($current_user->roles[0], $roles_allow) && @$_SERVER['DOING_AJAX'] != '/wp-admin/admin-ajax.php') {
      wp_redirect(home_url('/my-account')); exit;
    }
  }
}

//redirect to checkout
add_filter ('woocommerce_add_to_cart_redirect', 'redirect_to_checkout',20);
function redirect_to_checkout( $url ) {
    if ( isset( $_REQUEST['add-to-cart'] ) && is_numeric( $_REQUEST['add-to-cart'] ) ) {
        $productID = (int)$_REQUEST['add-to-cart'];
        if( WC_Subscriptions_Product::is_subscription( $productID ) || ( has_term( 76, 'product_cat', $productID ) && isset($_REQUEST['redeem_rewards']) ) || $productID == BUY_POINT_ID ){
            $url = wc_get_checkout_url();
        }
    }
    return $url;
}

//remove woocommerce product page tabs
//remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

/* Remove Checkout Fields */
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {
unset($fields['billing']['billing_company']);
unset($fields['order']['order_comments']);
unset($fields['shipping']['shipping_company']);
return $fields;
}
/* Remove Checkout Fields */

/**logout redirect to homepage**/
add_action('wp_logout','go_home');
function go_home(){
  wp_redirect( home_url() );
  exit();
}

//show only available shipping methods
add_filter( 'woocommerce_available_shipping_methods', 'cj_woocommerce_available_shipping_methods' );

function cj_woocommerce_available_shipping_methods( $available_methods ) {
  if ( isset( $available_methods['free_shipping'] ) ) {
    foreach ( $available_methods as $key => $value ) {
      if ( 'free_shipping' != $key ) {
        unset( $available_methods[ $key ] );
      }
    }
  }

  return $available_methods;
}

//Hieu: test remove taxes by use taxClass
add_filter('woocommerce_checkout_create_order_tax_item','lg_remove_tax_for_product_category',10,1);
function lg_remove_tax_for_product_category( $items ){
  $need_reload_items = false;
  foreach ( WC()->cart->get_cart_contents() as $cart_item_key => $item ) {
    if( has_term( 76, 'product_cat', $item['product_id'] ) && isset($item['redeem_rewards']) ) {
      $need_reload_items = true;
      break;
    }
  }
  if( $need_reload_items ){
    $items->set_props( array(
      'rate_code'          => '',
      'rate_id'            => 0,
      'label'              => '',
      'compound'           => false,
      'tax_total'          => 0,
      'shipping_tax_total' => 0,
    ) );
  }
}

add_action('woocommerce_checkout_update_order_meta','lgs_woocommerce_checkout_update_order_meta',20,1);
function lgs_woocommerce_checkout_update_order_meta($order_id){
    $order = wc_get_order($order_id);
    foreach ( $order->get_items() as $cart_item_key => $item ) {
        if( has_term( 76, 'product_cat', $item['product_id'] ) && isset($item['redeem_rewards']) ) {
            update_post_meta($order_id,'_order_tax',0);
            break;
        }
    }
}


// ADD IF MENU RULE
add_filter( 'if_menu_conditions', 'vop_new_menu_conditions' );

function vop_new_menu_conditions( $conditions ) {
  $conditions[] = array(
    'name'    =>  'User Bought Course',
    'condition' =>  function($item) {          // callback - must return TRUE or FALSE
      $user_id = get_current_user_id();
      $courses = ld_get_mycourses($user_id);
      if ( empty($courses) ) {
        return false;
      } else {
        return true;
      }
    }
  );

  return $conditions;

}


add_filter( 'if_menu_conditions', 'vop_new_menu_conditions2' );

function vop_new_menu_conditions2( $conditions ) {
  $conditions[] = array(
    'name'    =>  'If Bought Morphe',
    'condition' =>  function($item) {  // callback - must return TRUE or FALSE
       // $user_id = get_current_user_id();

    $current_user = wp_get_current_user();
    $email = $current_user->email;
    if ( woocommerce_customer_bought_product( $email, $current_user->ID, '2592')){
return true;
}
else if ( woocommerce_customer_bought_product( $email, $current_user->ID, '2591')){
return true;
}
else{
return false;
}

    }
  );

  return $conditions;

}



add_filter( 'if_menu_conditions', 'vop_new_menu_conditions3' );

function vop_new_menu_conditions3( $conditions ) {
  $conditions[] = array(
    'name'    =>  'If Bought Sarah',
    'condition' =>  function($item) {  // callback - must return TRUE or FALSE
       // $user_id = get_current_user_id();

    $current_user = wp_get_current_user();
    $email = $current_user->email;
    if ( woocommerce_customer_bought_product( $email, $current_user->ID, '43885')){
return true;
}else{
return false;
}

    }
  );

  return $conditions;

}


add_filter( 'if_menu_conditions', 'vop_new_menu_conditions4' );

function vop_new_menu_conditions4( $conditions ) {
  $conditions[] = array(
    'name'    =>  'if bought any cert',
    'condition' =>  function($item) {  // callback - must return TRUE or FALSE
    $current_user = wp_get_current_user();
    $email = $current_user->email;
    if ( woocommerce_customer_bought_product( $email, $current_user->ID, '43885')){
    return true;
  }
  else if( woocommerce_customer_bought_product( $email, $current_user->ID, '2035')){
    return true;
  }
  else if( woocommerce_customer_bought_product( $email, $current_user->ID, '2469')){
    return true;
  }
  else if( woocommerce_customer_bought_product( $email, $current_user->ID, '1604')){
    return true;
  }
  else if( woocommerce_customer_bought_product( $email, $current_user->ID, '1488')){
    return true;
  }
  else if( woocommerce_customer_bought_product( $email, $current_user->ID, '755')){
    return true;
  }
  else if( woocommerce_customer_bought_product( $email, $current_user->ID, '17411')){
    return true;
  }
  else{
  return false;
  }
    }
  );

  return $conditions;

}

/**
 * @author Pat Clark
 * @copyright 2016 adds if bought nicol
 */

add_filter( 'if_menu_conditions', 'vop_new_menu_conditions69' );

function vop_new_menu_conditions69( $conditions ) {
  $conditions[] = array(
    'name'    =>  'Bought Nicol',
    'condition' =>  function($item) {  // callback - must return TRUE or FALSE
       // $user_id = get_current_user_id();

    $current_user = wp_get_current_user();
    $email = $current_user->email;
    if ( woocommerce_customer_bought_product( $email, $current_user->ID, '77908')){
return true;
}else{
return false;
}

    }
  );

  return $conditions;

}


/**apply styling to wp-login**/
function my_login_logo() { ?>
  <style type="text/css">
    .login h1 a {
      background-color:#000;
  margin-bottom: -20px;
  background-size: 155px !important;
          }
.wp-core-ui .button.button-large {
  background: #000;
  border: 0px;
  box-shadow: none;
  text-shadow: none;
  border-radius: 0px;
  width: 100%;
  margin-top: 15px;
  height: 40px;
}
  </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );


/**change wp-login logo link and tooltip**/

function loginpage_custom_link() {
  return home_url();
}
add_filter('login_headerurl','loginpage_custom_link');


function change_title_on_logo() {
  return 'Liveglam';
}
add_filter('login_headertext', 'change_title_on_logo');


add_filter( 'woocommerce_return_to_shop_redirect', 'return_to_shop_link' );

function return_to_shop_link() {
   $homeurl = get_home_url();
   return $homeurl;
}

/**
* Better Pre-submission Confirmation
* http://gravitywiz.com/2012/08/04/better-pre-submission-confirmation/
*/
class GWPreviewConfirmation {

  private static $lead;

  public static function init() {
    add_filter( 'gform_pre_render', array( __class__, 'replace_merge_tags' ) );
  }

  public static function replace_merge_tags( $form ) {

    $current_page = isset(GFFormDisplay::$submission[$form['id']]) ? GFFormDisplay::$submission[$form['id']]['page_number'] : 1;
    $fields = array();
    if(!isset($form['fields'])) return;
    // get all HTML fields on the current page
    foreach($form['fields'] as &$field) {

      // skip all fields on the first page
      if(rgar($field, 'pageNumber') <= 1)
        continue;

      $default_value = rgar($field, 'defaultValue');
      preg_match_all('/{.+}/', $default_value, $matches, PREG_SET_ORDER);
      if(!empty($matches)) {
        // if default value needs to be replaced but is not on current page, wait until on the current page to replace it
        if(rgar($field, 'pageNumber') != $current_page) {
          $field['defaultValue'] = '';
        } else {
          $field['defaultValue'] = self::preview_replace_variables($default_value, $form);
        }
      }

      // only run 'content' filter for fields on the current page
      if(rgar($field, 'pageNumber') != $current_page)
        continue;

      $html_content = rgar($field, 'content');
      preg_match_all('/{.+}/', $html_content, $matches, PREG_SET_ORDER);
      if(!empty($matches)) {
        $field['content'] = self::preview_replace_variables($html_content, $form);
      }

    }

    return $form;
  }

  /**
  * Adds special support for file upload, post image and multi input merge tags.
  */
  public static function preview_special_merge_tags($value, $input_id, $merge_tag, $field) {

    // added to prevent overriding :noadmin filter (and other filters that remove fields)
    if( ! $value )
      return $value;

    $input_type = RGFormsModel::get_input_type($field);

    $is_upload_field = in_array( $input_type, array('post_image', 'fileupload') );
    $is_multi_input = is_array( rgar($field, 'inputs') );
    $is_input = intval( $input_id ) != $input_id;

    if( !$is_upload_field && !$is_multi_input )
      return $value;

    // if is individual input of multi-input field, return just that input value
    if( $is_input )
      return $value;

    $form = RGFormsModel::get_form_meta($field['formId']);
    $lead = self::create_lead($form);
    $currency = GFCommon::get_currency();

    if(is_array(rgar($field, 'inputs'))) {
      $value = RGFormsModel::get_lead_field_value($lead, $field);
      return GFCommon::get_lead_field_display($field, $value, $currency);
    }

    switch($input_type) {
    case 'fileupload':
      $value = self::preview_image_value("input_{$field['id']}", $field, $form, $lead);
      $value = self::preview_image_display($field, $form, $value);
      break;
    default:
      $value = self::preview_image_value("input_{$field['id']}", $field, $form, $lead);
      $value = GFCommon::get_lead_field_display($field, $value, $currency);
      break;
    }

    return $value;
  }

  public static function preview_image_value($input_name, $field, $form, $lead) {

    $field_id = $field['id'];
    $file_info = RGFormsModel::get_temp_filename($form['id'], $input_name);
    $source = RGFormsModel::get_upload_url($form['id']) . "/tmp/" . $file_info["temp_filename"];

    if(!$file_info)
      return '';

    switch(RGFormsModel::get_input_type($field)){

      case "post_image":
        list(,$image_title, $image_caption, $image_description) = explode("|:|", $lead[$field['id']]);
        $value = !empty($source) ? $source . "|:|" . $image_title . "|:|" . $image_caption . "|:|" . $image_description : "";
        break;

      case "fileupload" :
        $value = $source;
        break;

    }

    return $value;
  }

  public static function preview_image_display($field, $form, $value) {

    // need to get the tmp $file_info to retrieve real uploaded filename, otherwise will display ugly tmp name
    $input_name = "input_" . str_replace('.', '_', $field['id']);
    $file_info = RGFormsModel::get_temp_filename($form['id'], $input_name);

    $file_path = $value;
    if(!empty($file_path)){
      $file_path = esc_attr(str_replace(" ", "%20", $file_path));
      $value = "<a href='$file_path' target='_blank' title='" . __("Click to view", "gravityforms") . "'>" . $file_info['uploaded_filename'] . "</a>";
    }
    return $value;

  }

  /**
  * Retrieves $lead object from class if it has already been created; otherwise creates a new $lead object.
  */
  public static function create_lead( $form ) {

    if( empty( self::$lead ) ) {
      self::$lead = GFFormsModel::create_lead( $form );
      self::clear_field_value_cache( $form );
    }

    return self::$lead;
  }

  public static function preview_replace_variables( $content, $form ) {

    $lead = self::create_lead($form);

    // add filter that will handle getting temporary URLs for file uploads and post image fields (removed below)
    // beware, the RGFormsModel::create_lead() function also triggers the gform_merge_tag_filter at some point and will
    // result in an infinite loop if not called first above
    add_filter('gform_merge_tag_filter', array('GWPreviewConfirmation', 'preview_special_merge_tags'), 10, 4);

    $content = GFCommon::replace_variables($content, $form, $lead, false, false, false);

    // remove filter so this function is not applied after preview functionality is complete
    remove_filter('gform_merge_tag_filter', array('GWPreviewConfirmation', 'preview_special_merge_tags'));

    return $content;
  }

  public static function clear_field_value_cache( $form ) {

    if( ! class_exists( 'GFCache' ) )
      return;

    foreach( $form['fields'] as &$field ) {
      if( GFFormsModel::get_input_type( $field ) == 'total' )
        GFCache::delete( 'GFFormsModel::get_lead_field_value__' . $field['id'] );
    }

  }

}

GWPreviewConfirmation::init();


/**change default avatar image**/

add_filter( 'avatar_defaults', 'newgravatar' );
function newgravatar ($avatar_defaults) {
  $myavatar = get_stylesheet_directory_uri().'/assets/img/lgs-profile-image.png';
  $avatar_defaults[$myavatar] = "Own";
  return $avatar_defaults;
}

/**change subscription suspend button name**/
add_filter('wcs_view_subscription_actions', 'iz_change_suppend_button');
function iz_change_suppend_button($actions) {

  if (!empty($actions['suspend'])) {
    $actions['suspend']['name'] = 'Pause Subscription';
  }

  return $actions;

}



function ti_remove_password_strength() {
	if ( !is_account_page() && !is_page('password-rotation') && wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
		wp_dequeue_script( 'wc-password-strength-meter' );
	}
}
add_action( 'wp_print_scripts', 'ti_remove_password_strength', 100 );

//remove product added to cart message
add_filter( 'wc_add_to_cart_message_html', 'custom_add_to_cart_message' );
function custom_add_to_cart_message() {
  global $woocommerce;

    $return_to  = get_permalink(wc_get_page_id('checkout'));
    $message    = "";
  return $message;
}

/**adding scripts for rewards system**/

add_action( 'wp_enqueue_scripts', 'k_enqueue_script', 999 );
function k_enqueue_script(){
  wp_enqueue_script( 'bootstrap-growl-js', get_stylesheet_directory_uri().'/assets/js/jquery.bootstrap-growl.min.js', array(), false, true );
}
/**rewards system script add ends**/


if ( ! function_exists('monthly_brushes') ) {

// Register Custom Post Type for brushes
function monthly_brushes() {

	$labels = array(
		'name'                  => _x( 'all brushes', 'Post Type General Name', 'liveglam' ),
		'singular_name'         => _x( 'brushes', 'Post Type Singular Name', 'liveglam' ),
		'menu_name'             => __( 'brushes', 'liveglam' ),
		'name_admin_bar'        => __( 'brushes', 'liveglam' ),
		'archives'              => __( 'Item Archives', 'liveglam' ),
		'parent_item_colon'     => __( 'Parent Item:', 'liveglam' ),
		'all_items'             => __( 'All Items', 'liveglam' ),
		'add_new_item'          => __( 'Add New Item', 'liveglam' ),
		'add_new'               => __( 'Add New', 'liveglam' ),
		'new_item'              => __( 'New Item', 'liveglam' ),
		'edit_item'             => __( 'Edit Item', 'liveglam' ),
		'update_item'           => __( 'Update Item', 'liveglam' ),
		'view_item'             => __( 'View Item', 'liveglam' ),
		'search_items'          => __( 'Search Item', 'liveglam' ),
		'not_found'             => __( 'Not found', 'liveglam' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'liveglam' ),
		'featured_image'        => __( 'Featured Image', 'liveglam' ),
		'set_featured_image'    => __( 'Set featured image', 'liveglam' ),
		'remove_featured_image' => __( 'Remove featured image', 'liveglam' ),
		'use_featured_image'    => __( 'Use as featured image', 'liveglam' ),
		'insert_into_item'      => __( 'Insert into item', 'liveglam' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'liveglam' ),
		'items_list'            => __( 'Items list', 'liveglam' ),
		'items_list_navigation' => __( 'Items list navigation', 'liveglam' ),
		'filter_items_list'     => __( 'Filter items list', 'liveglam' ),
	);
	$args = array(
		'label'                 => __( 'brushes', 'liveglam' ),
		'description'           => __( 'monthly brushes', 'liveglam' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', ),
		'taxonomies'            => array( 'brushes' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
    'menu_icon'             => 'dashicons-admin-customizer',
	);
	register_post_type( 'monthly_brushes', $args );

}
add_action( 'init', 'monthly_brushes', 0 );

}

if ( ! function_exists('testimonials_post_type') ) {

// Register testimonials Post Type
function testimonials_post_type() {

	$labels = array(
		'name'                  => _x( 'testimonials', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'testimonial', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'testimonials', 'text_domain' ),
		'name_admin_bar'        => __( 'testimonials', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'testimonial', 'text_domain' ),
		'description'           => __( 'testimonials from customers', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
		//'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
    'menu_icon'             => 'dashicons-testimonial',
	);
	register_post_type( 'testimonials', $args );

}
add_action( 'init', 'testimonials_post_type', 0 );

  function add_testimonials_taxonomy() {
    register_taxonomy(
      'testimonials_categories',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
      'testimonials',        //post type name
      array(
        'hierarchical' => true,
        'label' => 'Testimonials Categories',  //Display name
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array(
          'slug' => 'Testimonials', // This controls the base slug that will display before each term
          'with_front' => false // Don't display the category base before
        )

      )
    );
}

  add_action( 'init', 'add_testimonials_taxonomy');


}

add_action('restrict_manage_posts','restrict_testimonials_by_category');
function restrict_testimonials_by_category() {
  global $typenow;
  global $wp_query;
  if ($typenow=='testimonials') {
    $taxonomy = 'testimonials_categories';
    $terms = get_terms( $taxonomy );


    if ( $terms ) {
  printf( '<select class="postform" name="%s">', $taxonomy );
        printf( '
    <option selected="selected" value="0">%s</option>', "Show All" );
      foreach ( $terms as $term ) {
      if(isset($_GET["testimonials_categories"])){
      if($_GET["testimonials_categories"] == $term->slug){
        printf( '
        <option selected="selected" value="%s">%s</option>', $term->slug, $term->name );
        }else{
        printf( '
        <option value="%s">%s</option>', $term->slug, $term->name );
        }
      }else{
        printf( '
        <option value="%s">%s</option>', $term->slug, $term->name );
        }
      }
      print( '
 
 
    </select>' );}

		}
	}


  Class WP_Widget_Recent_Comment extends WP_Widget_Recent_Comments {
  public function widget( $args, $instance ) {
    global $comments, $comment;

    $cache = array();
    if ( ! $this->is_preview() ) {
      $cache = wp_cache_get('widget_recent_comments', 'widget');
    }
    if ( ! is_array( $cache ) ) {
      $cache = array();
    }

    if ( ! isset( $args['widget_id'] ) )
      $args['widget_id'] = $this->id;

    if ( isset( $cache[ $args['widget_id'] ] ) ) {
      echo $cache[ $args['widget_id'] ];
      return;
    }

    $output = '';

    $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Comments' );

    /** This filter is documented in wp-includes/default-widgets.php */
    $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

    $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
    if ( ! $number )
      $number = 5;

    /**
     * Filter the arguments for the Recent Comments widget.
     *
     * @since 3.4.0
     *
     * @see WP_Comment_Query::query() for information on accepted arguments.
     *
     * @param array $comment_args An array of arguments used to retrieve the recent comments.
     */
    $comments = get_comments( apply_filters( 'widget_comments_args', array(
      'number'      => $number,
      'status'      => 'approve',
      'post_status' => 'publish',
      'post_type'   => 'post'
    ) ) );

    $output .= $args['before_widget'];
    if ( $title ) {
      $output .= $args['before_title'] . $title . $args['after_title'];
    }

    $output .= '<ul id="recentcomments">';
    if ( is_array( $comments ) && $comments ) {
      // Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
      $post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
      _prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

      foreach ( (array) $comments as $comment) {
        $output .= '<li class="recentcomments">';
        /* translators: comments widget: 1: comment author, 2: post link */
        $output .= sprintf( _x( '%1$s on %2$s', 'widgets' ),
          '<span class="comment-author-link 123333333">' . get_comment_author_link() . '</span>',
          '<a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">' . get_the_title( $comment->comment_post_ID ) . '</a>'
        );
        //$output .= $comment->comment_content;
        $output .= '</li>';
      }
    }
    $output .= '</ul>';
    $output .= $args['after_widget'];

    echo $output;

    if ( ! $this->is_preview() ) {
      $cache[ $args['widget_id'] ] = $output;
      wp_cache_set( 'widget_recent_comments', $cache, 'widget' );
    }
  }
} //new WP_Widget_Recent_Comment();
add_action( 'widgets_init', function(){ register_widget( "WP_Widget_Recent_Comment" );} , 20 );

//remove thank you message from order received page woo subscription
function custom_subscription_thank_you( $order_id ){

  if( wcs_order_contains_subscription( $order_id ) ) {
    $thank_you_message = sprintf( __( '%sThank you! Your subscription has been activated! Visit %syour account%s page for details%s', 'woocommerce-subscriptions' ), '<p>', '<a href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '">', '</a>','</p>' );
    return $thank_you_message;
  }

}
add_filter( 'woocommerce_subscriptions_thank_you_message', 'custom_subscription_thank_you');


//redirect based on product purchased
  function wcs_redirect_product_based($order_id){
    $order = wc_get_order($order_id);
    $url_rd = $page_confirm_slug = '';
    foreach($order->get_items() as $item){
      $product_id = isset($item['product_id'])?$item['product_id']:$item['variation_id'];
      if(has_term(76, 'product_cat', $product_id) && isset($item['redeem_rewards'])){
        $url_rd = site_url('/congrats-redeeming-prize/order-received/?order_id='.$order_id);
        $page_confirm_slug = 'congrats-redeeming-prize';
      }elseif(in_array($product_id, lgs_product_mm)){
        if($order->has_status('waitlist')){
          $url_rd = site_url('/morpheme-waitlist-confirmation/order-received/?order_id='.$order_id);
          $page_confirm_slug = 'morpheme-waitlist-confirmation';
        }elseif(isset($_COOKIE['cookie_payment_failed']) || isset($_COOKIE['cookie_payment_reactive'])){
          $url_rd = site_url('/welcome-back-morpheme/order-received/?order_id='.$order_id);
          $page_confirm_slug = 'welcome-back-morpheme';
        }elseif(isset($_COOKIE['rd_page_upgrade']) && in_array($_COOKIE['rd_page_upgrade'], lgs_product_mm)){
          $url_rd = site_url('/morphe-order-upgrade-confirmed/order-received/?order_id='.$order_id);
          $page_confirm_slug = 'morphe-order-upgrade-confirmed';
        }else{
          $url_rd = site_url('/morphe-order-confirmed/order-received/?order_id='.$order_id);
          $page_confirm_slug = 'morphe-order-confirmed';
        }
      }elseif(in_array($product_id, lgs_product_km)){
        if($order->has_status('waitlist')){
          $url_rd = site_url('/kissme-waitlist-confirmation/order-received/?order_id='.$order_id);
          $page_confirm_slug = 'kissme-waitlist-confirmation';
        }elseif(isset($_COOKIE['rd_page_upgrade']) && in_array($_COOKIE['rd_page_upgrade'], lgs_product_km)){
          $url_rd = site_url('/kissme-order-upgrade-confirmed/order-received/?order_id='.$order_id);
          $page_confirm_slug = 'kissme-order-upgrade-confirmed';
        }elseif(isset($_COOKIE['cookie_payment_failed']) || isset($_COOKIE['cookie_payment_reactive'])){
          $url_rd = site_url('/kissme-welcome-back/order-received/?order_id='.$order_id);
          $page_confirm_slug = 'kissme-welcome-back';
        }else{
          $url_rd = site_url('/kissme-order-confirmed/order-received/?order_id='.$order_id);
          $page_confirm_slug = 'kissme-order-confirmed';
        }
      }elseif(in_array($product_id, lgs_product_sm)){
        if($order->has_status('waitlist')){
          $url_rd = site_url('/shadowme-waitlist-confirmation/order-received/?order_id='.$order_id);
          $page_confirm_slug = 'shadowme-waitlist-confirmation';
        }elseif(isset($_COOKIE['rd_page_upgrade']) && in_array($_COOKIE['rd_page_upgrade'], lgs_product_sm)){
          $url_rd = site_url('/shadowme-order-upgrade-confirmed/order-received/?order_id='.$order_id);
          $page_confirm_slug = 'shadowme-order-upgrade-confirmed';
        }elseif(isset($_COOKIE['cookie_payment_failed']) || isset($_COOKIE['cookie_payment_reactive'])){
          $url_rd = site_url('/shadowme-welcome-back/order-received/?order_id='.$order_id);
          $page_confirm_slug = 'shadowme-welcome-back';
        }else{
          $url_rd = site_url('/shadowme-order-confirmed/order-received/?order_id='.$order_id);
          $page_confirm_slug = 'shadowme-order-confirmed';
        }
      }elseif(in_array($product_id, array(BUY_POINT_ID))){
        $url_rd = site_url('/order-confirmation-page-points/order-received/?order_id='.$order_id);
        $page_confirm_slug = 'order-confirmation-page-points';
      }elseif(has_term(SHOP_CAT, 'product_cat', $product_id) && !isset($item['redeem_rewards'])){
        $url_rd = site_url('/order-confirmation-shop/order-received/?order_id='.$order_id);
        $page_confirm_slug = 'order-confirmation-shop';
      }
      if( !empty( $url_rd ) && !empty( $page_confirm_slug ) ){
        $url_rd = str_replace('&amp;', '&', wp_nonce_url($url_rd, 'confirmation-page'));
        /** check is page exists **/
        $page = get_page_by_path($page_confirm_slug);
        if(!isset($page)){
          $url_rd = $order->get_view_order_url();
        }
        wp_redirect($url_rd);
        exit();
      }
    }
  }
add_action( 'woocommerce_thankyou', 'wcs_redirect_product_based', 1 );

function check_wp_nonce_confirmation_page(){

  if( is_page(LGS_CONFIRMATION_PAGES ) ){

    if( !isset( $_GET['_wpnonce'] ) || !wp_verify_nonce( $_GET['_wpnonce'], 'confirmation-page' ) ) {

      wp_redirect( home_url('/my-account' ) );
      exit();

    }

  }
}
add_action( 'wp_head', 'check_wp_nonce_confirmation_page');

define('LGS_CONFIRMATION_PAGES', array(9999995207,9999995221,9999995229,9999995233,9999511607,9999595188,10000065065,9999698690,10000741883,9999959398,10005383715,10007048408,10007048412,10007048414,10007048416));

function print_google_tracking(){
  if (isset($_GET['order_id'])) {
    $order = wc_get_order($_GET['order_id']);
        if( $order === false ) return;
    ?>
    <!-- Google Code for JF - Google Conversion Code Conversion Page -->
    <script type="text/javascript">
      /* <![CDATA[ */
      var google_conversion_id = 946071802;
      var google_conversion_language = "en";
      var google_conversion_format = "3";
      var google_conversion_color = "ffffff";
      var google_conversion_label = "V-i3CIKYlmMQ-tGPwwM";
      var google_remarketing_only = false;
      /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
    <noscript>
      <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/946071802/?label=V-i3CIKYlmMQ-tGPwwM&amp;guid=ON&amp;script=0"/>
      </div>
    </noscript>
    <!--Bing conversion tracking-->
    <!--<script>
      var uetq = uetq || [];
      uetq.push({
        'ec': 'Ecommerce',
        'ea': 'Purchase',
        'el': 'Successful Sale',
        'ev': '0',
        'gv': '<?php //echo $order->get_total(); ?>'
      });
    </script>-->
    <!--Bing conversion tracking ends-->
    <?php
    remove_action( 'woocommerce_thankyou', 'WC_Subscriptions_Order::subscription_thank_you' );
    remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );
    remove_action( 'woocommerce_thankyou', 'wcs_redirect_product_based', 1 );
    do_action( 'woocommerce_thankyou', $order->get_id() );
  }

}
add_action( 'wp_footer', 'print_google_tracking', 1);

//function to add google tag manager on all pages in head requested by Strawhouse
/*function add_gtm_code(){
  ?>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KVFWSCX');</script>
  <!-- End Google Tag Manager -->
  <?php
}*/

//add_action('wp_head', 'add_gtm_code');

//add GTM just after opening body tag, requested by Strawhouse
/*function gtm_noscript_code(){
  ?>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KVFWSCX"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <?php
}*/
//add_action('after_body_open_tag', 'gtm_noscript_code');

// custom admin login logo
function custom_login_logo() {
  echo '<style type="text/css">
  h1 a { background-image: url('.get_bloginfo('template_directory').'/images/custom_admin_logo.png) !important;background-position:center !important;height:50px !important;width:100% !important;}input#wp-submit{height: 50px;}
  </style>';
}
add_action('login_head', 'custom_login_logo');

function _remove_script_version( $src ){
$parts = explode( '?', $src );
return $parts[0];
}
//add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
//add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

function pw_loading_scripts_blog() {
    $check_blog = get_post_meta(get_the_ID(),'check_blog',true);
  ?>
  <style type="text/css">
    .acf-field-57ad8da4aaf6c ,.acf-field-57ad8dc1aaf6d ,.acf-field-57ad8de4aaf6e {
      display: none;
    }
  </style>
  <script type="text/javascript">
    jQuery(document).ready(function () {
      jQuery('#acf-field_57ad8d3baaf6b').click(function() {
        jQuery('.acf-field-57ad8da4aaf6c').toggle();
        jQuery('.acf-field-57ad8dc1aaf6d').toggle();
        jQuery('.acf-field-57ad8de4aaf6e').toggle();
      });
            <?php  if(isset($check_blog[0]) && $check_blog[0] == "Yes") { ?>
      jQuery('.acf-field-57ad8da4aaf6c').show();
      jQuery('.acf-field-57ad8dc1aaf6d').show();
      jQuery('.acf-field-57ad8de4aaf6e').show();
      <?php  } ?>
    });
  </script>
<?php }
add_action('admin_head', 'pw_loading_scripts_blog');

add_image_size( 'recent-blogs-image', 300, 300, true );
add_action('init', 'download_image');
function download_image()
{
  if (isset($_GET['download_image'])) {
    $theme_dir = get_stylesheet_directory();
    $fullPath = $theme_dir.'/assets/img/'.$_GET['download_image'];
    // File Exists?
    if (!file_exists($fullPath)) return;
    // Parse Info / Get Extension
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);

    // Determine Content Type
    switch ($ext) {
      case "gif":
        $ctype = "image/gif";
        break;
      case "png":
        $ctype = "image/png";
        break;
      case "jpeg":
      case "jpg":
        $ctype = "image/jpg";
        break;
    }

    if (empty($ctype)) return;

    header("Pragma: public"); // required
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false); // required for certain browsers
    header("Content-Type: $ctype");
    header("Content-Disposition: attachment; filename=\"" . basename($fullPath) . "\";");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . $fsize);
    ob_clean();
    flush();
    readfile($fullPath);
  }
}

add_filter('woocommerce_queued_js', 'check_upgrade_js');
function check_upgrade_js($js){
  if( isset( $_COOKIE['rd_page_upgrade'] ) ) {
    if( isset( $_COOKIE['rd_page_upgrade_to_annual'] ) ){
      $text = 'Six_To_Annual';
      if (strpos($js, '"quantity"') !== false) {
        $js = str_replace('"quantity"', '"variant": "upgrade '.$text.'","quantity"', $js);
      }
    } else {
    $product_id = $_COOKIE['rd_page_upgrade'];
    if( in_array($product_id, array(2591,KM_ANNUAL, SM_ANNUAL)) ){
      $text = 'Annual';
    } else {
      $text = 'SixMonth';
    }
    if (strpos($js, '"quantity"') !== false) {
      $js = str_replace('"quantity"', '"variant": "upgrade '.$text.'","quantity"', $js);
    }
  }
  }

  return $js;
}



add_shortcode('number_complete_order','count_number_complete_order' );

function count_number_complete_order($return = false) {

  $cache_get = wp_cache_get("lg_completed_orders", 'stats');
  if ( false !== $cache_get ) {
    $count_order = $cache_get;
  } else {
      global $wpdb ;

      $current_time = current_time('timestamp');
      $start_date = date('Y-m-d 00:00:00', strtotime("first day of last month", $current_time));
      $last_date = date('Y-m-d 23:59:59', strtotime("last day of last month", $current_time));

    $count_order = $wpdb->get_var(
      "SELECT COUNT(posts.ID) 
        FROM {$wpdb->posts} AS posts
        WHERE posts.post_type = 'shop_order' 
        AND posts.post_status = 'wc-completed'
        AND posts.post_date BETWEEN '{$start_date}' AND '{$last_date}'
        "
    );

    wp_cache_set("lg_completed_orders", $count_order, 'stats', 3600);
  }

    $three_times = $count_order * 5;
  //echo $three_times;
  $format_total_count = number_format($three_times);
  if($return){
    return $format_total_count;
  } else{
    echo $format_total_count;
  }
}

/*
 * get display full name by user login
 */
function lgs_get_referrer_name_form_ref( $referrer ){
  $cache_get = wp_cache_get($referrer, 'referrers_username');
  if ( false === $cache_get ) {
    if(is_int($referrer)){
      $user = get_user_by('id', $referrer);
    } else {
      $user = get_user_by('login', $referrer);
    }
    if( $user ){
          $first_name = isset($user->first_name)?$user->first_name:null;
          $last_name = isset($user->last_name)?$user->last_name:null;
          if( !empty( $first_name) && !empty( $last_name ) ) {
            $cache_get = $first_name . ' ' . $last_name;
          } elseif( !empty( $first_name ) ) {
            $cache_get = $first_name;
          } elseif( !empty( $first_name ) ) {
            $cache_get = $last_name;
          } else {
            $cache_get = $user->display_name;
          }
      wp_cache_set( $referrer, $cache_get, 'referrers_username', 3600);
    }
  }
  return $cache_get;
}
function lgs_check_referral_is_block( $referral_code, $product_type = '' ){
  $is_block = false;
  $user = get_user_by('login', $referral_code);
  if( $user ){
    $block_referral = get_option('block_referral_settings');
    if(!is_array($block_referral)){
      $userids = array_filter(array_map('absint', (array)explode(',', $block_referral)));
    }else{
      $userids = $block_referral;
    }
    if(in_array($user->ID, $userids)){
      $is_block = true;
    }
    //check if $product_type is disable
    if( !empty( $product_type ) && !$is_block ){
      switch($product_type){
        case 'morpheme':
          $check_disable = get_option('mm_referral');
          break;
        case 'kissme':
          $check_disable = get_option('km_referral');
          break;
        case 'shadowme':
          $check_disable = get_option('sm_referral');
          break;
      }

      if( $check_disable == 'yes' ){
        $is_block = true;
      }
    }
  }
  return $is_block;
}
/*
 * check referral code is valid
 */
function lgs_check_referral_code_is_valid($referral_code, $product_type, $check_FST = false ){

  if(empty($referral_code) || empty($product_type)  || $referral_code == 'admin') return false;

  $is_valid = false;
  $user = get_user_by('login', $referral_code);
  if(!$user){
    $is_valid = false;
  } else{
    //check if referrer is block or $product_type is block
    if( lgs_check_referral_is_block( $referral_code, $product_type ) ){
      return false;
    }

    if( !is_user_logged_in() ){
      $is_valid = true;
    } elseif(is_user_logged_in()){
      $current_user_ID = get_current_user_id();
      if( $current_user_ID != $user->ID){
        //check if user doesn't have an active sub of this $product_type
        $subscriptions_status = LiveGlam_Subscription_Status::get_status($current_user_ID);
        $status_key = 'get_status_'.$product_type;
        if( in_array( $subscriptions_status[$status_key], array('not-enrolled') ) ){
          $is_valid = true;
        } elseif( in_array( $subscriptions_status[$status_key], array('cancelled') ) && !lgs_check_customer_reactive_in_30day( $current_user_ID, $product_type ) ) {
          $is_valid = true;
        } elseif( in_array( $subscriptions_status[$status_key], array('on-hold','pending') ) && lgs_check_is_payment_for_parent_order_failed() ) {
          $is_valid = true;
        }
        //case check enable FST for cx reactive within 30days
        if( $check_FST && lgs_check_customer_reactive_in_30day( $current_user_ID, $product_type ) ){
          $is_valid = true;
        }
      }
    }
  }
  return $is_valid;
}

  /**
   * function check is cx clear payment for failed order is parent
   * @return bool
   */
function lgs_check_is_payment_for_parent_order_failed(){
  if( WC()->session->order_awaiting_payment > 0 ){
    if( ( $order = wc_get_order( WC()->session->order_awaiting_payment ) ) !== false ){
      if( wcs_order_contains_subscription( $order, array( 'parent' ) ) ){
        return true;
      }
    }
  }
  return false;
}

function lgs_check_customer_reactive_in_30day( $userID, $product_type ){
  $key_group = null;
  switch($product_type){
    case 'morpheme': $key_group = 'mm'; break;
    case 'kissme': $key_group = 'km'; break;
    case 'shadowme': $key_group = 'sm'; break;
  }
  if( !empty($userID) && !empty( $key_group ) ){
    //check customer reactive use code in 30 days
    $daytime_ago = time() - DAY_IN_SECONDS * 30;

    if( !empty( $time_cancel = get_user_meta( $userID, 'lgs_time_cancel_'.$key_group, true ) ) ) {
      if( $time_cancel > $daytime_ago ) {
        return true;
      }
    }
  }
  return false;
}

  /**
   * @param int $userID
   * @param string $club: mm, km, sm
   * @param int $numTime
   * @param string $typeTime
   * check if cx reactivate within range time
   */
function lgs_check_customer_reactivate_in_time( $userID = 0, $club = '', $numTime = 1, $typeTime = 'days'){
  if( !empty($userID) && !empty( $club ) && !empty( $time_cancel = get_user_meta( $userID, 'lgs_time_cancel_'.$club, true ) ) ){
    $daytime_ago = strtotime("- {$numTime} {$typeTime}", time());
    if( $time_cancel > $daytime_ago ) {
      return true;
    }
  }
  return false;
}

/*
 * set product free shipping USA or Canada
 */
function wcs_my_free_shipping( $is_available, $package ) {
  global $woocommerce;
  $rate = reset($package['rates']);
  // set the product ids that are eligible morphe annual, morphe monthly, morphe 6 months
  $eligible = array( 2592, 2591, 9999477214 );

  // get cart contents
  $cart_items = $woocommerce->cart->get_cart();
  // loop through the items looking for one in the eligible array
  foreach ( $cart_items as $key => $item ) {
    if( in_array( $item['product_id'], $eligible ) && !empty($rate)) {
      return false;
    }
  }

  // nothing found return the default value
  return $is_available;
}
add_filter( 'woocommerce_shipping_free_shipping_is_available', 'wcs_my_free_shipping', 20, 2 );

/*
 * set product free shipping anywhere
 */
function wcs_my_flat_rate( $is_available ) {
  global $woocommerce;

  // set the product ids that are eligible
  $eligible = array( 9999689162 );

  $cart_items = $woocommerce->cart->get_cart();
  foreach ( $cart_items as $key => $item ) {
    if( ( has_term( 76, 'product_cat', $item['product_id'] ) && isset($item['redeem_rewards']) ) || in_array( $item['product_id'], $eligible ) ) {
      return false;
    }
  }

  // nothing found return the default value
  return $is_available;
}
add_filter( 'woocommerce_shipping_flat_rate_is_available', 'wcs_my_flat_rate', 20 );

/*
 * add notice "Free shipping in the US & Canada only" on checkout page for product
 */
function add_notice_free_shipping_on_checkout(){
  global $woocommerce;

  $check = false;

  $morpheme = array( 2592, 2591, 9999477214 );

  $cart_items = $woocommerce->cart->get_cart();
  foreach ( $cart_items as $key => $item ) {
    if(  in_array( $item['product_id'], $morpheme ) ) {
      $check = true;
    }
  }

  if( $check ){ ?>
    <tr class="free-shipping">
      <td colspan="2">*Free shipping in the US & Canada only</td>
    </tr>
  <?php }

}
//add_action( 'woocommerce_review_order_after_order_total', 'add_notice_free_shipping_on_checkout', 20 );

//add custom post type FAQs
function faqs() {

  $labels = array(
    'name'                  => _x( 'All FAQs', 'Post Type General Name', 'liveglam' ),
    'singular_name'         => _x( 'faqs', 'Post Type Singular Name', 'liveglam' ),
    'menu_name'             => __( 'FAQs', 'liveglam' ),
    'name_admin_bar'        => __( 'FAQs', 'liveglam' ),
    'archives'              => __( 'Item Archives', 'liveglam' ),
    'parent_item_colon'     => __( 'Parent Item:', 'liveglam' ),
    'all_items'             => __( 'All FAQs', 'liveglam' ),
    'add_new_item'          => __( 'Add New FAQs', 'liveglam' ),
    'add_new'               => __( 'Add New', 'liveglam' ),
    'new_item'              => __( 'New FAQs', 'liveglam' ),
    'edit_item'             => __( 'Edit Item', 'liveglam' ),
    'update_item'           => __( 'Update Item', 'liveglam' ),
    'view_item'             => __( 'View Item', 'liveglam' ),
    'search_items'          => __( 'Search Item', 'liveglam' ),
    'not_found'             => __( 'Not found', 'liveglam' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'liveglam' ),
    'featured_image'        => __( 'Featured Image', 'liveglam' ),
    'set_featured_image'    => __( 'Set featured image', 'liveglam' ),
    'remove_featured_image' => __( 'Remove featured image', 'liveglam' ),
    'use_featured_image'    => __( 'Use as featured image', 'liveglam' ),
    'insert_into_item'      => __( 'Insert into item', 'liveglam' ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', 'liveglam' ),
    'items_list'            => __( 'Items list', 'liveglam' ),
    'items_list_navigation' => __( 'Items list navigation', 'liveglam' ),
    'filter_items_list'     => __( 'Filter items list', 'liveglam' ),
  );
  $args = array(
    'label'                 => __( 'faqs', 'liveglam' ),
    'description'           => __( 'faqs', 'liveglam' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor' ),
    //'taxonomies'            => array( 'post_tag' ),
    'hierarchical'          => false,
    'public'                => true,
    'publicly_queryable'    => true,
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'faqs' ),
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'capability_type'       => 'page',
    'menu_icon'             => 'dashicons-format-chat',
  );
  register_post_type( 'faqs', $args );

}
add_action( 'init', 'faqs', 0 );

// add categories for faqs
function add_faqs_categories() {
  register_taxonomy(
    'faqs_categories',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
    'faqs',        //post type name
    array(
      'hierarchical' => true,
      'label' => 'Faq Categories',  //Display name
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => array(
        'slug' => 'Faq', // This controls the base slug that will display before each term
        'with_front' => false // Don't display the category base before
      )

    )
  );
}
add_action( 'init', 'add_faqs_categories');

add_action('restrict_manage_posts','restrict_faqs_by_category');
function restrict_faqs_by_category() {
  global $typenow;
  if ($typenow=='faqs') {
    $taxonomy = 'faqs_categories';
    $terms = get_terms( $taxonomy );
    if ( $terms ) {
      printf( '<select class="postform" name="%s">', $taxonomy );
      printf( '<option selected="selected" value="0">%s</option>', "Show All" );
      foreach ( $terms as $term ) {
        if(isset($_GET["testimonials_categories"])){
          if($_GET["testimonials_categories"] == $term->slug){
            printf( '<option selected="selected" value="%s">%s</option>', $term->slug, $term->name );
          }else{
            printf( '<option value="%s">%s</option>', $term->slug, $term->name );
          }
        }else{
          printf( '<option value="%s">%s</option>', $term->slug, $term->name );
        }
      }
      print( '</select>' );
    }
  }
}

//add scripts in footer of order confirmation pages as necessary
function add_script_footer(){
  global $post;
  //MM order confirmed 9999511607
  //KM order confirmed 9999995207
	//SM order confirmed 10007048408

  //MM waitlist order confirmed 10000065065
  //KM waitlist order confirmed 9999995229
	//SM waitlist order confirmed 10007048414

    $post_confirmation = array(9999511607,9999995207,10007048408);
	  $waitlist_post_confirmation = array(10000065065,9999995229,10007048414);
    $shop_confirmation = array(10005383715);
  $is_mm = array(	9999511607, 10000065065);
  $is_km = array(	9999995207, 9999995229);
  $is_sm = array(	10007048408, 10007048414);
    $product_type = 'NA';
    if(in_array(@$post->ID,$is_mm))$product_type = 'MM';
    if(in_array(@$post->ID,$is_km))$product_type = 'KM';
    if(in_array(@$post->ID,$is_sm))$product_type = 'SM';
  if( in_array(@$post->ID,$post_confirmation)){
        echo "<script>fbq('track', 'Purchase', {value:".get_post_meta($_GET['order_id'],'_order_total',true).",currency: 'USD',Waitlist:0,Subscription:1,SubscriptionType:'".$product_type."'});</script>";
  }
  elseif( in_array(@$post->ID,$waitlist_post_confirmation)){
        echo "<script>fbq('track', 'Purchase', {value:".get_post_meta($_GET['order_id'],'_order_total',true).",currency: 'USD',Waitlist:1,Subscription:1,SubscriptionType:'".$product_type."'});</script>";
    }
    elseif( in_array(@$post->ID,$shop_confirmation)){
        echo "<script>fbq('track', 'Purchase', {value:".get_post_meta($_GET['order_id'],'_order_total',true).",currency: 'USD',Waitlist:0,Subscription:0,SubscriptionType:'".$product_type."'});</script>";
  }
}
add_action( 'wp_footer', 'add_script_footer' );


//add post type lipstick
if ( ! function_exists('monthly_lipstick') ) {

// Register Custom Post Type for lipstick
  function monthly_lipstick() {

    $labels = array(
      'name'                  => _x( 'all lipstick', 'Post Type General Name', 'liveglam' ),
      'singular_name'         => _x( 'lipstick', 'Post Type Singular Name', 'liveglam' ),
      'menu_name'             => __( 'lipstick', 'liveglam' ),
      'name_admin_bar'        => __( 'lipstick', 'liveglam' ),
      'archives'              => __( 'Item Archives', 'liveglam' ),
      'parent_item_colon'     => __( 'Parent Item:', 'liveglam' ),
      'all_items'             => __( 'All Items', 'liveglam' ),
      'add_new_item'          => __( 'Add New Item', 'liveglam' ),
      'add_new'               => __( 'Add New', 'liveglam' ),
      'new_item'              => __( 'New Item', 'liveglam' ),
      'edit_item'             => __( 'Edit Item', 'liveglam' ),
      'update_item'           => __( 'Update Item', 'liveglam' ),
      'view_item'             => __( 'View Item', 'liveglam' ),
      'search_items'          => __( 'Search Item', 'liveglam' ),
      'not_found'             => __( 'Not found', 'liveglam' ),
      'not_found_in_trash'    => __( 'Not found in Trash', 'liveglam' ),
      'featured_image'        => __( 'Featured Image', 'liveglam' ),
      'set_featured_image'    => __( 'Set featured image', 'liveglam' ),
      'remove_featured_image' => __( 'Remove featured image', 'liveglam' ),
      'use_featured_image'    => __( 'Use as featured image', 'liveglam' ),
      'insert_into_item'      => __( 'Insert into item', 'liveglam' ),
      'uploaded_to_this_item' => __( 'Uploaded to this item', 'liveglam' ),
      'items_list'            => __( 'Items list', 'liveglam' ),
      'items_list_navigation' => __( 'Items list navigation', 'liveglam' ),
      'filter_items_list'     => __( 'Filter items list', 'liveglam' ),
    );
    $args = array(
      'label'                 => __( 'lipstick', 'liveglam' ),
      'description'           => __( 'monthly lipstick', 'liveglam' ),
      'labels'                => $labels,
      'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', ),
      'taxonomies'            => array( 'lipstick' ),
      'hierarchical'          => true,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 5,
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => true,
      'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'capability_type'       => 'page',
      'menu_icon' => 'data:image/svg+xml;base64,' . base64_encode('<svg width="20" height="20" viewBox="0 0 213.148 213.148" xmlns="http://www.w3.org/2000/svg"><path d="M96.737,213.148H48.595c-2.142,0-3.878-1.736-3.878-3.878v-49.136c0-2.142,1.736-3.878,3.878-3.878h48.141  c2.142,0,3.878,1.736,3.878,3.878v49.136C100.615,211.412,98.878,213.148,96.737,213.148z M51.405,70.208  c-0.101,0-0.184,0.082-0.184,0.183L51.2,147.872c0,0.105,0.038,0.197,0.113,0.272c0.074,0.074,0.166,0.112,0.271,0.112l42.142,0.012  c0.212,0,0.384-0.172,0.384-0.384l0.021-77.481c0-0.087-0.097-0.184-0.183-0.184L51.405,70.208z M74.082,1.903L61.936,14.447  c-1.125,1.161-1.744,2.691-1.744,4.309v39.978c0,1.677,1.364,3.041,3.041,3.041h18.865c1.677,0,3.042-1.364,3.042-3.041V8.261  c0-1.68-0.354-3.297-1.053-4.807C82.907,0.908,80.465,0,78.572,0C76.865,0,75.27,0.676,74.082,1.903z M168.431,208.95V68.386  c0-6.355-5.151-11.506-11.506-11.506h-32.886c-6.355,0-11.506,5.151-11.506,11.506V208.95c0,2.318,1.879,4.198,4.198,4.198h47.502  C166.552,213.148,168.431,211.269,168.431,208.95z" fill="#a0a5aa"/></svg>')
    );
    register_post_type( 'monthly_lipstick', $args );

  }
  add_action( 'init', 'monthly_lipstick', 0 );

}

function lgs_post_type_admin_filter( $wp_query ) {
  if (is_admin()) {

    // Get the post type from the query
    $post_type = $wp_query->query['post_type'];

    $list_post_type = array('monthly_lipstick','monthly_brushes','monthly_eyeshadows','announcements','testimonials','faqs');

    if ( in_array($post_type,$list_post_type) ) {

      $wp_query->set('orderby', 'date');

      $wp_query->set('order', 'DESC');
    }
  }
}
add_filter('pre_get_posts', 'lgs_post_type_admin_filter');

if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title' 	=> 'Review Settings',
    'menu_title' 	=> 'Review Settings',
    'menu_slug' 	=> 'review-settings',
    'parent_slug' 	=> 'edit.php?post_type=reviews',
    'redirect' 	=> false
  ));

}

if( function_exists('acf_add_local_field_group') ):

  acf_add_local_field_group(array (
    'key' => 'group_58cf86f74ee92',
    'title' => 'Give a Product, Get a Product Option',
    'fields' => array (
      array (
        'key' => 'field_58cf87d0bb779',
        'label' => 'Add this product as Give a Product, Get a Product Option',
        'name' => 'choose_free_product',
        'type' => 'radio',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'choices' => array (
          'Yes' => 'Yes',
          'No' => 'No',
        ),
        'allow_null' => 0,
        'other_choice' => 0,
        'save_other_choice' => 0,
        'default_value' => 'No',
        'layout' => 'horizontal',
        'return_format' => 'value',
      ),
      array (
        'key' => 'field_58cf8b0fbb77e',
        'label' => 'Subtitle',
        'name' => 'subtitle',
        'type' => 'text',
        'instructions' => 'Add a subtitle e.g Angle Liner Makeup Brush',
        'required' => 0,
        'conditional_logic' => array (
          array (
            array (
              'field' => 'field_58cf87d0bb779',
              'operator' => '==',
              'value' => 'Yes',
            ),
          ),
        ),
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => 'Add a subtitle',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_58cf8b3fbb77f',
        'label' => 'Description',
        'name' => 'description',
        'type' => 'text',
        'instructions' => 'Description for the free product option',
        'required' => 1,
        'conditional_logic' => array (
          array (
            array (
              'field' => 'field_58cf87d0bb779',
              'operator' => '==',
              'value' => 'Yes',
            ),
          ),
        ),
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => 'Description for the free product option',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_58cf8bfcbe1d3',
        'label' => 'Shipstation CF3 Value',
        'name' => 'shipstation_cf3_value',
        'type' => 'text',
        'instructions' => 'Enter a unique text that will appear in ship station Custom Field 3, if this option is chosen by user.',
        'required' => 1,
        'conditional_logic' => array (
          array (
            array (
              'field' => 'field_58cf87d0bb779',
              'operator' => '==',
              'value' => 'Yes',
            ),
          ),
        ),
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_58cf8920bb77c',
        'label' => 'Thumbnail image',
        'name' => 'thumbnail_image',
        'type' => 'image',
        'instructions' => 'Thumbnail image for free brush option. Minimum upload size is 200X200 & Maximum 400X400',
        'required' => 1,
        'conditional_logic' => array (
          array (
            array (
              'field' => 'field_58cf87d0bb779',
              'operator' => '==',
              'value' => 'Yes',
            ),
          ),
        ),
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'return_format' => 'url',
        'preview_size' => 'thumbnail',
        'library' => 'all',
        'min_width' => 200,
        'min_height' => 200,
        'min_size' => '',
        'max_width' => 400,
        'max_height' => 400,
        'max_size' => '',
        'mime_types' => '',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_taxonomy',
          'operator' => '==',
          'value' => 'product_cat:give-a-product-get-a-product',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
  ));

endif;

// FAQ fields

if( function_exists('acf_add_local_field_group') ):

  acf_add_local_field_group(array (
    'key' => 'group_58ab0b760722c',
    'title' => 'FAQ',
    'fields' => array (
      array (
        'key' => 'field_58ab0e847dc99',
        'label' => 'FAQ',
        'name' => 'faq',
        'type' => 'repeater',
        'instructions' => 'add questions and answers',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'collapsed' => '',
        'min' => 1,
        'max' => 0,
        'layout' => 'row',
        'button_label' => 'Add FAQ',
        'sub_fields' => array (
          array (
            'key' => 'field_58ab0e9a7dc9a',
            'label' => 'Question',
            'name' => 'question',
            'type' => 'text',
            'instructions' => 'add question here.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
          ),
          array (
            'key' => 'field_58ab0eb77dc9b',
            'label' => 'Answer',
            'name' => 'answer',
            'type' => 'wysiwyg',
            'instructions' => 'add answer here.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 1,
            'delay' => 0,
          ),
        ),
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'page',
          'operator' => '==',
          'value' => '9999995205',
        ),
      ),
      array (
        array (
          'param' => 'page',
          'operator' => '==',
          'value' => '9999378286',
        ),
      ),
      array (
        array (
          'param' => 'page',
          'operator' => '==',
          'value' => PAGE_SHADOWME_ID,
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
  ));

endif;

//filter for google example address on checkoutpage
add_filter('woogoogad_billing_address_label_filter', 'woogoogad_billing_address_label_filter');
function woogoogad_billing_address_label_filter($text){
  return $text."<span class='address_example'>Example: 123 ABC St. Los Angeles CA 90015</span>";

}
//add additional meta data to users
add_filter( 'user_contactmethods', 'add_more_contactmethods', 20, 1 );
function add_more_contactmethods( $methods ){

  //add more method here
  $method = array(
    'instagram' => 'Instagram',
    'snapchat' => 'Snapchat',
    'pinterest' => 'Pinterest',
    'linkedin' => 'LinkedIn',
  );

  foreach ($method as $key => $value ){
    $methods[$key] = $value;
  }

  return $methods;
}

add_shortcode( 'show_sociallink_author', 'show_sociallink_author' );
function show_sociallink_author(){
  ob_start();
  global $post;

  $user_id = $post->post_author;

  $input = $fb = $gp = $tw = $in = $pi = $sc = $lk = '';

  $fb = get_user_meta( $user_id, 'facebook', true );
  $tw = get_user_meta( $user_id, 'twitter', true );
  $in = get_user_meta( $user_id, 'instagram', true );
  $pi = get_user_meta( $user_id, 'pinterest', true );
  $sc = get_user_meta( $user_id, 'snapchat', true );
  $lk = get_user_meta( $user_id, 'linkedin', true );

  if( $fb || $gp || $tw || $in || $pi || $sc || $lk ){
    $input = '<div class="user_social_links"><ul>';

    if( $fb ) $input .= '<li><a href="'.$fb.'" target="new"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>';
    if( $tw ) $input .= '<li><a href="'.$tw.'" target="new"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>';
    if( $in ) $input .= '<li><a href="'.$in.'" target="new"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>';
    if( $pi ) $input .= '<li><a href="'.$pi.'" target="new"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a></li>';
    if( $sc ) $input .= '<li><a href="'.$sc.'" target="new"><i class="fab fa-snapchat-ghost" aria-hidden="true"></i></a></li>';
    if( $lk ) $input .= '<li><a href="'.$lk.'" target="new"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>';

    $input .= '</ul></div>';
  }

  echo $input;

  return ob_get_clean();
}

//remove header cart widget
add_action( 'init', 'woocommerce_remove_header_cart' );
function woocommerce_remove_header_cart() {
  remove_action( 'storefront_header', 'storefront_header_cart', 60 );
}

//allow links in author bio
remove_filter('pre_user_description', 'wp_filter_kses');

//hide,redirect woocommerce shop page
//add_action( 'wp_head', 'hide_shop_product_page');
function hide_shop_product_page(){

  global $post;
  if( !is_user_logged_in() ) {
      if ( isset($post->post_type) && $post->post_type == 'product') {
          wp_redirect(home_url('/my-account'));
          exit;
      }
  }

}

function hm_flat_rate_is_available( $is_available ) {

  if( check_is_free_shipping_CA() ){
    return false;
  }

  return $is_available;
}

function hm_free_shipping_is_available( $is_available ) {

  if( check_is_free_shipping_CA() ){
    return true;
  }

  return $is_available;
}

add_filter( 'woocommerce_shipping_flat_rate_is_available', 'hm_flat_rate_is_available', 20 );
add_filter( 'woocommerce_shipping_free_shipping_is_available', 'hm_free_shipping_is_available', 20 );

function check_is_free_shipping_CA(){

  if( isset( $_COOKIE['cookie_payment_failed'] ) ){

    if ( WC()->session->order_awaiting_payment > 0 ) {
      $order_id = WC()->session->order_awaiting_payment;

    }

  } elseif( isset( $_COOKIE['cookie_payment_reactive'] ) ) {

    if ( ! empty( WC()->cart->cart_contents ) ) {
      foreach ( WC()->cart->cart_contents as $cart_item ) {
        if ( isset( $cart_item['subscription_resubscribe'] ) ) {
          $order_id =  $cart_item['subscription_resubscribe']['subscription_id'];
          break;
        }
      }

    }

  } elseif ( !empty( WC()->cart->cart_contents ) && is_user_logged_in() ) {

    foreach ( WC()->cart->cart_contents as $cart_item ) {
      if ( isset( $cart_item['product_id'] ) ) {
        $product_id = $cart_item['product_id']; break;
      }
    }

    if( in_array( $product_id, array( MM_SIXMONTH, MM_ANNUAL ) ) ) {

      $order_id = check_is_upgrade_subscription( MM_MONTHLY, MM_SIXMONTH );

    } elseif( in_array( $product_id, array( KM_SIXMONTH, KM_ANNUAL ) ) ) {

      $order_id = check_is_upgrade_subscription( KM_MONTHLY, KM_SIXMONTH );

    } elseif( in_array( $product_id, array( SM_SIXMONTH, SM_ANNUAL ) ) ) {

      $order_id = check_is_upgrade_subscription( SM_MONTHLY, SM_SIXMONTH );

    }

  }

  if( isset( $order_id ) ){

    if( get_post_meta( $order_id, '_shipping_country', true ) == 'CA' ){

      $_order_shipping = get_post_meta( $order_id, '_order_shipping', true );

      if( $_order_shipping == 0 ){

        $package = WC()->cart->get_shipping_packages();
        $package = reset( $package );
        $country = $package["destination"]["country"];

        if( in_array( $country, array( 'PR', 'US', 'CA' ) ) ){
          return true;
        }

      }

    }

  }

  return false;
}

function check_is_upgrade_subscription( $product_ml, $product_sm ){

  $sub_id = 0;

  $subscriptions = wcs_get_users_subscriptions( get_current_user_id() );

  $ml_subs = IzCustomization::check_user_has_subscription_active( $subscriptions, $product_ml, 'active' );
  $sm_subs = IzCustomization::check_user_has_subscription_active( $subscriptions, $product_sm, 'active' );

  if( $ml_subs ) {
    $sub_id = $ml_subs->get_id();
  } elseif( $sm_subs ) {
    $sub_id = $sm_subs->get_id();
  }

  return $sub_id;

}

//--------------------------//tarashi make new function Jun 6, 2017

//add new script and style for new theme
add_action( 'wp_enqueue_scripts', 'new_script_style', 1000 );
function new_script_style(){

  ?>
  <script type="text/javascript">
    var home_url = '<?php echo home_url(); ?>',
  stylesheet_uri = '<?php echo get_stylesheet_directory_uri(); ?>';
  </script>
  <?php
  $theme = wp_get_theme();
  $css_version = $theme->get( 'Version' );

  wp_enqueue_style( 'bootstrap-css', get_stylesheet_directory_uri() . '/assets/plugin/bootstrap/css/bootstrap.min.css', array(), $css_version);
  wp_enqueue_style( 'font-awesome-css', get_stylesheet_directory_uri() . '/assets/plugin/font-awesome/css/all.min.css', array(), $css_version);
  wp_enqueue_style( 'carousel-css', get_stylesheet_directory_uri() . '/assets/plugin/owl-carousel/assets/owl.carousel.css', array(), $css_version);
  wp_enqueue_style( 'theme-default-css', get_stylesheet_directory_uri() . '/assets/plugin/owl-carousel/assets/owl.theme.default.css', array(), $css_version);
  wp_enqueue_style( 'jPushMenu-css', get_stylesheet_directory_uri() . '/assets/plugin/jPushMenu/jPushMenu.css', array(), $css_version);
  wp_enqueue_style( 'bootstrap-select-css', get_stylesheet_directory_uri() . '/assets/plugin/bootstrap/css/bootstrap-select.min.css', array(), $css_version);
  wp_enqueue_style( 'hamburgers-css', get_stylesheet_directory_uri() . '/assets/plugin/hamburgers/hamburgers.css', array(), $css_version);
  wp_enqueue_style( 'app-css', get_stylesheet_directory_uri() . '/assets/css/app.min.css', array(), $css_version);

  wp_enqueue_script( 'bootstrap-popper', get_stylesheet_directory_uri() . '/assets/plugin/bootstrap/js/popper.min.js', array(), $css_version, true );
  wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/assets/plugin/bootstrap/js/bootstrap.min.js', array(), $css_version, true );
  wp_enqueue_script( 'carousel-js', get_stylesheet_directory_uri() . '/assets/plugin/owl-carousel/owl.carousel.min.js', array(), $css_version, true );
  wp_register_script('script-js', get_stylesheet_directory_uri() . '/assets/js/script.min.js', array(), $css_version, true);
  wp_localize_script('script-js','liveglam_custome',array('home_url' => home_url(), 'get_stylesheet_directory_uri' => get_stylesheet_directory_uri()));
  wp_enqueue_script( 'script-js' );
  wp_enqueue_script( 'script-product-custom', get_stylesheet_directory_uri() . '/assets/js/script-product-custom.min.js', array(), $css_version, true);
  wp_enqueue_script( 'jPushMenu-js', get_stylesheet_directory_uri() . '/assets/plugin/jPushMenu/jPushMenu.js', array(), $css_version, true );
  wp_enqueue_script( 'simplyscroll-js', get_stylesheet_directory_uri() . '/assets/plugin/simplyScroll/jquery.simplyscroll.min.js', array(), $css_version, true );
  wp_enqueue_script( 'nicescroll-js', get_stylesheet_directory_uri() . '/assets/plugin/nicescroll/jquery.nicescroll.min.js', array(), $css_version, true );
  wp_enqueue_script( 'simplePagination-js', get_stylesheet_directory_uri() . '/assets/plugin/pagination/jquery.simplePagination.js', array(), $css_version, true );
  wp_enqueue_script( 'isotope-js', get_stylesheet_directory_uri() . '/assets/plugin/isotope/isotope.min.js', array(), $css_version, true );
  wp_enqueue_script( 'bootstrap-select-js', get_stylesheet_directory_uri() . '/assets/plugin/bootstrap/js/bootstrap-select.min.js', array(), $css_version, true );
  if(!is_checkout())wp_enqueue_script( 'jquery-validate', get_stylesheet_directory_uri() . '/assets/js/jquery.validate.min.js', array(), $css_version, true );
  wp_enqueue_script( 'imagesLoaded-js', get_stylesheet_directory_uri() . '/assets/plugin/imagesLoaded/imagesloaded.js', array(), $css_version, true );
  wp_enqueue_script( 'modernizr.custom-js', get_stylesheet_directory_uri() . '/assets/js/modernizr.custom.min.js', array(), $css_version, true );
  wp_enqueue_script( 'uiProgressButton-js', get_stylesheet_directory_uri() . '/assets/js/uiProgressButton.min.js', array(), $css_version, true );
  wp_enqueue_script( 'classie-js', get_stylesheet_directory_uri() . '/assets/js/classie.min.js', array(), $css_version );
  wp_enqueue_script('email-collection-popup', get_stylesheet_directory_uri() . '/assets/js/email-collection-popup.min.js', array(), $css_version);
  wp_enqueue_script( 'jquery-cookie' );
  if (is_archive('reviews') || is_page('assets-for-affiliates-morpheme') || is_page('assets-for-affiliates-kissme') || is_page('assets-for-affiliates-shadowme')) {
    wp_enqueue_script( 'infinite-scroll', get_stylesheet_directory_uri() . '/assets/js/infinite-scroll.pkgd.min.js', array(), $css_version, true);
  }

    wp_enqueue_style( 'flaticon', get_stylesheet_directory_uri() . '/assets/fonts/flaticon/flaticon.css', array(), $css_version);
    wp_enqueue_style( 'flaticon2', get_stylesheet_directory_uri() . '/assets/fonts/flaticon/111619-scenic-arts/font/flaticon.css', array(), $css_version);
    wp_enqueue_style( 'flaticon3', get_stylesheet_directory_uri() . '/assets/fonts/flaticon/111505-beautiful/font/flaticon.css', array(), $css_version);
    wp_enqueue_style( 'flaticon4', get_stylesheet_directory_uri() . '/assets/fonts/flaticon/110805-gcons/font/flaticon.css', array(), $css_version);

  wp_enqueue_script('copy-js', get_stylesheet_directory_uri().'/assets/js/copy_to_clipboard.min.js', array(), $css_version, true);


  if(is_page(317630)){ /*script for rewards page*/
    wp_enqueue_script('wc-country-select');
    wp_enqueue_script('wc-address-i18n');
    wp_enqueue_style('select2-css', '//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.css');
    wp_enqueue_script('select2-js', '//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.js', array('jquery'), false, true);
  }

  if(is_account_page() && is_user_logged_in()){ /*script for dashboard page*/
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui-datepicker-style', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.min.css', array());
    wp_enqueue_script('wc-country-select');
    wp_enqueue_script('wc-address-i18n');
    wp_enqueue_script('password-strength-meter');
    wp_enqueue_script('wc-password-strength-meter');
    ?>
    <script type="text/javascript">
      var user_billing_phone = '<?php echo get_user_meta(get_current_user_id(),'billing_phone',true) ;?>';
    </script>
    <?php
    wp_enqueue_script( 'script-dashboard', get_stylesheet_directory_uri() . '/assets/js/liveglam-dashboard.min.js', array(), $css_version, true );
  }

  if ( is_page('password-rotation') ) {
    wp_enqueue_script('password-strength-meter');
    wp_enqueue_script('wc-password-strength-meter');
  }
}

/* get reviews by term ID */
function liveglam_get_all_reviews_by_termid( $termid = array(), $limit = 20, $page = 1, $term = '', $source = '' ){
    global $total_reviews_page;
  $all_reviews = array();
  $args = array(
    'post_type' => 'reviews',
    'posts_per_page' => $limit,
    'ignore_sticky_posts' => 1,
    'orderby' => 'ID',
    'order' => 'DESC',
        'post_status' => 'publish',
        'paged' => $page
  );
  if( count( $termid) ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'reviews_categories',
        'field' => 'term_id',
        'terms' => $termid,
        'operator' => 'IN'
      )
    );
  }

    if(  $term ) {
      $args['tax_query'] = array(
          array(
              'taxonomy' => 'reviews_categories',
              'field' => 'slug',
              'terms' => $term,

          )
      );
    }

    if(  $source ) {
      $args['meta_key'] = 'further_choose';
      $args['meta_value'] = ucwords($source);
    }
  $reviews = new WP_Query($args);
    $total_reviews_page = $reviews->max_num_pages;
  while ($reviews->have_posts()) : $reviews->the_post();
      $customer_images = wp_get_attachment_image_url(get_post_thumbnail_id(get_the_ID()),array(100,100));
    $customer_images = !empty($customer_images) ? $customer_images : get_stylesheet_directory_uri()."/assets/img/dummy-girl.jpg";

    $terms = get_the_terms(get_the_ID(), 'reviews_categories');
    $term_name = '';
    if( $terms ){
      foreach ($terms as $term) { $term_name = $term->slug; }
    }

        $further_choose = !empty($further_choose = get_post_meta(get_the_ID(),'further_choose',true))?$further_choose:'Instagram';
    switch ($further_choose) {
      case "Facebook": $img_choose = get_stylesheet_directory_uri()."/assets/img/facebook-facebook.svg"; break;
      case "Yelp": $img_choose = get_stylesheet_directory_uri()."/assets/img/icon-yelp.png"; break;
      case "Google": $img_choose = get_stylesheet_directory_uri()."/assets/img/google_icon.png"; break;
      case "Youtube": $img_choose = get_stylesheet_directory_uri()."/assets/img/youtube.png"; break;
      case "Twitter": $img_choose = get_stylesheet_directory_uri()."/assets/img/icon-twitter2.png"; break;
      case "Instagram": $img_choose = get_stylesheet_directory_uri()."/assets/img/IMG_icon-instagram.svg"; break;
    }

    $all_reviews[] = array(
            'title' => get_post_meta(get_the_ID(),'review_names',true),
      'customer_images' => $customer_images,
            'name' => get_post_meta(get_the_ID(),'reviewer_name',true),
            'name_handle' => get_post_meta(get_the_ID(),'review_handle',true),
      'further_choose' => strtolower($further_choose),
      'images_further' => $img_choose,
            'content' => get_post_meta(get_the_ID(),'review_content',true),
      'term_name' => $term_name,
            'subscribes_club' => lgs_implodeEx(get_post_meta(get_the_ID(),'subscribes_club',true),', ',' & ')
    );
  endwhile;
  wp_reset_postdata();
  return $all_reviews;
}

add_action( 'wp_ajax_load_more_reviews', 'load_more_reviews' );
add_action( 'wp_ajax_nopriv_load_more_reviews', 'load_more_reviews' );
global $total_reviews_page;
function load_more_reviews(){
  global $total_reviews_page;
  $page = isset($_GET['page'])  ? $_GET['page']:1;
  $term = isset($_GET['term']) && $_GET['term']!='all' ? $_GET['term']:'';
  $source = isset($_GET['source']) && $_GET['source']!='filter' ? $_GET['source']:'';

  $reviews =  liveglam_get_all_reviews_by_termid(array(), 10, $page, $term, $source);
  foreach($reviews as $review):
    $content_full = $review['content'];?>
    <li class="grid-item all filter <?php echo $review['further_choose']; ?> <?php echo $review['term_name']; ?>">
      <div class="grid-content">
        <p class="review-title nd19-block-title-s"><?php echo $review['title']; ?></p>
        <p class="review-comment content_excerpt nd19-block-content">
          <span><?php echo $content_full; ?></span>
        </p>
        <div class="review-footer">
          <div class="review-footer-content">
            <div class="review-author">
              <img src="<?php echo $review['customer_images']; ?>" class="photo image-blog-author" alt="<?php echo $review['name_handle']; ?>">
            </div>
            <div class="commentor-link">
              <div class="commentor-content">
                <div class="commentor-content-detail">
                  <p class="name nd19-block-content"><?php if(!empty($review['name'])): echo $review['name']; endif; ?>&nbsp;</p>
                  <div class="author-social">
                    <p class="social-link nd19-block-content-s">
                      <span><img src="<?php echo $review['images_further']; ?>" class="icon-<?php echo $review['further_choose']; ?>" alt="<?php echo $review['name_handle']; ?>"></span>
                      <?php echo $review['name_handle']; ?>
                    </p>
                  </div>
                  <p class="social-subscribes">
                    <?php if(!empty($review['subscribes_club'])): ?>
                      Subscribes to: <span><?php echo $review['subscribes_club']; ?></span>
                    <?php endif; ?>
                    &nbsp;
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </li>

  <?php endforeach;
  if ($page < $total_reviews_page) echo "<div class='pagination__next'></div>";
  if (is_ajax()) die();
}

add_action( 'wp_ajax_load_more_affiliate_assets', 'load_more_affiliate_assets' );
add_action( 'wp_ajax_nopriv_load_more_affiliate_assets', 'load_more_affiliate_assets' );
function load_more_affiliate_assets(){
  $pageImageCount = 12;
  $page = isset($_GET['page'])  ? $_GET['page']:1;
  $id = isset($_GET['id'])  ? $_GET['id']:1;

  $images = get_field('diamond_affiliate_image', $id);

  if( empty( $images ) ) return;

  $total = count($images);

  if($total > 0) {
    $all_images = array();

    for($i = min($total - 1, $page*$pageImageCount-1); $i >= ($page-1)*$pageImageCount; $i--){
      $all_images[] = $images[$i]['diamond_affiliate_image']['url'];
    }

    echo '<ul class="list isotope">';

    if(count($all_images) > 0){
      foreach($all_images as $image){
        echo '<li class="grid-item all"><div class="save_image_content">';
        echo '<p><img alt="Affiliate Image" src="'.$image.'" data-no-lazy="1"><br>';
        echo '<a class="nofancybox save_img nolightbox" href="'.$image.'" download=""><button>Save</button></a></p>';
        echo '</div></li>';
      }
    }

    echo '</ul>';
  }
  if ($page*$pageImageCount < $total) echo "<div class='pagination__next'></div>";
  if (is_ajax()) die();
}

/* get testimonials by term ID */
function liveglam_get_all_testimonials_by_termid( $termid = array(), $limit = 20 ){
  $args = array(
    'post_type' => 'testimonials',
    'ignore_sticky_posts' => 1,
    'posts_per_page' => $limit,
    'orderby' => 'ID',
    'order' => 'DESC',
    'post_status' => 'publish'
  );
    if( !empty($termid) ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'testimonials_categories',
        'field' => 'term_id',
        'terms' => $termid,
        'operator' => 'IN'
      )
    );
  }
  $all_testimonials = array();
  $testimonials = new WP_Query($args);
    while ( $testimonials->have_posts() ) : $testimonials->the_post();
            $customer_images = wp_get_attachment_image_url(get_post_thumbnail_id(get_the_ID()),array(200,200));
            $customer_images = !empty($customer_images) ? $customer_images : get_stylesheet_directory_uri()."/assets/img/dummy-girl.jpg";
            $further_choose = !empty($further_choose = get_post_meta(get_the_ID(),'further_choose',true))?$further_choose:'Instagram';
      switch ($further_choose) {
        case "Facebook": $img_choose = get_stylesheet_directory_uri()."/assets/img/facebook-facebook.svg"; break;
        case "Yelp": $img_choose = get_stylesheet_directory_uri()."/assets/img/icon-yelp.png"; break;
        case "Google": $img_choose = get_stylesheet_directory_uri()."/assets/img/google_icon.png"; break;
        case "Youtube": $img_choose = get_stylesheet_directory_uri()."/assets/img/youtube.png"; break;
        case "Twitter": $img_choose = get_stylesheet_directory_uri()."/assets/img/icon-twitter2.png"; break;
        case "Instagram": $img_choose = get_stylesheet_directory_uri()."/assets/img/IMG_icon-instagram.svg"; break;
      }

      $all_testimonials[] = array(
        'title' => get_the_title(),
        'customer_images' => $customer_images,
                'name' => get_post_meta(get_the_ID(),'testimonial_name',true),
                'name_handle' => get_post_meta(get_the_ID(),'name_handle',true),
        'further_choose' => strtolower($further_choose),
        'images_further' => $img_choose,
        'content' => get_the_content(),
                'subscribes_club' => lgs_implodeEx(get_post_meta(get_the_ID(),'subscribes_club',true),', ',' & ')
      );

    endwhile;
  wp_reset_postdata();
  return $all_testimonials;
}

  function lgs_implodeEx($value = array() ,$glue, $glueEx = null) {
    if( empty( $value ) ) return null;
    if ($glueEx === null)
      return implode($glue, $value);
    $c = count($value);
    if ($c <= 2)
      return implode($glueEx, $value);

    $lastPiece = array_pop($value);
    return implode($glue, array_splice($value, 0, $c - 1)) . $glueEx . $lastPiece;
  }

/* add new shortcode send email invites */
add_shortcode('send_email_invites', 'send_email_invites');
function send_email_invites( $atts ){
  ob_start();
  //if (!is_user_logged_in()) return;

  $product = isset( $atts['product'] ) ? $atts['product'] : 'morpheme';
    $input_email = isset( $atts['input_email'] ) ? $atts['input_email'] : 'input';

  $output = '';
  $output .= '<div class="section-send-email-invites">';
    if( $input_email == 'input' ){
  $output .= '<input class="email_invites email_address" id="input-email" type="text" placeholder="Enter Your Friend\'s Emails (up to 10)">';
    } else {
      $output .= '<textarea class="email_invites email_address" id="input-email" row="5" placeholder="Enter Your Friend\'s Emails (up to 10)"></textarea>';
    }
  $output .= '<button class="btn-secondary btn-vw btn-solid transparent send_email_invites">Send</button>';
  $output .= '<input type="hidden" value="'.$product.'" class="type-product" />';
  $output .= '</div>';
  $output .= '<div id="send_email_invites_success" class="white-popup-block-1 mfp-hide"></div>';

  echo $output;
  return ob_get_clean();
}

/* add new shortcode social share */
add_shortcode('social_share', 'social_share');
function social_share( $atts ){

  $IzCustom = new IzCustomization();
  ob_start();

  $product = !empty( $atts['product'] ) ? $atts['product'] : 'morpheme';

  switch ( $product ){
    case 'morpheme':
      $page_id = $IzCustom->defined_default_morpheme;
      break;
    case 'kissme':
      $page_id = $IzCustom->defined_default_kissme;
      break;
    case 'shadowme':
      $page_id = $IzCustom->defined_default_shadowme;
      break;
  }

  $page_id = PAGE_REFERRAL_ID;

  $url = get_permalink($page_id);
  $currentuserid = get_current_user_id();
  if ($currentuserid) {
    $objectcurrentuser = get_userdata($currentuserid);
    $url = esc_url(add_query_arg('ref', $objectcurrentuser->user_login, $url));
  }

    $title_tw = '';
    if( class_exists( 'WPSEO_Meta' ) ) {
      if( empty($title_tw = WPSEO_Meta::get_value( 'twitter-title', $page_id ) ) ){
        $title_tw = WPSEO_Meta::get_value( 'opengraph-title', $page_id );
      }
    }

  $link_gg = "https://plus.google.com/share?url=".urlencode($url);
  $link_tw = "http://twitter.com/intent/tweet?status=".urlencode($title_tw)."+".urlencode($url);
  $link_fb = "http://www.facebook.com/sharer/sharer.php?u=".urlencode($url);

  $twitter_icon = !empty($atts['icon']) ? '<span class="fab fa-twitter"></span>' : '<img alt="Twitter Share" src="'.get_stylesheet_directory_uri().'/assets/img/icon-twitter-2.svg">';
  $facebook_icon = !empty($atts['icon']) ? '<span class="fab fa-facebook-f"></span>' : '<img alt="Facebook Share" src="'.get_stylesheet_directory_uri().'/assets/img/icon-facebook-2.svg">';

  $output = '<ul class="social-share-content">
          <li><a target="_blank" href="'.$link_tw.'" id="share-twitter">'.$twitter_icon.'</a></li>
          <li><a target="_blank" href="'.$link_fb.'" id="share-facebook">'.$facebook_icon.'</a></li>
        </ul>';

  if( isset($atts['show_on_popup']) && $atts['show_on_popup'] == true ){
    $output = '<ul class="social-share-content">
          <li>
            <a target="_blank" href="'.$link_tw.'" id="share-twitter"><img alt="Twitter Share" src="'.get_stylesheet_directory_uri().'/assets/img/icon-twitter-popup-share.png"></a>
          </li>
          <li>
            <a target="_blank" href="'.$link_fb.'" id="share-facebook"><img alt="Facebook Share" src="'.get_stylesheet_directory_uri().'/assets/img/icon-facebook-popup-share.png"></a>
          </li>
        </ul>';
  }

  if( isset($atts['return_link']) && $atts['return_link'] == true ){
    $type = !empty( $atts['type'] ) ? $atts['type'] : 'facebook';

    switch ($type){
      case 'facebook'; $output = $link_fb; break;
      case 'twitter'; $output = $link_tw; break;
      case 'google'; $output = $link_gg; break;
    }

  }


  echo $output;
  return ob_get_clean();
}

/* add shortcode show section blogs for monthly club page */
add_shortcode( 'show_section_blogs', 'show_section_blogs' );
function show_section_blogs( $atts ){

  $post_id = @$atts['post_id'];
  $type = isset( $atts['product'] ) ? $atts['product'] : 'morpheme';

  switch ( $type ){
    case 'morpheme':
      $key1 = 'choose_monthly';
      $key2 = 'check_blog';
      $filed_desc = 'description';
      $field_btn_text = 'button_text';
      $field_image = 'image';
      break;
    case 'kissme':
      $key1 = 'choose_monthly_kissme';
      $key2 = 'check_blog_kissme';
      $filed_desc = 'description_kissme';
      $field_btn_text = 'button_text_kissme';
      $field_image = 'image_kissme';
      break;
    case 'shadowme':
      $key1 = 'choose_monthly_shadowme';
      $key2 = 'check_blog_shadowme';
      $filed_desc = 'description_shadowme';
      $field_btn_text = 'button_text_shadowme';
      $field_image = 'image_shadowme';
      break;
  }

  $args = array(
    'post_status' => 'publish',
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'ignore_sticky_posts' => 1,
    'meta_query' => array(
      array( 'key'     => $key1, 'value'   => $post_id, 'compare' => '=' ),
      array( 'key' => $key2, 'value'   => 'Yes', 'compare' => 'LIKE' ),
    ),
    'order'          => 'DESC'
  );

  $blogs = array();
  $blog_post = new WP_Query( $args );
  if ( $blog_post->have_posts() ) :
    while ( $blog_post->have_posts() ) : $blog_post->the_post();
            $image = !empty($image = wp_get_attachment_image_url(get_post_meta(get_the_ID(),$field_image,true ),'full') ) ? $image : wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
      $blogs[] = array(
                'desc' => get_post_meta(get_the_ID(),$filed_desc,true),
                'text' => get_post_meta(get_the_ID(),$field_btn_text,true),
                'image' => $image,
                'title' => get_the_title(),
                'link' => get_the_permalink(),
                'date' => get_the_date( 'M j, Y' )
      );
    endwhile; wp_reset_postdata();
  endif;

  ob_start();
  $output = '';

  if( count($blogs) > 0 ) {

    foreach ($blogs as $blog) {

      $output .= '<div class="section-blogs">';

      $output .= '<div class="blog long">
                  <img src="'.$blog['image'].'" alt="'.$blog['title'].'">
              </div>';

      $output .= '<div class="blog short">
               
              <div class="description">
                <p class="title-pink">'.$blog['date'].'</p>
                                <h5 class="tutor-blogs-title">'.$blog['title'].'</h5>
                                <p class="comment tutor-blogs-desc">'.$blog['desc'].'</p>
                <a href="'.$blog['link'].'">
                  <button class="btn btn-primary">'.$blog['text'].'</button>
                </a>
              </div>
            </div>';

      $output .= '</div>';
    }

  }

  echo $output;
  ob_end_clean();
  return $output;
}

/* get price shipping for product redeem */
function get_price_shipping_product_redeem( $product_id, $key_usl, $shipping_country ){

  $array_country = array( 'US' );

  if( in_array($shipping_country, $array_country ) ){
    $type_stripe = $key_usl.'pid';
    $type_reward = $key_usl.'pod';
  } else {
    $type_stripe = $key_usl.'pii';
    $type_reward = $key_usl.'poi';
  }

  $price_stripe = lrs_get_price_shipping( $product_id, $type_stripe );
  $price_reward = lrs_get_price_shipping( $product_id, $type_reward );

  return array(
    'reward' => $price_reward,
    'stripe' => $price_stripe,
  );
}

//add post type announcements
if ( ! function_exists('post_type_announcements') ) {
// Register Custom Post Type for announcements
  function post_type_announcements() {

    $labels = array(
      'name'                  => _x( 'Announcements', 'Post Type General Name', 'text_domain' ),
      'singular_name'         => _x( 'Announcements', 'Post Type Singular Name', 'text_domain' ),
      'menu_name'             => __( 'Announcements', 'text_domain' ),
      'name_admin_bar'        => __( 'Announcements', 'text_domain' ),
      'archives'              => __( 'Item Archives', 'text_domain' ),
      'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
      'all_items'             => __( 'All Announcements', 'text_domain' ),
      'add_new_item'          => __( 'Add New Announcements', 'text_domain' ),
      'add_new'               => __( 'Add Announcements', 'text_domain' ),
      'new_item'              => __( 'New Announcements', 'text_domain' ),
      'edit_item'             => __( 'Edit Announcements', 'text_domain' ),
      'update_item'           => __( 'Update Item', 'text_domain' ),
      'view_item'             => __( 'View Announcements', 'text_domain' ),
      'search_items'          => __( 'Search Announcements', 'text_domain' ),
      'not_found'             => __( 'Not found', 'text_domain' ),
      'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
      'featured_image'        => __( 'Featured Image', 'text_domain' ),
      'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
      'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
      'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
      'insert_into_item'      => __( 'Insert into', 'text_domain' ),
      'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
      'items_list'            => __( 'Items list', 'text_domain' ),
      'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
      'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
    );
    $args = array(
      'label'                 => __( 'Announcements', 'text_domain' ),
      'description'           => __( 'Announcements Description', 'text_domain' ),
      'labels'                => $labels,
      'supports'              => array( ),
      'taxonomies'            => array( 'category announcements', 'post_tag' ),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 5,
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => false,
      'exclude_from_search'   => true,
      'publicly_queryable'    => false,
      'capability_type'       => 'page',
      'menu_icon'   => 'dashicons-megaphone',
    );
    register_post_type( 'announcements', $args );

  }
  add_action( 'init', 'post_type_announcements', 0 );

  if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array (
      'key' => 'group_5964d50530d17',
      'title' => 'Announcements Setting',
      'fields' => array (
        array (
          'key' => 'field_5964d53a7e967',
          'label' => 'Type Announcement',
          'name' => 'type_announcement',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array (
            'morpheme' => 'MorphMe',
            'kissme' => 'KissMe',
            'liveglam' => 'LiveGlam',
            'shadowme' => 'ShadowMe',
          ),
          'default_value' => array (
          ),
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 0,
          'ajax' => 0,
          'return_format' => 'value',
          'placeholder' => '',
        ),
        array (
          'key' => 'field_5964d6397e96a',
          'label' => 'Start Date',
          'name' => 'start_date',
          'type' => 'date_picker',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'display_format' => 'd/m/Y',
          'return_format' => 'd/m/Y',
          'first_day' => 1,
        ),
        array (
          'key' => 'field_5964d6807e96b',
          'label' => 'End Date',
          'name' => 'end_date',
          'type' => 'date_picker',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'display_format' => 'm/d/Y',
          'return_format' => 'm/d/Y',
          'first_day' => 1,
        ),
        array (
          'key' => 'field_5964db8b62386',
          'label' => 'Show if',
          'name' => 'show_if',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array (
            'member_of' => 'User is member of',
            'not_member_of' => 'User is not member of',
            'all_members' => 'All Members',
            'in_waitlist' => 'User is in waitlist',
            'active_monthly' => 'User is Active Monthly',
            'active_6months' => 'User is Active 6 Months',
            'active_annual' => 'User is Active Annual'
          ),
          'default_value' => array (
            0 => 'member_of',
          ),
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 0,
          'ajax' => 0,
          'return_format' => 'value',
          'placeholder' => '',
        ),
        array (
          'key' => 'field_5964dc0462387',
          'label' => 'Choose Groups',
          'name' => 'choose_groups',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array (
            'morpheme' => 'MorpheMe',
            'kissme' => 'KissMe',
                        'shadowme' => 'ShadowMe',
          ),
          'default_value' => array (
          ),
          'allow_null' => 0,
          'multiple' => 1,
          'ui' => 1,
          'ajax' => 0,
          'return_format' => 'value',
          'placeholder' => '',
        ),
      ),
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'announcements',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => 1,
      'description' => '',
    ));

  endif;
}

/** update count view post */
function lgs_set_post_views($postID = 0) {
  if ( !is_single() ) return;
  if ( $postID == 0 ) {
    global $post; $postID = $post->ID;
  }
  $count_key = 'lgs_post_views_count';
  $count = get_post_meta($postID, $count_key, true);
  if($count==''){
    $count = 1;
  }else{
    $count = $count+1;
  }
  update_post_meta($postID, $count_key, $count);
}

/** custom theme comment showing on blog single page */
function mytheme_comment($comment, $args, $depth) {
  if ( 'div' === $args['style'] ) {
    $tag       = 'div';
    $add_below = 'comment';
  } else {
    $tag       = 'li';
    $add_below = 'comment-manage';
  }
  ?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <p class="comment-text nd19-block-content"><?php echo get_comment_text(get_comment()); ?></p>
    <div id="comment-manage-<?php comment_ID() ?>" class="comment-manage">
        <div class="comment-user-info">
          <?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
          <?php if ( 'div' != $args['style'] ) : ?>
            <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
              <?php endif; ?>
                <div class="comment">
                    <p><?php echo get_comment_author(); ?></p>
                    <a><span class="show-desktop">posted on</span> <?php echo get_comment_date('d M, Y'); ?></a>
                </div>
              <?php if ( $comment->comment_approved == '0' ) : ?>
                  <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
                  <br />
              <?php endif; ?>
              <?php if ( 'div' != $args['style'] ) : ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="comment-manage-action">
            <div class="reply">
              <?php comment_reply_link( array_merge( $args, array(
                    'add_below' => $add_below,
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                    'reply_text' => '<i class="fas fa-reply" aria-hidden="true"></i>' ) ) ); ?>
            </div>
            <a class="btn_save"><i class="fas fa-heart" aria-hidden="true"></i></a>
        </div>
    </div>
  <?php
}

/* get avatar for user */
function lg_get_avatar_for_user( $userID, $size = 300 ){
  $url_avatar = wp_cache_get($userID, 'user_avatar_'.$size);
  if ( false === $url_avatar ) {
    if (!empty($local_avatars_custom = get_user_meta($userID, 'basic_user_avatar', true))) {
      if (!empty($local_avatars_custom)) {
        if ($size == 64 && isset($local_avatars_custom['64'])) {
          $url_avatar = $local_avatars_custom['64'];
        } elseif(isset($local_avatars_custom['300'])) {
          $url_avatar = $local_avatars_custom['300'];
        } else {
          $url_avatar = $local_avatars_custom['full'];
        }
      }
    }
    if ($size == 300 && !empty($local_avatars_original = get_user_meta($userID, 'basic_user_avatar_id', true))) {
      //maybe cx have avatar set on media
      $url_avatars = wp_get_attachment_image_src($local_avatars_original, 'lg_image_small_size');
      if($url_avatars) {
        $url_avatar = $url_avatars[0];
      }
    }
    if(empty($url_avatar)){
      $url_avatar = get_avatar_url($userID, array("size" => 200));
    }
    wp_cache_set( $userID, $url_avatar, 'user_avatar_'.$size, 3600);
  }
  return $url_avatar;
}

/** get icon for user by level */
function lg_image_td_member( $userLevel ){
  $image = '';
  switch ( $userLevel ){
    case 'diamond':
        case 'diamond trial':
      $image = '<img alt="Diamond" src="'.get_stylesheet_directory_uri().'/assets/img/icon-td-jewellery.svg">'; break;
        case 'diamond elite':
            $image = '<img alt="Diamond Elite" src="'.get_stylesheet_directory_uri().'/assets/img/icon-td-diamond.svg">'; break;
    case 'gold':
      $image = '<img alt="Gold" src="'.get_stylesheet_directory_uri().'/assets/img/icon-td-star.svg">'; break;
    case 'silver':
      $image = '<img alt="Silver" src="'.get_stylesheet_directory_uri().'/assets/img/icon-td-elipse.svg">'; break;
  }
  return $image;
}


function my_wpcf7_form_elements($html) {
  function ov3rfly_replace_include_blank($name, $text, &$html) {
    $matches = false;
    preg_match('/<select name="' . $name . '"[^>]*>(.*)<\/select>/iU', $html, $matches);
    if ($matches) {
      $select = str_replace('<option value="">---</option>', '<option value="">' . $text . '</option>', $matches[0]);
      $html = preg_replace('/<select name="' . $name . '"[^>]*>(.*)<\/select>/iU', $select, $html);
    }
  }
  ov3rfly_replace_include_blank('your_option', 'Subject', $html);
  return $html;
}
add_filter('wpcf7_form_elements', 'my_wpcf7_form_elements');

/* show product buy points */
function lg_show_product_offer(){
  $product = new WC_Product_Variable( BUY_POINT_ID );
  $variables = $product->get_available_variations(); ?>
  <div id="show_offer" class="white-popup-block-2 mfp-hide colored-block">
    <div class="load_offers">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/gift_box.png" class="gift_icon" alt="Gift Box"/>
      <h2>How many points would you like to buy?</h2>
      <div class="btn-group bootstrap-select show-tick">
        <label class="d-none" for="load_points">&nbsp;</label>
        <select class="selectpicker" tabindex="-98" id="load_points">
          <?php
          $variables = array_reverse ($variables);
          foreach ($variables as $variable) {
            $_product = wc_get_product($variable['variation_id']); ?>
            <option value="<?php echo $_product->add_to_cart_url();?>"><?php echo $variable['attributes']['attribute_point']?> points - <?php echo wc_price($variable['display_regular_price']);?></option>
          <?php } ?>
        </select>
      </div>
      <a href="#" class="btn_purchase">
        <button class="btn btn-secondary btn-solid btn-sm">Purchase Points</button>
      </a>
    </div>
  </div>
<?php
}

if( function_exists('acf_add_local_field_group') ):

  acf_add_local_field_group(array (
    'key' => 'group_5997033a16498',
    'title' => 'Read time',
    'fields' => array (
      array (
        'key' => 'field_59970344b3df8',
        'label' => 'Read Time',
        'name' => 'read_time',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '3 min read',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'post',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
  ));

  acf_add_local_field_group(array (
    'key' => 'group_599651aab494c',
    'title' => 'Testimonials Setting',
    'fields' => array (
      array (
        'key' => 'field_599651fc67b3d',
        'label' => 'Further Choose',
        'name' => 'further_choose',
        'type' => 'radio',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'choices' => array (
          'Instagram' => 'Instagram',
          'Twitter' => 'Twitter',
          'Facebook' => 'Facebook',
          'Yelp' => 'Yelp',
          'Google' => 'Google',
          'Youtube' => 'Youtube',
        ),
        'allow_null' => 0,
        'other_choice' => 0,
        'save_other_choice' => 0,
        'default_value' => 'Instagram',
        'layout' => 'horizontal',
        'return_format' => 'value',
      ),
            array(
              'key' => 'field_5bd6d04e2e98c',
              'label' => 'Subscribes Club',
              'name' => 'subscribes_club',
              'type' => 'select',
              'instructions' => '',
              'required' => 0,
              'conditional_logic' => 0,
              'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
              ),
              'choices' => array(
                'MorpheMe' => 'MorpheMe',
                'KissMe' => 'KissMe',
                'ShadowMe' => 'ShadowMe',
              ),
              'default_value' => array(
              ),
              'allow_null' => 1,
              'multiple' => 1,
              'ui' => 1,
              'return_format' => 'value',
              'ajax' => 0,
              'placeholder' => '',
            ),
      array (
        'key' => 'field_5996575dd8426',
        'label' => 'Testimonial Name',
        'name' => 'testimonial_name',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_5996531f67b3e',
        'label' => 'Name Handle',
        'name' => 'name_handle',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'testimonials',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
  ));

endif;


function liveglam_convert_time_subscribed( $time ){
  $output = '<span class="menu-subscribed not-subscribed">Not subscribed yet</span>';
  if( $time == 0 ) return $output;
  $current_year = date('Y');
  $year = date('Y',$time);
  $diff = $current_year - $year;
  if( $diff == 0 ){
    $output = '<span class="menu-subscribed">Subscribed This Year</span>';
  } elseif( $diff == 1 ){
    $output = '<span class="menu-subscribed">Subscribed Last Year</span>';
  } else {
    $output = '<span class="menu-subscribed">Subscribed in '.date('M Y',$time).'</span>';//F
  }
  return $output;
}

/** add sidebar menu right **/
function liveglam_sidebar_menu(){

    $link_mm = home_url(PAGE_PRE_CHECKOUT.'?club=morpheme');
    $link_km = home_url(PAGE_PRE_CHECKOUT.'?club=kissme');
    $link_sm = home_url(PAGE_PRE_CHECKOUT.'?club=shadowme');

    if(is_user_logged_in() ){
      $status_array = array('active', 'waitlist', 'pause');
      $subscriptions_status = LiveGlam_Subscription_Status::get_status();
      if(in_array( $subscriptions_status['get_status_morpheme'], $status_array)) $link_mm = home_url(PAGE_MORPHEME_LANDING);
      if(in_array( $subscriptions_status['get_status_kissme'], $status_array)) $link_km = home_url(PAGE_KISSME_LANDING);
      if(in_array( $subscriptions_status['get_status_shadowme'], $status_array)) $link_sm = home_url(PAGE_SHADOWME_MONTHLY);
    }

    if( !is_user_logged_in() ){ ?>
        <ul class='sidebar_menu lgs-mlogout'>
            <li class="sidebar_list lgs-mlogout-dts">
                <div class="sidebar_list_content">
                    <div class="list-pages">
                      <a href="<?php echo home_url(); ?>" class="<?php echo is_front_page()?'active':''; ?>">
                        <div class="list-page">
                          <div class="list-page-left">
                            <p>Home</p>
                          </div>
                          <div class="list-page-right"></div>
                        </div>
                      </a>
                      <a href="<?php echo home_url('/member-perks/'); ?>" class="<?php echo is_page('member-perks')?'active':''; ?>">
                        <div class="list-page">
                          <div class="list-page-left">
                            <p>Member Perks</p>
                          </div>
                          <div class="list-page-right"></div>
                        </div>
                      </a>
                      <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="<?php echo is_shop()?'active':''; ?>">
                        <div class="list-page">
                          <div class="list-page-left">
                            <p>Shop</p>
                          </div>
                          <div class="list-page-right"></div>
                        </div>
                      </a>
                        <a href="<?php echo home_url('/blog/'); ?>" class="<?php echo (is_home() && ! is_front_page())?'active':''; ?>">
                            <div class="list-page">
                                <div class="list-page-left">
                                    <p>Blog</p>
                                </div>
                                <div class="list-page-right"></div>
                            </div>
                        </a>
                        <a href="<?php echo home_url('/reviews/'); ?>" class="<?php echo is_post_type_archive('reviews')?'active':''; ?>">
                            <div class="list-page">
                                <div class="list-page-left">
                                    <p>Reviews</p>
                                </div>
                                <div class="list-page-right"></div>
                            </div>
                        </a>
                        <a href="<?php echo home_url('/faq/'); ?>" class="<?php echo is_page('faq')?'active':''; ?>">
                            <div class="list-page">
                                <div class="list-page-left">
                                    <p>FAQ</p>
                                </div>
                              <div class="list-page-right"></div>
                            </div>
                        </a>
                        <a href="#" class="close-jPushMenu simplemodal-login">
                            <div class="list-page">
                                <div class="list-page-left">
                                    <p>Login</p>
                                </div>
                              <div class="list-page-right"></div>
                            </div>
                        </a>
                    </div>
                    <div class="list-signup">
                        <p class="not-signup-text">Not part of the #LiveGlamFam yet?</p>
                        <a href="<?php echo home_url(PAGE_PRE_CHECKOUT); ?>" class="btn-signup text-center">
                            <button class="btn-primary">Start here</button>
                        </a>
                    </div>
                </div>
            </li>
        </ul>
    <?php } else { ?>

      <div class="new-sidebar">
        <div class="new-sidebar-content">
          <div class="new-sidebar-close">
            <a href="#" class="close-jPushMenu">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-close-menu.png" alt="Close"/>
            </a>
          </div>
          <div class="new-sidebar-top">
            <div class="new-sidebar-avatar">
              <img src="<?php echo lg_get_avatar_for_user(get_current_user_id(), 300); ?>" alt="User Avatar"/>
            </div>
          </div>
          <div class="new-sidebar-list new-list-pages list-pages">
            <a href="<?php echo home_url('/my-account/'); ?>" class="<?php echo is_page('my-account')?'active':''; ?>">
              <div class="new-list-page list-page">
                <div class="list-page-left">
                  <p>My Dashboard</p>
                </div>
                <div class="list-page-right">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-myaccount-white.png" alt="My Dashboard">
                </div>
              </div>
            </a>
            <a href="<?php echo $link_mm; ?>" class="<?php echo is_page(PAGE_MORPHEME_LANDING)?'active':''; ?>">
              <div class="new-list-page list-page">
                <div class="list-page-left">
                  <p>MorpheMe</p>
                </div>
                <div class="list-page-right">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-menu-mm-white.svg" alt="MorpheMe">
                </div>
              </div>
            </a>
            <a href="<?php echo $link_km; ?>" class="<?php echo is_page(PAGE_KISSME_LANDING)?'active':''; ?>">
              <div class="new-list-page list-page">
                <div class="list-page-left">
                  <p>KissMe</p>
                </div>
                <div class="list-page-right">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-menu-km-white.svg" alt="KissMe">
                </div>
              </div>
            </a>
            <a href="<?php echo $link_sm; ?>" class="<?php echo is_page(PAGE_SHADOWME_MONTHLY)?'active':''; ?>">
              <div class="new-list-page list-page">
                <div class="list-page-left">
                  <p>ShadowMe</p>
                </div>
                <div class="list-page-right">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-menu-sm-white.svg" alt="ShadowMe">
                </div>
              </div>
            </a>
            <a href="<?php echo home_url('/member-perks/'); ?>" class="<?php echo is_page('member-perks')?'active':''; ?>">
              <div class="new-list-page list-page">
                <div class="list-page-left">
                  <p>Member Perks</p>
                </div>
                <div class="list-page-right">
                  <img src="<?php echo get_stylesheet_directory_uri() ;?>/assets/img/icon-menu-faq-white.svg" alt="Member Perks">
                </div>
              </div>
            </a>
            <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="<?php echo is_shop()?'active':''; ?>">
              <div class="new-list-page list-page">
                <div class="list-page-left">
                  <p>Shop</p>
                </div>
                <div class="list-page-right <?php echo is_shop()?'active':'';?>">
                  <img src="<?php echo get_stylesheet_directory_uri() ;?>/assets/img/icon-menu-shop-white.svg" alt="Shop">
                </div>
              </div>
            </a>
            <a href="<?php echo home_url('/rewards/'); ?>" class="<?php echo is_page('rewards')?'active':''; ?>">
              <div class="new-list-page list-page">
                <div class="list-page-left">
                  <p>Rewards</p>
                </div>
                <div class="list-page-right">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-menu-rewards-white.svg" alt="Rewards">
                </div>
              </div>
            </a>
            <a href="<?php echo home_url('/blog/'); ?>" class="<?php echo (is_home() && ! is_front_page())?'active':''; ?>">
              <div class="new-list-page list-page">
                <div class="list-page-left">
                  <p>Blog</p>
                </div>
                <div class="list-page-right">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-menu-blog-white.svg" alt="Blog">
                </div>
              </div>
            </a>
            <a href="<?php echo home_url('/faq/'); ?>" class="<?php echo is_page('faq')?'active':''; ?>">
              <div class="new-list-page list-page">
                <div class="list-page-left">
                  <p>FAQ</p>
                </div>
                <div class="list-page-right">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-menu-faq-white.svg" alt="FAQ">
                </div>
              </div>
            </a>
            <a href="<?php echo esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>">
              <div class="new-list-page list-page">
                <div class="list-page-left">
                  <p>Logout</p>
                </div>
                <div class="list-page-right">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-menu-logout-white.svg" alt="Logout">
                </div>
              </div>
            </a>
          </div>
          <div class="new-sidebar-bottom new-list-pages list-pages"></div>
        </div>
      </div>
    <?php }
}

/** add mobile nav bar **/
function liveglam_mobile_navbar(){
    if( !is_user_logged_in() ) {
  $content = '<div class="menu-section">
          <a class="btn-hamburger toggle-menu menu-right push-body hamburger hamburger--spin">
            <div class="hamburger-box">
              <div class="hamburger-inner"></div>
            </div>
          </a>
                    <a href="'.home_url().'" class="btn-logo">
                        <img class="logo-img" src="'.get_stylesheet_directory_uri().'/assets/img/liveglam.svg" alt="LiveGlam header logo">
          </a>';

    $content .= '<a class="btn-cart-bag-menu btn-cart-bag-menu-mobile hidden-important toggle-menu menu-left" href="javascript:;">
                    <div class="btn-sn-content">
                      <img src="'.get_stylesheet_directory_uri().'/assets/img/icon-shop-gray.png" alt="Icon Shop">
                      <span class="cart_bag count_items"></span>
                    </div>
                </a>';
      if( !empty( get_option( 'options_enable_sign_up_button', 0 ) ) ):
        $content .= '<div class="btn-signup-logout">';
        if (get_field('enable_search', 'option')) {
          $content .= '<a class="btn-search">
              <img class="logo-search active" src="'.get_stylesheet_directory_uri().'/assets/img/header-search.png">
              <img class="logo-search inactive" src="'.get_stylesheet_directory_uri().'/assets/img/header-search-inactive.png">
            </a>';
        }
        $content .= '<a href="'.home_url(PAGE_PRE_CHECKOUT).'" class="btn-signup text-center btn-primary">Sign Up</a>
        </div>';//liveglam_join_now liveglam_join_now-mobile
      endif;

    $content .= '</div>';
    } else {
      $class_mac = $class_shop = '';
      $img_mac = get_stylesheet_directory_uri().'/assets/img/icon-myaccount-gray.png';
      if( is_page('my-account') ){
        $class_mac = 'active';
        $img_mac = get_stylesheet_directory_uri().'/assets/img/icon-myaccount-pink-new.png';
      }
      $content = '<div class="menu-section-new">
                    <div class="menu-sn-content">
                      <div class="menu-sn-left">
                        <a href="'.home_url().'" class="btn-logo">
                          <img class="logo-img" src="'.get_stylesheet_directory_uri().'/assets/img/liveglam.svg" alt="LiveGlam header logo">
                        </a>
                      </div>
                      <div class="menu-sn-right">
                        <div class="menu-sn-right-content">';
                        if (get_field('enable_search', 'option')) {
                          $content .= '<a class="btn-search">
                              <img alt="Logo Search" class="logo-search active" src="'.get_stylesheet_directory_uri().'/assets/img/header-search.png">
                              <img alt="Logo Search" class="logo-search inactive" src="'.get_stylesheet_directory_uri().'/assets/img/header-search-inactive.png">
                            </a>';
                        }
            
                        $content .='<a href="'.home_url("/my-account").'" class="btn-menu-dashboard '.$class_mac.'">
                            <div class="btn-sn-content">
                              <img src="'.$img_mac.'" alt="User Avatar">
                            </div>
                          </a>
                          <a class="btn-cart-bag-menu btn-cart-bag-menu-mobile hidden-important toggle-menu menu-left">
                            <div class="btn-sn-content">
                              <img src="'.get_stylesheet_directory_uri().'/assets/img/icon-shop-gray.png" alt="Icon Shop">
                              <span class="cart_bag count_items"></span>
                            </div>
                          </a>
                          <a class="btn-hamburger toggle-menu menu-right push-body">
                            <div class="btn-sn-content">
                              <img src="'.get_stylesheet_directory_uri().'/assets/img/icon-menu-hamburger-gray.png" alt="Icon Hamburger">
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>';

    }


  return $content;
}

function lgs_check_subscription_onhold($subscription){
  if ( !is_object($subscription) || !wcs_is_subscription( $subscription ) ) {
    $subscription = wcs_get_subscription($subscription);
  }
  $last_order = $subscription->get_last_order('all');
  if(is_object($last_order) && !empty($last_order)){
    if($last_order->get_status() == 'failed' || $last_order->get_status() == 'pending'){
      $status = "failed";
    }elseif( get_post_meta($subscription->get_id(), 'hold_month', true) == 1 ){
      $status = "skip";
    } else {
      $status = 'on-hold';
    }
  }

  return $status;
}

function liveglam_sidebar_menu_left(){
    echo "<div class='cart_bag cart_content'></div>";
}

add_action('wp_ajax_check_show_top_tooltip','check_show_top_tooltip');
function check_show_top_tooltip(){
  if( is_user_logged_in() ) {
    update_user_meta(get_current_user_id(),'show_top_tooltip',1);
    echo '123';
  }
  die();
}

function liveglam_get_last_subscription_active_for_user( $user_subscriptions = array() ){
  $show_first = 'shop';
  if(isset($_GET['tab']) && !empty($_GET['tab'])){
    return $_GET['tab'];
  }
  if(count($user_subscriptions) > 0) {
    foreach ($user_subscriptions as $subscription_id => $subscription) {
      $sub_status = $subscription->get_status();
      if($sub_status == 'on-hold'){
        if(lgs_check_subscription_onhold($subscription) == 'failed'){
          $sub_status = 'failed';
        }
      }
      $subscriptions[$subscription_id]['status'] = $sub_status;
      $subscriptions[$subscription_id]['id'] = $subscription_id;
      $subscriptions[$subscription_id]['subscription'] = $subscription;
    }
    if(count($subscriptions) > 1) usort($subscriptions, "liveglam_custom_compare");
    foreach ($subscriptions as $subscription){
      $sub = $subscription['subscription'];
      foreach( $sub->get_items() as $item){
        $product_id = $item['product_id'];
      }
      if(in_array($product_id, lgs_product_mm)) $show_first = 'morpheme';
      elseif(in_array($product_id, lgs_product_km)) $show_first = 'kissme';
      elseif(in_array($product_id, lgs_product_sm)) $show_first = 'shadowme';
      break;
    }
  }
  return $show_first;
}
function liveglam_custom_compare($a, $b){
  $status = array('failed', 'active','on-hold','pending-cancel','cancelled');
  $a = array_search($a["status"], $status);
  $b = array_search($b["status"], $status);
  if($a === false && $b === false){ return 0; }
  elseif($a === false){ return 1; }
  elseif($b === false){ return -1; }
  else { return $a - $b; }
}


function liveglam_check_ios_android(){

  //Detect special conditions devices
  $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
  $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
  $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
  $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");

  $type = $_SERVER['HTTP_USER_AGENT'];

  //do something with this information
  if( $iPod || $iPhone || $iPad ){
    return 'ios';
  }elseif($Android){
    return 'android';
  }
  return 'unknown';

}

add_filter("woocommerce_order_formatted_shipping_address", "uppercase_shipping_address");
function uppercase_shipping_address($address) {
    if(!empty($address['first_name'])) {
        $address['first_name'] = ucwords($address['first_name']);
    }
    if(!empty($address['last_name'])) {
        $address['last_name'] = ucwords($address['last_name']);
    }
  return $address;
}

/* redirect single post type reviews to page reviews */
add_action('wp_head','liveglam_disable_post_type');
function liveglam_disable_post_type(){
  if(is_singular('reviews')){
    wp_redirect( home_url('/reviews') ); exit;
  }
}


add_action('save_post_shop_subscription','lg_save_subscription_meta',1, 3);
add_action('save_post_shop_order','lg_save_subscription_meta',1, 3);
function lg_save_subscription_meta($post_id, $post, $update ){
  if ( !is_admin()) return;
  if ( !isset($post_id)) return;
  if ( !in_array( $post->post_type, array('shop_subscription','shop_order')) && $update ) {
    return;
  }
  if ( in_array( $post->post_type, array('shop_subscription','shop_order')) && !$update ) {
    return;
  }
  if($post->post_type == 'shop_subscription'){
    $sub = wcs_get_subscription($post_id);
  } elseif($post->post_type == 'shop_order'){
    $sub = wc_get_order($post_id);
  }

  $sub_old_address['billing'] = array(
    '_billing_first_name'    => $sub->get_billing_first_name(),
    '_billing_last_name'     => $sub->get_billing_last_name(),
    '_billing_company'       => $sub->get_billing_company(),
    '_billing_address_1'     => $sub->get_billing_address_1(),
    '_billing_address_2'     => $sub->get_billing_address_2(),
    '_billing_city'          => $sub->get_billing_city(),
    '_billing_state'         => $sub->get_billing_state(),
    '_billing_postcode'      => $sub->get_billing_postcode(),
    '_billing_country'       => $sub->get_billing_country(),
  );
  $sub_old_address['shipping'] = array(
    '_shipping_first_name'    => $sub->get_shipping_first_name(),
    '_shipping_last_name'     => $sub->get_shipping_last_name(),
    '_shipping_company'       => $sub->get_shipping_company(),
    '_shipping_address_1'     => $sub->get_shipping_address_1(),
    '_shipping_address_2'     => $sub->get_shipping_address_2(),
    '_shipping_city'          => $sub->get_shipping_city(),
    '_shipping_state'         => $sub->get_shipping_state(),
    '_shipping_postcode'      => $sub->get_shipping_postcode(),
    '_shipping_country'       => $sub->get_shipping_country()
  );



  $billing_data = $shipping_data = '';
  $change_billing_date = $update_from_backend = $is_billing = $is_shipping = $is_payment_method = false;

  $sub_new_address = array();
  foreach($sub_old_address as $type => $data):
    foreach ($data as $key => $value):
      if (isset($_POST[$key])) {
        $update_from_backend = true;
        $sub_new_address[$type][$key] = $_POST[$key];
      }
    endforeach;
  endforeach;



  if(in_array( $post->post_type, array('shop_subscription'))){
    $stripe_customer_id = get_post_meta( $sub->get_id(), '_stripe_customer_id', true );
    $stripe_card_id     = get_post_meta( $sub->get_id(), '_stripe_card_id', true );
    $old_payment = empty($sub->get_payment_method())?'manual':$sub->get_payment_method();
    if( $_POST['_payment_method'] !== $old_payment ){
      $payment_method_old[] = $old_payment;
      $payment_method_new[] = $_POST['_payment_method'];
    }
    if( $_POST['_payment_method_meta']['post_meta']['_stripe_customer_id'] !== $stripe_customer_id){
      $payment_method_old[] = $stripe_customer_id;
      $payment_method_new[] = $_POST['_payment_method_meta']['post_meta']['_stripe_customer_id'];
    }
    if( $_POST['_payment_method_meta']['post_meta']['_stripe_card_id'] !== $stripe_card_id){
      $payment_method_old[] = $stripe_card_id;
      $payment_method_new[] = $_POST['_payment_method_meta']['post_meta']['_stripe_card_id'];
    }
  }

//    if(isset($payment_method_new) && isset($payment_method_old)){
//        $update_from_backend = true;
//        $is_payment_method = true;
//        $payment_new = implode(", ", $payment_method_old ).'</br>To:</br>'. implode(", ", $payment_method_new );
//    }
  if( is_array($sub_new_address['billing']) && is_array($sub_old_address['billing']) && isset($sub_new_address) && count(array_diff($sub_old_address['billing'],$sub_new_address['billing'])) >0 ){
    $is_billing = true;
    $billing_data = implode(", ", $sub_old_address['billing'] ).'</br>To:</br>'. implode(", ", $sub_new_address['billing'] );
    $billing_data = str_replace(', ,', ',', $billing_data);
  }

  if( is_array($sub_new_address['shipping']) && is_array($sub_old_address['shipping']) && isset($sub_new_address) && count(array_diff($sub_old_address['shipping'],$sub_new_address['shipping'])) >0 ){
    $is_shipping = true;
    $shipping_data = implode(", ", $sub_old_address['shipping'] ).'</br>To:</br>'. implode(", ", $sub_new_address['shipping'] );
    $shipping_data = str_replace(', ,', ',', $shipping_data);
  }

  if($post->post_type == 'shop_subscription') {
    if (isset($_POST['next_payment_timestamp_utc']) && !empty($_POST['next_payment_timestamp_utc'])) {
      $next_payment_date = date('Y-m-d H:i:s', $_POST['next_payment_timestamp_utc']);
      $sub_billing_date = get_post_meta($post_id, '_schedule_next_payment', true);
      if ($sub_billing_date != $next_payment_date) {
        $update_from_backend = true;
        $change_billing_date = true;
        $message_next_payment = date('M d, Y', strtotime($sub_billing_date)) . ' to ' . date('M d, Y', strtotime($next_payment_date));
      }
    }
  }

  if($update_from_backend){
    $user = get_userdata(get_current_user_id());
    $user_email = $user->user_email;
    if($change_billing_date && !empty($message_next_payment)){
      $sub->add_order_note( sprintf( __( '%1$s updated next billing date from: %2$s.', 'woocommerce' ), $user_email, $message_next_payment) );
    }
    if($is_billing && !empty($billing_data)) {
      $sub->add_order_note( sprintf( __( '%1$s updated billing address from:<br> %2$s.', 'woocommerce' ), $user_email, $billing_data) );
    }
    if($is_shipping && !empty($shipping_data)){
      $sub->add_order_note( sprintf( __( '%1$s updated shipping address from:<br> %2$s.', 'woocommerce' ), $user_email, $shipping_data) );
    }
//        if($is_payment_method && !empty($payment_new)){
//            $sub->add_order_note( sprintf( __( 'User %1$s changed Payment method from:<br> %2$s.', 'woocommerce' ), $user_email, $payment_new) );
//        }
  }
}

/* show footer template */
function show_dashboard_footer( $class = '' ){
  wc_get_template('lg-template-footer-dashboard.php', array('ft_class'=> $class ) );
}

function show_dashboard_header_right(){
    wc_get_template('lg-template-dashboard-header-right.php');
}
function show_general_search_content($show_close_button = true){
  if (get_field('enable_search', 'option')) wc_get_template('lg-general-search-content.php', array('show_close_button' => $show_close_button));
}

/*
 * Redirect login user to my-account
 */
//add_action("template_redirect", 'redirect_loggedin_user');
function redirect_loggedin_user(){
  if( is_front_page() && is_user_logged_in() && !current_user_can('manage_options')){
    wp_redirect( home_url('/my-account/') );
  }
}

/**
 * Remove taxcloud if state is not CA
 */
add_action( 'woocommerce_calculate_totals', 'check_state_before_calculate_tax', 9, 1 );
function check_state_before_calculate_tax($cart) {
  if ( ! defined( 'DOING_AJAX' ) && $_POST ) {
        $country = isset($_POST[ 'shipping_country' ])?$_POST[ 'shipping_country' ]:'';
        $state = isset($_POST[ 'shipping_state' ])?$_POST[ 'shipping_state' ]:'';
  } else {
    $country = WC()->customer->get_shipping_country();
    $state = WC()->customer->get_shipping_state();
    }

  //remove calculate tax if state is not CA
  if ($country == 'US' && $state !='CA') {
    remove_action( 'woocommerce_calculate_totals', 'wt_maybe_do_lookup', 10);
  }
}

/* add option page setting for change image side bar on my-account */
add_action('init','lg_add_dashboard_setting');
function lg_add_dashboard_setting(){
  if( function_exists('acf_add_options_sub_page') ):

    acf_add_options_sub_page(array(
      'page_title' 	=> 'Dashboard Setting',
      'menu_title' 	=> 'Dashboard Setting',
      'menu_slug' 	=> 'dashboard-setting',
      'parent_slug'   => 'options-general.php',
    ));

  endif;
}

add_image_size( 'lg_image_small_size', 300, 300, true );


//add_action('wp', 'load_payment_gates');
function load_payment_gates(){
  global $wp;
  if (is_account_page()) {
    WC()->payment_gateways();
  }
}
add_filter('woocommerce_get_endpoint_url','liveglam_after_addcart_success',999,2);
function liveglam_after_addcart_success($url, $endpoint){
    if ($endpoint == 'payment-methods') return home_url('/my-account/?stop');
  return $url;
}

//fix slow comment query count in admin
remove_action( 'wp_insert_comment', array( 'WC_Comments', 'delete_comments_count_cache' ) );
remove_action( 'wp_set_comment_status', array( 'WC_Comments', 'delete_comments_count_cache' ) );
add_filter( 'wp_count_comments', 'skip_comment_count_query', 10, 2 );
function skip_comment_count_query( $count, $post_id ) {
  if ( 0 === $post_id ) {
    $stats = array(
      'approved'       => 0,
      'moderated'      => 0,
      'spam'           => 0,
      'trash'          => 0,
      'post-trashed'   => 0,
      'total_comments' => 0,
      'all'            => 0,
    );
    $stats = (object) $stats;
    set_transient( 'wc_count_comments', $stats );
    return $stats;
  }
  return $count;
}

//fix checkout page scrolling to the middie of the page
add_filter('woocommerce_default_address_fields', 'remove_autofocus');
function remove_autofocus($fields){
  $fields['first_name']['autofocus'] = false;
  return $fields;
}

/**
 * remove action sucuri_set_lastlogin
 */
//remove_action('wp_login', 'sucuriscan_set_lastlogin', 50);


function lgs_get_faq_landing_page( $page_id ){
    $total_faq = get_post_meta($page_id,'faq',true);
    $faqs = array();
    if( $total_faq ){
      for($i = 0; $i < $total_faq; $i++):
        $question = get_post_meta($page_id, 'faq_'.$i.'_question', true);
        $answer = get_post_meta($page_id, 'faq_'.$i.'_answer', true);
        if( !empty($question)&&!empty($answer)){
          $faqs[] = array(
            'question' => $question,
            'answer' => wpautop($answer)
          );
        }
      endfor;
    }
    if(empty($total_faq) || empty($faqs)){
    return false;
  }
  return $faqs;
}

add_action('wp_head','lgs_disable_attachment_post');
function lgs_disable_attachment_post(){
  global $post;
  $list_post_type = array('monthly_lipstick','monthly_brushes','monthly_eyeshadows','announcements');
  if( isset($post->post_type)) {
    if($post->post_type == 'attachment'){
    wp_redirect(home_url('/blog/')); exit;
    } elseif(is_singular($list_post_type)) {
      wp_redirect(home_url()); exit;
    }
  }
}

//remove wp mandril dashboard widget from dashboard created by plugin wpmandrill.php function addDashboardWidgets()
function mandrill_remove_dashboard_widget() {
  remove_meta_box( 'mandrill_widget', 'dashboard', 'normal' );
}
add_action('wp_dashboard_setup', 'mandrill_remove_dashboard_widget' );

function woo_in_cart($product_id) {
    global $woocommerce;

    foreach($woocommerce->cart->get_cart() as $key => $item ) {

        if($product_id == $item['product_id'] ) {
            return $item['quantity'];
        }
    }

    return 0;
}

add_action( 'after_setup_theme','lgs_woocommerce_gallery' );
function lgs_woocommerce_gallery() {
    // Add support for WC features
//    add_theme_support( 'wc-product-gallery-zoom' );
//    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

function lgs_heart_rating( $rating = 5 ){
    $html = '<div class="heart-rating">';
    $html .= '<div class="heart-rating-top" style="width:' . ( ( $rating / 5 ) * 100 ) . '%">';
    $html .= '<span class="fas fa-heart"></span><span class="fas fa-heart"></span><span class="fas fa-heart"></span><span class="fas fa-heart"></span><span class="fas fa-heart"></span>';
    $html .= '</div>';
    $html .= '<div class="heart-rating-bot">';
    $html .= '<span class="far fa-heart"></span><span class="far fa-heart"></span><span class="far fa-heart"></span><span class="far fa-heart"></span><span class="far fa-heart"></span>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}


/**
 * Bug on checkout page, user getting free product for KM when purchase MM
 * we need reload checkout if user getting free product from different product type
 */
add_filter( 'woocommerce_update_order_review_fragments', 'lgs_product_free_update_order_review', 10, 1 );
function lgs_product_free_update_order_review( $fragments ){

  ob_start();
  ?><div class="liveglam-gaga-value-input"><?php
  LG_Morpheme_Customization::lcc_add_colour();
  LG_KissMe_Customization::km_add_colour();
    LG_ShadowMe::sm_add_colour();
  //LGS_CUSTOM_FP::lgs_ctfp_add_colour();
  LGS_Discount_Referral::lgs_bf2018_add_colour_order_failed();
  ?></div><?php
  $gaga_input = ob_get_clean();

  ob_start();
  ?><div class="liveglam-gaga-select-option"><?php
  LG_Morpheme_Customization::lgc_add_product();
  LG_KissMe_Customization::km_add_product();
  LG_ShadowMe::sm_add_product();
  LGS_CUSTOM_FP::lgs_ctfp_add_product();
  ?></div><?php
  $gaga_option = ob_get_clean();

  ob_start();
  ?><div class="liveglam-show-product-items"><?php
  LGS_CHECKOUT_CUSTOM::liveglam_show_product_items();
  ?></div><?php
  $show_individual = ob_get_clean();

  ob_start();
  ?><div class="liveglam-show-option-notices"><?php
  LGS_CHECKOUT_CUSTOM::liveglam_show_option_notice();
  ?></div><?php
  $show_notice = ob_get_clean();

  $fragments['form.woocommerce-checkout .liveglam-gaga-value-input'] = $gaga_input;
  $fragments['form.woocommerce-checkout .liveglam-gaga-select-option'] = $gaga_option;
  $fragments['form.woocommerce-checkout .liveglam-show-product-items'] = $show_individual;
  $fragments['form.woocommerce-checkout .liveglam-show-option-notices'] = $show_notice;

  return $fragments;
}

// check access if user is not log in
function liveglam_check_user_login(){
    if ( !is_user_logged_in() && $_SERVER['REQUEST_URI'] != '/my-account/' ) {
        wp_safe_redirect(home_url('/my-account/?redirect_to='.$_SERVER['REQUEST_URI']));
        exit();
    }else{
        if(isset($_GET['redirect_to'])){
            wp_safe_redirect(home_url($_GET['redirect_to']));
            exit();
        }
    }
}

/**
 * Output a select input box multiple.
 *
 * @param array $field
 */
function woocommerce_wp_select_multiple( $field ) {
  global $thepostid, $post;

  $thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
  $field['class']         = isset( $field['class'] ) ? $field['class'] : 'select short';
  $field['style']         = isset( $field['style'] ) ? $field['style'] : '';
  $field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
  $field['value']         = isset( $field['value'] ) ? $field['value'] : ( get_post_meta( $thepostid, $field['id'], true ) ? get_post_meta( $thepostid, $field['id'], true ) : array() );
  $field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
  $field['desc_tip']      = isset( $field['desc_tip'] ) ? $field['desc_tip'] : false;

  // Custom attribute handling
  $custom_attributes = array();

  if ( ! empty( $field['custom_attributes'] ) && is_array( $field['custom_attributes'] ) ) {

    foreach ( $field['custom_attributes'] as $attribute => $value ) {
      $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
    }
  }

  echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '">
        <label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label>';

  if ( ! empty( $field['description'] ) && false !== $field['desc_tip'] ) {
    echo wc_help_tip( $field['description'] );
  }

  echo '<select id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['name'] ) . '" class="' . esc_attr( $field['class'] ) . '" multiple="multiple" style="' . esc_attr( $field['style'] ) . '" ' . implode( ' ', $custom_attributes ) . '>';

  foreach ( $field['options'] as $key => $value ) {
    echo '<option value="' . esc_attr( $key ) . '" ' . ( in_array( $key, $field['value'] ) ? 'selected="selected"' : '' ) . '>' . esc_html( $value ) . '</option>';
  }
  echo '</select> ';

  if ( ! empty( $field['description'] ) && false === $field['desc_tip'] ) {
    echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
  }

  echo '</p>';
}

function lgs_get_order_track( $order ){

  $key_cache = 'lgs_order_track_'.$order->get_id();
  if(false === ($data_track = wp_cache_get($key_cache,'lgs_order_track'))){
    $track = false;
    $link = $track_num = $track_note = null;
    $comments = $order->get_customer_order_notes();
    if(isset($comments)){
      foreach($comments as $comment){
        if(strpos($comment->comment_content, 'tracking number') == true){
          $track = true;
          $track_note = $track_num = $comment->comment_content;
          break;
        }
      }
    }

    if($track && !empty($track_num)){

      if(strpos($track_num, "USPS") !== FALSE) $method = 'USPS';
      elseif(strpos($track_num, "UPS") !== FALSE) $method = 'UPS';
      elseif(strpos($track_num, "DHL") !== FALSE) $method = 'DHL';
      elseif(strpos($track_num, "Globegistics") !== FALSE) $method = 'Globegistics';
      elseif(strpos($track_num, "Asendia") !== FALSE) $method = 'Asendia';
      $track_num = trim(substr($track_num, stripos($track_num, 'tracking number') + 16), '.');

      switch($method){
        case 'USPS':
          $link = 'https://tools.usps.com/go/TrackConfirmAction.action?tLabels='.$track_num;
          break;
        case 'UPS':
          $link = 'https://wwwapps.ups.com/tracking/tracking.cgi?tracknum='.$track_num;
          break;
        case 'DHL':
          $link = 'https://webtrack.dhlglobalmail.com/?trackingnumber='.$track_num;
          break;
        case 'Globegistics':
          $link = 'https://dm.mytracking.net/globegistics/dmportalv2/externaltracking.aspx?track='.$track_num;
          break;
        case 'Asendia':
          $link = 'http://apps.asendiausa.com/tracking/packagetracking.html?pid='.$track_num;
          break;
      }
    }
    $data_track = array('number' => $track_num, 'link' => $link, 'note' => $track_note);
    wp_cache_set($key_cache, $data_track, 'lgs_order_track', HOUR_IN_SECONDS);
  }
  return $data_track;
}

function lgs_order_detail_items( $order, $type ){

  if ( ! is_object( $order ) ) {
    $order_id = absint( $order );
    $order    = wc_get_order( $order_id );
  }

  $has_traded = $traded_single = false;
  $show_individual_item = $show_traded_item = $show_free_gaga = array();

  $order_id = $order->get_id();

  //case have trade in order
  $club = ($type == 'morpheme')?'mm':($type == 'kissme'?'km':($type == 'shadowme'?'sm':$type));
  if( !empty($trade_id = Iz_Liveglam_MorpheMe_Renewal::lgs_maybe_have_trade($club, $order_id) ) ) {
    $has_traded = true;
    $traded_single = (get_post_meta($order_id, "_lgs_{$club}_trade_type", true) == 'single')?true:false;
    if($traded_single){
      //case trade single
      $old_product = get_post_meta($order_id, "_lgs_{$club}_trade_old", true);
    }else{
      //case trade set
      $product = new WC_Product($trade_id);

      if( !empty( $total_product_items = get_post_meta( $trade_id, 'product_items', true ) ) ) {
        for( $i = 0; $i < $total_product_items; $i++ ) {
          $show_traded_item[] = array(
            'image' => wp_get_attachment_image_url(get_post_meta( $trade_id, 'product_items_'.$i.'_product_item_image', true ),array(100,100)),
            'title' => get_post_meta( $trade_id, 'product_items_'.$i.'_product_item_title', true ),
            'desc' => get_post_meta( $trade_id, 'product_items_'.$i.'_product_item_subtitle', true )
          );
        }
      } else {
        $productImage = get_the_post_thumbnail_url($product->get_id(),'medium');
        $productTitle = $product->get_title();
        $productDescritpion = get_post_meta($product->get_id(),'subtitle_for_order_summary',true);
        $show_traded_item[] = array(
          'image' => $productImage,
          'title' => $productTitle,
          'desc'  => $productDescritpion
        );
      }
    }
  }

  //case have data sale KM
  if( !empty( $data_individual_sale = get_post_meta( $order->get_id(), 'data_individual_sale', true ) ) ) {
    //case have set monthly post ID
    $have_blog_sale = false;
    if( !empty( $data_individual_sale['monthPost'] ) ){
      $monthPost = LGS_User_Referrals::lgs_get_data_for_monthly_post($data_individual_sale['monthPost'], $type);
      if(!empty($monthPost['single_products'])):
        $have_blog_sale = true;
        foreach($monthPost['single_products'] as $individual_item):
          $individual_item_title = $individual_item['title'];
          $individual_item_image = $individual_item['image'];
          $individual_item_desc = $individual_item['subtitle'];
          $show_individual_item[] = array(
            'image' => $individual_item_image,
            'title' => $individual_item_title,
            'desc'  => $individual_item_desc
          );
        endforeach;
      endif;
    }
    if( !$have_blog_sale ) { //case no have set monthly post
      $show_individual_item[] = array(
        'image' => $data_individual_sale['set_image'],
        'title' => $data_individual_sale['set_name'],
        'desc' => $data_individual_sale['set_desc']
      );
    }
  } elseif( !$has_traded || $traded_single ) {
    //case no have trade or trade single
    if( wcs_order_contains_renewal($order) ){
      $time = $order->get_date_created()->getOffsetTimestamp();
    } else {
      $paid_date = $order->get_date_paid();
      $time = !empty($paid_date)?$paid_date->getOffsetTimestamp():$order->get_date_created()->getOffsetTimestamp();
    }

    $monthKey = LGS_User_Referrals::lgs_calcualte_monthkey( $time );
    $monthPost = LGS_User_Referrals::lgs_get_monthly_post($type, $monthKey);

    if(!empty($monthPost)):

      //case show set product for MM,KM
      if( in_array( $type, array('morpheme','kissme') ) ):

        foreach($monthPost['single_products'] as $individual_item):
          if($traded_single && $individual_item['title'] == $old_product):
            $product = wc_get_product($trade_id);
            $show_traded_item[] = array(
              'image' => get_the_post_thumbnail_url($product->get_id(), 'medium'),
              'title' => $product->get_title(),
              'desc' => get_post_meta($product->get_id(),'subtitle_for_order_summary',true)
            );
          else:
            $show_individual_item[] = array(
              'image' => $individual_item['image'],
              'title' => $individual_item['title'],
              'desc' => $individual_item['subtitle']
            );
          endif;
        endforeach;

      else:
        //case show set product for SM
        $productImage = !empty($monthPost['set_product'][0]['image'])?$monthPost['set_product'][0]['image']:'';
        $productDescritpion = !empty($monthPost['single_products'])?implode(', ', wp_list_pluck($monthPost['single_products'], 'title')):'';
        $productTitle = LGS_SHADOWME_ORDER::lgs_calculate_shipping_box_sm($time);
        $show_individual_item[] = array(
          'image' => $productImage,
          'title' => $productTitle,
          'desc' => $productDescritpion
        );

      endif;

    endif;
  }

  if( !empty( $free_products = Iz_Liveglam_MorpheMe_Renewal::lgs_free_product_condition( $order->get_id(), $club ) ) ) {
    foreach( $free_products as $free_product ){
      $product = wc_get_product($free_product);
      $individual_item_title = $product->get_title();
      $show_free_gaga[] = array(
        'image' => wp_get_attachment_image_url(get_post_meta( $free_product, 'thumbnail_image', true ),array(100,100)),
        'title' => $individual_item_title,
        'desc' => get_post_meta($product->get_id(),'subtitle_for_order_summary',true)
      );
    }
  }


  return array(
    'individual_item' => $show_individual_item,
    'trade' => array(
      'has_traded' => $has_traded,
      'traded_single' => $traded_single,
      'traded_item' => $show_traded_item
    ),
    'free_gaga' => $show_free_gaga
  );
}

function fix_request_query_args_for_woocommerce( $query_args ) {
  if ( isset( $query_args['post_status'] ) && empty( $query_args['post_status'] ) ) {
    unset( $query_args['post_status'] );
  }
  return $query_args;
}
add_filter( 'request', 'fix_request_query_args_for_woocommerce', 1, 1 );


setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
if ( SITECOOKIEPATH != COOKIEPATH ) setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);

if ( ! function_exists( 'is_privacy_policy' ) ) {
  function is_privacy_policy() {
    return get_option( 'wp_page_for_privacy_policy' ) && is_page( get_option( 'wp_page_for_privacy_policy' ) );
  }
}

  /**
   * change text "Products" to "Shop" for SEO breadcrumb
   */
add_filter('wpseo_breadcrumb_single_link_info', 'lgs_filter_wpseo_breadcrumb_single_link_info');
function lgs_filter_wpseo_breadcrumb_single_link_info($link_info){
  if( $link_info['text'] == 'Products' ){
    $link_info['text'] = "Shop";
  }
  return $link_info;
}

function lgs_get_faqs(){
  if ( false === ($faqs = wp_cache_get("lgs_get_faqs", 'lgs_get_faqs')) ) {

    $faqs = array();
    $args = array(
      'post_type' => 'faqs',
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'orderby' => 'publish_date',
      'order' => 'DESC',
    );
    $posts = get_posts($args);

    if(!empty($posts)){
      foreach( $posts as $post ){
        if(false !== ($terms = get_the_terms( $post->ID, 'faqs_categories'))){
          foreach( $terms as $term ){
            $faqs[$term->slug][] = $post;
          }
        }
      }
    }

    wp_cache_set("lgs_get_faqs", $faqs, 'lgs_get_faqs', HOUR_IN_SECONDS);
  }

  return $faqs;
}

//issue #1054 show email collection popup
add_action('wp_footer', 'open_email_collection_popup');
function open_email_collection_popup() {
    if(is_home() && !is_front_page() || is_front_page() || is_page('member-perks') || is_shop()){
      if( !is_user_logged_in() ){
        if (get_option('options_enable_email_collection_popup') === '1') { ?>
            <div class="email-collection-popup">
                <div class="mask"></div>
                <div class="collection-modal collection-step-1 active">
                    <img class="hero-image show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/email-collection-popup-image-mobile-1.png" alt="Hero Image"/>
                    <div class="text-content">
                        <img class="image-text" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/get-a-free-gift.png" alt="Get a free gift"/>
                        <h3 class="title">when you join!</h3>
                        <p class="description">Don't miss out on new collections, exclusive offers, and the best beauty tips blended out for you every month!</p>
                        <input type="email" id="get_glam_email" class="email-address get_glam_email" placeholder="Email address" required/>
                        <p class="error-message"></p>
                        <button class="collection-next-step btn-primary">Get Gift</button>
                    </div>
                    <div class="hero-image show-desktop">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/email-collection-popup-image-1.jpg" alt="Hero Image"/>
                    </div>
                    <span class="close">&times;</span>
                </div>
                <div class="collection-modal collection-step-2">
                    <img class="hero-image show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/email-collection-popup-image-mobile-2.png" alt="Hero Image"/>
                    <div class="text-content">
                        <img class="image-text" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/welcome-to-the.png" alt="Welcome"/>
                        <h3 class="title"><span>#</span>LiveGlamFam</h3>
                        <p class="pink-notification">
                            Thank you for being part of our glammazing email list.
                        </p>
                        <p class="description">
                            Use code <strong>"Welcome"</strong> at checkout to receive a <strong>free gift</strong> when you join one of our clubs or click the button below!
                        </p>
                        <a href="<?php echo home_url(PAGE_PRE_CHECKOUT.'/?ref=welcome'); ?>" class="collection-next-step btn-primary">Join Now</a>
                    </div>
                    <div class="hero-image show-desktop">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/email-collection-popup-image-2.jpg" alt="Hero Image"/>
                    </div>
                    <span class="close">&times;</span>
                </div>
                <div class="collection-modal collection-step-3">
                    <img class="hero-image show-mobile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/email-collection-popup-image-mobile-3.png" alt="Hero Image"/>
                    <div class="text-content">
                        <h3 class="title">Hey there, again.</h3>
                        <p class="pink-notification">This email address has already been subscribed.</p>
                        <p class="description description-2">Don’t forget to claim your <strong>free gift</strong> when you join one of our clubs. Use the code <strong>'Welcome'</strong> at checkout!</p>
                        <a href="<?php echo home_url(PAGE_PRE_CHECKOUT.'/?ref=welcome'); ?>" class="collection-next-step btn-primary">Ok</a>
                    </div>
                    <div class="hero-image show-desktop">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/email-collection-popup-image-3.jpg" alt="Hero Image"/>
                    </div>
                    <span class="close">&times;</span>
                </div>
            </div>
        <?php }
      }
    }
}

/**
 * Perform ajax search products
 */
add_action( 'wp_ajax_lg_ajax_search', 'lg_ajax_search' );
add_action( 'wp_ajax_nopriv_lg_ajax_search', 'lg_ajax_search' );
function lg_ajax_search() {
	global $woocommerce;
	$search_keyword =  $_POST;

	$ordering_args = $woocommerce->query->get_catalog_ordering_args( 'title', 'asc' );
  	$suggestions   = array();
  
  	// Proudcts Search args
	$args_product = array(
		's'                   => $search_keyword['s'],
		'post_type'           => array('product'),
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'orderby'             => $ordering_args['orderby'],
		'order'               => $ordering_args['order'],
		'suppress_filters'    => false,
		'perm'                => 'readable'
  	);
	$args_product['tax_query'] = array( 'relation' => 'OR' );
	$args_product['tax_query'][] = array(
		'taxonomy' => 'product_cat',
		'field'    => 'term_taxonomy_id',
		'terms'    => SHOP_CAT
	);

  	// Others search args
	$args = array(
		's'                   => $search_keyword['s'],
		'post_type'           => array('post', 'faqs', 'reviews', 'testimonials', 'page'),
    	'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'orderby'             => $ordering_args['orderby'],
		'order'               => $ordering_args['order'],
		'suppress_filters'    => false,
    	'perm'                => 'readable'
  	);
  
  	if ($search_keyword['page']) $args['posts_per_page'] = $search_keyword['page'];

	// $args['tax_query'] = array( 'relation' => 'OR' );
	// $args['meta_query'] = array( 'relation' => 'OR' );

	// $args['tax_query'][] = array(
	//   'taxonomy' => 'product_cat',
	//   'field'    => 'term_taxonomy_id',
	//   'terms'    => $search_keyword['cat']
	// );
	// $args['meta_query'][] = array(
	//   'key'     => 'review_content',
	//   'value'   => $search_keyword['s'],
	//   'compare' => 'LIKE'
	// );

	$products = get_posts( $args_product );
	$results = get_posts( $args );
	$sidebar = array();
	$sidebar['All'] = 0;

	foreach ( $products as $post ) {
		$product = wc_get_product( $post );

		$product_description = $product->get_short_description();

		$product_description = substr($product_description, 0, 400);

		$suggestions[] = array(
			'id'    => $product->get_id(),
			'title' => hightlightSearch($search_keyword['s'], html_entity_decode(strip_tags( $product->get_title() ))),
			'desc'  => hightlightSearch($search_keyword['s'], $product_description),
			'url'   => $product->get_permalink(),
			'img'   => $product->get_image('thumbnail'),
			'price' => '$ '.$product->get_regular_price(),
			'tag'   => 'SHOP'
		);

		if (!$sidebar['SHOP']) $sidebar['SHOP'] = 0;
		$sidebar['SHOP']++;
		$sidebar['All']++;
	}


	foreach ( $results as $post ) {
		$content = html_entity_decode(strip_tags(apply_filters( 'the_content', $post->post_content )));
		$content = substr($content, 0, 400);

		switch ($post->post_type) {
			case 'faqs': $tag = 'FAQ'; break;
			case 'reviews': $tag = 'REVIEW'; break;
			case 'testimonials': $tag = 'TESTIMONIAL'; break;
			case 'post': $tag = 'BLOG'; break;
			// case 'page': $tag = apply_filters( 'the_title', $post->post_title ); break;
			case 'page': $tag = 'PAGE'; break;
		}
		
		$suggestions[] = array(
			'id'    => $post->ID,
			'title' => hightlightSearch($search_keyword['s'], html_entity_decode(strip_tags( apply_filters( 'the_title', $post->post_title ))) ),
			'desc'  => hightlightSearch($search_keyword['s'], $content ),
			'url'   => get_permalink( $post->ID ),
			'img'   => '',
			'price' => '',
			'tag'   => $tag
		);

		if (!$sidebar[$tag]) $sidebar[$tag] = 0;
		$sidebar[$tag]++;
		$sidebar['All']++;
	}
  
	$search_query = new WP_Query($args);

	wp_reset_postdata();
	
	$data = array(
		'total' => $search_query->found_posts,
		'sidebar' => $sidebar,
		'suggestions' => $suggestions
	);

	echo json_encode( $data );
	die();
}

function hightlightSearch($search, $text) {
	$keys = implode('|', explode(' ', $search));
	$replaced = preg_replace('/(' . $keys .')/iu', '<span class="search-highlight">\0</span>', $text);

	return $replaced;
}

/**
 * #1659 add 3rd party script from BE option page
 */
add_action('wp_head', 'lgs_3rd_party_scripts', 1000);
add_action('wp_footer', 'lgs_3rd_party_scripts', 1000);
function lgs_3rd_party_scripts(){
  global $partyScript, $page_id;
  $current_action = current_action();
  if( $current_action == 'wp_head' ) {
    $partyScript = lgs_3rd_party_scripts_setting();
  }

  if( empty( $page_id ) ){
    if(is_home() && ! is_front_page()){
      $page_id = get_option( 'page_for_posts' );
    } elseif( is_shop() ){
      $page_id = wc_get_page_id( 'shop' );
    } else {
      $page_id = get_the_ID();
    }
  }

  if( !empty( $partyScript ) ){
    foreach($partyScript as $script){
      if(!empty($script['script_content']) && !empty($script['enable_script']) && $script['script_position'] == $current_action && (empty($script['show_on_page']) || in_array($page_id, $script['show_on_page']))){
        echo $script['script_content'];
      }
    }
  }
}

function lgs_3rd_party_scripts_setting(){

  $key_cache = 'lgs_3rd_party_scripts_setting';
  if(false === ($value_cache = wp_cache_get($key_cache, '3rd_party_scripts'))){

    if( !empty( $total = get_option('options_3rd_party_scripts', 0) ) ){
      for( $i = 0; $i < $total; $i++ ){
        $value_cache[] = array(
          'script_content' => get_option('options_3rd_party_scripts_'.$i.'_script_content'),
          'script_position' => !empty( get_option('options_3rd_party_scripts_'.$i.'_script_position') ) ? 'wp_head' : 'wp_footer',
          'show_on_page' => get_option('options_3rd_party_scripts_'.$i.'_show_on_page'),
          'enable_script' => get_option('options_3rd_party_scripts_'.$i.'_enable_script', 1)
        );
      }
    }

    wp_cache_set($key_cache, $value_cache, '3rd_party_scripts', HOUR_IN_SECONDS);
  }
  return $value_cache;
}

  /**
   * get referral link
   * @param null $userID
   * @return string|void
   */
function lgs_get_referral_link($userID = null){
  $refurl = home_url(PAGE_REFERRAL.'?ref=liveglam');
  $userID = !empty($userID) ? $userID : get_current_user_id();

  if( !empty( $userID ) ){
    $user = get_userdata($userID);
    $refurl = esc_url(add_query_arg('ref', $user->user_login, site_url(PAGE_REFERRAL)));
  }

  return $refurl;
}