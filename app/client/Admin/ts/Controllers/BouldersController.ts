namespace GoClimb.Admin.Controllers
{
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import FlashMessageSender = GoClimb.Core.Services.FlashMessageSender;
	import DialogService = GoClimb.Admin.Services.DialogService;
	import BouldersFacade = GoClimb.Core.Model.Facades.BouldersFacade;
	import IBoulder = GoClimb.Core.Model.Entities.IBoulder;
	import LabelsFacade = GoClimb.Core.Model.Facades.LabelsFacade;
	import IScope = angular.IScope;


	export class BouldersController extends BaseAdminController
	{

		public processingDelete: number = null;
		public selectedBoulders: [number] = null;
		public pdfUrl: string = null;

		private boulders: IndexedArray<IBoulder> = null;
		private loading: boolean = false;

		private flashMessageSender: FlashMessageSender;
		private dialogService: DialogService;
		private bouldersFacade: BouldersFacade;
		private labelsFacade: LabelsFacade;


		public constructor(flashMessageSender: FlashMessageSender, dialogService: DialogService, bouldersFacade: BouldersFacade, labelsFacade: LabelsFacade, $scope: IScope)
		{
			super();
			this.flashMessageSender = flashMessageSender;
			this.dialogService = dialogService;
			this.bouldersFacade = bouldersFacade;
			this.labelsFacade = labelsFacade;

			$scope.$watchCollection(() => {return this.selectedBoulders}, (newVal: any, oldVal) =>{
				if (newVal && newVal.length) {
					this.pdfUrl = this.labelsFacade.generateLabels(this.selectedBoulders);
				} else {
					this.pdfUrl = null;
				}
			});
		}


		public getBoulders(): IndexedArray<IBoulder>
		{
			if (!this.loading && !this.boulders) {
				this.loading = true;
				this.bouldersFacade.getBoulders((boulders: IndexedArray<IBoulder>) => {
					this.loading = false;
					this.boulders = boulders;
				});
			}
			return this.boulders;
		}


		public deleteBoulder(boulder: IBoulder)
		{
			if (!this.dialogService.confirm('flashes.boulders.delete')) {
				return;
			}

			this.processingDelete = boulder.id;
			this.bouldersFacade.deleteBoulder(boulder, () => {
				this.processingDelete = null;
				this.flashMessageSender.sendSuccess('flashes.boulders.deleted.success');
			});
		}
	}

	BouldersController.register(angular, 'BouldersController', ['flashMessageSender', 'dialogService', 'bouldersFacade', 'labelsFacade', '$scope']);

}
