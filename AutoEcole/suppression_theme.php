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
        if (isset($_POST['theme'])) {

            $idtheme = $_POST['theme'];


            // Vérifier si le thème existe dans la base de données
            $query = "UPDATE themes SET supprime = 1 WHERE idtheme = '$idtheme'";
            $result = mysqli_query($connect, $query);

            ?>
                <div class='message_retour message_retour_success'>
                    <p>Données reçues :</p>
                    <p>thème :
                        <?= $idtheme ?>
                    </p>
                </div>
                <?php

                if ($result) {
                    ?>
                    <div class='message_retour message_retour_success'>
                        <p>Le thème a été supprimé avec succès !</p>
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