<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

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
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'onclick-show-popup'); ?></strong></p></div><?php
}
else
{
	$OnclickShowPopup_errors = array();
	$OnclickShowPopup_success = '';
	$OnclickShowPopup_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".WP_OnclickShowPopup_TABLE."`
		WHERE `OnclickShowPopup_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'OnclickShowPopup_title' => $data['OnclickShowPopup_title'],
		'OnclickShowPopup_text' => $data['OnclickShowPopup_text'],
		'OnclickShowPopup_status' => $data['OnclickShowPopup_status'],
		'OnclickShowPopup_group' => $data['OnclickShowPopup_group'],
		'OnclickShowPopup_id' => $data['OnclickShowPopup_id']
	);
}
// Form submitted, check the data
if (isset($_POST['OnclickShowPopup_form_submit']) && $_POST['OnclickShowPopup_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('OnclickShowPopup_form_edit');
	
	$form['OnclickShowPopup_title'] = isset($_POST['OnclickShowPopup_title']) ? $_POST['OnclickShowPopup_title'] : '';
	if ($form['OnclickShowPopup_title'] == '')
	{
		$OnclickShowPopup_errors[] = __('Please enter the popup title.', 'onclick-show-popup');
		$OnclickShowPopup_error_found = TRUE;
	}

	$form['OnclickShowPopup_text'] = isset($_POST['OnclickShowPopup_text']) ? $_POST['OnclickShowPopup_text'] : '';
	if ($form['OnclickShowPopup_text'] == '')
	{
		$OnclickShowPopup_errors[] = __('Please enter the popup message.', 'onclick-show-popup');
		$OnclickShowPopup_error_found = TRUE;
	}
	
	$form['OnclickShowPopup_status'] = isset($_POST['OnclickShowPopup_status']) ? $_POST['OnclickShowPopup_status'] : '';
	$form['OnclickShowPopup_group'] = isset($_POST['OnclickShowPopup_group']) ? $_POST['OnclickShowPopup_group'] : '';

	//	No errors found, we can add this Group to the table
	if ($OnclickShowPopup_error_found == FALSE)
	{	
		$sSql = $wpdb->prepare(
				"UPDATE `".WP_OnclickShowPopup_TABLE."`
				SET `OnclickShowPopup_title` = %s,
				`OnclickShowPopup_text` = %s,
				`OnclickShowPopup_status` = %s,
				`OnclickShowPopup_group` = %s
				WHERE OnclickShowPopup_id = %d
				LIMIT 1",
				array($form['OnclickShowPopup_title'], $form['OnclickShowPopup_text'], $form['OnclickShowPopup_status'], $form['OnclickShowPopup_group'], $did)
			);
		$wpdb->query($sSql);
		
		$OnclickShowPopup_success = __('Details was successfully updated.', 'onclick-show-popup');
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
    <p><strong><?php echo $OnclickShowPopup_success; ?> <a href="<?php echo WP_OnclickShowPopup_ADMIN_URL; ?>"><?php _e('Click here to view the details', 'onclick-show-popup'); ?></a></strong></p>
  </div>
  <?php
}
?>
<script language="JavaScript" src="<?php echo WP_OnclickShowPopup_PLUGIN_URL; ?>/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Onclick show popup', 'onclick-show-popup'); ?></h2>
	<form name="OnclickShowPopup_form" method="post" action="#" onsubmit="return OnclickShowPopup_submit()"  >
      <h3><?php _e('Update popup details', 'onclick-show-popup'); ?></h3>
	  
	  <label for="tag-title"><?php _e('Popup title', 'onclick-show-popup'); ?></label>
      <textarea name="OnclickShowPopup_title" id="OnclickShowPopup_title" cols="130" rows="3"><?php echo esc_html(stripslashes($form['OnclickShowPopup_title'])); ?></textarea>
      <p><?php _e('Please enter your popup title.', 'onclick-show-popup'); ?></p>
	  
	  <label for="tag-message"><?php _e('Popup message', 'onclick-show-popup'); ?></label>
      <textarea name="OnclickShowPopup_text" id="OnclickShowPopup_text" cols="130" rows="7"><?php echo esc_html(stripslashes($form['OnclickShowPopup_text'])); ?></textarea>
      <p><?php _e('Please enter your popup message. message to show when popup title clicked.', 'onclick-show-popup'); ?></p>
	  
      <label for="tag-select-gallery-group"><?php _e('Select popup group', 'onclick-show-popup'); ?></label>
      <select name="OnclickShowPopup_group" id="OnclickShowPopup_group">
	  <option value='Select'>Select</option>
	  <?php
		$sSql = "SELECT distinct(OnclickShowPopup_group) as OnclickShowPopup_group FROM `".WP_OnclickShowPopup_TABLE."` order by OnclickShowPopup_group";
		$myDistinctData = array();
		$arrDistinctDatas = array();
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		$i = 0;
		$selected = "";
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
			if(strtoupper($form['OnclickShowPopup_group']) == strtoupper($arrDistinct["OnclickShowPopup_group"]) ) 
			{ 
				$selected = "selected='selected'"; 
			}
			?><option value='<?php echo $arrDistinct["OnclickShowPopup_group"]; ?>' <?php echo $selected; ?>><?php echo $arrDistinct["OnclickShowPopup_group"]; ?></option><?php
			$selected = "";
		}
		?>
      </select>
      <p><?php _e('This is to group the popup message. Select your popup group.', 'onclick-show-popup'); ?></p>
      
	  <label for="tag-display-status"><?php _e('Display status', 'onclick-show-popup'); ?></label>
      <select name="OnclickShowPopup_status" id="OnclickShowPopup_status">
        <option value='Select'>Select</option>
		<option value='YES' <?php if($form['OnclickShowPopup_status']=='YES') { echo 'selected="selected"' ; } ?>>Yes</option>
        <option value='NO' <?php if($form['OnclickShowPopup_status']=='NO') { echo 'selected="selected"' ; } ?>>No</option>
      </select>
      <p><?php _e('Do you want to show this message into the popup window', 'onclick-show-popup'); ?></p>
	  
      <input name="OnclickShowPopup_id" id="OnclickShowPopup_id" type="hidden" value="">
      <input type="hidden" name="OnclickShowPopup_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Update Details', 'onclick-show-popup'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="OnclickShowPopup_redirect()" value="<?php _e('Cancel', 'onclick-show-popup'); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="OnclickShowPopup_help()" value="<?php _e('Help', 'onclick-show-popup'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('OnclickShowPopup_form_edit'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'onclick-show-popup'); ?>
	<a target="_blank" href="<?php echo WP_OnclickShowPopup_FAV; ?>"><?php _e('click here', 'onclick-show-popup'); ?></a>
</p>
</div>