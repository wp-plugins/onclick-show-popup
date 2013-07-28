<div class="wrap">
<?php
$OnclickShowPopup_errors = array();
$OnclickShowPopup_success = '';
$OnclickShowPopup_error_found = FALSE;

// Preset the form fields
$form = array(
	'OnclickShowPopup_title' => '',
	'OnclickShowPopup_text' => '',
	'OnclickShowPopup_status' => '',
	'OnclickShowPopup_group' => '',
	'OnclickShowPopup_extra1' => '',
	'OnclickShowPopup_extra2' => '',
	'OnclickShowPopup_date' => '',
	'OnclickShowPopup_id' => ''
);

// Form submitted, check the data
if (isset($_POST['OnclickShowPopup_form_submit']) && $_POST['OnclickShowPopup_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('OnclickShowPopup_form_add');
	
	$form['OnclickShowPopup_title'] = isset($_POST['OnclickShowPopup_title']) ? $_POST['OnclickShowPopup_title'] : '';
	if ($form['OnclickShowPopup_title'] == '')
	{
		$OnclickShowPopup_errors[] = __('Please enter the popup title.', WP_OnclickShowPopup_UNIQUE_NAME);
		$OnclickShowPopup_error_found = TRUE;
	}

	$form['OnclickShowPopup_text'] = isset($_POST['OnclickShowPopup_text']) ? $_POST['OnclickShowPopup_text'] : '';
	if ($form['OnclickShowPopup_text'] == '')
	{
		$OnclickShowPopup_errors[] = __('Please enter the popup message.', WP_OnclickShowPopup_UNIQUE_NAME);
		$OnclickShowPopup_error_found = TRUE;
	}
	
	$form['OnclickShowPopup_status'] = isset($_POST['OnclickShowPopup_status']) ? $_POST['OnclickShowPopup_status'] : '';
	$form['OnclickShowPopup_group'] = isset($_POST['OnclickShowPopup_group']) ? $_POST['OnclickShowPopup_group'] : '';

	//	No errors found, we can add this Group to the table
	if ($OnclickShowPopup_error_found == FALSE)
	{
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_OnclickShowPopup_TABLE."`
			(`OnclickShowPopup_title`, `OnclickShowPopup_text`, `OnclickShowPopup_status`, `OnclickShowPopup_group`)
			VALUES(%s, %s, %s, %s)",
			array($form['OnclickShowPopup_title'], $form['OnclickShowPopup_text'], $form['OnclickShowPopup_status'], $form['OnclickShowPopup_group'])
		);
		$wpdb->query($sql);
		
		$OnclickShowPopup_success = __('New details was successfully added.', WP_OnclickShowPopup_UNIQUE_NAME);
		
		// Reset the form fields
		$form = array(
			'OnclickShowPopup_title' => '',
			'OnclickShowPopup_text' => '',
			'OnclickShowPopup_status' => '',
			'OnclickShowPopup_group' => '',
			'OnclickShowPopup_extra1' => '',
			'OnclickShowPopup_extra2' => '',
			'OnclickShowPopup_date' => '',
			'OnclickShowPopup_id' => ''
		);
	}
}

if ($OnclickShowPopup_error_found == TRUE && isset($OnclickShowPopup_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $OnclickShowPopup_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($OnclickShowPopup_error_found == FALSE && strlen($OnclickShowPopup_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $OnclickShowPopup_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=onclick-show-popup">Click here</a> to view the details</strong></p>
	  </div>
	  <?php
	}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/onclick-show-popup/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo WP_OnclickShowPopup_TITLE; ?></h2>
	<form name="OnclickShowPopup_form" method="post" action="#" onsubmit="return OnclickShowPopup_submit()"  >
      <h3>Add new popup details</h3>
      
	  <label for="tag-title">Popup title</label>
      <textarea name="OnclickShowPopup_title" id="OnclickShowPopup_title" cols="130" rows="3"></textarea>
      <p>Please enter your popup title.</p>
	  
	  <label for="tag-message">Popup message</label>
      <textarea name="OnclickShowPopup_text" id="OnclickShowPopup_text" cols="130" rows="7"></textarea>
      <p>Please enter your popup message. message to show when popup title clicked.</p>
	  
      <label for="tag-select-gallery-group">Select popup group</label>
      <select name="OnclickShowPopup_group" id="OnclickShowPopup_group">
	  <option value='Select'>Select</option>
	  <?php
		$sSql = "SELECT distinct(OnclickShowPopup_group) as OnclickShowPopup_group FROM `".WP_OnclickShowPopup_TABLE."` order by OnclickShowPopup_group";
		$myDistinctData = array();
		$arrDistinctDatas = array();
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		$i = 0;
		foreach ($myDistinctData as $DistinctData)
		{
			$arrDistinctData[$i]["OnclickShowPopup_group"] = strtoupper($DistinctData['OnclickShowPopup_group']);
			$i = $i+1;
		}
		for($j=$i; $j<$i+5; $j++)
		{
			$arrDistinctData[$j]["OnclickShowPopup_group"] = "GROUP" . $j;
		}
		$arrDistinctDatas = array_unique($arrDistinctData, SORT_REGULAR);
		foreach ($arrDistinctDatas as $arrDistinct)
		{
			?><option value='<?php echo $arrDistinct["OnclickShowPopup_group"]; ?>'><?php echo $arrDistinct["OnclickShowPopup_group"]; ?></option><?php
		}
		?>
      </select>
      <p>This is to group the popup message. Select your popup group.</p>
      
	  <label for="tag-display-status">Display status</label>
      <select name="OnclickShowPopup_status" id="OnclickShowPopup_status">
        <option value='Select'>Select</option>
		<option value='YES'>Yes</option>
        <option value='NO'>No</option>
      </select>
      <p>Do you want to show this message into the popup window</p>
	  
      <input name="OnclickShowPopup_id" id="OnclickShowPopup_id" type="hidden" value="">
      <input type="hidden" name="OnclickShowPopup_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="Insert Details" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="OnclickShowPopup_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="OnclickShowPopup_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('OnclickShowPopup_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo WP_OnclickShowPopup_LINK; ?></p>
</div>