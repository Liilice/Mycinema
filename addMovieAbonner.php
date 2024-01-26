<?php
    $pdo = require_once("database.php");
    $id = $_GET['id'];
    if ($id) {
        $statementUser = $pdo->prepare("SELECT firstname, lastname, email FROM user WHERE id = $id");
        $statementUser->execute();
        $resultatUser = $statementUser->fetchAll(PDO::FETCH_ASSOC);
    }
    CONST ERROR = "Le film n'existe pas.";
    $error = ['film' => '',];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_POST = filter_input_array(INPUT_POST, [
            'film' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ]);
        $film = $_POST["film"];
        $statementFilm = $pdo->prepare("SELECT id FROM movie WHERE title LIKE '%$film%'");
        $statementFilm->execute();
        $resultatFilm = $statementFilm->fetchAll(PDO::FETCH_ASSOC);
        $idMovie = $resultatFilm[0]["id"];

        if(empty($resultatFilm)){
            $error['film'] = ERROR;
        }else{
            $statementMembership = $pdo->query("SELECT id FROM membership WHERE id_user = $id");
            $resultatMembership = $statementMembership->fetchAll(PDO::FETCH_ASSOC);
            $idMembership = $resultatMembership[0]["id"];

            $statementMovieSchedule = $pdo->prepare("SELECT id FROM movie_schedule WHERE id_movie = $idMovie");
            $statementMovieSchedule->execute();
            $resultatMovieSchedule = $statementMovieSchedule->fetchAll(PDO::FETCH_ASSOC);
            $idSession = $resultatMovieSchedule[0]["id"];
        
            $statementAddMovie = $pdo->prepare("INSERT INTO membership_log(id_membership, id_session) VALUES ($idMembership, $idSession)");
            $statementAddMovie->execute();
            header('Location: successful.php');
            // echo '<pre>';
            // print_r($resultatMovieSchedule);
            // echo '</pre>';
        }
        
        // $statementAddAbonnee = $pdo->prepare("INSERT INTO membership(id_user, id_subscription, date_begin) VALUES ($id, $name, NOW())");
        // $statementAddAbonnee->execute();
        // header('Location: successful.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST" class="CRUD">
        <?php foreach($resultatUser as $key => $value):?>
            <div class="labelP">
                <label for="">Nom Prénom: </label>
                <p><?=$value["lastname"]. " ".$value["firstname"]?></p>
            </div>
            <div class="labelP">
                <label for="">Email: </label>
                <p><?=$value["email"]?></p>
            </div>
        <?php endforeach; ?>
        <div class="labelP">
                <label for="">Nom du film: </label>
                <input type="search" name="film" placeholder="film">
        </div>
        <?= $error['film'] ? '<p class="textError">' . $error['film'] . '</p>' : "" ?>
        <button type="submit" class="btn">Ajouter</button>
    </form>
</body>
</html>