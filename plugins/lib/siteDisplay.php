<?php
require_once (CLASS_PATH.DS.'display.php');

class SiteDisplay extends display {

	protected $handler = array('content'=>'content', 'ads'=>'ads', 'news'=>'news');

	public function __construct($urlTitle="", $contentTitle="") {
		$this->navigationHandler($urlTitle, $contentTitle);
		$this->setupUser();
	}

	public function displayNews() {
			$news = new News();
			$news->listNews(3);

			$html = '<ul class="news">';
			foreach ($news->newsList as $item) {
				$item->summary = strip_tags($item->summary);

				if ($item->published == 0 || $item->access > $this->user->access) continue;
				$html .= '<li>';
				$html .= '<h4><a href="'. $item->directLink .'">'.$item->title.'</a></h4>';
				$html .= '<p>'.$item->summary.'</p>';
				$html .= '</li>';
			}

			$html .= "</ul>";
			$html .= '<div class="newsTriangle"></div>';
			return $html;
		}

	public function displayAds($placement) {
			$ads = new Ads();
			$ads->listAds();



			$adDisplay = '<div class="scroll">';
			foreach($ads->adList as $item) {
				if ($item->placement == 1) {
					continue;
				}
				$adDisplay .= '<div class="panel">';
				if (($placement == $item->humanPlacement) || ($item->humanPlacment == 'Both')) {
					$adDisplay .= $item->summary;
				} else if (($placement == $item->humanPlacement) || ($item->humanPlacement == 'Both')) {
					$adDisplay .= $item->summary;
				}
				$adDisplay .= '<a href="'.$item->directLink.'" class="learnMore">Learn More</a>';
				$adDisplay .= '</div>';
			}
			$adDisplay .= '</div>
			<div class="numbers ir"></div>
			';

			echo $adDisplay;
		}

	public function randomAd($placement) {
			$ads = new Ads();
			$ads->listAds();
			$max = count($ads->adList) -1;


			$num = rand(0, $max);
			$item = $ads->adList[$num];

			if ($item->placement == 1) return;

			$adDisplay = '<div class="panelInside">';
			if (($placement == $item->humanPlacement) || ($item->humanPlacment == 'Both')) {
				$adDisplay .= $item->summary;
			} else if (($placement == $item->humanPlacement) || ($item->humanPlacement == 'Both')) {
				$adDisplay .= $item->summary;
			}
			$adDisplay .= '<a href="'.$item->directLink.'" class="learnMore">Learn More</a>';
			$adDisplay .= '</div>';

			echo $adDisplay;

		}



}

?>