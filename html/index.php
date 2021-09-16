<?php

$lang = 'de';

?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="utf-8">

    <title>swingSTR | Der offene Swing-Kalender für Stuttgart</title>
    <meta name="description" content="swingSTR | Der offene Swing-Event-Kalender für Stuttgart und Umgebung | Swing | Lindy Hop | Charleston | Solo Jazz | Balboa | Shag | Boogie Woogie">
    <meta name="author" content="Timo Bilhöfer">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->

    <link rel="stylesheet" href="css/styles.css?v=<?php echo filemtime('css/styles.css') ?>">

</head>

<body>
    <header>
        <h1>swingSTR | Der offene Swing-Event-Kalender für Stuttgart und Umgebung</h1>
        <a id="add_event" href="javascript:">Event eintragen</a>
    </header>
    <div id="gcal">
    <iframe src="https://www.google.com/calendar/embed?showTitle=0&wkst=2&bgcolor=%23ffffff&src=kja74l310d5sg6rnpcns38k3fk@group.calendar.google.com&src=kontakt@swing-stuttgart.de&src=swingandcake@gmail.com&src=nqj3q2taqm1aike4i6opvlt37o@group.calendar.google.com&src=a2vipdbb7ghsdk71sfblvivs3k@group.calendar.google.com&color=%235A6986&ctz=Europe%2FBerlin"></iframe>
    </div>
    <footer>
        <a id="more_info" href="javascript:">Mehr Infos</a>
        <a id="imprint" href="javascript:">Impressum</a>
    </footer>

    <div id="overlay">
        <a id="close_overlay" href="javascript:close_overlay()">x</a>
        <p id="overlay_content">test</p>
    </div>

    <script async src="https://offen.bilhoefer.de/script.js" data-account-id="a35c2236-3301-4a02-a1fd-4a6965b2706a"></script>
    <script src="js/main.js"></script>
</body>
</html>

<?php