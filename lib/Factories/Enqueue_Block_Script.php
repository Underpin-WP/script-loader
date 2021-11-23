<?php


namespace Underpin\Scripts\Factories;


use Underpin\Abstracts\Storage;
use Underpin\Scripts\Abstracts\Enqueue_Conditional;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Enqueue_Block_Script extends Enqueue_Conditional {

	protected $should_enqueue_callback;

	public $description = 'Enqueues a script on admin pages using the block editor';
	public $name        = 'Enqueue Block Script';

	public function update( $instance, Storage $args ) {
		parent::update( $instance, $args );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	protected function should_enqueue() {
		return get_current_screen()->is_block_editor();
	}

}