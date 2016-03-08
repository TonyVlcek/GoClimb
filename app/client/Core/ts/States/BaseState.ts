namespace GoClimb.Core.States
{

	import IAngularStatic = angular.IAngularStatic;
	import IStateProvider = angular.ui.IStateProvider;

	export abstract class BaseState
	{

		public static register(angular: IAngularStatic, name: string) {
			var proto = this.prototype;
			angular.module('GoClimb').config(['$stateProvider', function ($stateProvider: IStateProvider) {
				var instance = Object.create(proto);
				instance.constructor.apply(instance, []);
				$stateProvider.state(name, instance);
			}]);
		}

	}

}
