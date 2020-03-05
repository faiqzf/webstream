<div id="dbmovies-dbmvs-application" class="dbmovies-app">
    <!-- Header data -->
    <header class="dbmvsapp">
        <!-- Type content Selector -->
        <nav class="left" id="dbmovies-types">
            <ul>
                <li><h3>Dbmvs</h3></li>
                <li><a href="#" class="dbmvs-tab-content button button-primary" data-type="movie"><?php _d('Movies'); ?></a></li>
                <li><a href="#" class="dbmvs-tab-content button" data-type="tv"><?php _d('TVShows'); ?></a></li>
                <li class="dbmvs-results-screem"><?php _d('Results'); ?> <strong id="dbmvs-results-number">0</strong></li>
            </ul>
        </nav>

        <!-- Api Settings and responser-->
        <nav class="right" id="dbmovies-settings">
            <ul>
                <li class="dbmvs-credits" style="display:none">
                    <strong><?php _d('Credits'); ?>:</strong> <span id="dbmvs-credits">0</span>
                    <a href="https://dbmvs.ml/" target="_blank" class="dbmvs-update"><i class="dashicons dashicons-plus-alt"></i></a>
                </li>
                <li>
                    <a href="<?php echo admin_url('admin.php?page=dbmvs-settings'); ?>" class="dbmvs-settings"><i class="dashicons dashicons-admin-generic"></i></a>
                </li>
                <li id="dbmovies-li-imdb">
                    <span class="spinner is-active"></span>
                    <span class="percentage">0.0%</span>
                    <a href="#" id="dbmvs-imdb"><b><?php _d('IMDb Updater'); ?></b></a>
                </li>
            </ul>
        </nav>
        <input id="dbmovies-imdb-updater-page" value="<?php echo self::UpdateIMDbSett(); ?>" type="hidden">
    </header>

    <!-- Forms -->
    <div id="dbmvs-forms-response" class="forms">
        <!-- Filter content for Year -->
        <form id="dbmovies-form-filter">
            <fieldset>
                <a class="button dbmovies-log-collapse" href="#"><?php _d('Expand'); ?></a>
            </fieldset>
            <fieldset>
                <input type="number" id="dbmvs-year" min="1900" max="<?php echo date('Y')+1; ?>" name="year" value="<?php echo rand('1950', date('Y')); ?>" placeholder="<?php _d('Year'); ?>">
            </fieldset>
            <fieldset>
                <input type="number" id="dbmvs-page" min="1" name="page" value="1" placeholder="<?php _d('Page'); ?>">
            </fieldset>
            <fieldset>
                <select id="dbmvs-popularity" name="popu">
                    <option value="popularity.desc"><?php _d('Popularity desc'); ?></option>
                    <option value="popularity.asc"><?php _d('Popularity asc'); ?></option>
                </select>
            </fieldset>
            <fieldset id="genres-box-movie" class="genres on">
                <select id="dbmvs-movies-genres" name="genres-movie">
                    <?php echo $this->GenresMovies(); ?>
                </select>
            </fieldset>
            <fieldset id="genres-box-tv" class="genres">
                <select id="dbmvs-tvshows-genres" name="genres-tv">
                    <?php echo $this->GenresTVShows(); ?>
                </select>
            </fieldset>
            <fieldset>
                <input type="submit" id="dbmvs-btn-filter" class="button" value="<?php _d('Filter'); ?>">
                <input type="hidden" value="dbmovies_app_filter" name="action">
                <input type="hidden" id="dbmvs-filter-type" name="type" value="movie">
            </fieldset>
            <fieldset id="bulk-importer-click">
                <a href="#" id="bulk-importer" class="button button-primary"><?php _d('Bulk import'); ?></a>
            </fieldset>
        </form>


        <!-- Search content for string -->
        <form id="dbmovies-form-search" class="right">
            <fieldset>
                <input type="text" id="dbmvs-search-term" name="searchterm" placeholder="<?php _d('Search..'); ?>">
            </fieldset>
            <fieldset>
                <input type="submit" id="dbmvs-btn-search" class="button" value="<?php _d('Search'); ?>">
                <input type="hidden" id="dbmvs-search-page" name="searchpage" value="1">
                <input type="hidden" id="dbmvs-search-type" name="searchtype" value="movie">
                <input type="hidden" value="dbmovies_app_search" name="action">
            </fieldset>
        </form>
    </div>

    <!-- Progress Bar -->
    <div class="dbmvs-progress-bar">
        <div class="progressing"></div>
    </div>

    <!-- Response Log -->
    <div class="dbmovies-logs">
        <div id="dbmovies-logs-box" class="box">
            <ul>
                <i id="dbmvs-log-indicator"></i>
            </ul>
        </div>
    </div>

    <!-- Json Response -->
    <div class="wrapp">
        <div class="content">
            <input type="hidden" id="current-year">
            <input type="hidden" id="current-page">
            <input type="hidden" id="dtotal-items">
            <div id="dbmovies-response-box" class="items">
                <i id="response-dbmovies"></i>
            </div>
            <div class="paginator">
                <div id="dbmovies-loadmore-spinner"></div>
                <a href="#" id="dbmovies-loadmore" class="button dbmvsloadmore"><?php _d('Load More'); ?></a>
            </div>
        </div>
    </div>
</div>

<!-- Go Top -->
<a id="dbmovies-back-top" href="#" class="button button-secundary"><i class="dashicons dashicons-arrow-up-alt2"></i></a>
