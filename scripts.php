<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add this loader.
add_action( 'underpin/before_setup', function ( $instance ) {
		require_once( plugin_dir_path( __FILE__ ) . 'Script.php' );
		require_once( plugin_dir_path( __FILE__ ) . 'Scripts.php' );
		require_once( plugin_dir_path( __FILE__ ) . 'Script_Instance.php' );
		$instance->loaders()->add( 'scripts', [
			'registry' => 'Underpin_Scripts\Loaders\Scripts',
		] );
} );