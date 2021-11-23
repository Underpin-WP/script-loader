<?php
namespace Underpin\Scripts\Factories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Enqueue_Admin_Script_Conditional extends Enqueue_Script_Conditional {
	protected $should_enqueue_callback;

	public $description = 'Conditionally Enqueues a script in the admin area';
	public $name        = 'Enqueue Admin Script';

	function do_actions() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
	}
}