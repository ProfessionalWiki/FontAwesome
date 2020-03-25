# FontAwesome

[![Build Status](https://scrutinizer-ci.com/g/ProfessionalWiki/mw-font-awesome/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ProfessionalWiki/mw-font-awesome/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/mediawiki/font-awesome/v/stable)](https://packagist.org/packages/mediawiki/font-awesome)
[![Packagist download count](https://poser.pugx.org/mediawiki/font-awesome/downloads)](https://packagist.org/packages/mediawiki/font-awesome)

The [FontAwesome][mw-font-awesome] extension to MediaWiki provides parser
functions to insert [Font Awesome Free][font-awesome] icons into the wiki text.

Currently Font Awesome Free, version 5.11.2 is included.

## Requirements

- PHP 7.0 or later
- MediaWiki 1.31 or later

## Installation

### Using Composer

Using [Composer][composer] is the recommended way to install this extension.

Run the following commands from the MediaWiki installation directory:

1. `COMPOSER=composer.local.json php composer.phar require --no-update mediawiki/font-awesome ^1.0`
2. `php composer.phar update --no-dev mediawiki/font-awesome`

To update the extension run the last command again.

### Using a download from GitHub

1. Download a tar ball or zip file from [GitHub](https://github.com/cmln/mw-font-awesome/releases/latest)
2. Extract it into the `extensions` directory of your MediaWiki installation
3. Rename the folder `mw-font-awesome-...` to `FontAwesome`

To update the extension delete the `FontAwesome` folder completely and re-install.

## Activation

Add the following line to your `LocalSettings.php`:
```php
wfLoadExtension( 'FontAwesome' );
```

## Configuration

There are two render modes available for FontAwesome icons:
* **Web Fonts with CSS:** This implementation uses web fonts as the file format and relies on the browser to render icons as it would any custom font.
* **SVG with JavaScript:** This implementation encodes icon data and the mechanism to display them in the browser in JavaScript code that the browser executes.

The render mode can be selected by setting the variable `$wgFaRenderMode` in
LocalSettings.php. Allowed values are: `webfonts` (default) and `javascript`.

**Example:** `$wgFaRenderMode = 'javascript';`

For a discussion of the advantages and drawbacks of the render modes see
[Performance & Font Awesome](https://fontawesome.com/how-to-use/on-the-web/other-topics/performance)
on fontawesome.com.

## Usage

This extension defines three parser functions:
* `{{#far:...}}` to insert an icon from the FontAwesome Regular font
* `{{#fas:...}}` to insert an icon from the FontAwesome Solid font
* `{{#fab:...}}` to insert an icon from the FontAwesome Brands font

**Example:**
`{{#fab:wikipedia-w}}` will insert the Wikipedia-W

For valid icon names see https://fontawesome.com/icons.

## License

[GNU General Public License, Version 3][license] or later.

The Font Awesome Free package is included in the extension. See its
[license file][font-awesome-license] for details.

[license]: https://www.gnu.org/copyleft/gpl.html
[font-awesome-license]: ./res/fontawesome/LICENSE.txt
[mw-font-awesome]: https://www.mediawiki.org/wiki/Extension:FontAwesome
[mw-scss]: https://github.com/cmln/mw-scss
[font-awesome]: https://fontawesome.com/
[composer]: https://getcomposer.org/
