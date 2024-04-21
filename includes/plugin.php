<?php

namespace CBL_ETS_Addon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Plugin {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}
	}

	public function is_compatible() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'check_parent_plugin' ] );
			return false;
		}
		return true;
	}

	public function check_parent_plugin() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'cbl-ets' ),
			'<strong>' . esc_html__( 'Testimonial Slider Addon', 'cbl-ets' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'cbl-ets' ) . '</strong>'
		);

		printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );
    deactivate_plugins( ABSPATH.'wp-content\plugins\cbl-ets-addon/cbl-ets-addon.php' );
	}

	public function init() {
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
    add_action( 'wp_enqueue_scripts', [ $this, 'register_widget_styles' ] );
    add_action( 'elementor/preview/enqueue_styles', [ $this, 'register_widget_styles' ] );
    add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'register_widget_styles' ] );
    add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'register_widget_styles' ] );
	}

	public function register_widgets( $widgets_manager ) {
    require_once( __DIR__ . '/widgets/ets-widget.php' );
    $widgets_manager->register( new \CBL_Elementor_Testimonial_Slider() );
	}

  public function register_widget_styles() {
    wp_enqueue_style( 'cbl-ets-slick', CBLETS_URL.'assets/css/slick.css', array(), CBLETS_VERSION );
    wp_enqueue_style( 'cbl-ets-slick-theme', CBLETS_URL.'assets/css/slick-theme.css', array(), CBLETS_VERSION );
    wp_enqueue_script( 'cbl-ets-slick-js', CBLETS_URL.'assets/js/slick.min.js', array('jquery'), CBLETS_VERSION, true );

    wp_enqueue_script( 'cbl-ets-js', CBLETS_URL.'assets/js/script.js', array('jquery'), CBLETS_VERSION, true );
    wp_enqueue_style( 'cbl-ets-styles', CBLETS_URL.'assets/css/styles.css', array(), CBLETS_VERSION );
  }

}