<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Remove Task</title>
    <link rel='stylesheet' type='text/css' href='../style.css'>
</head>
<body>
<a href="index.php" class="BTN">home</a>
</body>
<?php
$username = "root";
$password = "";
$id = $_GET['id'];
try {
    $dbh = new PDO('mysql:host=localhost;dbname=todobase', $username, $password);
    $stmt = $dbh->prepare("DELETE FROM `tasktable` WHERE (id) = (:id);");
    $stmt->bindParam(':id', $id);

    $stmt->execute();

    $dhb = null;
    echo "<p id='deleteMSG'>Succesfully deleted your task.</p>";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}