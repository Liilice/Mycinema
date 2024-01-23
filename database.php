<?php
    $dsn = 'mysql:host=localhost;dbname=cinema';
    $user = 'alice';
    $password = 'AliceZheng';
    try{
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connexion reussi\n";
    }catch(PDOException $e){
        echo "Erreur : ".$e->getMessage();
    }
    return $pdo;