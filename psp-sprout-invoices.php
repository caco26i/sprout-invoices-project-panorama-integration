<?php

/**
 * @package psp_sprout_invoices
 * @version 1.2
 */

/*
 * Plugin Name: Panorama Sprout Invoices
 * Plugin URI: https://www.projectpanorama.com/add-ons/sprout-invoices
 * Description: Integrate <a href="https://sproutapps.co/sprout-invoices/" target="_new">Sprout Invoices</a> with Project Panorama
 * Author: Snap Orbital & Sprout Apps
 * Version: 1.2
 * Author URI: https://snaporbital.com
 * Text Domain: pspsi
 * Domain Path: languages
*/

/**
 * Integration directory
 */
define( 'PSPSI_DIR', WP_PLUGIN_DIR . '/' . basename( dirname( __FILE__ ) ) );

/**
 * Plugin File
 */
define( 'PSPSI_DIR_FILE', __FILE__ );

define( 'PSPSI_PATH', dirname( __FILE__ ) );

define( 'PSPSI_URL', plugins_url( '', __FILE__ ) );

define( 'PSPSI_VER', '1.0' );

/**
 * Initialize the plugin
 */
require_once( 'load.php' );

add_action( 'plugins_loaded', 'pspsi_load', 999 );
