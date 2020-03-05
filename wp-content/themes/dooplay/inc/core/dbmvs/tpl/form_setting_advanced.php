<h2><?php _d('PHP Limits'); ?></h2>
<p><?php _d('These adjustments will only be established for the functions of Dbmovies'); ?></p>
<table class="form-table dbmv">
    <tbody>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="dbmv-input-phptimelimit"><?php _d('Set time limit'); ?></label>
            </th>
            <td>
                <?php $this->field_number('phptimelimit','300', __d('Help extend the execution time')); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="dbmv-input-phpmemorylimit"><?php _d('Set memory limit'); ?></label>
            </th>
            <td>
                <?php $this->field_number('phpmemorylimit','256'); ?>
            </td>
        </tr>
    </tbody>
</table>
<h2><?php _d('Seasons and Episodes Order'); ?></h2>
<p><?php _d('Set order in which you want to display the lists of these contents'); ?></p>
<table class="form-table dbmv">
    <tbody>
        <tr valign="top">
            <th scope="row" class="titledesc"><?php _d('Order Seasons'); ?></th>
            <td>
                <?php $this->field_radio('orderseasons', self::PostOrder(),'ASC'); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc"><?php _d('Order Episodes'); ?></th>
            <td>
                <?php $this->field_radio('orderepisodes', self::PostOrder(),'ASC'); ?>
            </td>
        </tr>
    </tbody>
</table>
<h2><?php _d('Importers Post Status'); ?></h2>
<p><?php _d('Define Post Status after using the importers'); ?></p>
<table class="form-table dbmv">
    <tbody>
        <tr valign="top">
            <th scope="row" class="titledesc"><?php _d('Movies Importer'); ?></th>
            <td>
                <?php $this->field_radio('pstatusmovies', self::PostStatus(),'publish'); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc"><?php _d('TVShows Importer'); ?></th>
            <td>
                <?php $this->field_radio('pstatustvshows', self::PostStatus(),'publish'); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc"><?php _d('Seasons Importer'); ?></th>
            <td>
                <?php $this->field_radio('pstatusseasons', self::PostStatus(),'publish'); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc"><?php _d('Episodes Importer'); ?></th>
            <td>
                <?php $this->field_radio('pstatusepisodes', self::PostStatus(),'publish'); ?>
            </td>
        </tr>
    </tbody>
</table>
