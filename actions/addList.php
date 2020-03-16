<div id="inputContainer">
    <div id="headerContainer">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="viewList.php">View Lists</a></li>
            <li><a href="connectToDB.php">Test</a></li>
        </ul>
    </div>
    <form method="post">
        <p>Name of the list goes in here: </p>
        <input type="text" name="nameInput">
        <input type="submit">
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $listName = changeInput($_POST["nameInput"]);
    if ($listName !== null) {
        require "connectToDB.php";
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