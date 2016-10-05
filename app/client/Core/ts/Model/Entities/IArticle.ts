namespace GoClimb.Core.Model.Entities
{

	export interface IArticle
	{

		id?: number;
		name: string;
		content: string;
		author?: {
			id: number;
			name: string;
		},
		publishedDate?: any /*string|Date*/;
		published?: boolean;

	}

}
