namespace GoClimb.Admin.Model.Entities
{

	export interface INews
	{

		id?: number;
		name: string;
		author?: {
			id: number;
			name: string;
		},
		publishedDate?: any /*string|Date*/;
		published?: boolean;

	}

}
