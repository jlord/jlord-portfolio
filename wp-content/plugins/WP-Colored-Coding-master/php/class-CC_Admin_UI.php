<?php

/**
 * admin interface and settings handling
 *
 * @package WP Colored Coding
 * @since 0.1
 */

class CC_Admin_UI {

	/**
	 * plugin instance
	 *
	 * @access public
	 * @var WP_Colored_Coding
	 */
	public $plugin = NULL;

	/**
	 * settings_section
	 *
	 * @access protected
	 * @var string
	 */
	protected $settings_section = '';

	/**
	 * constructor
	 *
	 * @access public
	 * @param WP_Colored_Coding $plugin
	 * @return CC_Admin_UI
	 */
	public function __construct( $plugin ) {

		if ( ! $plugin instanceof WP_Colored_Coding )
			exit( 'Wrong Parameter in ' . __METHOD__  );

		$this->plugin = $plugin;
		$this->settings_section = $this->plugin->option_key . '_section';

		/**
		 * note for developers: get access of '$this' via WP_Colored_Coding::get_admin_ui()
		 */
		add_action( 'admin_init',            array( $this, 'settings' ) );
		add_action( 'add_meta_boxes',        array( $this, 'meta_boxes' ) );
		add_action( 'save_post',             array( $this, 'update_codeblocks' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		# ajax handles
		add_action( 'wp_ajax_wp_cc_new_block',            array( $this, 'single_codeblock' ) );
		add_action( 'wp_ajax_wp_cc_update_block',         array( $this, 'update_single' ) );
		add_action( 'wp_ajax_wp_cc_update_dialog_option', array( $this, 'get_code_dropdown' ) );

		# tinymce dialog
		if (
			(    current_user_can( 'edit_posts' )
			  || current_user_can( 'edit_pages' )
			)
			&& 'true' == get_user_option( 'rich_editing' )
		) {
			add_action( 'admin_footer',            array( $this, 'mce_dialog' ) );
			add_filter( 'mce_external_plugins', array( $this, 'register_mce_plugin' ) );
			add_filter( 'mce_buttons',          array( $this, 'register_mce_button' ) );
		}
	}

	/**
	 * admin styles
	 *
	 * @access public
	 * @global $pagenow
	 * @return void
	 */
	public function admin_scripts() {
		global $pagenow;

		wp_register_script(
			'modernizr-custom',
			WP_Colored_Coding::$uri . '/js/relevant-dropdowns/modernizr.custom.95508.js',
			array(),
			WP_Colored_Coding::VERSION,
			FALSE
		);

		wp_register_script(
			'relevant-dropdowns',
			WP_Colored_Coding::$uri . '/js/relevant-dropdowns/jquery.relevant-dropdown.js',
			array( 'modernizr-custom', 'jquery' ),
			WP_Colored_Coding::VERSION,
			FALSE
		);

		wp_enqueue_script(
			'wp-cc-admin-script',
			WP_Colored_Coding::$uri . '/js/admin.js',
			array( 'jquery', 'jquery-color', 'relevant-dropdowns' ),
			WP_Colored_Coding::VERSION,
			FALSE
		);

		wp_enqueue_style(
			'wp-cc-admin-style',
			WP_Colored_Coding::$uri . '/css/admin.css',
			array(),
			WP_Colored_Coding::VERSION
		);

		wp_localize_script(
			'wp-cc-admin-script',
			'wpCcGlobals',
			array(
				'AjaxUrl'             => admin_url( 'admin-ajax.php' ),
				'PostID'              => ( in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) )
					? get_the_ID()
					: NULL,
				'NonceFieldId'        => 'wp-cc-nonce',
				'UpdateBlock'         => 'wp_cc_update_block',
				'NewBlockAction'      => 'wp_cc_new_block',
				'UpdateOptionsAction' => 'wp_cc_update_dialog_option'
			)
		);
	}

	/**
	 * add the metaboxes
	 *
	 * @access public
	 * @return void
	 */
	public function meta_boxes() {

		add_meta_box(
			'wp-cc-codeblocks',
			__( 'Code Blocks', 'wp-cc' ),
			array( $this, 'code_metabox' ),
			'post'
		);
		add_meta_box(
			'wp-cc-codeblocks',
			__( 'Code Blocks', 'wp-cc' ),
			array( $this, 'code_metabox' ),
			'page'
		);
	}

	/**
	 * the code editing metabox
	 *
	 * @access public
	 * @param WP_Post $post
	 * @return void
	 */
	public function code_metabox( $post ) {
		$code = $this->plugin->get_code( $post->ID );
		$code[ '' ] = array(); # append an empty section for a new codeblock
		?>
		<input type="hidden" name="wp-cc[nonce]" value="<?php echo wp_create_nonce( 'wp_cc_nonce' ); ?>" id="wp-cc-nonce" />
		<div class="inside">
			<p><?php _e( 'To delete a codeblock just leave the textarea(code) empty and update.', 'wp-cc' ); ?></p>
			<ul id="wp-cc-code-list">
			<?php foreach ( $code as $name => $block ) {
				$this->single_codeblock( array_merge( $block, array( 'name' => $name ) ) );
			}?>
			</ul>
			<p><input
				class="button-secondary"
				type="button"
				id="wp-cc-new-block"
				value="<?php _e( 'Give me the next block', 'wp-cc' ); ?>"
			/></p>

			</div>
		<?php
	}

	/**
	 * single codeblock markup
	 *
	 * @access public
	 * @param array $values (Optional)
	 * @return string|void (Void on AJAX-Requests)
	 */
	public function single_codeblock( $values = array() ) {

		$options  = $this->plugin->get_options();
		$ajax     = defined( 'DOING_AJAX' ) && DOING_AJAX;
		$defaults = array(
			'name' => '',
			'code' => '',
			'lang' => '',
			'raw'  => '0'
		);
		$ns    = uniqid( '' );
		$v     = wp_parse_args( $values, $defaults );
		$langs = $this->plugin->get_langs();
		asort( $langs );

		if ( $ajax && ! wp_verify_nonce( $_POST[ 'nonce' ], 'wp_cc_nonce' ) )
			exit;

		?>
		<li id="<?php echo $ns; ?>" class="wp-cc-single-block">
			<div class="postbox">
				<div class="inside">
					<div class="cc-input">
						<div>
							<p>
								<label for="name-<?php echo $ns; ?>"><?php _e( 'Name', 'wp-cc' ); ?></label>
								<input
									id="name-<?php echo $ns; ?>"
									class="cc-data"
									type="text"
									name="wp-cc[block][<?php echo $ns; ?>][name]"
									value="<?php echo $v[ 'name' ]; ?>"
									placeholder="<?php esc_attr_e( 'Use within the Shortcode [cc name=""]', 'wp-cc' ); ?>"
									<?php if ( '' !== $v[ 'name' ] ) : ?>
										readonly="readonly"
									<?php endif; ?>
								/>
							</p>
							<p>
								<label for="lang-<?php echo $ns; ?>"><?php _e( 'Language', 'wp-cc' ); ?></label>
								<input
									id="lang-<?php echo $ns; ?>"
									class="cc-data cc-lang"
									type="text"
									name="wp-cc[block][<?php echo $ns; ?>][lang]"
									value="<?php echo $v[ 'lang' ]; ?>"
									placeholder="<?php esc_attr_e( 'Leave empty for no syntax highlighting', 'wp-cc' ); ?>"
									list="lang-list-<?php echo $ns; ?>"
								/>
								<datalist id="lang-list-<?php echo $ns; ?>">
									<?php foreach ( $langs as $value => $name ) : ?>
										<option value="<?php echo $value; ?>"><?php echo $name; ?></option>
									<?php endforeach; ?>
								</datalist>
							</p>
							<?php if ( '1' === $options[ 'enable_raw_output_option' ] ) : ?>
								<p>
									<input
										id="raw-<?php echo $ns; ?>"
										class="cc-data"
										type="checkbox"
										name="wp-cc[block][<?php echo $ns; ?>][raw]"
										value="1"
										<?php checked( $v[ 'raw' ], TRUE ); ?>
									/>
									<label for="raw-<?php echo $ns; ?>"><?php _e( 'Raw HTML Code (Note! This will print the plain Code without any escaping filters)', 'wp-cc' ); ?></label>
								</p>
							<?php endif; ?>
						</div>
						<div>
							<div class="cc-code-buttons">
								<p>
									<input type="button" class="wp-cc-insert-tab" data-target-id="code-<?php echo $ns; ?>" title="<?php esc_attr_e( 'Insert Tab', 'wp-cc' ); ?>" value="⇥" />
								</p>
							</div>
							<div class="cc-code">
								<p>
									<label for="code-<?php echo $ns; ?>"><?php _e( 'Code', 'wp-cc' ); ?></label><br />
									<textarea rows="10" class="large-text wp-cc-codearea cc-data" id="code-<?php echo $ns; ?>" name="wp-cc[block][<?php echo $ns; ?>][code]"><?php echo $v[ 'code' ]; ?></textarea
								</p>
							</div>
						</div>
					</div>
					<div class="cc-submit">
						<input type="button" class="wp-cc-single-update button-secondary" value="<?php _e( 'Update', 'wp-cc' ); ?>" data-ns="<?php echo $ns; ?>" />
					</div>
				</div>
			</div>
		</li>
		<?php

		if ( $ajax )
			exit;
	}

	/**
	 * update codeblocks
	 *
	 * @access public
	 * @param string $post_id
	 * @return void
	 */
	public function update_codeblocks( $post_id ) {

		if (
			! isset( $_POST[ 'wp-cc' ] )
		||  ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		||  (  ! wp_verify_nonce( $_POST['wp-cc'][ 'nonce' ], 'wp_cc_nonce' ) )
		||  ( isset( $_POST[ 'post_type' ] ) && ! current_user_can( 'edit_' . $_POST[ 'post_type' ], $post_id ) )
		)
			return;

		$blocks = array();
		foreach ( $_POST[ 'wp-cc' ][ 'block' ] as $b ) {
			if ( empty( $b[ 'code' ] ) )
				continue;
			if ( empty( $b[ 'name' ] ) )
				$b[ 'name' ] = $this->plugin->get_name( $post_id, count( $blocks ) );
			# post-meta api serializes (bool) TRUE to (string) '1' so we take the string for true/false data
			$raw = isset( $b[ 'raw' ] ) && '1' === $b[ 'raw' ] ? '1' : '0';
			$blocks[ $b[ 'name' ] ] = array(
				'code' => $b[ 'code' ],
				'lang' => trim( $b[ 'lang' ] ),
				'raw' => $raw
			);
		}
		$this->plugin->set_code_blocks( $post_id, $blocks );
		$this->plugin->update_codeblocks();
	}

	/**
	 * update a single block via ajax. prints a json-string
	 *
	 * @access public
	 * @return void
	 */
	public function update_single() {
		$_POST = stripslashes_deep( $_POST );

		if ( ! defined( 'DOING_AJAX' )  || ! DOING_AJAX )
			return;

		if ( ! wp_verify_nonce( $_POST[ 'nonce' ], 'wp_cc_nonce' ) )
			exit;

		$return = array(
			'deleted' => FALSE,
			'updated' => FALSE
		);
		$id       = ( int ) $_POST[ 'pid' ];
		$name     = empty( $_POST[ 'name' ] )
			? $this->plugin->get_name( $id )
			: $_POST[ 'name' ];
		$existing = $this->plugin->get_code( $id );
		$block = array();
		$block[ 'code' ] = $_POST[ 'code' ];
		$block[ 'lang' ] = trim( $_POST[ 'lang' ] );
		# post-meta api serializes (bool) TRUE to (string) '1' so we use a string
		$block[ 'raw' ]  = isset( $_POST[ 'raw' ] ) && '1' === $_POST[ 'raw' ] ? '1' : '0';

		$this->plugin->set_single_block( $id, $name, $block );
		$this->plugin->update_codeblocks();
		$new = $this->plugin->get_code( $id );
		if ( ! isset( $new[ $name ] ) )
			$return[ 'deleted' ] = TRUE;
		elseif ( ! isset( $existing[ $name ] ) || array() !== array_diff( $new[ $name ], $existing[ $name ] ) )
			$return[ 'updated' ] = TRUE;

		if ( $name !== $_POST[ 'name' ] )
			$return[ 'name' ] = $name;

		echo json_encode( $return );

		exit;
	}

	/**
	 * register the settings api
	 *
	 * @access public
	 * @return void
	 */
	public function settings() {

		register_setting(
			'writing',
			$this->plugin->option_key,
			array( $this, 'validate_setting_input' )
		);

		add_settings_section(
			$this->settings_section,
			__( 'WP Colored Coding settings', 'wp-cc' ),
			array( $this, 'settings_description' ),
			'writing'
		);

		# use syntax highlighting?
		add_settings_field(
			'cc_use_highlighting',
			__( 'Use syntax highlighting?', 'wp-cc' ),
			array( $this, 'opt_checkbox' ),
			'writing',
			$this->settings_section,
			array(
				'id'        => 'cc_use_syntax_highlighting',
				'label_for' => 'cc_use_syntax_highlighting',
				'name'      => $this->plugin->option_key . '[use_syntax_highlighting]'
			)
		);

		# rainbow theme
		$theme_options = $this->plugin->get_themes();
		foreach ( $theme_options as $handle => $atts ) {
			$theme_options[ $handle ] = $atts[ 'name' ];
		}
		add_settings_field(
			'cc_rainbow_theme',
			__( 'Syntax highlighting theme', 'wp-cc' ),
			array( $this, 'opt_select' ),
			'writing',
			$this->settings_section,
			array(
				'id'        => 'cc_rainbow_theme',
				'label_for' => 'cc_rainbow_theme',
				'name'      => $this->plugin->option_key . '[rainbow_theme]',
				'options'   => $theme_options
			)
		);

		# option to print raw code on each code-block fromular
		add_settings_field(
			'cc_enable_raw_output_option',
			__( 'Enable the raw output option?', 'wp-cc' ),
			array( $this, 'opt_checkbox' ),
			'writing',
			$this->settings_section,
			array(
				'id'          => 'cc_enable_raw_output_option',
				'label_for'   => 'cc_enable_raw_output_option',
				'name'        => $this->plugin->option_key . '[enable_raw_output_option]',
				'description' => __( 'Provide an option on each codeblock to print it as raw HTML/Javascript instead of escaping it.', 'wp-cc' )
			)
		);
	}

	/**
	 * prints a description to the settings section
	 *
	 * @access public
	 * @return void
	 */
	public function settings_description() {
		?>
		<div class="inside">
			<p><?php _e( 'If you want to use syntax highlighting via rainbow.js, just enable it and choose a theme.', 'wp-cc' ); ?></p>
		</div>
		<?php
	}

	/**
	 * validate the input
	 *
	 * @access public
	 * @param array $input (Array of all input fields registred to the settings section)
	 * @return array
	 */
	public function validate_setting_input( $input ) {

		$return = array(
			'use_syntax_highlighting'  => '',
			'rainbow_theme'            => '',
			'enable_raw_output_option' => '',
		);
		# use highlighting?
		if ( isset( $input[ 'use_syntax_highlighting' ] )
		  && '1' === $input[ 'use_syntax_highlighting' ]
		)
			$return[ 'use_syntax_highlighting' ] = '1';
		else
			$return[ 'use_syntax_highlighting' ] = '0';


		# rainbow theme?
		if ( isset( $input[ 'rainbow_theme' ] ) ) {
			$themes = array_keys( $this->plugin->get_themes() );
			if ( in_array( $input[ 'rainbow_theme' ], $themes ) )
				$return[ 'rainbow_theme' ] = $input[ 'rainbow_theme' ];
			else
				$return[ 'rainbow_theme' ] = '';
		}

		if ( isset( $input[ 'enable_raw_output_option' ] )
		  && '1' === $input[ 'enable_raw_output_option' ]
		  )
			$return[ 'enable_raw_output_option' ] = '1';
		else
			$return[ 'enable_raw_output_option' ] = '0';

		return $return;
	}

	/**
	 * prints a selectbox
	 *
	 * @access public
	 * @param array $attr
	 * @return void
	 */
	public function opt_select( $attr ) {
		$option = $this->plugin->get_options();
		$option_key = preg_replace( '~^cc_~', '', $attr[ 'id' ] );
		$current_value = $option[ $option_key ];

		?>
		<select name="<?php echo $attr[ 'name' ]; ?>" id="<?php echo $attr[ 'id' ];?>">
			<option value=""></option>
		<?php foreach ( $attr[ 'options' ] as $value => $name ) : ?>
			<option value="<?php echo $value; ?>" <?php selected( $current_value, $value ); ?>><?php echo $name; ?></option>
		<?php endforeach; ?>
		</select>
		<?php
		if ( ! empty( $attr[ 'description' ] ) ) : ?>
			<p class="help">
				<?php echo $attr[ 'description' ]; ?>
			</p>
			<?php
		endif;
	}

	/**
	 * prints a checkbox
	 *
	 * @access public
	 * @param array $attr
	 * @return void
	 */
	public function opt_checkbox( $attr ) {
		$option = $this->plugin->get_options();
		$option_key = preg_replace( '~^cc_~', '', $attr[ 'id' ] );
		$current_value = $option[ $option_key ];
		?>
		<input type="checkbox" name="<?php echo $attr[ 'name' ]; ?>" id="<?php echo $attr[ 'id' ]; ?>" value="1" <?php checked( $current_value, '1' ); ?> />
		<?php
		if ( ! empty( $attr[ 'description' ] ) ) : ?>
			<p class="help">
				<?php echo $attr[ 'description' ]; ?>
			</p>
			<?php
		endif;
	}

	/**
	 * register tinymce plugin
	 *
	 * @access public
	 * @param array $mce_plugins
	 * @return array
	 */
	public function register_mce_plugin( $mce_plugins ) {

		$mce_plugins[ 'wpCCDialog' ] = WP_Colored_Coding::$uri . '/js/editor_plugin.js';

		return $mce_plugins;
	}

	/**
	 * register tinymce button
	 *
	 * @access public
	 * @param array $mce_buttons
	 * @return array
	 */
	public function register_mce_button( $mce_buttons ) {

		array_push( $mce_buttons, '|', 'wp_cc_open' );

		return $mce_buttons;
	}

	/**
	 * tiny mce popup markup
	 *
	 * @access public
	 * @return void
	 */
	public function mce_dialog() {

		?>
		<div style="display:none">
			<form id="wp-cc-mce-popup">
				<div class="postbox">
					<div class="inside">
						<h4><?php _e( 'Insert a Codeblock', 'wp-cc' ); ?></h4>
						<p><label for="cc-dialog-shortcodes"><?php _e( 'Available Codeblocks', 'wp-cc' ); ?></label></p>
						<p id="wp-cc-dialog-options-codeblocks"><?php echo $this->get_code_dropdown( 'wp-cc-dialog-codeblocks' ); ?></p>
					</div>
					<div class="inside">
						<h4><?php _e( 'or write your code into the editor', 'wp-cc' ); ?></h4>
						<p><label for="cc-dialog-shortcodes"><?php _e( 'Languages supported by Rainbow.js', 'wp-cc' ); ?></label></p>
						<p id="wp-cc-dialog-options-language"><?php echo $this->get_supported_languages_dropdown( 'wp-cc-dialog-language' ); ?></p>
					</div>
					<div class="inside">
						<p><input type="submit" class="button-primary" value="<?php esc_attr_e( 'Insert Shortcode', 'wp-cc' ); ?>" /></p>
					</div>
					<div>
						<input type="hidden" name="wp-cc[dialog-nonce]" id="wp-cc-dialog-nonce" value="<?php echo wp_create_nonce( 'wp_cc_dialog_nonce' ); ?>" />
					</div>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * get all codeblocks as select-element
	 *
	 * @access public
	 * @param string $id
	 * @param string $name
	 * @return string
	 */
	public function get_code_dropdown( $name = '', $id = '' ) {

		$ajax = FALSE;
		$pid  = '';
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
			$ajax = TRUE;

		if ( ! $ajax && empty( $name ) )
			exit( 'Missing parameter: name in ' . __METHOD__ );

		if ( $ajax ) {
			$name = $_POST[ 'name' ];
			$pid  = $_POST[ 'pid' ];
		} else {
			$pid = get_the_ID();
		}

		if ( empty( $id ) )
			$id = $name;

		$select =
			  '<select name="' . $name . '" id="' . $id . '">'
			. '<option value=""></option>';
		$code = $this->plugin->get_code( $pid );
		foreach ( $code as $name => $c ) {
			$select .='<option value="' . $name . '">' . $name . '</option>';
		}
		$select .= '</select>';

		if ( $ajax ) {
			echo $select;
			exit;
		}
		return $select;
	}

	/**
	 * all supported languages as select-element
	 *
	 * @access public
	 * @param string $id
	 * @param string $name
	 * @return string
	 */
	public function get_supported_languages_dropdown( $name = '', $id = '' ) {

		if ( empty( $id ) )
			$id = $name;

		$select =
			  '<select name="' . $name . '" id="' . $id . '">'
			. '<option value=""></option>';

		$langs = $this->plugin->get_langs();
		foreach ( $langs as $slug => $name ) {
			$select .='<option value="' . $slug . '">' . $name . '</option>';
		}
		$select .= '</select>';

		return $select;
	}

}
