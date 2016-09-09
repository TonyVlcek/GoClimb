namespace GoClimb.Admin.Services
{

	import BaseService = GoClimb.Core.Services.BaseService;

	export class Authorizator extends BaseService
	{

		private permissions: string[];

		public constructor(permissions: string[])
		{
			super();
			this.permissions = permissions;
		}

		public isAllowed(resource: string): boolean
		{
			return this.permissions.indexOf(resource) !== -1;
		}

	}

	Authorizator.register(angular, 'authorizator', ['permissions']);

}
