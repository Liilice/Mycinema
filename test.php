<?php
$pdo = require_once("database.php");
$count = (int)$pdo->query("SELECT COUNT('title') FROM distributor 
    JOIN movie ON distributor.id = movie.id_distributor 
    JOIN movie_genre ON movie.id = movie_genre.id_movie 
    JOIN genre ON movie_genre.id_genre = genre.id 
    WHERE genre.name LIKE '%$search%' 
    AND movie.title LIKE '%$rechercher%' 
    AND distributor.name LIKE '%$distributor%';")->fetch(PDO::FETCH_NUM)[0];

$page = $_GET["page"]??1;
$parPage = 20;
$pages = ceil($count/$parPage);
$start = ($page - 1)*$parPage;
$statement = $pdo->prepare("
    SELECT movie.title, genre.name, distributor.name FROM distributor 
    JOIN movie ON distributor.id = movie.id_distributor 
    JOIN movie_genre ON movie.id = movie_genre.id_movie 
    JOIN genre ON movie_genre.id_genre = genre.id 
    WHERE genre.name LIKE '%$search%' 
    AND movie.title LIKE '%$rechercher%' 
    AND distributor.name LIKE '%$distributor%'LIMIT $start, $parPage;");
$statement->execute();
$resultatFiltre = $statement->fetchAll();
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
    <div>
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
        <!-- <input type="date" name="dateProjection" min="2018-01-01" max="2018-12-31" /> -->
        <input type="submit" value="Rechercher">
        <!-- <button type="submit">Rechercher</button> -->
    </div>
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
    <footer>
        <?php for($i = 1; $i <= $pages; $i++):?>
            <?php $url = "?rechercher=".$rechercher."&genre=".$search."&distributor=".$distributor."&page=".$i?> 
            <a href="<?=$url?>"><?=$i?></a>
        <?php endfor;?>
    </footer>
</body>
</html>



<?php for($i = 1; $i <= $pages; $i++):?>
            <?php if(!empty($_GET["member"])):?>
                <?php $url = "?member=".$member."&page=".$i?> 
            <?php endif; ?>
            <a href="<?=$url?>"><?=$i?></a>
        <?php endfor;?>