<div class="dbmovies-tvshow-content-generator">
    <button id="dbmovies-generator-epprepa" class="button button-primary"><?php _d('Get data'); ?></button>
    <button id="dbmovies-generator-episodes" class="button button-secundary" disabled><?php echo $sbtn; ?></button>
    <span id="dbmovies-json-response"></span>
    <span id="dbmovies-loader" class="spinner"></span>
    <input type="hidden" id="postparent" value="<?php echo $post->ID; ?>">
    <input type="hidden" id="tmdbsename" value="">
    <input type="hidden" id="tmdbepisos" value="">
    <input type="hidden" id="tmdbepisod" value="1">
</div>
<div class="dbmovies-progress-box">
    <div id="dbmovies-progress" class="progress"></div>
</div>
