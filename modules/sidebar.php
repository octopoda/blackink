 <form id="form" method="GET" action="/search.php"  class="search">
    <input type="search" name="h" id="search" />
    <button id="searchButton">Search</button>
</form>
<section class="refills">
	<h5><a href="refills.html">Online Refills</a></h5>
	<div class="refillTriangle"></div>
</section>


<h3 class="newsHeader">Recent News</h3>
<?php include(MODULES.'news.php'); ?>
<?php //include(MODULES.'ads.php'); ?>