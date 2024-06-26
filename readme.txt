=== JSM Accurate Modified Time for SEO ===
Plugin Name: JSM Accurate Modified Time for SEO
Plugin Slug: jsm-accurate-modified-time
Text Domain: jsm-accurate-modified-time
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://jsmoriss.github.io/jsm-accurate-modified-time/assets/
Tags: seo, post, content, meta tags, schema
Contributors: jsmoriss
Requires PHP: 7.2.34
Requires At Least: 5.8
Tested Up To: 6.5.5
Stable Tag: 1.0.1

Updates the WordPress post/page modified time when the output from a post/page shortcode or block changes.

== Description ==

= The Problem: =

WordPress updates the post/page modified time only when you save/update the post/page in the editor. If you have shortcodes or blocks that create dynamic content (ie. returning content from queries, files, feeds, etc.), the WordPress post/page modified time will not reflect these dynamic changes.

= The Solution: =

The JSM Accurate Modified Time for SEO plugin monitors the post/page content for changes, and updates the WordPress post/page modified time as required. If you use a social and search optimization plugin like WPSSO Core, Yoast SEO, The SEO Framework, etc., after activating this plugin the Open Graph `og:updated_time` and `article:modified_time` meta tags, along with the Schema markup `dateModified` property, will show an accurate modification time if/when your post/page content changes.

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

**Version 1.0.1 (2023/07/08)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Minor code optimization and standardization:
		* Replaced `{get|update|delete}_{comment|post|term|user}_meta()` functions by `{get|update|delete}_metadata()`.
* **Requires At Least**
	* PHP v7.2.34.
	* WordPress v5.8.

**Version 1.0.0 (2022/04/01)**

* **New Features**
	* Initial release.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.2.34.
	* WordPress v5.5.

== Upgrade Notice ==

= 1.0.1 =

(2023/07/08) Minor code optimization and standardization.

= 1.0.0 =

(2022/04/01) Initial release.

