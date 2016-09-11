namespace GoClimb.Admin.Controllers
{
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import IEvent = GoClimb.Admin.Model.Entities.IEvent;
	import FlashMessageSender = GoClimb.Admin.Services.FlashMessageSender;
	import ArticlesFacade = GoClimb.Admin.Model.Facades.ArticlesFacade;
	import DialogService = GoClimb.Admin.Services.DialogService;
	import EventsFacade = GoClimb.Admin.Model.Facades.EventsFacade;


	export class EventsController extends BaseAdminController
	{

		public processingDelete: number = null;

		private events: IndexedArray<IEvent> = null;
		private loading: boolean = false;

		private flashMessageSender: FlashMessageSender;
		private dialogService: DialogService;
		private eventsFacade: EventsFacade;


		public constructor(flashMessageSender: FlashMessageSender, dialogService: DialogService, eventsFacade: EventsFacade)
		{
			super();
			this.flashMessageSender = flashMessageSender;
			this.dialogService = dialogService;
			this.eventsFacade = eventsFacade;
		}


		public deleteEvent(event: IEvent)
		{
			if (!this.dialogService.confirm('flashes.events.delete')) {
				return;
			}

			this.processingDelete = event.id;
			this.eventsFacade.deleteEvent(event, () => {
				this.processingDelete = null;
				this.flashMessageSender.sendSuccess('flashes.events.deleted.success');
			});
		}


		public getEvents(): IndexedArray<IEvent>
		{
			if (!this.loading && !this.events) {
				this.loading = true;
				this.eventsFacade.getEvents((events) => {
					this.loading = false;
					this.events = events;
				});
			}
			return this.events;
		}

	}

	EventsController.register(angular, 'EventsController', ['flashMessageSender', 'dialogService', 'eventsFacade']);

}
