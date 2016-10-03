namespace GoClimb.Core.Model.Entities
{

	export interface IRole
	{

		id?: number;
		name: string;
		parent?: number;
		users: Array<{
			id: number;
			nick?: string;
			email: string
		}>;

	}

}
