<?php
declare(strict_types=1);
/**
 * File containing the ParserFirstCallInitTest class
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

use FontAwesome\Hooks\ParserFirstCallInit;
use FontAwesome\IconRenderers\JavascriptRenderer;
use FontAwesome\IconRenderers\WebfontRenderer;
use HashConfig;
use MWException;
use Parser;
use PHPUnit\Framework\TestCase;

/**
 * @uses \FontAwesome\Hooks\ParserFirstCallInit
 *
 * @ingroup Test
 * @ingroup FontAwesome
 *
 * @group extensions-font-awesome
 * @group mediawiki-databaseless
 */
class ParserFirstCallInitTest extends TestCase {

	public function testCanConstruct() {

		$config = new HashConfig();
		$hook = new ParserFirstCallInit( $config );

		self::assertInstanceOf( ParserFirstCallInit::class, $hook );
	}

	public function testInvalidRenderMode() {

		$config = new HashConfig( [ 'FaRenderMode' => 'foo' ] );

		$hook = new ParserFirstCallInit( $config );

		$this->expectException( MWException::class );
		$hook->process();
	}

	/**
	 * @dataProvider rendererProvider
	 *
	 * @param string $renderMode
	 * @param string $rendererClass
	 *
	 * @throws MWException
	 */
	public function testProcess( string $renderMode, string $rendererClass ) {

		$config = new HashConfig( [ 'FaRenderMode' => $renderMode ] );

		$parser = $this->createMock( Parser::class );
		$parser->expects( self::exactly( 3 ) )
			->method( 'setFunctionHook' )
			->with(

				self::callback( function( $id ) {
					return in_array( $id, [ 'far', 'fas', 'fab' ] );
				} ), // string $id The magic word ID

				self::callback( function( $cb ) use ( $rendererClass ) {
					return is_callable( $cb ) && $cb[ 0 ] instanceof $rendererClass && $cb[ 1 ] === 'render';
				} ), // callable $callback The callback function (and object) to use

				self::callback( function( $flags ) {
					return is_int( $flags );
				} ) // int $flags A combination of flags
			);


		$hook = new ParserFirstCallInit( $config, $parser );

		self::assertTrue( $hook->process() );
	}

	/**
	 * @return string[][]
	 */
	public function rendererProvider() {
		return [
			[ 'javascript', JavascriptRenderer::class ],
			[ 'webfonts', WebfontRenderer::class ],
		];
	}

}
