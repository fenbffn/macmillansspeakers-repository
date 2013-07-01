=== WP Title 2 ===
Contributors: IckataNET
Tags: title, heading, subheading, multilingual, cms, wp-title-2, qtranslate, language, post, page, custom post type, links, navigation
Requires at least: 3.0
Tested up to: 3.2
Stable tag: "trunk"

This plugin allows you to add and edit a Heading for your Posts, Pages and Custom Post Types, different from the Title (which is used in the navigation links). Very useful if you use WordPress as a CMS.


== Description ==

If you use WordPress as a CMS for your website, and you want your headings and links to be different, this plugin will help you. It adds additional field in your Add/Edit Posts/Page form. When you fill it and save your Post, Page or Custom Post Type, the new heading is stored in the DataBase. The plugin replaces `the_title()` and `wp_title()` Template tags so that the new Heading is printed. Also, the Heading is printed in the title atribute in your navigation links.

Since plug-in version 3.0 you can enable/disable the plug-in for Posts. If enabled, a new Widget called "WP Title 2 Recent Posts" appears in the Widgets. When you add the wiget to your sidebar, the short title is printed in the link navigation.

Since WordPress version 3.0, as the new Custom Post Types appeared, you can now choose whether to use WP Title 2 to have Custom Heading for all or some of your Custom Post Types, or none - you decide!

It is not necessary to fill the optional WP Title 2 Heading field - you can leave it empty and in that case your Post/Page/Custom Post Title and Post/Page/Custom Post Link will be the same.

WP Title 2 is compatible with all other plugins which are filtering the output of the Page Navigation and Navigation Menu Template Tags (`wp_list_pages()` and `wp_nav_menu()`).

Already tried WP Title 2? It works? Then please click "Works"! --------------->

Do you like this plugin? Please rate it! -------------------------------------->

This plugin is fully compatible with <a href="http://wordpress.org/extend/plugins/qtranslate/">qTranslate</a>, which allows you to post content in different languages.

Versions 3.6+ are compatible with WordPress version 3.0 and above. If your WordPress version is between 2.8 and 2.9.2, please <a href="http://downloads.wordpress.org/plugin/wp-title-2.3.5.1.zip">download plug-in version 3.5.1</a> .

Versions 3.0 - 3.5.1 are compatible with WordPress 2.8 - 2.9.2. For WordPress version below 2.8, please <a href="http://downloads.wordpress.org/plugin/wp-title-2.2.1.zip">download plugin version 2.1</a> .


== Installation ==

Installation is extremely easy:

1. Upload 'wp-title-2' directory to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress

That's all! Easy, eh?


== Frequently Asked Questions ==

= Do I have to change my templates in order to make the plugin working? =

No. You do not have to change anything. Simply unzip, upload and activate the plugin.

= What will happen with my old Pages' Title? =

The default Title will be printed unless you add your custom heading

= What will happen if I uninstall the plugin? =

Again, the default Posts'/Pages' Titles will be printed

= I would like to use the plugin to display a subtitle on my page (to display both the Title and WP Title 2 Heading). Is that possible with WP Title 2 and how? =

Yes. In that case you have to change your theme templates:

`<!-- this will print your original Title: -->
<h2><?php remove_filter('the_title','wptitle2_the_title',999); the_title(); ?></h2>
<!-- this will print WP Title 2 Heading: -->
<h3><?php add_filter('the_title','wptitle2_the_title',999); the_title(); ?></h3>`

= My original title does not appear in the navigation. Instead, WP Title 2 Heading is printed, or link is broken. What shall I do? =

Have you got any special characters in your Heading? Try disabling HTML in WP Title 2 Heading field (this can be done in Options -> WP Title 2). If you prefer using HTML tags in the Heading field, enable HTML in plugin's options, but remember to properly encode all special characters (e.g. `& => &amp; , " => &quot;`)


== Screenshots ==

1. screenshot 1

== Changelog ==

Changelog is available since version 3.0

= 3.6 =

 * (+) Fixed a bug with WordPress 3.0
 * (+) Added support for WordPress Navigation Menus
 * (+) Added support for Custom Post Types 

 * (-) Plug-in support for WordPress versions below 3.0 is discontinued

= 3.5.1 =

 * Fixed a problem causing conflict between JH Portfolio and WP Title 2 (looking for qTranslate now moved outside the "init" action).

= 3.5 =

 * (+) Added option to enable/disaple showing the custom heading in Posts/Pages list tables in Administration. If disabled, the default title will be shown.
 * (-) As WP Multiligual plugin was causing lots of problems, plugin compatibility with WP Multilingual is now discontinued.

= 3.0.3 =

 * Problem with qTranslate was not fixed at all in 3.0.2 . Checking for activated languages now moved under "init" action.

= 3.0.2 =

 * Combined with qTranslate, WP Title 2 didn't show additional heading input fields for all languages and they did not appear below the original title inputs. This one was caused by the recent version of qTranslate. Fixed.

= 3.0.1 =

 * Small bugfix - title attribute in Page navigation showed nothing if custom title field is empty. Now shows the default title.

= 3.0 =

 * (+) Plugin fully localized (language files and template (POT) file can be found in plugin's directory/lang)
 * (+) Added Options page
 * (+) Added support for HTML 
 * (+) Added support for Posts
 * (+) Added widget "WP Title 2 Recent Posts" 
 * (+) Fixed bugs with special characters in Title and WP Title 2 Heading

 * (-) Plugin support for WordPress versions below 2.8 deprecated

