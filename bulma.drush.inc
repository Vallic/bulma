<?php

/**
 * @file
 * Contains Drush hooks. Inspired by Zen and Omega Tools.
 */

use Drupal\Component\Utility\UrlHelper;

/**
 * Implements hook_drush_command().
 */
function bulma_drush_command() {
  $items = [];

  $items['bulma'] = [
    'description' => 'Create a Bulma subtheme.',
    'arguments' => [
      'name' => 'The name of your subtheme.',
    ],
    'options' => [
      'machine_name' => 'The machine-readable name of your subtheme. This will be auto-generated from the human-readable name if ommited.',
      'description' => 'The description of your subtheme',
      'destination' => 'The destination of your subtheme. Defaults to "themes".',
      'kit' => 'The name or url of the starter kit to use. Defaults to "default".',
    ],
    'examples' => [
      'drush bulma "My Theme"' => 'Creates a Bulma subtheme called "My Theme", using the default options.',
      'drush bulma "My Theme" --machine_name=my_theme' => 'Creates a Bulma subtheme called "My Theme" with a specific machine name.',
    ],
  ];

  return $items;
}

/**
 * Implements hook_drush_help().
 */
function bulma_drush_help($section) {

  switch ($section) {
    case 'drush:bulma':
      return dt('This command will create a Bulma subtheme. See examples to get started.');
      break;
  }
}

/**
 * Implements drush_hook_COMMAND().
 */
function drush_bulma($name = NULL, $machine_name = NULL) {

  // If no $name provided, abort.
  if (!$name) {
    drush_print(dt('Theme name missing. See help using drush bulma --help.'));
    return;
  }

  // Determine the theme name.
  if (!isset($name)) {
    $name = drush_get_option('name');
  }

  // Determine the machine name.
  if (!isset($machine_name)) {
    $machine_name = drush_get_option('machine_name');
  }
  if (!$machine_name) {
    $machine_name = $name;
  }
  $machine_name = str_replace(' ', '_', strtolower($machine_name));
  $search = [
    '/[^a-z0-9_]/', // Remove characters not valid in function names.
    '/^[^a-z]+/',   // Functions must begin with an alpha character.
  ];
  $machine_name = preg_replace($search, '', $machine_name);

  // Description of subtheme.
  $description = (drush_get_option('description')) ? trim(drush_get_option('description')) : 'A theme based on Bulma.';

  // Determine the path to the new subtheme.
  $subtheme_path = 'themes';
  if ($path = drush_get_option('path')) {
    $subtheme_path = drush_trim_path($path);
  }
  $subtheme_path = drush_normalize_path(drush_get_context('DRUSH_DRUPAL_ROOT') . '/' . $subtheme_path . '/' . $machine_name);

  // Determine the kit to use.
  $kit = (drush_get_option('kit')) ? drush_trim_path(drush_get_option('kit')) : 'default';

  // Make a fresh copy of the kit.
  $kit_path = drush_normalize_path(drush_get_context('DRUSH_DRUPAL_ROOT') . '/' . drupal_get_path('theme', 'bulma') . '/starterkit/' . $kit);

  // Allow kits to be pulled from external urls.
  if (UrlHelper::isValid($kit, TRUE)) {
    $kit_url = $kit;
    $kit_name = 'kit';

    // Get kit name from kit url.
    if (preg_match("/\/bulma\-kit\-([a-z0-9\_]*)\//", $kit_url, $matches)) {
      $kit_name = $kit = $matches[1];
    }

    // Switch to a temp directory.
    $current_dir = getcwd();
    chdir(drush_tempdir());

    drush_print(dt('Downloading @kit_name from @kit_url...', [
      '@kit_name' => (!empty($kit_name)) ? $kit_name . ' kit' : $kit_name,
      '@kit_url' => $kit_url,
    ]));
    if ($filepath = drush_download_file($kit_url)) {
      $filename = basename($filepath);

      // Decompress the zip archive.
      $files = drush_tarball_extract($filename, getcwd(), TRUE);

      // Re-index array.
      // This fixes an issue where a .tag.gz tarball returns a non-zero array.
      $files = array_values($files);
      $kit_path = getcwd() . '/' . $files[0];

      // Set working directory back to the previous working directory.
      chdir($current_dir);
    }
  }

  if (!is_dir(dirname($subtheme_path))) {
    drush_die(dt('The directory "!directory" was not found.', ['!directory' => dirname($subtheme_path)]));
  }
  drush_op('drush_copy_dir', $kit_path, $subtheme_path);

  // Alter the contents of the .info file based on the command options.
  $alterations = [
    'BULMA_SUBTHEME_NAME' => $name,
    'BULMA_SUBTHEME_DESCRIPTION' => $description,
    'BULMA_SUBTHEME_MACHINE_NAME' => $machine_name,
    'hidden: true' => '',
  ];

  // Replace all occurrences of '{{machine_name}}' with the machine name of our sub theme.
  $files_to_replace = bulma_get_files_to_make_replacements($kit);
  foreach ($files_to_replace as $file_to_replace) {
    drush_op('bulma_file_str_replace', $subtheme_path . '/' . $file_to_replace, array_keys($alterations), $alterations);
  }

  // Rename files.
  $files_to_rename = [
    '{{kit}}.cdn.yml',
    '{{kit}}.info.yml',
    '{{kit}}.libraries.yml',
    '{{kit}}.breakpoints.yml',
    '{{kit}}.theme',
    'assets/{{kit}}.style.css',
    'assets/{{kit}}.style.css.map',
    'assets/{{kit}}.style.scss',
    'config/install/{{kit}}.settings.yml',
    'config/schema/{{kit}}.schema.yml',
    'config/optional/block.block.{{kit}}_account_menu.yml',
    'config/optional/block.block.{{kit}}_branding.yml',
    'config/optional/block.block.{{kit}}_content.yml',
    'config/optional/block.block.{{kit}}_help.yml',
    'config/optional/block.block.{{kit}}_local_tasks.yml',
    'config/optional/block.block.{{kit}}_main_menu.yml',
    'config/optional/block.block.{{kit}}_messages.yml',
    'config/optional/block.block.{{kit}}_page_title.yml',
    'config/optional/block.block.{{kit}}_powered.yml',
    'config/optional/block.block.{{kit}}_search.yml',
    'config/optional/block.block.{{kit}}_tools.yml',
  ];
  foreach ($files_to_rename as $file_to_rename_path) {
    $file_original_path = $subtheme_path . '/' . str_replace('{{kit}}', $kit, $file_to_rename_path);
    $file_new_path = $subtheme_path . '/' . str_replace('{{kit}}', $machine_name, $file_to_rename_path);
    drush_op('rename', drush_normalize_path($file_original_path), drush_normalize_path($file_new_path));
  }

  // Notify user of the newly created theme.
  $message = 'Successfully created the Bulma subtheme "!name" created in: !path using the "!kit" kit';

  $message = dt($message . '.', [
    '!name' => $name,
    '!path' => $subtheme_path,
    '!kit' => $kit,
  ]);
  drush_print($message);
}

