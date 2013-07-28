<?php

/*
Plugin Name: Onclick show popup
Plugin URI: http://www.gopiplus.com/work/2011/12/17/wordpress-plugin-onclick-show-popup-for-content/
Description: Sometimes its useful to add a pop up to your website to show your ads, special announcement and offers. Using this plug-in you can creates unblockable, dynamic and fully configurable popups for your blog.
Author: Gopi.R
Version: 6.0
Author URI: http://www.gopiplus.com/work/2011/12/17/wordpress-plugin-onclick-show-popup-for-content/
Donate link: http://www.gopiplus.com/work/2011/12/17/wordpress-plugin-onclick-show-popup-for-content/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb, $wp_version;
define("WP_OnclickShowPopup_TABLE", $wpdb->prefix . "onclick_show_popup");

define("WP_OnclickShowPopup_UNIQUE_NAME", "onclick-show-popup");
define("WP_OnclickShowPopup_TITLE", "Onclick show popup");
define('WP_OnclickShowPopup_FAV', 'http://www.gopiplus.com/work/2011/12/17/wordpress-plugin-onclick-show-popup-for-content/');
define('WP_OnclickShowPopup_LINK', 'Check official website for more information <a target="_blank" href="'.WP_OnclickShowPopup_FAV.'">click here</a>');


if (!session_id()) { session_start(); }

function OnclickShowPopup()
{
	
	global $wpdb;
	$OnclickShowPopup_widget = get_option('OnclickShowPopup_widget');
	$OnclickShowPopup_random = get_option('OnclickShowPopup_random');
	$OnclickShowPopup_theme = get_option('OnclickShowPopup_theme');
	
	$sSql = "select OnclickShowPopup_title,OnclickShowPopup_text from ".WP_OnclickShowPopup_TABLE." where OnclickShowPopup_status='YES'";
	
	if($OnclickShowPopup_widget <> "")
	{
		 $sSql = $sSql . " and OnclickShowPopup_group='".$OnclickShowPopup_widget."'";
	}
	
	if($OnclickShowPopup_random == "YES")
	{
		$sSql = $sSql . " Order by rand()";
	}
	
	$data = $wpdb->get_results($sSql);
	$counter = 0;
	$li = "";
	$div = "";
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$OnclickShowPopup_title = stripslashes($data->OnclickShowPopup_title);
			$OnclickShowPopup_text = stripslashes($data->OnclickShowPopup_text);
			$OnclickShowPopup_text = str_replace("\r\n", "<br />", $OnclickShowPopup_text);
			
			$li = $li . '<li><a href="#inline_demo'.$counter.'" rel="prettyPhoto['.$OnclickShowPopup_theme.']">'.$OnclickShowPopup_title.'</a></li>';
			
			
			$div = $div . '<div id="inline_demo'.$counter.'" style="display:none;">'.$OnclickShowPopup_text.'</div>';
			$counter = $counter + 1;
		}
	}
	else
	{
		$PopUpData = "No content available in the db with the group name " . $OnclickShowPopup_widget . ". Please check the plugin page or in the admin to find more info.";
	}
	
	
	?>
<ul>
  <?php echo @$li; ?>
</ul>
<?php echo @$div; ?> 
<script type="text/javascript" charset="utf-8">
  jQuery(document).ready(function(){
    jQuery("a[rel^='prettyPhoto']").prettyPhoto({
overlay_gallery: false, "theme": '<?php echo $OnclickShowPopup_theme; ?>', social_tools: false, autoplay_slideshow: false
});
  });
</script>
<?php
}


function OnclickShowPopup_activation()
{
	
	global $wpdb;
	
	$t1 = "This is the demo for Onclick show popup plugin.";
	$t2 = "This is the demo for Onclick show popup plugin.";
	$t3 = "This is the demo for Onclick show popup plugin.";
	$t4 = "This is the demo for Onclick show popup plugin.";
	
	$c1 = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';
	
	if($wpdb->get_var("show tables like '". WP_OnclickShowPopup_TABLE . "'") != WP_OnclickShowPopup_TABLE) 
	{
		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `". WP_OnclickShowPopup_TABLE . "` (
			  `OnclickShowPopup_id` int(11) NOT NULL auto_increment,
			  `OnclickShowPopup_title` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
			  `OnclickShowPopup_text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
			  `OnclickShowPopup_status` char(3) NOT NULL default 'No',
			  `OnclickShowPopup_group` VARCHAR( 100 ) NOT NULL,
			  `OnclickShowPopup_extra1` VARCHAR( 100 ) NOT NULL,
			  `OnclickShowPopup_extra2` VARCHAR( 100 ) NOT NULL,
			  `OnclickShowPopup_date` datetime NOT NULL default '0000-00-00 00:00:00',
			  PRIMARY KEY  (`OnclickShowPopup_id`) )
			");
		$iIns = "INSERT INTO `". WP_OnclickShowPopup_TABLE . "` (`OnclickShowPopup_title`, `OnclickShowPopup_text`, `OnclickShowPopup_status`, `OnclickShowPopup_group`, `OnclickShowPopup_date`)"; 
		$sSql = $iIns . " VALUES ('$t1', '$c1', 'YES', 'Group1', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $iIns . " VALUES ('$t2', '$c1', 'YES', 'Group1', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $iIns . " VALUES ('$t3', '$c1', 'YES', 'Group1', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $iIns . " VALUES ('$t4', '$c1', 'YES', 'Group1', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}
	
	add_option('OnclickShowPopup_title', "Onclick show popup");
	add_option('OnclickShowPopup_theme', "light_rounded");
	add_option('OnclickShowPopup_widget', "Group1");
	add_option('OnclickShowPopup_title_yes', "YES");
	add_option('OnclickShowPopup_random', "YES");
}

function OnclickShowPopup_deactivate() 
{

}

function OnclickShowPopup_add_to_menu() 
{
	if (is_admin()) 
	{
		add_options_page('Onclick show popup', 'Onclick show popup', 'manage_options', 'onclick-show-popup', 'OnclickShowPopup_admin_options' );
	}
}

function OnclickShowPopup_admin_options() 
{
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			include('pages/content-management-edit.php');
			break;
		case 'add':
			include('pages/content-management-add.php');
			break;
		case 'set':
			include('pages/content-setting.php');
			break;
		default:
			include('pages/content-management-show.php');
			break;
	}
}

function OnclickShowPopup_widget_control() 
{
	echo '<p>Onclick show popup.</p>';
}

function OnclickShowPopup_plugins_loaded()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('onclick-show-popup', 'Onclick show popup', 'OnclickShowPopup_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control('onclick-show-popup', array('Onclick show popup', 'widgets'), 'OnclickShowPopup_widget_control');
	} 
}

function OnclickShowPopup_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	if(get_option('OnclickShowPopup_title_yes') == "YES")
	{
		echo get_option('OnclickShowPopup_title');
	}
	echo $after_title;
	OnclickShowPopup();
	echo $after_widget;
}

function OnclickShowPopup_Group($number) 
{
	switch ($number) 
	{ 
		case 1: 
			$group = "GROUP1";
			break;
		case 2: 
			$group = "GROUP2";
			break;
		case 3: 
			$group = "GROUP3";
			break;
		case 4: 
			$group = "GROUP4";
			break;
		case 5: 
			$group = "GROUP5";
			break;
		case 6: 
			$group = "GROUP6";
			break;
		case 7: 
			$group = "GROUP7";
			break;
		case 8: 
			$group = "GROUP8";
			break;
		case 9: 
			$group = "GROUP9";
			break;
		case 0: 
			$group = "GROUP0";
			break;
		default:
			$group = "GROUP1";
	}
	return $group;
}

function OnclickShowPopup_shortcode( $atts ) 
{
	
	global $wpdb;
	//[onclick-show-popup group="1"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$group = OnclickShowPopup_Group($atts['group']);
	
	$OnclickShowPopup_widget = @$group;
	$OnclickShowPopup_random = get_option('OnclickShowPopup_random');
	$OnclickShowPopup_theme = get_option('OnclickShowPopup_theme');
	
	$sSql = "select OnclickShowPopup_title,OnclickShowPopup_text from ".WP_OnclickShowPopup_TABLE." where OnclickShowPopup_status='YES'";
	
	if($OnclickShowPopup_widget <> "")
	{
		 $sSql = $sSql . " and OnclickShowPopup_group='".$OnclickShowPopup_widget."'";
	}
	
	if($OnclickShowPopup_random == "YES")
	{
		$sSql = $sSql . " Order by rand();";
	}
	
	$data = $wpdb->get_results($sSql);
	$counter = 0;
	$li = "";
	$div = "";
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$OnclickShowPopup_title = stripslashes($data->OnclickShowPopup_title);
			$OnclickShowPopup_text = stripslashes($data->OnclickShowPopup_text);
			$OnclickShowPopup_text = str_replace("\r\n", "<br />", $OnclickShowPopup_text);
			
			$li = $li . '<li><a href="#inline_demo'.$counter.'" rel="prettyPhoto['.$OnclickShowPopup_theme.$group.']">'.$OnclickShowPopup_title.'</a></li>';
			
			
			$div = $div . '<div id="inline_demo'.$counter.'" style="display:none;">'.$OnclickShowPopup_text.'</div>';
			$counter = $counter + 1;
		}
	}
	
	$prettyPhoto = "'prettyPhoto'";
	$theme = "'".$OnclickShowPopup_theme."'";
	
	$OnclickShowPopup = '<ul>'.$li.'</ul>';
	$OnclickShowPopup = $OnclickShowPopup . $div; 
	$OnclickShowPopup = $OnclickShowPopup . '<script type="text/javascript" charset="utf-8">jQuery(document).ready(function(){jQuery("a[rel^='.$prettyPhoto.']").prettyPhoto({overlay_gallery: false, "theme": '.$theme.', social_tools: false});});</script>';

	return $OnclickShowPopup;	
}

function OnclickShowPopup_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'jquery');
		wp_enqueue_style( 'prettyPhoto', get_option('siteurl').'/wp-content/plugins/onclick-show-popup/css/prettyPhoto.css','','','screen');
		wp_enqueue_script( 'jquery.prettyPhoto', get_option('siteurl').'/wp-content/plugins/onclick-show-popup/js/jquery.prettyPhoto.js');
	}	
}

add_shortcode( 'onclick-show-popup', 'OnclickShowPopup_shortcode' );
add_action('admin_menu', 'OnclickShowPopup_add_to_menu');
add_action('wp_enqueue_scripts', 'OnclickShowPopup_add_javascript_files');
register_activation_hook(__FILE__, 'OnclickShowPopup_activation');
add_action("plugins_loaded", "OnclickShowPopup_plugins_loaded");
register_deactivation_hook( __FILE__, 'OnclickShowPopup_deactivate' );
?>