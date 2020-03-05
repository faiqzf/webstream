<h2><?php _d('Customize titles'); ?></h2>
<p><?php _d('Configure the titles that are generated in importers'); ?></p>
<table class="form-table dbmv">
    <tbody>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="dbmv-input-titlemovies"><?php _d('Movies'); ?></label>
            </th>
            <td>
                <?php $this->field_text('titlemovies'); ?>
                <p><strong><?php _d('Usable tags'); ?>:</strong> <code>{name}</code> <code>{year}</code></p>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="dbmv-input-titletvshows"><?php _d('TVShows'); ?></label>
            </th>
            <td>
                <?php $this->field_text('titletvshows'); ?>
                <p><strong><?php _d('Usable tags'); ?>:</strong> <code>{name}</code> <code>{year}</code></p>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="dbmv-input-titleseasons"><?php _d('Seasons'); ?></label>
            </th>
            <td>
                <?php $this->field_text('titleseasons'); ?>
                <p><strong><?php _d('Usable tags'); ?>:</strong> <code>{name}</code> <code>{season}</code></p>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="dbmv-input-titlepisodes"><?php _d('Episodes'); ?></label>
            </th>
            <td>
                <?php $this->field_text('titlepisodes'); ?>
                <p><strong><?php _d('Usable tags'); ?>:</strong> <code>{name}</code> <code>{season}</code> <code>{episode}</code></p>
            </td>
        </tr>
    </tbody>
</table>
