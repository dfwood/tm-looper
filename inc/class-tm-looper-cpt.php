<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class TM_Looper_CPT
 * @since 1.0.0
 */
class TM_Looper_CPT {

	public static function register_post_types() {
		self::_register_puzzle_cpt();
	}

	protected static function _register_puzzle_cpt() {
		$args = array(
			'label'     => 'Puzzles',
			'public'    => true,
			'menu_icon' => 'dashicons-layout',
			'supports'  => array( 'title', 'custom-fields' ),
		);

		register_post_type( TM_Looper::PUZZLE_CPT, $args );
	}

}