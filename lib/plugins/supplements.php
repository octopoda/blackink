<?php
   	require_once(CLASS_PATH.DS."databaseObject.php");
	require_once(PLUGIN_PATH.DS.'Pest.php');
	
    class Supplements extends databaseObject{
        
        public $table = "supplements";
        public $idfield = "ItemNumber";
        
        public $ItemNumber;
		public $ProductName;
		public $Count;
		public $ProductDescription;
		public $SuggestedUse;
		public $SFB; 
		public $ProductImage;
		public $ThumbnailImage;
		public $MSRP;
		public $featured;
		public $frontpage;
		
		//Helper Functions
		private $url = 'http://www.orthomolecularproducts.com/ProductCatalog.svc/Product';
		private $u = "44ba81577b274ef39d4ab8096f49633d";
		private $o = "XML";
		public $items = "";
		public $directLink;
		
		
		
        public function __construct($i_id="") {
           if (empty($i_id)) $i_id = $this->ItemNumber;
			
			if (!empty($i_id)) {
         		$result = $this->fetchById($i_id);
				$this->getLink();
			} 
        }
		
		public function getLink() {
			$title = str_replace(" ", "_", $this->ProductName);
			$this->directLink = '/supplements/'. urlencode($title). '.html';	
		}
		
		
/* ========================================
	Build/Helper Methods 
	==================================== */	 
		
		public function installSupplements() {
			$this->trucateTable();
			
			
			$xmlString = $this->connectToOrtho();
			$xmlString = $this->prepareXML($xmlString);
			$productXML = $this->parseXML($xmlString);
			
			foreach ($productXML as $child) {
				$supplement = new Supplements();
				$supplement->instaniateSupplements($child);
				
				if ($supplement->ItemNumber == 0) {continue;}
				$supplement->save();	
			}
			
			return true;
		}
		
		
		
		
		public function alphaSearch($letter) {
			global $db;
			$productArray = array();
			
			$result_set = $db->queryFill("SELECT ItemNumber FROM supplements WHERE productName LIKE '".$letter."%'");
			
			if ($result_set != false) {
				foreach ($result_set as $itemNumber) {
					$productArray[] =  new Supplements($itemNumber['ItemNumber']);	
				}
			}
			
			
			
			return $productArray;
		}
		
		public function featured() {
			global $db;
			$featuredArray = array();
			
			$result_set = $db->queryFill("SELECT ItemNumber FROM supplements WHERE featured = 1");
			if ($result_set != false) {
				foreach ($result_set as $itemNumber) {
					$featuredArray[] = new Supplements($itemNumber['ItemNumber']);	
				}
			}
			
			return $featuredArray;	
		}
		
		public function frontpage () {
			global $db;
			
			$result = $db->queryFill("SELECT ItemNumber FROM supplements WHERE frontpage = 1 LIMIT 1");
			if ($result != false) {
				foreach ($result as $itemNumber) {
					$item  = new Supplements($itemNumber['ItemNumber']);
					return $item;
				}	
			}
				
		}
		
		public function supplementIdFromTitle($title) {
			global $db;
			
			$result = $db->queryFill("SELECT ItemNumber FROM supplements WHERE ProductName LIKE '%{$title}%' LIMIT 1");
			
			if ($result != false) {
				foreach ($result as $item) {
					$supplement = new Supplements($item['ItemNumber']);	
				}
			}
			
			return $supplement;	
		}
		
		
/* ========================================
	Display Methods 
	==================================== */
		
		public function displayFullSupplement($supplement) {
				$html = '<div class="eightcol supplementLeft">';
				$html .= '<h2>'.$supplement->ProductName.'</h2>';
				
				$html .= '<img src="'.$supplement->ProductImage.'" alt="'.$supplement->ProductName.'" class="supplementImage"/>';
				
				$html .= '<h4>Product Details</h4>';
				$html .= '<p>'.$supplement->ProductDescription.'</p>';
				
				$html .= '<h4>Suggested Use</h4>';
				$html .= '<p>'.$supplement->SuggestedUse.'</p>';
				
				$html .= '</div><div class="threecol supplementRight">';
				
				$html .= '<h6>Price</h6>';
				$html .= '<p class="price">$'.$supplement->MSRP.'</p>';
				
				
				$html .= '<h6>Count</h6>';
				$html .= '<p class="count">'.$supplement->Count.'</p>';
				
				$html .= '<h6>SupplementFacts</h6>';
				$html .= '<a href="'.$supplement->SFB.'" target="_blank"><img src="'.$supplement->SFB.'" alt="'.$supplement->ProductName.' Facts" /></a>';
				
				$html .= '</div>';
				
				return $html;	
		}
		
		public function displayPreviewSupplement($supplement) {
				$html = '<div class="fivecol supplementThumb">';
				$html .= '<h4><a href="'.$supplement->directLink.'">'.$supplement->ProductName.'</a></h4>';
				$html .= '<img src="'.$supplement->ThumbnailImage.'" alt="'.$supplement->ProductName.'" class="supplementThumbnail"/>';
				$html .= '<p>'.$this->thumbnailDescription($supplement->ProductDescription).'</p>';
				$html .= '</div>';
				
				return $html;
		}
		
		
		public function thumbnailDescription($text) {
			$chars = 120; 

			$text = $text." "; 
			$text = substr($text,0,$chars); 
			$text = substr($text,0,strrpos($text,' ')); 
			$text = $text."..."; 
			
			return $text;	
		}
		
		
		
	
		
/* ========================================
	Admin Methods 
	==================================== */
	
	protected function trucateTable() {
		global $db;
		
		$db->query('TRUNCATE TABLE supplements');	
	}
	
	//Connect to Othro
	private function connectToOrtho() {
		$rest = new Pest($this->url);
		
		$url = $this->url."?u=". $this->u.'&o='.$this->o. '&i=' .$this->items ;
        $string = $rest->get($url);
		return $string;
	}
	
	
	private function prepareXML($string) {
		$string = str_replace("&lt;", "<", $string);
		$string = str_replace("&gt;", '>',$string);	
		return $string;
	}
	
	private function parseXML($string) {
		$xml = simplexml_load_string($string);
		$productResults = $xml->children();
		$products = $productResults->children();
		$product = $products->children();
		
		return $product;	
	}	
	
	
	private function instaniateSupplements($product) {
		
		$this->ItemNumber = $product->ItemNumber;
		$this->ProductName = $product->ProductName;
		$this->Count = $product->Count;
		$this->ProductDescription = $this->prepareXML($product->ProductDescription);
		$this->SuggestedUse = $this->prepareXML($product->SuggestedUse);
		$this->SFB = $product->SFB ;
		$this->ProductImage = $product->ProductImage;
		$this->ThumbnailImage = $product->ThumbnailImage;
		$this->MSRP = $product->MSRP;
	}
	
	public function setFeatured() {
			$this->featured = 1; 
			$this->save($this->ItemNumber);
	}
	
	public function setFrontpage() {
		global $db;
		
		$db->query('UPDATE supplements SET frontpage = 0');
		
		$this->frontpage = 1;
		$this->save($this->ItemNumber);	
	}
	
	

/* ========================================
	Redefine Methods 
	==================================== */
	
	
	public function displayFeatured() {
		global $db;
		
		$html = '<a title="featured" id="'.$this->ItemNumber.'" class="ninjaSymbol ninjaSymbolStar supplementStar ';
		
		if ($this->featured == 1) {
			$html .= 'active';	
		}
		
		$html .= '"></a>';
		
		return $html;
	}
	
	
	public function displayFrontpage() {
		global $db;
		
		$html = '<a title="frontpage" id="'.$this->ItemNumber.'" class="ninjaSymbol ninjaSymbolStar supplementStar ';
		
		if ($this->frontpage == 1) {
			$html .= 'active';	
		}
		
		$html .= '"></a>';
		
		return $html;
	}
	
}// /Class
?>
