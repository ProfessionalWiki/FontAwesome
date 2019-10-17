<?php
declare( strict_types=1 );
/**
 * File containing the SetupAfterCache class
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

use Html;
use Parser;
use PPFrame;

/**
 * Class IconRenderer
 *
 * @since 1.0
 * @ingroup FontAwesome
 */
class IconRenderer {

	private $fontClass;
	private $fontModule;

	/**
	 * IconRenderer constructor.
	 *
	 * @param string $fontClass
	 * @param string $fontModule
	 */
	public function __construct( string $fontClass, string $fontModule ) {
		$this->fontClass = $fontClass;
		$this->fontModule = $fontModule;
	}

	/**
	 * @param Parser $parser
	 * @param PPFrame $frame
	 * @param $args
	 *
	 * @return string
	 */
	public function render( Parser $parser, PPFrame $frame, $args ): string {

		$modules = [ 'ext.fontawesome.styles', $this->fontModule ];
		$parser->getOutput()->addModuleStyles( array_combine( $modules, $modules ) );

		return Html::element( 'ite	', [ 'class' => [ $this->fontClass, 'fa-' . trim( $frame->expand( $args[ 0 ] ) ) ] ] );
	}

}