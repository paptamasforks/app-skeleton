<form id="oauth-signup-form" autocomplete="off">
    <div class="auth-box signup">
        <h1><?= __('Sign up with your :oauth_provider account', array(':oauth_provider' => $data['oauth_provider']));?></h1>
        <div class="inputs">
            <input type="text" class="input" id="signup-full-name" name="signup[full_name]" value="<?= $data['name']; ?>" />
            <p class="help-block" data-role="error-message"></p>
            <input type="text" class="input" id="signup-username" name="signup[username]" value="<?= $data['username'] ?>" />
            <p class="help-block" data-role="error-message"></p>
            <input type="text" class="input" id="signup-email" name="signup[email]" value="<?= $data['email'] ?>" />
            <p class="help-block" data-role="error-message"></p>
            <input type="password" class="input" id="signup-password" name="signup[password]" value="" placeholder="<?= __('Password'); ?>" />
            <p class="help-block" data-role="error-message"></p>
            <input type="hidden" name="signup[oauth_secret]" value="<?= $data['oauth_secret']; ?>" />
        </div>
        <div class="buttons">
            <button class="btn btn-primary btn-big" type="submit" ><?= __('Sign Up'); ?></button>
        </div>
    </div>
</form>