<?php
/**
 * RSS2 Feed Template for displaying RSS2 Comments feed.
 *
 * @package WordPress
 */

header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?><rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	<?php do_action('rss2_ns'); do_action('rss2_comments_ns'); ?>
	>
<channel>
	<title><?php
		if ( is_singular() )
			printf(ent2ncr(__('Comments on: %s')), get_the_title_rss());
		elseif ( is_search() )
			printf(ent2ncr(__('Comments for %s searching on %s')), get_bloginfo_rss( 'name' ), esc_attr($wp_query->query_vars['s']));
		else
			printf(ent2ncr(__('Comments for %s')), get_bloginfo_rss( 'name' ) . get_wp_title_rss());
	?></title>
	<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
	<link><?php (is_single()) ? the_permalink_rss() : bloginfo_rss("url") ?></link>
	<description><?php bloginfo_rss("description") ?></description>
	<lastBuildDate><?php echo mysql2date('r', get_lastcommentmodified('GMT')); ?></lastBuildDate>
	<?php the_generator( 'rss2' ); ?>
	<sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
	<sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
	<?php do_action('commentsrss2_head'); ?>
<?php
foreach($comments as $comment) : 
	$comment_post = get_post($comment->comment_post_ID);
	//get_post_custom($comment_post->ID);
?>
	<item>
		<title>
			<?php
			if($comment->comment_approved == 'spam'){
				_e('*SPAM* ', 'comment-notification');
			}
			if($comment->comment_approved == 'trash'){
				_e('~TRASH~ ', 'comment-notification');
			}
			if($comment->comment_approved != 1 && $comment->comment_approved != 'spam' && $comment->comment_approved != 'trash'){
				_e('!MODERATE! ', 'comment-notification');
			}
			if($comment->comment_type == 'pingback'){
				_e('+PINGBACK+ ', 'comment-notification');
			}
			if($comment->comment_type == 'trackback'){
				_e('#TRACKBACK# ', 'comment-notification');
			}
			if ( !is_singular() ) {
				$title = get_the_title($comment_post->ID);
				$title = apply_filters('the_title_rss', $title);
				printf(ent2ncr(__('Comment on %1$s by %2$s')), $title, get_comment_author_rss());
			} else {
				printf(ent2ncr(__('By: %s')), get_comment_author_rss());
			}
		?></title>
		<link><?php comment_link() ?></link>
		<dc:creator><?php echo get_comment_author_rss() ?></dc:creator>
		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_comment_time('Y-m-d H:i:s', true, false), false); ?></pubDate>
		<guid isPermaLink="false"><?php comment_guid() ?></guid>
		<description><![CDATA[
			<?php if(!$hide_avatars) : ?>
				<?php if($comment->comment_type == 'pingback' || $comment->comment_type == 'trackback') : ?>
					<img height="48" align="right" width="48" class="avatar avatar-48 photo" src="<?php echo COMMENT_NOTIFICATION_URL ?>images/trackback.png" alt="" title=""/>
				<?php else : ?>
					<?php echo str_replace('<img', '<img align="right" title=""', get_avatar($comment, 48)); ?>
				<?php endif ?>
			<?php endif; ?>
			<?php if(!$hide_user_data) : ?>
			<p>
				<?php if(!empty($comment->comment_author)) : ?>
					<?php if(!$hide_icons) : ?>
						<img src="<?php echo COMMENT_NOTIFICATION_URL ?>images/user.png" width="16 height="16" alt="" title="" />
					<?php endif ?>
					<?php _e('Name') ?>: <?php comment_author() ?><br />
				<?php endif ?>
				<?php if(!empty($comment->comment_author_email)) : ?>
					<?php if(!$hide_icons) : ?>
						<img src="<?php echo COMMENT_NOTIFICATION_URL ?>images/email.png" width="16 height="16" alt="" title="" />
					<?php endif ?>
					<?php _e('E-Mail') ?>: <?php comment_author_email_link() ?><br />
				<?php endif ?>
				<?php if(!empty($comment->comment_author_url)) : ?>
					<?php if(!$hide_icons) : ?>
						<img src="<?php echo COMMENT_NOTIFICATION_URL ?>images/house.png" width="16 height="16" alt="" title="" />
					<?php endif; ?>
					<?php _e('Website') ?>: <?php comment_author_url_link() ?><br />
				<?php endif ?>
			</p>
			<?php endif ?>
				<?php comment_text(); ?>
			<p>
			<?php if($is_moderator) : ?>
				<?php if($comment->comment_approved != 1) : ?>
				<?php if(!$hide_icons) : ?>
						<img src="<?php echo COMMENT_NOTIFICATION_URL ?>images/accept.png" width="16 height="16" alt="" title="" />
				<?php endif; ?>
				<a href="<?php echo admin_url("comment.php?action=mac&c=".get_comment_id()) ?>"><?php _e('Approve it', 'comment-notification'); ?></a>
				|
				<?php endif; ?>
				<?php if(!$hide_icons) : ?>
						<img src="<?php echo COMMENT_NOTIFICATION_URL ?>images/delete.png" width="16 height="16" alt="" title="" />
				<?php endif; ?>
				<a href="<?php echo admin_url("comment.php?action=cdc&c=".get_comment_id()) ?>"><?php _e('Delete it', 'comment-notification'); ?></a>
				<?php if($comment->comment_approved != 'spam') : ?>
				|
				<?php if(!$hide_icons) : ?>
						<img src="<?php echo COMMENT_NOTIFICATION_URL ?>images/shield_go.png" width="16 height="16" alt="" title="" />
				<?php endif; ?>
				<a href="<?php echo admin_url("comment.php?action=cdc&dt=spam&c=".get_comment_id()) ?>"><?php _e('Spam it', 'comment-notification'); ?></a>
				|
				<?php if(!$hide_icons) : ?>
						<img src="<?php echo COMMENT_NOTIFICATION_URL ?>images/comment.png" width="16 height="16" alt="" title="" />
				<?php endif; ?>
				<a href="<?php echo get_comment_link($comment) ?>"><?php _e('Read it', 'comment-notification'); ?></a>
				|
				<?php if(!$hide_icons) : ?>
						<img src="<?php echo COMMENT_NOTIFICATION_URL ?>images/comments_add.png" width="16 height="16" alt="" title="" />
				<?php endif; ?>
				<a href="<?php echo esc_url(add_query_arg('replytocom', get_comment_id(), str_replace('#comment-'.get_comment_id(), '', get_comment_link($comment))))."#respond" ?>"><?php _e('Reply to', 'comment-notification'); ?></a>
				<?php endif; ?>
			<?php endif; ?>
			</p>
		]]></description>
<?php 
	do_action('commentrss2_item', $comment->comment_ID, $comment_post->ID);
?>
	</item>
<?php endforeach; ?>
</channel>
</rss>
