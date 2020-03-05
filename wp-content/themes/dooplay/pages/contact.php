<?php
/*
Template Name: DT - Contact page
*/
get_header();
// Captcha

$action = doo_isset($_GET,'action');
$send   = doo_isset($_POST,'send');
if($action == 'send' && $send == 'true') {
    $nonce = doo_isset($_POST,'send-contact-nonce');
    $admin = get_option('admin_email');
    if(wp_verify_nonce($nonce,'send-contact')) {
        // datos del formulario
        $asunto  = $_POST['asunto'];
        $mensaje = $_POST['mensaje'];
        $email   = $_POST['email'];
        $name    = $_POST['dtname'];
        $link    = $_POST['dtpermalink'];
        $headers = array('Content-Type: text/html; charset=UTF-8','From: '.$name.' <'.$email.'>');
        $body = '
            <strong>'.$name.'</strong> ['.$email.']<br><br>
            -----------------------------------<br><br>
            '.$mensaje.'<br><br>
            -----------------------------------<br><br>
            '.$link.'<br><br>
            '. __d('Contact form') .'
        ';
        wp_mail( $admin, $asunto , $body, $headers );
        $status = 'csend';
        $data_mensaje = __d('Message sent, at any time one of our operators will contact you.');
    } // end verify_nonce
}
?>
<div class="contact">
	<div class="wrapper">
		<h1><?php _d('Contact Form'); ?></h1>
		<p class="descrip"><?php _d('Have something to notify our support team, please do not hesitate to use this form.'); ?></p>
	</div>
	<div class="wrapper">
	<?php if($action == 'send'):
		echo '<div class="mensaje_ot '.$status.'">';
		echo $data_mensaje;
		echo '</div>';
	endif; ?>
		<form class="contactame" method="post" action="<?php echo doo_compose_pagelink('pagecontact'); ?>?action=send">
			<fieldset class="nine">
				<label><?php _d('Name'); ?></label>
				<input type="text" name="dtname" required>
			</fieldset>
			<fieldset class="nine fix">
				<label><?php _d('Email'); ?></label>
				<input type="text" name="email" required>
			</fieldset>
			<fieldset>
				<label><?php _d('Subject'); ?></label>
				<p><?php _d('How can we help?'); ?></p>
				<input type="text" name="asunto" required>
			</fieldset>
			<fieldset>
				<label><?php _d('Your message'); ?></label>
				<p><?php _d('The more descriptive you can be the better we can help.'); ?></p>
				<textarea name="mensaje" rows="5" cols="" required></textarea>
			</fieldset>
			<fieldset>
				<label><?php _d('Link Reference (optional)'); ?></label>
				<input type="text" name="dtpermalink">
			</fieldset>
			<fieldset>
				<input type="submit" value="<?php _d('Send message'); ?>">
			</fieldset>
			<input type="hidden" name="send" value="true">
			<?php wp_nonce_field('send-contact', 'send-contact-nonce') ?>
		</form>
	</div>
</div>
<?php get_footer(); ?>
