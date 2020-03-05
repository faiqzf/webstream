<div class="dooplay_links">
    <div class="dform">
        <fieldset>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <select id='dooplay_lfield_type' name='dooplay_lfield_type'>
                                <?php foreach( $this->types() as $type) { echo "<option>{$type}</option>"; } ?>
                            </select>
                        </td>
                        <td>
                            <select id='dooplay_lfield_lang' name='dooplay_lfield_lang'>
                                <?php foreach( $this->langs() as $type) { echo "<option>{$type}</option>"; } ?>
                            </select>
                        </td>
                        <td>
                            <select id='dooplay_lfield_qual' name='dooplay_lfield_qual'>
                                <?php foreach( $this->resolutions() as $type) { echo "<option>{$type}</option>"; } ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" id="dooplay_lfield_size" name="dooplay_lfield_size" placeholder="<?php _d('File size'); ?>"/>
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
        <fieldset>
            <textarea id="dooplay_lfield_urls" name="dooplay_lfield_urls" rows="3" placeholder="<?php _d('Add a link per line'); ?>"></textarea>
        </fieldset>
        <fieldset>
            <a href="#" id="dooplay_anchor_hideform" class="button button-decundary"><?php _d('Cancel'); ?></a>
            <a href="#" id="dooplay_anchor_postlinks" class="button button-primary right"><?php _d('Add Links'); ?></a>
        </fieldset>
    </div>
    <div class="dpre">
        <a href="#" id="dooplay_anchor_showform" class="button button-primary"><?php _d('Add Links'); ?></a>
        <a href="#" id="dooplay_anchor_reloadllist" class="button button-secundary right" data-id="<?php echo $post->ID; ?>"><?php _d('Reload List'); ?></a>
    </div>
    <table>
        <thead>
            <tr>
                <th><?php _d('Type'); ?></th>
                <th><?php _d('Server'); ?></th>
                <th><?php _d('Language'); ?></th>
                <th><?php _d('Quality'); ?></th>
                <th><?php _d('Size'); ?></th>
                <th><?php _d('Clicks'); ?></th>
                <th><?php _d('User'); ?></th>
                <th><?php _d('Added'); ?></th>
                <th><?php _d('Manage'); ?></th>
            </tr>
        </thead>
        <tbody id="doolinks_response">
            <?php $this->tablelist_admin($post->ID); ?>
        </tbody>
    </table>
</div>
