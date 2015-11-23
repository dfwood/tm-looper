<?php
/**
 * Plugin Name: Looper
 * Plugin URI: http://davidwood.ninja/plugins/
 * Description: A simple puzzle plugin inspired by the Loop app for Android and iOS. http://loopgame.co/
 * Version: 1.0.0
 * Author: David Wood
 * Author URI: http://davidwood.ninja/
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: tm-looper
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class TM_Looper
 * @since 1.0.0
 */
class TM_Looper {

	const PUZZLE_CPT = 'tm_loop_puzzle';

	public function __construct() {
		require_once( __DIR__ . '/inc/class-tm-looper-cpt.php' );
		require_once( __DIR__ . '/inc/class-tm-looper-board-builder.php' );

		add_action( 'plugins_loaded', array( $this, '_load_textdomain' ) );
		add_action( 'init', array( 'TM_Looper_CPT', 'register_post_types' ) );

		add_action( 'wp_enqueue_scripts', array( $this, '_enqueue_scripts' ) );

		add_filter( 'the_content', array( $this, '_filter_puzzle_content' ) );

		register_activation_hook( __FILE__, array( $this, '_activate' ) );
		register_deactivation_hook( __FILE__, array( $this, '_deactivate' ) );
	}

	public function _load_textdomain() {
		load_plugin_textdomain( 'tm-looper', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	public function _enqueue_scripts() {
		$min = '.min';
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$min = '';
		}

		wp_enqueue_style( 'tm-looper', plugins_url( "assets/css/tm-looper{$min}.css", __FILE__ ) );
		wp_enqueue_script( 'tm-looper', plugins_url( "assets/js/tm-looper{$min}.js", __FILE__ ), array( 'jquery' ) );
	}

	public function _filter_puzzle_content( $content ) {
		if ( is_singular( self::PUZZLE_CPT ) ) {
			$board = new TM_Looper_Board_Builder();
			if ( ! empty( $board ) ) {
				$content = $board->get_html();
			}
		}

		return $content;
	}

	public function _activate() {
		require_once( __DIR__ . '/inc/class-tm-looper-cpt.php' );
		TM_Looper_CPT::register_post_types();
		flush_rewrite_rules();
	}

	public function _deactivate() {
		flush_rewrite_rules();
	}

}

new TM_Looper();