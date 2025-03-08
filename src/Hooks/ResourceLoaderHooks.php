<?php
/**
 * FontAwesome ResourceLoader hooks
 *
 * @file
 * @ingroup FontAwesome
 * @license GPL-3.0-or-later
 * @since 3.0.0
 */

declare( strict_types=1 );

namespace FontAwesome\Hooks;

use Config;
use ConfigException;
use ConfigFactory;
use MediaWiki\MainConfigNames;
use MediaWiki\ResourceLoader\Hook\ResourceLoaderRegisterModulesHook;
use MediaWiki\ResourceLoader\ResourceLoader;

class ResourceLoaderHooks implements ResourceLoaderRegisterModulesHook {

	private static array $moduleDefinitions = [
		'javascript' => [
			'relativePath' => '/FontAwesome/res/fontawesome/js/',
			'modules' => [
				'ext.fontawesome'         => [ 'scripts' => 'fontawesome.js' ],
				'ext.fontawesome.far' => [ 'scripts' => 'regular.js', 'dependencies' => [ 'ext.fontawesome' ] ],
				'ext.fontawesome.fas'   => [ 'scripts' => 'solid.js', 'dependencies' => [ 'ext.fontawesome' ] ],
				'ext.fontawesome.fab'  => [ 'scripts' => 'brands.js', 'dependencies' => [ 'ext.fontawesome' ] ],
			],
		],
		'webfonts' => [
			'relativePath' => '/FontAwesome/res/fontawesome/css/',
			'modules' => [
				'ext.fontawesome'         => [ 'styles' => 'fontawesome.css' ],
				'ext.fontawesome.far' => [ 'styles' => 'regular.css' ],
				'ext.fontawesome.fas'   => [ 'styles' => 'solid.css' ],
				'ext.fontawesome.fab'  => [ 'styles' => 'brands.css' ],
			],
		],
	];

	private Config $coreConfig;

	private Config $config;

	public function __construct(
		Config $coreConfig,
		ConfigFactory $configFactory
	) {
		$this->coreConfig = $coreConfig;
		$this->config = $configFactory->makeConfig( 'fontawesome' );
	}

	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ResourceLoaderRegisterModules
	 *
	 * @param ResourceLoader $resourceLoader
	 */
	public function onResourceLoaderRegisterModules( $resourceLoader ): void {
		$renderMode = $this->config->get( 'FaRenderMode' );
		if ( !array_key_exists( $renderMode, self::$moduleDefinitions ) ) {
			throw new ConfigException( "Invalid FaRenderMode value: $renderMode" );
		}

		$moduleDefinition = self::$moduleDefinitions[ $renderMode ];

		$relativePath = $moduleDefinition[ 'relativePath' ];
		$localBasePath  = $this->coreConfig->get( MainConfigNames::ExtensionDirectory ) . $relativePath;
		$remoteBasePath = $this->coreConfig->get( MainConfigNames::ExtensionAssetsPath ) . $relativePath;

		$modules = $moduleDefinition[ 'modules' ];

		foreach ( $modules as $name => $module ) {
			$modules[ $name ][ 'localBasePath' ] = $localBasePath;
			$modules[ $name ][ 'remoteBasePath' ] = $remoteBasePath;
			// Required to load module with MobileFrontend < 1.43
			if ( version_compare( MW_VERSION, '1.43', '<' ) ) {
				$modules[ $name ][ 'targets' ] = [ 'mobile', 'desktop' ];
			}
		}

		$resourceLoader->register( $modules );
	}

}
