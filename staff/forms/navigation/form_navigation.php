<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');

	$navigation;
	$action = "Add";

	if (isset($_GET['sel']) && isset($_GET['menu'])) {
		$navigation = new Navigation($_GET['sel']);
		$menu = new Menus($_GET['menu']);
		$action = "Edit";
	} else if (isset($_GET['menu'])) {
		$menu = new Menus($_GET['menu']);
		$navigation = new Navigation();

	}else {
		$menu = new Menus(menus::bottomMenu());
		$navigation = new Navigation();
	}


	echo $navigation->pushToForm();
	$link = 'forms/navigation/form_navigation.php';
	if (!empty($navigation->link)) $external = true;


?>
<script>
	$('#menu_id').val(<?php echo $menu->menu_id ?>)
	$('#content_title').val('<?php  echo $navigation->content_title ?>');
	$('#content_id').val(<?php echo $navigation->content_id ?>);
	<?php
		switch ($navigation->type) {
			case 2:
				echo "$('.contentInput').hide();";
				echo "$('.drugList').hide();";
				echo "$('#link').addClass('activeInput');";
				break;
			default:
				echo "$('.externalInput').hide();";
				echo "$('.drugList').hide();";
				echo "$('#content_title').addClass('activeInput');";
				break;
		}
	?>

</script>
<h3><?php echo $action ?> Navigation</h3>
<form id="formUpdate" method="POST">
	<fieldset>
    	<p>
        	<label for="type">Type of Link:</label>
        	<select name="type" id="type" sel>
            	<option value="1">Content</option>
                <option value="2">External Link</option>
            </select>
        </p>

        <p>
            <label for="title">Navigation Title (required)</label>
            <input type="text" name="title" id="title" autofocus placeholder="Navigation Name" class="required"  />
            <input type="hidden" name="navigation_id" id="navigation_id" />
        </p>
        <p class="contentInput">
        	<label for="content">Content for Navigation Item</label>
        	<input type="text" name="content_title" id="content_title" sel="<?php echo $navigation->content_id; ?>" placeholder="Click to Choose Content" />
            <input type="hidden" name="content_id" id="content_id" />

        </p>
        <p class="externalInput">
        	<label for="link">External Link</label>
            <input type="text" name="link" id="link" placeholder="http://yourdomain.com" sel="<?php echo $navigation->navigation_id; ?>" />
        </p>
        <div class="drugList">
            <a>
				<span class="ninjaSymbol ninjaSymbolPlus"></span>
				<span class="text">Add Theraputic Class</span>
			</a>
            <p>
            	<label>Treatment Names:</label>
                <ul class="drugs">
                	<?php if ($navigation->drugList != false) :

						foreach ($navigation->drugList as $drug) {	?>
                        <li>
                        	<span class="ninjaSymbol ninjaSymbolClear" id="deleteCompass"></span>
                        	<?php echo $drug->drugName; ?>
                        	<input type="hidden" name="drug_id[]" value="<?php echo $drug->drug_id; ?>" /></li>
                     <?php  } endif;?>

                </ul>
            </p>
        </div>
        <div class="contentPopUp"></div>
        <p>
        	<label for="menu_id">Menus</label>
            <select name="menu_id" id="menu_id">
        	<?php
				$menu->listMenus();
				foreach ($menu->menuList as $list) { ?>
					<option value="<?php echo $list->menu_id; ?>"
                   	<?php if ($menu->menu_id == $list->menu_id) { echo 'selected'; }   ?>
                    ><?php echo $list->menu_name ?></option>
			<? 	}?>
            </select>
        </p>

        <p class="listParents">
        	<?php
				$navigation->listParents($menu->menu_id);
				echo $navigation->parentDropDown();
			?>
        </p>

        <p>
			<label>Published</label>
			<select name="published" id="published">
				<option value="0">Unpublished</option>
				<option value="1">Published</option>
			</select>
		</p>
		<p class="new">
			<label for="access">Access:</label>
			<?php echo $menu->accessDropDown(1) ?>
		</p>

        <p class="listPosition">
        	<?php if (!isset($navigation->parent_id)) $navigation->parent_id = 0; ?>
        	<?php echo $navigation->positionDropDown($menu->menu_id, $navigation->parent_id); ?>
        </p>
        <p>
            <button name="navigationSettings" id="navigationSettings">Submit</button>
            <input type="hidden" name="class" id="class" value="navigation" />
            <input type="hidden" name="create" id="create" value="forms/navigation/navigation.php?sel=" />
        </p>

    </fieldset>



</form>
<div class="data"></div>