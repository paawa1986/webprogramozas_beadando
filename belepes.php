<?php
    if(isset($_POST['felhasznalo']) && isset($_POST['jelszo'])) {
        try {
            // Kapcsolódás
            $dbh = new PDO('mysql:host=localhost;dbname=paawa', 'paawa', 'xxxxx5',
                            array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
            
            // Felhsználó keresése
            $sqlSelect = "select id, csaladi_nev, uto_nev from felhasznalok where bejelentkezes = :bejelentkezes and jelszo = sha1(:jelszo)";
            $sth = $dbh->prepare($sqlSelect);
            $sth->execute(array(':bejelentkezes' => $_POST['felhasznalo'], ':jelszo' => $_POST['jelszo']));
            $row = $sth->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            echo "Hiba: ".$e->getMessage();
        }      
    }
    else {
        header("Location: index.html");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Belepes</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php if(isset($row)) { ?>
            <?php if($row) { ?>
                <h1>Bejelentkezett:</h1>
                Azonosito: <strong><?= $row['id'] ?></strong><br><br>
                Nev: <strong><?= $row['csaladi_nev']." ".$row['uto_nev'] ?></strong>
				<meta http-equiv='refresh' content='2; URL=fooldal.html'>
				
            <?php } else { ?>
                <h1>A bejelentkezes nem sikerult!</h1>
				<meta http-equiv='refresh' content='2; URL=index.html'>
                <a href="index.html" >Probalja ujra!</a>
            <?php } ?>
        <?php } ?>
    </body>
</html>