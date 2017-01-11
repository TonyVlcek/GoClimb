namespace GoClimb
{

	import IAnimateService = angular.animate.IAnimateService;

	angular.module('GoClimb').config(['$urlRouterProvider', function ($urlRouterProvider) {
		$urlRouterProvider.when('', '/');
		$urlRouterProvider.otherwise(function ($injector, $location) {
			$injector.get('$state').go('404');
			return $location.path();
		});
	}]);

	angular.module('GoClimb').run(['$transitions', 'FoundationApi', function ($transitions, foundationApi) {
		$transitions.onSuccess({to:'*'}, () => {
			foundationApi.publish('admin-menu', 'hide');
		});
	}]);
}
