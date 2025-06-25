<?php

?>
<div class="resend-plugin-container">
    <div class="resend-start-container">
        <?php Resend::view('logo'); ?>

        <div>
            <h3 class="resend-h3">Connect your site to Resend</h3>
            <p class="resend-setup-steps-desc">Follow these steps to send an email from your site using Resend.</p>
        </div>

        <div class="resend-setup-steps-container">
            <div class="resend-setup-steps-gradient"></div>

            <div class="resend-setup-step-create-key resend-setup-steps-step-container">
                <div class="resend-setup-steps-spot">
                    <div></div>
                </div>
                <div class="resend-setup-steps-content">
                    <div>
                        <div>
                            <div style="display: flex; align-items: center; margin-bottom: 8px; gap: 8px;">
                                <h3 class="resend-h3" style="margin-bottom: 0;">Create an API key</h3>
                                <svg class="only-completed" xmlns="http://www.w3.org/2000/svg" fill="none" width="22" viewBox="0 0 24 24" stroke-width="2" stroke="#00713f">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <p class="resend-setup-steps-desc">Create an API key with <strong>"Sending access"</strong> permissions to start sending emails from this site.</p>
                            <a class="resend-button is-primary" href="http://resend.com/api-keys" onclick="resendCreateKey()" target="_blank" rel="noopener noreferrer">Create API key</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="resend-setup-step-enter-key resend-setup-steps-step-container is-disabled">
                <div class="resend-setup-steps-spot">
                    <div></div>
                </div>
                <div class="resend-setup-steps-content">
                    <div>
                        <div>
                            <h3 class="resend-h3"><?php esc_html_e('Enter your API key', 'resend'); ?></h3>
                            <p class="resend-setup-steps-desc">Copy your API key from the Resend dashboard, and paste it into the field below.</p>
                            <form action="<?php echo esc_url(Resend_Admin::get_page_url()); ?>" method="post">
                                <?php wp_nonce_field(Resend_Admin::NONCE); ?>
                                <input type="hidden" name="action" value="enter-key">
                                <div>
                                    <input id="key" class="resend-input" name="key" type="text" value="" placeholder="<?php esc_attr_e('re_xxxxxxxxx', 'resend'); ?>" style="width: 100%;">
                                </div>
                                <div style="margin-top: 16px;">
                                    <input type="submit" class="resend-button" value="<?php esc_attr_e('Connect with API key', 'resend'); ?>">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
