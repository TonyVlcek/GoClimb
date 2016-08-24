declare module Foundation
{

	import IPromise = angular.IPromise;
	import IAugmentedJQuery = angular.IAugmentedJQuery;

	export interface IApi
	{

		subscribe(event: string, callback: Function): void;
		unsubscribe(event: string): void;

		publish(event: string, message: any): void;

		getSettings(): Object;
		modifySettings(settings: Object): Object;

		generateUuid(): string;

		toggleAnimate(element: IAugmentedJQuery, futureState: boolean): void;
		closeActiveElements(options: Object): void;
		animate(element: IAugmentedJQuery, futureState: boolean, animateIn: string, animateOut: string): IPromise<void>;
		animateAndAdvise(element: IAugmentedJQuery, futureState: boolean, animateIn: string, animateOut: string): IPromise<void>;


	}

}
