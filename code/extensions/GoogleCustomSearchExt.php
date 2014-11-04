<?php
/*
 * @author nicolaas [at] sunnysideup.co.nz
 * Simple extension to add Google Custom Search to SilverStripe
 */
class GoogleCustomSearchExt extends SiteTreeExtension {

	/**
	 * @see: https://developers.google.com/custom-search/json-api/v1/introduction#identify_your_application_to_google_with_api_key
	 * @var String
	 */
	private static $api_key = "";

	/**
	 *
	 * @see: https://developers.google.com/custom-search/json-api/v1/introduction#identify_your_application_to_google_with_api_key
	 * @var String
	 */
	private static $cx_key = "";

	/**
	 * returns the form
	 * @return Form
	 */
	public function getGoogleSiteSearchForm() {
		if($page = GoogleCustomSearchPage::get()->first()) {
			Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
			Requirements::javascript('googlecustomsearch/javascript/GoogleCustomSearch.js');
			$apiKey = Config::inst()->get("GoogleCustomSearchExt", "api_key");
			$cxKey = Config::inst()->get("GoogleCustomSearchExt", "cx_key");
			if($apiKey && $cxKey) {
				Requirements::customScript("
						GoogleCustomSearch.apiKey = '".$apiKey."';
						GoogleCustomSearch.cxKey = '".$cxKey."';
					",
					"GoogleCustomSearchExt"
				);
				$form = new Form(
					$this->owner,
					'GoogleSiteSearchForm',
					new FieldList($searchField = new TextField('search')),
					new FieldList(new FormAction('doSearch', _t("GoogleCustomSearchExt.GO", "go")))
				);
				$form->setFormMethod('GET');
				if($page = GoogleCustomSearchPage::get()->first()) {
					$form->setFormAction($page->Link());
				}
				$form->disableSecurityToken();
				$form->loadDataFrom($_GET);
				$searchField->setAttribute("autocomplete", "off");
				$form->setAttribute("autocomplete", "off");
				return $form;
			}
			else {
				user_error("You must set an API Key and a CX key in your configs to use the Google Custom Search Form", E_USER_WARNING);
			}
		}
		else {
			user_error("You must create a GoogleCustomSearchPage first.", E_USER_WARNING);
		}
	}

	/**
	 * returns the Google Search page...
	 * @return GoogleCustomSearchPage
	 */
	public function GoogleCustomSearchPage(){
		return GoogleCustomSearchPage::get()->first();
	}

}
