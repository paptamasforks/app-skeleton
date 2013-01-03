<form id="auth-signup-form" autocomplete="off">
    <div class="auth-box signup">
        <h1><?= __('Sign up for');?><br/><strong>App name</strong></h1>
        <div class="inputs">
            <input type="text" class="input" id="signup-full-name" name="signup[full_name]" value="" placeholder="<?= __('Your full name'); ?>" />
            <p class="help-block" data-role="error-message"></p>
            <input type="text" class="input" id="signup-username" name="signup[username]" value="" placeholder="<?= __('Username'); ?>" />
            <p class="help-block" data-role="error-message"></p>
            <input type="text" class="input" id="signup-email" name="signup[email]" value="" placeholder="<?= __('Email'); ?>" />
            <p class="help-block" data-role="error-message"></p>
            <input type="password" class="input" id="signup-password" name="signup[password]" value="" placeholder="<?= __('Password'); ?>" />
            <p class="help-block" data-role="error-message"></p>
        </div>
        <div class="buttons">
            <button class="btn btn-primary btn-big" type="submit" ><?= __('Sign Up'); ?></button>
        </div>
    </div>
</form>