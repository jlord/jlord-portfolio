( function() {
	tinymce.create(
		'tinymce.plugins.wpCCDialog',
		{
			/**
			 * @param tinymce.Editor editor
			 * @param string url
			 */
			init : function( editor, url ) {
				/**
				 * and a new command
				 */
				editor.addCommand(
					'wp_cc_open_dialog',
					function() {
						/**
						 * @link http://www.tinymce.com/wiki.php/API3:method.tinymce.WindowManager.open
						 * @param Object Popup settings
						 * @param Object Arguments to pass to the Popup
						 */
						editor.windowManager.open(
							{
								id       : 'wp-cc-mce-popup',
								width    : 480,
								height   : 'auto',
								title    : 'CC Shortcodes',
								wpDialog : true
							},
							{
								plugin_url : url
							}
						);
					}
				);
				/**
				 * register a new button
				 */
				editor.addButton(
					'wp_cc_open',
					{
						cmd   : 'wp_cc_open_dialog',
						title : editor.getLang( 'wpCC.buttonTitle', 'CC Shortcodes' ),
						image : url + '/../img/cc.png'
					}
				);

			}
		}
	);

	// Register plugin
	tinymce.PluginManager.add( 'wpCCDialog', tinymce.plugins.wpCCDialog );
} )();
