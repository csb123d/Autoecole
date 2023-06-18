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
        if (isset($_POST['seance']) && isset($_POST['eleve'])) {

            $idseance = $_POST['seance'];
            $ideleve = $_POST['eleve'];
            $note = -1;

            ?>
            <div class='message_retour message_retour_success'>
                <p>Données reçues :</p>
                <p>idSeance:
                    <?= $idseance ?>
                </p>
                <p>idEleve :
                    <?= $ideleve ?>
                </p>
            </div>
            <?php

            // Vérification de l'inscription de l'élève à la séance
            $query = "SELECT * FROM inscription WHERE idseance = $idseance AND ideleve = $ideleve";
            $result = mysqli_query($connect, $query);

            if (mysqli_num_rows($result) > 0) {
                ?>
                <div class='message_retour message_retour_error'>
                    <p>L'élève est déjà inscrit!</p>
                </div>
                <?php
            } else {
                $query = "SELECT EffMax, COUNT(*) AS effectif FROM seances JOIN inscription ON seances.idseance = inscription.idseance WHERE seances.idseance = $idseance";
                $result = mysqli_query($connect, $query);

                if ($result) {

                    $row = mysqli_fetch_assoc($result);
                    $effectifActuel = $row['effectif'];
                    $effectifMax = $row['EffMax'];

                    if ($effectifActuel < $effectifMax) {

                        $query = "INSERT INTO inscription (idseance, ideleve, note) VALUES ($idseance, $ideleve, $note) ON DUPLICATE KEY UPDATE note = $note";
                        $result = mysqli_query($connect, $query);

                        if ($result) {
                            ?>
                            <div class='message_retour message_retour_success'>
                                <p>L'élève est inscrit à la séance.
                                </p>
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
                            <p>Effectif maximum atteint !</p>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class='message_retour message_retour_error'>
                        <p>Une erreur est survenue :
                            <?= mysqli_error($connect) ?>
                        </p>
                    </div>
                    <?php
                }
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