 <form id="form" method="GET" action="/search.php"  class="search">
    <input type="search" name="h" id="search" />
    <button id="searchButton">Search</button>
</form>
<section class="refills">
	<h5><a href="/online_refills.html">Prescriptions Refills</a><span class="ninjaSymbol ninjaSymbolArrowRight"></span></h5>
</section>


<h3 class="newsHeader">Recent News</h3>
<?php include(MODULES.'news.php'); ?>
<?php $display->randomAd('Side Bar'); ?>