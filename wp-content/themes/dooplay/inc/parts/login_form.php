<div class="login_box">
    <div class="box">
        <a id="c_loginbox"><i class="icon-close2"></i></a>
        <h3><?php _d('Login to your account'); ?></h3>
        <form method="post" id="dooplay_login_user">
            <fieldset class="user"><input type="text" name="log" placeholder="<?php _d('Username'); ?>"></fieldset>
            <fieldset class="password"><input type="password" name="pwd" placeholder="<?php _d('Password'); ?>"></fieldset>
            <label><input name="rmb" type="checkbox" id="rememberme" value="forever" checked> <?php _d('Remember Me'); ?></label>
            <fieldset class="submit"><input id="dooplay_login_btn" data-btntext="<?php _d('Log in'); ?>" type="submit" value="<?php _d('Log in'); ?>"></fieldset>
            <a class="register" href="<?php echo $register; ?>"><?php _d('Register a new account'); ?></a>
            <label><a class="pteks" href="<?php echo $lostpassword; ?>"><?php _d('Lost your password?'); ?></a></label>
            <input type="hidden" name="red" value="<?php echo $redirect; ?>">
            <input type="hidden" name="action" value="dooplay_login">
        </form>
    </div>
</div>
