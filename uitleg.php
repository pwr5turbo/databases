<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "school";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT naam, roepnaam, straat, postcode FROM cursist";
    $result = $conn->query($sql);
    

        echo "<table>";
    while( $row = $result->fetch_assoc() ) {
        echo "<tr>";
        echo "<td>" . $row["naam"] ."</td>";
        echo "<td>". $row["roepnaam"] ."</td>";
        echo "<td>". $row["straat"] ."</td>";
        echo "<td>". $row["postcode"] ."</td>";

        echo "<tr>";

    }
        echo "<table>";

        $sql = "INSERT INTO cursist(cursistnr, naam, roepnaam, straat, postcode, plaats, geslacht, geb_datum)
         VALUES ('8','Lars','Bonsink','koploper','8265TX','kampen','Man','2005-02-07');";

        $conn->multi_query($sql);

    

    
    $conn->close();
    ?>
