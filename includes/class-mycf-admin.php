<?php
class MyCF_Admin {

    public static function register_menu() {
        add_menu_page(
            __( 'Form Entries', 'my-custom-form' ),
            __( 'Form Entries', 'my-custom-form' ),
            'manage_options',
            'mycf_entries',
            [ __CLASS__, 'render_admin_page' ],
            'dashicons-feedback',
            25
        );

        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
    }

    public static function enqueue_scripts( $hook ) {
        if ( $hook !== 'toplevel_page_mycf_entries' ) {
            return;
        }

        wp_enqueue_script(
            'mycf-admin-js',
            plugin_dir_url( __FILE__ ) . 'js/mycf-admin.js',
            [ 'jquery' ],
            '1.0',
            true
        );

        wp_localize_script( 'mycf-admin-js', 'mycf_ajax_obj', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'mycf_admin_nonce' )
        ] );
    }

    public static function render_admin_page() {
        echo '<div class="wrap"><h1>' . esc_html__( 'Form Entries', 'my-custom-form' ) . '</h1>';
        echo '<div id="mycf-entries-table">';
        require plugin_dir_path( __FILE__ ) . 'mycf-admin-list-template.php';
        echo '</div></div>';
    }

    public static function get_entries() {
        check_ajax_referer( 'mycf_admin_nonce', 'nonce' );

        global $wpdb;
        $table_name = $wpdb->prefix . 'mycf_messages';

        $paged    = isset( $_POST['paged'] ) ? absint( $_POST['paged'] ) : 1;
        $per_page = 5;
        $offset   = ( $paged - 1 ) * $per_page;

        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM {$table_name} ORDER BY created_at DESC LIMIT %d OFFSET %d",
            $per_page, $offset
        ) );

        $total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table_name}" );
        $pages = ceil( $total / $per_page );

        wp_send_json( [
            'entries' => $results,
            'pages'   => $pages,
            'current' => $paged
        ] );
    }

    public static function delete_entry() {
        check_ajax_referer( 'mycf_admin_nonce', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( __( 'Permission denied.', 'my-custom-form' ) );
        }

        $id = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;
        if ( $id ) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'mycf_messages';
            $wpdb->delete( $table_name, [ 'id' => $id ], [ '%d' ] );
            wp_send_json_success( __( 'Entry deleted.', 'my-custom-form' ) );
        }

        wp_send_json_error( __( 'Invalid ID.', 'my-custom-form' ) );
    }
}
