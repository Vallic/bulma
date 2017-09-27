<?php

/**
 * @file
 * Add custom theme settings to the Bulma base theme.
 */

use Drupal\bulma\Bulma;
use Drupal\bulma\Bulmaswatch;
use Drupal\Component\Utility\NestedArray;
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

  // Bulma breadcrumbs settings.
  $form['breadcrumb'] = [
    '#type' => 'details',
    '#title' => t('Bulma Breadcrumbs'),
    '#description' => t('Contains settings for breadcrumbs display, see <a href=":docs" target="_blank">documentation</a>', [
      ':docs' => 'http://bulma.io/documentation/components/breadcrumb/',
    ]),
    '#group' => 'bulma',
    '#tree' => TRUE,
  ];

  $form['breadcrumb']['position'] = [
    '#type' => 'select',
    '#title' => t('Breadcrumbs position'),
    '#description' => t('Position for breadcrumbs, default is left'),
    '#options' => [
      'is-centered' => t('Center'),
      'is-right' => t('Right'),
    ],
    '#empty_option' => t('Left'),
    '#empty_value' => '0',
    '#default_value' => theme_get_setting('breadcrumb.position'),
  ];

  $form['breadcrumb']['size'] = [
    '#type' => 'select',
    '#title' => t('Breadcrumbs size'),
    '#description' => t('Size of the breadcrumbs'),
    '#options' => [
      'is-small' => t('Small'),
      'is-medium' => t('Medium'),
      'is-large' => t('Large'),
    ],
    '#empty_option' => t('Default'),
    '#empty_value' => '0',
    '#default_value' => theme_get_setting('breadcrumb.size'),
  ];

  $form['breadcrumb']['separator'] = [
    '#type' => 'select',
    '#title' => t('Breadcrumbs separator'),
    '#description' => t('Character used to separate breadcrumbs, default is forward slash (&#x0002f).'),
    '#options' => [
      'has-arrow-separator' => t('Arrow (&#x02192)'),
      'has-bullet-separator' => t('Bullet (&#x02022)'),
      'has-dot-separator' => t('Dot (&#x000b7)'),
      'has-succeeds-separator' => t('Succeeds (&#x0227B)'),
    ],
    '#empty_option' => t('Default (&#x0002f)'),
    '#empty_value' => '0',
    '#default_value' => theme_get_setting('breadcrumb.style'),
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

  $cdn_data = Bulma::getCdnData();

  // CDN settings.
  $form['cdn'] = [
    '#type' => 'details',
    '#title' => t('Versions and alternative themes/skins'),
    '#group' => 'bulma',
    '#tree' => TRUE,
  ];

  $form['cdn']['bulma'] = [
    '#type' => 'details',
    '#title' => t('Bulma'),
    '#open' => TRUE,
  ];

  if (!Bulma::isLocal()) {
    $versions = Bulma::getCdnVersions('bulma');
    $form['cdn']['bulma']['version'] = [
      '#type' => 'select',
      '#title' => t('Version'),
      '#description' => t('Select a Bulma version provided by the CDN <a href=":home" target="_blank">@name</a>.', [
        ':home' => $cdn_data['home'],
        '@name' => $cdn_data['name'],
      ]),
      '#options' => $versions,
      '#default_value' => theme_get_setting('cdn.bulma.version'),
    ];
    $form['cdn']['bulma']['message'] = [
      '#type' => 'item',
      '#markup' => '<p>' . t('To use a local version of Bulma, <a href=":download" target="_blank">download</a> a Bulma release and extract it to <code>libraries/bulma</code> so that the README.md file is at <code>libraries/bulma/README.md</code>.', [':download' => 'https://github.com/jgthms/bulma/releases']) . '</p>',
    ];
  }
  else {
    $version = Bulma::getBulmaLocalVersion();
    $form['cdn']['bulma']['version'] = [
      '#type' => 'item',
      '#title' => t('Version'),
      '#markup' => t('Using locally installed version %version.', ['%version' => $version]),
    ];
  }

  if ($themes = Bulmaswatch::getThemes()) {
    // Bulmaswatch settings.
    $form['cdn']['bulmaswatch'] = [
      '#type' => 'details',
      '#title' => t('Bulmaswatch'),
      '#description' => t('Select a custom theme provided by Bulmaswatch; see <a href=":docs" target="_blank">documentation</a>.', [
        ':docs' => 'https://jenil.github.io/bulmaswatch',
      ]),
      '#open' => TRUE,
    ];

    if (!Bulmaswatch::isLocal()) {
      $versions = Bulma::getCdnVersions('bulmaswatch');
      $form['cdn']['bulmaswatch']['version'] = [
        '#type' => 'select',
        '#title' => t('Version'),
        '#description' => t('Select a Bulmaswatch version provided by the CDN <a href=":home" target="_blank">@name</a>.', [
          ':home' => $cdn_data['home'],
          '@name' => $cdn_data['name'],
        ]),
        '#options' => $versions,
        '#default_value' => theme_get_setting('cdn.bulmaswatch.version'),
      ];
      $form['cdn']['bulmaswatch']['message'] = [
        '#type' => 'item',
        '#markup' => '<p>' . t('To use a local version of Bulmaswatch, <a href=":download" target="_blank">download</a> a Bulmaswatch release and extract it to <code>libraries/bulmaswatch</code> so that the README.md file is at <code>libraries/bulmaswatch/README.md</code>.', [':download' => 'https://github.com/jenil/bulmaswatch/releases']) . '</p>',
        '#weight' => 10,
      ];
    }
    else {
      $api_data = Bulmaswatch::getBulmaswatchApiData();
      $form['cdn']['bulmaswatch']['version'] = [
        '#type' => 'item',
        '#title' => t('Version'),
        '#markup' => t('Using locally installed version %version.', ['%version' => $api_data['version']]),
      ];
    }
    $form['cdn']['bulmaswatch']['theme'] = [
      '#type' => 'select',
      '#title' => t('Theme'),
      '#options' => [],
      '#empty_option' => t('Default'),
      '#empty_value' => 'default',
      '#default_value' => theme_get_setting('cdn.bulmaswatch.theme'),
      '#open' => TRUE,
    ];

    foreach ($themes as $machine_name => $theme) {
      $form['cdn']['bulmaswatch']['theme']['#options'][$machine_name] = t('@name: @description', ['@name' => $theme['name'], '@description' => $theme['description']]);
      $form['cdn']['bulmaswatch']['theme_preview_' . $machine_name] = [
        '#type' => 'item',
        '#markup' => '<p>' . t('<a href=":preview" target="_blank">Preview</a> the %name theme.', [':preview' => $theme['preview'], '%name' => $theme['name']]) . '</p>',
        '#states' => [
          'visible' => [
            'select[name="cdn[bulmaswatch][theme]"]' => ['value' => $machine_name],
          ],
        ],
      ];
    }
  }

  $form['#validate'][] = 'bulma_form_system_theme_settings_validate';
  $form['#submit'][] = 'bulma_form_system_theme_settings_submit';
}

