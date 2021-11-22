<?php


namespace Underpin_Scripts\Factories;


use Underpin\Abstracts\Observer;
use Underpin\Abstracts\Storage;
use Underpin_Scripts\Abstracts\Script;
use function Underpin\underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Enqueue_Script extends Observer {

	public $description = 'Enqueues a script on the front end';
	public $name        = 'Enqueue Script';

	public function update( $instance, Storage $args ) {
		if ( $instance instanceof Script ) {
			add_action( 'wp_enqueue_scripts', [ $instance, 'enqueue' ] );
		} else {
			underpin()->logger()->log( 'warning', 'rest_middleware_action_failed_to_run', 'Middleware action failed to run. Rest_Middleware expects to run on a Script loader.', [
				'loader'  => get_class( $instance ),
				'expects' => 'Underpin_Scripts\Abstracts\Script',
			] );
		}
	}

}