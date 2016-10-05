namespace GoClimb.Core.Directives
{

	import LanguageService = GoClimb.Core.Services.LanguageService;

	export class TopPanelDirective extends BaseDirective
	{

		public templateUrl: string = 'app/client/Core/ts/Directives/TopPanel/TopPanelDirective.html';
		public link: Function = null;


		public constructor(languageService: LanguageService, user, links)
		{
			super();
			this.link = function ($scope) {
				$scope.availableLanguages = languageService.getAvailableLanguages();
				$scope.changeLanguage = function (newLang) {
					languageService.changeLanguage(newLang);
				};
				$scope.user = user;
				$scope.links = links;
			};
		}

	}

	TopPanelDirective.register(angular, 'topPanel', ['languageService', 'user', 'links']);

}
