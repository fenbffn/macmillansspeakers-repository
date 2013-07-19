<?php
/*
Plugin Name: Compare
Plugin URI:
Description: This plugins compare the content of csv file with content into wordpress installations.
Author: César Jaldin
Version: 1.0
Author URI:

Copyright 2013  César Jaldin  (email : rodia.piedra@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Get some constants ready for paths when your plugin grows
 *
 */

define( 'CTT_VERSION', '1.1' );
define( 'CTT_PATH', dirname( __FILE__ ) );
define( 'CTT_PATH_INCLUDES', dirname( __FILE__ ) . '/inc' );
define( 'CTT_FOLDER', basename( CTT_PATH ) );
define( 'CTT_URL', plugins_url() . '/' . CTT_FOLDER );
define( 'CTT_URL_INCLUDES', CTT_URL . '/inc' );

class Compare_Types {

	public function __construct() {

		// add scripts and styles only available in admin
		add_action( 'admin_enqueue_scripts', array( $this, 'tt_add_admin_JS' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'tt_add_admin_CSS' ) );

		// register admin pages for the plugin
		add_action( 'admin_menu', array( $this, 'tt_admin_pages_callback' ) );

		// Register activation and deactivation hooks
		register_activation_hook( __FILE__, 'tt_on_activate_callback' );
		register_deactivation_hook( __FILE__, 'tt_on_deactivate_callback' );
	}

	// This just echoes the chosen line, we'll position it later
	public function prepare_compares() {

	}

	public function tt_add_admin_JS() {
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'script-admin', plugins_url( '/js/script-admin.js' , __FILE__ ), array('jquery'), '1.0', true );
		wp_enqueue_script( 'script-admin' );
	}

	public function tt_add_admin_CSS() {
		wp_register_style( 'style-admin', plugins_url( '/css/style-admin.css', __FILE__ ), array(), '1.0', 'screen' );
		wp_enqueue_style( 'style-admin' );
	}

	public function tt_admin_pages_callback() {
		add_menu_page('Compare Documents', 'Compare Documents', 'edit_themes', 'tt-plugin-base', array( $this, 'tt_plugin_base'));
	}

	public function tt_on_activate_callback() {

	}

	public function tt_on_deactivate_callback() {
		// comment repo
	}

	/**
	 *
	 * The content of the base page
	 *
	 */
	function tt_plugin_base() {
		include_once(CTT_PATH_INCLUDES . '/base-page-template.php' );
	}
}



add_action( 'admin_notices', 'prepare_compares' );
