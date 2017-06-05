/**
 * @file
 * Bulma scripts for theme.
 */
(function ($) {
  'use strict';

  Drupal.behaviors.bulma = {
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
