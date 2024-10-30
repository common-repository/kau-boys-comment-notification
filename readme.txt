=== Kau-Boy's Comment Notification ===
Contributors: Kau-Boy
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8486283
Tags: admin, comment, comments, notification, feed, rss, author, moderation
Requires at least: 2.7
Stable tag: 1.3.1

This plugin enables blog admins and editors to manage the notification of incoming comments. It offers a special RSS feed with all comments, including those who has to be moderated, with the links to delete, approve or mark them as spam.

A list of all of my plugins can be found on the [WordPress Plugin page](http://kau-boys.com/wordpress-plugins "WordPress Plugins") on my blog [kau-boys.com](http://kau-boys.com).  


== Description ==

This plugin enables blog admins and editors to manage the notification of incoming comments. As WordPress only has the option to notify on every comment, the email account of the admin may recieve many email each day. Notification is also limited to the admin only, so only the admin user will receive an email for incoming comments.

Using the plugin you can subscribe to a RSS feed that contains even comments that has to be moderated. Every feed entry has the links to delete a comment, mark a comment as spam or approve a comment, if the comment has to be moderated. If a comment has been marked as spam, it will no longer appear in the feed.

A list of all of my plugins can be found on the [WordPress Plugin page](http://kau-boys.de/wordpress-plugins?lang=en "WordPress Plugins") on my blog [kau-boys.de](http://kau-boys.de).


== Screenshots ==

1. Screenshot of the feed dashboard widget


== Installation ==

= Installation through WordPress admin pages: = 

1. Go to the admin page `Plugins -> Add New` 
2. Search for `kau-boy` and choose the plugin
3. Choose the action `install`
4. Click on `Install now`
5. Activate the plugin after install has finished (with the link or trough the plugin page)
6. You might have to edit the settings

= Installation using WordPress admin pages: =

1. Download the plugin zip file
2. Go to the admin page `Plugins -> Add New`
3. Choose the `Upload` link under the `Install Plugins` headline
4. Browse for the zip file and click `Install Now`
5. Activate the plugin after install has finished (with the link or trough the plugin page)
6. You might have to edit the settings

= Installation using ftp: =

1. Unzip and upload the files to your `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress
3. You might have to edit the settings


== Frequently Asked Questions ==

= Who can subscribe to the comments feed? =

You can set if only users who has the moderation permission to subscribe, or every user of the blog. Non moderation users will not see the moderation links and they will not see comments that has to be moderated.

= Can I limit the number of mails that I receive for new comments? = 

This feature will be available in one of the next updates. But as digesting emails is more complex, I started with the feed option. 

   
== Change Log ==

* **1.3** Remove line break at bottom of feed to prevent a parse error as described here: http://validator.w3.org/feed/docs/error/WPBlankLine.html
* **1.2** Adding option to hide new WP 2.9 trash comments
* **1.1** Adding nice icons to the feed and an option to hide them
* **1.0.1** Removing "short open tags" which causes error on blog that don't have "short_open_tag" set to "On"
* **1.0** Adding user data (Name, E-Mail, Website) and option to hide them, adding tackback/pingback avatar icon to feed
* **0.6** Adding option to hide all types of comments to build feeds for special needs like a feed only for moderation
* **0.5** Adding the customization option to the dashboard to make it visible to editors
* **0.4** Adding option to include spam comments into feed to recognize false positives marked by Aksimet
* **0.3** Adding links to read the comment in the blog and to reply to the comment
* **0.2** Adding option to customize feed, adding avatars to feed
* **0.1** First stable release