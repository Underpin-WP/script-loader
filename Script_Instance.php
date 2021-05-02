<?php
/**
 * Script Factory
 *
 * @since   1.0.0
 * @package Underpin\Abstracts
 */


namespace Underpin_Scripts\Factories;


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

	public function __construct( $args = [] ) {
		// Override default params.
		foreach ( $args as $arg => $value ) {
			if ( isset( $this->$arg ) ) {
				$this->$arg = $value;
				unset( $args[ $arg ] );
			}
		}

		parent::__construct();
	}

}