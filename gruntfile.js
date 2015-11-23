module.exports = function (grunt) {
    // The following paths may be edited
    var js = {
        uglify: {
            //'dest': 'src'
            'assets/js/tm-looper.min.js': 'assets/js/tm-looper.js'
        },
        watch: ['assets/js/**/*.js']
    };
    var css = {
        dest: {
            dev: 'assets/css/tm-looper.css',
            min: 'assets/css/tm-looper.min.css'
        }
    };
    var scss = {
        main: 'assets/scss/main.scss',
        watch: ['assets/scss/**/*.scss']
    };

    /** STOP EDITING! **/
    var path = require('path');
    require('load-grunt-config')(grunt, {
        configPath: path.join(process.cwd(), '.grunt'),
        init: true,
        data: {
            js: js,
            css: css,
            scss: scss
        }
    });
};
