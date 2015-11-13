module.exports = function(grunt) {
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
					'www/assets/app.css': [
						'www/css/app/**/*.scss'
					]
				}
			}
		},

		/** TypeScript */
		ts: {
			app : {
				files: {
					'www/assets/build/app.js': 'www/js/**/*.ts'
				}
			}
		},

		/** Minification */
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> v<% pkg.version %> built <%= grunt.template.today("yyyy-mm-dd") %> */\n'
			},
			app: {
				src: [
					'www/assets/build/app.js'
				],
				dest: 'www/assets/app.js'
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-ts');


	grunt.registerTask('build:css', ['sass:app']);
	grunt.registerTask('build:js', ['ts:app', 'uglify:app']);

	grunt.registerTask('build', ['build:css', 'build:js']);
};
