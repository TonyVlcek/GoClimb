/**
 * @author Martin Mikšík
 */

namespace GoClimb
{
	var goClimb = angular.module('GoClimb', [
		'ui.router',
		'ngAnimate',

		//foundation
		'foundation',
		'foundation.dynamicRouting',
		'foundation.dynamicRouting.animations'
	]);

	goClimb.config(config);
	goClimb.run(run);

	config.$inject = ['$urlRouterProvider', '$locationProvider'];


	function config($urlProvider, $locationProvider) {
		$urlProvider.otherwise('/');

		$locationProvider.html5Mode({
			enabled: false,
			requireBase: false
		});

		$locationProvider.hashPrefix('!');
	}

	function run() {
		FastClick.attach(document.body);
	}
}
