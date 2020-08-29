<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Update Tasks</title>
    <link rel='stylesheet' type='text/css' href='../style.css'>
</head>
<body>
<a href="index.php" class="BTN">home</a>
<?php
$id = $_GET['id'];
$user = "root";
$pass = "";
try {
    $dbh = new PDO('mysql:host=localhost;dbname=todobase', $user, $pass);
    $stmt = $dbh->prepare("SELECT name, status, duration, description FROM `tasktable` WHERE `id` = (:id)");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p class='listName'>Task name: $result[name]</p>";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
echo "<form method=\"post\">
    <label for=\"taskStatus\">What is the status of the task at this point of time?</label><br>
    <select name=\"taskStatus\" id=\"taskStatus\">
        <option value=\"default\">---Please pick an option---</option>
        <option value=\"0\">Not Started</option>
        <option value=\"1\">Ongoing</option>
        <option value=\"2\">Halted</option>
        <option value=\"3\">Completed</option>
    </select>
    <p>How long do you think this will take? </p>
    <input type=\"text\" name=\"taskDuration\" value='$result[duration]'>
    <p>What is the task about? </p>
    <input type=\"text\" name=\"taskDescription\" value='$result[description]'>
    <input type=\"submit\">
</form>";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskStatus = changeInput($_POST["taskStatus"]);
    $taskDuration = changeInput($_POST["taskDuration"]);
    $taskDescription = changeInput($_POST["taskDescription"]);
    $user = "root";
    $pass = "";
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=todobase', $user, $pass);

        $stmt = $dbh->prepare("UPDATE `tasktable` SET status=(:status), duration=(:duration), description=(:description) WHERE id=(:id)");
        $stmt->bindParam(':status', $taskStatus);
        $stmt->bindParam(':duration', $taskDuration);
        $stmt->bindParam(':description', $taskDescription);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $dbh = null;
        echo "<p id='succesMessage'>Updated your task.</p>";
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