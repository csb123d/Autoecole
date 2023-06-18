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
    date_default_timezone_set('Europe/Paris');
    $date = date("Y-m-d");

    require 'retour_acceuil.php';
    require 'connect_database.php';
    $connect = connectToDatabase();

    mysqli_set_charset($connect, 'utf8');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['dateDeNaissance'])) {


            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $dateDeNaissance = $_POST['dateDeNaissance'];

            $interval = (new DateTime())->diff(new DateTime($dateDeNaissance));
            $age = $interval->y;

            if ($age < 18) {
                ?>
                <div class='message_retour message_retour_error'>
                    <p>L'élève doit avoir 18 ans !</p>
                </div>
                <?php
                exit;
            }

            ?>
            <div class='message_retour message_retour_success'>
                <p>Données reçues :</p>
                <p>Nom:
                    <?= $nom ?>
                </p>
                <p>Prénom :
                    <?= $prenom ?>
                </p>
                <p>Date de naissance :
                    <?= $dateDeNaissance ?>
                </p>
            </div>
            <?php

            $nom = mysqli_real_escape_string($connect, $nom);
            $prenom = mysqli_real_escape_string($connect, $prenom);

            $query = "INSERT INTO eleves (ideleve, nom, prenom, dateNaiss, dateinscription) VALUES (NULL, " . "'$nom'" . ", " . "'$prenom'" . ", " . "'$dateDeNaissance'" . ", " . "'$date'" . ")";
            $result = mysqli_query($connect, $query);
            if ($result) {
                ?>
                <div class='message_retour message_retour_success'>
                    <p>L'élève a été ajouté avec succès !</p>
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