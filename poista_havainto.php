<?php

require_once "tietokanta.php";

$id = $_GET['id'];

//TODO Validointi
$id = (int)$id;

poista_havainto($id);

// Mene takaisin etusivulle
header("Location: index.php");