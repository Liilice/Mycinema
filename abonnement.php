<?php 
    $pdo = require_once("database.php");

    $abonner = $_GET['abonner'];
    $parPage = 5;
    $page = $_GET["page"] ? $_GET["page"] : 1;
    $start = ($page - 1)*$parPage;

    if(isset($abonner) && $abonner !== ""){
        $countAbonner = $pdo->query("
            SELECT COUNT(user.id) FROM user 
            JOIN membership ON user.id = membership.id_user 
            JOIN subscription ON membership.id_subscription = subscription.id
            WHERE user.firstname LIKE '%$abonner%' OR user.lastname LIKE '%$abonner%';");
        $totalCountAbonner = $countAbonner->fetchAll()[0][0];
        $pages = ceil($totalCountAbonner / $parPage);

        $statement = $pdo->prepare("
            SELECT user.firstname, user.lastname, user.id, subscription.name FROM user 
            JOIN membership ON user.id = membership.id_user 
            JOIN subscription ON membership.id_subscription = subscription.id
            WHERE user.firstname LIKE '%$abonner%' OR user.lastname LIKE '%$abonner%'
            LIMIT $start, $parPage;");
        $statement->execute();
        $resultatFiltre = $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    $limitPage = 10;
    $pageHisto = $_GET["pageHisto"] ? $_GET["pageHisto"] : 1;
    $debut = ($pageHisto - 1)*$limitPage;
    $id = $_GET['id']; 
    if(isset($id) && $id !== ""){
        $countAbonnerHistoriq = $pdo->query("
            SELECT COUNT(*) FROM user 
            JOIN membership ON user.id = membership.id_user 
            JOIN subscription ON membership.id_subscription = subscription.id 
            JOIN membership_log ON membership.id = membership_log.id_membership 
            JOIN movie_schedule ON membership_log.id_session = movie_schedule.id 
            JOIN movie ON movie_schedule.id_movie = movie.id
            WHERE user.id = $id;");
        $totalCountAbonnerHistoriq = $countAbonnerHistoriq->fetchAll()[0][0];
        $pagess = ceil($totalCountAbonnerHistoriq / $limitPage );

        $statementhistoriqMember = $pdo->prepare("
            SELECT user.firstname, user.lastname, user.email, subscription.name, movie.title FROM user 
            JOIN membership ON user.id = membership.id_user 
            JOIN subscription ON membership.id_subscription = subscription.id 
            JOIN membership_log ON membership.id = membership_log.id_membership 
            JOIN movie_schedule ON membership_log.id_session = movie_schedule.id 
            JOIN movie ON movie_schedule.id_movie = movie.id
            WHERE user.id = $id
            LIMIT $debut, $limitPage;");
        $statementhistoriqMember->execute();
        $resultatFiltreHistorique = $statementhistoriqMember->fetchAll(PDO::FETCH_ASSOC);
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
        <input type="search" name="abonner" placeholder="abonner">
        <input type="submit" value="Rechercher"/>
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
                            <a href="addMovieAbonner.php?id=<?= $value['id']?>">
                                <button class="btn">Ajouter un film</button>
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
            <div class="pagination">
                <?php for($i = 1; $i <= $pages; $i++):?>
                    <?php if(!empty($_GET["abonner"])):?>
                        <?php $url = "?abonner=".$abonner."&page=".$i?> 
                    <?php endif; ?>
                    <?php $stylePagination = ($i==$page)?"active":"";?>
                    <a href="<?=$url?>" class="<?=$stylePagination?>"><?=$i?></a>
                <?php endfor;?>
            </div>
        </div>
        <div>
            <h2>Historique des films vus par l'abonné </h2>
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
            <div class="pagination">
                <?php for($i = 1; $i <= $pagess; $i++):?>
                    <?php if($_GET["id"]):?>
                        <?php $url = "?id=".$_GET["id"]."&pageHisto=".$i?> 
                    <?php endif; ?>
                    <a href="<?=$url?>" class="<?=($i==$pageHisto)?"active":""?>"><?=$i?></a>
                <?php endfor;?>
            </div>
        </div>
    </main>
</body>
</html>