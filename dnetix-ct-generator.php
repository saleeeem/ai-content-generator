<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Devnetix Content Generator
 * Plugin URI:        
 * Description:       Right now this plugin is under development we will explain later on...
 * Version:           1.0.0
 * Author:            Ammar	
 * Author URI:        https://devnetix.net
 * Text Domain:       devnetix-content-generator
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { 
	die;
}

// Load core packages and the autoloader.
require plugin_dir_path( __FILE__ ) . '/inc/admin/class-dev-ntx-global.php';
require plugin_dir_path( __FILE__ ) . '/inc/admin/class-dev-ntx-scripts.php';
require plugin_dir_path( __FILE__ ) . '/inc/admin/class-dev-ntxs-settings.php';
require plugin_dir_path( __FILE__ ) . '/inc/admin/class-dev-ntx-metaboxes.php';
