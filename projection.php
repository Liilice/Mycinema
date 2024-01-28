<?php 
    $pdo = require_once("database.php");
    $dateProjection = $_GET['dateProjection'];
    // $dateProjectionReformater = str_replace("T", " ", $dateProjection);
    // echo $dateProjectionReformater;
    $parPage = 15;
    $page = $_GET["page"] ? $_GET["page"] : 1;
    $start = ($page - 1)*$parPage;
    if(isset($_GET['dateProjection'])&&$_GET['dateProjection']!==""){
        $count = $pdo->query("SELECT COUNT(*) FROM movie JOIN movie_schedule ON movie.id = movie_schedule.id_movie WHERE movie_schedule.date_begin LIKE '$dateProjection%';");
        $totalCount = $count->fetchAll()[0][0];
        // echo '<pre>';
        // print_r($totalCount);
        // echo '</pre>';

        $pages = ceil($totalCount / $parPage);
        // recuperer tout les films par date de pprojection
        $statement = $pdo->prepare("SELECT movie.title, movie_schedule.date_begin, id_room FROM movie JOIN movie_schedule ON movie.id = movie_schedule.id_movie WHERE movie_schedule.date_begin LIKE '$dateProjection%';");
        $statement->execute();
        $resultatFiltre = $statement->fetchAll(PDO::FETCH_ASSOC);        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/96249701bf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
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
        <input type="date" name="dateProjection" min="2018-01-01" max="2018-12-31" />
        <input type="submit" value="Rechercher"/>
    </form>
    <main class="container">
        <div class="containerIndex">
            <div>
                <h2>Films</h2>
                <ul>
                    <?php foreach($resultatFiltre as $key => $value):?>
                        <li class="li"><?=$value["title"]?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h2>Salle de diffusion</h2>
                <ul>
                    <?php foreach($resultatFiltre as $key => $value):?>
                        <li class="li"><?=$value["id_room"]?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h2>Date de projection</h2>
                <ul>
                    <?php foreach($resultatFiltre as $key => $value):?>
                        <li class="li"><?=$value["date_begin"]?></li>
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
</body>
</html>