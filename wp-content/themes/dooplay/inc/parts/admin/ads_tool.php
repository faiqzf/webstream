<div class="wrap dooads">
    <h1><?php _d('Ad code manager'); ?></h1>
    <div id="ad-manage-codes" class="updated hidden">
        <p><strong><?php _e('Settings saved.'); ?></strong></p>
    </div>
    <nav class="menu">
        <ul id="dooadmenu" class="items">
            <li data-tab="integrations" class="nav-tab nav-tab-active"><?php _d('Code integrations'); ?></li>
            <li data-tab="homepage" class="nav-tab"><?php _d('Homepage'); ?></li>
            <li data-tab="singlepost" class="nav-tab"><?php _d('Single Post'); ?></li>
            <li data-tab="videoplayer" class="nav-tab"><?php _d('Video Player'); ?></li>
            <li data-tab="linksmodule" class="nav-tab"><?php _d('Links redirection'); ?></li>
        </ul>
    </nav>

    <form id="dooadmanage">
        <div id="dooad-integrations" class="tab-content on">
            <h3><?php _d('Header code integration'); ?></h3>
            <?php $this->textarea('_dooplay_header_code', $headcode); ?>
            <p><?php _d('Enter the code which you need to place before closing tag. (ex: Google Webmaster Tools verification, Bing Webmaster Center, BuySellAds Script, Alexa verification etc.)'); ?></p>
            <hr>
            <h3><?php _d('Footer code integration'); ?></h3>
            <?php $this->textarea('_dooplay_footer_code', $footcode); ?>
            <p><?php _d('Enter the codes which you need to place in your footer. (ex: Google Analytics, Clicky, STATCOUNTER, Woopra, Histats, etc.)'); ?></p>
        </div>

        <div id="dooad-homepage" class="tab-content">
            <h3><?php _d('Homepage > Ad banner desktop'); ?></h3>
            <?php $this->textarea('_dooplay_adhome', $adhomedk, __d('Use HTML code')); ?>
            <h3><?php _d('Homepage > Ad banner mobile'); ?></h3>
            <?php $this->textarea('_dooplay_adhome_mobile', $adhomemb, __d('Use HTML code')); ?>
            <p><?php _d('This is an optional field'); ?></p>
        </div>

        <div id="dooad-singlepost" class="tab-content">
            <h3><?php _d('Single Post > Ad banner desktop'); ?></h3>
            <?php $this->textarea('_dooplay_adsingle', $adsingdk, __d('Use HTML code')); ?>
            <h3><?php _d('Single Post > Ad banner mobile'); ?></h3>
            <?php $this->textarea('_dooplay_adsingle_mobile', $adsingmb, __d('Use HTML code')); ?>
            <p><?php _d('This is an optional field'); ?></p>
        </div>

        <div id="dooad-videoplayer" class="tab-content">
            <h3><?php _d('Video Player > Ad banner desktop'); ?></h3>
            <?php $this->textarea('_dooplay_adplayer', $adplaydk, __d('Use HTML code')); ?>
            <h3><?php _d('Video Player > Ad banner mobile'); ?></h3>
            <?php $this->textarea('_dooplay_adplayer_mobile', $adplaymb, __d('Use HTML code')); ?>
            <p><?php _d('This is an optional field'); ?></p>
        </div>
        <div id="dooad-linksmodule" class="tab-content">
            <h3><?php _d('Ad in top for Desktop'); ?></h3>
            <?php $this->textarea('_dooplay_adlinktop', $adlinktd, __d('Use HTML code')); ?>
            <h3><?php _d('Ad in top for mobile'); ?></h3>
            <?php $this->textarea('_dooplay_adlinktop_mobile', $adlinktm, __d('Use HTML code')); ?>
            <p><?php _d('This is an optional field'); ?></p>
            <hr>
            <h3><?php _d('Ad in bottom for Desktop'); ?></h3>
            <?php $this->textarea('_dooplay_adlinkbottom', $adlinkbd, __d('Use HTML code')); ?>
            <h3><?php _d('Ad in bottom for mobile'); ?></h3>
            <?php $this->textarea('_dooplay_adlinkbottom_mobile', $adlinkbm, __d('Use HTML code')); ?>
            <p><?php _d('This is an optional field'); ?></p>
        </div>
        <hr>
        <div class="control">
            <input id="dooadsavebutton" type="submit" class="button button-primary" data-text="<?php _d('Save changes'); ?>" value="<?php _d('Save changes'); ?>">
            <input type="hidden" name="nonce" value="<?php echo $nonce; ?>">
            <input type="hidden" name="action" value="dooadmanage">
        </div>
    </form>

</div>
