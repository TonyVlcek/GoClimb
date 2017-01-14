namespace GoClimb
{

	import IAnimateService = angular.animate.IAnimateService;

	var goClimb = angular.module('GoClimb');

	goClimb.config(['$urlRouterProvider', function ($urlRouterProvider) {
		$urlRouterProvider.when('', '/');
		$urlRouterProvider.otherwise(function ($injector, $location) {
			$injector.get('$state').go('404');
			return $location.path();
		});
	}]);

	//Setup and start tracking
	goClimb.config(['AnalyticsProvider', 'analyticsCode', (analyticsProvider, analyticsCode) => {
		if (analyticsCode) {
			analyticsProvider.setAccount(analyticsCode);
		} else {
			analyticsProvider.setAccount(null);
			analyticsProvider.disableAnalytics(true);
		}
	}]);

	goClimb.run(['Analytics', (Analytics) => {}]);
}
