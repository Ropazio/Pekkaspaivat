<?php
require_once "yhteiset.php";


// Tietokantayhteys

$dbConfig = [
    'name'          => 'pekkaspaivat',
    'user'          => 'root',
    'password'      => '',
    'options'       => []
];

$pdo = new PDO(
    'mysql:host=127.0.0.1;dbname='. $dbConfig['name'],
    $dbConfig['user'],
    $dbConfig['password'],
    $dbConfig['options']
);

// Avaa tietokantayhteys
$pdo->exec('SET NAMES utf8');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

///////////////////////////////////////////////////////////////////////////////

function hae_havainnot($kayttaja_id) {
    global $pdo, $MYSQL_DATE_FORMAT;

    // Hae kaikki havainnot
    $query = "SELECT * FROM havainnot WHERE kayttaja_id = ? ORDER BY pvmaika DESC";
    $sth = $pdo->prepare($query);
    $sth->execute([$kayttaja_id]);

    $havainnot = $sth->fetchAll();

    foreach ($havainnot as &$havainto) {

        // muuta datetime erilliseksi päivämääräksi ja ajaksi
        $datetime = date_create_from_format($MYSQL_DATE_FORMAT, $havainto['pvmaika']);
        $pvm = $datetime->format('d.m.Y');
        $aika = $datetime->format('H:i');

        $havainto = [
            'id'        => $havainto['id'],
            'pvm'       => $pvm,
            'aika'      => $aika,
            'status'    => $havainto['status'],
        ];
    }

    return $havainnot;
}


function tallenna_havainto($datetime, $status) {
    global $pdo;

    // Tallenna uusi havainto
    $query = "INSERT INTO havainnot (pvmaika, status, kayttaja_id) VALUES (?, ?, ?)";
    $pdo->prepare($query)->execute([$datetime, $status ? 1 : 0, $_SESSION['kayttaja_id']]);
}

function poista_havainto($id) {
    global $pdo;

    // Hae kaikki havainnot
    $pdo->prepare("DELETE FROM havainnot WHERE id = ?")->execute([$id]);
}

function muokkaa_havainto() {
    // Tähän tulee muokkaus
}

///////////////////////////////////////////////////////////////////////////////

function tarkista_kirjautuminen($kayttaja, $salasana) {
    global $pdo;

    // Hae kayttaja tietokannasta kayttajat
    $query = $pdo->prepare("SELECT salasana, id FROM kayttajat WHERE kayttaja = ?");
    
    $query->execute([$kayttaja]);
    [$kayttaja_salasana_tietokannassa, $kayttaja_id_tietokannassa] = $query->fetch();

    // kirjautuminen epäonnistui
    if (empty($kayttaja_salasana_tietokannassa)) {
        return null;
    }

    // kirjautuminen onnistui
    if ($kayttaja_salasana_tietokannassa == $salasana) {
        return $kayttaja_id_tietokannassa;
    }

    // kirjautuminen epäonnistui
    return null;
}

//////////////////////////////////////////////////////////////////////////////

function lataa_paivakirja($kayttaja_id) {
    global $pdo, $MYSQL_DATE_FORMAT;

    // Hae päiväkirjateksti tietokannasta päiväkirja
    $query = "SELECT * FROM paivakirja WHERE kayttaja_id = ? ORDER BY pvmaika DESC";
    $sth = $pdo->prepare($query);
    $sth->execute([$kayttaja_id]);

    $paivakirjateksti = $sth->fetchAll();

    foreach ($paivakirjateksti as &$paivitys) {

        // muuta datetime erilliseksi päivämääräksi ja ajaksi
        $datetime = date_create_from_format($MYSQL_DATE_FORMAT, $paivitys['pvmaika']);
        $pvm = $datetime->format('d.m.Y');
        $aika = $datetime->format('H:i');

        $paivitys = [
            'id'                => $paivitys['id'],
            'pvm'               => $pvm,
            'aika'              => $aika,
            'paivakirjateksti'  => $paivitys['paivakirjateksti'],
        ];
    }

    return $paivakirjateksti;
}

function tallenna_merkinta($datetime, $paivakirjateksti) {
    global $pdo;

    // Tallenna uusi päiväkirjamerkintä
    $query = "INSERT INTO paivakirja (pvmaika, paivakirjateksti, kayttaja_id) VALUES (?, ?, ?)";
    $pdo->prepare($query)->execute([$datetime, $paivakirjateksti, $_SESSION['kayttaja_id']]);
}

function poista_merkinta($id) {
    global $pdo;

    // Hae kaikki päiväkirjamerkinnät
    $pdo->prepare("DELETE FROM paivakirja WHERE id = ?")->execute([$id]);
}