namespace GoClimb.Admin.Directives
{

	var goClimb = angular.module('GoClimb');

	goClimb.directive('adminMenuButton', function () {
		return {
			restrict: 'A',
			templateUrl: 'app/client/Admin/ts/Directives/AdminMenuButton/AdminMenuButtonDirective.html',
			replace: true,
		}
	});
}
