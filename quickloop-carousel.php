<?php
/**
 * Plugin Name: QuickLoop Carousel
 * Plugin URI: https://github.com/yourusername/quickloop-carousel
 * Description: A lightweight, simple carousel plugin for WordPress. Display beautiful image carousels using an easy shortcode.
 * Version: 1.2.0
 * Author: Hrishikesh Das
 * Author URI: https://yourwebsite.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: quickloop-carousel
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.0
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants
define( 'QLC_VERSION', '1.2.0' );
define( 'QLC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'QLC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'QLC_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Load plugin text domain for translations
 */
function qlc_load_textdomain() {
	load_plugin_textdomain( 'quickloop-carousel', false, dirname( QLC_PLUGIN_BASENAME ) . '/languages' );
}
add_action( 'plugins_loaded', 'qlc_load_textdomain' );

/**
 * Include required files
 */
require_once QLC_PLUGIN_DIR . 'includes/class-carousel-renderer.php';
require_once QLC_PLUGIN_DIR . 'includes/class-carousel-shortcode.php';
require_once QLC_PLUGIN_DIR . 'includes/class-carousel-settings.php';
require_once QLC_PLUGIN_DIR . 'includes/class-carousel-block.php';

/**
 * Enqueue plugin styles
 */
function qlc_enqueue_styles() {
	wp_enqueue_style(
		'quickloop-carousel',
		QLC_PLUGIN_URL . 'assets/css/carousel.css',
		array(),
		QLC_VERSION,
		'all'
	);
	
	// Enqueue Swiper CSS from CDN
	wp_enqueue_style(
		'swiper',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
		array(),
		'11.0.0',
		'all'
	);
}
add_action( 'wp_enqueue_scripts', 'qlc_enqueue_styles' );

/**
 * Enqueue plugin scripts
 */
function qlc_enqueue_scripts() {
	// Enqueue Swiper JS from CDN
	wp_enqueue_script(
		'swiper',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
		array(),
		'11.0.0',
		true
	);
	
	// Enqueue our carousel initialization script
	wp_enqueue_script(
		'quickloop-carousel',
		QLC_PLUGIN_URL . 'assets/js/carousel.js',
		array( 'swiper' ),
		QLC_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'qlc_enqueue_scripts' );

/**
 * Plugin activation hook
 */
function qlc_activate() {
	// Flush rewrite rules on activation
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'qlc_activate' );

/**
 * Plugin deactivation hook
 */
function qlc_deactivate() {
	// Flush rewrite rules on deactivation
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'qlc_deactivate' );
