Controller.Page.Auth = Controller.Page({

    /**
     * Signup
     */
    action_signup: function() {
        $('#auth-signup-form').bind('submit', $.proxy(function(e) {
            e.preventDefault();

            // Try to sign up
            var auth = new Auth($('#auth-signup-form').formParams());
            auth.signup()
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
            if ($('#auth-signup-form').hasClass('errors')) {
                $('#auth-signup-form').errors('hide');
            }

            if (response.errors) {
                // Incorrect signup details
                $('#auth-signup-form').errors({errors: response.errors});
            }
            else {
                // Some server error
                alert(response.message);
            }
        }
    },


    /**
     * Edit profile
     */
    action_edit: function() {
        $('#auth-edit-form').bind('submit', $.proxy(function(e) {
            e.preventDefault();

            // Try to edit user profile
            var auth = new Auth($('#auth-edit-form').formParams());
            auth.edit()
                .done($.proxy(this, '_editSuccess'))
                .fail($.proxy(this, '_editFail'));

            return false;
        }, this));
    },

    /**
     * On edit success
     *
     * @param response
     * @private
     */
    _editSuccess: function(response) {
        // Go to "next" page
        $.redirect(response.next);
    },

    /**
     * On edit fail
     *
     * @param jqXHR
     * @private
     */
    _editFail: function(jqXHR) {
        if (jqXHR.status == 409) {
            // Something went wrong
            var response = $.parseJSON(jqXHR.responseText);

            // Hide signup errors if exists
            if ($('#auth-edit-form').hasClass('errors')) {
                $('#auth-edit-form').errors('hide');
            }

            if (response.errors) {
                // Incorrect update data
                $('#auth-edit-form').errors({errors: response.errors});
            }
            else {
                // Some server error
                alert(response.message);
            }
        }
    },


    /**
     * Login
     */
    action_login: function() {
        /*
        // If you want to submit login form with ajax use this code
        $('#auth-login-form').bind('submit', $.proxy(function(e) {
            e.preventDefault();

            // Try to login
            var auth = new Auth($('#auth-login-form').formParams());
            auth.login()
                .done($.proxy(this, '_loginSuccess'))
                .fail($.proxy(this, '_loginFail'));

            return false;
        }, this));
        */

        /**
         By default we don't submit the login form with ajax because Chrome doesn't save passwords if
         the form submission is prevented or the form is submitted ot an iframe
         */
        // Check for server sent errors
        var errors;
        if (errors = $('#auth-login-form').data('errors'))
        {
            $('#auth-login-form').errors({errors: errors});
        }
    },

    /**
     * On login success
     *
     * @param response
     * @private
     */
    _loginSuccess: function(response) {
        // Go to "next" page
        $.redirect(response.next);
    },

    /**
     * On login fail
     *
     * @param jqXHR
     * @private
     */
    _loginFail: function(jqXHR) {
        if (jqXHR.status == 409) {
            // Incorrect login info
            var response = $.parseJSON(jqXHR.responseText);

            // Hide login errors if exists
            if ($('#auth-login-form').hasClass('errors')) {
                $('#auth-login-form').errors('hide');
            }

            $('#auth-login-form').errors({errors: response.errors});
        }
    },


    /**
     * Recover
     */
    action_recover: function() {
        $('#auth-recovery-form').bind('submit', $.proxy(function(ev) {
            ev.preventDefault();

            // Try to recover password
            var auth = new Auth($('#auth-recovery-form').formParams());
            auth.recover()
                .done($.proxy(this, '_recoverSuccess'))
                .fail($.proxy(this, '_recoverFail'));

            return false;
        }, this));
    },

    /**
     * On recover success
     *
     * @param response
     * @private
     */
    _recoverSuccess: function(response) {
        // Go to 'next' page
        $.redirect(response.next);
    },

    /**
     * On recover fail
     *
     * @param jqXHR
     * @private
     */
    _recoverFail: function(jqXHR) {
        if (jqXHR.status == 409) {
            // Incorrect recovery data
            var response = $.parseJSON(jqXHR.responseText);

            // Hide recovery errors if exists
            if ($('#auth-recovery-form').hasClass('errors')) {
                $('#auth-recovery-form').errors('hide');
            }

            if (response.errors) {
                // Problem with the provided email
                $('#auth-recovery-form').errors({errors: response.errors});
            }
            else {
                // Some email server error
                alert(response.message);
            }
        }
    },


    /**
     * Reset
     */
    action_reset: function() {
        $('#auth-reset-form').bind('submit', $.proxy(function(ev) {
            ev.preventDefault();

            // Try to reset password
            // Get the secure key
            var secure_key = Request.param('id');

            // Get form params
            var data = $('#auth-reset-form').formParams();

            // Add secure key to form params
            data.reset.secure_key = secure_key;

            var auth = new Auth(data);

            // Try to reset password
            auth.reset()
                .done($.proxy(this, '_resetSuccess'))
                .fail($.proxy(this, '_resetFail'));

            return false;
        }, this));
    },

    /**
     * On reset success
     *
     * @param response
     * @private
     */
    _resetSuccess: function(response) {
        // Go to 'next' page
        $.redirect(response.next);
    },

    /**
     * On reset fail
     *
     * @param jqXHR
     * @private
     */
    _resetFail: function(jqXHR) {
        if (jqXHR.status == 409) {
            // Incorrect reset data
            var response = $.parseJSON(jqXHR.responseText);

            // Hide resetting errors if exists
            if ($('#auth-reset-form').hasClass('errors')) {
                $('#auth-reset-form').errors('hide');
            }

            if (response.errors) {
                // Some validation errors
                $('#auth-reset-form').errors({errors: response.errors});
            }
            else {
                // Some server error
                alert(response.message);
            }
        }
    }
});
