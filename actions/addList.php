<?php
require "connectToDB.php";
$user = "root";
$pass = "";

try {
    $dbh = new PDO('mysql:host=localhost;dbname=todobase', $user, $pass);

    $stmt = $dbh->prepare("INSERT INTO listtable (listName) VALUE (:listName)");
    $stmt->bindParam(':listName', $listName);

    $listName = 'Blaze';
    $stmt->execute();

    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
