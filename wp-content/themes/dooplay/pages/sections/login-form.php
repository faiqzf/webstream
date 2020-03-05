<form id="dooplay_login_user" method="post">
	<fieldset>
		<label for="log"><?php _d('Username'); ?></label>
		<input type="text" name="log" id="user_login" value="<?php echo isset($_POST['username']) ? $_POST['username'] : false; ?>" required/>
	</fieldset>
	<fieldset>
		<label for="pwd"><?php _d('Password'); ?></label>
		<input type="password" name="pwd" id="user_pass" value="<?php echo isset($_POST['password']) ? $_POST['password'] : false; ?>" required/>
	</fieldset>
	<fieldset>
		<label for="rememberme"><input name="rmb" type="checkbox" id="rememberme" value="forever" checked="checked" /> <?php _d('Stay logged in'); ?></label>
	</fieldset>
    <div id="jsonresponse"></div>
	<fieldset>
		<input type="submit" id="dooplay_login_btn" data-btntext="<?php _d('Log in'); ?>" class="submit button" value="<?php _d('Log in'); ?>" />
		<span><?php _d("Don't you have an account yet?"); ?> <a href="<?php echo doo_compose_pagelink('pageaccount') .'?action=sign-in'; ?>"><?php _d("Sign up here"); ?> </a></span>
		<span><a href="<?php echo esc_url( home_url() ); ?>/wp-login.php?action=lostpassword" target="_blank"><?php _d("I forgot my password"); ?></a></span>
	</fieldset>
    <input type="hidden" name="action" value="dooplay_login">
	<input type="hidden" name="red" value="<?php echo doo_compose_pagelink('pageaccount'); ?>">
</form>
