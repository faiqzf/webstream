<!DOCTYPE html>
<html lang="en" dir="ltr" data-cast-api-enabled="true">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">
        <title>JW Player</title>
        <script src="<?php echo DOO_URI. '/assets/jwplayer/jwplayer.js'; ?>"></script>
		<script src="<?php echo DOO_URI. '/assets/jwplayer/provider.html5.js'; ?>"></script>
		<script>jwplayer.key="<?php echo $jwpkey; ?>";</script>
        <script type="text/javascript">
            var jw = <?php echo json_encode($data)."\n"; ?>
        </script>
        <style type="text/css" media="all">
            html,body.jwplayer {height:100%;width:100%;margin:0;overflow:hidden;background:#000}
            #player {width:100%;height:100%;overflow:hidden}
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
                height: '100%',
				width: '100%',
                flashplayer: jw.flash,
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
