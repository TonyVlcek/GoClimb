namespace GoClimb.Admin.Controllers
{
	var goClimb = angular.module('GoClimb');

	goClimb.controller("TestController", ['$scope', function($scope) {

		$scope.models = {
			selected: null,
			lists: {"Items": [], "Menu": []}
		};

		// Generate initial model
		for (var i = 1; i <= 6; ++i) {
			$scope.models.lists.Items.push({label: "Page " + i});
		}

		$scope.models.lists.Menu.push({label: "Home" });

		// Model to JSON for demo purpose
		$scope.$watch('models', function(model) {
			$scope.modelAsJson = angular.toJson(model, true);
		}, true);

	}]);
}
