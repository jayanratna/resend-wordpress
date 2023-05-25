<?php

/**
 * Plugin Name: Resend (Official)
 * Plugin URI: https://resend.com
 * Description: The best API to reach humans instead of spam folders. Build, test, and deliver transactional emails at scale.
 * Version: 0.1.0
 * Requires PHP: 8.1
 * Requires at least: 5.9
 * Tested up to: 6.2
 * Author: Resend
 */

/**
 * Resend.
 */
class Resend
{
    public static $RESEND_DIR = __DIR__;

    public function __construct()
    {
        if (! defined('RESEND_DIR')) {
            define('RESEND_DIR', self::$RESEND_DIR);
        }

        add_filter('init', array($this, 'init' ));
    }

    public function init()
    {
        add_action('admin_menu', array($this, 'admin_menu'));
    }

    public function admin_menu()
    {
        add_options_page('Resend', 'Resend', 'manage_options', 'resend', array($this, 'settings_html'));
    }

    public function settings_html()
    {
        include RESEND_DIR . '/page-settings.php';
    }
}

if (! function_exists('wp_mail')) {
    $resend = new Resend();
}
