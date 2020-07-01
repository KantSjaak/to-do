<a href="index.php">Home</a>
<?php
$username = "root";
$password = "";
$id = $_GET['id'];
try {
    $dbh = new PDO('mysql:host=localhost;dbname=todobase', $username, $password);
    $stmt = $dbh->prepare("DELETE FROM `listtable` WHERE (id) = (:id);");
    $stmt->bindParam(':id', $id);

    $stmt->execute();

    $dhb = null;
    echo "Record deleted successfully";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}