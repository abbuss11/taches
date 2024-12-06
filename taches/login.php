<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['mdp'];

    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mdp'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: taches.php");
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<form method="POST">
    <label>Nom d'utilisateur :</label>
    <input type="text" name="username" required>
    <label>Mot de passe :</label>
    <input type="password" name="mdp" required>
    <button type="submit">Se connecter</button>
</form>
