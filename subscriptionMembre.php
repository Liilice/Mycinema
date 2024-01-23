<?php
    $pdo = require_once("database.php");
    $_GET = filter_input_array(INPUT_GET, FILTER_VALIDATE_INT);
    $id = $_GET['id'];
    $statementSubscription = $pdo->prepare("SELECT name FROM subscription ORDER BY price DESC");
    $statementSubscription->execute();
    $resultat = $statementSubscription->fetchAll(PDO::FETCH_ASSOC);
    if ($id) {
        $statementUser = $pdo->prepare("SELECT firstname, lastname, email FROM user WHERE id = $id");
        $statementUser->execute();
        $resultatUser = $statementUser->fetchAll(PDO::FETCH_ASSOC);

        $statement = $pdo->prepare("
            SELECT user.firstname, user.lastname, user.email, subscription.name FROM membership 
            JOIN subscription ON membership.id_subscription = subscription.id 
            JOIN user ON membership.id_user = user.id
            WHERE user.id = $id");
        $statement->execute();
        $resultatFiltre = $statement->fetchAll(PDO::FETCH_ASSOC);
        if(empty($resultatFiltre)){
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
                $statementAddAbonnee = $pdo->prepare("INSERT INTO membership(id_user, id_subscription, date_begin) VALUES ($id, $name, NOW())");
                $statementAddAbonnee->execute();
                header('Location: abonnement.php');
            }

        }else{
            header('Location: member.php');
        }
    }
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
        <?php foreach($resultatUser as $key => $value):?>
            <p>Nom Prénom: <?=$value["lastname"]. " ".$value["firstname"]?></p>
            <p>Email: <?=$value["email"]?></p>
        <?php endforeach; ?>
        <label for="subscription">Selectionner un abonnement</label>
        <select name="subscription" id="subscription">
            <?php foreach($resultat as $key => $value):?>
            <?php foreach($value as $key2 => $value2):?>
                <option value="<?=$value2?>"><?=$value2?></option>
            <?php endforeach; ?>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn">S'abonner</button>
    </form>
</body>
</html>