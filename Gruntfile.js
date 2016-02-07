module.exports = function (grunt) {
	var banner = '/*! <%= pkg.name %> v<%= pkg.version %> built <%= grunt.template.today("yyyy-mm-dd") %> */\n';

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		/** SASS */
		sass: {
			app: {
				options: {
					sourcemap: 'none',
					style: 'compressed'
				},
				files: {
					'www/assets/build/app.css': [
						'www/css/app/**/*.scss'
					]
				}
			}
		},

		/** TypeScript */
		ts: {
			app: {
				files: {
					'www/assets/build/app.js': 'www/js/**/*.ts'
				}
			}
		},

		/** CSS and JS libs */
		bower_concat: {
			options: {
				separator: ';\n'
			},
			app: {
				dest: 'www/assets/build/libs.js',
				cssDest: 'www/assets/build/libs.css',
				mainFiles: {
					/*bootstrap: [
						'dist/css/bootstrap.min.css',
						'dist/css/bootstrap-theme.min.css',
						'dist/css/bootstrap.min.js'
					],*/
					'jquery': [
						'dist/jquery.min.js'
					],
					'angular': [
						'angular.min.js'
					],
					'angular-animate': [
						'angular-animate.min.js'
					],
					'angular-ui-route': [
						'release/angular-ui-router.min.js'
					],
					'fastclick': [
						'lib/fastclick.js'
					],
					/*,
						'hammerjs': [
						'hammer.min.js'
					]*/
					'tether': [
						'tether.min.js',
						'css/tether.css',
						'css/tether-theme-basic.css',
						'css/tether-theme-arrows.css',
						'css/tether-theme-arrows-dark.css'
					],
					'viewport-units-buggyfill': [
						'viewport-units-buggyfill.js',
						'viewport-units-buggyfill.hacks.js'
					],
					'foundation-apps': [
						'dist/css/foundation-apps.min.css',
						'dist/js/foundation-apps.min.js',
						'dist/js/foundation-apps-templates.min.js'
					]
				}
			}
		},

		/** Concat CSS files */
		concat: {
			options: {
				banner: banner,
				stripBanners: true
			},
			app: {
				src: [
					'www/assets/build/libs.css',
					'www/assets/build/app.css'
				],
				dest: 'www/assets/app.css'
			}
		},

		/** Minification */
		uglify: {
			options: {
				banner: banner
			},
			app: {
				src: [
					'www/assets/build/libs.js',
					'www/assets/build/app.js'
				],
				dest: 'www/assets/app.js'
			}
		}
	});

	grunt.loadNpmTasks('grunt-bower-concat');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-ts');


	grunt.registerTask('build:css', ['bower_concat:app', 'sass:app', 'concat:app']);
	grunt.registerTask('build:js', ['bower_concat:app', 'ts:app', 'uglify:app']);

	grunt.registerTask('build', ['bower_concat:app', 'sass:app', 'concat:app', 'ts:app', 'uglify:app']);
};
