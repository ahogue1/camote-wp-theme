<?php
/**
 * Camote Theme Customizer
 *
 * @package Camote
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function camote_customize_register( $wp_customize ) {
  $wp_customize->remove_section( 'background_image' );


  // add color picker setting
  $wp_customize->add_setting( 'dark_color', array(
    'default' => '#000'
  ) );
  $wp_customize->add_setting( 'text_color', array(
    'default' => '#dddddd'
  ) );
  $wp_customize->add_setting( 'text_over_dark_color', array(
    'default' => '#fff'
  ) );
  $wp_customize->add_setting( 'primary_color', array(
    'default' => '#0A9DE2'
  ) );
  $wp_customize->add_setting( 'secondary_color', array(
    'default' => '#81D742'
  ) );

  // add color picker control
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dark_color', array(
    'label' => 'Dark Color',
    'section' => 'colors',
    'settings' => 'dark_color',
  ) ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
    'label' => 'Text Color',
    'section' => 'colors',
    'settings' => 'text_color',
  ) ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_over_dark_color', array(
    'label' => 'Text Over Dark Color',
    'section' => 'colors',
    'settings' => 'text_over_dark_color',
  ) ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
    'label' => 'Primary Color',
    'section' => 'colors',
    'settings' => 'primary_color',
  ) ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_color', array(
    'label' => 'Secondary Color',
    'section' => 'colors',
    'settings' => 'secondary_color',
  ) ) );

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'camote_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'camote_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'camote_customize_register' );

function camote_customize_theme_colors() {
  $dark_color = get_theme_mod( 'dark_color' );
  $text_color = get_theme_mod( 'text_color' );
  $text_over_dark_color = get_theme_mod( 'text_over_dark_color' );
  $primary_color = get_theme_mod( 'primary_color' );
  $secondary_color = get_theme_mod( 'secondary_color' );

  ?>
    <style type="text/css">
      .main-navigation, #footer {
        background: <?php echo $dark_color; ?>;
        color: <?php echo $text_over_dark_color; ?>;
      }

      #primary-menu a, #primary-menu a:visited, #footer a, #footer a:visited {
        color: <?php echo $text_over_dark_color; ?>;
      }

      #primary-menu a:hover, #footer a:hover {
        color: <?php echo $primary_color; ?>;
      }

      .site-title {
        background: <?php echo $primary_color; ?>;
      }

      .site-description {
        background: <?php echo $secondary_color; ?>;
      }
    </style>
  <?php
}
add_action( 'wp_head', 'camote_customize_theme_colors' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function camote_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function camote_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function camote_customize_preview_js() {
	wp_enqueue_script( 'camote-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'camote_customize_preview_js' );
