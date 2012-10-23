<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
    $site = new Site();

    function checked($a, $v) {
        if ($a == $v) echo "selected";
    }
?>

<h3 class="floatLeft">Site Configuration</h3>

<div>
    <h5>Sidebars</h5>
    <dl class="clearfix">
    <?php foreach ($site->configuration as $k=>$v) {?>
        <dt><?php echo $k ?>:</dt>
        <dd>
            <select id="siteOnOff" name="siteOnOff" data-name="<?php echo $k?>">
                <option value="0" <?php checked(0, $v) ?>>Off</option>
                <option value="1" <?php checked(1, $v) ?>>On</option>
            </select>
        </dd>


    <?php  } ?>
    </dl>

</div>

<div class="data"></div>

