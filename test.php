// if(isset($_POST['genre']) && $_POST['genre']!=="defaut")
    // {
    //     // recuperer tout les films par genre par select;
    //     $statement = $pdo->prepare("SELECT title FROM movie JOIN movie_genre ON movie.id = movie_genre.id_movie JOIN genre ON genre.id = movie_genre.id_genre WHERE genre.name LIKE '%$search%';");
    //     $statement->execute();
    //     $resultatFiltre = $statement->fetchAll(PDO::FETCH_ASSOC);
    // }
    // if($chercher){
    //     // recuperer tout les films par l'input de recherche;
    //     $statement = $pdo->prepare("SELECT title FROM movie WHERE title LIKE '%$chercher%';");
    //     $statement->execute();
    //     $resultatFiltre = $statement->fetchAll(PDO::FETCH_ASSOC);
    // }
    // if($distributor){
    //     // recuperer tout les films par l'input de distributor;
    //     $statement = $pdo->prepare("SELECT title FROM movie JOIN distributor ON movie.id_distributor = distributor.id WHERE distributor.name LIKE '%$distributor%';");
    //     $statement->execute();
    //     $resultatFiltre = $statement->fetchAll(PDO::FETCH_ASSOC);
    // }

    

    movie.title, genre.name, distributor.name
