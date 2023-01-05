<?php
    require_once "yhteiset.php";
    require_once "tietokanta.php";
    
    function tama_aika() {
        return date("H:i");
    }

    function tama_paivamaara() {
        return date("d.m.Y");
    }

    function muotoile_status($status) {
        if ($status) {
            return "Paikalla";
        }
        return "Poissa";
    }

    if (!(isset($_SESSION['kirjautunut']) && $_SESSION['kirjautunut'] != '')) {
        header ("Location: kirjautuminen.php");
    }

    $rivit = hae_havainnot($_SESSION['kayttaja_id']);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pekan elämänvaiheet</title>
    <link rel="stylesheet" href="sivu.css" />
</head>
<body>
    <div class="sivu">
        <div class="paaotsikko">
            <h1>Pekkaspäivät</h1>
        </div>

        <form method="POST" action="tallenna_havainto.php">
            <div class="havaintolomake">
                <div class="havaintolomakkeen_syotteet">

                    <div class="havainnon_pvm">
                        <label for="pvm">Pvm:</label>
                        <input type="text" id="pvm" name="pvm" value="<?=tama_paivamaara(); ?>" />
                    </div>

                    <div class="havainnon_aika">
                        <label for="aika">Aika:</label>
                        <input type="text" id="aika" name="aika" value="<?=tama_aika(); ?>" />
                    </div>
                    
                    <div class="havainnon_status">
                        <label for="status">Paikalla:</label>
                        <input type="checkbox" id="status" name="status" />
                    </div>
                </div>

                <div>
                    <button type="submit" class="nappi">Lähetä</button>
                </div>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Pvm</th>
                    <th>Aika</th>
                    <th>Status</th>
                    <th>Toiminnot</th>
                </tr>
            </thead>
            <tbody>

                <?php

                    if (empty($rivit)) {
                        echo "<tr><td colspan='4'>Ei havaintoja.</td></tr>";
                    }
                    else {

                        foreach ($rivit as $rivi) {
                            echo "<tr>";
                            echo "<td>" . $rivi['pvm'] . "</td>";
                            echo "<td>" . $rivi['aika'] . "</td>";
                            echo "<td class='" . ($rivi['status'] ? "solu_paikalla" : "solu_poissa") . "'>" . muotoile_status($rivi['status']) . "</td>";
                            echo "<td><a href='poista_havainto.php?id=" . $rivi['id'] . "'>Poista</a>";
                            echo " ";
                            echo "<a href='muokkaa_havainto.php?id=" . $rivi['id'] . "'>Muokkaa</a></td>";
                            echo "</tr>";
                        }

                    }

                ?>

            </tbody>
        </table>

        
        <div class="tekstiosion_otsikko">
            <h2>Havaintoja</h2>
        </div>

        <div class="tekstiosio">

            <p>
                Pekka on keskikokoinen kimalainen, jonka on havaittu pölyttävän lähes poikkeuksetta mirrinmintussa.
            </p>
            <p>
                Elli on pieni kimalainen, joka on havaittu pölyttävän rusokkiamppelissa.
            </p>
            <p>
                Kimalaisten sosiaalisesta ja kognitiivisesta käyttäytymisestä löytyy hyvin tietoa "Kognitio ja sosiaalinen informaationkäyttö kimalaisilla"-tutkielmasta, joka löytyy osoitteesta <a href="http://jultika.oulu.fi/files/nbnfioulu-201811303193.pdf">http://jultika.oulu.fi/files/nbnfioulu-201811303193.pdf.</a>
            </p>

        </div>

        <div class="tekstiosion_otsikko">
            <h2>Päiväkirja</h2>
        </div>

        <div class="tekstiosio">
            <p>
                Kimalaisista ei ollut lainkaan havaintoja 23.6 - 4.7 välisellä ajalla (24.6 - 26.7 ei tehty havaintoja). Epäilen, että syynä voi olla noin viikon kestänyt hellejakso, kun aurinko porotti ja lämpöä oli noin kolmisenkymmentä Celsius-asetta.
            </p>
            <p>
                Kimalainen ilmeistyi suorinta reittiä tutkimaan taas mirrinminttua hellejakson jälkeen 4.7. Epäilen, että kyseessä on Pekka. Nappasin kimalaisesta muutaman kuvan, jotka lisäisen sitten taas tänne sivulle. Täytyy merkitä havainnot taas tarkoin, jotta tutkimus saa jatkua. Tarkoitus olisi myöhemmin lisäillä keskiarvoista työaikaa havainnoiva kuvaaja sivustolle.
            </p>
            <p>
                4.7 Parvekkeella havaittu kaksi kimalaista, jotka ovat keskenään melko saman kokoisia. Kimalaiset poistuivat vain hetkeksi, joten ehkä pesä on lähettyvillä.

            </p>

            <div>
                <img src="img/pekka1.jpg" alt="Pekka 1" class="kuvat">
                <img src="img/pekka2.jpg" alt="Pekka 2" class="kuvat">
            </div>
               

    </div>
</body>
</html>
