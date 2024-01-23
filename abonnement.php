<?php 
    $pdo = require_once("database.php");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_POST = filter_input_array(INPUT_POST, [
            'abonner' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ]);
        $abonner = $_POST['abonner'];
        if(isset($abonner) && $abonner !== ""){
            $statement = $pdo->prepare("
                SELECT user.firstname, user.lastname, user.id, subscription.name FROM user 
                JOIN membership ON user.id = membership.id_user 
                JOIN subscription ON membership.id_subscription = subscription.id
                WHERE user.firstname LIKE '%$abonner%' OR user.lastname LIKE '%$abonner%';");
            $statement->execute();
            $resultatFiltre = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    $id = $_GET['id'];
    if(isset($id) && $id !== ""){
        $statementhistoriqMember = $pdo->prepare("
            SELECT user.firstname, user.lastname, user.email, subscription.name, movie.title FROM user 
            JOIN membership ON user.id = membership.id_user 
            JOIN subscription ON membership.id_subscription = subscription.id 
            JOIN membership_log ON membership.id = membership_log.id_membership 
            JOIN movie_schedule ON membership_log.id_session = movie_schedule.id 
            JOIN movie ON movie_schedule.id_movie = movie.id
            WHERE user.id = $id;");
        $statementhistoriqMember->execute();
        $resultatFiltreHistorique = $statementhistoriqMember->fetchAll(PDO::FETCH_ASSOC);
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
    <h1>My Cinema - Site de référencement des abonnements</h1>
    <div class="containerLink">
        <h2><a href="index.php">Films</a></h2>
        <h2><a href="member.php">Clients</a></h2>
        <h2><a href="abonnement.php">Abonnement</a></h2>
        <h2><a href="admin.php">Admin</a></h2>
    </div>
    <form action="" method="POST">
        <input type="text" name="abonner" placeholder="abonner">
        <button type="submit">Rechercher</button>
    </form>
    <main class="containerMember">
        <div>
            <h2>Abonné</h2>
            <div class="containerHisto">
                <ul>
                    <?php foreach($resultatFiltre as $key => $value):?>
                        <li class="li">
                            <span><?=$value["firstname"]." ".$value["lastname"]." ".$value["name"] ?></span>
                            <a href="abonnement.php?id=<?= $value['id']  ?>">
                                <button class="btn">Historique</button>
                            </a>
                            <a href="editAbonner.php?id=<?= $value['id']  ?>">
                                <button class="btn btn-primary">Modifier l'abonnement</button>
                            </a>
                            <a href="deleteAbonner.php?id=<?= $value['id']  ?>">
                                <button class="btn btn-danger">Supprimer l'abonnement</button>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div>
            <h2>Historique des films vus par l'abonné</h2>
            <div class="containerHisto">
                <ul>
                    <h3>Nom Prénom</h3>
                    <?php foreach($resultatFiltreHistorique as $key => $value):?>
                        <li class="li"><?=$value["firstname"]." ".$value["lastname"]?></li>
                    <?php endforeach; ?>
                </ul>
                <ul>
                    <h3>Email</h3>
                    <?php foreach($resultatFiltreHistorique as $key => $value):?>
                        <li class="li"><?=$value["email"]?></li>
                    <?php endforeach; ?>
                </ul>
                <ul>
                    <h3>Subscription</h3>
                    <?php foreach($resultatFiltreHistorique as $key => $value):?>
                        <li class="li"><?=$value["name"]?></li>
                    <?php endforeach; ?>
                </ul>
                <ul>
                    <h3>Films</h3>
                    <?php foreach($resultatFiltreHistorique as $key => $value):?>
                        <li class="li"><?=$value["title"]?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </main>
</body>
</html>