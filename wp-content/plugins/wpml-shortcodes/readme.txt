=== WPML Shortcodes ===
Contributors: mirkolofio <mirkolofio@gmail.com>, SED Web Enhancement <sedwebagency@gmail.com>
Donate link: http://mircobabini.com/donate/
Tags: wpml, language, translate, translation, translator, shortcode, lang, theme, plugin
Requires at least: 2.8
Tested up to: 4.4.2
Stable tag: 1.2.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds shortcodes to the WPML environment, like wpml__, wpml_e and more. Makes WP full WPML ready.

== Description ==
Adds the wpml__ and wpml_e functions to your theme and the wpml__ shortcode to your WordPress website. Make your WordPress <strong>full WPML ready</strong>

<pre>&lt;?php wpml__( $text, $context ); ?>
&lt;?php wpml_e( $text, $context ); ?></pre>

Similarly to the behaviour of the __, _e functions, you must provide a string to make translateable and a context.
That's it; just provide translations from the WPML > String Translations admin panel.

Check how to use the shortcode below.

= Usage (via code) =
<pre>&lt;h1>&lt;?php echo wpml__( 'Title', 'wpmlshortcodes' ); ?>&lt;/h1>
&lt;h2>&lt;?php wpml_e( 'Subtitle', 'wpmlshortcodes' ); ?>&lt;/h2></pre>

= Usage (via shortcode) =
<pre>&lt;h1>[wpml__ context=wpmlshortcodes]Title[/wpml__]&lt;/h1>
&lt;h2>[wpml__ context=wpmlshortcodes]Subtitle[/wpml__]&lt;/h2></pre>

> <strong>NEWS! WPML Translate (+ shortcode)</strong><br>
> Adds the wpml_if (ex wpml_translate) shortcode to your WPML suite. You can also use the wpml_e__if_language( $content, $lang ) in your php code.

= Usage (via code) =
<pre>&lt;p>&lt;?php
wpml_e__if_language( 'Text', 'en' );
wpml_e__if_language( 'Testo', 'it' );
?>&lt;/p></pre>

= Usage (via shortcode) =
<pre>[wpml_if lang='en']Text[/wpml_if][wpml_if lang='it']Testo[/wpml_if]</pre>

It also supports backward compatibility for wpml_translate and wpml_language from WPML Translate Shortcode (deprecated plugin);

= WPML Translate Shortcode > WPML Shortcodes =
Welcome to the new WPML Shortcodes. This plugin is the new WPML Translate Shortcode, became a full-translation suite.

Of course we still support WPML Translate Shortcode, with a new shortcode (1.2.4+): wpml_if (see usage above).
Also, we provide full backward compatibility (yes, you can still use wpml_translate or wpml_language shortcodes) on 1.2.6+.

= Contribute =
Pull requests on [github.com](https://github.com/mircobabini/wpml-shortcodes).

Author: [Mirco Babini](http://github.com/mircobabini), **Web Developer and Mobile App Developer; WordPress Consultant**.

== Installation ==

Simply search for 'WPML Shortcodes' in the Plugins Admin page, then install and activate. That's it!

== Frequently asked questions ==

== Screenshots ==

== Changelog ==

= 1.2.6 =
* Add backward compatibility to wpml_translate and wpml_language from WPML Translate Shortcode (deprecated plugin)

= 1.2.5 =
* Fix docs
* Support optional context in main api
* Fallback on global context, api: wpml__main_context( $context )
* Fix shortcodes
* Refactoring

= 1.2.4 =
* Integration: WPML Translate Shortcode (deprecated since now)
* usage: [wpml_if lang=it]ciao[/wpml_if][wpml_if lang=en]hello[/wpml_if]

= 1.2.3 =
* Support defined name for shortcodes

= 1.2.2 =
* Fallback (english) if WPML is missing

= 1.2.1 =
* Fix the J.D. Grimes issue (/pull/1)
* Needed to manually restore all the translated strings

= 1.2.0 =
* Ready for the marketplace
