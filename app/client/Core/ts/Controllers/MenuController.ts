namespace GoClimb.Core.Controllers
{

	import WallDetailsFacade = GoClimb.Core.Model.Facades.WallDetailsFacade;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import ITemplateCacheService = angular.ITemplateCacheService;

	export class MenuController extends BaseController
	{

		public menu;

		public constructor(menu, $templateCache: ITemplateCacheService)
		{
			super();
			this.menu = menu;
			$templateCache.put('ngDropdowns/templates/dropdownMenuItem.html', [
				'<li ng-class="{divider: dropdownMenuItem.divider, \'divider-label\': dropdownMenuItem.divider && dropdownMenuItem[dropdownItemLabel]}">',
				'<a href="" class="dropdown-item"',
				' ng-if="!dropdownMenuItem.divider"',
				' ng-href="{{dropdownMenuItem.href}}"',
				' ng-click="selectItem()"',
				' target="_self">',
				'{{dropdownMenuItem[dropdownItemLabel]}}',
				'</a>',
				'<span ng-if="dropdownMenuItem.divider">',
				'{{dropdownMenuItem[dropdownItemLabel]}}',
				'</span>',
				'</li>'
			].join(''));
		}


	}

	MenuController.register(angular, 'MenuController', ['menu', '$templateCache']);

}
