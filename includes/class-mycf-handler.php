<?php 
class MyCF_Handler {
    public static function init_ajax() {
        // Logged-in users
        add_action( 'wp_ajax_mycf_submit_form', [ __CLASS__, 'handle_ajax_submission' ] );
        // Guests
        add_action( 'wp_ajax_nopriv_mycf_submit_form', [ __CLASS__, 'handle_ajax_submission' ] );
    }

    public static function render_form() {
        ob_start();
        require plugin_dir_path( __FILE__ ) . 'mycf-form-template.php';
        return ob_get_clean();
    }

    public static function handle_ajax_submission() {
        check_ajax_referer( 'mycf_form_action', 'security' );

        // Honeypot check
        if ( ! empty( $_POST['mycf_hp'] ) ) {
            wp_send_json_error( [ 'message' => __( 'Bot detected.', 'my-custom-form' ) ] );
        }

        $name    = sanitize_text_field( $_POST['name'] ?? '' );
        $email   = sanitize_email( $_POST['email'] ?? '' );
        $phone   = sanitize_text_field( $_POST['phone'] ?? '' );
        $message = sanitize_textarea_field( $_POST['message'] ?? '' );

        // Validation
        if ( empty( $name ) || empty( $email ) || empty( $phone ) || empty( $message ) ) {
            wp_send_json_error( [ 'message' => __( 'All fields are required.', 'my-custom-form' ) ] );
        }
        if ( ! is_email( $email ) ) {
            wp_send_json_error( [ 'message' => __( 'Please enter a valid email address.', 'my-custom-form' ) ] );
        }
        if ( ! preg_match( '/^[0-9]{7,15}$/', $phone ) ) {
            wp_send_json_error( [ 'message' => __( 'Please enter a valid phone number (only digits, 7-15 chars).', 'my-custom-form' ) ] );
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

        wp_send_json_success( [ 'message' => __( 'Your message has been submitted successfully!', 'my-custom-form' ) ] );
    }
}

