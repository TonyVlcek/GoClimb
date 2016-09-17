namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;
	import Authorizator = GoClimb.Admin.Services.Authorizator;
	import IAugmentedJQuery = angular.IAugmentedJQuery;
	import IScope = angular.IScope;

	export class IfAllowedDirective extends BaseDirective
	{

		private authorizator: Authorizator;


		public constructor(authorizator: Authorizator)
		{
			super();
			this.authorizator = authorizator;
		}


		public link = (scope: IScope, element: IAugmentedJQuery, attrs) =>
		{
			scope.$watch(() => {
				return this.authorizator.isAllowed(attrs['ifAllowed']);
			}, function (newValue) {
				if (newValue) {
					element.removeClass('ng-hide');
				} else {
					element.addClass('ng-hide');
				}
			}, true);
		}

	}

	IfAllowedDirective.register(angular, 'ifAllowed', ['authorizator']);

}
