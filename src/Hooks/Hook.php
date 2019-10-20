<?php
declare(strict_types=1);
/**
 * File containing the Hook class
 *
 * @copyright 2019, Stephan Gambke
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki extension Bootstrap.
 * The Bootstrap extension is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Bootstrap extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup FontAwesome
 */

namespace FontAwesome\Hooks;


use Config;

/**
 * @ingroup FontAwesome
 */
abstract class Hook {

	protected $configuration;
	protected $params;

	/**
	 * ResourceLoaderRegisterModules constructor.
	 *
	 * @param Config $configuration
	 * @param array $params
	 */
	final public function __construct( Config $configuration, ...$params ) {
		$this->configuration = $configuration;
		$this->params = $params;
	}

	/**
	 * @return bool
	 */
	abstract public function process(): bool;

	/**
	 * @param $key
	 * @return mixed
	 */
	protected function getConfigParam( $key ) {
		return $this->configuration->get( $key );
	}

	/**
	 * @param int $index
	 * @return mixed
	 */
	protected function getHookParam( int $index ) {
		return $this->params[ $index ];
	}
}