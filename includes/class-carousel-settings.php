<?php
/**
 * Carousel Settings Page
 *
 * @package QuickLoop_Carousel
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class QLC_Carousel_Settings
 * 
 * Handles the admin settings page and options
 */
class QLC_Carousel_Settings {

	/**
	 * Settings option name
	 */
	const OPTION_NAME = 'qlc_carousel_settings';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	/**
	 * Add settings page to WordPress admin menu
	 */
	public function add_settings_page() {
		add_options_page(
			__( 'QuickLoop Carousel Settings', 'quickloop-carousel' ),
			__( 'QuickLoop Carousel', 'quickloop-carousel' ),
			'manage_options',
			'qlc-carousel-settings',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Register plugin settings
	 */
	public function register_settings() {
		register_setting(
			'qlc_carousel_settings_group',
			self::OPTION_NAME,
			array( $this, 'sanitize_settings' )
		);

		// General Settings Section
		add_settings_section(
			'qlc_general_section',
			__( 'General Settings', 'quickloop-carousel' ),
			array( $this, 'render_general_section' ),
			'qlc-carousel-settings'
		);

		add_settings_field(
			'enable_loop',
			__( 'Enable Loop', 'quickloop-carousel' ),
			array( $this, 'render_checkbox_field' ),
			'qlc-carousel-settings',
			'qlc_general_section',
			array(
				'label_for' => 'enable_loop',
				'description' => __( 'Enable infinite carousel loop', 'quickloop-carousel' ),
			)
		);

		add_settings_field(
			'show_arrows',
			__( 'Show Navigation Arrows', 'quickloop-carousel' ),
			array( $this, 'render_checkbox_field' ),
			'qlc-carousel-settings',
			'qlc_general_section',
			array(
				'label_for' => 'show_arrows',
				'description' => __( 'Display previous/next navigation buttons', 'quickloop-carousel' ),
			)
		);

		// Layout Settings Section
		add_settings_section(
			'qlc_layout_section',
			__( 'Layout Settings', 'quickloop-carousel' ),
			array( $this, 'render_layout_section' ),
			'qlc-carousel-settings'
		);

		add_settings_field(
			'carousel_alignment',
			__( 'Carousel Alignment', 'quickloop-carousel' ),
			array( $this, 'render_select_field' ),
			'qlc-carousel-settings',
			'qlc_layout_section',
			array(
				'label_for' => 'carousel_alignment',
				'description' => __( 'Choose carousel orientation', 'quickloop-carousel' ),
				'options' => array(
					'horizontal' => __( 'Horizontal', 'quickloop-carousel' ),
					'vertical' => __( 'Vertical', 'quickloop-carousel' ),
				),
			)
		);

		add_settings_field(
			'image_size',
			__( 'Image Size (px)', 'quickloop-carousel' ),
			array( $this, 'render_number_field' ),
			'qlc-carousel-settings',
			'qlc_layout_section',
			array(
				'label_for' => 'image_size',
				'description' => __( 'Size of carousel images in pixels', 'quickloop-carousel' ),
				'min' => 200,
				'max' => 800,
				'step' => 50,
			)
		);

		add_settings_field(
			'flow_direction',
			__( 'Flow Direction', 'quickloop-carousel' ),
			array( $this, 'render_flow_direction_field' ),
			'qlc-carousel-settings',
			'qlc_layout_section',
			array(
				'label_for' => 'flow_direction',
				'description' => __( 'Direction of carousel flow', 'quickloop-carousel' ),
			)
		);

		// Autoplay Settings Section
		add_settings_section(
			'qlc_autoplay_section',
			__( 'Autoplay Settings', 'quickloop-carousel' ),
			array( $this, 'render_autoplay_section' ),
			'qlc-carousel-settings'
		);

		add_settings_field(
			'enable_autoplay',
			__( 'Enable Autoplay by Default', 'quickloop-carousel' ),
			array( $this, 'render_checkbox_field' ),
			'qlc-carousel-settings',
			'qlc_autoplay_section',
			array(
				'label_for' => 'enable_autoplay',
				'description' => __( 'Automatically advance slides', 'quickloop-carousel' ),
			)
		);

		add_settings_field(
			'autoplay_delay',
			__( 'Autoplay Delay (ms)', 'quickloop-carousel' ),
			array( $this, 'render_number_field' ),
			'qlc-carousel-settings',
			'qlc_autoplay_section',
			array(
				'label_for' => 'autoplay_delay',
				'description' => __( 'Time between slide transitions in milliseconds', 'quickloop-carousel' ),
				'min' => 1000,
				'max' => 10000,
				'step' => 100,
			)
		);

		// Animation Settings Section
		add_settings_section(
			'qlc_animation_section',
			__( 'Animation Settings', 'quickloop-carousel' ),
			array( $this, 'render_animation_section' ),
			'qlc-carousel-settings'
		);

		add_settings_field(
			'transition_speed',
			__( 'Transition Speed (ms)', 'quickloop-carousel' ),
			array( $this, 'render_number_field' ),
			'qlc-carousel-settings',
			'qlc_animation_section',
			array(
				'label_for' => 'transition_speed',
				'description' => __( 'Animation duration for slide transitions', 'quickloop-carousel' ),
				'min' => 100,
				'max' => 2000,
				'step' => 50,
			)
		);

		add_settings_field(
			'animation_effect',
			__( 'Animation Effect', 'quickloop-carousel' ),
			array( $this, 'render_select_field' ),
			'qlc-carousel-settings',
			'qlc_animation_section',
			array(
				'label_for' => 'animation_effect',
				'description' => __( 'Choose the animation style for transitions', 'quickloop-carousel' ),
				'options' => array(
					'slide' => __( 'Slide', 'quickloop-carousel' ),
					'fade'  => __( 'Fade', 'quickloop-carousel' ),
					'zoom'  => __( 'Zoom', 'quickloop-carousel' ),
				),
			)
		);
	}

	/**
	 * Render general settings section description
	 */
	public function render_general_section() {
		echo '<p>' . esc_html__( 'Configure default behavior for all carousels.', 'quickloop-carousel' ) . '</p>';
	}

	/**
	 * Render autoplay settings section description
	 */
	public function render_autoplay_section() {
		echo '<p>' . esc_html__( 'Control automatic slide advancement settings.', 'quickloop-carousel' ) . '</p>';
	}

	/**
	 * Render layout settings section description
	 */
	public function render_layout_section() {
		echo '<p>' . esc_html__( 'Configure carousel orientation, image size, and flow direction.', 'quickloop-carousel' ) . '</p>';
	}

	/**
	 * Render animation settings section description
	 */
	public function render_animation_section() {
		echo '<p>' . esc_html__( 'Customize the visual effects and animation speed.', 'quickloop-carousel' ) . '</p>';
	}

	/**
	 * Render checkbox field
	 *
	 * @param array $args Field arguments
	 */
	public function render_checkbox_field( $args ) {
		$settings = $this->get_settings();
		$value = ! empty( $settings[ $args['label_for'] ] ) ? 1 : 0;
		?>
		<label>
			<input 
				type="checkbox" 
				id="<?php echo esc_attr( $args['label_for'] ); ?>" 
				name="<?php echo esc_attr( self::OPTION_NAME . '[' . $args['label_for'] . ']' ); ?>" 
				value="1" 
				<?php checked( $value, 1 ); ?>
			/>
			<span class="description"><?php echo esc_html( $args['description'] ); ?></span>
		</label>
		<?php
	}

	/**
	 * Render number field
	 *
	 * @param array $args Field arguments
	 */
	public function render_number_field( $args ) {
		$settings = $this->get_settings();
		$value = isset( $settings[ $args['label_for'] ] ) ? $settings[ $args['label_for'] ] : '';
		?>
		<input 
			type="number" 
			id="<?php echo esc_attr( $args['label_for'] ); ?>" 
			name="<?php echo esc_attr( self::OPTION_NAME . '[' . $args['label_for'] . ']' ); ?>" 
			value="<?php echo esc_attr( $value ); ?>" 
			min="<?php echo esc_attr( $args['min'] ); ?>" 
			max="<?php echo esc_attr( $args['max'] ); ?>" 
			step="<?php echo esc_attr( $args['step'] ); ?>" 
			class="regular-text"
		/>
		<p class="description"><?php echo esc_html( $args['description'] ); ?></p>
		<?php
	}

	/**
	 * Render select field
	 *
	 * @param array $args Field arguments
	 */
	public function render_select_field( $args ) {
		$settings = $this->get_settings();
		$value = isset( $settings[ $args['label_for'] ] ) ? $settings[ $args['label_for'] ] : '';
		?>
		<select 
			id="<?php echo esc_attr( $args['label_for'] ); ?>" 
			name="<?php echo esc_attr( self::OPTION_NAME . '[' . $args['label_for'] . ']' ); ?>"
		>
			<?php foreach ( $args['options'] as $option_value => $option_label ) : ?>
				<option 
					value="<?php echo esc_attr( $option_value ); ?>" 
					<?php selected( $value, $option_value ); ?>
				>
					<?php echo esc_html( $option_label ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<p class="description"><?php echo esc_html( $args['description'] ); ?></p>
		<?php
	}

	/**
	 * Render flow direction field (dynamic based on alignment)
	 *
	 * @param array $args Field arguments
	 */
	public function render_flow_direction_field( $args ) {
		$settings = $this->get_settings();
		$value = isset( $settings[ $args['label_for'] ] ) ? $settings[ $args['label_for'] ] : '';
		$alignment = isset( $settings['carousel_alignment'] ) ? $settings['carousel_alignment'] : 'horizontal';
		?>
		<select 
			id="<?php echo esc_attr( $args['label_for'] ); ?>" 
			name="<?php echo esc_attr( self::OPTION_NAME . '[' . $args['label_for'] . ']' ); ?>"
			class="qlc-flow-direction-select"
		>
			<!-- Horizontal options -->
			<option value="ltr" <?php selected( $value, 'ltr' ); ?> data-alignment="horizontal">
				<?php esc_html_e( 'Left to Right', 'quickloop-carousel' ); ?>
			</option>
			<option value="rtl" <?php selected( $value, 'rtl' ); ?> data-alignment="horizontal">
				<?php esc_html_e( 'Right to Left', 'quickloop-carousel' ); ?>
			</option>
			<!-- Vertical options -->
			<option value="ttb" <?php selected( $value, 'ttb' ); ?> data-alignment="vertical">
				<?php esc_html_e( 'Top to Bottom', 'quickloop-carousel' ); ?>
			</option>
			<option value="btt" <?php selected( $value, 'btt' ); ?> data-alignment="vertical">
				<?php esc_html_e( 'Bottom to Top', 'quickloop-carousel' ); ?>
			</option>
		</select>
		<p class="description"><?php echo esc_html( $args['description'] ); ?></p>
		<script>
			// Hide/show flow direction options based on alignment
			(function() {
				var alignmentSelect = document.getElementById('carousel_alignment');
				var flowSelect = document.querySelector('.qlc-flow-direction-select');
				
				function updateFlowOptions() {
					var alignment = alignmentSelect ? alignmentSelect.value : 'horizontal';
					var options = flowSelect.querySelectorAll('option');
					
					options.forEach(function(option) {
						var optionAlignment = option.getAttribute('data-alignment');
						if (optionAlignment === alignment) {
							option.style.display = '';
							option.disabled = false;
						} else {
							option.style.display = 'none';
							option.disabled = true;
						}
					});
					
					// Select first visible option if current is hidden
					if (flowSelect.selectedOptions[0] && flowSelect.selectedOptions[0].disabled) {
						var firstVisible = flowSelect.querySelector('option[data-alignment="' + alignment + '"]');
						if (firstVisible) {
							flowSelect.value = firstVisible.value;
						}
					}
				}
				
				if (alignmentSelect) {
					alignmentSelect.addEventListener('change', updateFlowOptions);
					updateFlowOptions(); // Initial call
				}
			})();
		</script>
		<?php
	}

	/**
	 * Sanitize settings before saving
	 *
	 * @param array $input Input settings
	 * @return array Sanitized settings
	 */
	public function sanitize_settings( $input ) {
		$sanitized = array();

		// Checkboxes
		$sanitized['enable_loop'] = ! empty( $input['enable_loop'] ) ? 1 : 0;
		$sanitized['show_arrows'] = ! empty( $input['show_arrows'] ) ? 1 : 0;
		$sanitized['enable_autoplay'] = ! empty( $input['enable_autoplay'] ) ? 1 : 0;

		// Numbers
		$sanitized['autoplay_delay'] = isset( $input['autoplay_delay'] ) ? absint( $input['autoplay_delay'] ) : 3000;
		$sanitized['transition_speed'] = isset( $input[' transition_speed'] ) ? absint( $input['transition_speed'] ) : 300;
		
		// Image size (200-800px range)
		$image_size = isset( $input['image_size'] ) ? absint( $input['image_size'] ) : 400;
		$sanitized['image_size'] = max( 200, min( 800, $image_size ) );

		// Select - validate against allowed values
		$allowed_effects = array( 'slide', 'fade', 'zoom' );
		$sanitized['animation_effect'] = isset( $input['animation_effect'] ) && in_array( $input['animation_effect'], $allowed_effects, true ) 
			? sanitize_key( $input['animation_effect'] ) 
			: 'slide';
		
		// Carousel alignment
		$allowed_alignments = array( 'horizontal', 'vertical' );
		$sanitized['carousel_alignment'] = isset( $input['carousel_alignment'] ) && in_array( $input['carousel_alignment'], $allowed_alignments, true )
			? sanitize_key( $input['carousel_alignment'] )
			: 'horizontal';
		
		// Flow direction
		$allowed_directions = array( 'ltr', 'rtl', 'ttb', 'btt' );
		$sanitized['flow_direction'] = isset( $input['flow_direction'] ) && in_array( $input['flow_direction'], $allowed_directions, true )
			? sanitize_key( $input['flow_direction'] )
			: 'ltr';

		return $sanitized;
	}

	/**
	 * Get settings with defaults
	 *
	 * @return array Settings array
	 */
	public static function get_settings() {
		$defaults = array(
			'enable_loop'        => 1,
			'show_arrows'        => 1,
			'enable_autoplay'    => 1,
			'autoplay_delay'     => 3000,
			'transition_speed'   => 300,
			'animation_effect'   => 'slide',
			'carousel_alignment' => 'horizontal',
			'image_size'         => 400,
			'flow_direction'     => 'ltr',
		);

		$settings = get_option( self::OPTION_NAME, array() );
		return wp_parse_args( $settings, $defaults );
	}

	/**
	 * Render settings page
	 */
	public function render_settings_page() {
		// Check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'quickloop-carousel' ) );
		}
		?>
		<div class="wrap qlc-settings-wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			
			<?php settings_errors( 'qlc_carousel_settings_group' ); ?>

			<form method="post" action="options.php">
				<?php
				settings_fields( 'qlc_carousel_settings_group' );
				do_settings_sections( 'qlc-carousel-settings' );
				?>
				
				<div class="qlc-settings-actions">
					<?php submit_button( __( 'Save Changes', 'quickloop-carousel' ), 'primary', 'submit', false ); ?>
					<button type="button" class="button button-secondary qlc-reset-defaults" id="qlc-reset-defaults">
						<?php esc_html_e( 'Reset to Defaults', 'quickloop-carousel' ); ?>
					</button>
				</div>
			</form>

			<div class="qlc-settings-info">
				<h2><?php esc_html_e( 'Shortcode Usage', 'quickloop-carousel' ); ?></h2>
				<p><?php esc_html_e( 'Use the following shortcode to display a carousel:', 'quickloop-carousel' ); ?></p>
				<code>[qlc_carousel images="123,456,789"]</code>
				
				<p><strong><?php esc_html_e( 'Available Parameters:', 'quickloop-carousel' ); ?></strong></p>
				<ul>
					<li><code>images</code> - <?php esc_html_e( 'Comma-separated image IDs (required)', 'quickloop-carousel' ); ?></li>
					<li><code>effect</code> - <?php esc_html_e( 'Animation effect: slide, fade, zoom (overrides global)', 'quickloop-carousel' ); ?></li>
					<li><code>speed</code> - <?php esc_html_e( 'Transition speed in ms (overrides global)', 'quickloop-carousel' ); ?></li>
					<li><code>autoplay</code> - <?php esc_html_e( 'Enable/disable autoplay (overrides global)', 'quickloop-carousel' ); ?></li>
					<li><code>delay</code> - <?php esc_html_e( 'Autoplay delay in ms (overrides global)', 'quickloop-carousel' ); ?></li>
					<li><code>navigation</code> - <?php esc_html_e( 'Show/hide arrows (overrides global)', 'quickloop-carousel' ); ?></li>
					<li><code>loop</code> - <?php esc_html_e( 'Enable/disable loop (overrides global)', 'quickloop-carousel' ); ?></li>
				</ul>
			</div>
		</div>
		<?php
	}

	/**
	 * Enqueue admin assets
	 *
	 * @param string $hook Current admin page hook
	 */
	public function enqueue_admin_assets( $hook ) {
		// Only load on our settings page
		if ( 'settings_page_qlc-carousel-settings' !== $hook ) {
			return;
		}

		wp_enqueue_style(
			'qlc-admin',
			QLC_PLUGIN_URL . 'assets/css/admin.css',
			array(),
			QLC_VERSION
		);

		wp_enqueue_script(
			'qlc-admin',
			QLC_PLUGIN_URL . 'assets/js/admin.js',
			array( 'jquery' ),
			QLC_VERSION,
			true
		);

		wp_localize_script(
			'qlc-admin',
			'qlcAdmin',
			array(
				'resetConfirm' => __( 'Are you sure you want to reset all settings to defaults?', 'quickloop-carousel' ),
				'nonce' => wp_create_nonce( 'qlc_reset_settings' ),
			)
		);
	}
}

// Initialize the settings page
new QLC_Carousel_Settings();
