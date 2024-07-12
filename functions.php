<?php
/**
 * Tsubaki functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Three
 * @since Tsubaki 1.0
 */


if ( ! function_exists( 'tsubaki_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Tsubaki 1.0
	 *
	 * @return void
	 */
	function tsubaki_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

	}

endif;

add_action( 'after_setup_theme', 'tsubaki_support' );

if ( ! function_exists( 'tsubaki_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since Tsubaki 1.0
	 *
	 * @return void
	 */
	function tsubaki_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'tsubaki-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'tsubaki-style' );

		// Enqueue the additional stylesheet for Twenty Twenty-Three.
		if ( class_exists( 'WooCommerce' ) && function_exists( 'WC' ) && defined( 'WC_ABSPATH' ) && file_exists( WC_ABSPATH . 'assets/css/twenty-twenty-three.css' ) ) {

			wp_enqueue_style( 'woocommerce-twenty-twenty-three', WC()->plugin_url() . '/assets/css/twenty-twenty-three.css' );

			wp_dequeue_style( 'woocommerce-general' );
		}
	}

endif;

add_action( 'wp_enqueue_scripts', 'tsubaki_styles' );

if ( ! function_exists( 'tsubaki_woocommerce_init' ) ) :
	/**
	 * Initialize WooCommerce compatibility.
	 *
	 * @since Tsubaki 1.0.1
	 * @return void
	 */
	function tsubaki_woocommerce_init() {
		if ( ! class_exists( 'WooCommerce' ) || ! defined( 'WC_ABSPATH' ) || ! file_exists( WC_ABSPATH . 'includes/theme-support/class-wc-twenty-twenty-three.php' ) ) {
			return;
		}

		// Load WooCommerce compatibility file if WooCommerce is loaded and the compatibility file exists.
		include_once WC_ABSPATH . 'includes/theme-support/class-wc-twenty-twenty-three.php';
	}
endif;

add_action( 'after_setup_theme', 'tsubaki_woocommerce_init' );


add_action( 'init', 'tsubaki_input_styles' );

if ( ! function_exists( 'tsubaki_input_styles' ) ) :
	/**
	 * Adds styling capabilities to input elements.
	 *
	 * @since 1.2.0
	 * 
	 * @return void
	 */
	function tsubaki_input_styles() {

		add_filter( 'woocommerce_dropdown_variation_attribute_options_html', function( $html ) {
			return sprintf( '<span class="tsubaki-element-select">%s</span>', $html );
		});
	}
endif;
