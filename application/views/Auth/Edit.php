<form id="auth-edit-form" autocomplete="off">
    <div class="auth-box signup">
        <h1><strong><?= __('Edit your profile');?></strong></h1>
        <div class="inputs">
            <label><?= __('Your full name'); ?></label>
            <input type="text" class="input" id="edit-full-name" name="edit[full_name]" value="<?= $user_data['full_name']; ?>" />
            <p class="help-block" data-role="error-message"></p>

            <label><?= __('Username'); ?></label>
            <input type="text" class="input" id="edit-username" name="edit[username]" value="<?= $user_data['username']; ?>" />
            <p class="help-block" data-role="error-message"></p>

            <label><?= __('Email'); ?></label>
            <input type="text" class="input" id="edit-email" name="edit[email]" value="<?= $user_data['email']; ?>" />
            <p class="help-block" data-role="error-message"></p>

            <label><?= __('Password'); ?></label>
            <input type="password" class="input" id="edit-password" name="edit[password]" value="" />
            <p class="help-block" data-role="error-message"></p>

            <label><?= __('Password confirm'); ?></label>
            <input type="password" class="input" id="edit-password-confirm" name="edit[password_confirm]" value="" />
            <p class="help-block" data-role="error-message"></p>
        </div>
        <div class="buttons">
            <button class="btn btn-primary btn-big" type="submit" ><?= __('Update your profile'); ?></button>
        </div>
    </div>
</form>