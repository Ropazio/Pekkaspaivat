<?php

require_once "yhteiset.php";
require_once "tietokanta.php";

///////////////////////////////////////////////////////////////////////////////
// Tallennuskäsittely
///////////////////////////////////////////////////////////////////////////////

$pvm = date('d.m.Y');
$aika = date('H:i');
$teksti = $_POST['paivakirjateksti'];


// TODO: Validoi syöte!

// muuta pvm + aika MySQL:n hyväksymään muotoon
$aikavyohyke = new DateTimeZone($AIKAVYOHYKE);
$datetime = date_create_from_format( $DISPLAY_DATE_FORMAT, $pvm . " " . $aika, $aikavyohyke);

// jos pvm & ajan parserointi onnistui...
if ($datetime !== false) {
    $mysql_datetime = $datetime->format($MYSQL_DATE_FORMAT);

    tallenna_merkinta($mysql_datetime, $teksti);
}

// Mene takaisin etusivulle
header("Location: index.php");