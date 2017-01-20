namespace GoClimb.Core.Model.Facades
{

	import IRating = GoClimb.Core.Model.Entities.IRating;

	export class RatingFacade extends BaseFacade
	{
		public addRating(rating: IRating, callback: (rating: IRating) => void = null)
		{
			rating = angular.copy(rating);
			this.httpService.requestPost('ratings', {rating: rating}, (data) => {
				callback(data.rating);
			});
		}
	}

	RatingFacade.register(angular, 'ratingFacade', ['httpService']);

}
