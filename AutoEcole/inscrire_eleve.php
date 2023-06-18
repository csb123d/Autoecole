<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<h1>Inscrire un élève</h1>
    <?php
    require 'connect_database.php';
    $connect = connectToDatabase();

    mysqli_set_charset($connect, 'utf8');

    // Récupération des séances avec les thèmes actifs
    $seancesQuery = "SELECT seances.idseance, themes.nom FROM seances JOIN themes ON seances.idtheme = themes.idtheme WHERE themes.supprime = 0";
    $seances = mysqli_query($connect, $seancesQuery);

    // Récupération des élèves
    $elevesQuery = "SELECT ideleve, nom, prenom FROM eleves";
    $eleves = mysqli_query($connect, $elevesQuery);

    mysqli_close($connect);
    ?>
    <form action="inscription_eleve.php" method="POST">


        <div class="mb-3">
            <label class="form-label" for="seance">Séances :</label>
            <select class="form-select" name="seance" id="seance" required>
                <?php
                while ($row = mysqli_fetch_array($seances)) {
                    ?>
                    <option value=<?= $row['idseance'] ?>><?= $row['nom'] ?> </option>
                    <?php
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" for="eleve">Élèves :</label>
            <select class="form-select" name="eleve" id="eleve" required>
                <?php
                while ($row = mysqli_fetch_array($eleves)) {
                    ?>
                    <option value=<?= $row['ideleve'] ?>><?= $row['nom'] ?> - <?= $row['prenom'] ?> </option>
                    <?php
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Inscrire</button>
    </form>
</body>

</html>