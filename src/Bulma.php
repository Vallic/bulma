<?php

namespace Drupal\bulma;

use Drupal\Component\Serialization\Json;
use Drupal\Component\Serialization\Yaml;
use Drupal\Component\Utility\Unicode;
use Drupal\file\Entity\File;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * The primary class for the Drupal Bulma base theme.
 *
 * Provides many helper methods.
 *
 * @ingroup utility
 */
class Bulma {

  /**
   * Get classes for preprocess functions based on theme settings.
   *
   * @param string $type
   *   Type of settings to check.
   *
   * @return array
   *   Return array of classes to apply.
   */
  public static function multiSettings($type) {

    $data = [];
    $classes = [];

    switch ($type) {
      case 'table':
        $data = [
          'table' => 1,
          'is-bordered' => theme_get_setting('table.bordered'),
          'is-striped' => theme_get_setting('table.striped'),
          'is-narrow' => theme_get_setting('table.narrow'),
        ];
        break;

      case 'breadcrumb':
        $data = [
          'position' => theme_get_setting('breadcrumb.position'),
          'size' => theme_get_setting('breadcrumb.size'),
          'style' => theme_get_setting('breadcrumb.separator'),
        ];
        break;

      case 'tabs':
        $data = [
          'position' => theme_get_setting('tabs.position'),
          'size' => theme_get_setting('tabs.size'),
          'style' => theme_get_setting('tabs.style'),
          'is-fullwidth' => theme_get_setting('tabs.fullwidth'),
        ];
        break;

      case 'label':
        $data = [
          'tag' => theme_get_setting('elements.labels_rounded'),
          'color' => theme_get_setting('elements.labels_color'),
          'size' => theme_get_setting('elements.labels_size'),
        ];
        break;

      case 'button':
        $data = [
          'colorize' => theme_get_setting('button.colorize'),
          'size' => theme_get_setting('button.size'),
          'is-outlined' => theme_get_setting('button.outlined'),
          'is-inverted' => theme_get_setting('button.inverted'),
        ];
        break;

      default:

    }

    if (!empty($data)) {
      foreach ($data as $key => $value) {

        switch ($value) {

          // Default choice in select or checkbox is not selected.
          case '0':
            continue;

          // Cases for checkbox settings.
          case 1:
            $classes[$key] = $key;
            break;

          // Case for selected fields.
          default:
            $classes[$key] = $value;
        }

      }

    }

    return $classes;
  }

  /**
   * Retrieve single settings as bool or string value.
   *
   * @param string $setting
   *   Theme setting to check.
   *
   * @return mixed
   *   True or false for horizontal form setting.
   */
  public static function singleSetting($setting) {
    $theme_setting = theme_get_setting($setting);

    if (is_numeric($theme_setting)) {
      if ($theme_setting === 1) {
        return TRUE;
      }

      return FALSE;
    }

    // Strings, etc.
    return $theme_setting;
  }

  /**
   * Matches a Bulma class based on a string value.
   *
   * Borrowed from Bootstrap project drupal.org/project/bootstrap.
   *
   * @param string|array $value
   *   The string to match against to determine the class.
   * @param string $default
   *   The default class to return if no match is found.
   *
   * @return string
   *   The Bulma class matched against the value of $haystack.
   */
  public static function cssClassFromString(&$value, $default = '') {

    $data = [
      // Text that match these specific strings are checked first.
      'matches' => [
        // Primary class.
        t('Download feature')->render()   => 'is-primary',

        // Success class.
        t('Add effect')->render()         => 'is-success',
        t('Add and configure')->render()  => 'is-success',
        t('Save configuration')->render() => 'is-success',
        t('Install and set as default')->render() => 'is-success',

        // Info class.
        t('Save and add')->render()       => 'is-info',
        t('Add another item')->render()   => 'is-info',
        t('Update style')->render()       => 'is-info',
      ],

      // Text containing these words anywhere in the string are checked last.
      'contains' => [
        // Primary class.
        t('Confirm')->render()            => 'is-primary',
        t('Filter')->render()             => 'is-primary',
        t('Log in')->render()             => 'is-primary',
        t('Submit')->render()             => 'is-primary',
        t('Search')->render()             => 'is-primary',
        t('Settings')->render()           => 'is-primary',
        t('Upload')->render()             => 'is-primary',

        // Danger class.
        t('Delete')->render()             => 'is-danger',
        t('Remove')->render()             => 'is-danger',
        t('Uninstall')->render()          => 'is-danger',

        // Success class.
        t('Add')->render()                => 'is-success',
        t('Create')->render()             => 'is-success',
        t('Install')->render()            => 'is-success',
        t('Save')->render()               => 'is-success',
        t('Write')->render()              => 'is-success',

        // Warning class.
        t('Export')->render()             => 'is-warning',
        t('Import')->render()             => 'is-warning',
        t('Restore')->render()            => 'is-warning',
        t('Rebuild')->render()            => 'is-warning',

        // Info class.
        t('Apply')->render()              => 'is-info',
        t('Update')->render()             => 'is-info',
      ],
    ];

    // Iterate over the array.
    foreach ($data as $pattern => $strings) {
      foreach ($strings as $text => $class) {
        switch ($pattern) {
          case 'matches':
            if ($value === $text) {
              return $class;
            }
            break;

          case 'contains':
            if (strpos(Unicode::strtolower($value), Unicode::strtolower($text)) !== FALSE) {
              return $class;
            }
            break;
        }
      }
    }

    // Return the default if nothing was matched.
    return $default;
  }

