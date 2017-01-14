namespace GoClimb
{

	import IAnimateService = angular.animate.IAnimateService;
	import IRootScopeService = angular.IRootScopeService;

	angular.module('GoClimb').config(['$urlRouterProvider', ($urlRouterProvider) => {
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
