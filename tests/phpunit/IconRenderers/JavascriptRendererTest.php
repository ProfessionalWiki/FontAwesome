<?php
declare( strict_types=1 );
/**
 * File containing the JavascriptRendererTest class
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

use FontAwesome\IconRenderers\IconRenderer;
use FontAwesome\IconRenderers\JavascriptRenderer;
use Html;
use Parser;
use ParserOutput;
use PHPUnit\Framework\TestCase;
use PPFrame;

/**
 * @covers \FontAwesome\IconRenderers\JavascriptRenderer
 *
 * @uses \FontAwesome\IconRenderers\JavascriptRenderer
 *
 * @ingroup Test
 * @ingroup FontAwesome
 *
 * @group extensions-font-awesome
 * @group mediawiki-databaseless
 */
class JavascriptRendererTest extends TestCase {

	public function testCanConstruct() {
		$renderer = new JavascriptRenderer( 'foo', 'foobar' );

		static::assertInstanceOf(
			JavascriptRenderer::class,
			$renderer
		);

		static::assertInstanceOf(
			IconRenderer::class,
			$renderer
		);
	}

	public function testRender() {
		$magicWord = 'foo';
		$fontClass = 'foobar';
		$icon1 = 'bar';
		$icon2 = 'baz';

		$modules = [ 'ext.fontawesome.' . $magicWord ];

		$output = $this->createMock( ParserOutput::class );
		$output->expects( static::once() )
			->method( 'addModules' )
			->with( static::equalTo( $modules ) );

		$parser = $this->createMock( Parser::class );
		$parser->method( 'getOutput' )
			->willReturn( $output );

		$frame = $this->createMock( PPFrame::class );
		$frame->method( 'expand' )
			->will( static::returnArgument( 0 ) );

		$renderer = new JavascriptRenderer( $magicWord, $fontClass );

		$expected = Html::element( 'i', [ 'class' => [ $fontClass, "fa-$icon1" ] ] );
		$observed = $renderer->render( $parser, $frame, [ $icon1 ] );

		static::assertEquals( $expected, $observed );

		$expected = Html::element( 'i', [ 'class' => [ $fontClass, "fa-$icon2" ] ] );
		$observed = $renderer->render( $parser, $frame, [ $icon2 ] );

		static::assertEquals( $expected, $observed );
	}
}