  /**
   * Generate CSS classes to apply on submit elements.
   *
   * @param string $name
   *   Button value.
   *
   * @return array
   *   CSS classes for elements.
   */
  public static function colorizeButton($name) {
    $button_class = [];

    // Get all button settings.
    $bulma_button = self::multiSettings('button');

    if (!empty($bulma_button)) {
      foreach ($bulma_button as $key => $class) {

        // If buttons should be colorized by task/action.
        if ($key == 'colorize') {

          // Get class.
          $color = Bulma::cssClassFromString($name, 'is-primary');

          // Assign color.
          $button_class[] = $color;
        }

        else {
          $button_class[] = $class;
        }
      }
    }

    return $button_class;
  }

  /**
   * Matching field label or field type with font awesome.
   *
   * @param string $name
   *   Label upon matching to font awesome class is done.
   * @param string $type
   *   Field type upon matching to font awesome class is done.
   *
   * @return bool|mixed|string
   *   Return false - no match, string as font awesome css class/value.
   */
  public static function iconMatch($name, $type) {

    $class = FALSE;

    $icons = [
      t('Username')->render() => 'user',
      t('Password')->render() => 'lock',
      t('timezone')->render() => 'globe',
      t('Authored by')->render() => 'user',
      t('URL alias')->render() => 'road',
      t('title')->render() => 'pencil',
      t('Subject')->render() => 'pencil',
      t('Date')->render() => 'calendar-o',
      t('Time')->render() => 'clock-o',
      t('Homepage')->render() => 'globe',
      t('Files')->render() => 'file',
      t('Tags')->render() => 'tags',
      t('Preview')->render() => 'eye',
      t('Add another item')->render() => 'plus',
      t('Log in')->render() => 'sign-in',
      t('Manage')->render() => 'cog',
      t('Configure')->render() => 'cog',
      t('Settings')->render() => 'cog',
      t('Download')->render() => 'download',
      t('Export')->render() => 'download',
      t('Filter')->render() => 'filter',
      t('Import')->render() => 'upload',
      t('Save')->render() => 'check',
      t('Update')->render() => 'check',
      t('Edit')->render() => 'pencil',
      t('Uninstall')->render() => 'trash',
      t('Install')->render() => 'plus',
      t('Write')->render() => 'plus',
      t('Cancel')->render() => 'ban',
      t('Delete')->render() => 'trash',
      t('Remove')->render() => 'trash',
      t('Search')->render() => 'search',
      t('Upload')->render() => 'upload',
    ];

    foreach ($icons as $key => $icon) {
      if (Unicode::strtolower($name) === Unicode::strtolower($key)) {
        $class = $icon;
      }
    }

    // If default icon is turned on.
    if (self::singleSetting('general.icon_type')) {
      if (empty($class)) {
        switch ($type) {
          case 'file':
            $class = 'file';
            break;

          case 'email':
            $class = 'envelope';
            break;

          case 'password':
            $class = 'lock';
            break;

          case 'url':
            $class = 'link';
            break;

          case 'entity_autocomplete':
            $class = 'tags';
            break;

          case 'submit':
            $class = 'check';
            break;

          case 'textfield':
            $class = 'pencil';
            break;

          case 'search':
            $class = FALSE;
            break;

          default:
            $class = 'keyboard-o';
            break;
        }
      }
    }

    return $class;
  }

