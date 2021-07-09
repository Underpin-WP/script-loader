<?php


namespace Underpin_Scripts\Factories;


use Underpin\Abstracts\Middleware;
use Underpin_Scripts\Abstracts\Script;
use function Underpin\underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Enqueue_Script extends Middleware {

	public $description = 'Enqueues a script on the front end';
	public $name        = 'Enqueue Script';

	function do_actions() {
		if ( $this->loader_item instanceof Script ) {
			add_action( 'wp_enqueue_scripts', [ $this->loader_item, 'enqueue' ] );
		} else {
			underpin()->logger()->log( 'warning', 'rest_middleware_action_failed_to_run', 'Middleware action failed to run. Rest_Middleware expects to run on a Script loader.', [
				'loader'  => get_class( $this->loader_item ),
				'expects' => 'Underpin_Scripts\Abstracts\Script',
			] );
		}
	}

}