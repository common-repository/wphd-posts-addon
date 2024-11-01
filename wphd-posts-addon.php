<?php
/**
 * Plugin Name: WPHD Post Addon
 * Description: Custom Elementor addon.
 * Plugin URI:  https://wphd.com.br/wphd-plugin/
 * Version:     1.0.0
 * Author:      WPHD
 * Author URI:  https://wphd.com.br/
 * Text Domain: wphd-posts-addon
 * 
 * Elementor tested up to:  3.7.8
 * Elementor Pro tested up to: 3.7.1
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

require_once (plugin_dir_path(__FILE__)) . 'includes/assets/tgm/required-plugins.php';
if (!function_exists('wphd_elementor')) {
  function wphd_elementor()
  {

    // Load plugin file
    require_once(__DIR__ . '/includes/plugin.php');

    if (!function_exists('add_elementor_wphd_elementor_widget_categories')) {
      function add_elementor_wphd_elementor_widget_categories($elements_manager)
      {

        $elements_manager->add_category(
          'wphd',
          [
            'title' => esc_html__('WPHD', 'wphd-posts-addon'),
            'icon' => 'eicon-person',
          ]
        );
      }
    }
    // Run the plugin
    \Elementor_Hedomi\Plugin::instance();
  }
}
add_action('elementor/elements/categories_registered', 'add_elementor_wphd_elementor_widget_categories');
add_action('plugins_loaded', 'wphd_elementor');
