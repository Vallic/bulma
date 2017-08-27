<?php

namespace Drupal\bulma;

use Drupal\Component\Serialization\Yaml;

/**
 * A class to provide Bulmaswatch integration helper methods.
 *
 * @ingroup utility
 */
class Bulmaswatch {

  /**
   * Determines whether there is a local Bulma library.
   *
   * @return bool
   *   The available versions keyed by version, or FALSE on error.
   */
  public static function isLocal() {
    return file_exists(DRUPAL_ROOT . '/libraries/bulmaswatch/api/themes.json');
  }

  /**
   * Returns a list of available Bulmaswatch themes.
   *
   * @return array
   *   An array of available Bulmaswatch themes keyed by theme name.
   */
  public static function getThemes() {
    $themes = [];
    $api_data = static::getBulmaswatchApiData();
    foreach ($api_data['themes'] as $theme) {
      // Parse the machine name.
      $machine_name = strtolower($theme['name']);
      if (static::isLocal()) {
        $theme['local_css'] = '/libraries/bulmaswatch/' . $machine_name . '/bulmaswatch.min.css';
      }
      $themes[$machine_name] = $theme;
    }
    return $themes;
  }

  /**
   * Returns a list of available Bulmaswatch themes.
   *
   * @return array
   *   An array of available Bulmaswatch themes keyed by theme name.
   */
  public static function getBulmaswatchApiData() {
    static $api_data;

    if (empty($api_data)) {
      $api_file = '/api/themes.json';
      if (static::isLocal()) {
        $filename = DRUPAL_ROOT . '/libraries/bulmaswatch' . $api_file;
        $api_data = Yaml::decode(file_get_contents($filename));
      }
      else {
        $cdn_data = Bulma::getCdnData();
        $api = $cdn_data['api']['bulmaswatch']['file_root'] . $api_file;
        $api_data = Bulma::getApiData($api);
      }
    }

    return $api_data;
  }
}
