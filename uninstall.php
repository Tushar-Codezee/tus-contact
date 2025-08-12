<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Confirm deletion (WordPress doesn't have a native "are you sure" prompt here —
// you'd need to handle it via settings page UI before uninstall)

// Delete table
global $wpdb;
$table_name = $wpdb->prefix . 'mycf_messages';
$wpdb->query( "DROP TABLE IF EXISTS {$table_name}" );