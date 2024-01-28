<?php 
    $pdo = require_once("database.php");
    $statementGenre = $pdo->prepare('SELECT name FROM genre');
    $statementGenre->execute();
    $resultat = $statementGenre->fetchAll(PDO::FETCH_ASSOC); 

    $search = $_GET['genre'] && $_GET['genre']!=="defaut" ? $_GET['genre']: '';
    $distributor = $_GET['distributor'] ? $_GET['distributor'] : '';
    $rechercher = $_GET['rechercher'] ? $_GET['rechercher'] : '';

    $parPage = 15;
    $page = $_GET["page"] ? $_GET["page"] : 1;
    $start = ($page - 1)*$parPage;

    $count = $pdo->query("SELECT COUNT(*) FROM distributor JOIN movie ON distributor.id = movie.id_distributor JOIN movie_genre ON movie.id = movie_genre.id_movie JOIN genre ON movie_genre.id_genre = genre.id WHERE genre.name LIKE '%$search%' AND movie.title LIKE '%$rechercher%' AND distributor.name LIKE '%$distributor%';");
    $totalCount = $count->fetchAll()[0][0];

    $pages = ceil($totalCount / $parPage);

    $statement = $pdo->prepare("
        SELECT movie.title, genre.name, distributor.name FROM distributor 
        JOIN movie ON distributor.id = movie.id_distributor 
        JOIN movie_genre ON movie.id = movie_genre.id_movie 
        JOIN genre ON movie_genre.id_genre = genre.id 
        WHERE genre.name LIKE '%$search%' 
        AND movie.title LIKE '%$rechercher%' 
        AND distributor.name LIKE '%$distributor%' LIMIT $start, $parPage;");
    $statement->execute();
    $resultatFiltre = $statement->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/96249701bf.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <header>
        <img src="/image/cinemaLogo.png" alt="logo">
        <ul class="containerLink">
            <li>
                <a href="index.php"><i class="fa-solid fa-film"></i></a>
                <h2><a href="index.php">Films</a></h2>
            </li>
            <li>
                <a href="projection.php"><i class="fa-solid fa-video"></i></a>
                <h2><a href="projection.php">Projection</a></h2>
            </li>
            <li>
                <a href="member.php"><i class="fa-regular fa-user"></i></a>
                <h2><a href="member.php">Clients</a></h2>
            </li>
            <li>
                <a href="abonnement.php"><i class="fa-solid fa-user-plus"></i></a>
                <h2><a href="abonnement.php">Abonnement</a></h2>
            </li>
            <li>
                <a href="admin.php"><i class="fa-solid fa-user-gear"></i></a>
                <h2><a href="admin.php">Admin</a></h2>
            </li>
        </ul>
    </header>
    <form action="" method="get">
        <input type="search" placeholder="Film" name="rechercher">
        <select name="genre" id="genre">
            <option value="defaut">Defaut</option>
            <?php foreach($resultat as $key => $value):?>
            <?php foreach($value as $key2 => $value2):?>
                <option value="<?=$value2?>"><?=$value2?></option>
            <?php endforeach; ?>
            <?php endforeach; ?>
        </select>
        <input type="search" name="distributor" placeholder="Distributor">
        <input type="submit" value="Rechercher"/>
    </form>
    <main class="container">
        <div class="containerIndex">
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
        </div>
        <div class="pagination">
            <?php for($i = 1; $i <= $pages; $i++):?>
                <?php if($_GET["rechercher"]||$_GET["search"]||$_GET["distributor"]):?>
                    <?php $url = "?rechercher=".$rechercher."&genre=".$search."&distributor=".$distributor."&page=".$i?> 
                <?php else:?>
                    <?php $url = "?page=".$i;?>
                <?php endif; ?>
                <a href="<?=$url?>" class="<?=($i==$page)?"active":""?>"><?=$i?></a>
            <?php endfor;?>
        </div>
    </main>
    <footer>
        <ul class="containerFooter">
            <li>
                <a href="inscription.php"><i class="fa-solid fa-right-to-bracket"></i></a>
                <h2><a href="inscription.php">S'inscrire</a></h2>
            </li>
            <li>
                <a href="recrutement.php"><i class="fa-solid fa-user-group"></i></a>
                <h2><a href="recrutement.php">Recrutement</a></h2>
            </li>
        </ul>
        <!-- <ul class="socialMedia">
            <li><i class="fa-brands fa-facebook"></i></li>
            <li><i class="fa-brands fa-x-twitter"></i></li>
            <li><i class="fa-brands fa-instagram"></i></li>
            <li><i class="fa-brands fa-tiktok"></i></li>
            <li><i class="fa-brands fa-youtube"></i></li>
        </ul> -->
    </footer>
</body>
</html>