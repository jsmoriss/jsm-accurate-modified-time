=== JSM Accurate Modified Time for SEO (Yoast SEO, Rank Math SEO, All in One SEO, etc.) ===
Plugin Name: JSM Accurate Modified Time for SEO
Plugin Slug: jsm-accurate-modified-time
Text Domain: jsm-accurate-modified-time
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://jsmoriss.github.io/jsm-accurate-modified-time/assets/
Tags: meta tags, schema, yoast, rank math, seo
Contributors: jsmoriss
Requires PHP: 7.4.33
Requires At Least: 5.9
Tested Up To: 6.8.1
Stable Tag: 2.0.0

Updates the WordPress post/page modified time when the output from a post/page shortcode or block changes.

== Description ==

WordPress updates the post/page modified time only when you save/update the post/page in the editor. If you have shortcodes or blocks that create dynamic content (ie. returning content from queries, files, feeds, etc.), the WordPress post/page modified time will not reflect these dynamic changes.

= The Solution: =

The JSM Accurate Modified Time for SEO plugin monitors the post/page content for changes and updates the WordPress post/page modified time as required.

If you use a social and search optimization plugin like WPSSO Core, Yoast SEO, The SEO Framework, Rank Math SEO, All in One SEO, etc., the Open Graph `og:updated_time` and `article:modified_time` meta tags, along with the Schema markup `dateModified` property, will show accurate modification times when shortcodes or blocks updates your post/page content.

== Installation ==

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

<h3 class="top">Version Numbering</h3>

Version components: `{major}.{minor}.{bugfix}[-{stage}.{level}]`

* {major} = Major structural code changes and/or incompatible API changes (ie. breaking changes).
* {minor} = New functionality was added or improved in a backwards-compatible manner.
* {bugfix} = Backwards-compatible bug fixes or small improvements.
* {stage}.{level} = Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).

<h3>Repositories</h3>

* [GitHub](https://jsmoriss.github.io/jsm-user-locale/)
* [WordPress.org](https://plugins.trac.wordpress.org/browser/jsm-user-locale/)

<h3>Changelog / Release Notes</h3>

**Version 2.0.0 (2024/07/11)**

* **New Features**
	* None.
* **Improvements**
	* Added calls to cache clearing functions after updating the post modified time:
		* WordPress `clean_post_cache()`
		* WPSSO Core `wpsso_refresh_post_cache()`
		* W3TC `w3tc_pgcache_flush_post()`
		* WP Rocket `rocket_clean_post()`
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.4.33.
	* WordPress v5.9.

== Upgrade Notice ==

= 2.0.0 =

(2023/07/11) Added calls to cache clearing functions after updating the post modified time.

