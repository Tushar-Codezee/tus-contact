<?php
/**
 * Plugin Name:     Tus Contact
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
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

// Hooks
register_activation_hook( __FILE__, [ 'MyCF_Activator', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'MyCF_Deactivator', 'deactivate' ] );

// Shortcode for form
add_shortcode( 'mycf_form', [ 'MyCF_Handler', 'render_form' ] );

// Form submission
add_action( 'init', [ 'MyCF_Handler', 'handle_form_submission' ] );