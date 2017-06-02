<?php

/**
 * @file
 * Add custom theme settings to the Bulma base theme.
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function bulma_form_system_theme_settings_alter(&$form, FormStateInterface $form_state, $form_id = NULL) {

  // Bulma tabs settings.
  $form['bulma_tabs'] = [
    '#type' => 'details',
    '#title' => t('Bulma Tabs'),
    '#description' => t('Contains settings for tabs display, see <a href="@docs">documentation</a>', [
      '@docs' => Url::fromUri('http://bulma.io/documentation/components/tabs/',
        ['attributes' => ['target' => '_blank']])
        ->toString(),
    ]),
  ];

  $form['bulma_tabs']['bulma_tabs_position'] = [
    '#type' => 'select',
    '#title' => t('Tabs positions'),
    '#description' => t('Position for tabs, default is left'),
    '#options' => [
      'default' => t('Left'),
      'is-centered' => t('Center'),
      'is-right' => t('Right'),
    ],
    '#default_value' => theme_get_setting('bulma_tabs_position'),
  ];

  $form['bulma_tabs']['bulma_tabs_size'] = [
    '#type' => 'select',
    '#title' => t('Tabs size'),
    '#description' => t('Size of the tabs'),
    '#options' => [
      'default' => t('Default'),
      'is-small' => t('Small'),
      'is-medium' => t('Medium'),
      'is-large' => t('Large'),
    ],
    '#default_value' => theme_get_setting('bulma_tabs_size'),
  ];

  $form['bulma_tabs']['bulma_tabs_style'] = [
    '#type' => 'select',
    '#title' => t('Tabs style'),
    '#description' => t('Look & feel of the tabs.'),
    '#options' => [
      'default' => t('Default'),
      'is-boxed' => t('Classic with borders'),
      'is-toggle' => t('Mutually exclusive'),
    ],
    '#default_value' => theme_get_setting('bulma_tabs_style'),
  ];

  $form['bulma_tabs']['bulma_tabs_fullwidth'] = [
    '#type' => 'checkbox',
    '#title' => t('Fullwidth'),
    '#description' => t('If you want tabs to be display in full width'),
    '#default_value' => theme_get_setting('bulma_tabs_fullwidth'),
  ];

  // Bulma table settings.
  $form['bulma_table'] = [
    '#type' => 'details',
    '#title' => t('Bulma Table'),
    '#description' => t('Contains settings for table display see <a href="@docs">documentation</a>', [
      '@docs' => Url::fromUri('http://bulma.io/documentation/elements/table/',
        ['attributes' => ['target' => '_blank']])
        ->toString(),
    ]),
  ];

  $form['bulma_table']['bulma_table_bordered'] = [
    '#type' => 'checkbox',
    '#title' => t('Bordered'),
    '#description' => t('Add borders to all the cells.'),
    '#default_value' => theme_get_setting('bulma_table_bordered'),
  ];

  $form['bulma_table']['bulma_table_striped'] = [
    '#type' => 'checkbox',
    '#title' => t('Striped'),
    '#description' => t('Add stripes to the table.'),
    '#default_value' => theme_get_setting('bulma_table_striped'),
  ];

  $form['bulma_table']['bulma_table_narrow'] = [
    '#type' => 'checkbox',
    '#title' => t('Narrow'),
    '#description' => t('Make the cells narrower.'),
    '#default_value' => theme_get_setting('bulma_table_narrow'),
  ];
}
