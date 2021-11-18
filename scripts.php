<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add this loader.
add_action( 'underpin/before_setup', function ( $file, $class ) {
	require_once( plugin_dir_path( __FILE__ ) . 'lib/abstracts/Script.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'lib/abstracts/Enqueue_Conditional.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'lib/loaders/Scripts.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'lib/factories/Script_Instance.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'lib/factories/Enqueue_Admin_Script.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'lib/factories/Enqueue_Login_Script.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'lib/factories/Enqueue_Script.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'lib/factories/Enqueue_Script_Conditional.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'lib/factories/Enqueue_Admin_Script_Conditional.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'lib/factories/Enqueue_Block_Script.php' );
	Underpin\underpin()->get( $file, $class )->loaders()->add( 'scripts', [
		'registry' => 'Underpin_Scripts\Loaders\Scripts',
	] );
}, 5, 2 );