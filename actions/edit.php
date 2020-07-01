<a href="index.php">Home</a>
<div id="inputContainer">
    <form method="post">
        <p>New name of the list goes in here: </p>
        <input type="text" name="nameInput">
        <input type="submit">
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $listName = changeInput($_POST["nameInput"]);
    if ($listName !== null) {
        $user = "root";
        $pass = "";
        $id = $_GET['id'];

        try {
            $dbh = new PDO('mysql:host=localhost;dbname=todobase', $user, $pass);

            $stmt = $dbh->prepare("UPDATE `listtable` SET listName = (:newName) WHERE id = (:id)");
            $stmt->bindParam(':newName', $listName);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            $dbh = null;
            echo "<p id='succesMessage'>Changed list name.</p>";
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