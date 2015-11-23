jQuery(document).ready(function ($) {
    var timeout;
    var grid = $('.grid');
    var rows = grid.attr('data-rows');
    var cols = grid.attr('data-cols');

    if (grid.length) {
        $.each(grid, function () {
            var tiles = $(this).find('.tile');
            tiles.on('click', function (e) {
                e.preventDefault();
                var elem = $(this);
                if (!elem.hasClass('tile-0')) {
                    clearTimeout(timeout);
                    var rot = undefined !== elem.attr('data-rot') ? elem.attr('data-rot') : 0;
                    rot++;
                    var angle = rot * 90;
                    elem.css('transform', 'rotate(' + angle + 'deg)').attr('data-rot', rot).addClass('changing');
                    timeout = setTimeout(function () {
                        elem.removeClass('changing');
                        isConnected( tiles, $(this) );
                    }, 250);
                }
            });
        });
    }

    function isConnected( tiles, grid ) {
        var connected = true;
        $.each(tiles, function (index) {
            var elem = $(this);
            var cont = true;
            if (!elem.hasClass('tile-0')) {
                var row = Math.floor(index / cols);
                var col = index % cols;
                var type = getType(elem);
                var rot = elem.attr('data-rot') ? elem.attr('data-rot') : 0;
                var direction = rot % 4;
                var sides = getConnectedSides(type, direction);
                if (0 < sides.length) {
                    for (var i = 0; i < sides.length; i++) {
                        var loc = -1;
                        switch (sides[i]) {
                            case 'u':
                                if (0 < row) {
                                    loc = ((row - 1) * cols) + col;
                                }
                                break;
                            case 'd':
                                if (rows > (row + 1)) {
                                    loc = ((row + 1) * cols) + col;
                                }
                                break;
                            case 'l':
                                if (0 < col) {
                                    loc = (row * cols) + col - 1;
                                }
                                break;
                            case 'r':
                                if (cols > (col + 1)) {
                                    loc = (row * cols) + col + 1;
                                }
                                break;
                        }
                        if (0 <= loc) {
                            var newElem = tiles.eq(loc);
                            var tType = getType(newElem);
                            var trot = newElem.attr('data-rot') ? newElem.attr('data-rot') : 0;
                            var tDir = trot % 4;
                            if (0 == tType) {
                                cont = false;
                            } else if (4 > tType && 0 < tType) {
                                var tSides = getConnectedSides(tType, tDir);
                                var tSide = getInverse(sides[i]);
                                if (0 > $.inArray(tSide, tSides)) {
                                    cont = false;
                                }
                            }
                        } else {
                            cont = false;
                        }
                    }
                } else {
                    cont = false;
                }
            }
            if (cont) {
                elem.addClass('connected');
            } else {
                elem.removeClass('connected');
            }
            if (!cont) {
                connected = false;
                //return false;
            }
        });
        if (connected) {
            grid.addClass('connected');
            tiles.off('click');
            // TODO: Add additional victory actions here!
        } else {
            grid.removeClass('connected');
        }
    }

    function getInverse(side) {
        switch (side) {
            case 'u':
                return 'd';
            case 'd':
                return 'u';
            case 'r':
                return 'l';
            case 'l':
                return 'r';
        }
    }

    function getType(elem) {
        var type = 0; // Empty tile
        if (elem.hasClass('tile-1')) {
            type = 1; // Line tile
        } else if (elem.hasClass('tile-2')) {
            type = 2; // Curve tile
        } else if (elem.hasClass('tile-3')) {
            type = 3; // Tri-curve tile
        } else if (elem.hasClass('tile-4')) {
            type = 4; // Star-curve tile
        } else if (elem.hasClass('tile-5')) {
            type = 5; // End tile
        }
        return type;
    }

    function getConnectedSides(type, dir) {
        var sides = [];
        switch (type) {
            case 1: // Line
                switch (dir) {
                    case 0:
                    case 2:
                        sides = ['u', 'd'];
                        break;
                    case 1:
                    case 3:
                        sides = ['l', 'r'];
                        break;
                }
                break;
            case 2: // Curve
                switch (dir) {
                    case 0:
                        sides = ['u', 'l'];
                        break;
                    case 1:
                        sides = ['u', 'r'];
                        break;
                    case 2:
                        sides = ['d', 'r'];
                        break;
                    case 3:
                        sides = ['d', 'l'];
                        break;
                }
                break;
            case 3: // Triple
                switch (dir) {
                    case 0:
                        sides = ['u', 'r', 'l'];
                        break;
                    case 1:
                        sides = ['u', 'r', 'd'];
                        break;
                    case 2:
                        sides = ['d', 'r', 'l'];
                        break;
                    case 3:
                        sides = ['d', 'l', 'u'];
                        break;
                }
                break;
            case 4: // Star
                sides = ['u', 'd', 'l', 'r'];
                break;
            case 5: // End
                switch (dir) {
                    case 0:
                        sides = ['u'];
                        break;
                    case 1:
                        sides = ['r'];
                        break;
                    case 2:
                        sides = ['d'];
                        break;
                    case 3:
                        sides = ['l'];
                        break;
                }
                break;
        }
        return sides;
    }
});