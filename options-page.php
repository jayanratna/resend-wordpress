<?php
// Check the users capbilities...
if (! current_user_can('manage_options')) {
    return;
}

wp_register_script('resend-js', plugins_url('assets/js/admin.js', __FILE__), '', null, false);
wp_enqueue_script('resend-js');
?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()) ?></h1>
    <form method="POST" action="options.php">
        <?php settings_fields('resend'); ?>
        <div class="settings-container">
            <?php do_settings_sections('resend'); ?>
        </div>
        <?php submit_button('Save Settings'); ?>
    </form>

    <?php if (isset($this->settings['resend_api_key'])) { ?>
        <input type="submit" class="button-secondary send-test" value="Send test email">
    <?php } ?>
</div>
