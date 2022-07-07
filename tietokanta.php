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

function hae_havainnot() {
    global $pdo, $MYSQL_DATE_FORMAT;

    // Hae kaikki havainnot
    $query = $pdo->query("SELECT * FROM havainnot ORDER BY pvmaika DESC");
    $query->execute();

    $havainnot = $query->fetchAll();
    //echo print_r( $havainnot, true );

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
    $query = "INSERT INTO havainnot (pvmaika, status) VALUES (?, ?)";
    $pdo->prepare($query)->execute([$datetime, !empty($status)]);
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
    $query = $pdo->prepare("SELECT salasana FROM kayttajat WHERE kayttaja = ?");
    
    $query->execute([$kayttaja]);
    $kayttajan_salasana_tietokannassa = $query->fetch();

    if (empty($kayttajan_salasana_tietokannassa)) {
        return false;
    }

    if ($kayttajan_salasana_tietokannassa['salasana'] == $salasana) {
        return true;
    }

    return false;
}