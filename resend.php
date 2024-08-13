<?php

/**
 * Plugin Name: Resend
 * Plugin URI: https://resend.com
 * Description: The best API to reach humans instead of spam folders. Build, test, and deliver transactional emails at scale.
 * Version: 1.0.0
 * Tested up to: 6.2
 * Author: Resend
 */

/**
 * Resend for Wordpress
 */
class Resend
{
    public $settings;

    public static $RESEND_DIR = __DIR__;

    public function __construct()
    {
        if (! defined('RESEND_DIR')) {
            define('RESEND_DIR', self::$RESEND_DIR);
        }

        add_filter('init', array($this, 'init'));

        $this->settings = $this->load_settings();
    }

    public function init()
    {
        // Initialise settings...
        add_action('admin_init', array($this, 'register_settings'));

        // Add settings page to menu...
        add_action('admin_menu', array($this, 'register_options_page'));

        // Add settings link to plugin page...
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settings_link'));

        add_action('wp_ajax_resend_test', array($this, 'send_test_email'));
    }

    public function load_settings()
    {
        return get_option('resend_options');
    }

    public function register_options_page()
    {
        add_options_page(
            'Resend Settings',
            'Resend',
            'manage_options',
            'resend',
            array($this, 'options_page_html')
        );
    }

    public function add_settings_link($links)
    {
        $settings_link = '<a href="options-general.php?page=resend">' . __('Settings', 'resend') . '</a>';
        array_push($links, $settings_link);
        return $links;
    }

    public function options_page_html()
    {
        include RESEND_DIR . '/options-page.php';
    }

    public function send_test_email()
    {
        $response = wp_mail('onboarding@resend.dev', 'Resend Test: dev', 'This is a test message', array());

        wp_die();
    }

    public function register_settings()
    {
        // Register new settings for "resend" page.
        register_setting('resend', 'resend_options', array($this, 'validate_fields'));

        add_settings_section(
            'resend_section_developers',
            __('Developers', 'resend'),
            array($this, 'resend_section_developers_callback'),
            'resend'
        );

        add_settings_field(
            'resend_api_key',
            __('API Key', 'resend'),
            array($this, 'resend_api_key_callback'),
            'resend',
            'resend_section_developers',
            array(
                'label_for' => 'resend_api_key',
                'class' => 'resend_row',
                'resend_custom_data' => 'custom'
            )
        );
    }

    public function validate_fields($data)
    {
        if ($data['resend_api_key'] == '') {
            add_settings_error('resend_messages', 'no-api-key', __('An API key is required', 'resend'), 'error');
            return false;
        }

        return $data;
    }

    public function resend_section_developers_callback()
    {
        include RESEND_DIR . '/settings/resend-section-developers.php';
    }

    public function resend_api_key_callback($args)
    {
        include RESEND_DIR . '/settings/resend-api-key.php';
    }
}

if (! function_exists('wp_mail')) {
    $resend = new Resend();

    if (is_array($resend->settings)) {
        include RESEND_DIR . '/wp-mail.php';
    }
}
