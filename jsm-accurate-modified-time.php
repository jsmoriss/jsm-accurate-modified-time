<?php
/*
 * Plugin Name: JSM Accurate Modified Time for SEO
 * Text Domain: jsm-accurate-modified-time
 * Domain Path: /languages
 * Plugin URI: https://surniaulula.com/extend/plugins/jsm-accurate-modified-time/
 * Assets URI: https://jsmoriss.github.io/jsm-accurate-modified-time/assets/
 * Author: JS Morisset
 * Author URI: https://surniaulula.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Description: Update post/page modified times when output from post/page shortcodes and blocks changes.
 * Requires PHP: 7.4.33
 * Requires At Least: 5.9
 * Tested Up To: 6.7.0
 * Version: 2.0.0
 *
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes and/or incompatible API changes (ie. breaking changes).
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 *
 * Copyright 2022-2024 Jean-Sebastien Morisset (https://surniaulula.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'JsmAmt' ) ) {

	class JsmAmt {

		private static $instance = null;	// JsmAmt class object.

		public function __construct() {

			add_filter( 'the_content', array( $this, 'the_content' ), PHP_INT_MAX, 1 );
		}

		public static function &get_instance() {

			if ( null === self::$instance ) {

				self::$instance = new self;
			}

			return self::$instance;
		}

		/*
		 * When using this filter it's important to check if you're filtering the content in the main query with the
		 * conditionals is_main_query() and in_the_loop(). The main post query can be thought of as the primary post loop
		 * that displays the main content for a post, page or archive. Without these conditionals you could unintentionally
		 * be filtering the content for custom loops in sidebars, footers, or elsewhere.
		 *
		 * See https://developer.wordpress.org/reference/hooks/the_content/.
		 */
		public function the_content( $content ) {

			if ( is_main_query() && is_singular() && in_the_loop() ) {

				/*
				 * s = A dot metacharacter in the pattern matches all characters, including newlines.
				 * U = Invert greediness of quantifiers, so they are NOT greedy by default.
				 */
				$text = preg_replace( '/[\s\n\r]+/s', ' ', $content );		// Replace newlines by a space.
				$text = preg_replace( '/<!--.*-->/U', '', $text );		// Remove comments.
				$text = preg_replace( '/(\xC2\xA0|\s)+/s', ' ', $text );	// Replace 1+ spaces to a single space.

				$md5_current = md5( trim( $text ) );

				global $post;

				if ( ! empty( $post->ID ) && $post->ID > 0 ) {	// Just in case.

					$md5_meta = '_content_md5';
					$md5_last = get_metadata( 'post', $post->ID, $md5_meta, $single = true );

					if ( $md5_last !== $md5_current ) {

						update_metadata( 'post', $post->ID, $md5_meta, $md5_current );

						if ( ! empty( $md5_last ) ) {	// Not the first run.

							$this->update_post_modified( $post->ID );

							$this->clean_post_cache( $post->ID );

							$post = get_post( $post->ID );	// Refresh the global post object.
						}
					}
				}
			}

			return $content;
		}

		public function update_post_modified( $post_id ) {

			if ( ! empty( $post_id ) && $post_id > 0 ) {	// Just in case.

				global $wpdb;

				$data = array(
					'post_modified'     => current_time( $type = 'mysql', $gmt = false ),
					'post_modified_gmt' => current_time( $type = 'mysql', $gmt = true ),
				);

				$updated = $wpdb->update( $wpdb->posts, $data, $where = array( 'ID' => $post_id ) );
			}
		}

		public function clean_post_cache( $post_id ) {

			if ( ! empty( $post_id ) && $post_id > 0 ) {	// Just in case.

				clean_post_cache( $post_id );	// Since WP v2.0.0.

				if ( function_exists( 'wpsso_refresh_post_cache' ) ) {	// WPSSO Core plugin.

					wpsso_refresh_post_cache( $post_id );
				}

				if ( function_exists( 'w3tc_pgcache_flush_post' ) ) {	// W3 Total Cache plugin.

					w3tc_pgcache_flush_post( $post_id );
				}

				if ( function_exists( 'rocket_clean_post' ) ) {	// WP Rocket plugin.

					rocket_clean_post( $post_id );
				}
			}
		}
	}

	JsmAmt::get_instance();
}
