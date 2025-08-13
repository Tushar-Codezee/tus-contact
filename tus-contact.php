<?php
/**
 * Plugin Name:     Tus Contact
 * Plugin URI:      https://wordpress.org
 * Description:     Creating custom form and entry show on backend
 * Author:          Tushar K.
 * Author URI:      https://wordpress.org/
 * Text Domain:     tus-contact
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Tus_Contact
 */

// Your code starts here.
if(! defined('ABSPATH')){
    return;
}

// Include files
require_once plugin_dir_path( __FILE__ ) . 'includes/class-mycf-activator.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-mycf-deactivator.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-mycf-handler.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-mycf-admin.php';

if ( is_admin() ) {
    add_action( 'admin_menu', [ 'MyCF_Admin', 'register_menu' ] );
    add_action( 'wp_ajax_mycf_get_entries', [ 'MyCF_Admin', 'get_entries' ] );
    add_action( 'wp_ajax_mycf_delete_entry', [ 'MyCF_Admin', 'delete_entry' ] );
}


// Hooks
register_activation_hook( __FILE__, [ 'MyCF_Activator', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'MyCF_Deactivator', 'deactivate' ] );

MyCF_Handler::init_ajax();

// add_action( 'wp_ajax_mycf_submit_form', [ 'MyCF_Handler', 'handle_form_submission' ] );
// add_action( 'wp_ajax_nopriv_mycf_submit_form', [ 'MyCF_Handler', 'handle_form_submission' ] );

// Shortcode for form
add_shortcode( 'mycf_form', [ 'MyCF_Handler', 'render_form' ] );

// Form submission
add_action( 'init', [ 'MyCF_Handler', 'init_ajax' ] );