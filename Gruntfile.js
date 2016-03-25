module.exports = function (grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		sass: grunt.file.readJSON('app/config/build/sass.json'),
		ts: grunt.file.readJSON('app/config/build/ts.json'),
		concat: grunt.file.readJSON('app/config/build/concat.json'),
		uglify: grunt.file.readJSON('app/config/build/uglify.json'),
		ngtemplates: grunt.file.readJSON('app/config/build/ngtemplates.json'),
		copy: grunt.file.readJSON('app/config/build/copy.json'),
		clean: [
			'!www/assets/build/.gitkeep',
			'www/assets/build/*'
		],
		typings: {
			default: {
			}
		},
		postcss: {
			options: {
				map: true,
				processors: [
					require('pixrem')(),
					require('autoprefixer')({browsers: 'last 2 versions'})
				]
			},
			dist: {
				src: 'www/assets/build/*.css'
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-ts');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-angular-templates');
	grunt.loadNpmTasks('grunt-typings');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-postcss');

	/** Copy */
	grunt.registerTask('copy:app', ['copy:admin']);

	/** SASS */
	grunt.registerTask('sass:app', ['sass:admin', 'sass:auth', 'sass:backend', 'sass:frontend', "postcss"]);
	grunt.registerTask('sass:app-dev', ['sass:admin-dev', 'sass:auth-dev', 'sass:backend-dev', 'sass:frontend-dev', "postcss"]);

	/** TS */
	grunt.registerTask('ts:admin-dev', ['ts:admin']);
	grunt.registerTask('ts:auth-dev', ['ts:auth']);
	grunt.registerTask('ts:backend-dev', ['ts:backend']);
	grunt.registerTask('ts:frontend-dev', ['ts:frontend']);

	grunt.registerTask('ts:app', ['ts:admin', 'ts:auth', 'ts:backend', 'ts:frontend']);
	grunt.registerTask('ts:app-dev', ['ts:admin-dev', 'ts:auth-dev', 'ts:backend-dev', 'ts:frontend-dev']);

	/** ANGULAR TEMPLATES */
	grunt.registerTask('ngtemplates:app', ['ngtemplates:admin', 'ngtemplates:auth', 'ngtemplates:backend', 'ngtemplates:frontend']);
	grunt.registerTask('ngtemplates:app-dev', ['ngtemplates:admin-dev', 'ngtemplates:auth-dev', 'ngtemplates:backend-dev', 'ngtemplates:frontend-dev']);

	/** ONE FILE */
	grunt.registerTask('concat:app', ['concat:admin', 'concat:auth', 'concat:backend', 'concat:frontend']);
	grunt.registerTask('concat:app-dev', ['concat:admin-dev', 'concat:auth-dev', 'concat:backend-dev', 'concat:frontend-dev']);

	grunt.registerTask('uglify:app', ['uglify:admin', 'uglify:auth', 'uglify:backend', 'uglify:frontend']);
	grunt.registerTask('uglify:app-dev', ['uglify:admin-dev', 'uglify:auth-dev', 'uglify:backend-dev', 'uglify:frontend-dev']);

	/** SHORTCUTS  */
	grunt.registerTask('build:admin', ['typings', 'sass:admin', 'ts:admin', 'postcss', 'concat:admin', 'uglify:admin', 'ngtemplates:admin', 'copy:admin', 'clean']);
	grunt.registerTask('build:admin-dev', ['typings', 'sass:admin-dev', 'ts:admin-dev', 'postcss','concat:admin-dev', 'uglify:admin-dev', 'ngtemplates:admin-dev', 'copy:admin', 'clean']);

	grunt.registerTask('build:auth', ['typings', 'sass:auth', 'ts:auth', 'postcss', 'concat:auth', 'uglify:auth', 'ngtemplates:auth', 'clean']);
	grunt.registerTask('build:auth-dev', ['typings', 'sass:auth-dev', 'postcss', 'ts:auth-dev', 'concat:auth-dev', 'uglify:auth-dev', 'ngtemplates:auth-dev', 'clean']);

	grunt.registerTask('build:backend', ['typings', 'sass:backend', 'ts:backend', 'postcss', 'concat:backend', 'uglify:backend', 'ngtemplates:backend', 'clean']);
	grunt.registerTask('build:backend-dev', ['typings', 'sass:backend-dev', 'ts:backend-dev', 'postcss', 'concat:backend-dev', 'uglify:backend-dev', 'ngtemplates:backend-dev', 'clean']);

	grunt.registerTask('build:frontend', ['typings', 'sass:frontend', 'ts:frontend', 'postcss', 'concat:frontend', 'uglify:frontend', 'ngtemplates:frontend','copy:admin', 'clean']);
	grunt.registerTask('build:frontend-dev', ['typings', 'sass:frontend-dev', 'ts:frontend-dev', 'postcss', 'concat:frontend-dev', 'uglify:frontend-dev', 'ngtemplates:frontend-dev', 'clean']);

	grunt.registerTask('build:app', ['typings', 'sass:app', 'ts:app', 'concat:app', 'uglify:app', 'ngtemplates:app', 'copy:app', 'clean']);
	grunt.registerTask('build:app-dev', ['typings', 'sass:app-dev', 'ts:app-dev', 'concat:app-dev', 'uglify:app-dev', 'ngtemplates:app-dev', 'copy:app', 'clean']);

	grunt.registerTask('default', ['build:app-dev']);

};
