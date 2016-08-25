namespace GoClimb.Core.Directives
{

	import IDirective = angular.IDirective;
	import IAngularStatic = angular.IAngularStatic;

	export abstract class BaseDirective implements IDirective
	{

		public restrict: string = 'A';


		public static register(angular: IAngularStatic, name: string, dependencies: any[] = [])
		{
			var proto = this.prototype;
			dependencies.push(function () {
				var instance = Object.create(proto);
				instance.constructor.apply(instance, arguments);
				return instance;
			});
			angular.module('GoClimb').directive(name, dependencies);
		}

	}

}
