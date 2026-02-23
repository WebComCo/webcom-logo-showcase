<?php
/**
 * Plugin Name: Webcom Logo Showcase
 * Description: نمایش لوگوی مشتریان با افکت‌های پیشرفته و سازگار با المنتور.
 * Version: 1.3.0
 * Author: webcom (MehrDad)
 * Author URI: https://webcomco.com
 * Text Domain: webcom-logo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'WLS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WLS_URL', plugin_dir_url( __FILE__ ) );

require_once WLS_PATH . 'includes/cpt.php';

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'wls-style', WLS_URL . 'assets/css/style.css', array(), '1.3.0' );
    wp_enqueue_script( 'wls-script', WLS_URL . 'assets/js/script.js', array('jquery'), '1.3.0', true );
});

add_action( 'elementor/widgets/register', function( $widgets_manager ) {
    if ( ! did_action( 'elementor/loaded' ) ) return;
    require_once WLS_PATH . 'includes/elementor-addon.php';
    $widgets_manager->register( new \Webcom_Logo_Widget() );
});