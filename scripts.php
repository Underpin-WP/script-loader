<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add this loader.
add_action( 'underpin/before_setup', function ( $file, $class ) {
	require_once( plugin_dir_path( __FILE__ ) . 'Script.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'Scripts.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'Script_Instance.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'Enqueue_Admin_Script.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'Enqueue_Script.php' );
	Underpin\underpin()->get( $file, $class )->loaders()->add( 'scripts', [
		'registry' => 'Underpin_Scripts\Loaders\Scripts',
	] );
}, 5, 2 );