/**
 * Form validation handler for system_theme_settings form.
 */
function bulma_form_system_theme_settings_validate($form, FormStateInterface $form_state) {
  // Set a flag to indicate whether caches need to be cleared.
  $flush_caches = FALSE;
  $settings = [
    [
      'cdn',
      'bulma',
      'version',
    ],
    [
      'cdn',
      'bulmaswatch',
      'version',
    ],
    [
      'cdn',
      'bulmaswatch',
      'theme',
    ],
  ];
  foreach ($settings as $setting) {
    $original_value = NestedArray::getValue($form, array_merge($setting, ['#default_value']), $key_exists);
    if ($key_exists) {
      $submitted_value = $form_state->getValue($setting);
      if ($submitted_value !== $original_value) {
        $flush_caches = TRUE;
        break;
      }
    }
  }
  $form_state->set('flush_caches', $flush_caches);

  // Unset form values that don't need to be saved.
  // Unset bulma keys.
  $bulma_parent_keys = [
    'cdn',
    'bulma',
  ];
  $bulma_value = $form_state->getValue($bulma_parent_keys);
  unset($bulma_value['message']);
  $form_state->setValue($bulma_parent_keys, $bulma_value);
  // Unset bulmaswatch keys.
  $bulmaswatch_parent_keys = [
    'cdn',
    'bulmaswatch',
  ];
  $bulmaswatch_value = $form_state->getValue($bulmaswatch_parent_keys);
  unset($bulmaswatch_value['message']);
  if ($themes = Bulmaswatch::getThemes()) {
    foreach (array_keys($themes) as $machine_name) {
      unset($bulmaswatch_value['theme_preview_' . $machine_name]);
    }
  }
  $form_state->setValue($bulmaswatch_parent_keys, $bulmaswatch_value);
}

/**
 * Form submission handler for system_theme_settings form.
 */
function bulma_form_system_theme_settings_submit($form, FormStateInterface $form_state) {
  // Clear cached data so a change will take effect.
  if ($form_state->get('flush_caches')) {
    drupal_flush_all_caches();
  }
}
