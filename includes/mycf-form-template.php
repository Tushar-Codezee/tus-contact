<div id="mycf-message" style="display:none; padding:10px; margin-bottom:10px;"></div>

<form id="mycf-form" method="post">
    <?php wp_nonce_field( 'mycf_form_action', 'mycf_nonce' ); ?>
    <input type="text" name="mycf_hp" style="display:none" tabindex="-1" autocomplete="off">

    <p>
        <label><?php esc_html_e( 'Name:', 'my-custom-form' ); ?></label><br>
        <input type="text" name="name" required>
    </p>
    <p>
        <label><?php esc_html_e( 'Email:', 'my-custom-form' ); ?></label><br>
        <input type="email" name="email" required>
    </p>
    <p>
        <label><?php esc_html_e( 'Phone:', 'my-custom-form' ); ?></label><br>
        <input type="text" name="phone" required>
    </p>
    <p>
        <label><?php esc_html_e( 'Message:', 'my-custom-form' ); ?></label><br>
        <textarea name="message" required></textarea>
    </p>
    <p>
        <input type="submit" value="<?php esc_attr_e( 'Submit', 'my-custom-form' ); ?>">
    </p>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("mycf-form");
    const msgBox = document.getElementById("mycf-message");

    form.addEventListener("submit", function(e) {
        e.preventDefault();

        let formData = new FormData(form);
        formData.append("action", "mycf_submit_form");
        formData.append("security", document.getElementById("mycf_nonce").value);

        fetch("<?php echo esc_url( admin_url('admin-ajax.php') ); ?>", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            msgBox.style.display = "block";
            msgBox.style.background = data.success ? "#d4edda" : "#f8d7da";
            msgBox.style.color = data.success ? "#155724" : "#721c24";
            msgBox.innerText = data.data.message;

            if (data.success) {
                form.reset();
                setTimeout(() => {
                    msgBox.style.display = "none";
                }, 3000);
            }
        })
        .catch(() => {
            msgBox.style.display = "block";
            msgBox.style.background = "#f8d7da";
            msgBox.style.color = "#721c24";
            msgBox.innerText = "An error occurred. Please try again.";
        });
    });
});
</script>
