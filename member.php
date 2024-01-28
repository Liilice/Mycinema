<?php 
    $pdo = require_once("database.php");
    $member = $_GET['member'];
    $parPage = 5;
    $page = $_GET["page"] ? $_GET["page"] : 1;
    $start = ($page - 1)*$parPage;
    if(isset($_GET['member'])&&$_GET['member']!==""){
        $count = $pdo->query("SELECT COUNT(*) AS id FROM user WHERE firstname LIKE '%$member%' OR lastname LIKE '%$member%';");
        $totalCountMember = $count->fetchAll()[0][0];
        $pages = ceil($totalCountMember / $parPage);
        $statement = $pdo->prepare("
            SELECT firstname, lastname, id FROM user 
            WHERE firstname LIKE '%$member%' OR lastname LIKE '%$member%' LIMIT $start, $parPage;");
        $statement->execute();
        $resultatFiltre = $statement->fetchAll();
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
        <input type="search" name="member" placeholder="member">
        <input type="submit" value="Rechercher"/>
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
        <div class="pagination">
            <?php for($i = 1; $i <= $pages; $i++):?>
                <?php if(!empty($_GET["member"])):?>
                    <?php $url = "?member=".$member."&page=".$i?> 
                <?php endif; ?>
                <a href="<?=$url?>" class="<?=($i==$page)?"active":""?>"><?=$i?></a>
            <?php endfor;?>
        </div>
    </main>
</body>
</html>