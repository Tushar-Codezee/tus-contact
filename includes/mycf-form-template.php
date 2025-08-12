<?php if ( isset( $_GET['mycf_success'] ) ) : ?>
    <p style="color: green;">Your message has been submitted successfully!</p>
<?php endif; ?>

<form method="post">
    <?php wp_nonce_field( 'mycf_form_action', 'mycf_nonce' ); ?>
    
    <p>
        <label for="name">Name:</label><br>
        <input type="text" name="name" required>
    </p>
    <p>
        <label for="email">Email:</label><br>
        <input type="email" name="email" required>
    </p>
    <p>
        <label for="phone">Phone:</label><br>
        <input type="text" name="phone" required>
    </p>
    <p>
        <label for="message">Message:</label><br>
        <textarea name="message" required></textarea>
    </p>
    <p>
        <input type="submit" name="mycf_submit" value="Submit">
    </p>
</form>
