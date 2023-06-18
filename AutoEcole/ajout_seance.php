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
    $result = mysqli_query($connect, "SELECT * FROM themes");
    
    ?>
    <h1>Ajouter une séance</h1>
    <form action="ajouter_seance.php" method="post">
        <div class="mb-3">
            <!-- Input Nom -->
            <label class="form-label" for="theme">Thèmes :</label>
            <select class="form-select" name="theme" id="theme" required>
                <?php
                while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                    if ($row[2] == 0) {
                        echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                    }
                }
                mysqli_close($connect);
                ?>
            </select>
        </div>
        <div class="mb-3">
            <!-- Date de naissance -->
            <label class="form-label" for="DateSeance">Date de la séance :</label>
            <input class="form-control" type="date" name="DateSeance" id="DateSeance" required>
        </div>
        <div class="mb-3">
            <!-- Date de naissance -->
            <label class="form-label" for="EffMax">Effectif maximum :</label>
            <input class="form-control" type="number" name="EffMax" id="EffMax" required>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</body>

</html>