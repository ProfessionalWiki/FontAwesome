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

namespace FontAwesome\Hooks;

use SCSS\ResourceLoaderSCSSModule;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/SetupAfterCache
 *
 * @since 1.0
 * @ingroup FontAwesome
 */
class SetupAfterCache {

	protected $configuration;
	private $rlModuleTemplate;

	/**
	 * @param array $configuration
	 *
	 * @since  1.0
	 *
	 */
	public function __construct( array &$configuration ) {
		$this->configuration = &$configuration;
	}

	/**
	 * @return bool
	 * @since  1.0
	 *
	 */
	public function process(): bool {

		$this->initResourceModuleTemplate();

		$this->registerResourceModule( 'ext.fontawesome.styles', 'fontawesome.scss' );
		$this->registerResourceModule( 'ext.fontawesome.styles.regular', 'regular.scss' );
		$this->registerResourceModule( 'ext.fontawesome.styles.solid', 'solid.scss' );
		$this->registerResourceModule( 'ext.fontawesome.styles.brands', 'brands.scss' );

		return true;
	}

	private function initResourceModuleTemplate() {

		$remoteBasePath = $this->configuration[ 'wgExtensionAssetsPath' ] . '/FontAwesome/res/fontawesome/scss/';
		$remoteFontPath = $this->configuration[ 'wgExtensionAssetsPath' ] . '/FontAwesome/res/fontawesome/webfonts';
		$localBasePath = $this->configuration[ 'wgExtensionDirectory' ] . '/FontAwesome/res/fontawesome/scss/';

		$this->rlModuleTemplate =
			[
				'localBasePath'  => $localBasePath,
				'remoteBasePath' => $remoteBasePath,
				'class'          => ResourceLoaderSCSSModule::class,
				'position'       => 'top',
				'variables'      => [
					'fa-font-path' => $remoteFontPath,
				],
				'dependencies'   => [],
				'cacheTriggers'  => [
					'LocalSettings.php' => null,
					'composer.lock'     => null,
				],
			];
	}

	/**
	 * @param string $moduleName
	 * @param string $styleFileName
	 */
	private function registerResourceModule( string $moduleName, string $styleFileName ) {
		$this->configuration[ 'wgResourceModules' ][ $moduleName ] = $this->rlModuleTemplate +
			[ 'styles' => [ $styleFileName ] ];
	}

}
