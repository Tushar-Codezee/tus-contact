<?php
class MyCF_Handler {
    public static function render_form() {
        ob_start();
        require plugin_dir_path( __FILE__ ) . 'mycf-form-template.php';
        return ob_get_clean();
    }

    public static function handle_form_submission() {
        if ( isset( $_POST['mycf_submit'] ) && isset( $_POST['mycf_nonce'] ) ) {
            if ( ! wp_verify_nonce( $_POST['mycf_nonce'], 'mycf_form_action' ) ) {
                wp_die( 'Security check failed.' );
            }

            $name    = sanitize_text_field( $_POST['name'] ?? '' );
            $email   = sanitize_email( $_POST['email'] ?? '' );
            $phone   = sanitize_text_field( $_POST['phone'] ?? '' );
            $message = sanitize_textarea_field( $_POST['message'] ?? '' );

            if ( empty( $name ) || empty( $email ) || empty( $phone ) || empty( $message ) ) {
                wp_die( 'All fields are required.' );
            }

            global $wpdb;
            $table_name = $wpdb->prefix . 'mycf_messages';

            $wpdb->insert(
                $table_name,
                [
                    'name'    => $name,
                    'email'   => $email,
                    'phone'   => $phone,
                    'message' => $message,
                ],
                [ '%s', '%s', '%s', '%s' ]
            );

            wp_redirect( add_query_arg( 'mycf_success', '1', wp_get_referer() ) );
            exit;
        }
    }
}
