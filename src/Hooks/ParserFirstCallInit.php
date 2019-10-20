<?php
declare(strict_types=1);
/**
 * File containing the ParserFirstCallInit class
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

use FontAwesome\IconRenderers\JavascriptRenderer;
use FontAwesome\IconRenderers\WebfontRenderer;
use MWException;
use Parser;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
 *
 * @ingroup FontAwesome
 */
class ParserFirstCallInit extends Hook {

	private static $parserFunctionToFontClass = [
		'far' => 'far',
		'fas' => 'fas',
		'fab' => 'fab',
	];

	/**
	 * @return bool
	 * @throws MWException
	 */
	public function process(): bool {

		$rendererClass = $this->getRendererClass();

		foreach ( self::$parserFunctionToFontClass as $parserFunction => $fontClass ) {
			$this->registerIconRenderer( $parserFunction, $fontClass, $rendererClass );
		}

		return true;
	}

	/**
	 * @param string $parserFunctionName
	 * @param string $fontClass
	 * @param string $rendererClass
	 */
	private function registerIconRenderer( string $parserFunctionName, string $fontClass, string $rendererClass ) {

		$renderer = new $rendererClass( $fontClass );
		$this->getHookParam( 0 )->setFunctionHook( $parserFunctionName, [ $renderer, 'render' ], Parser::SFH_OBJECT_ARGS );
	}

	/**
	 * @param string $fontClass
	 *
	 * @return string
	 * @throws MWException
	 */
	private function getRendererClass(): string {
		switch ( $this->getConfigParam( 'FaRenderMode' ) ) {
			case 'javascript':
				return JavascriptRenderer::class;
			case 'webfonts':
				return WebfontRenderer::class;
			default:
				throw new MWException( 'Unexpected Font Awesome render mode.' );
		}
	}

}
