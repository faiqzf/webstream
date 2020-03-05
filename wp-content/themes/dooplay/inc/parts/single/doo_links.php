<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <meta name="robots" content="noindex, follow">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
        <title><?php echo wp_kses_post($titl); ?></title>
        <link rel='stylesheet' id='fonts-css'  href='https://fonts.googleapis.com/css?family=Roboto:400,500' type='text/css' media='all' />
        <link rel='stylesheet' id='link-single'  href='<?php echo DOO_URI,'/assets/css/front.links.css'; ?>' type='text/css' media='all' />
        <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
        <script type='text/javascript'>
            var Link = <?php echo $json; ?>;
        </script>
        <?php if($ganl){ ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ganl; ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo $ganl; ?>');
        </script>
        <?php } ?>
        <style type='text/css'>
            :root {
                --main-color:<?php echo $clor; ?>;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="container">
                <div class="box" style="border-top: solid 3px <?php echo $clor; ?>">
                    <?php if($adst) echo "<div class='ads top'>{$adst}</div>"; ?>
                    <div class="inside">
                        <div class="counter">
                            <span id="counter"><?php echo $time; ?></span>
                            <small><?php _d('Please wait until the time runs out'); ?></small>
                        </div>
                        <a id="link" rel="nofollow" href="<?php echo $murl; ?>" class="btn" style="background-color:<?php echo $clor; ?>"><?php echo $btxt; ?></a>
                        <small class="text"><?php echo $txun; ?></small>
                        <small class="text"><a href="<?php echo $prml; ?>"><?php echo $titl; ?></a></small>
                    </div>
                    <?php if($adsb) echo "<div class='ads bottom'>{$adsb}</div>"; ?>
                </div>
                <?php if($type === __d('Torrent')) { ?>
                    <small class="footer"><?php _d('Get this torrent'); ?></small>
                <?php } else { ?>
                    <small class="footer"><?php echo sprintf( __d('Are you going to %s'), '<strong>'.$domn.'</strong>'); ?></small>
                <?php } ?>
            </div>
        </div>
    </body>
    <script type='text/javascript' src='<?php echo doo_compose_javascript('front.links'); ?>'></script>
</html>
