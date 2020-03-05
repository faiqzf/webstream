<!DOCTYPE html>
<html lang="en" dir="ltr" data-cast-api-enabled="true">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">
        <title>JW Player</title>
        <script src='https://ssl.p.jwpcdn.com/player/v/8.6.2/jwplayer.js'></script>
        <script type="text/javascript">jwplayer.key="<?php echo $jw8key; ?>";</script>
        <script type="text/javascript">
            var jw = <?php echo json_encode($data)."\n"; ?>
        </script>
        <style type="text/css" media="all">
            html,body{padding:0;margin:0;height:100%}
            #player{width:100%!important;height:100%!important;overflow:hidden;background-color:#000}
        </style>
    </head>
    <body class="jwplayer">
        <div id="player"></div>
        <script type="text/javascript">
            const player = jwplayer('player').setup({
                image: jw.image,
                mute: false,
                volume: 25,
                autostart: jw.auto,
                repeat: false,
                abouttext: jw.text,
                aboutlink: jw.link,
                skin: {
                    active: jw.color
                },
                logo: {
                    file: jw.logo,
                    hide: true,
                    link: jw.link,
                    margin: '15',
                    position: jw.lposi
                },
                sources: [{
                    file: jw.file,
                    type: 'video/mp4'
                }],
            })
        </script>
    </body>
</html>
