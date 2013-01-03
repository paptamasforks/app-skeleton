<?php
    $session = Session::instance();
    $errors = $session->get_once('auth.form.errors');
    $post_data = $session->get_once('auth.form.data', array());
?>
<div class="auth-container">
    <form id="auth-login-form" action="<?= Url::map('service.auth.login') ?>" method="post"<?= ($errors) ? " data-errors='".json_encode($errors)."'" : ''; ?>>
        <div id="login"></div>
        <div class="auth-box login">
            <h1><?= __('Sign in to');?><br/><strong>App name</strong></h1>
            <div class="inputs">
                <input type="text" class="input" id="login-username" name="login[username]" value="<?= Arr::get($post_data, 'username', ''); ?>" placeholder="<?= __('Username or email'); ?>" />
                <p class="help-block" data-role="error-message"></p>
                <input type="password" class="input" id="login-password" name="login[password]" value="<?= Arr::get($post_data, 'password', ''); ?>" placeholder="<?= __('Password'); ?>" />
                <p class="help-block" data-role="error-message"></p>
                <?php if (isset($_GET['next'])): ?>
                <input type="hidden" name="login[next]" value="<?= $_GET['next']; ?>" />
                <?php endif; ?>
            </div>
            <div class="utils">
                <div class="forgot-password">
                    <a href="<?= Url::map('auth.recover'); ?>"><?= __('I forgot my password'); ?></a>
                </div>
                <div class="remember-me">
                    <label class="checkbox inline">
                        <input type="checkbox" name="login[remember-me]" value="on" /> <?= __('Remember me'); ?></label>
                    </label>
                </div>
            </div>
            <div class="buttons">
                <button class="btn btn-primary btn-big" type="submit" ><?= __('Sign in'); ?></button>
            </div>
        </div>
    </form>
</div>