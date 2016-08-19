namespace GoClimb.Admin.Controllers
{

	import WallDetailsFacade = GoClimb.Admin.Model.Facades.WallDetailsFacade;
	import FlashMessageSender = GoClimb.Admin.Services.FlashMessageSender;

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
					console.log(data);
					that.details = data.details;
				});
			}
			return that.details;
		}


		public updateDetails()
		{
			var that = this;
			that.wallDetailsFacade.updateDetails(this.details, function () {
				that.flashMessageSender.sendSuccess('flashes.success.settings.updated');
			});
		}


	}

	SettingsController.register(angular, 'SettingsController', ['wallDetailsFacade', 'flashMessageSender']);

}