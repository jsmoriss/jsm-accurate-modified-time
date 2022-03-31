<?php
/**
 * Plugin Name: JSM's Accurate Modified Time
 * Text Domain: jsm-accurate-modified-time
 * Domain Path: /languages
 * Plugin URI: https://surniaulula.com/extend/plugins/jsm-accurate-modified-time/
 * Assets URI: https://jsmoriss.github.io/jsm-accurate-modified-time/assets/
 * Author: JS Morisset
 * Author URI: https://surniaulula.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Description: Update post/page modified times when output from post/page shortcodes and blocks changes.
 * Requires PHP: 7.2
 * Requires At Least: 5.2
 * Tested Up To: 5.9.3
 * Version: 1.0.0
 *
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes and/or incompatible API changes (ie. breaking changes).
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 *
 * Copyright 2022 Jean-Sebastien Morisset (https://surniaulula.com/)
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

		/**
		 * When using this filter it’s important to check if you’re filtering the content in the main query with the
		 * conditionals is_main_query() and in_the_loop(). The main post query can be thought of as the primary post loop
		 * that displays the main content for a post, page or archive. Without these conditionals you could unintentionally
		 * be filtering the content for custom loops in sidebars, footers, or elsewhere.
		 *
		 * See https://developer.wordpress.org/reference/hooks/the_content/.
		 */
		public function the_content( $content ) {

			if ( is_main_query() && is_singular() && in_the_loop() ) {

				/**
				 * U = Invert greediness of quantifiers, so they are NOT greedy by default.
				 * s = A dot metacharacter in the pattern matches all characters, including newlines.
				 */
				$text = preg_replace( '/[\s\n\r]+/s', ' ', $content );	// Replace newlines by a space.
				$text = preg_replace( '/<!--.*-->/U', '', $text );	// Remove comments.

				$md5_current = md5( $text );

				global $post;

				if ( ! empty( $post->ID ) ) {

					$md5_meta = '_content_md5';

					$md5_last = get_post_meta( $post->ID, $md5_meta, $single = true );

					if ( $md5_last !== $md5_current ) {

						update_post_meta( $post->ID, $md5_meta, $md5_current );

						if ( ! empty( $md5_last ) ) {

							global $wpdb;

							$data = array(
								'post_modified'     => current_time( $type = 'mysql', $gmt = false ),
								'post_modified_gmt' => current_time( $type = 'mysql', $gmt = true ),
							);
						
							$updated = $wpdb->update( $wpdb->posts, $data, $where = array( 'ID' => $post->ID ) );

							/**
							 * If the WPSSO Core plugin is active, clear the post ID cache.
							 */
							if ( class_exists( 'Wpsso' ) ) {

								$wpsso =& Wpsso::get_instance();

								$wpsso->post->clear_cache( $post->ID );
							}
						}
					}
				}
			}

			return $content;
		}
	}

	JsmAmt::get_instance();
}
