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
    $stmt = $conn->prepare("SELECT `listName` FROM `listtable` ORDER BY `id` ASC");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $k=>$v) {
        echo "<div class='listItem'>". $v["listName"]. "<br></div>";
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}