<?php
/**
 * Simple example for connecting to the Apaleo API and retreiving the available inventory.
 *
 * Copyright 2017 Loopon AB. See LICENSE for details (MIT License; free to use as you wish).
 *
 * Using OAuth2 library provided at:
 *     https://github.com/thephpleague/oauth2-client
 *
 * In order to download/install required libraries, first install composer:
 *     https://getcomposer.org/doc/00-intro.md
 *
 * Then download the required dependencies:
 *     $ composer install
 *
 * Finally update the credentials at the bottom of this file:
 *     $lApaleoExample = new ApaleoClient('<URL OF YOUR APPLICATION>', '<USERNAME>', '<PASSWORD>');
 *
 * This code is provided as-is without warranty of any kind. If you do have questions/need assistance with this example,
 * feel free to contact Simon Finne <simon.finne@loopon.com> where I will try to respond if possible, but cannot
 * guarantee any support.
 *
 * Note that functionality of this exact example depends on your user having the properties.read scope.
 * Also note, that if you for any reason want to connect to Apaleo's staging environment, you need to update the
 * ApaleoProvider::cIdentityUrl and ApaleoClient::cApiUrl configurations.
 *
 * Contact api@apaleo.com or see dev.apaleo.com for help regarding their api.
 */

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/src/Client.php');

$lApaleoClient = new Loopon\Apaleo\Client\Client('<URL OF YOUR APPLICATION>', '<USERNAME>', '<PASSWORD>');
$lInventory = $lApaleoClient->getInventoryApi()->getProperties();
print_r($lInventory);

