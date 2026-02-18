<?php
/**
 * Gutenberg Block Registration
 *
 * @package QuickLoop_Carousel
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class QLC_Carousel_Block
 * 
 * Handles Gutenberg block registration and rendering
 */
class QLC_Carousel_Block {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_block' ) );
	}

	/**
	 * Register the Gutenberg block
	 */
	public function register_block() {
		// Register block script
		wp_register_script(
			'qlc-carousel-block',
			QLC_PLUGIN_URL . 'blocks/carousel/block.js',
			array(
				'wp-blocks',
				'wp-element',
				'wp-block-editor',
				'wp-components',
				'wp-i18n',
				'wp-data',
			),
			QLC_VERSION,
			true
		);

		// Register block editor styles
		wp_register_style(
			'qlc-carousel-block-editor',
			QLC_PLUGIN_URL . 'assets/css/block-editor.css',
			array( 'wp-edit-blocks' ),
			QLC_VERSION
		);
		
		// Add inline style to pass image size as CSS variable
		$settings = QLC_Carousel_Settings::get_settings();
		$image_size = isset( $settings['image_size'] ) ? absint( $settings['image_size'] ) : 80;
		$custom_css = ".block-editor-block-list__layout { --qlc-editor-image-size: {$image_size}px; }";
		wp_add_inline_style( 'qlc-carousel-block-editor', $custom_css );

		// Register the block
		register_block_type(
			QLC_PLUGIN_DIR . 'blocks/carousel/block.json',
			array(
				'render_callback' => array( $this, 'render_block' ),
				'editor_script'   => 'qlc-carousel-block',
				'editor_style'    => 'qlc-carousel-block-editor',
			)
		);
	}

	/**
	 * Server-side block rendering
	 *
	 * @param array  $attributes Block attributes
	 * @param string $content Block content
	 * @return string Rendered block output
	 */
	public function render_block( $attributes, $content = '' ) {
		// Convert images array to comma-separated string
		if ( ! empty( $attributes['images'] ) && is_array( $attributes['images'] ) ) {
			$image_ids = array_map( function( $image ) {
				return is_array( $image ) && isset( $image['id'] ) ? $image['id'] : $image;
			}, $attributes['images'] );
			$attributes['images'] = $image_ids;
		}

		// Remove null values (use global settings for these)
		$attributes = array_filter( $attributes, function( $value ) {
			return $value !== null && $value !== '';
		});

		// Use the renderer
		return QLC_Carousel_Renderer::render( $attributes );
	}
}

// Initialize the block handler
new QLC_Carousel_Block();
