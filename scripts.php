<?php

use Underpin\Abstracts\Underpin;
use function Underpin\underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add this loader.
Underpin::attach( 'setup', new \Underpin\Factories\Observer( 'scripts', [
	'update' => function ( Underpin $plugin, $args ) {
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
		$plugin->loaders()->add( 'scripts', [
			'class' => 'Underpin_Scripts\Loaders\Scripts',
		] );
	},
] ) );