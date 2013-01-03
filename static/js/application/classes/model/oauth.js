var OAuth = Model(
    {
        urls: {
            signup:   Url.map('service.oauth.signup')
        }
    },
    {
        signup: function() {
            return $.ajax({
                url: OAuth.urls.signup,
                type: 'post',
                dataType: 'json',
                data: this.serialize()
            });
        }
    }
);