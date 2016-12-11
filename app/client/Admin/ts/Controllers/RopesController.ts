namespace GoClimb.Admin.Controllers
{
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import DialogService = GoClimb.Admin.Services.DialogService;
	import RopesFacade = GoClimb.Core.Model.Facades.RopesFacade;
	import IRope = GoClimb.Core.Model.Entities.IRope;
	import LabelsFacade = GoClimb.Core.Model.Facades.LabelsFacade;
	import IScope = angular.IScope;


	export class RopesController extends BaseAdminController
	{

		public processingDelete: number = null;
		public selectedRopes: [number] = null;
		public pdfUrl: string = null;

		private ropes: IndexedArray<IRope> = null;
		private loading: boolean = false;

		private flashMessageSender: FlashMessageSender;
		private dialogService: DialogService;
		private ropesFacade: RopesFacade;
		private labelsFacade: LabelsFacade;


		public constructor(flashMessageSender: FlashMessageSender, dialogService: DialogService, ropesFacade: RopesFacade, labelsFacade: LabelsFacade, $scope: IScope)
		{
			super();
			this.flashMessageSender = flashMessageSender;
			this.dialogService = dialogService;
			this.ropesFacade = ropesFacade;
			this.labelsFacade = labelsFacade;

			$scope.$watchCollection(() => {return this.selectedRopes}, (newVal: any, oldVal) =>{
				if (newVal && newVal.length) {
					this.pdfUrl = this.labelsFacade.generateLabels(this.selectedRopes);
				} else {
					this.pdfUrl = null;
				}
			});
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

	RopesController.register(angular, 'RopesController', ['flashMessageSender', 'dialogService', 'ropesFacade', 'labelsFacade', '$scope']);

}
