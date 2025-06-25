<?php

class Resend_Admin
{
    public const NONCE = 'resend-nonce';

    private static $initiated = false;

    public static function init()
    {
        if (! self::$initiated) {
            self::init_hooks();
        }

        if (isset($_POST['action']) && $_POST['action'] == 'enter-key') {
            self::enter_api_key();
        }
    }

    public static function init_hooks()
    {
        self::$initiated = true;

        add_action('admin_init', array('Resend_Admin', 'admin_init'));
        add_action('admin_menu', array('Resend_Admin', 'admin_menu'), 5);
        add_action('admin_enqueue_scripts', array('Resend_Admin', 'load_resources'));

        add_filter('plugin_action_links', array('Resend_Admin', 'plugin_action_links'), 10, 2);

        add_filter('plugin_action_links_' . plugin_basename(plugin_dir_path(__FILE__) . '/resend.php'), array('Resend_Admin', 'admin_plugin_settings_link'));
    }

    public static function admin_init()
    {
        if (get_option('Activated_Resend')) {
            delete_option('Activated_Resend');
            if (! headers_sent()) {
                $admin_url = self::get_page_url('init');
                wp_redirect($admin_url);
            }
        }
    }

    public static function admin_menu()
    {
        $hook = add_options_page(__('Resend', 'resend'), __('Resend', 'resend'), 'manage_options', 'resend', array('Resend_Admin', 'display_page'));

        if ($hook) {
            add_action("load-$hook", array('Resend_Admin', 'admin_help'));
        }
    }

    public static function admin_plugin_settings_link($links)
    {
        $settings_link = '<a href="' . esc_url(self::get_page_url()) . '">' . __('Settings', 'resend') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public static function load_resources()
    {
        global $hook_suffix;

        if (in_array(
            $hook_suffix,
            apply_filters(
                'resend_admin_page_hook_suffixes',
                array_merge(
                    array(
                        'index.php',
                        'settings_page_resend'
                    )
                )
            )
        )) {
            $resend_css_path = 'public/resend.css';
            wp_register_style('resend', plugin_dir_url(__FILE__) . $resend_css_path, array(), self::get_asset_file_version($resend_css_path));
            wp_enqueue_style('resend');

            $resend_font_inter_css_path = 'public/fonts/inter.css';
            wp_register_style('resend-font-inter', plugin_dir_url(__FILE__) . $resend_font_inter_css_path, array(), self::get_asset_file_version($resend_font_inter_css_path));
            wp_enqueue_style('resend-font-inter');

            $resend_admin_css_path = 'public/resend-admin.css';
            wp_register_style('resend-admin', plugin_dir_url(__FILE__) . $resend_admin_css_path, array(), self::get_asset_file_version($resend_admin_css_path));
            wp_enqueue_style('resend-admin');

            $resend_admin_js_path = 'public/resend-admin.js';
            wp_register_script('resend-admin.js', plugin_dir_url(__FILE__) . $resend_admin_js_path, array(), self::get_asset_file_version($resend_admin_js_path));
            wp_enqueue_script('resend-admin.js');
        }
    }

    public static function display_page()
    {
        if (! Resend::get_api_key() || (isset($_GET['view']) && $_GET['view'] == 'start')) {
            self::display_start_page();
        } elseif (isset($_GET['view']) && $_GET['view'] == 'stats') {
            self::display_stats_page();
        } else {
            self::display_configuration_page();
        }
    }

    public static function display_start_page()
    {
        Resend::view('start');
    }

    public static function display_stats_page()
    {
        Resend::view('stats');
    }

    public static function display_configuration_page()
    {
        Resend::view('config');
    }

    /**
     * Add help to the Resend page.
     */
    public static function admin_help()
    {
        $current_screen = get_current_screen();

        if (current_user_can('manage_options')) {
            if (! Resend::get_api_key() || (isset($_GET['view']) && $_GET['view'] == 'start')) {
            } elseif (isset($_GET['view']) && $_GET['view'] == 'stats') {
            } else {
                // Configuration page
                $current_screen->add_help_tab(array(
                    'id' => 'overview',
                    'title' => __('Overview', 'resend'),
                    'content' =>
                        '<p>' . esc_html__('Resend is the best way to reach humans instead of spam folders. Deliver transactional and marketing emails at scale.', 'resend') . '</p>' .
                        '<p>' . esc_html__('On this page, you are able to update your Resend settings and view your email history.', 'resend') . '</p>',
                ));
            }
        }

        $current_screen->set_help_sidebar(
            '<p><strong>' . esc_html__('For more information:', 'resend') . '</strong></p>' .
            '<p><a href="https://resend.com/docs" target="_blank">' . esc_html__('Resend Documentation', 'resend') . '</a></p>' .
            '<p><a href="https://resend.com/help" target="_blank">' . esc_html__('Resend Support', 'resend') . '</a></p>'
        );
    }

    public static function enter_api_key()
    {
        if (! current_user_can('manage_options')) {
            return;
        }

        if (! wp_verify_nonce($_POST['_wpnonce'], self::NONCE)) {
            return false;
        }

        $new_key = $_POST['key'];
        $old_key = Resend::get_api_key();

        if (empty($new_key)) {
            if (! empty($old_key)) {
                // Delete old key
            }
        } elseif ($new_key != $old_key) {
            // Save new key
        }

        return true;
    }

    public static function plugin_action_links($links, $file)
    {
        if ($file == plugin_basename(plugin_dir_url(__FILE__) . '/resend.php')) {
            $links[] = '<a href="' . esc_url(self::get_page_url()) . '">' . esc_html__('Settings', 'resend') . '</a>';
        }

        return $links;
    }

    public static function get_page_url($page = 'config')
    {
        $args = array('page' => 'resend');

        if ($page == 'stats') {
            $args = array(
                'page' => 'resend',
                'view' => 'stats',
            );
        } elseif ($page == 'init') {
            $args = array(
                'page' => 'resend',
                'view' => 'start',
            );
        }

        return add_query_arg($args, menu_page_url('resend', false));
    }

    public static function get_asset_file_version($relative_path)
    {
        $full_path = RESEND__PLUGIN_DIR . $relative_path;

        return RESEND_VERSION;
    }
}
