namespace GoClimb.Admin.Controllers
{
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import DialogService = GoClimb.Admin.Services.DialogService;
	import RopesFacade = GoClimb.Core.Model.Facades.RopesFacade;
	import IRope = GoClimb.Core.Model.Entities.IRope;


	export class RopesController extends BaseAdminController
	{

		public processingDelete: number = null;

		private ropes: IndexedArray<IRope> = null;
		private loading: boolean = false;

		private flashMessageSender: FlashMessageSender;
		private dialogService: DialogService;
		private ropesFacade: RopesFacade;


		public constructor(flashMessageSender: FlashMessageSender, dialogService: DialogService, ropesFacade: RopesFacade)
		{
			super();
			this.flashMessageSender = flashMessageSender;
			this.dialogService = dialogService;
			this.ropesFacade = ropesFacade;
		}


		public getRopes(): IndexedArray<IRope>
		{
			if (!this.loading && !this.ropes) {
				this.loading = true;
				this.ropesFacade.getRopes((ropes: IndexedArray<IRope>) => {
					this.loading = false;
					this.ropes = ropes;
				});
			}
			return this.ropes;
		}


		public deleteRope(rope: IRope)
		{
			if (!this.dialogService.confirm('flashes.ropes.delete')) {
				return;
			}

			this.processingDelete = rope.id;
			this.ropesFacade.deleteRope(rope, () => {
				this.processingDelete = null;
				this.flashMessageSender.sendSuccess('flashes.ropes.deleted.success');
			});
		}

	}

	RopesController.register(angular, 'RopesController', ['flashMessageSender', 'dialogService', 'ropesFacade']);

}
