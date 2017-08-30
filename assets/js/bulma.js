/**
 * @file
 * Bulma scripts for theme.
 */
(function ($) {
  'use strict';

  Drupal.behaviors.bulma = {
    attach: function (context) {
      var $toggle = $('#js-navbar-burger').once('bulma');
      if ($toggle.length) {
        var $menu = $('#js-navbar-menu');

        $toggle.click(function () {
          $(this).toggleClass('is-active');
          $menu.toggleClass('is-active');
        });
      }
    }
  };

})(jQuery);
