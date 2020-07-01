<!DOCTYPE html>
<html lang="nl">
<head>
    <title>View Tasks</title>
    <link rel='stylesheet' type='text/css' href='../style.css'>
</head>
<?php
$idParent = $_GET['id'];

$user = "root";
$pass = "";

try {
    $conn = new PDO('mysql:host=localhost;dbname=todobase', $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT `id`, `listName` FROM `listtable` WHERE `id` = (:idParent) ORDER BY `id` ASC");
    $stmt->bindParam(':idParent', $idParent);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach($stmt->fetchAll() as $k=>$v) {
        echo "<p id='taskTitle'>$v[listName]</p>";
    }


    $stmt = $conn->prepare("SELECT `id`, `name`, `status`, `duration`, `description`, `idParent` FROM `taskTable` WHERE idParent = (:idParent) ORDER BY `id` ASC");
    $stmt->bindParam(':idParent', $idParent);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $k=>$v) {
        echo "<ul><li>id: $v[id]</li><li>name: $v[name]</li><li>status: $v[status]</li><li>duration: $v[duration]</li><li>description: $v[description]</li><li>parent id: $v[idParent]</li></ul>";
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

//INSERT INTO `taskTable` (name, status, duration, description, idParent) VALUES ('php challenge', 'ongoing', 7-1-2020, 'adding tasks, normal cards are done', 7)