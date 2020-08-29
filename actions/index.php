<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Home</title>
    <link rel='stylesheet' type='text/css' href='../style.css'>
</head>
<body>
    <a href="addList.php" class="BTN">add list</a>
</body>
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
        echo "<ul class='lists'>";
        echo "<li><a class='listName' href='viewTasks.php?id=$v[id]'>$v[listName]</a></li>";
        echo "<li><a class='listEdit' href='edit.php?id=$v[id]'>Edit</a></li>";
        echo "<li><a class='listDelete' href='removeList.php?id=$v[id]'>Delete</a></li>";
        echo "</ul>";
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}