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

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $k=>$v) {
        echo "<div class='listItem'>". $v["listName"]. "<br></div>";
    }
    //edit function and add edit text as onclicks
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

edit(11, "work list");

function edit($id, $name)
{
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=todobase', "root", "");

        $stmt = $dbh->prepare("UPDATE `listtable` SET `listName` = (:newvalue) WHERE `id` = (:idvalue)");
        $stmt->bindParam(':newvalue', $name);
        $stmt->bindParam(':idvalue', $id);

        $stmt->execute();

        $dbh = null;
        echo "<p id='succesMessage'>changed list " . $name . " in the database</p>";
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}