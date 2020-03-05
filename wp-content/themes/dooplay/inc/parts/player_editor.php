<!-- Player editor Table -->
<table id="repeatable-fieldset-one" width="100%" class="dt_table_admin">
    <thead>
        <tr>
            <th>#</th>
            <th><?php _d('Title'); ?></th>
            <th><?php _d('Type'); ?></th>
            <th><?php _d('URL source or Shortcode'); ?></th>
            <th><?php _d('Flag Language'); ?></th>
            <th><?php _d('Control'); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php if($postmneta) : foreach ($postmneta as $field) { ?>
    <tr class="tritem">
        <td class="draggable"><span class="dashicons dashicons-move"></td>
        <td class="text_player"><input type="text" class="widefat" name="name[]" value="<?php if($field['name'] != '') echo esc_attr( $field['name'] ); ?>" required/></td>
        <td>
            <select name="select[]" style="width: 100%;">
            <?php foreach ($this->type_player() as $label => $value ) : ?>
            <option value="<?php echo $value; ?>"<?php selected( $field['select'], $value ); ?>><?php echo $label; ?></option>
            <?php endforeach; ?>
            </select>
        </td>
        <td>
            <input type="text" class="widefat" name="url[]" placeholder="" value="<?php if ($field['url'] != '') echo esc_attr( $field['url'] ); else echo ''; ?>" />
        </td>
        <td>
            <select name="idioma[]" style="width: 100%;">
            <?php foreach ($this->languages() as $label => $value ) : ?>
            <option value="<?php echo $value; ?>"<?php selected( $field['idioma'], $value ); ?>><?php echo $label; ?></option>
            <?php endforeach; ?>
            </select>
        </td>
        <td><a class="button remove-row" href="#"><?php _d('Remove'); ?></a></td>
    </tr>
    <?php } else : ?>
    <tr class="tritem">
        <td class="draggable"><span class="dashicons dashicons-move"></td>
        <td class="text_player"><input type="text" class="widefat" name="name[]" /></td>
        <td>
            <select name="select[]" style="width: 100%;">
            <?php foreach ($this->type_player() as $label => $value ) : ?>
            <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
            <?php endforeach; ?>
            </select>
        </td>
        <td>
            <input type="text" class="widefat" name="url[]" placeholder="" />
        </td>
        <td>
            <select name="idioma[]" style="width: 100%;">
            <?php foreach ($this->languages() as $label => $value ) : ?>
            <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
            <?php endforeach; ?>
            </select>
        </td>
        <td><a class="button remove-row" href="#"><?php _d('Remove'); ?></a></td>
    </tr>
    <?php endif; ?>
    <tr class="empty-row screen-reader-text tritem">
        <td class="draggable"><span class="dashicons dashicons-move"></td>
        <td class="text_player"><input type="text" class="widefat" name="name[]" /></td>
        <td>
            <select name="select[]" style="width: 100%;">
            <?php foreach ($this->type_player() as $label => $value ) : ?>
            <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
            <?php endforeach; ?>
            </select>
        </td>
        <td><input type="text" class="widefat" name="url[]" placeholder="" /></td>
        <td>
            <select name="idioma[]" style="width: 100%;">
            <?php foreach ($this->languages() as $label => $value ) : ?>
            <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
            <?php endforeach; ?>
            </select>
        </td>
        <td><a class="button remove-row" href="#"><?php _d('Remove'); ?></a></td>
    </tr>
    </tbody>
</table>

<!-- Link Add Row -->
<p class="repeater"><a id="add-row" class="add_row" href="#"><?php _d('Add new row'); ?></a></p>

<!-- JQuery -->
<script type="text/javascript">
    jQuery(document).ready(function( $ ){
        $('#add-row').on('click', function() {
            var row = $('.empty-row.screen-reader-text').clone(true);
            row.removeClass('empty-row screen-reader-text');
            row.insertBefore('#repeatable-fieldset-one tbody>tr:last');
            return false;
        });
        $('.remove-row').on('click', function() {
            $(this).parents('tr').remove();
            return false;
        });
        $('.dt_table_admin').sortable( {
            items: '.tritem',
            opacity: 0.8,
            cursor: 'move',
        } );
    });
</script>
