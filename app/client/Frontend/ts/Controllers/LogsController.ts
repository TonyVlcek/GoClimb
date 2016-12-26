namespace GoClimb.Admin.Controllers
{

	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import BaseController = GoClimb.Core.Controllers.BaseController;
	import IRope = GoClimb.Core.Model.Entities.IRope;
	import RopesFacade = GoClimb.Core.Model.Facades.RopesFacade;
	import IBoulder = GoClimb.Core.Model.Entities.IBoulder;
	import BouldersFacade = GoClimb.Core.Model.Facades.BouldersFacade;

	export class LogsController extends BaseController
	{

		public user = null;
		public links = null;
		public wall = null;

		private ropesFacade: RopesFacade;
		private ropesLoading: boolean = false;
		private ropes: IndexedArray<IRope> = null;
		private bouldersFacade: GoClimb.Core.Model.Facades.BouldersFacade;
		private bouldersLoading: boolean = false;
		private boulders: IndexedArray<IBoulder> = null;

		public constructor(wall, user, authLinks, ropesFacade: RopesFacade, bouldersFacade: BouldersFacade)
		{
			super();
			this.user = user;
			this.links = authLinks;
			this.wall = wall;
			this.ropesFacade = ropesFacade;
			this.bouldersFacade = bouldersFacade;
		}

		public getRopes(): IndexedArray<IRope>
		{
			if (!this.ropesLoading && !this.ropes) {
				this.ropesLoading = true;
				this.ropesFacade.getRopes((ropes) => {
					this.ropesLoading = false;
					this.ropes = ropes;
				});
			}
			return this.ropes;
		}

		public getBoulders(): IndexedArray<IBoulder>
		{
			if (!this.bouldersLoading && !this.boulders) {
				this.bouldersLoading = true;
				this.bouldersFacade.getBoulders((boulders) => {
					this.bouldersLoading = false;
					this.boulders = boulders;
				});
			}
			return this.boulders;
		}

	}

	LogsController.register(angular, 'LogsController', ['wall', 'user', 'links', 'ropesFacade', 'bouldersFacade']);

}
