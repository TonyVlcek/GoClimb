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
		private restToken: string;
		private $http: IHttpService;
		private flashMessageSender: FlashMessageSender;

		public constructor(apiUrl: string, restToken: string, $http: IHttpService, flashMessageSender: FlashMessageSender)
		{
			super();
			this.apiUrl = apiUrl;
			this.restToken = restToken;
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
			var that = this;
			var originalErrorCallback = function (result) {
				that.resolveError(result);
			};
			var newErrorCallback = errorCallback ? function (result) {
				errorCallback(result, function () {
					originalErrorCallback(result);
				});
			} : originalErrorCallback;

			var divider = request.indexOf('?') === -1 ? '?' : '&';
			var token = that.restToken ? divider + 'token=' + that.restToken : '';

			that.$http({
				method: method,
				url: this.apiUrl + request + token,
				data: params
			}).then(function (result: any) {
				successCallback(result.data.data);
			}, newErrorCallback);
		}


		private resolveError(result)
		{
			var code = result.data.status.code;
			switch (code) {
				case 500:
				case 600:
				case 601:
				case 602:
					this.flashMessageSender.sendError('flashes.http.error' + code.toString());
					break;
			}
		}

	}

	HttpService.register(angular, 'httpService', ['apiUrl', 'restToken', '$http', 'flashMessageSender']);

}
