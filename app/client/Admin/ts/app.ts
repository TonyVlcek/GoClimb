namespace GoClimb
{

	angular.module('GoClimb').config(['$urlRouterProvider', function ($urlRouterProvider) {
		$urlRouterProvider.when('', '/');

		$urlRouterProvider.otherwise(function ($injector, $location) {
			$injector.get('$state').go('404');
			return $location.path();
		});
	}]);

}
