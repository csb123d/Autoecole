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
        if (isset($_POST['inscription'])) {


            $inscription = $_POST["inscription"];

            ?>
            <div class='message_retour message_retour_success'>
                <p>Données reçues :</p>
                <p>Inscription:
                    <?= $inscription ?>
                </p>
            </div>
            <?php

            $data = explode("|", $inscription);
            $ideleve = $data[0];
            $idseance = $data[1];

            $query = "DELETE FROM inscription WHERE ideleve = '$ideleve' AND idseance = '$idseance'";
            $result = mysqli_query($connect, $query);

            if ($result) {

                ?>
                <div class='message_retour message_retour_success'>
                    <p>L'élève est désinscrit !</p>
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

    ?>

</body>

</html>