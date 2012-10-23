 <?php
    $site = new Site();
    print_r($site->configuration);
    if ($site->configuration['Search'] == 1) { ?>
    <form id="form" method="GET" action="/search.php"  class="search">
        <input type="search" name="h" id="search" />
        <button id="searchButton">Search</button>
    </form>
<?php } ?>


<?php include(MODULES.'news.php'); ?>
<?php $display->randomAd('Side Bar'); ?>