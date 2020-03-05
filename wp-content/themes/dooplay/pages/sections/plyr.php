<html lang="en" dir="ltr" data-cast-api-enabled="true">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="noindex">
        <title>Plyr</title>
        <link rel="stylesheet" href="https://cdn.plyr.io/3.4.7/plyr.css">
        <style type="text/css" media="all">
            html,body.plyr{
                height:100%;
                width:100%;
                margin:0;
                overflow:
                hidden;
                background:#000
            }
            #player{
                width:100%;
                height:100%;
                overflow:hidden
            }
            .plyr--audio .plyr__control.plyr__tab-focus,
            .plyr--audio .plyr__control:hover,
            .plyr--audio .plyr__control[aria-expanded=true] {
                background: <?php echo $plyrcl; ?>!important
            }
            .plyr--video .plyr__control.plyr__tab-focus,
            .plyr--video .plyr__control:hover,
            .plyr--video .plyr__control[aria-expanded=true] {
                background: <?php echo $plyrcl; ?>!important
            }
            .plyr__control--overlaid:focus,
            .plyr__control--overlaid:hover {
                background: <?php echo $plyrcl; ?>!important
            }
            .plyr__menu__container .plyr__control[role=menuitemradio][aria-checked=true]::before {
                background: <?php echo $plyrcl; ?>!important
            }
            .plyr--full-ui input[type=range] {
                color: <?php echo $plyrcl; ?>!important
            }
            .plyr__control--overlaid {
                background: rgba(255, 255, 255, 0.5)!important
            }
        </style>
    </head>
    <body class="plyr">
        <video poster="<?php echo $prvimg; ?>" id="player" playsinline controls>
            <source src="<?php echo $mp4fle; ?>" type="video/mp4" size="720">
        </video>
    </body>
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=es6,Array.prototype.includes,CustomEvent,Object.entries,Object.values,URL"></script>
    <script src="https://cdn.plyr.io/3.4.7/plyr.js" crossorigin="anonymous"></script>
    <script>const player = new Plyr('#player')</script>
</html>
