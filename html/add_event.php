<?php
?>
<h2>Neues Event in den Kalender eintragen</h2>
<div id="add_errors"></div>
<form id="add_event_form" >
    <label for="email">Deine E-Mail-Adresse: <br /><span class="tiny">(wird nur zu Kontaktzwecken gespeichert, nach Bearbeitung der Anfrage gelöscht und nie an Dritte weitergegeben)</span></label>
    <input type="email" id="email" name="email" required />
    <label for="ename">Event Name:</label>
    <input type="text" id="ename" name="ename" />
    <label for="edate">Datum:</label>
    <input type="date" id="edate" name="edate" />
    <label for="etimeb">Uhrzeit Beginn:</label>
    <input type="time" id="etimeb" name="etimeb" />
    <label for="etimee">Uhrzeit Ende:</label>
    <input type="time" id="etimee" name="etimee" />
    <label for="eplace">Ort:</label>
    <input type="text" id="eplace" name="eplace" />
    <label for="edesc">Beschreibung:</label>
    <textarea id="edesc" name="edesc" rows="5"></textarea>
    <div id="h-captcha"></div>
    <input type="submit" value="Absenden">
</form>
<?php