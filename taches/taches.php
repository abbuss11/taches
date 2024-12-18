<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ajout d'une tâche
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_task'])) {
    $title = $_POST['title'];
    $sql = "INSERT INTO taches (user_id, titre) VALUES (:user_id, :title)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'title' => $title]);
}

// Marquer une tâche comme terminée
if (isset($_GET['complete'])) {
    $task_id = $_GET['complete'];
    $sql = "UPDATE taches SET completer = TRUE WHERE id = :id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $task_id, 'user_id' => $user_id]);
}

// Suppression d'une tâche
if (isset($_GET['delete'])) {
    $task_id = $_GET['delete'];
    $sql = "DELETE FROM taches WHERE id = :id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $task_id, 'user_id' => $user_id]);
}

// Récupérer les tâches
$sql = "SELECT * FROM taches WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$tasks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<h1>Mes tâches</h1>

<form method="POST">
    <input type="text" class="input" name="titre" placeholder="Nouvelle tâche" required>
    <button type="submit" class="btn btn-success" name="add_task">Ajouter</button>
</form>

<h2>Tâches en cours</h2>
<ul>
    <?php foreach ($tasks as $task): ?>
        <?php if (!$task['completer']): ?>
            <li>
                <?= htmlspecialchars($task['titre']) ?>
                <a class="btn btn-primary" href="?complete=<?= $task['id'] ?>">Compléter</a>
                <a class="btn btn-outline-warning" href="?delete=<?= $task['id'] ?>">Supprimer</a>
            </li>
        <?php endif; ?>
    <?php endforeach; ?></ul>

<h2>Tâches terminées</h2>
<ul>
    <?php foreach ($tasks as $task): ?>
        <?php if ($task['completer']): ?>
            <li><?= htmlspecialchars($task['titre']) ?></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
   <p>by abbuss </p>
</body>
</html>
