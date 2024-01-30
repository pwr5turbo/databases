<?php 
    $result_rotterdam = "";
    $no_order = "";
    $rotterdam_aantal = "";
    $result_west = "";
    $result_azie = "";
    $volw_kind = "";
    $postcode = "";
    $woonplaats = "";
    $boekdatum = "";
    $aantaldagen = "";
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "reisbureau";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT Naam FROM klanten where Plaats = 'Rotterdam'";
    $result = $conn->query($sql);

    while( $row = $result->fetch_assoc() ) {
        $result_rotterdam .= $row["Naam"] . "<br>" ;
    }

    $aantalRot = "SELECT COUNT(Naam) as aantal_rotterdam FROM klanten where Plaats = 'Rotterdam'";
    $result = $conn->query($aantalRot);
    
    while( $row = $result->fetch_assoc() ) {
        $rotterdam_aantal .= $row["aantal_rotterdam"] . "<br>" ;
    }

    $klantNum = "SELECT Naam 
    FROM klanten t1
    LEFT JOIN boekingen t2 ON t1.Klantnummer = t2.Klantnummer
    WHERE t2.Klantnummer IS NULL";
    
    $result = $conn->query($klantNum);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $no_order .= $row["Naam"] . "<br>";
        }
    } else {
        echo "All customers have made orders.";
    }

    $west = "SELECT COUNT(Werelddeel) as aantal_westEU FROM bestemmingen where Werelddeel = 'West-Europa'";
    $result = $conn->query($west);

    while( $row = $result->fetch_assoc() ) {
        $result_west .= $row["aantal_westEU"] ;
    }

    $aziePrijs = "SELECT `boekingen`.`Aantal volwassenen`AS `adults` , `boekingen`.`Aantal kinderen` as `kids`, `best`.`Bestemmingcode` , reizen.Reisnummer, reizen.`Prijs per persoon` as `prijs pp` 
    FROM `bestemmingen` as `best`
    INNER JOIN `reizen`  ON `reizen`.`Bestemmingcode`=`best`.`Bestemmingcode`
    INNER JOIN `boekingen` ON boekingen.Reisnummer = reizen.Reisnummer
    WHERE `best`.`Werelddeel` = 'Azie'";

    $result_prijs = $conn->query($aziePrijs);

    $result = [];

    while ($row = $result_prijs->fetch_assoc() ) {
        $result[] = ( $row["adults"] + $row["kids"] ) * $row["prijs pp"];
    }

    $result_prijs = array_sum($result);

    $volw_kind_query = "SELECT `boek`.`Klantnummer` as `nummer`, `klanten`.`Naam` as `naam`
    FROM `klanten`
    INNER JOIN `boekingen` as `boek` ON `klanten`.`Klantnummer` = `boek`.`Klantnummer` 
    WHERE `boek`.`Aantal kinderen` > 0
    ORDER BY nummer";

    $volw_kind_result = $conn->query($volw_kind_query);

    while ($row = $volw_kind_result->fetch_assoc()) {
        $volw_kind .= $row["nummer"] . " &nbsp&nbsp" . $row["naam"]. "<br>";
    }

    $aantalRijzen_query = "SELECT COUNT(Vertrekdatum) as aantal_reizen FROM `reizen`";
    $aantalRijzen_result = $conn->query($aantalRijzen_query);

    while ($row = $aantalRijzen_result->fetch_assoc()) {
        $aantalRijzen = $row["aantal_reizen"];
    }

    $postcode_query = "SELECT Postcode FROM klanten WHERE Postcode LIKE '9%'";
    $postcode_result = $conn->query($postcode_query);

    while ( $row = $postcode_result->fetch_assoc()) {
        $postcode .= $row["Postcode"]. "<br>";
    }

    $woonplaats_query = "SELECT `Plaats`, `Naam` FROM `klanten` ORDER BY `Plaats`";
    $woonplaats_result = $conn->query($woonplaats_query);

    $woonplaats .= "<table>";
    while ($row = $woonplaats_result->fetch_assoc()) {
        $woonplaats .= "<tr><td>" . $row["Plaats"] . "</td><td>" . $row["Naam"] . "</td></tr>";
    }
    $woonplaats .= "</table>";

        $boekdatum_query =  "SELECT DATE(boekingen.`Boekdatum`) as boek, klanten.`Naam` as naam
        FROM klanten
        INNER JOIN `boekingen` ON klanten.Klantnummer = boekingen.Klantnummer 
        WHERE `Boekdatum` < '1999-04-01'";
        $boekdatum_result = $conn->query($boekdatum_query);

        $boekdatum .= "<table>";
        while ( $row = $boekdatum_result->fetch_assoc() ) {
            $naam = explode(" ", $row["boek"]);
            $boekdatum .= "<tr><td>" .$row["naam"]. "</td><td>";
            $boekdatum .= $row["boek"] . "</td></tr>";
        }
        $boekdatum .= "</table>";

        $aantalDagen_query = "SELECT `reizen`.`Aantal dagen`, `bestemmingen`.`Werelddeel`, `klanten`.`Naam`
        FROM `bestemmingen`
        INNER JOIN `reizen` ON `bestemmingen`.`Bestemmingcode` = `reizen`.`Bestemmingcode`
        INNER JOIN `boekingen` ON `reizen`.`Reisnummer` = `boekingen`.`Reisnummer`
        INNER JOIN klanten ON `klanten`.`Klantnummer` = boekingen.`Klantnummer`
        WHERE `reizen`.`Aantal dagen` >= 15
        ORDER BY `reizen`.`Aantal dagen`";
        $aantalDagen_result = $conn->query($aantalDagen_query);

        $aantaldagen .= "<table>";
        while ($row = $aantalDagen_result->fetch_assoc() ) {
            $aantaldagen .= "<tr><td>" . $row['Aantal dagen'] . "</td><td>" . $row['Werelddeel'] .  "</td><td>" . $row['Naam'] ."</td></tr>";
        }
        $aantaldagen .= "</table>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3 style="margin: 0px;">Klanten uit rotterdam</h3>
    <?php echo $result_rotterdam;
          echo "aantal mensen uit rotterdam: " . $rotterdam_aantal;
    ?>
    <h3 style="margin: 0px;">Klanten zonder order</h3>
    <?php echo $no_order; ?>
    <h3 style="margin: 0px;">Aantal vluchten naar west europa</h3>
    <?php echo $result_west; ?>
    <h3 style="margin: 0px;">Prijs totaal naar Azie</h3>
    <?php echo "$". $result_prijs; ?>
    <h3 style="margin: 0px;">volwassenen met kinderen</h3>
    <?php echo $volw_kind; ?>
    <h3 style="margin: 0px;">Aantal reizen</h3>
    <?php echo $aantalRijzen; ?>
    <h3 style="margin: 0px;">Postcode begint met 9</h3>
    <?php echo $postcode; ?>
    <h3 style="margin: 0px;">Plaats gesorteerd</h3>
    <?php echo $woonplaats; ?>
    <h3 style="margin: 0px;">Voor april geboekt</h3>
    <?php echo $boekdatum; ?>
    <h3 style="margin: 0px;">Reis min 15 dagen</h3>
    <?php  echo $aantaldagen;         ?>

</body>
</html>