<h2><?php _d('User Requests'); ?></h2>
<p><?php _d('For this application to function correctly add the required API credentials'); ?></p>
<table class="form-table dbmv">
    <tbody>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="dbmv-input-request-email"><?php _d('Email'); ?></label>
            </th>
            <td>
                <?php $this->field_text('request-email', false, __d('Establish an email where you want to be notified of new requests')); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <?php _d('Unknown user'); ?>
            </th>
            <td>
                <?php $this->field_checkbox('requestsunk', __d('Unknown users can publish requests?')); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <?php _d('Auto publish'); ?>
            </th>
            <td>
                <?php $this->field_checkbox('reqauto-adm', __d('Administrator')); ?>
                <?php $this->field_checkbox('reqauto-edi', __d('Editor')); ?>
                <?php $this->field_checkbox('reqauto-aut', __d('Author')); ?>
                <?php $this->field_checkbox('reqauto-con', __d('Contributor')); ?>
                <?php $this->field_checkbox('reqauto-sub', __d('Subscriber')); ?>
                <?php $this->field_checkbox('reqauto-unk', __d('Unknown user')); ?>
                <p><?php _d('Mark user roles that do not require content moderation'); ?></p>
            </td>
        </tr>
    </tbody>
</table>
