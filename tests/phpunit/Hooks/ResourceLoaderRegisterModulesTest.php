<?php
declare(strict_types=1);
/**
 * File containing the ResourceLoaderRegisterModulesTest class
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

use FontAwesome\Hooks\ResourceLoaderRegisterModules;
use HashConfig;
use MediaWiki\ResourceLoader\ResourceLoader;
use MWException;
use PHPUnit\Framework\TestCase;

/**
 * @uses \FontAwesome\Hooks\ResourceLoaderRegisterModules
 *
 * @ingroup Test
 * @ingroup FontAwesome
 *
 * @group extensions-font-awesome
 * @group mediawiki-databaseless
 */
class ResourceLoaderRegisterModulesTest extends TestCase {

	public function testCanConstruct() {

		$config = new HashConfig();
		$hook = new ResourceLoaderRegisterModules( $config );

		self::assertInstanceOf( ResourceLoaderRegisterModules::class, $hook );
	}

	public function testInvalidRenderMode() {

		$config = new HashConfig( [ 'FaRenderMode' => 'foo' ] );

		$hook = new ResourceLoaderRegisterModules( $config );

		$this->expectException( MWException::class );
		$hook->process();
	}

	/**
	 * @dataProvider rendererProvider
	 *
	 * @param string $renderMode
	 * @param string $relativePath
	 * @param array $expected
	 *
	 * @throws MWException
	 */
	public function testProcess( string $renderMode, string $relativePath, array $expected ) {

		$localBasePath = 'someExtensionDirectory';
		$remoteBasePath = 'someExtensionAssetsPath';

		$config = new HashConfig( [
			'FaRenderMode'        => $renderMode,
			'ExtensionDirectory'  => $localBasePath,
			'ExtensionAssetsPath' => $remoteBasePath,
		] );

		foreach ( $expected as $name => $module ) {
			$expected[ $name ][ 'localBasePath' ] = $localBasePath . $relativePath;
			$expected[ $name ][ 'remoteBasePath' ] = $remoteBasePath . $relativePath;
		}

		$rl = $this->createMock( ResourceLoader::class );
		$rl->expects( self::once() )
			->method( 'register' )
			->with(
				self::callback( function( $observed ) use ( $expected ) {
					return $this->checkRlModules( $observed, $expected );
				} ) // array of module info arrays keyed by name
			);

		$hook = new ResourceLoaderRegisterModules( $config, $rl );
		self::assertTrue( $hook->process() );

	}

	/**
	 * @param array $observed
	 * @param array $expected
	 *
	 * @return bool
	 */
	private function checkRlModules( array $observed, array $expected ): bool {

		foreach ( $expected as $moduleName => $expectedModule ) {

			if ( !array_key_exists( $moduleName, $observed ) ) {
				return false;
			}

			$observedModule = $observed[ $moduleName ];

			foreach ( $expectedModule as $key => $value ) {
				if ( !array_key_exists( $key, $observedModule ) ) {
					return false;
				}
				if ( $expectedModule[ $key ] !== $observedModule[ $key ] ) {
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * @return array
	 */
	public
	function rendererProvider() {
		return
			[
				[
					'javascript',
					'/FontAwesome/res/fontawesome/js/',
					[
						'ext.fontawesome'     => [ 'scripts' => 'fontawesome.js' ],
						'ext.fontawesome.far' => [ 'scripts' => 'regular.js', 'dependencies' => [ 'ext.fontawesome' ] ],
						'ext.fontawesome.fas' => [ 'scripts' => 'solid.js', 'dependencies' => [ 'ext.fontawesome' ] ],
						'ext.fontawesome.fab' => [ 'scripts' => 'brands.js', 'dependencies' => [ 'ext.fontawesome' ] ],
					],
				],
				[
					'webfonts',
					'/FontAwesome/res/fontawesome/css/',
					[
						'ext.fontawesome'     => [ 'styles' => 'fontawesome.css' ],
						'ext.fontawesome.far' => [ 'styles' => 'regular.css' ],
						'ext.fontawesome.fas' => [ 'styles' => 'solid.css' ],
						'ext.fontawesome.fab' => [ 'styles' => 'brands.css' ],
					],
				],
			];
	}

}
