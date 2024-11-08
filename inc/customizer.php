<?php
/**
 * popper Theme Customizer.
 *
 * @package popper
 */

add_action( 'customize_register', 'popper_customize_register' );
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function popper_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/**
	 * Custom Customizer Customizations
	 */

	// Create heading color setting
	$wp_customize->add_setting( 'header_color', array(
		'default'           => '#000000',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	// Add the controls
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color', array(
				'label'    => esc_html__( 'Header Background Color', 'popper' ),
				'section'  => 'colors',
				'settings' => 'header_color'
			)
		)
	);


	// Add option to select sidebar position
	$wp_customize->add_section( 'popper_options',
		array(
			'title'       => esc_html__( 'Theme Options', 'popper' ),
			//			'priority' => 95,
			'capability'  => 'edit_theme_options',
			'description' => esc_html__( 'Change the default display options for the theme.', 'popper' )
		)
	);

	// Create settings
	$wp_customize->add_setting( 'layout_setting',
		array(
			'default'           => 'no-sidebar',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'popper_sanitize_layout', // Sanitization function appears further down
			'transport'         => 'postMessage'
		)
	);

	// Add the controls
	$wp_customize->add_control( 'popper_layout_control',
		array(
			'type'     => 'radio',
			'label'    => esc_html__( 'Sidebar position', 'popper' ),
			'section'  => 'popper_options',
			'choices'  => array(
				'no-sidebar'    => esc_html__( 'No sidebar (default)', 'popper' ),
				'sidebar-left'  => esc_html__( 'Left sidebar', 'popper' ),
				'sidebar-right' => esc_html__( 'Right sidebar', 'popper' )
			),
			'settings' => 'layout_setting' // Matches setting ID from above
		)
	);
}

add_action( 'customize_preview_init', 'popper_customize_preview_js' );
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function popper_customize_preview_js() {

	wp_register_script(
		'popper_customizer',
		get_template_directory_uri() . '/js/customizer.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
	wp_enqueue_script( 'popper_customizer' );
}

/**
 * Sanitize layout options:
 * If something goes wrong and one of the three specified options are not used,
 * apply the default (no-sidebar).
 *
 * @param $value
 *
 * @return string
 */
function popper_sanitize_layout( $value ) {

	if ( ! in_array( $value, array( 'sidebar-left', 'sidebar-right', 'no-sidebar' ), true ) ) {
		$value = 'no-sidebar';
	}

	return $value;
}

add_action( 'wp_head', 'popper_customize_css' );
/**
 * Inject Customizer CSS when appropriate, write in head.
 */
function popper_customize_css() {

	$header_color = get_theme_mod( 'header_color' );

	if ( $header_color && '#000000' !== $header_color ) {
		?>
		<style type="text/css">
			.site-header {
				background-color: <?php echo $header_color; ?>;
			}
		</style>
		<?php
	}

	if ( '#ffffff' === $header_color && ! get_header_image() ) {
		?>
		<style type="text/css">
			.site-title, .site-description {
				color: #000;
			}
			.main-navigation {
				background-color: transparent;
			}

			@media screen and (min-width: 50em) {

				.main-navigation.toggled {
					background-color: transparent;
				}

				.main-navigation a,
				.main-navigation a:hover,
				.main-navigation a:focus,
				.dropdown-toggle {
					color: #000;
					outline-color: #000;
				}

				.dropdown-toggle {
					background-color: transparent;
				}

				.dropdown-toggle:hover,
				.dropdown-toggle:focus {
					background-color: #fff;
					outline: 1px solid #000;
				}

				.main-navigation ul ul a,
				ul ul .dropdown-toggle {
					color: #fff;
				}

				.main-navigation ul ul a:hover,
				.main-navigation ul ul a:focus {
					outline-color: #B3B3B3;
				}
			}
		</style>
		<?php
	}
}