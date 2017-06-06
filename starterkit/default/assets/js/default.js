/**
 * @file
 * BULMA_SUBTHEME_MACHINE_NAME scripts for theme.
 */
(function ($) {
  'use strict';

  Drupal.behaviors.BULMA_SUBTHEME_MACHINE_NAME = {
    attach: function (context) {

      var $toggle = $('#nav-toggle');
      var $menu = $('#nav-menu');

      $toggle.click(function () {
        $(this).toggleClass('is-active');
        $menu.toggleClass('is-active');
      });

    }
  };

})(jQuery);
