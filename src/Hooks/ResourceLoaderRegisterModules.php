<?php
declare( strict_types=1 );
/**
 * File containing the ResourceLoaderRegisterModules class
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


use Config;
use ResourceLoader;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ResourceLoaderRegisterModules
 *
 * @ingroup FontAwesome
 */
class ResourceLoaderRegisterModules {

	private static $moduleDefinitions = [
		'javascript' => [
			'relativePath' => '/FontAwesome/res/fontawesome/js/',
			'modules' => [
				'ext.fontawesome'         => [ 'scripts' => 'fontawesome.js' ],
				'ext.fontawesome.far' => [ 'scripts' => 'regular.js', 'dependencies' => [ 'ext.fontawesome' ] ],
				'ext.fontawesome.fas'   => [ 'scripts' => 'solid.js', 'dependencies' => [ 'ext.fontawesome' ] ],
				'ext.fontawesome.fab'  => [ 'scripts' => 'brands.js', 'dependencies' => [ 'ext.fontawesome' ] ],
			],
		],
		'webfonts'  => [
			'relativePath' => '/FontAwesome/res/fontawesome/css/',
			'modules' => [
				'ext.fontawesome'         => [ 'styles' => 'fontawesome.css' ],
				'ext.fontawesome.far' => [ 'styles' => 'regular.css' ],
				'ext.fontawesome.fas'   => [ 'styles' => 'solid.css' ],
				'ext.fontawesome.fab'  => [ 'styles' => 'brands.css' ],
			],
		],
	];

	private $configuration;
	private $resourceLoader;

	/**
	 * ResourceLoaderRegisterModules constructor.
	 *
	 * @param Config $configuration
	 * @param ResourceLoader $rl
	 */
	public function __construct( Config $configuration, ResourceLoader $rl ) {
		$this->resourceLoader = $rl;
		$this->configuration = $configuration;
	}

	/**
	 * @return bool
	 * @throws \MWException
	 */
	public function process(): bool {

		if ( ! array_key_exists( $this->configuration->get( 'FaRenderMode' ), self::$moduleDefinitions )) {
			throw new \MWException( 'Unexpected Font Awesome render mode.' );
		}

		$moduleDefinition = self::$moduleDefinitions[ $this->configuration->get( 'FaRenderMode' ) ];

		$relativePath = $moduleDefinition[ 'relativePath'];
		$localBasePath  = $this->configuration->get( 'ExtensionDirectory' ) . $relativePath;
		$remoteBasePath = $this->configuration->get( 'ExtensionAssetsPath' ) . $relativePath;

		$modules = $moduleDefinition[ 'modules' ];

		foreach ( $modules as $name => $module ) {
			$modules[ $name ][ 'localBasePath' ] = $localBasePath;
			$modules[ $name ][ 'remoteBasePath' ] = $remoteBasePath;
		}

		$this->resourceLoader->register( $modules );

		return true;
	}

}