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



echo "BEGIN:VCALENDAR\r\n";
echo "VERSION:2.0\r\n";
echo "PRODID:-//swingSTR//swingevents//DE\r\n";
echo "CALSCALE:GREGORIAN\r\n";
echo "METHOD:PUBLISH\r\n";
echo "X-WR-CALNAME:swingSTR\r\n";
echo "X-WR-TIMEZONE:Europe/Berlin\r\n";
echo "BEGIN:VTIMEZONE\r\n";
echo "TZID:Europe/Berlin\r\n";
echo "X-LIC-LOCATION:Europe/Berlin\r\n";
echo "BEGIN:DAYLIGHT\r\n";
echo "TZOFFSETFROM:+0100\r\n";
echo "TZOFFSETTO:+0200\r\n";
echo "TZNAME:CEST\r\n";
echo "DTSTART:19700329T020000\r\n";
echo "END:DAYLIGHT\r\n";
echo "BEGIN:STANDARD\r\n";
echo "TZOFFSETFROM:+0200\r\n";
echo "TZOFFSETTO:+0100\r\n";
echo "TZNAME:CET\r\n";
echo "DTSTART:19701025T030000\r\n";
echo "END:STANDARD\r\n";
echo "END:VTIMEZONE\r\n";

foreach ($events as $event) {
    $estart = date("Ymd\THis", strtotime($event["estart"]));
    $eend = date("Ymd\THis", strtotime($event["eend"]));
    echo "BEGIN:VEVENT\r\n";
    echo "SUMMARY:".$event["ename"]."\r\n";
    echo "UID:".$event["id"]."@swingSTR.de\r\n";
    echo "DTSTART;TZID=Europe/Berlin:".$estart."\r\n";
    echo "DTEND;TZID=Europe/Berlin:".$eend."\r\n";
    echo "DTSTAMP;TZID=Europe/Berlin:".date("Ymd\THis")."\r\n";
    echo "LOCATION:".$event["eplace"]."\r\n";
    echo "END:VEVENT\r\n";
}

echo "END:VCALENDAR\r\n";