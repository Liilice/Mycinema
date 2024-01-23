<?php
    $pdo = require_once("database.php");
    $id = $_GET['id'];
    $statementIdRoom = $pdo->prepare("SELECT id FROM room");
    $statementIdRoom->execute();
    $resultatIdRoom = $statementIdRoom->fetchAll(PDO::FETCH_ASSOC);

    $statementFilm = $pdo->prepare("SELECT title FROM movie WHERE id = $id");
    $statementFilm->execute();
    $title = $statementFilm->fetchAll(PDO::FETCH_ASSOC);

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_POST = filter_input_array(INPUT_POST, [
            'datetime' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'idRoom' => FILTER_SANITIZE_NUMBER_INT,
        ]);
        $idRoom = $_POST["idRoom"];
        $date = $_POST["datetime"];
        $date.= ":00";      
        $date = $_POST["datetime"];
        $statementAddMovie = $pdo->prepare("INSERT INTO movie_schedule(id_movie, id_room, date_begin) VALUES($id, $idRoom, '$date')");
        $statementAddMovie->execute();
        header('Location: successful.php');
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
        <div class="labelInput">
            <label for="nom">Nom du film</label>
            <?php foreach($title as $key => $value):?>
                <input type="text" name="nom" value="<?=$value["title"]?>">
            <?php endforeach; ?>
        </div>
        <div class="labelInput">
            <label for="idMovie">ID du film</label>
            <input type="text" name="idMovie" value="<?=$id?>">
        </div>
        <div class="labelInput">
            <label for="idRoom">Room</label>
            <select name="idRoom" id="idRoom">
                <?php foreach($resultatIdRoom as $key => $value):?>
                    <option value="<?=$value["id"]?>"><?=$value["id"]?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="labelInput">
            <label for="date">Date de diffusion</label>
            <input type="datetime-local" name="datetime">
        </div>
        <button type="submit" class="btn">Envoyer</button>
    </form>
</body>
</html>