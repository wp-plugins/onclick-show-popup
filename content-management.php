<!--
/**
 *     Onclick show popup
 *     http://www.gopiplus.com/work/2011/12/17/wordpress-plugin-onclick-show-popup-for-content/
 *     Copyright (C) 2011 - 2013 www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
-->

<div class="wrap">
  <?php
  	global $wpdb;
    @$mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=onclick-show-popup/content-management.php";
    @$DID=@$_GET["DID"];
    @$AC=@$_GET["AC"];
    @$submittext = "Insert Message";
	if($AC <> "DEL" and trim(@$_POST['OnclickShowPopup_text']) <>"")
    {
			if($_POST['OnclickShowPopup_id'] == "" )
			{
					$sql = "insert into ".WP_OnclickShowPopup_TABLE.""
					. " set `OnclickShowPopup_text` = '" . mysql_real_escape_string(trim($_POST['OnclickShowPopup_text']))
					. "', `OnclickShowPopup_title` = '" . $_POST['OnclickShowPopup_title']
					. "', `OnclickShowPopup_status` = '" . $_POST['OnclickShowPopup_status']
					. "', `OnclickShowPopup_group` = '" . $_POST['OnclickShowPopup_group']
					. "'";	
			}
			else
			{
					$sql = "update ".WP_OnclickShowPopup_TABLE.""
					. " set `OnclickShowPopup_text` = '" . mysql_real_escape_string(trim($_POST['OnclickShowPopup_text']))
					. "', `OnclickShowPopup_title` = '" . $_POST['OnclickShowPopup_title']
					. "', `OnclickShowPopup_status` = '" . $_POST['OnclickShowPopup_status']
					. "', `OnclickShowPopup_group` = '" . $_POST['OnclickShowPopup_group']
					. "' where `OnclickShowPopup_id` = '" . $_POST['OnclickShowPopup_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_OnclickShowPopup_TABLE." where OnclickShowPopup_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".WP_OnclickShowPopup_TABLE." where OnclickShowPopup_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $OnclickShowPopup_id_x = htmlspecialchars(stripslashes($data->OnclickShowPopup_id)); 
		if ( !empty($data) ) $OnclickShowPopup_title_x = htmlspecialchars(stripslashes($data->OnclickShowPopup_title));
        if ( !empty($data) ) $OnclickShowPopup_text_x = htmlspecialchars(stripslashes($data->OnclickShowPopup_text));
        if ( !empty($data) ) $OnclickShowPopup_status_x = htmlspecialchars(stripslashes($data->OnclickShowPopup_status));
		if ( !empty($data) ) $OnclickShowPopup_group_x = htmlspecialchars(stripslashes($data->OnclickShowPopup_group));
        $submittext = "Update Message";
    }
    ?>
  <h2>Onclick show popup</h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/onclick-show-popup/setting.js"></script>
  <form name="OnclickShowPopup_form" method="post" action="<?php echo $mainurl; ?>" onsubmit="return OnclickShowPopup_submit()"  >
    <table width="100%">
      <tr>
        <td colspan="3" align="left" valign="middle">Enter the popup title:</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="middle"><textarea name="OnclickShowPopup_title" id="OnclickShowPopup_title" cols="150" rows="5"><?php echo @$OnclickShowPopup_title_x; ?></textarea></td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="middle">Enter the popup message (Can enter HTML content also):</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="middle"><textarea name="OnclickShowPopup_text" id="OnclickShowPopup_text" cols="150" rows="12"><?php echo @$OnclickShowPopup_text_x; ?></textarea></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Display Status:</td>
        <td align="left" valign="middle">Group Name:</td>
      </tr>
      <tr>
        <td width="11%" align="left" valign="middle"><select style="width:100px;" name="OnclickShowPopup_status" id="OnclickShowPopup_status">
            <option value="">Select</option>
            <option value='YES' <?php if(@$OnclickShowPopup_status_x=='YES') { echo 'selected' ; } ?>>Yes</option>
            <option value='NO' <?php if(@$OnclickShowPopup_status_x=='NO') { echo 'selected' ; } ?>>No</option>
          </select></td>
        <td width="89%" align="left" valign="middle">
        <select style="width:100px;"  name="OnclickShowPopup_group" id="OnclickShowPopup_group">
            <option value='Group1' <?php if(@$OnclickShowPopup_group_x=='Group1') { echo 'selected' ; } ?>>Group1</option>
            <option value='Group2' <?php if(@$OnclickShowPopup_group_x=='Group2') { echo 'selected' ; } ?>>Group2</option>
            <option value='Group3' <?php if(@$OnclickShowPopup_group_x=='Group3') { echo 'selected' ; } ?>>Group3</option>
            <option value='Group4' <?php if(@$OnclickShowPopup_group_x=='Group4') { echo 'selected' ; } ?>>Group4</option>
            <option value='Group5' <?php if(@$OnclickShowPopup_group_x=='Group5') { echo 'selected' ; } ?>>Group5</option>
            <option value='Group6' <?php if(@$OnclickShowPopup_group_x=='Group6') { echo 'selected' ; } ?>>Group6</option>
            <option value='Group7' <?php if(@$OnclickShowPopup_group_x=='Group7') { echo 'selected' ; } ?>>Group7</option>
            <option value='Group8' <?php if(@$OnclickShowPopup_group_x=='Group8') { echo 'selected' ; } ?>>Group8</option>
            <option value='Group9' <?php if(@$OnclickShowPopup_group_x=='Group9') { echo 'selected' ; } ?>>Group9</option>
            <option value='Group0' <?php if(@$OnclickShowPopup_group_x=='Group0') { echo 'selected' ; } ?>>Group0</option>
          </select>
        </td>
      </tr>
      <tr>
        <td height="40" colspan="3" align="left" valign="bottom"><table width="100%">
            <tr>
              <td width="50%" align="left"><input name="publish" lang="publish" class="button-primary" value="<?php echo @$submittext?>" type="submit" />
                <input name="publish" lang="publish" class="button-primary" onclick="_OnclickShowPopup_redirect()" value="Cancel" type="button" /></td>
              <td width="50%" align="right"><div style="float:right;">
                  <input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=onclick-show-popup/content-management.php'" value="Go to - Content Management" type="button" />
                  <input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=onclick-show-popup/onclick-show-popup.php'" value="Go to - Popup Setting" type="button" />
				  <input name="Help" lang="publish" class="button-primary" onclick="_OnclickShowPopup_help()" value="Help" type="button" />
                </div></td>
            </tr>
          </table></td>
      </tr>
      <input name="OnclickShowPopup_id" id="OnclickShowPopup_id" type="hidden" value="<?php echo @$OnclickShowPopup_id_x; ?>">
    </table>
  </form>
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".WP_OnclickShowPopup_TABLE." order by OnclickShowPopup_id");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="OnclickShowPopup_Display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="3%" align="left" scope="col">ID</th>
            <th width="65%" align="left" scope="col">Popup Title</th>
            <th width="11%" align="left" scope="col">Group</th>
            <th width="7%" align="left" scope="col">Display</th>
            <th width="8%" align="left" scope="col">Action</th>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
		if($data->OnclickShowPopup_status=='YES') { $displayisthere="True"; }
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->OnclickShowPopup_id)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->OnclickShowPopup_title)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->OnclickShowPopup_group)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->OnclickShowPopup_status)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=onclick-show-popup/content-management.php&DID=<?php echo($data->OnclickShowPopup_id); ?>">Edit</a> &nbsp; <a onClick="javascript:_OnclickShowPopup_delete('<?php echo($data->OnclickShowPopup_id); ?>')" href="javascript:void(0);">Delete</a></td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="6" align="center" style="color:#FF0000" valign="middle">No message available with display status 'Yes'!' </td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
  <table style="width:100%;text-align:right;"><tr><td>
    <input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=onclick-show-popup/content-management.php'" value="Go to - Content Management" type="button" />
    <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=onclick-show-popup/onclick-show-popup.php'" value="Go to - Popup Setting" type="button" />
	<input name="Help1" lang="publish" class="button-primary" onclick="_OnclickShowPopup_help()" value="Help" type="button" />
 </td></tr></table>
  <?php include_once("help.php"); ?>
</div>
