namespace GoClimb.Admin.Services
{

	import BaseService = GoClimb.Core.Services.BaseService;
	import ITimeoutService = angular.ITimeoutService;
	import IPromise = angular.IPromise;
	import IApi = Foundation.IApi;

	export class FlashMessageSender extends BaseService
	{

		private api: IApi;

		public constructor(api: IApi)
		{
			super();
			this.api = api;
		}


		public sendInfo(message: string, title: string = '', duration: number = 5)
		{
			this.sendFlash(message, FlashMessageType.INFO, title, duration);
		}


		public sendSuccess(message: string, title: string = '', duration: number = 5)
		{
			this.sendFlash(message, FlashMessageType.SUCCESS, title, duration);
		}


		public sendError(message: string, title: string = '', duration: number = 5)
		{
			this.sendFlash(message, FlashMessageType.ERROR, title, duration);
		}


		public sendFlash(message: string, type: FlashMessageType, title: string = '', duration: number = 5)
		{
			var flash = {
				title: title,
				content: message,
				color: FlashMessageSender.getColor(type),
				autoclose: duration * 1000,
			};
			this.api.publish('flashMessages', flash);
		}


		private static getColor(type: FlashMessageType): string
		{
			switch (type) {
				case FlashMessageType.ERROR:
					return 'alert';
				case FlashMessageType.SUCCESS:
					return 'success';
				case FlashMessageType.INFO:
					return 'default';
			}
		}

	}

	FlashMessageSender.register(angular, 'flashMessageSender', ['FoundationApi']);

}
