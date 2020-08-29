<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Add List</title>
    <link rel='stylesheet' type='text/css' href='../style.css'>
</head>
<body>
    <div id="inputContainer">
        <div id="headerContainer">
            <ul>
                <a href="index.php" class="BTN">home</a>
            </ul>
        </div>
        <form method="post">
            <p>Name of the list goes in here: </p>
            <input type="text" name="nameInput">
            <input type="submit">
        </form>
    </div>
</body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $listName = changeInput($_POST["nameInput"]);
    if ($listName !== null) {
        $user = "root";
        $pass = "";

        try {
            $dbh = new PDO('mysql:host=localhost;dbname=todobase', $user, $pass);

            $stmt = $dbh->prepare("INSERT INTO listtable (listName) VALUE (:listName)");
            $stmt->bindParam(':listName', $listName);

            $stmt->execute();

            $dbh = null;
            echo "<p id='succesMessage'>added list ". $listName. " to the database</p>";
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}

function changeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>