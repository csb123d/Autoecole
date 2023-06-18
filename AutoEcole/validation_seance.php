<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Valider une séance</h1>

    <?php
    require 'connect_database.php';
    $connect = connectToDatabase();

    mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
    
    $date = date('Y-m-d');
    $query = "SELECT * FROM seances WHERE dateSeance < '$date'";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {

        ?>

        <form action="valider_seance.php" method="POST">


            <div class="mb-3">
                <label class="form-label" for="seance">Séances :</label>
                <select class="form-select" name="seance" id="seance" required>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        var_dump($row)
                        ?>
                        <option value=<?= $row['idseance'] ?>><?= $row['DateSeance'] ?> </option>
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
            <p>Aucune séance passée</p>
        </div>
        <?php
    }


    ?>

</body>

</html>