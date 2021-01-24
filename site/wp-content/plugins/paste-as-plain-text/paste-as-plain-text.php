<?php
/*
Plugin Name: Paste as Plain Text
Plugin URI: http://wordpress.org/plugins/paste-as-plain-text/
Description: Forces the WordPress editor to paste everything as plain text.
Version: 1.0.1
Author: Till Krüss
Author URI: http://till.kruss.me/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Copyright 2014 Till Krüss  (http://till.kruss.me/)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Paste as Plain Text
 * @copyright 2014 Till Krüss
 */

class TK_PasteAsPlainText {

	function __construct() {

		add_action( 'admin_init', array( $this, 'init' ) );

	}

	function init() {

		add_filter( 'tiny_mce_before_init', array( $this, 'forcePasteAsPlainText' ) );
		add_filter( 'teeny_mce_before_init', array( $this, 'forcePasteAsPlainText' ) );
		add_filter( 'teeny_mce_plugins', array( $this, 'loadPasteInTeeny' ) );
		add_filter( 'mce_buttons_2', array( $this, 'removePasteAsPlainTextButton' ) );

	}

	function forcePasteAsPlainText( $mceInit ) {

		global $tinymce_version;

		if ( $tinymce_version[0] < 4 ) {
			$mceInit[ 'paste_text_sticky' ] = true;
			$mceInit[ 'paste_text_sticky_default' ] = true;
		} else {
			$mceInit[ 'paste_as_text' ] = true;
		}

		return $mceInit;
	}

	function loadPasteInTeeny( $plugins ) {

		return array_merge( $plugins, (array) 'paste' );

	}

	function removePasteAsPlainTextButton( $buttons ) {

		if( ( $key = array_search( 'pastetext', $buttons ) ) !== false ) {
			unset( $buttons[ $key ] );
		}

		return $buttons;

	}

}

new TK_PasteAsPlainText();
