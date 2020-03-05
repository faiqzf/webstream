<form method="POST" id="dooplay_sign_up" class="register_form">
	<fieldset>
		<label for="user_name"><?php _d('Username'); ?></label>
		<input type="text" placeholder="JohnDoe" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : false; ?>" required />
	</fieldset>
	<fieldset>
		<label for="email"><?php _d('E-mail address'); ?></label>
		<input type="text" placeholder="johndoe@email.com" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : false; ?>" required />
	</fieldset>
	<fieldset>
		<label for="spassword"><?php _d('Password'); ?></label>
		<input type="password" id="spassword" name="spassword" required />
		<div class="passwordbox"><div id="passwordStrengthDiv" class="is0"></div></div>
	</fieldset>
	<fieldset class="min fix">
		<label for="dt_name"><?php _d('Name'); ?></label>
		<input type="text" placeholder="John" id="firstname" name="firstname" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : false; ?>" required />
	</fieldset>
	<fieldset class="min">
		<label for="dt_last_name"><?php _d('Last name'); ?></label>
		<input type="text" placeholder="Doe" id="lastname" name="lastname" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : false; ?>" required />
	</fieldset>
	<?php if(cs_get_option('gcaptchasitekey') && cs_get_option('gcaptchasecret')){ ?>
	<fieldset>
		<div class="g-recaptcha" data-sitekey="<?php echo cs_get_option('gcaptchasitekey'); ?>"></div>
	</fieldset>
	<?php } ?>
    <div id="jsonresponse"></div>
	<fieldset>
		<input name="adduser" type="submit" id="dooplay_signup_btn" class="submit button" data-btntext="<?php _d('Sign up'); ?>" value="<?php _d('Sign up'); ?>" />
		<span><?php _d('Do you already have an account?'); ?> <a href="<?php echo doo_compose_pagelink('pageaccount'); ?>?action=log-in"><?php _d('Login here'); ?></a></span>
	</fieldset>
	<input name="action" type="hidden" id="action" value="dooplay_register"/>
</form>
