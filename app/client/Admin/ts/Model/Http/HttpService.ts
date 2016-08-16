namespace GoClimb.Admin.Model.Http
{

	import BaseService = GoClimb.Core.Services.BaseService;
	import IHttpService = angular.IHttpService;
	import IRequestShortcutConfig = angular.IRequestShortcutConfig;
	import IHttpPromiseCallbackArg = angular.IHttpPromiseCallbackArg;
	import FlashMessageSender = GoClimb.Admin.Services.FlashMessageSender;
	import IHttpPromiseCallback = angular.IHttpPromiseCallback;

	export class HttpService extends BaseService
	{

		private apiUrl: string;
		private $http: IHttpService;
		private flashMessageSender: FlashMessageSender;

		public constructor(apiUrl: string, $http: IHttpService, flashMessageSender: FlashMessageSender)
		{
			super();
			this.apiUrl = apiUrl;
			this.$http = $http;
			this.flashMessageSender = flashMessageSender;
		}


		public get(request: string, successCallback: Function, errorCallback: Function = null)
		{
			this.request(request, 'GET', {}, successCallback, errorCallback);
		}


		public post(request: string, params: {}, successCallback: Function, errorCallback: Function = null)
		{
			this.request(request, 'POST', params, successCallback, errorCallback);
		}


		private request(request: string, method: string, params: {}, successCallback: Function, errorCallback = null)
		{
			var originalErrorCallback = function (result) {
				this.resolveError(result);
			};
			errorCallback = errorCallback ? function (result) {
				errorCallback(result, function () {
					originalErrorCallback(result);
				});
			} : originalErrorCallback;

			this.$http({
				method: method,
				url: this.apiUrl + request,
				data: params
			}).then(function (result: any) {
				var data = result.data;
				if (data.status.code < 200 || data.status.code >= 300) {
					errorCallback(result);
				} else {
					successCallback(data.data);
				}
			}, errorCallback);
		}


		private resolveError(result)
		{
			if (result.status >= 500) {
				this.flashMessageSender.sendError('flashes.error.http.error500');
			}
		}

	}

	HttpService.register(angular, 'httpService', ['apiUrl', '$http', 'flashMessageSender']);

}
