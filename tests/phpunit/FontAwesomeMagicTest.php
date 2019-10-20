<?php
declare(strict_types=1);
/**
 * File containing the FontAwesomeMagicTest class
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

use PHPUnit\Framework\TestCase;

/**
 * @ingroup Test
 * @ingroup FontAwesome
 *
 * @group extensions-font-awesome
 * @group mediawiki-databaseless
 */
class FontAwesomeMagicTest extends TestCase {

	public function testMagicWords() {

		include __DIR__ . '/../../src/FontAwesome.magic.php';

		self::assertTrue( is_array( $magicWords ) );

		self::assertArrayHasKey( 'en', $magicWords );
		self::assertArrayHasKey( 'far', $magicWords[ 'en' ] );
		self::assertArrayHasKey( 'fas', $magicWords[ 'en' ] );
		self::assertArrayHasKey( 'fab', $magicWords[ 'en' ] );
	}

}
