<?php
require_once "./database.php";

if ($_POST['id']) {
    $id = $_POST['id'];
    $statement = $pdo->prepare("SELECT * FROM posts WHERE id=:id");
    $statement->bindValue(':id', $id);
    $statement->execute();
    $post = $statement->fetch(PDO::FETCH_ASSOC);
}
if (!empty($post)) {
    unlink($post['image']);
    $statement = $pdo->prepare("DELETE FROM posts WHERE id=:id");
    $statement->bindValue(':id', $post['id']);
    $statement->execute();
    header('Location:/');
}
