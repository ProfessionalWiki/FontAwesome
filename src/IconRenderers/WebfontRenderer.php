<?php
declare( strict_types=1 );
/**
 * File containing the WebfontRenderer class
 *
 * @copyright 2019, Stephan Gambke
 * @license   GPL-3.0-or-later
 *
 * This file is part of the MediaWiki extension FontAwesome.
 * The FontAwesome extension is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The FontAwesome extension is distributed in the hope that it will be useful,
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

use MediaWiki\Html\Html;
use Parser;
use PPFrame;

/**
 * Class WebfontRenderer
 *
 * @since 1.0
 * @ingroup FontAwesome
 */
class WebfontRenderer implements IconRenderer {
	/**
	 * @var bool Tracks whether the ResourceLoader module has been registered
	 */
	private bool $isModuleRegistered = false;

	private string $magicWord;

	/**
	 * @var string CSS class for the font
	 */
	private string $fontClass;

	public function __construct(
		string $magicWord,
		string $fontClass
	) {
		$this->magicWord = $magicWord;
		$this->fontClass = $fontClass;
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
		$iconClass = 'fa-' . trim( $frame->expand( $args[0] ) );
		$attributes = [ 'class' => [ $this->fontClass, $iconClass ] ];

		if ( count( $args ) > 1 ) {
			$style = trim( $frame->expand( $args[1] ) );
			// Consider adding HTML sanitization for the style attribute
			$attributes['style'] = $style;
		}

		return Html::element( 'i', $attributes );
	}

	/**
	 * @param Parser $parser
	 */
	private function registerRlModule( Parser $parser ) {
		if ( $this->isModuleRegistered ) {
			return;
		}

		$this->isModuleRegistered = true;

		$parser->getOutput()->addModuleStyles( $this->getFontModules() );
	}

	/**
	 * @return string[]
	 */
	private function getFontModules(): array {
		return [ 'ext.fontawesome' => 'ext.fontawesome', 'ext.fontawesome.' . $this->magicWord ];
	}

}
