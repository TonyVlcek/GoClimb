namespace GoClimb.Admin.Directives {

	var goClimb = angular.module('GoClimb');

	goClimb.directive('header', function () {
		return {
			restrict: 'A',
			templateUrl: 'app/client/Admin/ts/Directives/Divider/DividerDirective.html',
			replace: true,

			scope: {
				classes: '@classes',
				title: '@title',
				titleRight: '@titleRight'
			},
		}
	});
}
