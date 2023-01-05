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
    $tekstit = lataa_paivakirja($_SESSION['kayttaja_id'])

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
                            echo "<td><button class='merkintanappi'><a href='poista_havainto.php?id=" . $rivi['id'] . "'>Poista</a></button>";
                            echo "&emsp;";
                            echo "<button class='merkintanappi'><a href='muokkaa_havainto.php?id=" . $rivi['id'] . "'>Muokkaa</a></button></td>";
                            echo "</tr>";
                        }

                    }

                ?>

            </tbody>
        </table>


        <div class="tekstiosio">
            <p>
                Kimalaisten sosiaalisesta ja kognitiivisesta käyttäytymisestä löytyy hyvin tietoa "Kognitio ja sosiaalinen informaationkäyttö kimalaisilla"-tutkielmasta, joka löytyy osoitteesta <a href="http://jultika.oulu.fi/files/nbnfioulu-201811303193.pdf">http://jultika.oulu.fi/files/nbnfioulu-201811303193.pdf.</a>
            </p>

        </div>

        <div class="tekstiosion_otsikko">
            <h2>Havaintopäiväkirja</h2>
        </div>

        <div class="tekstiosio">
            <?php

                if (empty($tekstit)) {
                    echo "<p>Ei päiväkirjamerkintöjä.<p>";
                }
                else {
                    foreach ($tekstit as $teksti) {
                        echo "<b>" . $teksti['aika'] . "&emsp;" . $teksti['pvm'] . "</b>";
                        echo "<p>" . nl2br($teksti['paivakirjateksti']) . "</p>";
                        echo "<div class='poista_paivakirjamerkinta'>";
                            echo "<button class='merkintanappi'><a href='poista_paivakirjamerkinta.php?id=" . $teksti['id'] . "'>Poista merkintä</a></button>";
                        echo "</div>";
                    }
                }
            ?>

            <form method="POST" action="lisaa_paivakirjamerkinta.php" class="kenttaosio">
                <button type="button" class="kenttatoiminto merkintanappi">Lisää merkintä</button>
                <div class="kentta">
                    <div>
                        <textarea name="paivakirjateksti" class="tekstikentta"></textarea>
                    </div>
                    <button type="submit" class="merkintanappi">Tallenna merkintä</button>
                </div>
            </form>

            <div>
                <img src="img/pekka1.jpg" alt="Pekka 1" class="kuvat">
                <img src="img/pekka2.jpg" alt="Pekka 2" class="kuvat">
            </div>   

    </div>

<script type="text/javascript" src="tekstikentta.js"></script>
</body>
</html>
