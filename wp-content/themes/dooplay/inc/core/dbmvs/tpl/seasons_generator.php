<div class="dbmovies-tvshow-content-generator">
    <button id="dbmovies-generator-seprepa" class="button button-primary"><?php _d('Get data'); ?></button>
    <button id="dbmovies-generator-seasons" class="button button-secundary" disabled><?php echo $sbtn; ?></button>
    <span id="dbmovies-json-response"></span>
    <span id="dbmovies-loader" class="spinner"></span>
    <input type="hidden" id="postparent" value="<?php echo $post->ID; ?>">
    <input type="hidden" id="tmdbsename" value="">
    <input type="hidden" id="tmdbseasos" value="">
    <input type="hidden" id="tmdbseason" value="1">
</div>
<div class="dbmovies-progress-box">
    <div id="dbmovies-progress" class="progress"></div>
</div>
