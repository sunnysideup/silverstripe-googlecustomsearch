<?php

/**
 * @package googlesitesearch
 */
class GoogleCustomSearchPage extends Page {

	private static $icon = "googlecustomsearch/images/treeicons/GoogleCustomSearchPage";

	private static $allowed_children = "none";

	private static $can_be_root = true;

	/**
	 * Standard SS variable.
	 */
	private static $singular_name = "Google Search Results Page";
		function i18n_singular_name() { return _t("GoogleCustomSearchPage.SINGULAR_NAME", "Google Search Results Page");}

	/**
	 * Standard SS variable.
	 */
	private static $plural_name = "Google Search Results Pages";
		function i18n_plural_name() { return _t("GoogleCustomSearchPage.PLURAL_NAME", "Google Search Results Pages");}

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		return $fields;
	}

	public function requireDefaultRecords() {
		if($this->canCreate()) {
			DB::alteration_message("Creating a GoogleCustomSearchPage", "created");
			$page = new GoogleCustomSearchPage();
			$page->writeToStage('Stage');
			$page->publish('Stage', 'Live');
		}
	}

	public function populateDefaults() {
		$this->Title = "Search";
		$this->MenuTitle = "Search";
		$this->ShowInMenus = 0;
		$this->ShowInSearch = 0;
		$this->URLSegment = "search";
	}

	public function canCreate($member = null) {
		return GoogleCustomSearchPage::get()->count() ?  false : true;
	}

}

class GoogleCustomSearchPage_Controller extends Page_Controller {

	public function init() {
		parent::init();
		Requirements::themedCSS('GoogleCustomSearchPage');
		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::javascript('googlecustomsearch/javascript/GoogleCustomSearchPage.js');
		$cxKey = Config::inst()->get("GoogleCustomSearchExt", "cx_key");
		Requirements::customScript("
				GoogleCustomSearchPage.cxKey = '".$cxKey."';
			",
			"GoogleCustomSearchPage"
		);
	}

	/**
	 * template function,
	 *
	 * @ return String
	 */
	public function SearchPhrase(){
		$string = "";
		if(isset($_GET['search'])) {
			$string = $_GET['search'];
		}
		return DBField::create_field('HTMLText', $string);
	}

	/**
	 *
	 * @return String
	 */
	function getTitle(){
		if($searchPhrase = $this->SearchPhrase()->forTemplate()) {
			return $this->dataRecord->Title._t("GoogleCustomSearchPage.FOR", " for ").$searchPhrase;
		}
		else {
			return $this->dataRecord->Title;
		}
	}

}
