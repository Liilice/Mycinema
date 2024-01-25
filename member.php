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
    <form action="" method="get">
        <input type="search" name="member" placeholder="member">
        <!-- <input type="date" name="dateProjection" min="2018-01-01" max="2018-12-31" /> -->
        <input type="submit" hidden />
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
    <div id="pagination">
        <?php for($i = 1; $i <= $pages; $i++):?>
            <?php if(!empty($_GET["member"])):?>
                <?php $url = "?member=".$member."&page=".$i?> 
            <?php endif; ?>
            <?php $stylePagination = ($i==$page)?"active":"";?>
            <a href="<?=$url?>" class="<?=$stylePagination?>"><?=$i?></a>
        <?php endfor;?>
    </div>
</body>
</html>