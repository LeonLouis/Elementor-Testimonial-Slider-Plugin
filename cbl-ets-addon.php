<?php
/**
 * Plugin Name: Elementor Testimonial Slider Plugin
 * Description: Simple testimonial slider widget for Elementor.
 * Version: 1.0.0
 * Author: <a href="https://louis.fatbois.life/">Code by Louis</a>
 * Author URI: https://louis.fatbois.life/
 * Text Domain: cbl-ets
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.20.0
 * Elementor Pro tested up to: 3.20.0
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'CBLETS_URL', plugin_dir_url( __FILE__ ) );
define( 'CBLETS_VERSION', '1.0.0' );

function cbl_elementor_testimonial_slider() {
	require_once( __DIR__ . '/includes/plugin.php' );
	\CBL_ETS_Addon\Plugin::instance();
}
add_action( 'plugins_loaded', 'cbl_elementor_testimonial_slider' );