<?php
    $pdo = require_once("database.php");
    $id = $_GET['id'];
    echo $id;
    $statementIdRoom = $pdo->prepare("SELECT id FROM room");
    $statementIdRoom->execute();
    $resultatIdRoom = $statementIdRoom->fetchAll(PDO::FETCH_ASSOC);
    // echo '<pre>';
    // print_r($resultatIdRoom);
    // echo '</pre>';
    $date = $_POST["datetime"];
    echo $date;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <div>
            <label for="nom">Nom du film</label>
            <input type="text" name="nom">
        </div>
        <div>
            <label for="idMovie">ID du film</label>
            <input type="text" name="idMovie">
        </div>
        <div>
            <label for="idRoom">Room</label>
            <select name="idRoom" id="idRoom">
                <option value="defaut">Defaut</option>
                <?php foreach($resultatIdRoom as $key => $value):?>
                    <option value="<?=$value["id"]?>"><?=$value["id"]?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <label for="date">Date de diffusion</label>
        <input type="datetime-local" name="datetime">
        <button>Envoyer</button>
    </form>
</body>
</html>