<form id="auth-reset-form" autocomplete="off">
    <div class="auth-box reset">
        <h1><?= __('Reset your password for');?><br/><strong>App name</strong></h1>
        <div class="inputs">
            <input type="password" class="input" id="reset-password" name="reset[password]" value="" placeholder="<?= __('New password'); ?>" />
            <p class="help-block" data-role="error-message"></p>
            <input type="password" class="input" id="reset-password-confirm" name="reset[password_confirm]" value="" placeholder="<?= __('New password again'); ?>" />
            <p class="help-block" data-role="error-message"></p>
        </div>
        <div class="buttons">
            <button class="btn btn-primary" type="submit"><?= __('Reset password'); ?></button>
        </div>
        <div><a href="<?= Url::map('auth.login'); ?>"><?= __('Cancel'); ?></a></div>
    </div>
</form>