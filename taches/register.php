<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['mdp'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, mdp) VALUES (:username, :mdp)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute(['username' => $username, 'mdp' => $password]);
        header("Location: login.php");
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
<form method="POST">
    <label>Nom d'utilisateur :</label>
    <input type="text" name="username" required>
    <label>Mot de passe :</label>
    <input type="password" name="mdp" required>
    <button type="submit">S'inscrire</button>
</form>

</body>
</html>
