<?php

$servername = "swingstr_db";
$username = $_ENV["MYSQL_USER"];
$dbname = $_ENV["MYSQL_DATABASE"];

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

$errors = [];
$data = [];

if (empty($_POST['email'])) {
    $errors['email'] = 'E-Mail muss angegeben werden.';
}

if (empty($_POST['ename'])) {
    $errors['ename'] = 'Event Name muss angegeben werden.';
}

if (empty($_POST['edate'])) {
    $errors['edate'] = 'Datum muss angegeben werden.';
}

if (empty($_POST['etimeb'])) {
    $errors['etimeb'] = 'Beginn muss angegeben werden.';
}

if (empty($_POST['etimee'])) {
    $errors['etimee'] = 'Ende muss angegeben werden.';
}

if (empty($_POST['eplace'])) {
    $errors['eplace'] = 'Ort muss angegeben werden.';
}

if (empty($_POST['edesc'])) {
    $errors['edesc'] = 'Beschreibung muss angegeben werden.';
}

if (empty($_POST['hcaptcha'])) {
    $errors['hcaptcha'] = 'Das Captcha muss ausgefüllt werden.';
}

if (isset($_POST['hcaptcha'])){
    $captchaData = array('response' => $_POST['hcaptcha'], 'secret' => getCaptchaSecret());
    $captchaResponse = json_decode(httpPost("https://hcaptcha.com/siteverify", $captchaData), true);

    if (!$captchaResponse["success"]) {
        $errors['hcaptcha'] = 'Das Captcha wurde nicht richtig gelöst.';
    }
} else {
    $errors['hcaptcha'] = 'Es gab ein Problem mit dem Captcha-Service.';
}


if (empty($errors)) {

    // clean POST
    $email = clean($_POST['email']);
    $ename = clean($_POST['ename']);
    $edate = clean($_POST['edate']);
    $etimee = clean($_POST['etimee']);
    $etimeb = clean($_POST['etimeb']);
    $eplace = clean($_POST['eplace']);
    $edesc = clean($_POST['edesc']);

    // calc start & end
    $estart = new DateTime($edate." ".$etimeb, new DateTimeZone("Europe/Berlin"));
    $eend = new DateTime($edate." ".$etimee, new DateTimeZone("Europe/Berlin"));
    if ($eend < $estart){
        $eend = $eend->modify("+24 hours");
    };
    $estart = $estart->format('Y-m-d H:i:s');
    $eend = $eend->format('Y-m-d H:i:s');

    // Create connection
    $conn = new mysqli($servername, $username, getMySQLpw(), $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        $errors['database'] = "Error: " . $sql . "<br>" . $conn->error;
    } else {

        $sql = "INSERT INTO swingstrdb (email, ename, estart, eend, eplace, edesc, ecat, estat, emod) VALUES ('$email', '$ename', '$estart', '$eend', '$eplace', '$edesc', 0, 0, '')";

        if ($conn->query($sql) === TRUE) {
            $data['success'] = true;
        } else {
            $errors['database'] = "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    
}

$data["edata"] = json_encode("{email:$email,ename:$ename,edate:$edate,etimee:$etimee,etimeb:$etimeb,eplace:$eplace,edesc:$edesc,estart:$estart,eend:$eend}");

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $data['success'] = true;
    $data['message'] = '<h3>Erfolg!</h3>Das Event wurde erfolgreich gesendet und wird nun geprüft. Dies kann wenige Tage dauern.';
}

echo json_encode($data);