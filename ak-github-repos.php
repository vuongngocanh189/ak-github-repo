<?php
/**
* Plugin Name: AK Github Repos
* Description: A plugin to list personal github repo
* Version: 1.0
*
**/

// Exit if Accessed Directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Load Scripts
require_once(plugin_dir_path(__FILE__) . '/includes/ak-github-repos-scripts.php');
require_once(plugin_dir_path(__FILE__) . '/includes/ak-github-repos-class.php');

// Register widget
function ak_gitgub_register_widgets() {
	register_widget( 'AK_Github_Repos' );
}

add_action( 'widgets_init', 'ak_gitgub_register_widgets' );
