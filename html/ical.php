<?php 
header("Content-Type: text/Calendar");
header("Content-Disposition: inline; filename=swingSTR.ics");

$servername = "swingstr_db";
$dbusername = $_ENV["MYSQL_USER"];
$dbname = $_ENV["MYSQL_DATABASE"];

function getMySQLpw(){
    $fn = fopen($_ENV['MYSQL_PASSWORD_FILE'],"r");
    $key = fgets($fn);
    fclose($fn);
    return $key;
}

// Create connection
$conn = new mysqli($servername, $dbusername, getMySQLpw(), $dbname);
    
// Check connection
if ($conn->connect_error) {
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {

    $sql = "SELECT * FROM swingstrdb WHERE estat = 1";

    $events = $conn->query($sql);

    if (!$events) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}


?>
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//swingSTR//swingevents//DE
CALSCALE:GREGORIAN
METHOD:PUBLISH
<?php
foreach ($events as $event) {
    $estart = date("Ymd\THis", strtotime($event["estart"]));
    $eend = date("Ymd\THis", strtotime($event["eend"]));
    echo "BEGIN:VEVENT\n";
    echo "SUMMARY:".$event["ename"]."\n";
    echo "UID:".$event["id"]."\n";
    echo "DTSTART;TZID=Europe/Berlin:".$estart."\n";
    echo "DTEND;TZID=Europe/Berlin:".$eend."\n";
    echo "LOCATION:".$event["eplace"]."\n";
    echo "END:VEVENT\n";
}
?>
END:VCALENDAR