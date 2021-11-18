<?php

namespace Underpin_Scripts\Factories;


use Underpin\Traits\Instance_Setter;
use Underpin_Scripts\Abstracts\Enqueue_Conditional;
use Underpin_Scripts\Abstracts\Script;
use function Underpin\underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Enqueue_Script_Conditional extends Enqueue_Conditional {
	use Instance_Setter;

	public $description = 'Conditionally enqueues a script on the front end';
	public $name        = 'Enqueue Script Conditional';
	protected $should_enqueue_callback;

	public function __construct( $args ) {
		$this->set_values( $args );
	}

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

	protected function should_enqueue() {
		return $this->set_callable( $this->should_enqueue_callback, $this->loader_item );
	}

	function do_actions() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
	}
}