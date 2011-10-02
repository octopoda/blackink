<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/errors.php');

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
	$link = 'forms/navigation/navigationForm.php';
?>
<script>
	$('#menu_id').val(<?php echo $menu->menu_id ?>)
	$('#content_title').val('<?php  echo $navigation->content_title ?>');
	$('#content_id').val(<?php echo $navigation->content_id ?>);
</script>
<h3><?php echo $action ?> Navigation</h3>
<form id="formUpdate" method="POST">
	<fieldset>
        <p>
            <label for="title">Navigation Title (required)</label>
            <input type="text" name="title" id="title" autofocus  />
            <input type="hidden" name="navigation_id" id="navigation_id" />
        </p>
        <p>
        	<label for="content">Content for Navigation Item</label>
        	<input type="text" name="content_title" id="content_title" />
            <input type="hidden" name="content_id" id="content_id" />
            
        </p>
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
            <input type="hidden" name="addNavigation" id="addNavigation" value="forms/navigation/navigation.php" />
        </p>
    
    </fieldset>
</form>
<div class="data"></div>