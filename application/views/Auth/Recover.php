<form id="auth-recovery-form" autocomplete="off">
    <div class="auth-box recover">
        <h1>
            <strong><?= __('Forgot your password?'); ?></strong>
        </h1>
        <p class="subheading"><?= __('Enter your email address below and we will send you instructions on how to reset it.'); ?></p>
        <div class="inputs">
            <input type="text" class="input" id="recover-email" name="recover[email]" value="" placeholder="<?= __('Your email'); ?>" />
            <p class="help-block" data-role="error-message"></p>
        </div>
        <div class="buttons">
            <button class="btn btn-primary" type="submit"><?= __('Recover password'); ?></button>
        </div>
        <div><a href="<?= Url::map('auth.login'); ?>"><?= __('Cancel'); ?></a></div>
    </div>
</form>