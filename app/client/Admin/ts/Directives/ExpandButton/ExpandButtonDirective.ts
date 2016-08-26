namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;
	import IScope = angular.IScope;
	import IAugmentedJQuery = angular.IAugmentedJQuery;
	import IAttributes = angular.IAttributes;

	export class ExpandButtonDirective extends BaseDirective
	{

		public templateUrl: string = 'app/client/Admin/ts/Directives/ExpandButton/ExpandButtonDirective.html';

		public link = (scope, element: IAugmentedJQuery, attributes: IAttributes) =>
		{
			scope.$watch(() => {
				return !angular.element('body').hasClass('panel-is-compressed');
			}, (newValue) => {
				scope.expanded = newValue;
			}, true);


			scope.toggle = () => {
				angular.element('body').toggleClass('panel-is-compressed');
			};
		}
	}

	ExpandButtonDirective.register(angular, 'expandButton');

}
