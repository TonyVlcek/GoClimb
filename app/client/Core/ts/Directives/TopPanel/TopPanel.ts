namespace GoClimb.Core.Directives
{

	var goClimb = angular.module('GoClimb');

	goClimb.directive('topPanel', function () {
		return {
			restrict: 'A',
			templateUrl: 'app/client/Core/ts/Directives/TopPanel/TopPanel.html',
			replace: true,
		}
	});
}
