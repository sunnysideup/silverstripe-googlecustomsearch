jQuery(document).ready(
	function(){
		GoogleCustomSearch.init();
	}

)

var GoogleCustomSearch = {

	/**
	 * selector for the html element showing results
	 * @var String
	 */
	resultsSelector: "#GoogleCustomSearchResults",

	/**
	 * selector for the html element showing "no results"
	 * This should be pre-completed in the html
	 * @var String
	 */
	noResultsSelector: "#GoogleCustomSearchNoResult",

	/**
	 * selector for the html "searching now ... element"
	 * This should be pre-completed in the html
	 * @var String
	 */
	searchingResultsSelector: "#GoogleCustomSearchSearchingResult",

	/**
	 * selector for form
	 * @var String
	 */
	formSelector: "#Form_GoogleSiteSearchForm",

	/**
	 * selector for the input field for the search
	 * @var String
	 */
	inputFieldSelector: "#Form_GoogleSiteSearchForm_search",

	/**
	 * page that the see full results link will be directed to
	 * @var String
	 */
	fullResultsLink: "/search/",

	/**
	 * api key... set by PHP
	 * @var String
	 */
	apiKey: "",

	/**
	 * cx "key"... set by PHP
	 * @var String
	 */
	cxKey: "",

	/**
	 * holds the runSearch timeout thingy-me-bob
	 * @var Function
	 */
	runSearchHolder: null,

	/**
	 * number of milli-seconds before search runs
	 * @var Int
	 */
	timeBeforeSearchRuns: 500,

	/**
	 * minimum number of character entered before search runs
	 * @var Int
	 */
	charsBeforeSearchRuns: 3,

	/**
	 * the word(s) being search for
	 * @var String
	 */
	searchString: "",

	/**
	 * runs the basic setup
	 * @var Function
	 */
	init: function(){
		jQuery(this.inputFieldSelector).keyup(
			function() {
				var field = jQuery(this);
				var value = field.val();
				GoogleCustomSearch.searchString = value;
				if(value && value.length >= GoogleCustomSearch.charsBeforeSearchRuns) {
					clearTimeout(GoogleCustomSearch.timeoutHolder);
					GoogleCustomSearch.timeoutHolder = setTimeout(
						function() {
							GoogleCustomSearch.runSearch();
						},
						GoogleCustomSearch.timeBeforeSearchRuns
					);
				}
				else {
					jQuery(GoogleCustomSearch.resultsSelector).html("");
					jQuery(GoogleCustomSearch.noResultsSelector).hide();
					jQuery(GoogleCustomSearch.searchingResultsSelector).hide();
				}
			}
		);
	},

	/**
	 * runs the search by retrieving JSON from Google
	 * with a "callBack" to display the search
	 * @var Function
	 */
	runSearch: function(){
		var searchCommandLine = document.createElement('script');
		searchCommandLine.type = 'text/javascript';
		searchCommandLine.async = true;
		searchCommandLine.src = this.sourceBuilder();
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(searchCommandLine, s);
		//hide others
		jQuery(GoogleCustomSearch.resultsSelector).hide();
		jQuery(GoogleCustomSearch.noResultsSelector).hide();
		//show the one
		jQuery(GoogleCustomSearch.searchingResultsSelector).hide();
	},

	/**
	 * displays the search
	 * @var Function
	 */
	callBack: function (response){
		var item, myLink, link;
		if(response.items) {
			if(response.items.length) {
				html = "";
				html += "<ul>";
				link = jQuery(GoogleCustomSearch.formSelector).attr("action")+"recordsearch/";
				for (var i = 0; i < response.items.length; i++) {
					item = response.items[i];
					myLink = link + "?forwardto=" + escape(item.link) + "&search=" + escape(GoogleCustomSearch.searchString);
					// in production code, item.htmlTitle should have the HTML entities escaped.
					html += "<li><a href=\""+myLink+"\">" + item.htmlTitle+"</a></li>";
				}
				html += "<li><a href=\""+GoogleCustomSearch.fullResultsLink+"?search=" + escape(GoogleCustomSearch.searchString)+"\">See Full Results</a></li>";
				html += "</ul>";
				//hide others
				jQuery(GoogleCustomSearch.noResultsSelector).hide();
				jQuery(GoogleCustomSearch.searchingResultsSelector).hide();
				//show the one
				jQuery(GoogleCustomSearch.resultsSelector).html(html).show();
				return;
			}
		}
		//hide others
		jQuery(GoogleCustomSearch.resultsSelector).hide();
		jQuery(GoogleCustomSearch.searchingResultsSelector).hide();
		//show the one
		jQuery(GoogleCustomSearch.noResultsSelector).show();

	},

	/**
	 * returns the location of the Google API call
	 * @var Function
	 * @return String
	 */
	sourceBuilder: function() {
		var link = 'https://www.googleapis.com/customsearch/v1?';
			link += 'key=' + this.apiKey;
			link += '&cx='+ this.cxKey;
			link += '&fields=kind,items(htmlTitle,link)'
			link += '&callback=GoogleCustomSearch.callBack';
			link += '&q=' + escape(jQuery(this.inputFieldSelector).val());
		return link;
	}





}
