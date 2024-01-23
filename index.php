<?php 
    $pdo = require_once("database.php");
    $statementGenre = $pdo->prepare('SELECT name FROM genre');
    $statementGenre->execute();
    $resultat = $statementGenre->fetchAll(PDO::FETCH_ASSOC); 

    // $dateProjection = $_POST['dateProjection'];
    // $dateProjectionReformater = str_replace("T", " ", $dateProjection);
    // echo $dateProjectionReformater;

    // if($dateProjection){
    //     // recuperer tout les films par date de pprojection
    //     $statement = $pdo->prepare("SELECT movie.title, movie_schedule.date_begin FROM movie JOIN movie_schedule ON movie.id = movie_schedule.id_movie WHere movie_schedule.date_begin LIKE '$dateProjection%';");
    //     $statement->execute();
    //     $resultatFiltre = $statement->fetchAll(PDO::FETCH_ASSOC);
    //     // AJOUTER UNE RECHERCHE AVEC LHEURE AUSSI
    //     // echo '<pre>';
    //     // print_r($resultatFiltre);
    //     // echo '</pre>';
    // }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_POST = filter_input_array(INPUT_POST, [
            'genre' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'rechercher' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'distributor' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ]);
        $search = $_POST['genre'] && $_POST['genre']!=="defaut" ? $_POST['genre']: '';
        $distributor = $_POST['distributor'] ? $_POST['distributor'] : '';
        $rechercher = $_POST['rechercher'] ? $_POST['rechercher'] : '';
        $statement = $pdo->prepare("
            SELECT movie.title, genre.name, distributor.name FROM distributor 
            JOIN movie ON distributor.id = movie.id_distributor 
            JOIN movie_genre ON movie.id = movie_genre.id_movie 
            JOIN genre ON movie_genre.id_genre = genre.id 
            WHERE genre.name LIKE '%$search%' 
            AND movie.title LIKE '%$rechercher%' 
            AND distributor.name LIKE '%$distributor%';");
        $statement->execute();
        $resultatFiltre = $statement->fetchAll();
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
    <h1>My Cinema - Site de référencement des films</h1>
    <div class="containerLink">
        <h2><a href="index.php">Films</a></h2>
        <h2><a href="member.php">Clients</a></h2>
        <h2><a href="abonnement.php">Abonnement</a></h2>
        <h2><a href="admin.php">Admin</a></h2>
    </div>
    <form action="" method="POST">
        <input type="text" placeholder="rechercher" name="rechercher">
        <select name="genre" id="genre">
            <option value="defaut">Defaut</option>
            <?php foreach($resultat as $key => $value):?>
            <?php foreach($value as $key2 => $value2):?>
                <option value="<?=$value2?>"><?=$value2?></option>
            <?php endforeach; ?>
            <?php endforeach; ?>
        </select>
        <input type="text" name="distributor" placeholder="distributor">
        <input type="date" name="dateProjection" min="2018-01-01" max="2018-12-31" />
        <button type="submit">Rechercher</button>
    </form>
    <main class="container">
        <div>
            <h2>Titre</h2>
            <ul>
                <?php foreach($resultatFiltre as $key => $value):?>
                    <li class="li"><?=$value["title"]?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <h2>Genre</h2>
            <ul>
                <?php foreach($resultatFiltre as $key => $value):?>
                    <li class="li"><?=$value[1]?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <h2>Distributor</h2>
            <ul>
                <?php foreach($resultatFiltre as $key => $value):?>
                    <li class="li"><?=$value["name"]?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>
</body>
</html>