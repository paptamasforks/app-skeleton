var Auth = Model(
    {
        urls: {
            signup:   Url.map('service.auth.signup'),
            edit:     Url.map('service.auth.edit'),
            login:    Url.map('service.auth.login'),
            recover:  Url.map('service.auth.recover'),
            reset:    Url.map('service.auth.reset')
        }
    },
    {
        /**
         * Signup
         *
         * @return {*}
         */
        signup: function() {
            return this._action('signup');
        },

        /**
         * Edit account
         *
         * @return {*}
         */
        edit: function() {
            return this._action('edit');
        },

        /**
         * Login
         *
         * @return {*}
         */
        login: function() {
            return this._action('login');
        },

        /**
         * Recover password
         *
         * @return {*}
         */
        recover: function() {
            return this._action('recover');
        },

        /**
         * Reset password
         *
         * @return {*}
         */
        reset: function() {
            return this._action('reset');
        },

        /**
         * Helper for other methods
         *
         * @param method
         * @return {*}
         * @private
         */
        _action: function(method) {
            return $.ajax({
                url: Auth.urls[method],
                type: 'post',
                dataType: 'json',
                data: this.serialize()
            });
        }
    }
);