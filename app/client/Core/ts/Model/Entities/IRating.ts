namespace GoClimb.Core.Model.Entities
{

	export interface IRating
	{

		id?: number;
		note: string;
		rating: number;
		route? : {
			id: number
		};
		author?: {
			id: number;
			name: string;
		},
		createdDate?: any;

	}

}
