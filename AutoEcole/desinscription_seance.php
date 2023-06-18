<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<h1>Désinscription d'une séance</h1>


    <?php
    require 'connect_database.php';
    $connect = connectToDatabase();

    mysqli_set_charset($connect, 'utf8');

    // Récupération des élèves inscrits à une séance avec les informations associées
    $query = "SELECT inscription.ideleve, eleves.nom, eleves.prenom, inscription.idseance, themes.nom AS theme
        FROM inscription
        JOIN eleves ON inscription.ideleve = eleves.ideleve
        JOIN seances ON inscription.idseance = seances.idseance
        JOIN themes ON seances.idtheme = themes.idtheme
        WHERE themes.supprime = 0"; // Sélectionne seulement les séances avec des thèmes actifs
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {

        ?>
        <form action="desinscrire_seance.php" method="POST">

            <div class="mb-3">
                <label class="form-label" for="inscription">Élèves :</label>
                <select class="form-select" name="inscription" id="inscription" required>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <option value=<?= $row['ideleve'] ?>|<?= $row['idseance'] ?>>Élève : <?= $row['nom'] ?> - <?= $row['prenom'] ?> - Thème : <?= $row['theme'] ?> </option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Valider</button>
        </form>

        <?php

    } else {

        ?>
        <div class='message_retour message_retour_error'>
            <p>Aucun Élève inscrit</p>
        </div>
        <?php
    }

    ?>

</body>

</html>