# FontAwesome

[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/ProfessionalWiki/FontAwesome/ci.yml?branch=master)](https://github.com/ProfessionalWiki/FontAwesome/actions?query=workflow%3ACI)
[![Latest Stable Version](https://poser.pugx.org/mediawiki/font-awesome/v/stable)](https://packagist.org/packages/mediawiki/font-awesome)
[![Packagist download count](https://poser.pugx.org/mediawiki/font-awesome/downloads)](https://packagist.org/packages/mediawiki/font-awesome)

The [FontAwesome][mw-font-awesome] extension to MediaWiki provides parser
functions to insert [Font Awesome Free][font-awesome] icons into the wiki text.

Currently Font Awesome Free, version 6.2.1 is included.

## Requirements

- PHP 7.4.3 or later
- MediaWiki 1.35 or later

## Installation

### Using Composer

Using [Composer][composer] is the recommended way to install this extension.

Run the following commands from the MediaWiki installation directory:

1. `COMPOSER=composer.local.json php composer.phar require --no-update mediawiki/font-awesome ^2.0`
2. `php composer.phar update --no-dev mediawiki/font-awesome`

To update the extension run the last command again.

### Using a download from GitHub

1. Download a tar ball or zip file from [GitHub](https://github.com/ProfessionalWiki/FontAwesome/releases/latest)
2. Extract it into the `extensions` directory of your MediaWiki installation
3. Rename the folder `FontAwesome-...` to `FontAwesome`

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

For valid icon names see https://fontawesome.com/v6/search.

## Professional Support

The FontAwesome extension is maintained by [Professional Wiki](https://professional.wiki).
You can [contract us][contact-form] to help you with installation or customization of FontAwesome.
We also do development work.

## License

[GNU General Public License, Version 3][license] or later.

The Font Awesome Free package is included in the extension. See its
[license file][font-awesome-license] for details.

[license]: https://www.gnu.org/copyleft/gpl.html
[font-awesome-license]: ./res/fontawesome/LICENSE.txt
[mw-font-awesome]: https://www.mediawiki.org/wiki/Extension:FontAwesome
[font-awesome]: https://fontawesome.com/
[composer]: https://getcomposer.org/
[contact-form]: https://professional.wiki/en/contact

## Release notes

### Version 2.0.0

Released on January 27, 2023.

* Raised minimum PHP version from 7.0 to 7.4.3
* Raised minimum MediaWiki version from 1.31 to 1.35
* Updated to FontAwesome 6

### Version 1.1.0

Released on January 25, 2023.

* Updated FontAwesome to 5.15.4

### Version 1.0.0

Released on October 20, 2019.

* Initial release
