<?php
// Check the users capbilities...
if (! current_user_can('manage_options')) {
    return;
}
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
</div>
