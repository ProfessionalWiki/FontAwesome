<?php
declare(strict_types=1);
/**
 * File containing the JavascriptRenderer class
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

namespace FontAwesome\IconRenderers;

use Html;
use Parser;
use PPFrame;

/**
 * Class JavascriptRenderer
 *
 * @since 1.0
 * @ingroup FontAwesome
 */
class JavascriptRenderer implements IconRenderer {

	private $fontClass;
	private $useScripts;

	private $isModuleRegistered = false;

	/**
	 * IconRenderer constructor.
	 *
	 * @param string $fontClass
	 */
	public function __construct( string $fontClass ) {
		$this->fontClass = $fontClass;
		$this->useScripts = true;
	}

	/**
	 * @param Parser $parser
	 * @param PPFrame $frame
	 * @param string[] $args
	 *
	 * @return string
	 */
	public function render( Parser $parser, PPFrame $frame, array $args ): string {

		$this->registerRlModule( $parser );
		
		switch (sizeof($args)) {
			case "1": return Html::element( 'i', [ 	'class' => [ $this->fontClass, 'fa-' . trim( $frame->expand( $args[ 0 ] ) ) ] ] );
			case "2": return Html::element( 'i', [ 	'class' => [ $this->fontClass, 'fa-' . trim( $frame->expand( $args[ 0 ] ) ) ] ,
								'style' => trim( $frame->expand( $args[ 1 ] ) )                               ] );
			default : return Html::element( 'i', [ 	'class' => [ $this->fontClass, 'fa-' . trim( $frame->expand( $args[ 0 ] ) ) ] ,
								'style' => trim( $frame->expand( $args[ 1 ] ) )                               ,
								'data-fa-transform' => trim( $frame->expand( $args[ 2 ] ) )                   ] );
		}
	}

	/**
	 * @param Parser $parser
	 */
	private function registerRlModule( Parser $parser ) {

		if ( $this->isModuleRegistered ) {
			return;
		}

		$this->isModuleRegistered = true;
		$parser->getOutput()->addModules( $this->getFontModules() );
	}

	/**
	 * @return string[]
	 */
	private function getFontModules(): array {
		return [ 'ext.fontawesome.' . $this->fontClass ];
	}

}
