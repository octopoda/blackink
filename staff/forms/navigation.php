<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); 

	$nav = new Navigation();
	$link = '/staff/forms/navigation.php';
	
	if (isset($_GET['sel'])) {
		$menuId = $_GET['sel'];
	} else {
		$menuId = 1;
	}
?>


<h3 class="floatLeft">Main Menu Navigation</h3>
<p></p>

<div class="menuSelect">
	<form>
		<select class="menuPicker">
			<?php  
				$nav->listMenus();
				foreach ($nav->menuList as $list) { ?>
					<option value="<?php echo $list['menu_id']; ?>" <?php if ($list['menu_id'] == $menuId) echo 'selected="selected"'; ?>><?php  echo $list['menu_name'] ?></option>
			<?php }?>
		</select>
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
                <td width="100"><?php echo $list->moveArrows($list->navigation_id, $list->position, $link, $list->parent); ?></td>
                <td><?php echo $list->accessGroupName($list->access); ?></td>
            </tr>
            
            <?php if ($list->subNavList != false) { 
					foreach ($list->subNavList as $sub) { ?>
    			<tr class="subNav">
                	<td class="title"><?php echo $sub->title; ?></td>
                    <td style="text-align:center"><?php echo $sub->published($sub->navigation_id); ?></td>
                    <td><?php echo $list->moveArrows($sub->navigation_id, $sub->position, $link, $sub->parent); ?></td>
                    <td><?php echo $sub->accessGroupName($sub->access); ?></td>
                </tr>
    <?php  } } } ?>
    	</tbody>
    </table>
</div>
<div class="data">
</div>

