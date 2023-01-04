<?php
require_once "tietokanta.php";

function kirjautuminen($kayttaja, $salasana) : bool {

    echo "Yritetään kirjautua: käyttäjä = '" . $kayttaja . "', salasana = '" . $salasana ."'.<br>";
 
    // Tarkistetaan käyttäjä ja salasana. Palataan kirjautumissivulle, jos ei löydy käyttäjää tai salasana on väärä.
    if (tarkista_kirjautuminen($kayttaja, $salasana) == false) {
        header("Location: kirjautumissivu.php");
        return false;
    }

    // Jos käyttäjä Löytyy ja salasana ok, jatketaan pekkaspäiviin. 
    header("Location: index.php");
}

$kayttaja = $_POST['kayttaja'];
$salasana = $_POST['salasana'];

kirjautuminen($kayttaja , $salasana);

?>