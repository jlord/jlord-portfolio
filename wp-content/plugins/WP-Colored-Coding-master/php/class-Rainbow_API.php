<?php

/**
 * Interface between WP and Rainbow.js
 *
 * @package WP Colored Coding
 * @since 0.1
 */

add_filter( 'wp_cc_rainbow_themes',    array( 'Rainbow_API', 'themes' ),    9, 1 );
add_filter( 'wp_cc_rainbow_scripts',   array( 'Rainbow_API', 'scripts' ),   9, 1 );
add_filter( 'wp_cc_rainbow_languages', array( 'Rainbow_API', 'languages' ), 9, 1 );

class Rainbow_API {

	/**
	 * returns the available themes
	 *
	 * @access public
	 * @static
	 * @param array $themes
	 * @return array
	 */
	public static function themes( $themes ) {

		$default_themes = array(

			'all-hallows-eve' =>
				array(
					'src'  => 'all-hallows-eve.css',
					'name' => 'All hallows eve'
				),

			'blackboard' =>
				array(
					'src'  => 'blackboard.css',
					'name' => 'Blackboard'
				),

			'espresso-libre' =>
				array(
					'src'  => 'espresso-libre.css',
					'name' => 'Espresso libre'
				),

			'github' =>
				array(
					'src'  => 'github.css',
					'name' => 'Github'
				),

			'tricolore' =>
				array(
					'src'  => 'tricolore.css',
					'name' => 'Tricolore'
				),

			'twilight' =>
				array(
					'src'  => 'twilight.css',
					'name' => 'Twilight'
				),

			'zenburnesque' =>
				array(
					'src'  => 'zenburnesque.css',
					'name' => 'Zenburnesque'
					),

			'obsidian' =>
				array(
					'src'  => 'obsidian.css',
					'name' => 'Obsidian'
					),

			'solarized-dark' =>
				array(
					'src'  => 'solarized-dark.css',
					'name' => 'Solarized Dark'
					),

			'solarized-light' =>
				array(
					'src'  => 'solarized-light.css',
					'name' => 'Solarized Light'
					),

			'sunburst' =>
				array(
					'src'  => 'sunburst.css',
					'name' => 'Sunburst'
					),

			'technicolor' =>
				array(
					'src'  => 'technicolor.css',
					'name' => 'Technicolor'
					)

		);

		return array_merge( $themes, $default_themes );
	}

	/**
	 * returns the supported languages
	 *
	 * @access public
	 * @static
	 * @param array $lang
	 * @return array
	 */
	public static function languages( $lang ) {

		/**
		 * languages as 'slug' => 'name'
		 * use 'slug' for internal references
		 */
		$default_languages = array (
			'c'            => 'C',
			'coffeescript' => 'Coffeescript',
			'csharp'       => 'C#',
			'css'          => 'CSS',
			'go'           => 'Go',
			'html'         => 'HTML',
			'java'         => 'Java',
			'javascript'   => 'JavaScript',
			'lua'          => 'Lua',
			'php'          => 'PHP',
			'python'       => 'Python',
			'r'            => 'R',
			'ruby'         => 'Ruby',
			'shell'        => 'Shell',
			'sheme'        => 'Basic Sheme',
			'smalltalk'    => 'Smalltalk'
		);

		return array_merge( $lang, $default_languages );
	}

	/**
	 * returns the rainbow.js script
	 *
	 * @access public
	 * @static
	 * @param array $scripts
	 * @return array
	 */
	public static function scripts( $scripts ) {

		$default_script = array(
			/**
			 * for a language-specific script use this
			 *
			'rainbow_my_language' =>
				array(
					'src'       => '{SRC}',
					'depts'     => array( 'rainbow' ),
					'lang'      => 'my_language', # use as 'slug'
					'in_footer' => TRUE # this must be equal with the script it depends on
				),
			*/
			'rainbow' =>
				array(
					'src'       => WP_Colored_Coding::$uri . '/js/rainbow/rainbow.min.js',
					'depts'     => array(),
					'in_footer' => TRUE,
					'lang'      => 'all'
				)

		);

		return array_merge( $scripts, $default_script );
	}
}
