<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); 

	$nav = new Navigation();
	$menu = new Menus();
	
	
	
	if (isset($_GET['sel'])) {
		$menuId = $_GET['sel'];
	} else {
		$menuId = 1;
	}
	
	$link = '/staff/forms/navigation/navigation.php?sel=' . $menuId;
?>
<script>
	$(function() {
		$( "#radio" ).buttonset();
	});
</script>

<h3 class="floatLeft">Main Menu Navigation</h3>
<p></p>

<div class="menuSelect">
	 <form  class="menuPicker">
		<div id="radio">
			<?php  
				$menu->listMenus();
				foreach ($menu->menuList as $list) { 
					$id = 'radio_'. $list->menu_id; ?>
					<input type="radio" name="menuPicker" id="<?php echo $id ?>" value="<?php echo $list->menu_id ?>" <?php if ($list->menu_id == $menuId) echo "checked"; ?>/>
					<label for="<?php echo $id ?>"><?php echo $list->menu_name ?></label>
			<?php } ?>
		</div>
		<ul class="quickMenu">
		<li>
			<a class="addMenu">
				<span class="ninjaSymbol ninjaSymbolPlus"></span>
				<span class="text"> Add Menu Navigation</span>
			</a>
		</li>
	</ul>
	</form>
	
 
</div>
<div class="list">
	<table class="navigationList">
    	<thead>
        	<tr>
            	<th>Title</th>
                <th>Published</th>
                <th>Position</th>
                <th>Access</th>
            </tr>
        </thead>
    	<tbody>
    
	<?php 
		$nav->listNav($menuId);
		foreach($nav->itemList as $list) { ?>
    		<tr class="mainNav">
            	<td class="title"><?php echo $list->title; ?></td>
                <td width="50" style="text-align:center"><?php echo $list->published($list->navigation_id); ?></td>
                <td width="100"><?php echo $list->moveArrows($list->navigation_id, $list->position, $link, $list->parent, $list->menu_id); ?></td>
                <td><?php echo $list->accessDropDown($list->access); ?></td>
            </tr>
            
            <?php if ($list->subNavList != false) { 
					foreach ($list->subNavList as $sub) { ?>
    			<tr class="subNav">
                	<td class="title"><?php echo $sub->title; ?></td>
                    <td style="text-align:center"><?php echo $sub->published($sub->navigation_id); ?></td>
                    <td><?php echo $list->moveArrows($sub->navigation_id, $sub->position, $link, $sub->parent, $sub->menu_id); ?></td>
                    <td><?php echo $sub->accessDropDown($sub->access); ?></td>
                </tr>
    <?php  } } } ?>
    	</tbody>
    </table>
</div>
<div class="data">
</div>