  /**
   * Find the appropriate fontawesome icon for a given file.
   *
   * @param \Drupal\Core\Entity\Entity\File $file
   *   A file entity.
   *
   * @return string
   *   Fontawesome CSS class/value.
   */
  public static function getFileIcon(File $file) {
    $mime_type = $file->getMimeType();

    // Retrieve the generic mime type from core.
    $generic_mime_type = file_icon_class($mime_type);

    // Map the generic mime types to an icon.
    $icon_map = [
      'application-pdf' => 'file-pdf-o',
      'application-x-executable' => 'console',
      'audio' => 'file-audio-o',
      'image' => 'file-image-o',
      'package-x-generic' => 'file-archive-o',
      'text' => 'file-text-o',
      'text-html' => 'file-text-o',
      'text-x-script' => 'file-code-o',
      'video' =>'file-video-o',
      'x-office-document' => 'file-text-o',
      // 'general' is the fallback returned by file_icon_class().
      'general' => 'file-o',
    ];

    // Retrieve the icon class.
    $icon = $icon_map[$generic_mime_type];
    return $icon;
  }

  /**
   * Determines whether there is a local Bulma library.
   *
   * @return bool
   *   The available versions keyed by version, or FALSE on error.
   */
  public static function isLocal() {
    return file_exists(DRUPAL_ROOT . '/libraries/bulma/bulma.sass');
  }

  /**
   * Returns data on the CDN.
   *
   * @return array|FALSE
   *   Details used for CDN API calls.
   */
  public static function getCdnData() {
    static $cdn_data;

    if (empty($cdn_data)) {
      /** @var \Drupal\Core\Theme\ActiveTheme $theme */
      $theme = \Drupal::theme()->getActiveTheme();
      $filename = $theme->getPath() . '/' . $theme->getName() . '.cdn.yml';
      if (file_exists($filename)) {
        $cdn_data = Yaml::decode(file_get_contents($filename));
        // Replace version placeholder.
        foreach (['bulma', 'bulmaswatch'] as $package) {
          if (!$version = theme_get_setting("cdn.{$package}.version")) {
            $version = 'latest';
          }
          $cdn_data['api'][$package]['file_root'] = str_replace('[version]', $version, $cdn_data['api'][$package]['file_root']);
        }
      }
      else {
        $cdn_data = FALSE;
      }
    }
    return $cdn_data;
  }

  /**
   * Returns data from an API call.
   *
   * @param string $api
   *   An API call URL.
   *
   * @return array|FALSE
   *   The decoded JSON response, or FALSE on error.
   */
  public static function getApiData($api) {
    $client = \Drupal::httpClient();
    $request = new Request('GET', $api);
    try {
      $response = $client->send($request);
    }
    catch (RequestException $e) {
      $response = new Response(400);
    }
    $contents = $response->getBody(TRUE)->getContents();

    $json = Json::decode($contents) ?: FALSE;

    return $json;
  }

  /**
   * Returns available versions for a package.
   *
   * @param string $package
   *   The name of a package to return version data for. Valid values are
   *  'bulma' and 'bulmaswatch'.
   *
   * @return array|FALSE
   *   The available versions keyed by version, or FALSE on error.
   */
  public static function getCdnVersions($package = 'bulma') {
    $cdn_data = static::getCdnData();
    $api = $cdn_data['api'][$package]['version'];
    $json = static::getApiData($api);
    if ($json) {
      return array_combine($json['versions'], $json['versions']);
    }
    return FALSE;
  }

  /**
   * Returns the locally installed Bulma version.
   *
   * @return string|FALSE
   *   A version string, or FALSE on error.
   */
  public static function getBulmaLocalVersion() {
    $filename = DRUPAL_ROOT . '/libraries/bulma/package.json';
    if (file_exists($filename)) {
      $json = Json::decode(file_get_contents($filename));
      if ($json) {
        return $json['version'];
      }
    }

    return FALSE;
  }
}
