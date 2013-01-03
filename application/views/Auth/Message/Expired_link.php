<form id="launchpad-message-form" autocomplete="off">
    <div class="auth-box message">
        <div class="message-text" align="center">
            <h3>This password recovery link is invalid or expired.</h3>
        </div>
        <div align="center">
            <a href="<?= Url::map('auth.login'); ?>">&laquo; <?= __('Back to Sign In'); ?></a>
        </div>
    </div>
</form>