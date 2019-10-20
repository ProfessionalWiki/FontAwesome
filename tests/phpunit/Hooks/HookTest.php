<?php
declare(strict_types=1);
/**
 * File containing the HookTest class
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

use ConfigException;
use FontAwesome\Hooks\Hook;
use HashConfig;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @uses \FontAwesome\Hooks\Hook
 *
 * @ingroup Test
 * @ingroup FontAwesome
 *
 * @group extensions-font-awesome
 * @group mediawiki-databaseless
 */
class HookTest extends TestCase {

	/**
	 * @throws \ReflectionException
	 */
	public function testGetParams() {

		$reflector = new ReflectionClass( Hook::class );

		$getConfigParam = $reflector->getMethod( 'getConfigParam' );
		$getConfigParam->setAccessible( true );

		$getHookParam = $reflector->getMethod( 'getHookParam' );
		$getHookParam->setAccessible( true );

		$testInstance = $this->getMockForAbstractClass( Hook::class, [ new HashConfig( [ 'foo' => 'bar', 'baz' => 'quok' ] ), 'arg0', 'arg1' ] );

		$observed = $getConfigParam->invokeArgs( $testInstance, [ 'foo' ] );
		self::assertEquals( 'bar', $observed );

		$observed = $getConfigParam->invokeArgs( $testInstance, [ 'baz' ] );
		self::assertEquals( 'quok', $observed );

		$observed = $getHookParam->invokeArgs( $testInstance, [ 0 ] );
		self::assertEquals( 'arg0', $observed );

		$observed = $getHookParam->invokeArgs( $testInstance, [ 1 ] );
		self::assertEquals( 'arg1', $observed );

		$this->expectException( ConfigException::class );
		$getConfigParam->invokeArgs( $testInstance, [ 'quuz' ] );
	}

}
