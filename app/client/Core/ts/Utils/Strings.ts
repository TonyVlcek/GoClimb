namespace GoClimb.Core.Utils
{

	export class Strings
	{

		public static ucfirst(string: string)
		{
			return string.length <= 1 ? string.toUpperCase() : (string.charAt(0).toUpperCase() + string.slice(1));
		}


		public static lcfirst(string: string)
		{
			return string.length <= 1 ? string.toLowerCase() : (string.charAt(0).toLowerCase() + string.slice(1));
		}

	}

}
