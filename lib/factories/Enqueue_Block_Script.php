<?php


namespace Underpin_Scripts\Factories;


use Underpin_Scripts\Abstracts\Enqueue_Conditional;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Enqueue_Block_Script extends Enqueue_Conditional {

	protected $should_enqueue_callback;

	public $description = 'Enqueues a script on admin pages using the block editor';
	public $name        = 'Enqueue Block Script';

	function do_actions() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	protected function should_enqueue() {
		return get_current_screen()->is_block_editor();
	}

}