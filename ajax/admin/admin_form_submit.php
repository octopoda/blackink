<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/require.php'); 

//echo 'hello';

if (isset($_POST['siteForm'])) {
	$site = new Site();
	
	if ($site->createFromForm($_POST)) {
		echo $_POST['siteForm'];
	} else {
		return false;	
	}
}

if (isset($_POST['contactForm'])) {
	$contact = new contactInformation();
	
	$contact->createFromForm($_POST);
	
	echo $_POST['contactForm'];
}


if (isset($_POST['addMenu'])) {
	$menu = new Menus();
	
	$menu->createMenuFromForm($_POST);
	
	echo $_POST['addMenu'];	
}

if (isset($_POST['addNavigation'])) {
	if (isset($_POST['navigation_id'])) $id = $_POST['navigation_id'];
	
	$navigation = new Navigation($id);
	$navigation->createNavigationFromForm($_POST);
	
	echo $_POST['addNavigation'];	
}

if (isset($_POST['addContent'])) {
	if (isset($_POST['content_id'])) $id = $_POST['content_id'];
	$content = new Content($id);
	
	$created = $content->createContentFromForm($_POST);
	
	echo $_POST['addContent'].$created;
}

if (isset($_POST['addUser'])) {
	if (isset($_POST['user_id']))  $id = $_POST['user_id'];
	$user = new Users($id);
	
	$newUser = $user->createUserFromForm($_POST);
	
	echo $_POST['addUser'];	
}

if (isset($_POST['addNews'])) {
	if (isset($_POST['news_id'])) $id = $_POST['news_id'];
	$news = new News();
	
	$created = $news->createNewsFromForm($_POST);
	
	echo $_POST['addNews'];		
}

if (isset($_POST['changePassword'])) {
	global $error;
	
	$u = new Users($_POST['user_id']);
	
	if ($u->changePassword($_POST['newPass'])) {
		echo $_POST['changePassword'];
	}
		
}

if (isset($_POST['addAds'])) {
	global $error;
	if (isset($_POST['ad_id'])) $id = $_POST['ad_id'];
	$ads = new Ads($id);
	
	$created = $ads->createAdsFromForm($_POST);
	
	echo $_POST['addAds'];	
}



?>


