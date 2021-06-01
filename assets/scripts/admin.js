"use strict";

(function ($) {
  'use strict';
  /**
   * All of the code for your Dashboard-specific JavaScript source
   * should reside in this file.
   *
   * Note that this assume you're going to use jQuery, so it prepares
   * the $ function reference to be used within the scope of this
   * function.
   *
   * From here, you're able to define handlers for when the DOM is
   * ready:
   *
   * $(function() {
   *
   * });
   *
   * Or when the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and so on.
   *
   * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
   * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
   * be doing this, we should try to minimize doing that in our own work.
   */

  $(document).ready(function () {
    /**
     * Admin code for dismissing notifications.
     *
     */
    $('.cdxn-mlh-notice').on('click', '.notice-dismiss, .cdxn-mlh-notice-action', function () {
      var $this = $(this);
      var admin_ajax = cdxn_mlh_script.admin_ajax;
      var parents = $(this).parents('.cdxn-mlh-notice');
      var dismiss_type = $(this).data('dismiss');
      var notice_type = parents.data('notice');

      if (!dismiss_type) {
        dismiss_type = '';
      }

      var data = {
        action: 'rate_the_plugin',
        dismiss_type: dismiss_type,
        notice_type: notice_type,
        cx_nonce: cdxn_mlh_script.ajx_nonce
      };
      jQuery.ajax({
        type: 'POST',
        url: admin_ajax,
        data: data,
        success: function success(response) {
          if (response) {
            $this.parents('.cdxn-mlh-notice').remove();
          }
        }
      });
    });
  });
})(jQuery);