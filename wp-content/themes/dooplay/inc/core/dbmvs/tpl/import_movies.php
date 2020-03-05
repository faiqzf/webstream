<div id="dbmvoies-importer-html">
    <div class="dbmovies-quick-importer">
        <form id="dbmovies-importer">
            <div class="box">
                <span id="dbmovies-loader" class="spinner"></span>
                <input type="text" name="ptmdb" placeholder="<?php _d('Paste URL of IMDb or TMDb'); ?>" id="dbmovies-inp-tmdb" required>
                <input type="submit" value="<?php _d('Import'); ?>" class="button button-primary" id="dbmovies-btn-importer">
                <input type="hidden" value="movie" name="ptype">
                <input type="hidden" value="dbmovies_insert_tmdb" name="action">
            </div>
        </form>
    </div>
</div>
