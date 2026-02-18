<?php
/**
 * Carousel Renderer - Shared rendering logic
 *
 * @package QuickLoop_Carousel
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class QLC_Carousel_Renderer
 * 
 * Handles carousel rendering with attribute merging
 */
class QLC_Carousel_Renderer {

	/**
	 * Render carousel HTML
	 *
	 * @param array $attributes Carousel attributes
	 * @return string HTML output
	 */
	public static function render( $attributes = array() ) {
		// Merge with global settings and defaults
		$atts = self::merge_attributes( $attributes );

		// Validate images parameter
		if ( empty( $atts['images'] ) ) {
			return '<p class="qlc-error">' . esc_html__( 'Please provide image IDs for the carousel.', 'quickloop-carousel' ) . '</p>';
		}

		// Parse image IDs
		if ( is_string( $atts['images'] ) ) {
			$image_ids = array_map( 'absint', explode( ',', $atts['images'] ) );
		} elseif ( is_array( $atts['images'] ) ) {
			$image_ids = array_map( 'absint', $atts['images'] );
		} else {
			$image_ids = array();
		}

		$image_ids = array_filter( $image_ids ); // Remove zero values

		if ( empty( $image_ids ) ) {
			return '<p class="qlc-error">' . esc_html__( 'No valid image IDs provided.', 'quickloop-carousel' ) . '</p>';
		}

		// Generate unique ID for this carousel instance
		static $carousel_count = 0;
		$carousel_count++;
		$carousel_id = 'qlc-carousel-' . $carousel_count;

		// Determine effect class
		$effect_class = 'effect-' . sanitize_html_class( $atts['effect'] );
		$alignment_class = 'alignment-' . sanitize_html_class( $atts['carousel_alignment'] );
		$direction_class = 'direction-' . sanitize_html_class( $atts['flow_direction'] );
		
		// Determine Swiper direction
		$swiper_direction = $atts['carousel_alignment'] === 'vertical' ? 'vertical' : 'horizontal';
		$is_rtl = in_array( $atts['flow_direction'], array( 'rtl', 'btt' ), true );

		// Start output buffering
		ob_start();
		?>
		<div class="qlc-carousel-container <?php echo esc_attr( $effect_class . ' ' . $alignment_class . ' ' . $direction_class ); ?>" 
		     id="<?php echo esc_attr( $carousel_id ); ?>" 
		     style="--qlc-speed: <?php echo esc_attr( $atts['speed'] ); ?>ms; --qlc-image-size: <?php echo esc_attr( $atts['image_size'] ); ?>px;"
		     data-alignment="<?php echo esc_attr( $atts['carousel_alignment'] ); ?>"
		     data-direction="<?php echo esc_attr( $atts['flow_direction'] ); ?>">
			<div class="swiper">
				<div class="swiper-wrapper">
					<?php foreach ( $image_ids as $image_id ) : ?>
						<?php
						// Get image URL and alt text
						$image_url = wp_get_attachment_image_url( $image_id, 'large' );
						$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
						
						// Skip if image doesn't exist
						if ( ! $image_url ) {
							continue;
						}
						?>
						<div class="swiper-slide">
							<img src="<?php echo esc_url( $image_url ); ?>" 
							     alt="<?php echo esc_attr( $image_alt ? $image_alt : __( 'Carousel image', 'quickloop-carousel' ) ); ?>" 
							     loading="lazy">
						</div>
					<?php endforeach; ?>
				</div>
				
				<?php if ( $atts['pagination'] ) : ?>
				<div class="swiper-pagination"></div>
				<?php endif; ?>
				
				<?php if ( $atts['navigation'] ) : ?>
				<div class="swiper-button-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'quickloop-carousel' ); ?>"></div>
				<div class="swiper-button-next" aria-label="<?php esc_attr_e( 'Next slide', 'quickloop-carousel' ); ?>"></div>
				<?php endif; ?>
			</div>
		</div>

		<script>
		document.addEventListener('DOMContentLoaded', function() {
			if (typeof Swiper !== 'undefined') {
				new Swiper('#<?php echo esc_js( $carousel_id ); ?> .swiper', {
					direction: <?php echo wp_json_encode( $swiper_direction ); ?>,
					effect: <?php echo wp_json_encode( $atts['effect'] ); ?>,
					speed: <?php echo absint( $atts['speed'] ); ?>,
					loop: <?php echo $atts['loop'] ? 'true' : 'false'; ?>,
					<?php if ( $is_rtl && $swiper_direction === 'horizontal' ) : ?>
					direction: 'horizontal',
					reverseDirection: true,
					<?php endif; ?>
					autoplay: <?php echo $atts['autoplay'] ? '{ delay: ' . absint( $atts['delay'] ) . ', disableOnInteraction: false, pauseOnMouseEnter: true, reverseDirection: ' . ( $is_rtl ? 'true' : 'false' ) . ' }' : 'false'; ?>,
					pagination: <?php echo $atts['pagination'] ? '{ el: ".swiper-pagination", clickable: true, type: "bullets" }' : 'false'; ?>,
					navigation: <?php echo $atts['navigation'] ? '{ nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" }' : 'false'; ?>,
					keyboard: {
						enabled: true,
						onlyInViewport: true
					},
					a11y: {
						enabled: true,
						prevSlideMessage: <?php echo wp_json_encode( __( 'Previous slide', 'quickloop-carousel' ) ); ?>,
						nextSlideMessage: <?php echo wp_json_encode( __( 'Next slide', 'quickloop-carousel' ) ); ?>,
						paginationBulletMessage: <?php echo wp_json_encode( __( 'Go to slide {{index}}', 'quickloop-carousel' ) ); ?>
					}
				});
			}
		});
		</script>
		<?php

		return ob_get_clean();
	}

	/**
	 * Merge attributes with global settings
	 * Priority: instance attributes > global settings > defaults
	 *
	 * @param array $attributes Instance attributes
	 * @return array Merged attributes
	 */
	private static function merge_attributes( $attributes ) {
		// Get global settings
		$global_settings = QLC_Carousel_Settings::get_settings();

		// Default values
		$defaults = array(
			'images'             => '',
			'autoplay'           => $global_settings['enable_autoplay'],
			'delay'              => $global_settings['autoplay_delay'],
			'navigation'         => $global_settings['show_arrows'],
			'pagination'         => true,
			'loop'               => $global_settings['enable_loop'],
			'effect'             => $global_settings['animation_effect'],
			'speed'              => $global_settings['transition_speed'],
			'carousel_alignment' => $global_settings['carousel_alignment'],
			'image_size'         => $global_settings['image_size'],
			'flow_direction'     => $global_settings['flow_direction'],
		);

		// Merge: instance > defaults (which already include global settings)
		$merged = wp_parse_args( $attributes, $defaults );

		// Convert string booleans to actual booleans
		foreach ( array( 'autoplay', 'navigation', 'pagination', 'loop' ) as $bool_key ) {
			if ( is_string( $merged[ $bool_key ] ) ) {
				$merged[ $bool_key ] = filter_var( $merged[ $bool_key ], FILTER_VALIDATE_BOOLEAN );
			} else {
				$merged[ $bool_key ] = (bool) $merged[ $bool_key ];
			}
		}

		// Sanitize effect
		$allowed_effects = array( 'slide', 'fade', 'zoom' );
		if ( ! in_array( $merged['effect'], $allowed_effects, true ) ) {
			$merged['effect'] = 'slide';
		}

		// Sanitize numeric values
		$merged['delay'] = absint( $merged['delay'] );
		$merged['speed'] = absint( $merged['speed'] );

		return $merged;
	}
}
