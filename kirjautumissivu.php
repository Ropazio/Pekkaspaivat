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
        <div class="paaotsikko">
            <h1>Pekkaspäivät - Kirjautuminen</h1>
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

                <div class="kirjautumistietojen_laheta_nappi">
                    <button type="submit">Kirjaudu</button>
                </div>

            </div>
        </form>
    </div>
</body>
</html>
