<?php

namespace Underpin\Scripts\Abstracts;


use Underpin\Abstracts\Observer;
use Underpin\Abstracts\Storage;
use Underpin\Loaders\Logger;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Enqueue_Conditional extends Observer {

	public function update( $instance, Storage $args ) {
		$this->instance = $instance;
	}

	public function enqueue() {
		// Only enqueue if this is the block editor.
		if ( $this->should_enqueue() ) {
			if ( $this->instance instanceof Script ) {
				$this->instance->enqueue();
			} else {
				Logger::log( 'warning', 'rest_middleware_action_failed_to_run', 'Middleware action failed to run. Rest_Middleware expects to run on a Script loader.', [
					'loader'  => get_class( $this->instance ),
					'expects' => 'Underpin\Scripts\Abstracts\Script',
				] );
			}
		}
	}

	abstract protected function should_enqueue();
}