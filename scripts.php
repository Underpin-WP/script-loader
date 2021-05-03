<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add this loader.
add_action( 'underpin/before_setup', function ( $class ) {
	if ( 'Underpin\Underpin' === $class ) {
		require_once( plugin_dir_path( __FILE__ ) . 'Script.php' );
		require_once( plugin_dir_path( __FILE__ ) . 'Scripts.php' );
		require_once( plugin_dir_path( __FILE__ ) . 'Script_Instance.php' );
		Underpin\underpin()->loaders()->add( 'scripts', [
			'instance' => 'Underpin_Scripts\Abstracts\Script',
			'registry' => 'Underpin_Scripts\Loaders\Scripts',
		] );
	}
} );