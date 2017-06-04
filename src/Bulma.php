<?php

namespace Drupal\bulma;

use Drupal\Component\Utility\Unicode;

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
          'is-bordered' => theme_get_setting('bulma_table_bordered'),
          'is-striped' => theme_get_setting('bulma_table_striped'),
          'is-narrow' => theme_get_setting('bulma_table_narrow'),
        ];
        break;

      case 'tabs':
        $data = [
          'position' => theme_get_setting('bulma_tabs_position'),
          'size' => theme_get_setting('bulma_tabs_size'),
          'style' => theme_get_setting('bulma_tabs_style'),
          'is-fullwidth' => theme_get_setting('bulma_tabs_fullwidth'),
        ];
        break;

      case 'label':
        $data = [
          'tag' => theme_get_setting('bulma_elements_labels_rounded'),
          'color' => theme_get_setting('bulma_elements_labels_color'),
          'size' => theme_get_setting('bulma_elements_labels_size'),
        ];
        break;

      case 'button':
        $data = [
          'colorize' => theme_get_setting('bulma_button_colorize'),
          'size' => theme_get_setting('bulma_button_size'),
          'is-outlined' => theme_get_setting('bulma_button_outlined'),
          'is-inverted' => theme_get_setting('bulma_button_inverted'),
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
   * Check if horizontal form is enabled.
   *
   * @return bool
   *   True or false for horizontal form setting.
   */
  public static function horizontalForm() {
    $horizontal_form = theme_get_setting('bulma_elements_labels_inline');

    if ($horizontal_form === 1) {
      return TRUE;
    }

    return FALSE;
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

}
