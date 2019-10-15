<?php
declare( strict_types=1 );
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

use FontAwesome\IconRenderer;
use Parser;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
 *
 * @since 1.0
 * @ingroup FontAwesome
 */
class ParserFirstCallInit {
	/**
	 * @var Parser
	 */
	private $parser;

	/**
	 * ParserFirstCallInit constructor.
	 *
	 * @param Parser $parser
	 */
	public function __construct( Parser &$parser ) {
		$this->parser = $parser;
	}

	/**
	 * @return bool
	 * @throws \MWException
	 * @since  1.0
	 */
	public function process(): bool {

		$this->registerIconRenderer( 'far', 'far', 'ext.fontawesome.styles.regular' );
		$this->registerIconRenderer( 'fas', 'fas', 'ext.fontawesome.styles.solid' );
		$this->registerIconRenderer( 'fab', 'fab', 'ext.fontawesome.styles.brands' );

		return true;
	}

	/**
	 * @param string $fontClass
	 * @param string $fontModule
	 * @param string $parserFunctionName
	 *
	 * @throws \MWException
	 */
	private function registerIconRenderer( string $parserFunctionName, string $fontClass, string $fontModule ) {
		$renderer = new IconRenderer( $fontClass, $fontModule );
		$this->parser->setFunctionHook( $parserFunctionName, [ $renderer, 'render' ], Parser::SFH_OBJECT_ARGS );
	}

}
