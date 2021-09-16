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
        <a id="add_event" href="javascript:">-> Event eintragen <-</a>
    </header>
    <div id="gcal">
    <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=2&bgcolor=%23ffffff&ctz=Europe%2FBerlin&src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&src=a2phNzRsMzEwZDVzZzZybnBjbnMzOGszZmtAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=bnFqM3EydGFxbTFhaWtlNGk2b3B2bHQzN29AZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=YTJ2aXBkYmI3Z2hzZGs3MXNmYmx2aXZzM2tAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=a29udGFrdEBzd2luZy1zdHV0dGdhcnQuZGU&src=c3dpbmdhbmRjYWtlQGdtYWlsLmNvbQ&color=%2333B679&color=%23D81B60&color=%237CB342&color=%23795548&color=%23EF6C00&color=%239E69AF&showTitle=0" style="border-width:0" frameborder="0" scrolling="no"></iframe>
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