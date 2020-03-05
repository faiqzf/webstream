<div class="form_edit">
    <div class="cerrar">
        <a id="cerrar_form_edit_link">
            <i class="icon-close"></i>
        </a>
    </div>
    <form id="doo_link_front_editor">
        <fieldset>
            <h3><?php _d('Edit Link'); ?></h3>
        </fieldset>
        <fieldset>
            <select name="type">
            <?php foreach( $this->types() as $type ) { echo '<option '.selected( get_post_meta($post_id, '_dool_type', true), $type, false).'>'.$type.'</option>'; } ?>
            </select>
        </fieldset>

        <fieldset>
            <input name="murl" type="text" value="<?php echo get_post_meta( $post_id, '_dool_url', true ); ?>">
        </fieldset>

        <fieldset>
            <select name="lang">
            <?php foreach( $this->langs() as $lang ) { echo '<option '.selected( get_post_meta($post_id, '_dool_lang', true), $lang, false).'>'.$lang.'</option>'; } ?>
            </select>
        </fieldset>
        <fieldset>
            <select name="qual">
            <?php foreach( $this->resolutions() as $resolution ) { echo '<option '.selected( get_post_meta($post_id, '_dool_quality', true), $resolution, false).'>'.$resolution.'</option>'; } ?>
            </select>
        </fieldset>
        <fieldset>
            <input type="text" name="size" id="size" value="<?php echo get_post_meta( $post_id, '_dool_size', true ); ?>" placeholder="<?php _d('File size (optional)'); ?>">
        </fieldset>
        <fieldset>
            <input type="submit" value="<?php _d('Save data'); ?>">
            <input type="hidden" id="ptid" name="ptid" value="<?php echo $post_id; ?>">
            <input type="hidden" id="nonc" name="nonc" value="<?php echo wp_create_nonce('doolinksaveformeditor_'.$post_id); ?>">
            <input type="hidden" name="action" value="doosaveformeditor_user">
        </fieldset>
    </form>
</div>
