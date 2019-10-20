<?php
declare(strict_types=1);
/**
 * File containing the FontAwesomeTest class
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

namespace FontAwesome\Tests;

use FontAwesome\FontAwesome;
use Parser;
use PHPUnit\Framework\TestCase;
use ResourceLoader;

/**
 * @uses \FontAwesome\FontAwesome
 *
 * @ingroup Test
 * @ingroup FontAwesome
 *
 * @group extensions-font-awesome
 * @group mediawiki-databaseless
 */
class FontAwesomeTest extends TestCase {

	public function testInit() {
		unset( $GLOBALS[ 'wgHooks' ][ 'ParserFirstCallInit' ][ FontAwesome::class ] );
		unset( $GLOBALS[ 'wgHooks' ][ 'ResourceLoaderRegisterModules' ][ FontAwesome::class ] );

		FontAwesome::init();

		self::assertArrayHasKey( FontAwesome::class, $GLOBALS[ 'wgHooks' ][ 'ParserFirstCallInit' ] );
		$hook = $GLOBALS[ 'wgHooks' ][ 'ParserFirstCallInit' ][ FontAwesome::class ];
		self::assertTrue( is_callable( $hook ) );

		$this->checkParserFirstCallInitHook( $hook );

		self::assertArrayHasKey( FontAwesome::class, $GLOBALS[ 'wgHooks' ][ 'ResourceLoaderRegisterModules' ] );
		$hook = $GLOBALS[ 'wgHooks' ][ 'ResourceLoaderRegisterModules' ][ FontAwesome::class ];
		self::assertTrue( is_callable( $hook ) );

		$this->checkResourceLoaderRegisterModules( $hook );
	}

	/**
	 * @param callable $hook
	 */
	private function checkParserFirstCallInitHook( callable $hook ) {

		$GLOBALS[ 'wgFaRenderMode' ] = 'javascript';
		$parser = $this->createMock( Parser::class );

		self::assertTrue( call_user_func( $hook, $parser ) );
	}

	/**
	 * @param callable $hook
	 */
	private function checkResourceLoaderRegisterModules( callable $hook ) {

		$GLOBALS[ 'wgFaRenderMode' ] = 'javascript';
		$rl = $this->createMock( ResourceLoader::class );

		self::assertTrue( call_user_func( $hook, $rl ) );
	}
}
