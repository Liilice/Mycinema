<?php 
    $pdo = require_once("database.php");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_POST = filter_input_array(INPUT_POST, [
            'member' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'historiqMember' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ]);
        $member = $_POST['member'];
        if(isset($member) && $member !== ""){
            $statement = $pdo->prepare("
                SELECT firstname, lastname, id FROM user 
                WHERE firstname LIKE '%$member%' OR lastname LIKE '%$member%';");
            $statement->execute();
            $resultatFiltre = $statement->fetchAll();
        }
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
    <h1>My Cinema - Site de référencement des clients</h1>
    <div class="containerLink">
        <h2><a href="index.php">Films</a></h2>
        <h2><a href="member.php">Clients</a></h2>
        <h2><a href="abonnement.php">Abonnement</a></h2>
        <h2><a href="admin.php">Admin</a></h2>
    </div>
    <form action="" method="POST">
        <input type="text" name="member" placeholder="member">
        <!-- <input type="date" name="dateProjection" min="2018-01-01" max="2018-12-31" /> -->
        <button type="submit">Rechercher</button>
    </form>
    <main class="containerMember">
        <div>
            <h2>Member</h2>
            <ul>
                <?php foreach($resultatFiltre as $key => $value):?>
                    <li class="li d">
                        <p><?=$value["firstname"]." ".$value["lastname"]?></p>
                        <a href="subscriptionMembre.php?id=<?= $value['id']  ?>">
                            <button class="btn">Souscrire à un abonnement</button>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>
</body>
</html>