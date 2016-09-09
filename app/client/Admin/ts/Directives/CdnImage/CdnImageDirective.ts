namespace GoClimb.Admin.Directives
{

	import BaseDirective = GoClimb.Core.Directives.BaseDirective;
	import IAugmentedJQuery = angular.IAugmentedJQuery;

	export class CdnImageDirective extends BaseDirective
	{

		private cdnUrl;


		public constructor(cdnUrl)
		{
			super();
			this.cdnUrl = cdnUrl;
		}


		public link = (scope, element, attrs) =>
		{
			element.attr('src', this.cdnUrl + attrs.cdnImage);
		}

	}

	CdnImageDirective.register(angular, 'cdnImage', ['cdnUrl']);

}
