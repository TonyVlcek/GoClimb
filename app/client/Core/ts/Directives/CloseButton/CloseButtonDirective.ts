namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;
	import IScope = angular.IScope;
	import IAugmentedJQuery = angular.IAugmentedJQuery;
	import IAttributes = angular.IAttributes;

	export class CloseButtonDirective extends BaseDirective
	{

		public templateUrl: string = 'app/client/Core/ts/Directives/CloseButton/CloseButtonDirective.html';

	}

	CloseButtonDirective.register(angular, 'closeButton');

}
