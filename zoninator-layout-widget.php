<?php
/**
 * Plugin Name: Zoninator Layout Widget
 * Description: A widget for displaying zoninator zones with layout controls.
 * Version: 1.0.0
 * Author: Human Made Ltd
 * Author URI: https://hmn.md
 * Text Domain: zoninator-widget
 * Domain Path: /languages
 */

add_action( 'after_setup_theme', function() {

	if ( ! class_exists( 'Extended_Widget' ) ) {
		return;
	}

	require_once __DIR__ . '/class-zoninator-layout.php';
	require_once __DIR__ . '/class-zoninator-layout-widget.php';

	add_action( 'widgets_init', array( 'Z_Zoninator_Layout_Widget', 'register' ) );

} );
