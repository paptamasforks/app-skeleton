Controller.Page.Oauth = Controller.Page({

    /**
     * Signup with facebook
     */
    action_facebook: function() {
        this._process_oauth();
    },

    /**
     * Signup with google
     */
    action_google: function() {
        this._process_oauth();
    },

    /**
     * Process signup for both facebook and google
     *
     * @private
     */
    _process_oauth: function() {
        $('#oauth-signup-form').bind('submit', $.proxy(function(e) {
            e.preventDefault();

            // Try to sign up
            var oauth = new OAuth($('#oauth-signup-form').formParams());
            oauth.signup()
                .done($.proxy(this, '_signupSuccess'))
                .fail($.proxy(this, '_signupFail'));

            return false;
        }, this));
    },

    /**
     * On signup success
     *
     * @param response
     * @private
     */
    _signupSuccess: function(response) {
        // Go to "next" page
        $.redirect(response.next);
    },

    /**
     * On signup fail
     *
     * @param jqXHR
     * @private
     */
    _signupFail: function(jqXHR) {
        if (jqXHR.status == 409) {
            // Something went wrong
            var response = $.parseJSON(jqXHR.responseText);

            // Hide signup errors if exists
            if ($('#oauth-signup-form').hasClass('errors')) {
                $('#oauth-signup-form').errors('hide');
            }

            if (response.errors) {
                // Incorrect signup details
                $('#oauth-signup-form').errors({errors: response.errors});
            }
            else {
                // Some server error
                alert(response.message);
            }

        }
    }
});
