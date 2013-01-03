<?php
   	require_once("databaseObject.php");

    class Ads extends databaseObject{

        public $table = "ads";
        public $idfield = "ad_id";

        public $ad_id;
		public $title;
		public $published;
		public $position;
		public $user_id;
		public $placement;
		public $summary;
		public $content;

		//Helper Functions
		public $adList;
		public $humanPlacment;
		public $directLink;
		public $access = 0;

        public function __construct($a_id="") {
           if (empty($a_id)) $a_id = $this->ad_id;

			if (!empty($a_id)) {
         		$result = $this->fetchById($a_id);
				$this->placementHumanReadable();
				$this->directLink = $this->createLink('ads');
			}
        }
/* ========================================
	Build/Helper Methods
	==================================== */

	public function placementHumanReadable() {
		switch ($this->placement) {
			case 0:
				$this->humanPlacement = 'Front Page';
				break;
			case 1:
				$this->humanPlacement = 'Side Bar';
				break;
			case 2:
				$this->humanPlacement = 'Both';
				break;
		}
	}


	public function listAds() {
		global $db;

		$result_set = $db->queryFill("SELECT ad_id FROM ads ");

		if ($result_set != false) {
			foreach ($result_set as $row) {
				$this->adList[] = new Ads($row['ad_id']);
			}
		}
	}


/* ========================================
	Display Methods
	==================================== */

	static function adIdFromTitle($title) {
		global $db;

		$result_set = $db->queryFill("SELECT ad_id FROM ads WHERE title = '{$title}'");
		if ($result_set != false) {
			foreach ($result_set as $row) {
				return $row['ad_id'];
			}
		}
	}

/* ========================================
	Admin Methods
	==================================== */

	//CRU
	public function createFromForm($post) {
		global $error;

		$this->fillFromForm($post);



		$ad_id = $this->save($this->ad_id);

		if (isset($ad_id)) {
			return $ad_id;
		} else {
			$error->addError('The information did not save.', 'Ads1284');
		}
	}



	//Delete
	public function deleteFromForm() {
		global $error;

		if ($this->delete($this->ad_id)) {
			return true;
		} else {
			$error->addError('the information did not save.' ,'Ads1564');
		}
	}


/* ========================================
	Redefine Methods
	==================================== */

}// /Class
?>
