namespace GoClimb.Core.Model.Facades
{

	import HttpService = GoClimb.Core.Model.Http.HttpService;
	import BaseFacade = GoClimb.Core.Model.Facades.BaseFacade;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import Utils = GoClimb.Core.Utils.Utils;
	import ILog = GoClimb.Core.Model.Entities.ILog;
	import IRoute = GoClimb.Core.Model.Entities.IRoute;


	export class LogsFacade extends BaseFacade
	{

		private logs: IndexedArray<ILog> = null;

		private loading: boolean = false;


		public getLogs(callback: (logs: IndexedArray<ILog>) => void = null, errorCallback: Function = null)
		{
			if (this.logs === null && this.loading === false) {
				this.loading = true;
				this.httpService.requestGet('logs/', (data) => {
					for (var id in data.logs) {
						data.logs[id] = LogsFacade.mapLog(data.logs[id]);
					}
					this.logs = new IndexedArray<ILog>(data.logs);
					this.loading = false;
					if (callback) {
						callback(this.logs);
					}
				}, {}, errorCallback);
			} else if (this.logs) {
				callback(this.logs);
			}
		}

		public getLog(id: number, callback: (log: ILog) => void = null, errorCallback: Function = null) {
			this.getLogs((logs) => {
				callback(logs.getIndex(id.toString()));
			}, errorCallback);
		}

		public createLog(log: ILog, route: IRoute, callback: (log: ILog) => void = null)
		{
			log = angular.copy(log);
			log.route = route;
			log = LogsFacade.logToJson(log);
			this.httpService.requestPost('logs/', {log: log}, (data) => {
				var log = LogsFacade.mapLog(data.log);
				if (this.logs) {
					this.logs.setIndex(data.log.id.toString(), log);
				}
				if (callback) {
					callback(log);
				}
			});
		}

		public updateLog(log: ILog, callback: (log: ILog) => void = null, errorCallback: Function = null)
		{
			log = angular.copy(log);
			log.style = log.style.id as any;
			log = LogsFacade.logToJson(log);
			this.httpService.requestPost('logs/' + log.id, {log: log}, (data) => {
				this.logs.setIndex(data.log.id.toString(), LogsFacade.mapLog(data.log));
				if (callback) {
					callback(this.logs.getIndex(data.log.id.toString()));
				}
			}, errorCallback);
			return this;
		}

		private static mapLog(log: ILog): ILog
		{
			if (log.loggedDate) {
				log.loggedDate = Utils.stringToDate(log.loggedDate);
			}

			return log;
		}

		private static logToJson(log: ILog): ILog
		{
			if (log.loggedDate) {
				log.loggedDate = Utils.dateToString(log.loggedDate);
			}

			return log;
		}

	}

	LogsFacade.register(angular, 'logsFacade', ['httpService']);

}
