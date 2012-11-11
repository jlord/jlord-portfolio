=== WP Colored Coding ===
Contributors: dnaber-de
Tags: syntax highlighting, rainbow.js, code samples
Requires at least: 3.3
Tested up to: 3.4.2
Stable tag: 1.2
License: Apache 2.0
License URI: http://www.apache.org/licenses/LICENSE-2.0

Syntax highlighting with Rainbow.js.

== Description ==

Brings the cool Javascript syntax highlighter [Rainbow.js](https://github.com/ccampbell/rainbow) to your Wordpress-Blog and allows you to manage code snippets independend from the text editor.

= Quick Start =
1. Download the plugin from this page
1. Follow the instructions on the [Wordpress Codex](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation) to install the plugin.
By default, the plugin is ready for use after activation. Some options can be changed on Settings → Writing.

For a detailed usage manual refer to the  [Usage section](http://wordpress.org/extend/plugins/wp-colored-coding/other_notes/#usage), or – better than a thousand words – to the [screenshots](http://wordpress.org/extend/plugins/wp-colored-coding/screenshots/).

If you want to change the behaviour of the plugin see the [API-Documentation](http://wordpress.org/extend/plugins/wp-colored-coding/other_notes/#API)

![Screenshot 1](http://wordpress.org/extend/plugins/wp-colored-coding/assets/screenshot-1.png)
![Screenshot 2](http://wordpress.org/extend/plugins/wp-colored-coding/assets/screenshot-2.png)
![Screenshot 3](http://wordpress.org/extend/plugins/wp-colored-coding/assets/screenshot-3.png)
== Installation ==
Just [download](https://github.com/dnaber-de/WP-Colored-Coding/downloads) the latest tag and follow the instructions on the [Wordpress Codex](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

== Settings ==
By default, the plugin is ready for use after activation. Some options can be changed on Settings → Writing.

= Raw output =
This option enables an additional checkbox for each codeblock of a post which allows you to disable the `esc_attr()` filter for that code snippet. That means, every HTML and Javascript inside this textarea will be parsed by the browser as those. So be carefull with this option.

== Usage ==

= Codeblocks =
A single Codeblock is identified (in the posts context) by its name. If you don't want to specify a name for each block, leave it empty, it will be generated automatically.

The language field is also optional. To use syntax highlighting, write in a rainbow supported language. (It will give you suggestions.) Currently these are
* C
* Coffeescript
* C#
* CSS
* Go
* HTML
* Java
* JavaScript
* Lua
* PHP
* Python
* R
* Ruby
* Shell
* Smalltalk

Each codeblock can be placed anywhere in the text by using the shortcode `[cc name="{name}"]`. You can use the TinyMCE button »CC« for that.

= Shortcode (in-text code) =
For just a few lines of code you may want to use the shortcode like this:

`
[cc lang="javascript"]
var str = 'Hello World';
alert( str );
[/cc]
`

== Contribution & Bug-Report ==
For bug reports or ideas for new features, please use the [issue tracker on gitub](https://github.com/dnaber-de/WP-Colored-Coding/issues).

== API ==

The following filters are provided:

* `wp_cc_rainbow_themes`
* `wp_cc_rainbow_scripts`
* `wp_cc_rainbow_languages`

Adding a new Theme is quite easy. Just expend the themes-array by a key like this
`
/**
 * @param array $themes
 * @return array
 */
function my_new_rainbow_theme( $themes ) {
	$themes[ 'my_theme' ] = array(
		'src'  => //the absolute URI to the stylesheet
		'name' => 'My Theme'
	);

	return $themes;
}
add_filter( 'wp_cc_rainbow_themes', 'my_new_rainbow_theme' );
`

To add a supported language use
`
/**
 * @param array $scripts
 * @return array
 */
function my_new_rainbow_script( $scripts ) {
	$scripts[ 'my_new_lang' ] = array(
		'src'       => //the absolute URI to the script
		'depth'     => array( 'rainbow' ),
		'lang'      => 'my_new_lang',
		'in_footer' => TRUE # this must be equal with the script it depends on
	);

	# to override the built-in rainbow version use the key 'rainbow'

	return $scripts;
}
add_filter( 'wp_cc_rainbow_scripts', 'my_new_rainbow_script' );

/**
 * @param array $langs
 * @return array
 */
function my_new_lang( $langs ) {

	$langs[ 'my_new_lang' ] = 'My new lang';

	return $langs;
}
add_filter( 'wp_cc_rainbow_languages', 'my_new_lang' );
`

= Deactivation/Uninstallation =

If you deactivate the plugin all settings and codes will be preserved. On uninstallation (delete), all settings and codes will be deleted finally. If this is triggered from the network-admin page, all blogs will be cleaned up.

== Acknowledgement ==
* Thanks to [sparanoid](https://github.com/sparanoid) for chinese translation
* Thanks to [@volleyballfisch](https://twitter.com/Volleyballfisch) for spanish translation

== Screenshots ==
1. The Meta-Box on post edit screen to manage your code snippeds.
2. TinyMCE popup to build and insert shortcode into the text editor.
3. WP Colored Coding settings section.

== Frequently Asked Questions ==
= Are there any frequently asked questions? =
None so far. If you have any questions feel free to [contact](http://dnaber.de/kontakt) me (english, german) or use the [support forum](http://wordpress.org/support/plugin/wp-colored-coding) on wordpress.org.


== Changelog ==

= 1.2.0 =
* fixed a bug of the unfiltered output option
* better readme.txt for wordpress.org

= 1.1.0 =
* spanish language files
* rainbow support for Go, R, Coffeescript, Java, Smalltalk

= 1.0.1 =
* bugfix
* Theme Technicolor updated

= 1.0.0 =
* initial release


