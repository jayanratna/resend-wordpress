<?php
wp_register_style('resend-styles', plugins_url('assets/css/admin.css', __FILE__));
wp_enqueue_style('resend-styles');

wp_nonce_field('resend_nonce');
?>
<div class="wrap">
    <div class="logo-bar">
        <a href="http://resend.com" target="_blank" rel="noopener noreferrer">
            Resend
        </a>
    </div>

    <h1 class="nav-tab-wrapper">
        <a class="nav-tab" rel="general">General</a>
		<a class="nav-tab" rel="test">Send Test Email</a>
    </h1>

    <div class="tab-content tab-general">
        General
    </div>

    <div class="tab-content tab-test">
        Send Test Email
    </div>
</div>
