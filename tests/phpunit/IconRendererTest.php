<?php
declare( strict_types=1 );
/**
 * File containing the IconRendererTest class
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

use FontAwesome\IconRenderer;
use Html;
use Parser;
use ParserOutput;
use PHPUnit\Framework\TestCase;
use PPFrame;

/**
 * @uses \FontAwesome\IconRenderer
 *
 * @ingroup Test
 * @ingroup FontAwesome
 *
 * @group extensions-font-awesome
 * @group mediawiki-databaseless
 *
 * @since 1.0
 */
class IconRendererTest extends TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			IconRenderer::class,
			new IconRenderer( 'foo', 'bar' )
		);
	}

	public function testRender() {

		$fontClass = 'foo';
		$fontModule = 'bar';
		$icon = 'baz';

		$modules = [ 'ext.fontawesome.styles', $fontModule ];

		$output = $this->createMock( ParserOutput::class );
		$output->expects($this->once())
			->method( 'addModuleStyles' )
			->with( $this->equalTo( array_combine( $modules, $modules )) );

		$parser = $this->createMock( Parser::class );
		$parser->method('getOutput' )
			->willReturn( $output );

		$frame = $this->createMock( PPFrame::class );
		$frame->method( 'expand' )
			->will( $this->returnArgument( 0 ) );

		$renderer = new IconRenderer( $fontClass, $fontModule );

		$expected = Html::element( 'i', [ 'class' => [ $fontClass, "fa-$icon" ] ] );
		$observed = $renderer->render( $parser, $frame, [ $icon ] );

		$this->assertEquals( $expected, $observed );
	}
}
