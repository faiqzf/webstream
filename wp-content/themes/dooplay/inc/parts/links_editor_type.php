<table class="options-table-responsive dt-options-table">
    <tbody>
        <tr id="parent_row">
            <td class="label">
                <label><?php _d('Parent'); ?></label>
            </td>
            <td class="field">
                <a href="<?php echo admin_url('post.php?post='.wp_get_post_parent_id($post->ID).'&action=edit'); ?>"><strong><?php echo get_the_title( wp_get_post_parent_id($post->ID) ); ?></strong></a>
            </td>
        </tr>
        <tr id="dool_type_row">
            <td class="label">
                <label><?php _d('Type'); ?></label>
            </td>
            <td class="field">
                <select name="_dool_type" id="dool_type">
                    <?php foreach( $this->types() as $type ) { echo '<option '.selected( get_post_meta($post->ID, $this->metatype, true), $type, false).'>'.$type.'</option>'; } ?>
                </select>
            </td>
        </tr>
        <tr id="dool_url_row">
            <td class="label">
                <label><?php _d('URL Link'); ?></label>
            </td>
            <td class="field">
                <input class="regular-text" type="text" name="_dool_url" id="dool_url" value="<?php echo get_post_meta($post->ID, $this->metaurl, true); ?>">
            </td>
        </tr>
        <tr id="dool_size_row">
            <td class="label">
                <label><?php _d('File size'); ?></label>
            </td>
            <td class="field">
                <input class="regular-text" type="text" name="_dool_size" id="dool_size" value="<?php echo get_post_meta($post->ID, $this->metasize, true); ?>">
            </td>
        </tr>
        <tr id="dool_lang_row">
            <td class="label">
                <label><?php _d('Language'); ?></label>
            </td>
            <td class="field">
                <select name="_dool_lang" id="dool_lang">
                    <?php foreach( $this->langs() as $lang ) { echo '<option '.selected( get_post_meta($post->ID, $this->metalang, true), $lang, false).'>'.$lang.'</option>'; } ?>
                </select>
            </td>
        </tr>
        <tr id="dool_quality_row">
            <td class="label">
                <label><?php _d('Quality'); ?></label>
            </td>
            <td class="field">
                <select name="_dool_quality" id="dool_quality">
                    <?php foreach( $this->resolutions() as $resolution ) { echo '<option '.selected( get_post_meta($post->ID, $this->metaquality, true), $resolution, false).'>'.$resolution.'</option>'; } ?>
                </select>
            </td>
        </tr>
    </tbody>
</table>
