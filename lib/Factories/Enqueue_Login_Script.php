<?php


namespace Underpin\Scripts\Factories;


use Underpin\Abstracts\Observer;
use Underpin\Abstracts\Storage;
use Underpin\Loaders\Logger;
use Underpin\Scripts\Abstracts\Script;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Enqueue_Login_Script extends Observer {

	public $description = 'Sets up script params necessary for AJAX and REST requests';
	public $name        = 'REST Middleware';

	public function update( $instance, Storage $args ) {
		if ( $instance instanceof Script ) {
			add_action( 'login_enqueue_scripts', [ $instance, 'enqueue' ] );
		} else {
			Logger::log( 'warning', 'rest_middleware_action_failed_to_run', 'Middleware action failed to run. Rest_Middleware expects to run on a Script loader.', [
				'loader'  => get_class( $instance ),
				'expects' => 'Underpin\Scripts\Abstracts\Script',
			] );
		}
	}

}