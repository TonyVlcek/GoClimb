namespace GoClimb
{

	import ITranslateProvider = angular.translate.ITranslateProvider;

	var goClimb = angular.module('GoClimb', [
		'ui.router',
		'ngAnimate',
		'ngDropdowns',
		'pascalprecht.translate',
		'smart-table',
		'foundation',
	]);

	goClimb.config(['$locationProvider', '$translateProvider', function ($locationProvider, $translateProvider: ITranslateProvider) {
		$locationProvider.html5Mode({
			enabled: true,
			requireBase: true
		});

		var result = [];
		for (var key in _translations) {
			if (_translations.hasOwnProperty(key)) {
				var parts = key.split('.');
				var name = parts[0];
				var lang = parts[1];
				if (!(lang in result)) {
					result[lang] = [];
				}
				result[lang][name] = _translations[key];
			}
		}

		for (var lang in result) {
			if (result.hasOwnProperty(lang)) {
				$translateProvider.translations(lang, result[lang]);
			}
		}
		$translateProvider.useSanitizeValueStrategy('escape');
	}]);

}
