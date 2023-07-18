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

    $settings = get_option('resend_options');

    $content_type = 'text/plain';

    if (empty($headers)) {
        $headers = array();
    } else {
        if (!is_array($headers)) {
            // Explode the headers out, so this function can take
            // both string headers and an array of headers.
            $tempHeaders = explode("\n", str_replace("\r\n", "\n", $headers));
        } else {
            $tempHeaders = $headers;
        }

        $headers = array();

        if (!empty($tempHeaders)) {
            foreach ((array) $tempHeaders as $header) {
                // Explode them out.
                list($name, $content) = explode(':', trim($header), 2);

                // Cleanup crew.
                $name = trim($name);
                $content = trim($content);

                switch (strtolower($name)) {
                    case 'content-type':
                        if (strpos($content, ';')) {
                            list($type, $charset_content) = explode(';', $content);
                            $content_type = trim($type);
                        } elseif (trim($content) !== '') {
                            $content_type = trim($content);
                        }
                        break;
                    default:
                        // Add it to our grand headers array.
                        $headers[trim($name)] = trim($content);
                        break;
                }
            }
        }
    }

    $content_type = apply_filters('wp_mail_content_type', $content_type);

    $body = array(
        'from' => 'wordpress@resend.dev',
        'to' => is_array($to) ? $to : [$to],
        'subject' => $subject,
        'html' => $content_type === 'text/html' ? $message : null,
        'text' => $content_type === 'text/plain' ? $message : null,
    );

    foreach ($attachments as $attachment) {
        if (is_readable($attachment)) {
            $body['attachments'][] = array(
                'content' => base64_encode(file_get_contents($attachment)),
                'filename' => basename($attachment)
            );
        }
    }

    $args = array(
        'headers' => array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $settings['resend_api_key'],
        ),
        'body' => wp_json_encode($body),
    );
    $response = wp_remote_post('https://api.resend.com/emails', $args);

    if (is_wp_error($response)) {
        do_action('wp_mail_failed', new WP_Error('wp_mail_failed'));
        return false;
    }

    do_action('wp_mail_succeeded', array(
        'to' => $body['to'],
        'subject' => $body['subject'],
        'message' => $body['html'] ?? $body['text'],
        'headers' => $headers,
        'attachments' => $body['attachments'] ?? null,
    ));

    return true;
}
