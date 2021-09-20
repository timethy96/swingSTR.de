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

    <link rel="canonical" href="https://swingSTR.de" />

    <meta property="og:image:width" content="279">
    <meta property="og:image:height" content="279">
    <meta property="og:image" content="https://swingSTR.de/og/og-image.jpg">
    <meta property="og:description" content="swingSTR | Der offene Swing-Event-Kalender f&uuml;r Stuttgart und Umgebung | Swing | Lindy Hop | Charleston | Solo Jazz | Balboa | Shag | Boogie Woogie">
    <meta property="og:title" content="swingSTR | Der offene Swing-Kalender f&uuml;r Stuttgart">
    <meta property="og:url" content="swingSTR.de">
    <link rel="apple-touch-icon" sizes="180x180" href="/og/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/og/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/og/favicon-16x16.png">
    <link rel="manifest" href="/og/site.webmanifest">
    <link rel="mask-icon" href="/og/safari-pinned-tab.svg" color="#000000">
    <link rel="shortcut icon" href="/og/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="swingSTR">
    <meta name="application-name" content="swingSTR">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-config" content="/og/browserconfig.xml">
    <meta name="theme-color" content="#000000">

    <link rel="stylesheet" href="css/styles.css?v=<?php echo filemtime('css/styles.css') ?>">

</head>

<body>
    <header>
        <h1>swing<span class="white">STR</span> | Der offene Swing-Event-Kalender für Stuttgart und Umgebung</h1>
        <a id="add_event" href="javascript:">Event eintragen</a>
    </header>

    <div id="cat_tabs">
        <a class="cat_tab active" id="tab_events" href="javascript:">Events</a>
        <a class="cat_tab" id="tab_kurse" href="javascript:">Kurse</a>
    </div>

    <div id="gcal">
        <iframe src="https://www.google.com/calendar/embed?showTitle=0&wkst=2&bgcolor=%23ffffff&src=jl64g1ck3s2evbcqaq22hhturo@group.calendar.google.com&src=swingandcake@gmail.com&src=a2vipdbb7ghsdk71sfblvivs3k@group.calendar.google.com&color=%235A6986&ctz=Europe%2FBerlin"></iframe>
    </div>

    <footer>
        <a id="more_info" href="javascript:">Mehr Infos</a>
        <a id="imprint" href="javascript:">Impressum</a>
    </footer>

    <div id="overlay">
        <a id="close_overlay" href="javascript:close_overlay()">x</a>
        <p id="overlay_content">test</p>
    </div>

    <script async src="https://offen.bilhoefer.de/script.js" data-account-id="7983b615-6b2a-4f8d-83db-b914ebc81fb7"></script>
    <script src="https://js.hcaptcha.com/1/api.js?hl=de&render=explicit" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/main.js"></script>
</body>
</html>

<?php