=== Page Redirects - Redirect any Post, Page or Product ===
Contributors: stefanpejcic, pluginsclub
Donate link: https://plugins.club/
Tags: redirect, 301, post redirect, page redirect, page redirects, woocommerce redirect
Requires at least: 5.0
Tested up to: 6.2
Stable tag: 1.2
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Set custom redirect URL for posts, pages and products.

== Description ==

Allows you to set a custom redirect URL for posts, pages and products. Current redirects can be viewed, deleted or searched from an admin page.

For all pages/posts the plugin adds an option meta box to the edit screen where you can specify the redirect location. This type of redirect is useful for many things, including menu items, duplicate posts, or just redirecting a page to a different URL or location on your existing site.



For more free WordPress plugins please visit [plugins.club](https://plugins.club/).


== Installation ==

1. Upload the plugin file to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

You will find 'Page Redirects' option under 'Settings' menu in your WordPress admin panel.

For basic usage, you can also have a look at the [plugin web site](https://plugins.club/wordpress/error_log-file-viewer/).

== Frequently Asked Questions ==

= How to create a new redirect? =

When editing a post/page add URL in the "Redirect URL" field.

= How to delete a redirect? =

When editing a post/page delete URL from the "Redirect URL" field.

= How to view all redirects? =

Settings > Page Redirects

= Should I use a full URL with http:// or https:// ? =

If you are redirecting to an external URL, then yes. If you are just redirecting to another page or post on your site, then no, it is recommended that you use relative URLs whenever possible.

= Do I need to have a Page or Post Created to redirect? =

Yes, redirects can be created only on Posts and Pages.

= How the redirects work? .htaccess file? =

This plugin DOES NOT modify the .htaccess file, but uses the WordPress function wp_redirect(), which is a form of PHP header location redirect.

== Upgrade Notice ==

This is new version 1.0

== Screenshots ==

1. Plugin page displays all current redirects
2. Box to add redirects on the post edit screen

== Changelog ==

= 1.2 =

* Admin page UI changes

= 1.1 =

* Ensured compatibility with WP 6.2
* Additional Security checks
* Separate Settings page
 
 
= 1.0 =

* Initial release
