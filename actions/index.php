<!DOCTYPE html>
<html lang="nl">
<head>
    <title>View lists</title>
    <link rel='stylesheet' type='text/css' href='../style.css'>
</head>
<?php
$user = "root";
$pass = "";

try {
    $conn = new PDO('mysql:host=localhost;dbname=todobase', $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT `id`, `listName` FROM `listtable` ORDER BY `id` ASC");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $k=>$v) {
        echo "<ul><li class='listItem'><a href='viewTasks.php?id=$v[id]'>$v[listName]</a> <p><a href=\"edit.php?id=$v[id]\">Edit</a> <a href='removeList.php?id=$v[id]'>delete</a><p></li></ul>";
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}