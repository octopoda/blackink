<?php
require_once (CLASS_PATH.DS.'display.php');

class SiteDisplay extends display {

	protected $handler = array('content'=>'content', 'ads'=>'ads', 'news'=>'news');

	public function __construct($urlTitle="", $contentTitle="") {
		$this->navigationHandler($urlTitle, $contentTitle);
		$this->setupUser();
	}

	public function displayNews() {
			$site = new Site();

			if ($site->configuration['News'] != 1) {
				return;
			}

			$news = new News();
			$news->listNews(3);
			$html = '<h3 class="newsHeader">Recent News</h3>';
			$html .= '<ul class="news">';
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
			$site = new Site();

			if ($site->configuration['Ads'] != 1) {
				return;
			}

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
			$site = new Site();

			if ($site->configuration['Ads'] != 1) {
				return;
			}

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

	public function  paginateClass($classname, $pageNumber, $orderby, $rate) {
		$class = new $classname();
		$html = "";

		$totalSize = count($class->fetchAll());

		$page = 1;
		$size = 10;

		if (isset($pageNumber)) $page = $pageNumber;

		$pagination = new Pagination($classname);
		$pagination->setupPagination($page, $size, $totalSize);
		$result = $class->fetchPublished($orderby, $rate, $pagination->getLimitSQL());

		foreach ($result as $content) {
			$c = new $classname($content[$class->idfield]);
			if ($classname == 'post' && $c->isPublished()) {
				$html .= $this->buildPaginationHTML($c);
			}
		}

		echo $html;
		echo $pagination->create_links();
	}


	public function buildPaginationHTML($object) {

		if ($object->table == 'post') {
			$user = new Users($object->user_id);
			$html  = '<div class="pagination"><hgroup>';
			$html .= '<h3><a href="'.$object->directLink.'">'.$object->title.'</a></h3>';
			$html .= '<h5>Author: '.$user->printName(). ' // Date: '.date("M d, Y", strtotime($object->publish_date)).'</h5>';
			$html .= '</hgroup>';
			$html .= '<p>'.  truncate($object->searchable, 400," ", "...").'</p>';
			$html .= '</div>';
		}

		return $html;
	}


	//End Comments



}

?>