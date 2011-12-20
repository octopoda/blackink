 <form id="form" method="GET" action="/search.php"  class="search">
    <input type="search" name="h" id="search" />
    <button id="searchButton">Search</button>
</form>

<?php include(MODULES. 'refills.php');  ?>

<h3 class="newsHeader">Recent News</h3>
<?php include(MODULES.'news.php'); ?>
<?php $display->randomAd('Side Bar'); ?>