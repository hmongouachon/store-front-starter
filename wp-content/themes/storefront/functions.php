<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */

///////////////////////////

// checkout extra field

//////////////////////////

/* add extra checkout field */
add_action('woocommerce_after_order_notes','custom_checkout_field');
function custom_checkout_field($checkout) {
	echo '<div id="custom_checkout_field"><h2>'.__('Custom heading').'</h2>';
	woocommerce_form_field('custom_field_name',array(
		'type' => 'text',
		'class' => array(
			'custom-field'
		),
		'label' => __('Custom additional field'),
		'placeholder' => __('New custom field'),
	),
	$checkout->get_value('custom_field_name'));
	echo '</div>';
}
/* checkout validation */
add_action('woocommerce_checkout_process', 'customised_checkout_field_process');
function customised_checkout_field_process(){
	// Show an error message if the field is empty
	if (!$_POST['custom_field_name']) wc_add_notice(__('Custom field is empty') , 'error');
}
/* update custom field value in db > will be show in order custom fields row */
add_action('woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta');
function custom_checkout_field_update_order_meta($order_id){
	if (!empty($_POST['custom_field_name'])) {
		update_post_meta($order_id, 'My custom field',sanitize_text_field($_POST['custom_field_name']));
	}
}
/* display in admin order details */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_billing_options_value_in_admin_order', 10, 1 );
function display_billing_options_value_in_admin_order($order){
    if( $value = get_post_meta( $order->get_id(), 'My custom field', true ) )
        echo '<p><strong>'.__('The custom field', 'woocommerce').':</strong><br>' . $value . '</p>';
}

///////////////////////////

// front end form to add extra 
// meta fields to current user

//////////////////////////

// enqueue script
function custom_scripts() {
    wp_register_script('custom_script', get_template_directory_uri().'/assets/js/custom.js', array('jquery'),'1.1', true);
    wp_enqueue_script('custom_script');
}
add_action( 'wp_enqueue_scripts', 'custom_scripts' );  
// ajax update user meta
function user_extra_fields() {
    if(empty($_POST) || !isset($_POST)) {
        ajaxStatus('error', 'Nothing to update.');
    } else {
        try {
            $user = wp_get_current_user();
            $user_id = $user->ID;
            if ( ! current_user_can( 'edit_user', $user_id ) )
                return false;
            update_user_meta( $user_id, 'ananas_like', $_POST['ananas_like'] );
            update_user_meta( $user_id, 'ananas_content', $_POST['ananas_content'] );
            // $user_data = get_user_meta($user_id);
            $user_data[] = get_user_meta( $user_id, 'ananas_like', true );
            $user_data[] = get_user_meta( $user_id, 'ananas_content', true );
            print_r($user_data);
            die();
        } catch (Exception $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}
add_action('wp_ajax_user_extra_fields', 'user_extra_fields');
add_action( 'wp_ajax_nopriv_user_extra_fields', 'user_extra_fields');
// form template
function get_template_ananas(){
	echo ' 
	<h2>Formulaire sur l\'ananas</h2>
		<form id="ananas-form" class="ananas-form" method="POST">
			<div class="form-group">
				<label>Aimez-vous l\'ananas ?</label>
				<div>
				  <input type="radio" id="oui" name="ananas-like" value="oui"
				         checked>
				  <label for="oui">Oui</label>
				</div>
				<div>
				  <input type="radio" id="non" name="ananas-like" value="non">
				  <label for="non">Non</label>
				</div>
			</div>					
			<div class="form-group">
				<label>Pourquoi aimez-vous l\'ananas ou non ?</label>
				<textarea name="message" rows="6" cols="25" placeholder="Exprimez-vous, dpartagez votre ressenti !"></textarea><br /><br />
			</div>
			<input type="submit" value="Send"><input type="reset" value="Clear">
		</form>		
	';
}

///////////////////////////

// ajax call on single product page

//////////////////////////

add_action('woocommerce_before_add_to_cart_form','build_button_ajax');
function build_button_ajax() {
	echo '
	   <button id="call-ip" class="call-ip">Call ip</button>
	   <div class="ip-holder"></div>
	';
}