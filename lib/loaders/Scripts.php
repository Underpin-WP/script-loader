<?php
/**
 * Script Loader
 *
 * @since   1.0.0
 * @package Underpin\Registries\Loaders
 */


namespace Underpin_Scripts\Loaders;

use Underpin\Abstracts\Registries\Object_Registry;
use Underpin_Scripts\Abstracts\Script;
use WP_Error;
use function Underpin\underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Scripts
 * Loader for scripts
 *
 * @since   1.0.0
 * @package Underpin\Registries\Loaders
 */
class Scripts extends Object_Registry {

	/**
	 * @inheritDoc
	 */
	protected $abstraction_class = '\Underpin_Scripts\Abstracts\Script';

	protected $default_factory = '\Underpin_Scripts\Factories\Script_Instance';

	/**
	 * @inheritDoc
	 */
	protected function set_default_items() {}

	/**
	 * @param string $key
	 * @return Script|WP_Error Script Resulting script class, if it exists. WP_Error, otherwise.
	 */
	public function get( $key ) {
		return parent::get( $key );
	}

	/**
	 * Sets a localized param for the specified script.
	 *
	 * @since 1.0.0
	 *
	 * @param string $script The script ID
	 * @param string $key    Localized param key
	 * @param mixed  $value  Localized param value
	 * @return true|WP_Error True if set, otherwise WP_Error.
	 */
	public function set_param( $script, $key, $value ) {
		$script = $this->get( $script );

		if ( is_wp_error( $script ) ) {
			return underpin()->logger()->log_as_error(
				'error',
				'set_param_invalid_script',
				'A param was not set because the script could not be found',
				$script
			);
		}

		return $script->set_param( $key, $value );
	}

	/**
	 * removes a localized param for the specified script.
	 *
	 * @since 1.0.0
	 *
	 * @param string $script The script ID
	 * @param string $key    Localized param key to remove
	 * @return true|WP_Error True if removed, otherwise WP_Error.
	 */
	public function remove_param( $script, $key ) {
		$script = $this->get( $script );

		if ( is_wp_error( $script ) ) {
			return underpin()->logger()->log_as_error(
				'error',
				'set_param_inavlid_script',
				'A param was not set because the script could not be found',
				$script
			);
		}

		return $script->remove_param( $key );
	}

	/**
	 * Enqueues a script.
	 *
	 * @since 1.0.0
	 *
	 * @param string $handle The script that should be enqueued.
	 * @return true|WP_Error true if the script was enqueued. A WP Error otherwise.
	 */
	public function enqueue( $handle ) {
		$script = $this->get( $handle );

		if ( $script instanceof Script ) {
			$script->enqueue();

			return true;
		} else {
			return underpin()->logger()->log_as_error(
				'error',
				'script_not_enqueued',
				'The specified script could not be enqueued because it has not been registered.',
				$handle
			);
		}
	}
}