<?php
declare( strict_types=1 );
/**
 * The main file of the FontAwesome extension
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


namespace FontAwesome;

use ExtensionRegistryHelper\ExtensionRegistryHelper;
use FontAwesome\Hooks\ParserFirstCallInit;
use FontAwesome\Hooks\SetupAfterCache;
use Parser;

/**
 * Class FontAwesome
 *
 * @since 1.0
 * @ingroup FontAwesome
 */
class FontAwesome {

	/**
	 * @throws \Exception
	 */
	public static function init() {

		ExtensionRegistryHelper::singleton()->loadExtensionRecursive( 'Scss' );

		$GLOBALS[ 'wgHooks' ][ 'SetupAfterCache' ][] = function (): bool {
			$hook = new SetupAfterCache( $GLOBALS );
			return $hook->process();
		};

		$GLOBALS[ 'wgHooks' ][ 'ParserFirstCallInit' ][] = function ( Parser &$parser ): bool {

			$hook = new ParserFirstCallInit( $parser );
			return $hook->process();
		};

	}
}