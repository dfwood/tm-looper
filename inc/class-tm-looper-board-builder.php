<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class TM_Looper_Board_Builder
 * @since 1.0.0
 */
class TM_Looper_Board_Builder {

	protected $board_id = 0;
	protected $board_html = '';

	public function __construct( $board_id = 0 ) {
		$board_id = absint( $board_id );
		if ( 0 == $board_id && get_the_ID() ) {
			$board_id = get_the_ID();
		} else {
			return;
		}

		$this->board_id = $board_id;

		$this->_build_board();
	}

	public function get_html() {
		return $this->board_html;
	}

	protected function _build_board() {
		$output = '';

		if ( $vars = $this->_get_board_parts() ) {
			list( $width, $height, $data ) = $vars;

			// TODO: Add grid color classes!
			$grid_classes = array( 'grid', "c{$width}", "r{$height}" );
			$grid_classes = esc_attr( implode( ' ', $grid_classes ) );

			$parts   = array();
			$parts[] = "<div class='{$grid_classes}' data-cols='{$width}' data-rows='{$height}'>";

			/**
			 * BOARD DATA
			 * 0 = empty
			 * 1 = line
			 * 2 = curve
			 * 3 = tri-curve
			 * 4 = star-curve
			 * 5 = end
			 */
			foreach ( $data as $value ) {
				$rotation   = rand( 0, 3 );
				$class_list = array(
					'tile',
					"tile-{$value}",
					"rot-{$rotation}",
				);
				$classes    = esc_attr( implode( ' ', $class_list ) );

				$parts[] = "<div class='{$classes}' data-rot='{$rotation}'>";
				switch ( $value ) {
					case 4:
						$parts[] = '<div></div>';
						$parts[] = '<div></div>';
					case 3:
						$parts[] = '<div></div>';
					case 5:
						$parts[] = '<div></div>';
				}
				$parts[] = "</div>";
			}

			$parts[] = "</div>";
			$output  = implode( "\n", $parts );
		}

		$this->board_html = $output;
	}

	protected function _get_board_parts() {
		$return     = false;
		$width      = absint( get_post_meta( $this->board_id, 'tml_board_width', true ) );
		$height     = absint( get_post_meta( $this->board_id, 'tml_board_height', true ) );
		$board_data = get_post_meta( $this->board_id, 'tml_board', true );

		if ( 2 < $width && 1 < $height && ! empty( $board_data ) ) {
			$board_data = explode( ',', $board_data );
			if ( count( $board_data ) == ( $width * $height ) ) {
				$return = array(
					$width,
					$height,
					$board_data,
				);
			} elseif ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				error_log( 'Board size ' . ($height * $width) . ' expected, got ' . count($board_data) );
			}
		}

		return $return;
	}

}