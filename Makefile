# Commands run from inside the MediaWiki container ##########################################################

ci: test cs
test: phpunit
cs: phpcs

phpunit:
	php ../../tests/phpunit/phpunit.php -c phpunit.xml.dist

phpcs:
	vendor/bin/phpcs -p -s --standard=$(shell pwd)/phpcs.xml
