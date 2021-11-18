<?php

namespace Underpin_Scripts\Abstracts;


use Underpin\Abstracts\Middleware;
use function Underpin\underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Enqueue_Conditional extends Middleware {
	public function enqueue() {
		// Only enqueue if this is the block editor.
		if ( $this->should_enqueue() ) {
			if ( $this->loader_item instanceof Script ) {
				$this->loader_item->enqueue();
			} else {
				underpin()->logger()->log( 'warning', 'rest_middleware_action_failed_to_run', 'Middleware action failed to run. Rest_Middleware expects to run on a Script loader.', [
					'loader'  => get_class( $this->loader_item ),
					'expects' => 'Underpin_Scripts\Abstracts\Script',
				] );
			}
		}
	}

	abstract protected function should_enqueue();
}