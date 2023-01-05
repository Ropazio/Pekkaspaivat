<?php
require_once "tietokanta.php";

function kirjautuminen($kayttaja, $salasana) : bool {

    echo "Yritetään kirjautua: käyttäjä = '" . $kayttaja . "', salasana = '" . $salasana ."'.<br>";
 
    // Tarkistetaan käyttäjä ja salasana. Palataan kirjautumissivulle, jos ei löydy käyttäjää tai salasana on väärä.
    $id = tarkista_kirjautuminen($kayttaja, $salasana);
    if (empty($id)) {
        header("Location: kirjautumissivu.php");
        return false;
    }

    // Jos käyttäjä Löytyy ja salasana ok, jatketaan pekkaspäiviin.
    $_SESSION['kirjautunut'] = true;
    $_SESSION['kayttaja_id'] = $id;
    header ("Location: index.php");
    return true;
}

$kayttaja = $_POST['kayttaja'];
$salasana = $_POST['salasana'];

kirjautuminen($kayttaja , $salasana);

?>