(function() {
	function showSignInForm() {
		var continueForm = (<Element[]><any>document.getElementsByClassName('js-continue'))[0];
		var signInForm = (<Element[]><any>document.getElementsByClassName('js-sign-in'))[0];
		continueForm.classList.add('hidden');
		signInForm.classList.remove('hidden');
	}

	var el = (<Element[]><any>document.getElementsByClassName('js-not-you'))[0];
	el.addEventListener('click', showSignInForm, false);
})();
