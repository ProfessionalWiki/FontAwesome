#!/bin/bash
# Run tests
# (assumes to be run on scrutinizer.org)
#
# @copyright (C) 2019, Stephan Gambke
# @license   GNU General Public License, version 3 (or any later version)

set -xe

PACKAGE_NAME="mediawiki/font-awesome"
EXTENSION_NAME="FontAwesome"

function fetch_mw_from_download() {

  wget "https://releases.wikimedia.org/mediawiki/${MW%.*}/mediawiki-$MW.tar.gz"
  tar -zxf "mediawiki-$MW.tar.gz"
  mv "mediawiki-$MW" ~/mw

  cd ~/mw
  composer require "phpunit/phpunit:^6.5" --update-no-dev --no-scripts
}

function fetch_mw_from_composer() {

  wget https://github.com/wikimedia/mediawiki/archive/$MW.tar.gz
  tar -zxf "$MW.tar.gz"
  mv "mediawiki-$MW" ~/mw

  cd ~/mw
  composer install
}

function fetch_extension_from_download() {
  cp -R ~/build "$HOME/mw/extensions/$EXTENSION_NAME"
}

function fetch_extension_from_composer() {

  local COMPOSER_VERSION=''

  if [[ "$SCRUTINIZER_PR_SOURCE_BRANCH" == '' ]]
  then
    COMPOSER_VERSION="dev-${SCRUTINIZER_BRANCH}#${SCRUTINIZER_SHA1}"
  else
    COMPOSER_VERSION="dev-${SCRUTINIZER_PR_SOURCE_BRANCH}#${SCRUTINIZER_SHA1}"
  fi

  php ~/build/tests/setup/fix-composer.php "$PACKAGE_NAME" "$COMPOSER_VERSION" "$SCRUTINIZER_PROJECT" <~/mw/composer.local.json-sample >~/mw/composer.local.json

  cd ~/mw
  composer update "$PACKAGE_NAME"
}

function install() {
  mysql -e 'create database wikidb;'
  php ~/mw/maintenance/install.php --dbserver "$SERVICE_MARIADB_IP" --dbuser root --dbname wikidb --pass hugo TestWiki admin
  echo "wfLoadExtension( '$EXTENSION_NAME' );" >>~/mw/LocalSettings.php
}

function run_tests() {
  php ~/mw/tests/phpunit/phpunit.php -c ~/mw/extensions/$EXTENSION_NAME/phpunit.xml.dist "$@"
}

function prepare_analysis() {
  cd ~/build
  mv ~/mw ~/build
}

if [[ "$MW" =~ 1.[[:digit:]][[:digit:]].[[:digit:]][[:digit:]]? ]]  # e.g. 1.33.0
then
  fetch_mw_from_download
else
  fetch_mw_from_composer
fi

if [[ "$EXTENSION" == "download" ]]
then
  fetch_extension_from_download
else
  fetch_extension_from_composer
fi

install

run_tests "$@"

prepare_analysis