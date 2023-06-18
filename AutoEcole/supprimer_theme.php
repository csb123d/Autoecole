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
    $query = "SELECT idtheme, nom FROM themes WHERE supprime = '0'";
    $result = mysqli_query($connect, $query);


    ?>
    <h1>Supprimer un thème</h1>
    <form action="suppression_theme.php" method="post">
        <div class="mb-3">
            <label class="form-label" for="theme">Thèmes :</label>
            <select class="form-select" name="theme" id="theme" required>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                        echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                    }
                } else {
                    echo "<option disabled>Aucun thème </option>";
                }
                mysqli_close($connect);
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>

</body>

</html>