<?php
/**
 * IKA functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 *
 */
// Create Theme Customizer
require( get_template_directory() . '/inc/customizer.php' );
// Create Slider Post Type
require( get_template_directory() . '/inc/slider/slider_post_type.php' );
// Create Portfolio Post Type
require( get_template_directory() . '/inc/portfolio/portfolio_post_type.php' );
require( get_template_directory() . '/inc/portfolio/related.php' );
require( get_template_directory() . '/inc/portfolio/portfolio_footer.php' );

require_once( get_template_directory() . '/inc/theme_functions.php' );
require_once( get_template_directory() . '/inc/theme_setup.php' );
?>