<?php
    $pdo = require_once("database.php");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_POST = filter_input_array(INPUT_POST, [
            'films' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ]);
        $films = $_POST['films'] ? $_POST['films'] : '';
        $statement = $pdo->prepare("SELECT id, title FROM movie WHERE title LIKE '%$films%'");
        $statement->execute();
        $resultatFiltre = $statement->fetchAll(PDO::FETCH_ASSOC);
        // echo '<pre>';
        // print_r($resultatFiltre);
        // echo '</pre>';
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
    <h1>My Cinema - Planning des films</h1>
    <div class="containerLink">
        <h2><a href="index.php">Films</a></h2>
        <h2><a href="member.php">Clients</a></h2>
        <h2><a href="abonnement.php">Abonnement</a></h2>
        <h2><a href="admin.php">Admin</a></h2>
    </div>
    <form action="" method="POST">
        <input type="text" name="films" placeholder="films">
        <button type="submit">Rechercher</button>
    </form>
    <main class="containerMember">
        <div>
            <h2>Films</h2>
            <ul>
                <?php foreach($resultatFiltre as $key => $value):?>
                    <li class="li d">
                       <p><?=$value["title"]?></p>
                       <a href="movieAdd.php?id=<?= $value['id']  ?>">
                            <button class="btn">Ajouter au planning</button>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>
</body>
</html>