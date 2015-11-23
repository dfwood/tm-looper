<?php

$width = 6;
$height = 6;
$id = 487;

// 6x6, #487
$data = array(
	5, 1, 3, 3, 1, 5,
	2, 2, 5, 5, 2, 2,
	2, 3, 5, 5, 3, 2,
	0, 3, 1, 1, 3, 0,
	5, 2, 5, 5, 2, 5,
	0, 5, 3, 3, 5, 0,
);

// TODO: Add grid color classes!
$grid_classes = array( 'grid', "c{$width}", "r{$height}" );
$grid_classes = implode( ' ', $grid_classes ); //esc_attr( implode( ' ', $grid_classes ) );

echo "<div class='{$grid_classes}' data-cols='{$width}' data-rows='{$height}'>";

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
	$rotation = rand( 0, 3 );
	$class_list = array(
		'tile',
		"tile-{$value}",
		"rot-{$rotation}",
	);
	$class = implode( ' ', $class_list ); //esc_attr( implode( ' ', $class_list ) );

	echo "<div class='{$class}' data-rot='{$rotation}'>";
	switch ($value) {
		case 4:
			echo '<div></div>';
			echo '<div></div>';
		case 3:
			echo '<div></div>';
		case 5:
			echo '<div></div>';
	}
	echo "</div>";
}

echo "</div>";