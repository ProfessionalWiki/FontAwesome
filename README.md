# FontAwesome

[![Latest Stable Version](https://poser.pugx.org/mediawiki/font-awesome/v/stable)](https://packagist.org/packages/mediawiki/simple-batch-upload)
[![Packagist download count](https://poser.pugx.org/mediawiki/font-awesome/downloads)](https://packagist.org/packages/mediawiki/simple-batch-upload)

The [FontAwesome][mw-font-awesome] extension provides parser functions to insert
FontAwesome icons into the wiki text.

## Requirements

- PHP 7.0 or later
- MediaWiki 1.31 or later

## Installation

The recommended way to install this extension is by using [Composer][composer].
Just add the following to the MediaWiki `composer.local.json` file and run
`php composer.phar update mediawiki/font-awesome` from the MediaWiki
installation directory.

```json
{
	"require": {
		"mediawiki/font-awesome": "~1.0"
	}
}
```

(Alternatively you can download a tar ball or zip file from
[GitHub](https://github.com/cmln/mw-font-awesome/releases/latest)
and extract it into the `extensions` directory of your MediaWiki installation.)

Then add the following line to your `LocalSettings.php`:
```php
wfLoadExtension( 'FontAwesome' );
```

## Usage

This extension defines three parser functions:
* `{{#far:...}}` to insert an icon from the FontAwesome Regular font
* `{{#fas:...}}` to insert an icon from the FontAwesome Solid font
* `{{#fab:...}}` to insert an icon from the FontAwesome Brands font

**Example:**
`{{#fab:wikipedia-w}}` will insert the Wikipedia-W

For valid icon names see https://fontawesome.com/icons

## License

[GNU General Public License, Version 3][license] or later.

[license]: https://www.gnu.org/copyleft/gpl.html
[mw-font-awesome]: https://www.mediawiki.org/wiki/Extension:FontAwesome
[composer]: https://getcomposer.org/
