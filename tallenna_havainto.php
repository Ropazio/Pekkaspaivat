<?php

require_once "yhteiset.php";
require_once "tietokanta.php";

///////////////////////////////////////////////////////////////////////////////
// Tallennuskäsittely
///////////////////////////////////////////////////////////////////////////////

$pvm = $_POST['pvm'];
$aika = $_POST['aika'];
$status = $_POST['status'] ?? false;

// TODO: Validoi syöte!

// muuta pvm + aika MySQL:n hyväksymään muotoon
$aikavyohyke = new DateTimeZone($AIKAVYOHYKE);
$datetime = date_create_from_format( $DISPLAY_DATE_FORMAT, $pvm . " " . $aika, $aikavyohyke);

// jos pvm & ajan parserointi onnistui...
if ($datetime !== false) {
    $mysql_datetime = $datetime->format($MYSQL_DATE_FORMAT);

    tallenna_havainto($mysql_datetime, $status);
}

// Mene takaisin etusivulle
header("Location: index.php");