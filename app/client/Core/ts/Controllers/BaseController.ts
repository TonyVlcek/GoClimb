namespace GoClimb.Core.Controllers
{

	import IAngularStatic = angular.IAngularStatic;
	import LanguageService = GoClimb.Core.Services.LanguageService;

	export abstract class BaseController
	{

		public static register(angular: IAngularStatic, name: string, dependencies: any[] = [])
		{
			var proto = this.prototype;
			dependencies.push(function () {
				var instance = Object.create(proto);
				instance.constructor.apply(instance, arguments);
				return instance;
			});
			angular.module('GoClimb').controller(name, dependencies);
		}

	}

}
