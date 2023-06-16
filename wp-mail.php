<?php

/**
 * WP Mail
 *
 * @param string|string[] $to
 * @param string $subject
 * @param string $message
 * @param string|string[] $headers
 * @param string|string[] $attachments
 * @return bool
 */
function wp_mail($to, $subject, $message, $headers = '', $attachments = array())
{
    // Compact the input, apply the filters, and extract them back out.
    $atts = apply_filters('wp_mail', compact('to', 'subject', 'message', 'headers', 'attachments'));

    $pre_wp_mail = apply_filters('pre_wp_mail', null, $atts);

    if (null !== $pre_wp_mail) {
        return $pre_wp_mail;
    }

    $content_type = 'text/plain';
    $content_type = apply_filters('wp_mail_content_type', $content_type);

    $args = array();
    $response = wp_remote_post('https://api.resend.com/emails', $args);

    if (is_wp_error($response)) {
        do_action('wp_mail_failed', new WP_Error('wp_mail_failed'));
        return false;
    }

    do_action('wp_mail_succeeded', array(

    ));

    return true;
}
