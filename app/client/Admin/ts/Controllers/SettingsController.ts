namespace GoClimb.Admin.Controllers
{

	import WallDetailsFacade = GoClimb.Core.Model.Facades.WallDetailsFacade;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;

	export class SettingsController extends BaseAdminController
	{

		private wallDetailsFacade: WallDetailsFacade;

		private details: {} = null;
		private flashMessageSender: FlashMessageSender;


		public constructor(wallDetailsFacade: WallDetailsFacade, flashMessageSender: FlashMessageSender)
		{
			super();
			this.wallDetailsFacade = wallDetailsFacade;
			this.flashMessageSender = flashMessageSender;
		}


		public getDetails(): {}
		{
			var that = this;
			if (that.details === null) {
				that.details = {};
				this.wallDetailsFacade.getDetails(function (data) {
					that.details = data.details;
				});
			}
			return that.details;
		}


		public updateDetails()
		{
			var that = this;
			that.wallDetailsFacade.updateDetails(this.details, function (data) {
				that.details = data.details;
				that.flashMessageSender.sendSuccess('flashes.settings.updated.success');
			});
		}


	}

	SettingsController.register(angular, 'SettingsController', ['wallDetailsFacade', 'flashMessageSender']);

}