/**
 * Replace strings in a file.
 */
function bulma_file_str_replace($file_path, $find, $replace) {
  $file_path = drush_normalize_path($file_path);
  $file_contents = file_get_contents($file_path);
  $file_contents = str_replace($find, $replace, $file_contents);
  file_put_contents($file_path, $file_contents);
}

/**
 * Returns an array of files to make string replacements.
 */
function bulma_get_files_to_make_replacements($kit = 'default') {
  return [
    'config/install/' . $kit . '.settings.yml',
    'config/optional/block.block.' . $kit . '_account_menu.yml',
    'config/optional/block.block.' . $kit . '_branding.yml',
    'config/optional/block.block.' . $kit . '_content.yml',
    'config/optional/block.block.' . $kit . '_help.yml',
    'config/optional/block.block.' . $kit . '_local_tasks.yml',
    'config/optional/block.block.' . $kit . '_main_menu.yml',
    'config/optional/block.block.' . $kit . '_messages.yml',
    'config/optional/block.block.' . $kit . '_page_title.yml',
    'config/optional/block.block.' . $kit . '_powered.yml',
    'config/optional/block.block.' . $kit . '_search.yml',
    'config/optional/block.block.' . $kit . '_tools.yml',
    'config/schema/' . $kit . '.schema.yml',
    'assets/' . $kit . '.style.css',
    'assets/' . $kit . '.style.css.map',
    'assets/' . $kit . '.style.scss',
    $kit . '.cdn.yml',
    $kit . '.info.yml',
    $kit . '.libraries.yml',
    $kit . '.theme',
    $kit . '.breakpoints.yml',
    'README.md',
  ];
}
