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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['seance'])) {

            $idseance = $_POST['seance'];

            ?>
            <div class='message_retour message_retour_success'>
                <p>Données reçues :</p>
                <p>ID Thème :
                    <?= $idseance ?>
                </p>
                <?php

                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'note_') === 0) {
                        $ideleve = substr($key, strlen('note_'));
                        $note = $value;
                        ?>
                        <p>Note :
                            <?= $note ?>
                        </p>
                        <?php
                        $query = "SELECT * FROM inscription WHERE idseance = $idseance AND ideleve = $ideleve";
                        $result = mysqli_query($connect, $query);

                        if (mysqli_num_rows($result) > 0) {
                            $query = "UPDATE inscription SET note = $note WHERE idseance = $idseance AND ideleve = $ideleve";
                            mysqli_query($connect, $query);
                        }
                    }
                }
                ?>
            </div>
            <?php

            ?>
            <div class='message_retour message_retour_success'>
                <p>Les notes ont bien été enrengistrées</p>
            </div>
            <?php
            retour_acceuil();

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

    mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
    
    ?>

</body>

</html>