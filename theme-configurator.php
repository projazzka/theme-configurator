<?php
/*
Plugin Name: Theme Configurator
Plugin URI: http://www.l90r.com/posts/wordpress-theme-configurator
Description: The most elegant way to add a settings screen to your theme
Version: 0.1
Author: Igor Prochazka
Author URI: http://www.l90r.com/

---------------------------------------------------------------------
    This file is part of the wordpress plugin "Theme Configurator"
    Copyright (C) 2009 by Igor Prochazka

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

---------------------------------------------------------------------
*/

/* register hooks */

add_action('admin_menu', 'thcfg_admin_menu' );
add_action('admin_init', 'thcfg_admin_init');

define('THCFG_PATH', dirname(__FILE__));
define('THCFG_URL', plugins_url() . '/' . basename(dirname(__FILE__)));

function thcfg_admin_menu() {
	$name = add_theme_page('Settings', 'Settings', 'edit_pages', 'Settings', 'thcfg_admin_page' );
	add_action('admin_head-' . $name, 'thcfg_admin_head' );
    wp_enqueue_script( 'jquery-ui-sortable' );
}

function thcfg_admin_init() {
 	add_settings_field('thcfg_advanced', 'Theme Configurator Advanced Mode', 'thcfg_settings_cb', 'general');
 	register_setting('general','thcfg_advanced');
}

function thcfg_settings_cb() {
	echo '<input name="thcfg_advanced" id="thcfg_advanced" type="checkbox" value="1" class="code" '
	. checked( 1, get_option('thcfg_advanced'), false ) . ' /> Show advanced Theme Configurator options (for theme developers)';
	
}

function thcfg_create_controller() {
	if($_REQUEST['thcfg_admin']) {
		require_once(THCFG_PATH . '/Admin.php');
		return new Thcfg_Admin();
	} else {
		require_once(THCFG_PATH . '/Main.php');
		return new Thcfg_Main();
	}
}

function thcfg_admin_page() {
	$control = thcfg_create_controller();
	$control->action();
}

function thcfg_admin_head() {
	$dir = plugin_basename(__FILE__);
	$control = thcfg_create_controller();
	$control->header();
}


?>