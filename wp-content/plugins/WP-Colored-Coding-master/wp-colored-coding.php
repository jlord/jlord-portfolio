<?php
/**
 * Plugin Name: WP Colored Coding
 * Plugin URI:  http://dnaber.de/blog/2012/wordpress-plugin-colored-coding/
 * Author:      David Naber
 * Author URI:  http://dnaber.de/
 * Version:     1.2
 * Description: Managing Codeblocks independent from the WP Texteditor and use Rainbow.js for syntax highlighting.
 * Textdomain:  wp-cc
 * License:     Apache 2.0
 * License URI: http://www.apache.org/licenses/LICENSE-2.0
 *
 * Copyright 2012 David Naber
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * This package distributes a copy of Rainbow.js
 * which is also licensed under the Apache License, Version 2.0
 *
 * Copyright 2012 Craig Campbell
 *
 * see js/rainbow/LICENSE for more information
 */

if ( ! function_exists( 'add_filter' ) )
	exit( 'WP?' );

if ( ! class_exists( 'WP_Colored_Coding' ) ) {

	add_action( 'plugins_loaded', array( 'WP_Colored_Coding', 'init' ), 10 );
	register_uninstall_hook( __FILE__, array( 'WP_Colored_Coding', 'unistall' ) );

	class WP_Colored_Coding {

		/**
		 * Version
		 *
		 * @cons string
		 */
		const VERSION = '1.2';

		/**
		 * instance
		 *
		 * @var WP_Colored_Coding
		 */
		private static $instance = NULL;

		/**
		 * filesystem path tho the plugin directory
		 *
		 * @access public
		 * @static
		 * @var string
		 */
		public static $dir = '';

		/**
		 * URI to the plugin directory
		 *
		 * @access public
		 * @static
		 * @var string
		 */
		public static $uri = '';

		/**
		 * default options
		 *
		 * @access protected
		 * @static
		 * @var array
		 */
		protected static $default_options = array(
			'rainbow_theme'            => 'technicolor',
			'use_syntax_highlighting'  => '1',
			'enable_raw_output_option' => '0'
		);

		/**
		 * all the theme options are here
		 *
		 * @access protected
		 * @var array
		 */
		protected $options = array();

		/**
		 * options key
		 *
		 * @access public
		 * @var string
		 */
		public $option_key = '';

		/**
		 * post-meta key
		 *
		 * @access public
		 * @var string
		 */
		public $meta_key = '';

		/**
		 * codeblocks for each post
		 *
		 * @access protected
		 * @var array
		 */
		protected $codeblocks = array();

		/**
		 * themes for the rainbow.js
		 *
		 * @access protected
		 * @var array
		 */
		protected $themes = array();

		/**
		 * languages supportet by rainbow.js
		 *
		 * @access protected
		 * @var array
		 */
		protected $langs = array();

		/**
		 * scripts of rainbow.js
		 *
		 * @access protected
		 * @var array
		 */
		protected $scripts = array();

		/**
		 * instance of admin_ui class
		 *
		 * @access protected
		 * @var CC_Admin_UI
		 */
		protected $admin_ui = NULL;

		/**
		 * global shortcodes
		 *
		 * @access private
		 * @var array
		 */
		private $global_shortcodes = array();

		/**
		 * let's go
		 *
		 * @access public
		 * @since 0.1
		 * @static
		 * @return void
		 */
		public static function init() {

			self::$dir = plugin_dir_path( __FILE__ );
			self::$uri  = plugins_url( '', __FILE__ );

			if ( class_exists( 'CC_Admin_UI' ) )
				return;

			require_once self::$dir . '/php/class-CC_Admin_UI.php';
			require_once self::$dir . '/php/class-Rainbow_API.php';

			load_plugin_textdomain( 'wp-cc', FALSE, basename( dirname( __FILE__ ) ) . '/lang' );

			self::get_instance();
		}

		/**
		 * provide access to the plugin Object to remove hooks
		 *
		 * @since 1.2
		 * @return WP_Colored_Coding
		 */
		public static function get_instance() {

			if ( ! self::$instance instanceof self )
				self::$instance = new self( TRUE );

			return self::$instance;
		}

		/**
		 * constructor
		 *
		 * @access public
		 * @since 0.1
		 * @param $hook_in (Optional, default false)
		 * @return WP_Colored_Coding
		 */
		public function __construct( $hook_in = FALSE ) {

			# set some defaults
			$this->option_key = 'wp_cc_options';
			$this->meta_key   = '_wp_cc_codes';

			$this->load_options();

			/**
			 * rainbow.js themes and supported languages
			 * @see Rainbow_API
			 */
			$this->themes  = apply_filters( 'wp_cc_rainbow_themes',    array() );
			$this->langs   = apply_filters( 'wp_cc_rainbow_languages', array() );
			$this->scripts = apply_filters( 'wp_cc_rainbow_scripts',   array() );

			if ( $hook_in ) {

				# settings and admin interfaces
				$this->admin_ui = new CC_Admin_UI( $this );

				add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
				add_shortcode( 'cc', array( $this, 'cc_block_shortcode' ) );
				/**
				 * apply do_shortcode() before wpautop() to 'the_content' only for
				 * the 'cc' shortcode
				 */
				add_filter( 'the_content', array( $this, 'bypass_shortcodes' ), 5 );
			}
		}

		/**
		 * store the global shortcodes to bypass it
		 *
		 * @access public
		 * @since 0.1
		 * @param string $content
		 * @global $shortcode_tags
		 * @return void
		 */
		public function bypass_shortcodes( $content ) {
			global $shortcode_tags;

			$this->global_shortcodes = $shortcode_tags;
			foreach ( $shortcode_tags as $key => $bypass ) {
				if ( 'cc' !== $key )
					unset( $shortcode_tags[ $key ] );
			}
			$pattern = get_shortcode_regex();
			$content = preg_replace_callback( "/$pattern/s", 'do_shortcode_tag', $content );
			$this->restore_shortcodes(); #important!

			return $content;
		}

		/**
		 * restore shortcodes
		 *
		 * @access protected
		 * @since 0.1
		 * @global $shortcode_tags
		 * @return void
		 */
		protected function restore_shortcodes() {
			global $shortcode_tags;

			$shortcode_tags = $this->global_shortcodes;
		}

		/**
		 * register the syntax highlighting javascripts and styles
		 *
		 * @access public
		 * @since 0.1
		 * @return void
		 */
		public function register_scripts() {

			foreach ( $this->themes as $handle => $t ) {
				$css_src = '.' == dirname( $t[ 'src' ] )
					? self::$uri . '/css/rainbow-themes/' . $t[ 'src' ] #internal styles
					: $t[ 'src' ]; #external styles (@see Rainbow_API::themes())

				wp_register_style(
					$handle,
					$css_src,
					array(),
					self::VERSION,
					'all'
				);
			}
			if ( ! empty( $this->options[ 'rainbow_theme' ] ) && '1' === $this->options[ 'use_syntax_highlighting' ] )
				wp_enqueue_style( $this->options[ 'rainbow_theme' ] );

			foreach ( $this->scripts as $handle => $s ) {
				wp_register_script(
					$handle,
					$s[ 'src' ],
					( empty( $s[ 'depts'] )      ? array()           : $s[ 'depts' ] ),
					( empty( $s[ 'version'] )    ? self::VERSION     : $s[ 'version' ] ),
					( isset( $s[ 'in_footer' ] ) ? $s[ 'in_footer' ] : TRUE )
				);
			}
		}

		/**
		 * enqueues the scripts dependend on the scripts arguments
		 *
		 * @access protected
		 * @since 0.1
		 * @param string $lang
		 * @return void
		 */
		protected function enqueue_scripts( $lang = '' ) {
			global $wp_scripts;

			$queue = $wp_scripts instanceof WP_Scripts && is_array( $wp_scripts->queue )
				? $wp_scripts->queue
				: array();

			# enqueue scripts in header
			if ( 'wp_enqueue_scripts' === current_filter() ) {
				foreach ( $this->scripts as $handle => $args ) {
					if ( empty( $args[ 'in_footer' ] ) && ! in_array( $handle, $queue ) )
						wp_enqueue_script( $handle );
				}
				return;
			}

			if ( ! empty( $lang ) ) {
				foreach ( $this->scripts as $handle => $args ) {
					if ( $lang === $args[ 'lang' ] && ! in_array( $handle, $queue ) ) {
						wp_enqueue_script( $handle );
						return; # all others should handle with the dependencies array
					}
				}
			}
			# still here, okay all other scripts without lang-attribute
			foreach ( $this->scripts as $handle => $args ) {
				if (
				    ( empty( $args[ 'lang' ] ) || 'all' === $args[ 'lang' ] )
				&&  ! in_array( $handle, $queue )
				) {
					wp_enqueue_script( $handle );
				}
			}
		}


		/**
		 * parses the shortcode
		 *
		 * @access public
		 * @since 0.1
		 * @param array $attr
		 * @param srting $content (Optional)
		 * @return string
		 */
		public function cc_block_shortcode( $attr, $content = '' ) {

			$attr = shortcode_atts(
				array(
					'name' => '',
					'lang' => ''
				),
				$attr
			);
			if ( empty( $attr[ 'name' ] ) && empty( $content ) )
				return '';

			$lang = '';
			$print_raw  = FALSE;
			/**
			 * print codeblock
			 */
			if ( ! empty( $attr[ 'name' ] ) ) {
				$id      = get_the_ID();
				$code    = $this->get_code( $id );
				if ( empty( $code[ $attr[ 'name' ] ] ) )
					return ''; # codeblock doesn't exist

				$codeblock = $code[ $attr[ 'name' ] ];
				$lang      = $codeblock[ 'lang' ];
				if ( isset( $codeblock[ 'raw' ] )
				  && '1' === $codeblock[ 'raw' ]
				  && '1' === $this->options[ 'enable_raw_output_option' ]
				) {
					$content   = $codeblock[ 'code' ];
					$print_raw = TRUE;
				} else {
					$content = esc_attr( $codeblock[ 'code' ] );
				}
			}
			/**
			 * print enclosed content as code
			 */
			elseif ( ! empty( $content ) ) {

				$lang    = esc_attr( $attr[ 'lang' ] );
				$content = preg_replace( "~^(\r\n|\n)~", '', $content );
				$content = esc_attr( $content );
			}

			$class   = empty( $lang ) ? 'wp-cc' : 'wp-cc wp-cc-' . $lang;
			$wrapper =
				  '<div class="' . $class . '">'
					. '<pre>'
						. '<code'
						. ( ! empty( $lang )
								? ' data-language="' . $lang . '"'
								: ''
						  )
						. '>'
							.'%s'
						.'</code>'
					. '</pre>'
				. '</div>';
			$wrapper = apply_filters( 'wp_cc_markup_wrapper', $wrapper, $lang );

			if ( '1' === $this->options[ 'use_syntax_highlighting' ] && ! $print_raw )
				$this->enqueue_scripts( $lang );

			if ( $print_raw )
				return $content;

			return sprintf( $wrapper, $content );
		}

		/**
		 * get the codeblocks for a single post or all blocks
		 *
		 * @access public
		 * @since 0.1
		 * @param int|string $post_id
		 * @return array
		 */
		public function get_code( $post_id = NULL ) {

			if ( NULL === $post_id )
				return $this->codeblocks;

			if ( ! isset( $this->codeblocks[ $post_id ] ) )
				$this->codeblocks[ $post_id ] = get_post_meta( $post_id, $this->meta_key, TRUE );

			return is_array( $this->codeblocks[ $post_id ] ) ? $this->codeblocks[ $post_id ] : array();
		}

		/**
		 * set code
		 *
		 * @access public
		 * @since 0.1
		 * @param int|string $post_id
		 * @param array $code
		 * @return void
		 */
		public function set_code_blocks( $post_id, $blocks = array() ) {

			if ( ! is_array( $blocks ) )
				$blocks = array();
			$this->codeblocks[ $post_id ] = $blocks;
		}

		/**
		 * sets a single codeblock by name
		 *
		 * @access public
		 * @since 0.1
		 * @param string $post_id
		 * @param string $name
		 * @param array $value
		 * @return void
		 */
		public function set_single_block( $post_id, $name, $value = array() ) {

			if ( ! is_array( $value )  || empty( $value ) || empty( $value[ 'code' ] ) )
				unset( $this->codeblocks[ $post_id ][ $name ] );

			else
				$this->codeblocks[ $post_id ][ $name ] = $value;
		}

		/**
		 * update post metas
		 *
		 * @access public
		 * @since 0.1
		 * @return void
		 */
		public function update_codeblocks() {

			foreach ( $this->codeblocks as $id => $code ) {

				foreach ( $code as $key => $single ) {
					if ( '' == trim( $single[ 'code' ] ) )
						unset( $code[ $key ] );
				}
				if ( ! empty( $code ) )
					update_post_meta( $id, $this->meta_key, $code );
				else
					delete_post_meta( $id, $this->meta_key );

			}
		}

		/**
		 * returns a unique name for a codebock
		 *
		 * @access public
		 * @param int $post_id
		 * @param int $new_count (Optional)
		 * @return string
		 */
		public function get_name( $post_id, $new_count = NULL ) {

			$code = $this->get_code( $post_id );
			$next = ( NULL === $new_count ) ? count( $code ) + 1 : $new_count + 1;
			$name = 'code-' . ( string ) $next;
			if ( array_key_exists( $name, $code ) ) {
				while ( array_key_exists( $name, $code ) ) {
					$name .= '-1';
				}
			}

			return $name;
		}

		/**
		 * getter for the plugin options
		 *
		 * @access public
		 * @since 0.1
		 * @return void
		 */
		public function get_options() {

			return $this->options;
		}

		/**
		 * getter for registred themes
		 *
		 * @access public
		 * @since 0.1
		 * @return array
		 */
		public function get_themes() {

			return $this->themes;
		}

		/**
		 * getter for supported languages
		 *
		 * @access public
		 * @since 0.1
		 * @return array
		 */
		public function get_langs() {

			return $this->langs;
		}

		/**
		 * get the admin_ui object
		 *
		 * @return CC_Admin_UI
		 */
		public function get_admin_ui() {

			return $this->admin_ui;
		}

		/**
		 * load options
		 *
		 * @access protected
		 * @since 0.1
		 * @return void
		 */
		protected function load_options() {

			$this->options = get_option( $this->option_key, self::$default_options );
		}

		/**
		 * clean up on uninstallation
		 *
		 * @access public
		 * @static
		 * @global $wpdb
		 * @global $blog_id
		 * @return void
		 */
		public static function unistall() {
			global $wpdb;

			$plugin = new self;
			ignore_user_abort( -1 );

			if ( is_network_admin() && isset( $wpdb->blogs ) ) {
				$blogs = $wpdb->get_results(
					'SELECT blog_id FROM ' .
						$wpdb->blogs,
					ARRAY_A
				);
				foreach ( $blogs as $key => $row ) {
					$id = ( int ) $row[ 'blog_id' ];
					switch_to_blog( $id );
					delete_option( $plugin->option_key );
					$wpdb->query(
						'DELETE FROM ' .
							$wpdb->postmeta . ' ' .
						'WHERE ' .
							$wpdb->postmeta . ".meta_key = '" . $plugin->meta_key . "'"
					);
					restore_current_blog();
				}

				return;
			}

			delete_option( $plugin->option_key );
			$wpdb->query(
				'DELETE FROM ' .
					$wpdb->postmeta . ' ' .
				'WHERE ' .
					$wpdb->postmeta . ".meta_key = '" . $plugin->meta_key . "'"
			);

		}

	} # end of class
}
