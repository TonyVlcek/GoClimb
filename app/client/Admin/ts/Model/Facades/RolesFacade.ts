namespace GoClimb.Admin.Model.Facades
{

	import HttpService = GoClimb.Admin.Model.Http.HttpService;
	import BaseFacade = GoClimb.Admin.Model.Facades.BaseFacade;
	import IndexedArray = GoClimb.Core.Utils.IndexedArray;
	import IRole = GoClimb.Admin.Model.Entities.IRole;


	export class RolesFacade extends BaseFacade
	{

		private roles: IndexedArray<IRole> = null;

		private loading: boolean = false;


		public getRoles(callback: (roles: IndexedArray<IRole>) => void = null, errorCallback: Function = null)
		{
			if (this.roles === null && this.loading === false) {
				this.loading = true;
				this.httpService.requestGet('roles/', (data) => {
					this.roles = new IndexedArray<IRole>(data.roles);
					this.loading = false;
					if (callback) {
						callback(this.roles);
					}
				}, errorCallback);
			} else if (this.roles) {
				callback(this.roles);
			}
		}

		public getRole(id: string, callback: (role: IRole) => void = null, errorCallback: Function = null) {
			this.getRoles((roles) => {
				callback(roles.getIndex(id));
			}, errorCallback);
		}

		public linkUpUser(roleId: number, userId: number, callback: (role: IRole) => void = null, errorCallback: Function = null): RolesFacade
		{
			this.httpService.requestPost('roles/' + roleId + '/users', {userId: userId}, (data) => {
				var role = this.roles.getIndex(roleId.toString());
				role.users = data.users;
				callback(role)
			}, errorCallback);
			return this;
		}

		public unlinkUser(roleId: number, userId: number, callback: (role: IRole) => void = null, errorCallback: Function = null): RolesFacade
		{
			this.httpService.requestDelete('roles/' + roleId + '/users/' + userId, {}, (data) => {
				var role = this.roles.getIndex(roleId.toString());
				role.users = data.users;
				callback(role);
			}, errorCallback);
			return this;
		}
	}

	RolesFacade.register(angular, 'rolesFacade', ['httpService']);

}
