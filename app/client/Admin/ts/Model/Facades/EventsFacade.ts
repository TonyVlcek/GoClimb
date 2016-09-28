namespace GoClimb.Admin.Model.Facades
{

	import HttpService = GoClimb.Admin.Model.Http.HttpService;
	import Utils = GoClimb.Core.Utils.Utils;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import IEvent = GoClimb.Admin.Model.Entities.IEvent;

	export class EventsFacade extends BaseFacade
	{

		private events: IndexedArray<IEvent> = null;

		private loading: boolean = false;


		public getEvents(callback: (events: IndexedArray<IEvent>) => void = null, errorCallback: Function = null)
		{
			if (this.events === null && this.loading === false) {
				this.loading = true;
				this.httpService.requestGet('events/', (data) => {
					for (var id in data.events) {
						data.events[id] = EventsFacade.mapEvent(data.events[id]);
					}
					this.events = new IndexedArray<IEvent>(data.events);
					this.loading = false;
					if (callback) {
						callback(this.events);
					}
				}, {}, errorCallback);
			} else if (this.events) {
				callback(this.events);
			}
		}


		public getEvent(id: string, callback: (event: IEvent) => void = null, errorCallback: Function = null)
		{
			this.getEvents((events) => {
				callback(events.getIndex(id));
			}, errorCallback);
		}


		public createEvent(event: IEvent, publish: boolean, callback: (event: IEvent) => void = null, errorCallback: Function = null): EventsFacade
		{
			event = angular.copy(event);
			event.published = publish;
			event = EventsFacade.eventToJson(event);
			this.httpService.requestPost('events/', {event: event}, (data) => {
				this.events.setIndex(data.event.id.toString(), EventsFacade.mapEvent(data.event));
				if (callback) {
					callback(this.events.getIndex(data.event.id.toString()));
				}
			}, errorCallback);
			return this;
		}


		public updateEvent(event: IEvent, publish: boolean, callback: (event: IEvent) => void = null, errorCallback: Function = null): EventsFacade
		{
			event = angular.copy(event);
			event.published = publish;
			event = EventsFacade.eventToJson(event);
			this.httpService.requestPost('events/' + event.id, {event: event}, (data) => {
				this.events.setIndex(data.event.id.toString(), EventsFacade.mapEvent(data.event));
				if (callback) {
					callback(this.events.getIndex(data.event.id.toString()));
				}
			}, errorCallback);
			return this;
		}


		public deleteEvent(event: IEvent, callback: () => void = null, errorCallback: Function = null): EventsFacade
		{
			event = angular.copy(event);
			this.httpService.requestDelete('events/' + event.id, {}, () => {
				this.events.removeIndex(event.id.toString());
				if (callback) {
					callback();
				}
			}, errorCallback);
			return this;
		}


		private static mapEvent(event: IEvent): IEvent
		{
			if (event.published) {
				event.publishedDate = Utils.stringToDate(event.publishedDate);
			}

			if (event.endDate !== null) {
				event.endDate = Utils.stringToDate(event.endDate);
			}

			event.startDate = Utils.stringToDate(event.startDate);
			return event;
		}


		private static eventToJson(event: IEvent): IEvent
		{
			if (event.published && event.publishedDate) {
				event.publishedDate = Utils.dateToString(event.publishedDate);
			}

			if (event.endDate !== null) {
				event.endDate = Utils.dateToString(event.endDate);
			}

			event.startDate = Utils.dateToString(event.startDate);
			return event;
		}
	}

	EventsFacade.register(angular, 'eventsFacade', ['httpService']);

}
