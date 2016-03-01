namespace GoClimb.Admin.Directives
{

	var goClimb = angular.module('GoClimb');

	goClimb.directive('adminMenu', function () {
		return {
			restrict: 'A',
			templateUrl: 'app/client/Admin/ts/Directives/AdminMenu/AdminMenuDirective.html',
			replace: true,
		}
	});
}
