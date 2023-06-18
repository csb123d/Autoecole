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

    require 'connect_database.php';
    $connect = connectToDatabase();

    mysqli_set_charset($connect, 'utf8');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['dateDeNaissance'])) {


            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $dateDeNaissance = $_POST['dateDeNaissance'];

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

            $query = "SELECT * FROM eleves WHERE nom = '$nom' AND prenom = '$prenom'";
            $result = mysqli_query($connect, $query);

            if (!$result) {
                ?>
                <div class='message_retour message_retour_error'>
                    <p>Une erreur est survenue :
                        <?= mysqli_error($connect) ?>
                    </p>
                </div>
                <?php
                exit();
            } else {
                if (mysqli_num_rows($result) > 0) {
                    ?>
                    <form action="ajouter_eleve.php" method="post">
                        L'élève existe déjà voulez-vous tous de même l'enrengistrer ?
                        <!-- Input Nom -->
                        <input type="hidden" class="form-control" type="text" value=<?= $nom ?> name="nom" id="nom" required>
                        <!-- Input Prénom -->
                        <input type="hidden" class="form-control" type="text" value=<?= $prenom ?> name="prenom" id="prenom" required>
                        <!-- Date de naissance -->
                        <input type="hidden" class="form-control" type="date" value=<?= $dateDeNaissance ?> name="dateDeNaissance"
                            id="dateDeNaissance" required>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </form>
                    <?php
                } else {
                    ?>
                    <form action="ajouter_eleve.php" method="post">
                        Confirmer l'ajout ?
                        <!-- Input Nom -->
                        <input type="hidden" class="form-control" type="text" value=<?= $nom ?> name="nom" id="nom" required>
                        <!-- Input Prénom -->
                        <input type="hidden" class="form-control" type="text" value=<?= $prenom ?> name="prenom" id="prenom" required>
                        <!-- Date de naissance -->
                        <input type="hidden" class="form-control" type="date" value=<?= $dateDeNaissance ?> name="dateDeNaissance"
                            id="dateDeNaissance" required>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </form>
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

    ?>

</body>

</html>