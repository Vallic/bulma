<?php
/**
 * @file
 * Contains \Drupal\bulma\Bulma.
 */

namespace Drupal\bulma;

/**
 * The primary class for the Drupal Bulma base theme.
 *
 * Provides many helper methods.
 *
 * @ingroup utility
 */
class Bulma {

  /**
   * Get all table related settings from theme.
   *
   * @return array
   */
  public static function tableSettings() {
    $table_array = [
      'table' => 1,
      'is-bordered' => theme_get_setting('bulma_table_bordered'),
      'is-striped' => theme_get_setting('bulma_table_striped'),
      'is-narrow' => theme_get_setting('bulma_table_narrow'),
    ];

    $classes = array();

    foreach ($table_array as $key => $value) {
      if ($value === 1) {
        $classes[] = $key;
      }
    }

    return $classes;

  }

  /**
   * Get all tabs related settings from theme.
   *
   * @return array
   */
  public static function tabSettings() {
    $table_array = [
      'position' => theme_get_setting('bulma_tabs_position'),
      'size' => theme_get_setting('bulma_tabs_size'),
      'style' => theme_get_setting('bulma_tabs_style'),
      'is-fullwidth' => theme_get_setting('bulma_tabs_fullwidth'),
    ];

    $classes = array();

    foreach ($table_array as $key => $value) {

      switch ($key) {
        case 'is-fullwidth':
          if ($value === 1) {
            $classes[] = $key;
          }
          break;

        default:
          if ($value != 'default') {
            $classes[] = $value;
          }
          break;
      }

    }

    return $classes;
  }
}