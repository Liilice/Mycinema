<?php
    $pdo = require_once("database.php");
    $_GET = filter_input_array(INPUT_GET, FILTER_VALIDATE_INT);
    $id = $_GET['id'];
    if ($id) {
        $statement = $pdo->prepare("
            SELECT user.firstname, user.lastname, user.email, subscription.name FROM membership 
            JOIN subscription ON membership.id_subscription = subscription.id 
            JOIN user ON membership.id_user = user.id
            WHERE user.id = $id");
        $statement->execute();
        $resultatFiltre = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    $statementSubscription = $pdo->prepare("SELECT name FROM subscription ORDER BY price DESC");
    $statementSubscription->execute();
    $resultat = $statementSubscription->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_POST = filter_input_array(INPUT_POST, [
            'subscription' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ]);
        $subscription = $_POST["subscription"];
        $statementName = $pdo->prepare("SELECT id FROM subscription WHERE name LIKE '$subscription'");
        $statementName->execute();
        $resultatName = $statementName->fetchAll(PDO::FETCH_ASSOC);
 
        $name = "";
        foreach($resultatName as $key => $value){
            $name .= $value["id"];
        }
        echo $name;
        $statementModif = $pdo->prepare("UPDATE membership SET id_subscription = $name WHERE id_user = $id");
        $statementModif->execute();
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
        <?php foreach($resultatFiltre as $key => $value):?>
            <div class="labelP">
                <label for="">Nom Prénom: </label>
                <p><?=$value["lastname"]. " ".$value["firstname"]?></p>
            </div>
            <div class="labelP">
                <label for="">Email: </label>
                <p><?=$value["email"]?></p>
            </div>
            <div class="labelP">
                <label for="">Subcription Actuel: </label>
                <p><?=$value["name"]?></p>
            </div>
        <?php endforeach; ?>
        <div class="labelP">
            <label for="subscription">Modifier par</label>
            <select name="subscription" id="subscription">
                <?php foreach($resultat as $key => $value):?>
                <?php foreach($value as $key2 => $value2):?>
                    <option value="<?=$value2?>"><?=$value2?></option>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn">Modifier</button>
    </form>
</body>
</html>