<?php
/**
 * Carousel Shortcode Handler
 *
 * @package QuickLoop_Carousel
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class QLC_Carousel_Shortcode
 * 
 * Handles the carousel shortcode registration and rendering
 */
class QLC_Carousel_Shortcode {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_shortcode( 'qlc_carousel', array( $this, 'render_carousel' ) );
	}

	/**
	 * Render the carousel shortcode
	 *
	 * @param array $atts Shortcode attributes
	 * @return string HTML output
	 */
	public function render_carousel( $atts ) {
		// Parse shortcode attributes
		$atts = shortcode_atts(
			array(
				'images'     => '',
				'autoplay'   => '',  // Empty means use global setting
				'delay'      => '',
				'navigation' => '',
				'pagination' => '',
				'loop'       => '',
				'effect'     => '',  // NEW: slide/fade/zoom
				'speed'      => '',  // NEW: transition speed
			),
			$atts,
			'qlc_carousel'
		);

		// Remove empty values so renderer can use global settings
		$atts = array_filter( $atts, function( $value ) {
			return $value !== '';
		});

		// Use the renderer
		return QLC_Carousel_Renderer::render( $atts );
	}
}

// Initialize the shortcode handler
new QLC_Carousel_Shortcode();
