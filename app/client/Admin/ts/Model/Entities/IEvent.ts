namespace GoClimb.Admin.Model.Entities
{

	export interface IEvent
	{

		id?: number;
		name: string;
		content: string;
		author?: {
			id: number;
			name: string;
		},
		startDate?: any /*string|Date*/;
		endDate?: any /*string|Date*/;
		publishedDate?: any /*string|Date*/;
		published?: boolean;

	}

}
