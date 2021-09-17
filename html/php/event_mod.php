<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../admin/phpMailer/Exception.php';
require '../admin/phpMailer/PHPMailer.php';
require '../admin/phpMailer/SMTP.php';

function getSMTPpw(){
    $fn = fopen($_ENV['SMTP_PASSWORD_FILE'],"r");
    $key = fgets($fn);
    fclose($fn);
    return $key;
}

$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.bilhoefer.de';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'keineantwort@swingstr.de';                 // SMTP username
$mail->Password = getSMTPpw();                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->From = 'keineantwort@swingSTR.de';
$mail->FromName = 'swingSTR.de Kalender';



$servername = "swingstr_db";
$username = $_ENV["MYSQL_USER"];
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

if (isset($_SESSION['uname'])){
    $emod = clean($_SESSION['uname']);
    $eid = clean($_POST['id']);
    $echoice = clean($_POST['choice']);
    $ereason = clean($_POST['reason']);

    // Create connection
    $conn = new mysqli($servername, $username, getMySQLpw(), $dbname);

    // Check connection
    if ($conn->connect_error) {
        $errors['database'] = "Error: " . $sql . "<br>" . $conn->error;
    } else {

        if ($echoice == "2"){

            $sql = "SELECT email, ename, estart, eend, eplace, edesc FROM swingstrdb WHERE id = $eid";
            
            $event = $conn->query($sql)->fetch_assoc();

            if (!$event) {
                $errors['database'] = "Error: " . $sql . "<br>" . $conn->error;
            }
    
            $to = $event["email"];
            $ename = $event["ename"];
            $estart = $event["estart"];
            $eend = $event["eend"];
            $eplace = $event["eplace"];
            $edesc = $event["edesc"];

            $mail->addAddress($to);
            $mail->addReplyTo('info@swingSTR.de', 'swingSTR.de Kalender'); 
    
            $mail->Subject = "Dein Eintrag auf swingSTR.de";
            $mail->Body = "Hallo! \n\nLeider wurde dein Eintrag abgelehnt.\nGrund: $ereason\n\nÜbersicht:\nTitel: $ename\nStartzeit: $estart\nEndzeit: $eend\nOrt: $eplace\nBeschreibung: $edesc\n\nWenn du glaubst, dass es sich hierbei um einen Fehler handelt, kontaktiere uns unter info@swingSTR.de.";
            

            if(!$mail->send()) {
                $errors['mail'] = "Mail konnte nicht gesendet werden : " . $mail->ErrorInfo;
            };
        }

        if (empty($errors)){

            $sql = "UPDATE swingstrdb SET estat = $echoice, emod = '$emod', email = '' WHERE id = $eid";

            if ($conn->query($sql) === TRUE) {
                $data['success'] = true;
            } else {
                $errors['database'] = "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        
    }

    

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
    }
    $conn->close();

    echo json_encode($data);

} else {
    die("You are not logged in!");
};
