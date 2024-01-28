<?php
    $pdo = require_once("database.php");
    CONST ERROR_REQUIRED = "Veuillez remplir le champ";
    $error = [
        'nom' => '',
        'prenom' => '',
        'email' => '',
        'birthdate' => '',
        'address' => '',
        'zipcode' => '',
        'city' => '',
        'country' => '',
    ];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_POST = filter_input_array(INPUT_POST, [
            'nom' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'prenom' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'email' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'birthdate' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'address' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'zipcode' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'city' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'country' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ]);
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $birthdate = $_POST["birthdate"].":00";
        $address = $_POST["address"];
        $zipcode = $_POST["zipcode"];
        $city = $_POST["city"];
        $country = $_POST["country"];

        if (!$nom)  {
            $error['nom'] = ERROR_REQUIRED; 
        }
        if (!$prenom)  {
            $error['prenom'] = ERROR_REQUIRED; 
        }
        if (!$email)  {
            $error['email'] = ERROR_REQUIRED; 
        }
        if (!$birthdate)  {
            $error['birthdate'] = ERROR_REQUIRED; 
        }
        if (!$address)  {
            $error['address'] = ERROR_REQUIRED; 
        }
        if (!$zipcode)  {
            $error['zipcode'] = ERROR_REQUIRED; 
        }
        if (!$city)  {
            $error['city'] = ERROR_REQUIRED; 
        }
        if (!$country)  {
            $error['country'] = ERROR_REQUIRED; 
        }  
        if(!empty($nom)&&!empty($prenom)&&!empty($email)&&!empty($birthdate)&&!empty($address)&&!empty($zipcode)&&!empty($city)&&!empty($country)){
            $statementUser = $pdo->prepare("
                INSERT INTO user(email, firstname, lastname, birthdate, address, zipcode, city, country)
                VALUES('$email', '$prenom', '$nom', '$birthdate', '$address', '$zipcode', '$city', '$country')");
            $statementUser->execute();
            header('Location: successful.php');
        }      
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
    <form action="" method="POST" >
        <h1>Inscrivez-vous dès maintenant !</h1>
        <div class="labelInput">
            <label for="nom">Nom</label>
            <input type="text" name="nom" placeholder="Nom" value="<?= $nom ?? '' ?>">
            <?= $error['nom'] ? '<p class="textError">' . $error['nom'] . '</p>' : "" ?>
        </div>
        <div class="labelInput">
            <label for="Prenom">Prenom</label>
            <input type="text" name="prenom" placeholder="Prenom" value="<?= $prenom ?? '' ?>">
            <?= $error['prenom'] ? '<p class="textError">' . $error['prenom'] . '</p>' : "" ?>
        </div>
        <div class="labelInput">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email">
            <?= $error['email'] ? '<p class="textError">' . $error['email'] . '</p>' : "" ?>
        </div>
        <div class="labelInput">
            <label for="birthdate">Date de naissance</label>
            <input type="datetime-local" name="birthdate"> 
            <?= $error['birthdate'] ? '<p class="textError">' . $error['birthdate'] . '</p>' : "" ?>
        </div>
        <div class="labelInput">
            <label for="Address">Address</label>
            <input type="text" name="address" placeholder="Address" value="<?= $address ?? '' ?>">
            <?= $error['address'] ? '<p class="textError">' . $error['address'] . '</p>' : "" ?>
        </div>
        <div class="labelInput">
            <label for="zipcode">Zipcode</label>
            <input type="text" name="zipcode" placeholder="Zipcode" value="<?= $zipcode ?? '' ?>">
            <?= $error['zipcode'] ? '<p class="textError">' . $error['zipcode'] . '</p>' : "" ?>
        </div>
        <div class="labelInput">
            <label for="city">City</label>
            <input type="text" name="city" placeholder="City" value="<?= $city ?? '' ?>">
            <?= $error['city'] ? '<p class="textError">' . $error['city'] . '</p>' : "" ?>
        </div>
        <div class="labelInput">
            <label for="country">Country</label>
            <input type="text" name="country" placeholder="country" value="<?= $country ?? '' ?>">
            <?= $error['country'] ? '<p class="textError">' . $error['country'] . '</p>' : "" ?>
        </div>
        <button class="btn btn-danger">Devenir un membre</button>
    </form>
</body>
</html>