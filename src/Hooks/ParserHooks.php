<?php
/**
 * FontAwesome parser hooks
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
use FontAwesome\IconRenderers\JavascriptRenderer;
use FontAwesome\IconRenderers\WebfontRenderer;
use MediaWiki\Hook\ParserFirstCallInitHook;
use Parser;

class ParserHooks implements ParserFirstCallInitHook {

	// TODO: Move to a class that handles the mapping of magic words to classes
	private static array $magicWordsClassMap = [
		/**
		 * Family: Classic
		 * Style: Solid
		 */
		'fas' => 'fa-solid',
		/**
		 * Family: Classic
		 * Style: Regular
		 */
		'far' => 'fa-regular',
		/**
		 * Family: Brands
		 * Style: Brands
		 */
		'fab' => 'fa-brands',
	];

	private Config $config;

	public function __construct(
		ConfigFactory $configFactory
	) {
		$this->config = $configFactory->makeConfig( 'fontawesome' );
	}

	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
	 *
	 * @param Parser $parser
	 */
	public function onParserFirstCallInit( $parser ): void {
		$rendererClass = $this->getRendererClass();
		foreach ( self::$magicWordsClassMap as $magicWord => $fontClass ) {
			$this->registerIconRenderer( $magicWord, $fontClass, $rendererClass, $parser );
		}
	}

	private function registerIconRenderer( string $magicWord, string $fontClass, string $rendererClass, Parser $parser ) {
		$renderer = new $rendererClass( $magicWord, $fontClass );
		$parser->setFunctionHook( $magicWord, [ $renderer, 'render' ], Parser::SFH_OBJECT_ARGS );
	}

	/**
	 * @throws ConfigException
	 */
	private function getRendererClass(): string {
		$renderMode = $this->config->get( 'FaRenderMode' );
		switch ( $renderMode ) {
			case 'javascript':
				return JavascriptRenderer::class;
			case 'webfonts':
				return WebfontRenderer::class;
			default:
				throw new ConfigException( "Invalid FaRenderMode value: $renderMode" );
		}
	}

}
