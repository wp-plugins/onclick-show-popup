<?php
// Form submitted, check the data
if (isset($_POST['frm_OnclickShowPopup_display']) && $_POST['frm_OnclickShowPopup_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$OnclickShowPopup_success = '';
	$OnclickShowPopup_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$sSql = $wpdb->prepare(
		"SELECT COUNT(*) AS `count` FROM ".WP_OnclickShowPopup_TABLE."
		WHERE `OnclickShowPopup_id` = %d",
		array($did)
	);
	$result = '0';
	$result = $wpdb->get_var($sSql);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong>Oops, selected details doesn't exist (1).</strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('OnclickShowPopup_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_OnclickShowPopup_TABLE."`
					WHERE `OnclickShowPopup_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$OnclickShowPopup_success_msg = TRUE;
			$OnclickShowPopup_success = __('Selected record was successfully deleted.', WP_OnclickShowPopup_UNIQUE_NAME);
		}
	}
	
	if ($OnclickShowPopup_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $OnclickShowPopup_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php echo WP_OnclickShowPopup_TITLE; ?><a class="add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=onclick-show-popup&amp;ac=add">Add New</a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WP_OnclickShowPopup_TABLE."` order by OnclickShowPopup_id desc";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/onclick-show-popup/pages/setting.js"></script>
		<form name="frm_OnclickShowPopup_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="3%" class="check-column" scope="col"><input type="checkbox" name="OnclickShowPopup_group_item[]" /></th>
			<th width="72%" scope="col">Popup Title</th>
            <th width="16%" scope="col">Popup Group</th>
			<th width="9%" scope="col">Display Status</th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="OnclickShowPopup_group_item[]" /></th>
			<th scope="col">Popup Title</th>
            <th scope="col">Popup Group</th>
			<th scope="col">Display Status</th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			$displayisthere = FALSE;
			foreach ($myData as $data)
			{
				if($data['OnclickShowPopup_status'] == 'YES') 
				{
					$displayisthere = TRUE; 
				}
				?>
				<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
					<td align="left"><input type="checkbox" value="<?php echo $data['OnclickShowPopup_id']; ?>" name="OnclickShowPopup_group_item[]"></th>
				  <td><?php echo stripslashes($data['OnclickShowPopup_title']); ?>
					<div class="row-actions">
						<span class="edit"><a title="Edit" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=onclick-show-popup&amp;ac=edit&amp;did=<?php echo $data['OnclickShowPopup_id']; ?>">Edit</a> | </span>
						<span class="trash"><a onClick="javascript:OnclickShowPopup_delete('<?php echo $data['OnclickShowPopup_id']; ?>')" href="javascript:void(0);">Delete</a></span> 
					</div>
				  </td>
					<td><?php echo esc_html(stripslashes($data['OnclickShowPopup_group'])); ?></td>
					<td><?php echo esc_html(stripslashes($data['OnclickShowPopup_status'])); ?></td>
				</tr>
				<?php 
				$i = $i+1; 
				} 
			?>
			<?php 
			if ($displayisthere == FALSE) 
			{ 
				?><tr><td colspan="6" align="center">No records available.</td></tr><?php 
			} 
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('OnclickShowPopup_form_show'); ?>
		<input type="hidden" name="frm_OnclickShowPopup_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=onclick-show-popup&amp;ac=add">Add New</a>
	  <a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=onclick-show-popup&amp;ac=set">Setting Management</a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo WP_OnclickShowPopup_FAV; ?>">Help</a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	  	<h3>Plugin configuration option</h3>
		<ol>
			<li>Add the plugin in the posts or pages using short code.</li>
			<li>Add directly in to the theme using PHP code.</li>
			<li>Drag and drop the widget to your sidebar.</li>
		</ol>
		<p class="description"><?php echo WP_OnclickShowPopup_LINK; ?></p>
	</div>
</div>