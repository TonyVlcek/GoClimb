namespace GoClimb.Core.Services
{

	import IWindowService = angular.IWindowService;
	import ILocationService = angular.ILocationService;


	export class LanguageService extends BaseService
	{

		protected $location: ILocationService;
		protected $window: IWindowService;
		protected availableLanguages: Object;


		public constructor($location, $window, availableLanguages)
		{
			super();
			this.$location = $location;
			this.$window = $window;
			this.availableLanguages = availableLanguages;
		}


		public changeLanguage(newLang: string)
		{
			if (newLang in this.availableLanguages) {
				this.$window.location = this.availableLanguages[newLang].replace('/__PATH__', this.$location.path());
			}
		}


		public getAvailableLanguages()
		{
			return this.availableLanguages;
		}

	}

	LanguageService.register(angular, 'languageService', ['$location', '$window', 'availableLanguages']);

}
