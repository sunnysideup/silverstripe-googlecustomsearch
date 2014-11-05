<?php


class GoogleCustomSearchPage_Record extends DataObject {

	private static $db = array(
		"Title" => "Varchar(200)",
		"URL" => "Varchar(255)"
	);

	/**
	 * add new search entry
	 *
	 * @param String $keywordString
	 * @param String $URL
	 *
	 * @return Int
	 */
	public static function add_entry($keywordString, $URL = "") {
		if($member = Member::currentUser()) {
			if($member->IsShopAdmin()) {
				return -1;
			}
		}
		$obj = new GoogleCustomSearchPage_Record();
		$obj->Title = $keywordString;
		$obj->URL = $URL;
		return $obj->write();
	}

	/**
	 * remove spaces
	 *
	 */
	function onBeforeWrite() {
		$this->Title = strtolower(trim(preg_replace('!\s+!', ' ', $this->Title)));
		parent::onBeforeWrite();
	}


	/**
	 * standard SS method
	 * @param Member $member
	 * @return Boolean
	 */
	public function canCreate($member = null) {return false;}

	/**
	 * standard SS method
	 * @param Member $member
	 * @return Boolean
	 */
	public function canEdit($member = null) {return false;}

	/**
	 * standard SS method
	 * @param Member $member
	 * @return Boolean
	 */
	public function canDelete($member = null) {return false;}

}
