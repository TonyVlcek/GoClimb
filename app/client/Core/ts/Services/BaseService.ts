namespace GoClimb.Core.Services
{

	import IAngularStatic = angular.IAngularStatic;

	export abstract class BaseService
	{

		public static register(angular: IAngularStatic, name: string, dependencies: any[] = [])
		{
			var proto = this.prototype;
			dependencies.push(function () {
				var instance = Object.create(proto);
				instance.constructor.apply(instance, arguments);
				return instance;
			});
			angular.module('GoClimb').factory(name, dependencies);
		}

	}

}
