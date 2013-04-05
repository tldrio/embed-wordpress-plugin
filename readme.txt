=== Embed tldr.io summaries ===
Contributors: tldr.io
Tags: summaries, summary, tldr, tldrs, tldr.io, embed
Requires at least: 3.3
Tested up to: 3.5
Stable tag: trunk
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Embed summaries of any article (including yours) in your posts.

== Description ==

Easily embed summaries of any article in your posts.  

Use the `[tldrio_embed]` shortcode to embed the summary of your own post.  

Use the `[tldrio_embed url]` shortcode to embed the summary of the article with URL `url`. For example: `[tldrio_embed http://paulgraham.com/hw.html]`  

Click on the 'tldr.io' button in the Wordpress editor to include the default shortcode in your post.


== Installation ==

1. Install the 'Embed tldr.io summaries' plugin via the Wordpress.org plugin directory (or directly upload the files to your server)
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You can now use the [tldrio_embed] and [tldrio_embed url] shortcodes (see 'Description')

== Screenshots ==

1. Embed the summary of your post.
2. Embed the summary of any article.
3. Use the tldr.io button to go even faster.

== Frequently Asked Questions ==

= Why does this plugin need to call tldr.io's server on every page it's
used? =

The tldr.io summaries are stored on our servers. They are indexed by the
URL of the article they're the tldr of. So we need the embed widget to
tell our servers the URL corresponding to the requested tldr, so we can
send it to the widget. The calls are secured by SSL, meaning they can't
be read by third parties.

== Changelog ==

= 0.0.1 =
* First functional version
* Ability to embed the summary of the post with a default link for old browsers (IE7 and older)
* Ability to embed the summary of any article
