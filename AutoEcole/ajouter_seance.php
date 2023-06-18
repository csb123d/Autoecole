<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    require 'retour_acceuil.php';
    require 'connect_database.php';
    $connect = connectToDatabase();

    mysqli_set_charset($connect, 'utf8');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['theme']) && isset($_POST['DateSeance']) && isset($_POST['EffMax'])) {
            $idtheme = $_POST['theme'];
            $dateSeance = $_POST['DateSeance'];
            $effmax = $_POST['EffMax'];

            $query = "SELECT * FROM seances WHERE idtheme = '$idtheme' AND dateSeance = '$dateSeance'";
            $result = mysqli_query($connect, $query);

            if (mysqli_num_rows($result) > 0) {
                ?>
                <div class='message_retour message_retour_error'>
                    <p>Une séance avec le même thème et la même date existe déjà.</p>
                </div>
                <?php
                mysqli_close($connect);
                exit;
            }

            ?>
            <div class='message_retour message_retour_success'>
                <p>Données reçues :</p>
                <p>ID Thème :
                    <?= $idtheme ?>
                </p>
                <p>Date de la séance :
                    <?= $dateSeance ?>
                </p>
                <p>Effectif maximum :
                    <?= $effmax ?>
                </p>
            </div>
            <?php

            $query = "INSERT INTO seances (idtheme, dateSeance, effmax) VALUES ('$idtheme', '$dateSeance', '$effmax')";
            $result = mysqli_query($connect, $query);

            if ($result) {
                ?>
                <div class='message_retour message_retour_success'>
                    <p>La séance a été ajoutée avec succès !</p>
                </div>
                <?php
                retour_acceuil();

                
            } else {
                ?>
                <div class='message_retour message_retour_error'>
                    <p>Une erreur est survenue :
                        <?= mysqli_error($connect) ?>
                    </p>
                </div>
                <?php
            }
        } else {
            ?>
            <div class='message_retour message_retour_error'>
                <p>Donnée(s) manquante(s)</p>
            </div>
            <?php
        }

    } else {
        ?>
        <div class='message_retour message_retour_error'>
            <p>Pas de protocol POST</p>
        </div>
        <?php
    }

    mysqli_close($connect);
    ?>

</body>

</html>