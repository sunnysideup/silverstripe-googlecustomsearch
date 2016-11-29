<?php

/**
 * @package googlesitesearch
 */
class GoogleCustomSearchPage extends Page
{
    private static $icon = "googlecustomsearch/images/treeicons/GoogleCustomSearchPage";

    private static $allowed_children = "none";

    private static $can_be_root = true;

    private static $description = "Page to search via Google and display search results.";

    /**
     * Standard SS variable.
     */
    private static $singular_name = "Google Search Results Page";
    public function i18n_singular_name()
    {
        return _t("GoogleCustomSearchPage.SINGULAR_NAME", "Google Search Results Page");
    }

    /**
     * Standard SS variable.
     */
    private static $plural_name = "Google Search Results Pages";
    public function i18n_plural_name()
    {
        return _t("GoogleCustomSearchPage.PLURAL_NAME", "Google Search Results Pages");
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab("Root.Searches",
            new GoogleCustomSearchPage_RecordField("stats", "Search History Last 100 Days")
        );
        return $fields;
    }

    public function requireDefaultRecords()
    {
        if ($this->canCreate()) {
            DB::alteration_message("Creating a GoogleCustomSearchPage", "created");
            $page = new GoogleCustomSearchPage();
            $page->writeToStage('Stage');
            $page->publish('Stage', 'Live');
        }
    }

    public function populateDefaults()
    {
        parent::populateDefaults();
        $this->Title = "Search";
        $this->MenuTitle = "Search";
        $this->ShowInMenus = 0;
        $this->ShowInSearch = 0;
        $this->URLSegment = "search";
    }

    public function canCreate($member = null)
    {
        return GoogleCustomSearchPage::get()->count() ?  false : true;
    }
}

class GoogleCustomSearchPage_Controller extends Page_Controller
{
    private static $allowed_actions = array(
        "recordsearch"
    );

    public function init()
    {
        parent::init();
        //register any search
        if (isset($_GET["search"])) {
            $searchString = Convert::raw2sql($_GET["search"]);
            $forwardto = "";
            if (isset($_GET["forwardto"])) {
                $forwardto = Convert::raw2sql($_GET["forwardto"]);
            }
            GoogleCustomSearchPage_Record::add_entry($searchString, $forwardto);
        }
        if ($this->request->param("Action") != "recordsearch") {
            Requirements::themedCSS('GoogleCustomSearchPage');
            Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
            Requirements::javascript('googlecustomsearch/javascript/GoogleCustomSearchPage.js');
            $cxKey = Config::inst()->get("GoogleCustomSearchExt", "cx_key");
            Requirements::customScript("
					GoogleCustomSearchPage.cxKey = '".$cxKey."';
				",
                "GoogleCustomSearchPage"
            );
        } else {
            echo "registered ...";
        }
    }

    /**
     * template function,
     *
     * @ return String
     */
    public function SearchPhrase()
    {
        $string = "";
        if (isset($_GET['search'])) {
            $string = $_GET['search'];
        }
        return DBField::create_field('HTMLText', $string);
    }

    /**
     *
     * @return String
     */
    public function getTitle()
    {
        if ($searchPhrase = $this->SearchPhrase()->forTemplate()) {
            return $this->dataRecord->Title._t("GoogleCustomSearchPage.FOR", " for ").$searchPhrase;
        } else {
            return $this->dataRecord->Title;
        }
    }

    public function recordsearch($request)
    {
        if (isset($_GET["forwardto"]) && $_GET["forwardto"]) {
            return $this->redirect($_GET["forwardto"]);
        }
    }
}
