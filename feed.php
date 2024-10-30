<?php
	
	// load WP config file
	require_once ('../../../wp-config.php');
	
	// set the plugin URL
	define('COMMENT_NOTIFICATION_URL', WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)));
	
	// set textdomain for language files
	load_plugin_textdomain('comment-notification', false, dirname(plugin_basename(__FILE__)));
	
	// load the user frm the DB, create a user object for this user and check if he is a moderator
	$user_data = $wpdb->get_results("SELECT * FROM $wpdb->users WHERE user_login = '".$_REQUEST['user_login']."' AND user_pass = '".$_REQUEST['user_pass']."'");
	$user = new WP_User($user_data[0]->ID);
	$is_moderator = $user->has_cap('moderate_comments');
	
	// get request vars and set to default values if they are empty
	$hide_avatars = $_GET['hide_avatars'];
	$hide_user_data = $_GET['hide_user_data'];
	$hide_comments = $_GET['hide_comments'];
	$max_entries = $_GET['max_entries'];
	$hide_icons = $_GET['hide_icons'];
	if(empty($max_entries)) $max_entries = 100;
	
	
	// load some DB options and set defaults if options are empty
	$moderators_only = get_option('kau-boys_comment_notification_moderators_only');
	if(empty($moderators_only)) $moderators_only = 'on';
	
	// if the users doesn't have the permission to moderate feeds, skip the rest of the script	
	if(!$is_moderator && $moderators_only == 'on'){
		die(__("You cannot read this feed as you are not permitted to moderate posts!", 'comment-notification'));
	}
	
	// load all comments from the DB
	$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments ".(!empty($hide_comments)? ' WHERE comment_approved NOT IN ("'.implode('", "', $hide_comments).'")' : '')." ORDER BY comment_date_gmt DESC LIMIT 0, ".$max_entries);
	
	// load the feed template to create the feed 
	require_once('feed-rss2-comments.php');
	
?>