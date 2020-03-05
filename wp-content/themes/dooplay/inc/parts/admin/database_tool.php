<div class="wrap dooplaydb">
    <h1><?php _d('Database tool for DooPlay'); ?></h1>
    <h2><?php _d('Caution, any process that runs from this tool is irreversible'); ?></h2>
    <p><?php _d('Before proceeding with any action that you wish to execute from this tool, we recommend making a backup of your database, all elimination processes are irreversible.'); ?></p>


    <div class="metabox-holder">

        <?php if(!$newlink){ ?>
        <div id="doolinkmod" class="postbox required">
            <h3><span><?php _d('Update Links Module'); ?></span></h3>
            <div class="inside">
                <p><?php _d('This new version require that you update the content for the links module, the process is safe'); ?></p>
                <form id="doolinkmod_form">
                    <input id="doolinkmod_submit" type="submit" class="button button-primary" value="<?php _d('Update module'); ?>">
                    <input id="doolinkmod_step" name="step" type="hidden" value="1">
                    <input id="doolinkmod_run" name="run" type="hidden" value="assume">
                    <input id="doolinkmod_action" name="action" type="hidden" value="dooupdate_linksdb">
                </form>
            </div>
            <div class="response">
                <span class="spinner is-active"></span>
                <div class="doo-progress">
                    <div style="width:0%;"></div>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if($lkey AND !$lstatus) { ?>
        <div id="doobox_forcelicense" class="postbox required">
            <h3><span><?php _d('Force license activation'); ?></span></h3>
            <div class="inside">
                <p><?php _d('This measure is required when your server does not complete the connection with our repository.'); ?></p>
                <hr>
                <p>
                    <a href="#" data-run='forcelicense' class="button button-primary doodatabasetool"><?php _d('Activate license'); ?></a>
                    <span id="doodatabasetool_forcelicense" class="agotime"><?php echo ($timerun['forcelicense']) ? human_time_diff($timerun['forcelicense'], current_time('timestamp')) : $never; ?></span>
                </p>
            </div>
        </div>
        <?php } ?>

        <div id="doobox_license" class="postbox">
            <h3><span><?php _d('Reset license'); ?></span></h3>
            <div class="inside">
                <p><?php _d('Delete all the data that your license has registered in your database.'); ?></p>
                <hr>
                <p>
                    <a href="#" data-run='license' class="button button-primary doodatabasetool"><?php _d('Run process'); ?></a>
                    <span id="doodatabasetool_license" class="agotime"><?php echo isset($timerun['license']) ? human_time_diff($timerun['license'], current_time('timestamp')) : $never; ?></span>
                </p>
            </div>
        </div>
        <div id="doobox_transients" class="postbox">
            <h3><span><?php _d('Clear Transient options'); ?></span></h3>
            <div class="inside">
                <p><?php _d('Removing transient options can help solve some system problems.'); ?></p>
                <hr>
                <p>
                    <a href="#" data-run='transients' class="button button-primary doodatabasetool"><?php _d('Run process'); ?></a>
                    <span id="doodatabasetool_transients" class="agotime"><?php echo isset($timerun['transients']) ? human_time_diff($timerun['transients'], current_time('timestamp')) : $never; ?></span>
                </p>
            </div>
        </div>
        <div id="doobox_userfavorites" class="postbox">
            <h3><span><?php _d('Reset User favorites'); ?></span></h3>
            <div class="inside">
                <p><?php _d('Reset the list of favorites of all your users.'); ?></p>
                <hr>
                <p>
                    <a href="#" data-run='userfavorites' class="button button-primary doodatabasetool"><?php _d('Run process'); ?></a>
                    <span id="doodatabasetool_userfavorites" class="agotime"><?php echo isset($timerun['userfavorites']) ? human_time_diff($timerun['userfavorites'], current_time('timestamp')) : $never; ?></span>
                </p>
            </div>
        </div>
        <div id="doobox_userviews" class="postbox">
            <h3><span><?php _d('Reset User views'); ?></span></h3>
            <div class="inside">
                <p><?php _d('Restore the list of views of all your users.'); ?></p>
                <hr>
                <p>
                    <a href="#" data-run='userviews' class="button button-primary doodatabasetool"><?php _d('Run process'); ?></a>
                    <span id="doodatabasetool_userviews" class="agotime"><?php echo isset($timerun['userviews']) ? human_time_diff($timerun['userviews'], current_time('timestamp')) : $never; ?></span>
                </p>
            </div>
        </div>
        <div id="doobox_reports" class="postbox">
            <h3><span><?php _d('Reset User reports'); ?></span></h3>
            <div class="inside">
                <p><?php _d('Remove all user reports'); ?></p>
                <hr>
                <p>
                    <a href="#" data-run='reports' class="button button-primary doodatabasetool"><?php _d('Run process'); ?></a>
                    <span id="doodatabasetool_reports" class="agotime"><?php echo isset($timerun['reports']) ? human_time_diff($timerun['reports'], current_time('timestamp')) : $never; ?></span>
                </p>
            </div>
        </div>
        <div id="doobox_ratings" class="postbox">
            <h3><span><?php _d('Reset User ratings'); ?></span></h3>
            <div class="inside">
                <p><?php _d('Reset rating counter on all content.'); ?></p>
                <hr>
                <p>
                    <a href="#" data-run='ratings' class="button button-primary doodatabasetool"><?php _d('Run process'); ?></a>
                    <span id="doodatabasetool_ratings" class="agotime"><?php echo isset($timerun['ratings']) ? human_time_diff($timerun['ratings'], current_time('timestamp')) : $never; ?></span>
                </p>
            </div>
        </div>
        <div id="doobox_featured" class="postbox">
            <h3><span><?php _d('Reset Post featured'); ?></span></h3>
            <div class="inside">
                <p><?php _d('Reset all the content that was marked as featured and start a new list.'); ?></p>
                <p>
                    <a href="#" data-run='featured' class="button button-primary doodatabasetool"><?php _d('Run process'); ?></a>
                    <span id="doodatabasetool_featured" class="agotime"><?php echo isset($timerun['featured']) ? human_time_diff($timerun['featured'], current_time('timestamp')) : $never; ?></span>
                </p>
            </div>
        </div>
        <div id="doobox_postviews" class="postbox">
            <h3><span><?php _d('Reset Post views'); ?></span></h3>
            <div class="inside">
                <p><?php _d('Reset views counter on all content.'); ?></p>
                <hr>
                <p>
                    <a href="#" data-run='postviews' class="button button-primary doodatabasetool"><?php _d('Run process'); ?></a>
                    <span id="doodatabasetool_postviews" class="agotime"><?php echo isset($timerun['postviews']) ? human_time_diff($timerun['postviews'], current_time('timestamp')) : $never; ?></span>
                </p>
            </div>
        </div>
        <div id="doobox_genpages" class="postbox">
            <h3><span><?php _d('Generate pages'); ?></span></h3>
            <div class="inside">
                <p><?php _d('Generate all the required pages.'); ?></p>
                <hr>
                <p>
                    <a href="#" data-run='genpages' class="button button-primary doodatabasetool"><?php _d('Run process'); ?></a>
                    <span id="doodatabasetool_genpages" class="agotime"><?php echo isset($timerun['genpages']) ? human_time_diff($timerun['genpages'], current_time('timestamp')) : $never; ?></span>
                </p>
            </div>
        </div>
    </div>
    <input type="hidden" id="doolinkmod_nonce" value="<?php echo $nonce; ?>">
</div>
