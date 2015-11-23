<?php
/**
 * Use a custom post type AND a custom DB table
 *
 * CUSTOM TABLE
 * ID POST_ID(game) USER_ID(player) DATE_ADDED TIME(taken) USER_RATING(?) NUMBER_OF_MOVES
 *
 * POST META
 * board = comma separated string of board data
 * board_width = int, tile width of the board
 * board_height = int, tile height of the board
 * board_author = user ID of author, if not present, then is "premium/featured/professional" board
 * board_rating = float storing average board rating (calculated from custom table, maybe do via cron?)
 *
 * BOARD DATA
 * 0 = empty
 * 1 = line
 * 2 = curve
 * 3 = tri-curve
 * 4 = star-curve
 * 5 = end
 */

// 6x6, #487
$board_1 = '5,1,3,3,1,5,2,2,5,5,2,2,2,3,5,5,3,2,0,3,1,1,3,0,5,2,5,5,2,5,0,5,3,3,5,0';

// 9x9, #481
$board_2 = '5,5,5,5,0,5,5,5,5,2,4,3,5,0,5,3,4,2,0,5,5,0,5,0,5,5,0,0,5,2,5,4,5,2,5,0,2,2,5,5,1,5,5,2,2,3,4,2,5,1,5,2,4,3,2,2,2,5,5,5,2,2,2,2,2,0,5,1,5,0,2,2,2,2,5,1,1,1,5,2,2';

// 7x5, #436
$board_3 = '0,0,5,3,5,0,0,2,1,3,3,3,1,2,1,5,4,1,4,5,1,2,1,3,3,3,1,2,0,0,5,3,5,0,0';

// 3x3, from website
$board_4 = '2,3,2,3,4,3,2,3,2';

// 3x2, infinity symbol
$board_5 = '2,3,2,2,3,2';