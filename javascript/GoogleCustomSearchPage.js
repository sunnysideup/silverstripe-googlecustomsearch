

var GoogleCustomSearchPage = {

	/**
	 * cx "key"... set by PHP
	 * @var String
	 */
	cxKey: "",

	init: function(){
		var gcse = document.createElement('script');
		gcse.type = 'text/javascript';
		gcse.async = true;
		gcse.src = (document.location.protocol == 'https' ? 'https:' : 'http:') +
				'//www.google.com/cse/cse.js?cx=' + this.cxKey;
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gcse, s);
	}

}

jQuery(document).ready(
	function(){
		GoogleCustomSearchPage.init();
	}
);
