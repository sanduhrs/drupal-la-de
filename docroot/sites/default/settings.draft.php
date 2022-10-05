<?php

/**
 * @file
 * Draft VM overrides.
 *
 * Injected into settings.local.php by DrupalProject composer script.
 */

use Drupal\Component\Serialization\Yaml;

// Set up default database.
$databases['default']['default'] = [
  'database' => 'drupal',
  'username' => 'drupal',
  'password' => 'drupal',
  'prefix' => '',
  'host' => 'drupal.nl.test',
  'port' => '3306',
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

$settings['trusted_host_patterns'] = [];
// Default domain.
$settings['trusted_host_patterns'][] = $vm_settings['vagrant']['hostname'] . '.test';
// Host aliases.
foreach ($vm_settings['vagrant']['host_aliases'] as $alias) {
  $settings['trusted_host_patterns'][] = $alias;
}
// IP address can be explicitly set in settings.
if (!empty($vm_settings['vagrant']['ip_address'])) {
  $settings['trusted_host_patterns'][] = $vm_settings['vagrant']['ip_address'];
}
// Or generated by Draft environemnt helper. See https://github.com/lemberg/draft-environment/blob/2.x.x/helpers/configuration.rb#L137
else {
  $sum = 0;
  foreach (str_split($vm_settings['vagrant']['hostname']) as $char) {
    $sum += ord($char);
  }

  $part_3 = min([max([$sum >> 8, 1]), 255]);
  $part_4 = min([max([$sum % 256, 2]), 255]);
  $settings['trusted_host_patterns'][] = "10.10.$part_3.$part_4";
}

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