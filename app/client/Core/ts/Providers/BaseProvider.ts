namespace GoClimb.Core.Providers
{

	import IAngularStatic = angular.IAngularStatic;

	export abstract class BaseProvider
	{

		public abstract $get();


		public static register(angular: IAngularStatic, name: string, dependencies: any[] = [])
		{
			var proto = this.prototype;
			dependencies.push(function () {
				var instance = Object.create(proto);
				instance.constructor.apply(instance, arguments);
				return instance;
			});
			angular.module('GoClimb').provider(name, dependencies);
		}

	}

}
