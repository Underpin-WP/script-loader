<?php

namespace Underpin\Scripts\Factories;


use Underpin\Abstracts\Storage;
use Underpin\Loaders\Logger;
use Underpin\Traits\Instance_Setter;
use Underpin\Scripts\Abstracts\Enqueue_Conditional;
use Underpin\Scripts\Abstracts\Script;


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
		parent::__construct( $args );
	}

	public function enqueue() {
		// Only enqueue if this is the block editor.
		if ( $this->should_enqueue() ) {
			if ( $this->loader_item instanceof Script ) {
				$this->loader_item->enqueue();
			} else {
				Logger::log( 'warning', 'rest_middleware_action_failed_to_run', 'Middleware action failed to run. Rest_Middleware expects to run on a Script loader.', [
					'loader'  => get_class( $this->loader_item ),
					'expects' => 'Underpin\Scripts\Abstracts\Script',
				] );
			}
		}
	}

	protected function should_enqueue() {
		return $this->set_callable( $this->should_enqueue_callback, $this->loader_item );
	}

	public function update( $instance, Storage $args ) {
		parent::update( $instance, $args );
		$this->loader_item = $instance;
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
	}

}