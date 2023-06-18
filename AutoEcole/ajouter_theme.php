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
    //la ligne suivante permet d'éviter les problèmes d'accent entre la page ouèbe et le serveur mysql
    mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['nom']) && isset($_POST['descriptif'])) {

            $nom = $_POST['nom'];
            $descriptif = $_POST['descriptif'];

            $nom = mysqli_real_escape_string($connect, $nom);
            $descriptif = mysqli_real_escape_string($connect, $descriptif);

            $query = "SELECT * FROM themes WHERE nom = '$nom'";
            $result = mysqli_query($connect, $query);

            if (mysqli_num_rows($result) > 0) {
                $query = "UPDATE themes SET supprime = 0 WHERE nom = '$nom'";
                $result = mysqli_query($connect, $query);

                if ($result) {
                    ?>
                    <div class='message_retour message_retour_success'>
                        <p>Le thème a été réactivé, il existait déjà.</p>
                    </div>
                    <?php
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
                $query = "INSERT INTO themes (idtheme, nom, supprime, descriptif) VALUES (NULL, " . "'$nom'" . ", " . "'0'" . ", " . "'$descriptif'" . ")";
                $result = mysqli_query($connect, $query);

                ?>
                <div class='message_retour message_retour_success'>
                    <p>Données reçues :</p>
                    <p>Nom :
                        <?= $nom ?>
                    </p>
                    <p>Descriptif:
                        <?= $descriptif ?>
                    </p>
                </div>
                <?php

                if ($result) {
                    ?>
                    <div class='message_retour message_retour_success'>
                        <p>Le thème a été ajouté avec succès !</p>
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