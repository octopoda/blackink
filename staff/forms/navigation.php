<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); 

	$nav = new Navigation();
	$nav->listNav(1);
	$link = 'forms/navigation.php';
?>


<h3 class="floatLeft">Main Menu Navigation</h3>
<p></p>

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
    
	<?php foreach($nav->itemList as $list) { ?>
    		
    		
    		<tr class="mainNav">
            	<td class="title"><?php echo $list->title; ?></td>
                <td width="50" style="text-align:center"><?php echo $list->published($list->navigation_id); ?></td>
                <td width="100"><?php echo $list->moveArrows($list->navigation_id, $list->position, $link); ?></td>
                <td><?php echo $list->accessGroupName($list->access); ?></td>
            </tr>
            
            <?php if ($list->subNavList != false) { 
					foreach ($list->subNavList as $sub) { ?>
    			<tr class="subNav">
                	<td class="title"><?php echo $sub->title; ?></td>
                    <td style="text-align:center"><?php echo $sub->published($sub->navigation_id); ?></td>
                    <td><?php echo $list->moveArrows($sub->navigation_id, $sub->position, $link); ?></td>
                    <td><?php echo $sub->accessGroupName($sub->access); ?></td>
                </tr>
    <?php  } } } ?>
    	</tbody>
    </table>
</div>
<div class="data">
</div>

