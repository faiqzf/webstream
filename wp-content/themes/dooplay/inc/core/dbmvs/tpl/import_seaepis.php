<div id="dbmvs_seaepi_generator" class="dbmvs_modal fadein">
    <div class="dbmvs_modal_box jump">
        <form id="dbmvseaepigenerator">
            <input type="hidden" id="dbmvgseitem" name="item" value="1">
            <input type="hidden" id="dbmvgsetotl" name="totl" value="">
            <input type="hidden" id="dbmvgsetmdb" name="tmdb" value="">
            <input type="hidden" id="dbmvgsepare" name="pare" value="">
            <input type="hidden" id="dbmvgsetype" name="type" value="">
            <input type="hidden" id="dbmvgsename" name="name" value="">
            <input type="hidden" id="dbmvgseseas" name="seas" value="">
            <input type="hidden" name="action" value="dbmovies_generate_te">
            <div id="dbmvseaepico" class="left loading"></div>
            <div class="right">
                <input type="submit" id="dbmvseaepbtn" class="button button-primary" value="<?php _d('Import'); ?>" disabled>
                <a href="#" id="dbmvseaepbtncl" class="button hidden"><?php _d('Cancel'); ?></a>
                <span id="dbmvseaeptxt" class="text"><?php _d('Loading..'); ?></span>
                <div id="dbmvseaeprgrs" class="progress">
                    <span></span>
                </div>
            </div>
        </form>
    </div>
</div>
