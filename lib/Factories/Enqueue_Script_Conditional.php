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

	protected function should_enqueue() {
		return $this->set_callable( $this->should_enqueue_callback, $this->loader_item );
	}

	public function update( $instance, Storage $args ) {
		parent::update( $instance, $args );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
	}

}