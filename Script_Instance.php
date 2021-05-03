<?php
/**
 * Script Factory
 *
 * @since   1.0.0
 * @package Underpin\Abstracts
 */


namespace Underpin_Scripts\Factories;


use Underpin\Traits\Instance_Setter;
use Underpin_Scripts\Abstracts\Script;
use function Underpin\underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Script_Instance
 * Handles creating custom admin bar menus
 *
 * @since   1.0.0
 * @package Underpin\Abstracts
 */
class Script_Instance extends Script {
	use Instance_Setter;

	public function __construct( $args = [] ) {
		// Override default params.
		$this->set_values( $args );

		parent::__construct();
	}

}