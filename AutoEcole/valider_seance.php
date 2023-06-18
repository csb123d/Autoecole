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
    require 'connect_database.php';
    $connect = connectToDatabase();



    mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['seance'])) {

            $idSeance = $_POST['seance'];

            ?>
            <div class='message_retour message_retour_success'>
                <p>Données reçues :</p>
                <p>ID Thème :
                    <?= $idSeance ?>
                </p>
            </div>
            <?php

            // Récupération des élèves inscrits à la séance
            $query = "SELECT inscription.ideleve, eleves.nom, eleves.prenom, inscription.note
            FROM inscription
            INNER JOIN eleves ON inscription.ideleve = eleves.ideleve
            WHERE inscription.idseance = $idSeance";
            $result = mysqli_query($connect, $query);

            if (mysqli_num_rows($result) > 0) {
                ?>
                <form action="noter_eleves.php" method="POST">
                    <input type="hidden" name="seance" value=<?= $idSeance ?>>

                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {  
                        ?>
                        <div class="mb-3">
                            <label class="form-label" for="note_<?= $row['ideleve'] ?>"><?= $row['nom'] ?> <?= $row['prenom'] ?></label>
                            <?php
                                if ($row['note'] != -1) {
                                    ?>
                                    <input class="form-control" type='number' min='0' max='40' type="text" value=<?=$row['note']?> name="note_<?= $row['ideleve'] ?>"
                                        id="note_<?= $row['ideleve'] ?>">
                                    <?php
                                } else {
                                    ?>
                                    <input class="form-control" type='number' min='0' max='40' type="text" name="note_<?= $row['ideleve'] ?>"
                                        id="note_<?= $row['ideleve'] ?>">
                                    <?php
                                }
                            ?>
                            
                        </div>

                        <?php
                    }
                    ?>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </form>
                <?php
            } else {
                ?>
                <div class='message_retour message_retour_error'>
                    <p>Aucun élèves</p>
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