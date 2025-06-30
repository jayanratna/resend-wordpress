<?php
if (! isset($type)) {
    $type = false;
}
?>
<?php if ($type === 'new-key-valid') : ?>
    <div class="resend-alert is-success">
        <span class="resend-alert-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </span>
        <p class="resend-alert-text"><?php esc_html_e('Resend is now connected to your site.', 'resend'); ?></p>
    </div>

<?php elseif ($type === 'new-key-empty') : ?>
    <div class="resend-alert is-danger">
        <span class="resend-alert-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </span>
        <p class="resend-alert-text"><?php esc_html_e('You did not enter API key. Please try again.', 'resend'); ?></p>
    </div>

<?php elseif ($type === 'new-key-invalid') : ?>
    <div class="resend-alert is-danger">
        <span class="resend-alert-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </span>
        <p class="resend-alert-text"><?php esc_html_e('The API key you entered is invalid. Please double-check it.', 'resend'); ?></p>
    </div>
<?php endif; ?>
