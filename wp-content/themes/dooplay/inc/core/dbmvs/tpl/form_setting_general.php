<h2><?php _d('Authorize Application'); ?></h2>
<p><?php _d('For this application to function correctly add the required API credentials'); ?></p>
<table class="form-table dbmv">
    <tbody>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="dbmv-input-dbmovies"><?php _d('API Key for Dbmovies'); ?></label>
            </th>
            <td class="<?php echo $this->DBMVStatus(); ?>">
                <?php $this->field_text('dbmovies', false, __d('Your API key will give you access to all our services')); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="dbmv-input-themoviedb"><?php _d('API Key for Themoviedb'); ?></label>
            </th>
            <td class="<?php echo $this->TMDbStatus(); ?>">
                <?php $this->field_text('themoviedb', false, __d('Add your API key to be able to generate data with our importers')); ?>
            </td>
        </tr>
    </tbody>
</table>
<h2><?php _d('Import settings'); ?></h2>
<p><?php _d('Set the settings of your preference for data import'); ?></p>
<table class="form-table dbmv">
    <tbody>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="select-language"><?php _d('Set Language'); ?></label>
            </th>
            <td>
                <?php $this->field_select('language', self::Languages(), 'en-US'); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <?php _d('App capabilities'); ?>
            </th>
            <td>
                <?php $this->field_checkbox('upload', __d('Upload poster image to server')); ?>
                <?php $this->field_checkbox('genres', __d('Do you want to autocomplete genres')); ?>
                <?php $this->field_checkbox('release', __d('Publish content with the release date')); ?>
                <?php $this->field_checkbox('autoscroll', __d('Activate Auto scroll for results')); ?>
                <?php $this->field_checkbox('nospostimp', __d('Do not import data until after publishing')); ?>
                <?php $this->field_checkbox('repeated', __d('Allow repeated content')); ?>
                <?php $this->field_checkbox('safemode', __d('Massively import safely')); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="dbmv-input-autoscrollresults"><?php _d('Auto Scroll Results limits'); ?></label>
            </th>
            <td>
                <?php $this->field_number('autoscrollresults', '200', __d('Set the maximum number of results that can be obtained with the Infinite Scroll')); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="dbmv-input-delaytime"><?php _d('Delay time'); ?></label>
            </th>
            <td>
                <?php $this->field_number('delaytime', '500', __d('Time in milliseconds to execute the next importation')); ?>
            </td>
        </tr>
    </tbody>
</table>
