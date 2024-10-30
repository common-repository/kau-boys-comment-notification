<?php
/*
Plugin Name: Kau-Boy's Comment Notification
Plugin URI: http://kau-boys.de/wordpress/kau-boys-comment-notification-plugin
Description: This plugin enables blog admins and editors to manage the notification of incomming comments. As WordPress only has the option to notify on every comment, the email account of the admins or editors may recieve many email each day.
Version: 1.3.1
Author: Bernhard Kau
Author URI: http://kau-boys.de
*/


define('COMMENT_NOTIFICATION_URL', WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)));

$wp_locale_all = array();

function init_comment_notification(){	
	load_plugin_textdomain('comment-notification', false, dirname(plugin_basename(__FILE__)));
}

function comment_notification_admin_menu(){	
	add_options_page("Kau-Boy's Comment Notification settings", __('Comment Notification', 'comment-notification'), 8, __FILE__, 'comment_notification_admin_settings');
}

function comment_notification_filter_plugin_actions($links, $file){
	static $this_plugin;
	if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
	
	if ($file == $this_plugin){
		$settings_link = '<a href="options-general.php?page=kau-boys-comment-notification/comment-notification.php">'.__('Settings').'</a>';
		array_unshift($links, $settings_link);
	}
	return $links;
}

function comment_notification_admin_settings(){
	global $current_user;
	
	// load user information for feed link
	get_currentuserinfo();
	
	if(isset($_POST['save'])){
		update_option('kau-boys_comment_notification_moderators_only', ($_POST['kau-boys_comment_notification_moderators_only']? 'on' : 'off'));
		$settings_saved = true;
	}
	$moderators_only = get_option('kau-boys_comment_notification_moderators_only');
	
	// set default if values haven't been recieved from the database
	if(empty($moderators_only)) $moderators_only = 'on';
?>

<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Kau-Boy's Comment Notification</h2>
	<?php if($settings_saved) : ?>
	<div id="message" class="updated fade"><p><strong><?php _e('Options saved.') ?></strong></p></div>
	<?php endif ?>
	<p>
		<?php _e('Here you can customize the plugin for your needs.', 'comment-notification') ?>
	</p>
	<form method="post" action="">
		<p>
			<input type="checkbox" name="kau-boys_comment_notification_moderators_only" id="kau-boys_comment_notification_moderators_only"<?php echo ($moderators_only == 'on')? ' checked="checked"' : '' ?>/>
			<label for="kau-boys_comment_notification_moderators_only"><?php _e('Allow only moderators to subscribe to the feed', 'comment-notification') ?></label>
		</p>
		<p class="submit">
			<input class="button-primary" name="save" type="submit" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>

<?php
}

function comment_notification_dashboard_setup(){	
	wp_add_dashboard_widget('comment_notification_dashboard_widget', __('Comment Notification RSS Feed', 'comment-notification'), 'comment_notification_dashboard_widget');
}

function comment_notification_dashboard_widget(){
	global $current_user;
	
	// load user information for feed link
	get_currentuserinfo();
	
?>
<h4><img alt="rss feed icon" src="<?php echo includes_url('images/rss.png') ?>" />  <?php _e('Customize Comment Notification RSS feed', 'comment-notification') ?></h4>
	<form action="<?php echo COMMENT_NOTIFICATION_URL ?>feed.php" method="get">
		<p>	
			<input type="hidden" name="user_login" value="<?php echo $current_user->user_login ?>" />
			<input type="hidden" name="user_pass" value="<?php echo $current_user->user_pass ?>" />
			<p>
				<b><?php _e('Limit Feed entries', 'comment-notification') ?></b>
				<br />
				<label for="max_entries" style="width: 200px; display: inline-block;"><?php _e('Max. number of feed entries', 'comment-notification') ?></label>
				<input type="text" id="max_entries" name="max_entries" value="100" style="width: 50px" />
			</p>
			<p>
				<b><?php _e('Feed content', 'comment-notification') ?></b>
				<br />
				<input type="checkbox" id="hide_avatars" name="hide_avatars" />
				<label for="hide_avatars"><?php _e('Hide avatars', 'comment-notification') ?></label>
				<br />
				<input type="checkbox" id="hide_user_data" name="hide_user_data" />
				<label for="hide_user_data"><?php _e('Hide user data', 'comment-notification') ?></label>
				<br />
				<input type="checkbox" id="hide_icons" name="hide_icons" />
				<label for="hide_icons"><?php _e('Hide icons', 'comment-notification') ?></label>
			</p>
			<p>
				<b><?php _e('Comment types in Feed', 'comment-notification') ?></b>
				<br />
				<input type="checkbox" id="hide_comments_approved" name="hide_comments[]" value="1" />
				<label for="hide_comments_approved"><?php _e('Hide approved comments', 'comment-notification') ?></label>
				<br />
				<input type="checkbox" id="hide_comments_moderation" name="hide_comments[]" value="0" />
				<label for="hide_comments_moderation"><?php _e('Hide moderation comments', 'comment-notification') ?></label>
				<br />
				<input type="checkbox" id="hide_comments_spam" name="hide_comments[]" value="spam" />
				<label for="hide_comments_spam"><?php _e('Hide spam comments', 'comment-notification') ?></label>
				<br />
				<input type="checkbox" id="hide_comments_trash" name="hide_comments[]" value="trash" />
				<label for="hide_comments_trash"><?php _e('Hide trash comments', 'comment-notification') ?></label>
				<br />
				<span class="description"><?php _e('Showing spam comments is useful, if you activated Akismet and you want to verify that no regular comment has been marked as spam. Hiding all comments but moderated is useful for a feed only for moderation.', 'comment-notification') ?></span>
			</p>
		</p>
		<p class="submit">
			<input class="button-primary" name="save" type="submit" value="<?php _e('Open custom feed', 'comment-notification') ?>" />
		</p>
	</form>
<?php
}

add_action('init', 'init_comment_notification');
add_action('admin_menu', 'comment_notification_admin_menu');
add_action('wp_dashboard_setup', 'comment_notification_dashboard_setup');
add_filter('plugin_action_links', 'comment_notification_filter_plugin_actions', 10, 2);

?>