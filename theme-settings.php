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

  // Bulma buttons settings.
  $form['bulma_button'] = [
    '#type' => 'details',
    '#title' => t('Bulma Button'),
    '#description' => t('Contains settings for buttons, see <a href="@docs">documentation</a>', [
      '@docs' => Url::fromUri('http://bulma.io/documentation/elements/button/',
        ['attributes' => ['target' => '_blank']])
        ->toString(),
    ]),
  ];

  $form['bulma_button']['bulma_button_colorize'] = [
    '#type' => 'checkbox',
    '#title' => t('Colorize buttons'),
    '#description' => t('Colorize buttons by type -  Primary / Info /  Success /  Warning / Danger'),
    '#default_value' => theme_get_setting('bulma_button_colorize'),
  ];

  $form['bulma_button']['bulma_button_size'] = [
    '#type' => 'select',
    '#title' => t('Button size'),
    '#description' => t('Size of the buttons'),
    '#options' => [
      '0' => t('Default'),
      'is-small' => t('Small'),
      'is-medium' => t('Medium'),
      'is-large' => t('Large'),
    ],
    '#default_value' => theme_get_setting('bulma_button_size'),
  ];

  $form['bulma_button']['bulma_button_outlined'] = [
    '#type' => 'checkbox',
    '#title' => t('Outlined buttons'),
    '#description' => t('Colorize buttons by type'),
    '#default_value' => theme_get_setting('bulma_button_outlined'),
  ];

  $form['bulma_button']['bulma_button_inverted'] = [
    '#type' => 'checkbox',
    '#title' => t('Inverted buttons'),
    '#description' => t('The text color becomes the background color, and vice-versa'),
    '#default_value' => theme_get_setting('bulma_button_inverted'),
  ];

  $form['bulma_button']['notice_button'] = [
    '#markup' => t('You can combine Outlined and Inverted buttons - the invert color becomes the text and border colors'),
  ];

  // Bulma buttons settings.
  $form['bulma_elements'] = [
    '#type' => 'details',
    '#title' => t('Bulma Form Elements'),
    '#description' => t('Contains settings for form elements, see <a href="@docs">documentation</a>', [
      '@docs' => Url::fromUri('http://bulma.io/documentation/elements/form/',
        ['attributes' => ['target' => '_blank']])
        ->toString(),
    ]),
  ];

  $form['bulma_elements']['bulma_elements_labels_inline'] = [
    '#type' => 'checkbox',
    '#title' => t('Horizontal form'),
    '#description' => t('Not working currently, lot of precise adjustments needs to be done to implement this'),
    '#default_value' => theme_get_setting('bulma_elements_labels_inline'),
    '#disabled' => TRUE,
  ];

  $form['bulma_elements']['bulma_elements_labels_rounded'] = [
    '#type' => 'checkbox',
    '#title' => t('Rounded labels'),
    '#description' => t('Rounder labels'),
    '#default_value' => theme_get_setting('bulma_elements_labels_rounded'),
  ];

  $form['bulma_elements']['bulma_elements_labels_color'] = [
    '#type' => 'select',
    '#title' => t('Labels style'),
    '#description' => t('Color/style of the labels'),
    '#options' => [
      '0' => t('Default'),
      'is-black' => t('Black'),
      'is-dark' => t('Dark'),
      'is-light' => t('Light'),
      'is-white' => t('White'),
      'is-primary' => t('Primary'),
      'is-info' => t('Info'),
      'is-success' => t('Success'),
      'is-warning' => t('Warning'),
      'is-danger' => t('Danger'),
    ],
    '#default_value' => theme_get_setting('bulma_elements_labels_color'),
  ];

  $form['bulma_elements']['bulma_elements_labels_size'] = [
    '#type' => 'select',
    '#title' => t('Labels size'),
    '#description' => t('Size of the labels'),
    '#options' => [
      '0' => t('Default'),
      'is-medium' => t('Medium'),
      'is-large' => t('Large'),
    ],
    '#default_value' => theme_get_setting('bulma_elements_labels_size'),
  ];

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
      '0' => t('Left'),
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
      '0' => t('Default'),
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
      '0' => t('Default'),
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
