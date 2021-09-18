<?php
session_start();

$servername = "swingstr_db";
$dbusername = $_ENV["MYSQL_USER"];
$dbname = $_ENV["MYSQL_DATABASE"];

function getMySQLpw(){
    $fn = fopen($_ENV['MYSQL_PASSWORD_FILE'],"r");
    $key = fgets($fn);
    fclose($fn);
    return $key;
}

function clean($str){
    $str = mb_convert_encoding($str, 'UTF-8', 'UTF-8');
    $str = htmlentities($str, ENT_QUOTES, 'UTF-8');
    return $str;
}

function getPWhash($usr){
    $file = file_get_contents($_ENV['SWINGSTR_USERS_FILE']);
    $lines = explode("\n", $file);
    foreach($lines as $row) {
        $uspw = explode(':',$row);
        if (strtoupper($uspw[0]) == strtoupper($usr)){
            return $uspw[1];
        }
    }
    return FALSE;
}

function httpPost($url, $data)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function getCaptchaSecret(){
    $fn = fopen($_ENV['HCAPTCHA_KEY_FILE'],"r");
    $key = fgets($fn);
    fclose($fn);
    return $key;
}



// If the submit button is pressed
if(isset($_POST['submit'])){

// Escape special characters in a string
    $username = clean($_POST['username']);
    $password = clean($_POST['password']);

    $captchaData = array('response' => $_POST['h-captcha-response'], 'secret' => getCaptchaSecret());
    $captchaResponse = json_decode(httpPost("https://hcaptcha.com/siteverify", $captchaData), true);

    if ($captchaResponse["success"]) {
    // If username and password are not empty
        if ($username != "" && $password != ""){

        // Query database to find user with matching username and password
            $hash = getPWhash($username);
            if ($hash){
                $hashpw = hash('sha256',$password);
                if ($hash == $hashpw) {
                    $_SESSION['uname'] = $username;
                } else {
                    echo "Error! Invalid username and password.";
                }
            } else {
            
            // Display failed message
                    echo "Error! Invalid username and password.";
            }

        }
    }

}
?>

<html>
<head>
    <title>swingSTR | Moderatorbereich</title>
    <link rel="stylesheet" href="admin.css?v=<?php echo filemtime('admin.css') ?>">
</head>
  <body>
	<div class="container">

<?php

if (!isset($_SESSION['uname'])){
?>

<form method="post" action="">
    <div id="div_login">
        <h1>Login</h1>
        <div>
            <input type="text" class="textbox" id="username" name="username" placeholder="Username" />
        </div>
        <div>
            <input type="password" class="textbox" id="password" name="password" placeholder="Password"/>
        </div>
        <div class="h-captcha" data-sitekey="027fb1df-5ecd-4ac6-a20c-53208b082a83"></div>
        <div>
            <input type="submit" value="Submit" name="submit" id="submit" />
        </div>
    </div>
</form>
<script src="https://js.hcaptcha.com/1/api.js?hl=de" async defer></script>
<?php
} elseif ($_SESSION['uname']) {

// Create connection
$conn = new mysqli($servername, $dbusername, getMySQLpw(), $dbname);
    
// Check connection
if ($conn->connect_error) {
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {

    $sql = "SELECT * FROM swingstrdb WHERE estat = 0";

    $newEvents = $conn->query($sql);

    if (!$newEvents) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql = "SELECT * FROM swingstrdb WHERE estat = 1";

    $accEvents = $conn->query($sql);

    if (!$accEvents) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql = "SELECT * FROM swingstrdb WHERE estat = 2";

    $denEvents = $conn->query($sql);

    if (!$denEvents) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}


?>

    <div id="usr_login">Hallo <?php echo $_SESSION['uname']; ?>! Du hast dich erfolgreich eingeloggt.</div>
    <p>INFO: Es kann bis zu 12 Stunden dauern, bis Änderungen im Kalender angezeigt werden! (Google Beschränkung)</p>
    <h2>Neue Anfragen</h2>
    <?php
    if ($newEvents->num_rows == 0) {
        echo "Keine neuen Events verfügbar!";
    }
    foreach ($newEvents as $event) {
        ?>
        <div class="event_card" data-id="<?php echo $event['id']; ?>">
            <div class="event_load"></div>
            <div class="event_description">
                <ul>
                    <li>E-Mail: <?php echo $event["email"]; ?></li>
                    <li>Event Name: <?php echo $event["ename"]; ?></li>
                    <li>Start: <?php echo $event["estart"]; ?></li>
                    <li>Ende: <?php echo $event["eend"]; ?></li>
                    <li>Ort: <?php echo $event["eplace"]; ?></li>
                    <li>Beschreibung: <?php echo $event["edesc"]; ?></li>
                    <li>Kategorie: <?php echo $event["ecat"]; ?></li>
                </ul>
            </div>
            <div class="event_buttons">
                <a href="javascript:" class="event_accept event_button">Annehmen</a>
                <a href="javascript:" class="event_deny event_button">Ablehnen</a>
                <form class="deny_reason">
                    <textarea id="denytext" name="reason" placeholder="Grund der Ablehnung" rows="5" required></textarea>
                    <input type="submit" value="Senden" />
                </form>
                <a href="javascript:" class="event_spam event_button">Spam</a>
            </div>
        </div>
        <?php
    }
    ?>
    <h2>Beantwortete Anfragen</h2>
    <div id="active_events" class="old_events">
        <h3>Aktive Events</h3>
        <?php
        
        foreach ($accEvents as $event) {
            ?>
            <div class="event_card" data-id="<?php echo $event['id']; ?>">
                <div class="event_load"></div>
                <div class="event_description">
                    <ul>
                        <li>Event Name: <?php echo $event["ename"]; ?></li>
                        <li>Start: <?php echo $event["estart"]; ?></li>
                        <li>Ende: <?php echo $event["eend"]; ?></li>
                        <li>Ort: <?php echo $event["eplace"]; ?></li>
                        <li>Beschreibung: <?php echo $event["edesc"]; ?></li>
                        <li>Status: <?php echo $event["estat"]; ?></li>
                        <li>Moderator: <?php echo $event["emod"]; ?></li>
                    </ul>
                </div>
                <div class="event_buttons">
                    <a href="javascript:" class="event_deactivate event_button">Event deaktivieren</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div id="denied_events" class="old_events">
        <h3>Abgelehnte Events</h3>
        <?php
        foreach ($denEvents as $event) {
            ?>
            <div class="event_card" data-id="<?php echo $event['id']; ?>">
                <div class="event_load"></div>
                <div class="event_description">
                    <ul>
                        <li>Event Name: <?php echo $event["ename"]; ?></li>
                        <li>Start: <?php echo $event["estart"]; ?></li>
                        <li>Ende: <?php echo $event["eend"]; ?></li>
                        <li>Ort: <?php echo $event["eplace"]; ?></li>
                        <li>Beschreibung: <?php echo $event["edesc"]; ?></li>
                        <li>Status: <?php echo $event["estat"]; ?></li>
                        <li>Moderator: <?php echo $event["emod"]; ?></li>
                    </ul>
                </div>
                <div class="event_buttons">
                    <a href="javascript:" class="event_reactivate event_button">Event reaktivieren</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>


</div>

<?php
};
?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="admin.js"></script>
    </body>
</html>

<?php