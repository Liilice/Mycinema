<?php
    $pdo = require_once("database.php");
    $_GET = filter_input_array(INPUT_GET, FILTER_VALIDATE_INT);
    $id = $_GET['id'] ?? '';
    if ($id) {
        $statement = $pdo->prepare("
            SELECT * FROM membership_log 
            WHERE id_membership = $id");
        $statement->execute();
        $statementDelete = $pdo->prepare("
            DELETE FROM membership_log 
            WHERE id_membership = $id");
        $statementDelete->execute();
        $statementDeletePrincipal = $pdo->prepare("DELETE FROM membership WHERE id_user = $id");
        $statementDeletePrincipal->execute();
    }
    header('Location: abonnement.php');