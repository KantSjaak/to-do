<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Add Tasks</title>
    <link rel='stylesheet' type='text/css' href='../style.css'>
</head>
<body>
<a href="index.php" class="BTN">home</a>
<form method="post">
    <p>Name of the new task: </p>
    <input type="text" name="taskName"><br>
    <br><label for="taskStatus">What is the status of the task at this point of time?</label><br>
    <select name="taskStatus" id="taskStatus">
        <option value="0">Not Started</option>
        <option value="1">Ongoing</option>
        <option value="2">Halted</option>
        <option value="3">Completed</option>
    </select>
    <p>How long do you think this will take? </p>
    <input type="text" name="taskDuration">
    <p>What is the task about? </p>
    <input type="text" name="taskDescription">
    <input type="submit">
</form>
<?php
$parentID = $_GET['id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskName = changeInput($_POST["taskName"]);
    $taskStatus = changeInput($_POST["taskStatus"]);
    $taskDuration = changeInput($_POST["taskDuration"]);
    $taskDescription = changeInput($_POST["taskDescription"]);
        $user = "root";
        $pass = "";
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=todobase', $user, $pass);

            $stmt = $dbh->prepare("INSERT INTO `tasktable` (name, status, duration, description, idParent) VALUE (:name, :status, :duration, :description, :idParent)");
            $stmt->bindParam(':name', $taskName);
            $stmt->bindParam(':status', $taskStatus);
            $stmt->bindParam(':duration', $taskDuration);
            $stmt->bindParam(':description', $taskDescription);
            $stmt->bindParam(':idParent', $parentID);
            $stmt->execute();

            $dbh = null;
            echo "<p id='succesMessage'>added list ". $taskName. " to the database</p>";
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
}

function changeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}