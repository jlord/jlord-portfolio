/**
 * scripts for the admin-UI
 *
 * @package WordPress
 * @subpackage WP Colored Coding
 * @requires jQuery framework
 */
( function( $ ) {

	$( document ).ready(
		function() {

			/**
			 * buttons for the textarea
			 */
			//remember the selection
			$( document ).on(
				'blur',
				'.wp-cc-codearea',
				function() {
					/**
					 * cross-browser selectrion
					 *
					 * @link http://stackoverflow.com/questions/263743/how-to-get-cursor-position-in-textarea
					 */
					var getInputSelection = function( el ) {
						var start = 0, end = 0, normalizedValue, range,
							textInputRange, len, endRange;
						if ( 'number' == typeof( el.selectionStart )  && 'number' == typeof( el.selectionEnd ) ) {
							start = el.selectionStart;
							end = el.selectionEnd;
						}
						//@todo IE support
						return {
							start: start,
							end: end
						};
					}
					this.ccSelection = getInputSelection( this );
				}
			);

			// set the cursor to the right position
			$( document ).on(
				'focus',
				'.wp-cc-codearea',
				function() {
					if ( 'number' == typeof( this.selectionStart ) && 'undefined' != typeof( this.ccSelection ) )
						this.selectionStart = this.selectionEnd = this.ccSelection.start;

				}
			);

			//insert a tab
			$( document ).on(
				'click',
				'.wp-cc-insert-tab',
				function( e ) {
					e.preventDefault();
					var textarea = document.getElementById( $( this ).attr( 'data-target-id' ) );
					var selection = textarea.ccSelection;
					var len = textarea.value.length;
					textarea.value = textarea.value.substr( 0, selection.start ) + "\t" + textarea.value.substr( selection.start, len );
					textarea.ccSelection.start++;
					textarea.focus();
					return false;
				}
			);

		}
	);

	/**
	 * ajax stuff
	 */
	$( document ).ready(
		function() {
			// append a new codeblock section
			$( document ).on(
				'click',
				'#wp-cc-new-block',
				function() {
					$.post(
						wpCcGlobals.AjaxUrl,
						{
							nonce  : $( '#' + wpCcGlobals.NonceFieldId ).attr( 'value' ),
							action : wpCcGlobals.NewBlockAction
						},
						function( data ) {
							data = $( data );
							data.hide();
							$( '#wp-cc-code-list' ).append( data );
							data.slideDown();
						}
					);
				}
			);

			// update (and delete) a single codeblock
			$( document ).on(
				'click',
				'.wp-cc-single-update',
				function() {
					var ns = $( this ).attr( 'data-ns' );
					var pid = wpCcGlobals.PostID;
					var fields = $( '#' + ns + ' .cc-data' );
					var data = {
						nonce  : $( '#' + wpCcGlobals.NonceFieldId ).attr( 'value' ),
						action : wpCcGlobals.UpdateBlock,
						pid    : pid
					};
					fields.each(
						function( ) {
							var name = $( this ).attr( 'name' ).match( /\[(\w+)\]$/ );
							if ( 'text' == $( this ).attr( 'type' ) || 'TEXTAREA' == this.tagName )
								data[ name[ 1 ] ] = $( this ).attr( 'value' );
							if ( 'checkbox' == $( this ).attr( 'type' ) && 'checked' == $( this ).attr( 'checked' ) )
								data[ name[ 1 ] ] = $( this ).attr( 'value' );
						}
					);
					$.post(
						wpCcGlobals.AjaxUrl,
						data,
						function( data ) {
							if ( data.name ) {
								$( '#name-' + ns )
									.attr( 'value', data.name )
									.attr( 'readonly', 'readonly' );
							}
							if ( data.deleted ) {
								$( '#' + ns ).slideUp(
									'slow',
									function() {
										$( this ).remove();
									}
								);
							}
							else if ( data.updated ) {
								var box = $( '#' + ns + ' .cc-input' );
								box.css( { 'background-color': '#ff4' } );
								box.animate(
									{
										backgroundColor : '#f5f5f5'
									},
									500,
									function() {
										$( this ).css( { 'background-color': 'transparent' } );
									}
								);

							}
						},
						'json'
					);

				}
			);
		}
	);

	/**
	 * the dialog triggered by the TinyMCE Button
	 */
	ccDialog  = {

		/**
		 * the formular
		 *
		 * @var Object
		 */
		dialog : null,

		/**
		 * start the magic for the dialog box
		 *
		 * @return void
		 */
		init : function() {

			// any tinymce here?
			if ( 'undefined' == typeof( edCanvas ) )
				return; //no!
			//tinyMCEPopup is still undefined at this point

			ccDialog.dialog = $( '#wp-cc-mce-popup' );
			ccDialog.dialog.submit( ccDialog.submit );
			ccDialog.dialog._focus( ccDialog.updateOptions );
			// close the dialog on 'ESC'
			$( document ).keyup(
				function( e ) {
					if ( 27 == e.keyCode ) {
						e.preventDefault();
						ccDialog.close();
					}
				}
			);

		},

		/**
		 * build the shortcode and append id to the cursor-possition
		 *
		 * @param e Event
		 * @return false
		 */
		submit : function( e ) {

			e.preventDefault();
			var codeblock = null;
			var language  = null;
			codeblock = ccDialog.dialog.find( '#wp-cc-dialog-options-codeblocks select' ).val();
			language  = ccDialog.dialog.find( '#wp-cc-dialog-options-language select' ).val();

			//no values at all?
			if ( ! codeblock && ! language ) {
				ccDialog.close();
				return false;
			}

			//the shortcode
			if ( codeblock )
				var sc = '[cc name="' + codeblock + '"/]';
			else if ( language )
				var sc = '[cc lang="' + language + '"][/cc]';


			//TinyMCE Mode (richt text editor)
			if ( ccDialog.isMCE() ) {
				e = tinyMCEPopup.editor;
				tinyMCEPopup.restoreSelection();
				e.execCommand( 'mceInsertContent', false, sc );
			}

			ccDialog.close();
			return false;

		},

		/**
		 * get the lates shortcodes from wp
		 *
		 * @param e Event (Optional)
		 * @return void
		 */
		updateOptions : function( e ) {

			$.post(
				wpCcGlobals.AjaxUrl,
				{
					nonce    : $( '#wp-cc-dialog-nonce' ).val(),
					action   : wpCcGlobals.UpdateOptionsAction,
					name     : 'wp-cc-dialog-codeblocks',
					pid      : wpCcGlobals.PostID
				},
				function( data ) {
					//data is a html string
					$( '#wp-cc-dialog-options-codeblocks' ).html( data );
				}
			);
		},

		/**
		 * viewing the richtext-mode of tinymce?
		 *
		 * @return bool
		 */
		isMCE : function() {

			if ( 'undefined' !== typeof( tinyMCEPopup )
			  && 'undefined' !== typeof( tinyMCEPopup.editor )
			  && ! tinyMCEPopup.editor.isHidden()
			) {
				return true;
			}
			return false;
		},

		/**
		 * close the dialog window
		 *
		 * @param e Event (optional)
		 * @return false
		 */
		close : function( e ) {

			if ( e && 'function' == typeof( e.preventDefault ) )
				e.preventDefault();

			ccDialog.dialog.wpdialog( 'close' );
			return false;
		}
	};
	$( document ).ready( ccDialog.init );


	/**
	 * polyfill for datalist-elements
	 */
	$( document ).ready(
		function() {
			if ( ! Modernizr.input.list || ( parseInt( $.browser.version ) > 400 ) ) {
				$( '.cc-lang' ).relevantDropdown();
			}
		}
	);

} )(jQuery);
