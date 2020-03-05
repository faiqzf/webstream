<div id="report-video" class="report-video-form">
	<div class="fixform">
		<div class="title"><?php _d('what going on?'); ?></div>
		<div id="msg"></div>
		<form id="post_report" class="reportar_form">
			<fieldset>
				<textarea name="mensaje" rows="4" placeholder="<?php _d('What is the problem? Please explain..'); ?>" required></textarea>
			</fieldset>
			<fieldset>
				<input type="email" name="reportmail" placeholder="<?php _d('Email address'); ?>" required />
				<label><?php _d('Your email is only visible to moderators'); ?></label>
			</fieldset>
			<fieldset>
				<input type="submit" value="<?php _d('Send report'); ?>">
			</fieldset>
			<input type="hidden" name="idpost" value="<?php the_id(); ?>">
            <input type="hidden" name="action" value="reports_ajax">
			<?php wp_nonce_field('send-report','send-report-nonce') ?>
		</form>
	</div>
</div>
