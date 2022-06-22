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

    $rivit = hae_havainnot();

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
            <div class="lomake">
                <div class="lomakkeen_syotteet">

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

                <div class="havainnon_laheta_nappi">
                    <button type="submit">Lähetä</button>
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

        
        <div class="teksitosion_otsikko">
            <h2>Havaintoja</h3>
        </div>

        <div class="tekstiosio">
            <h3>
                <p>
                    Pekka on keskikokoinen kimalainen, jonka on havaittu pölyttävän lähes poikkeuksetta mirrinmintussa.
                </p>
                <p>
                    Elli on pieni kimalainen, joka on havaittu pölyttävän rusokkiamppelissa.
                </p>
            </h3>
        </div>

    </div>
</body>
</html>
