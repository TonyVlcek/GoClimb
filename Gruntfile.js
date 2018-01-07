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
			'!temp/build/.gitkeep',
			'temp/build/*'
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
				src: 'temp/build/*.css'
			}
		},
		json: grunt.file.readJSON('app/config/build/json.json')
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
	grunt.loadNpmTasks('grunt-json');

	/** SASS */
	grunt.registerTask('sass:all', ['sass:public', 'sass:admin', 'sass:app', 'sass:auth', 'sass:backend', 'sass:frontend', "postcss"]);
	grunt.registerTask('sass:all-dev', ['sass:public-dev', 'sass:admin-dev', 'sass:app-dev', 'sass:auth-dev', 'sass:backend-dev', 'sass:frontend-dev', "postcss"]);

	/** TS */
	grunt.registerTask('ts:admin-dev', ['ts:admin']);
	grunt.registerTask('ts:app-dev', ['ts:app']);
	grunt.registerTask('ts:auth-dev', ['ts:auth']);
	grunt.registerTask('ts:backend-dev', ['ts:backend']);
	grunt.registerTask('ts:frontend-dev', ['ts:frontend']);
	grunt.registerTask('ts:public-dev', ['ts:public']);

	grunt.registerTask('ts:all', ['ts:public', 'ts:admin', 'ts:app', 'ts:auth', 'ts:backend', 'ts:frontend']);
	grunt.registerTask('ts:all-dev', ['ts:public-dev', 'ts:admin-dev', 'ts:app-dev', 'ts:auth-dev', 'ts:backend-dev', 'ts:frontend-dev']);

	/** ANGULAR TEMPLATES */
	grunt.registerTask('ngtemplates:all', ['ngtemplates:admin', 'ngtemplates:app', 'ngtemplates:auth', 'ngtemplates:backend', 'ngtemplates:frontend']);
	grunt.registerTask('ngtemplates:all-dev', ['ngtemplates:admin-dev', 'ngtemplates:app-dev', 'ngtemplates:auth-dev', 'ngtemplates:backend-dev', 'ngtemplates:frontend-dev']);

	/** ONE FILE */
	grunt.registerTask('concat:all', ['concat:admin', 'concat:app', 'concat:auth', 'concat:backend', 'concat:frontend']);
	grunt.registerTask('concat:all-dev', ['concat:admin-dev', 'concat:app-dev', 'concat:auth-dev', 'concat:backend-dev', 'concat:frontend-dev']);

	grunt.registerTask('uglify:all', ['uglify:admin', 'uglify:app', 'uglify:auth', 'uglify:backend', 'uglify:frontend']);
	grunt.registerTask('uglify:all-dev', ['uglify:admin-dev', 'uglify:app-dev', 'uglify:auth-dev', 'uglify:backend-dev', 'uglify:frontend-dev']);

	/** SHORTCUTS  */
	grunt.registerTask('json:all', ['json:admin', 'json:app', 'json:frontend']);

	grunt.registerTask('build:admin', ['typings', 'sass:admin', 'ts:admin', 'postcss', 'concat:admin', 'json:admin', 'ngtemplates:admin', 'uglify:admin', 'clean']);
	grunt.registerTask('build:admin-dev', ['typings', 'sass:admin-dev', 'ts:admin-dev', 'postcss','concat:admin-dev', 'json:admin', 'ngtemplates:admin-dev', 'uglify:admin-dev', 'clean']);

	grunt.registerTask('build:app', ['typings', 'sass:app', 'ts:app', 'postcss', 'concat:app', 'json:app', 'ngtemplates:app', 'uglify:app', 'clean']);
	grunt.registerTask('build:app-dev', ['typings', 'sass:app-dev', 'ts:app-dev', 'postcss','concat:app-dev', 'json:app', 'ngtemplates:app-dev', 'uglify:app-dev', 'clean']);

	grunt.registerTask('build:auth', ['typings', 'sass:auth', 'ts:auth', 'postcss', 'concat:auth', 'ngtemplates:auth', 'uglify:auth', 'clean']);
	grunt.registerTask('build:auth-dev', ['typings', 'sass:auth-dev', 'postcss', 'ts:auth-dev', 'concat:auth-dev', 'ngtemplates:auth-dev', 'uglify:auth-dev', 'clean']);

	grunt.registerTask('build:backend', ['typings', 'sass:backend', 'ts:backend', 'postcss', 'concat:backend', 'ngtemplates:backend', 'uglify:backend', 'clean']);
	grunt.registerTask('build:backend-dev', ['typings', 'sass:backend-dev', 'ts:backend-dev', 'postcss', 'concat:backend-dev', 'ngtemplates:backend-dev', 'uglify:backend-dev', 'clean']);

	grunt.registerTask('build:frontend', ['typings', 'sass:frontend', 'ts:frontend', 'postcss', 'concat:frontend', 'json:frontend', 'ngtemplates:frontend', 'uglify:frontend', 'clean']);
	grunt.registerTask('build:frontend-dev', ['typings', 'sass:frontend-dev', 'ts:frontend-dev', 'postcss', 'concat:frontend-dev', 'json:frontend', 'ngtemplates:frontend-dev', 'uglify:frontend-dev', 'clean']);

	grunt.registerTask('build:public-dev', ['sass:public-dev', 'ts:public-dev', 'postcss', 'concat:public-dev', 'uglify:public-dev', 'clean']);
    grunt.registerTask('build:public', ['typings', 'sass:public', 'ts:public', 'postcss', 'concat:public', 'uglify:public', 'clean']);

	grunt.registerTask('build:all', ['typings', 'sass:all', 'ts:all', 'concat:all', 'json:all', 'ngtemplates:all', 'uglify:all', 'copy:all', 'clean']);
	grunt.registerTask('build:all-dev', [ 'sass:all-dev', 'ts:all-dev', 'concat:all-dev', 'json:all', 'ngtemplates:all-dev', 'uglify:all-dev', 'copy:all', 'clean']);

	grunt.registerTask('default', ['build:all-dev']);

};
