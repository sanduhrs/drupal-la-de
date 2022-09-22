<?php

// @codingStandardsIgnoreFile
$lando_info = json_decode(getenv('LANDO_INFO'), TRUE);

/**
 * Configure Lando DB.
 */
$databases['default']['default'] = [
    'database' => $lando_info['database']['creds']['database'],
    'username' => $lando_info['database']['creds']['user'],
    'password' => $lando_info['database']['creds']['password'],
    'prefix' => '',
    'host' => $lando_info['database']['internal_connection']['host'],
    'port' => $lando_info['database']['internal_connection']['port'],
    'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
    'driver' => 'mysql',
];

// Hash salt doesn't matter for local development.
$settings['hash_salt'] = 'hash-salt-does-not-matter-for-local-development';

// File system.
$settings['file_public_path'] = 'sites/default/files';
$settings['file_private_path'] = 'sites/default/files/private';

/**
 * Trusted host configuration.
 *
 * Allow:
 *   - machine IP address
 *   - default domain (<vagrant.hostname>.test)
 *   - host aliases (<vagrant.host_aliases>)
 */

$vm_settings = Yaml::decode(file_get_contents($app_root . '/../vm-settings.yml'));

$settings['trusted_host_patterns'] = [
    '^.+\.lndo\.site',
];

/**
 * Disabling even more cache bins.
 *
 * Additional cache bin(s) can be disabled here by assigning cache.backend.null
 * to them, for example:
 *
 * @code
 * $settings['cache']['bins']['discovery'] = 'cache.backend.null';
 * @endcode
 *
 * will disable discovery cache.
 *
 * For more information go to https://www.drupal.org/node/2598914
 */

// Disable contrib translations updates.
$config['locale.settings']['translation']['import_enabled'] = FALSE;

// Disable Advanced aggregation.
$config['advagg.settings']['enabled'] = FALSE;
