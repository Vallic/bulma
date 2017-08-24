<?php

/**
 * @file
 * Add custom theme settings to the Bulma base theme.
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function bulma_form_system_theme_settings_alter(&$form, FormStateInterface $form_state, $form_id = NULL) {

  // Get all menus.
  $menus = menu_ui_get_menus(FALSE);

  $form['bulma'] = array(
    '#type' => 'vertical_tabs',
    '#default_tab' => 'edit-bulma-general',
    '#weight' => -10,
  );

  // Bulma general settings.
  $form['general'] = [
    '#type' => 'details',
    '#title' => t('Bulma general settings'),
    '#description' => t('Contains general settings, blocks, etc.'),
    '#group' => 'bulma',
    '#tree' => TRUE,
  ];

  $form['general']['block'] = [
    '#type' => 'checkbox',
    '#title' => t('Block panel style'),
    '#description' => t('Applied only on blocks with title or label visible / enabled so as to skip branding, menus, and similar blocks.'),
    '#default_value' => theme_get_setting('general.block'),
  ];

  $form['general']['icon'] = [
    '#type' => 'checkbox',
    '#title' => t('Use icons'),
    '#description' => t('Use font awesome icons'),
    '#default_value' => theme_get_setting('general.icon'),
  ];

  $form['general']['icon_type'] = [
    '#type' => 'checkbox',
    '#title' => t('Use default field type icons'),
    '#description' => t('If field label / value is not matched, use the default font awesome icons by Drupal field type.'),
    '#default_value' => theme_get_setting('general.icon_type'),
  ];

  // Define some system menus manual.
  // If we use dynamic, on install setting defaults will fail.
  $form['general']['menu'] = [
    '#type' => 'select',
    '#title' => t('Bulma Nav Menu'),
    '#description' => t('Select which menu will be used as the nav menu - horizontal.'),
    '#options' => [
      'none' => t('None'),
      'main' => t('Main navigation'),
      'footer' => t('Footer'),
      'account' => t('User account menu'),
    ] + $menus,
    '#default_value' => theme_get_setting('general.menu'),
  ];

  // Bulma buttons settings.
  $form['button'] = [
    '#type' => 'details',
    '#title' => t('Bulma Button'),
    '#description' => t('Contains settings for buttons, see <a href=":docs" target="_blank">documentation</a>', [
      ':docs' => 'http://bulma.io/documentation/elements/button/',
    ]),
    '#group' => 'bulma',
    '#tree' => TRUE,
  ];

  $form['button']['colorize'] = [
    '#type' => 'checkbox',
    '#title' => t('Colorize buttons'),
    '#description' => t('Colorize buttons by type -  Primary / Info /  Success /  Warning / Danger'),
    '#default_value' => theme_get_setting('button.colorize'),
  ];

  $form['button']['size'] = [
    '#type' => 'select',
    '#title' => t('Button size'),
    '#description' => t('Size of the buttons'),
    '#options' => [
      'is-small' => t('Small'),
      'is-medium' => t('Medium'),
      'is-large' => t('Large'),
    ],
    '#empty_option' => t('Default'),
    '#empty_value' => '0',
    '#default_value' => theme_get_setting('button.size'),
  ];

  $form['button']['outlined'] = [
    '#type' => 'checkbox',
    '#title' => t('Outlined buttons'),
    '#description' => t('Colorize buttons by type'),
    '#default_value' => theme_get_setting('button.outlined'),
  ];

  $form['button']['inverted'] = [
    '#type' => 'checkbox',
    '#title' => t('Inverted buttons'),
    '#description' => t('The text color becomes the background color, and vice-versa'),
    '#default_value' => theme_get_setting('button.inverted'),
  ];

  $form['button']['notice_button'] = [
    '#markup' => t('You can combine Outlined and Inverted buttons - the invert color becomes the text and border colors.'),
  ];

  // Bulma elements settings.
  $form['elements'] = [
    '#type' => 'details',
    '#title' => t('Bulma Form Elements'),
    '#description' => t('Contains settings for form elements, see <a href=":docs" target="_blank">documentation</a>', [
      ':docs' => 'http://bulma.io/documentation/elements/form/',
    ]),
    '#group' => 'bulma',
    '#tree' => TRUE,
  ];

  $form['elements']['labels_inline'] = [
    '#type' => 'checkbox',
    '#title' => t('Horizontal form'),
    '#description' => t('Not working currently, lot of precise adjustments needs to be done to implement this'),
    '#default_value' => theme_get_setting('elements.labels_inline'),
  ];

  $form['elements']['input_size'] = [
    '#type' => 'select',
    '#title' => t('Form element size'),
    '#description' => t('Size of the form elements - inputs, select'),
    '#options' => [
      'is-small' => t('Small'),
      'is-medium' => t('Medium'),
      'is-large' => t('Large'),
    ],
    '#empty_option' => t('Default'),
    '#empty_value' => '0',
    '#default_value' => theme_get_setting('elements.input_size'),
  ];

  $form['elements']['labels_rounded'] = [
    '#type' => 'checkbox',
    '#title' => t('Rounded labels'),
    '#description' => t('Rounded labels'),
    '#default_value' => theme_get_setting('elements.labels_rounded'),
  ];

  $form['elements']['labels_color'] = [
    '#type' => 'select',
    '#title' => t('Labels style'),
    '#description' => t('Color/style of the labels'),
    '#options' => [
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
    '#empty_option' => t('Default'),
    '#empty_value' => '0',
    '#default_value' => theme_get_setting('elements.labels_color'),
  ];

  $form['elements']['labels_size'] = [
    '#type' => 'select',
    '#title' => t('Labels size'),
    '#description' => t('Size of the labels'),
    '#options' => [
      'is-medium' => t('Medium'),
      'is-large' => t('Large'),
    ],
    '#empty_option' => t('Default'),
    '#empty_value' => '0',
    '#default_value' => theme_get_setting('elements.labels_size'),
  ];

  // Bulma tabs settings.
  $form['tabs'] = [
    '#type' => 'details',
    '#title' => t('Bulma Tabs'),
    '#description' => t('Contains settings for tabs display, see <a href=":docs" target="_blank">documentation</a>', [
      ':docs' => 'http://bulma.io/documentation/components/tabs/',
    ]),
    '#group' => 'bulma',
    '#tree' => TRUE,
  ];

  $form['tabs']['position'] = [
    '#type' => 'select',
    '#title' => t('Tabs positions'),
    '#description' => t('Position for tabs, default is left'),
    '#options' => [
      'is-centered' => t('Center'),
      'is-right' => t('Right'),
    ],
    '#empty_option' => t('Left'),
    '#empty_value' => '0',
    '#default_value' => theme_get_setting('tabs.position'),
  ];

  $form['tabs']['size'] = [
    '#type' => 'select',
    '#title' => t('Tabs size'),
    '#description' => t('Size of the tabs'),
    '#options' => [
      'is-small' => t('Small'),
      'is-medium' => t('Medium'),
      'is-large' => t('Large'),
    ],
    '#empty_option' => t('Default'),
    '#empty_value' => '0',
    '#default_value' => theme_get_setting('tabs.size'),
  ];

  $form['tabs']['style'] = [
    '#type' => 'select',
    '#title' => t('Tabs style'),
    '#description' => t('Look & feel of the tabs.'),
    '#options' => [
      'is-boxed' => t('Classic with borders'),
      'is-toggle' => t('Mutually exclusive'),
    ],
    '#empty_option' => t('Default'),
    '#empty_value' => '0',
    '#default_value' => theme_get_setting('tabs.style'),
  ];

  $form['tabs']['fullwidth'] = [
    '#type' => 'checkbox',
    '#title' => t('Fullwidth'),
    '#description' => t('If you want tabs to be display in full width'),
    '#default_value' => theme_get_setting('tabs.fullwidth'),
  ];

  // Bulma table settings.
  $form['table'] = [
    '#type' => 'details',
    '#title' => t('Bulma Table'),
    '#description' => t('Contains settings for table display see <a href=":docs" target="_blank">documentation</a>', [
      ':docs' => 'http://bulma.io/documentation/elements/table/',
    ]),
    '#group' => 'bulma',
    '#tree' => TRUE,
  ];

  $form['table']['bordered'] = [
    '#type' => 'checkbox',
    '#title' => t('Bordered'),
    '#description' => t('Add borders to all the cells.'),
    '#default_value' => theme_get_setting('table.bordered'),
  ];

  $form['table']['striped'] = [
    '#type' => 'checkbox',
    '#title' => t('Striped'),
    '#description' => t('Add stripes to the table.'),
    '#default_value' => theme_get_setting('table.striped'),
  ];

  $form['table']['narrow'] = [
    '#type' => 'checkbox',
    '#title' => t('Narrow'),
    '#description' => t('Make the cells narrower.'),
    '#default_value' => theme_get_setting('table.narrow'),
  ];
}
