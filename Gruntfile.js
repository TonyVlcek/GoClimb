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
					bootstrap: [
						'dist/css/bootstrap.min.css',
						'dist/css/bootstrap-theme.min.css',
						'dist/css/bootstrap.min.js'
					],
					jquery: [
						'dist/jquery.min.js'
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
