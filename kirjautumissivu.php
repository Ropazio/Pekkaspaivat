<?php
    require_once "tietokanta.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pekan elämänvaiheet - Kirjaudu</title>
    <link rel="stylesheet" href="sivu.css" />
</head>
<body>
    <div class="sivu">
        <div class="paaotsikko_kirjautuminen">
            <?php
                $talvikuukaudet = [1, 2, 3, 11, 12];
                if (in_array(date("n"), $talvikuukaudet)) {
                    echo "<h1>Pakkaspäivät</h1>";
                } else {
                    echo "<h1>Pekkaspäivät</h1>";
                }
            ?>
            <h2>Kirjautuminen</h2>
        </div>

        <form method="POST" action="kirjautuminen.php">
            <div class="kirjautumislomake">
                <div class="kirjautumislomakkeen_syotteet">

                    <div class="kayttaja_teksti">
                        <label for="kayttaja">Käyttäjä:</label>
                    </div>
                    <div class="kayttaja_kentta">
                        <input type="text" id="kayttaja" name="kayttaja" />
                    </div>

                    <div class="salasana_teksti">
                        <label for="salasana">Salasana:</label>
                    </div>
                    <div class="salasana_kentta">
                        <input type="password" id="salasana" name="salasana" />
                    </div>
                </div>

                <div class="napin_laatikko">
                    <button type="submit" class="nappi">Kirjaudu</button>
                </div>

                <?php if(isset($_GET['error'])): ?> 
                    <div class="virhe" style="color: red;">
                        Virheellinen käyttäjänimi tai salasana! Voit käyttää testikäyttäjänä käyttäjänimeä "Testi" ja salasanaa "Testi".
                    </div>
                <?php endif ?> 
            </div>
        </form>
    </div>

<script type="text/javascript" src="sivun_tyyli.js"></script>
</body>
</html>
