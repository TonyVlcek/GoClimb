namespace GoClimb.Admin.Controllers {

	import RolesFacade = GoClimb.Core.Model.Facades.RolesFacade;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import IRole = GoClimb.Core.Model.Entities.IRole;


	export class RolesController extends BaseAdminController
	{
		private roles: IndexedArray<IRole>;

		private loading: boolean = false;


		private rolesFacade: RolesFacade;


		public constructor (rolesFacade: RolesFacade) {
			super();
			this.rolesFacade = rolesFacade;
		}

		public getRoles(): IndexedArray<IRole>
		{
			if (!this.loading && !this.roles) {
				this.loading = true;
				this.rolesFacade.getRoles((roles) => {
					this.loading = false;
					this.roles = roles;
				});
			}
			return this.roles;
		}
	}

	RolesController.register(angular, 'RolesController', ['rolesFacade']);
}
