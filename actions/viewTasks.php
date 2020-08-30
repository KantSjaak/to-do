<!DOCTYPE html>
<html lang="nl">
<head>
    <title>View Tasks</title>
    <link rel='stylesheet' type='text/css' href='../style.css'>
</head>
<body>
<a href="index.php" class="BTN">home</a>
<?php
$idParent = $_GET['id'];
echo "<a href=\"addTask.php?id=$idParent\" class=\"BTN\">add task</a>";
echo "<label for=\"viewedTasks\"> What tasks do you want to see? </label>
    <select name=\"viewedTasks\" id=\"viewedTasks\">
        <option value=\"-1\">Show me all the tasks</option>
        <option value=\"0\">Not Started</option>
        <option value=\"1\">Ongoing</option>
        <option value=\"2\">Halted</option>
        <option value=\"3\">Completed</option>
    </select>
    <button type='button' onclick='showTasks()'>Filter!</button><p id=\"order\">Not Started</p><button type='button' onclick='sortTasks()'>Sort!</button>";
echo "<script>function showTasks() {
  
  let i = parseInt(document.getElementById(\"viewedTasks\").value);
  if (i !== -1){
      for (let headCount=0; headCount<4; headCount++){
           if (headCount === i){
               var items = document.getElementsByClassName(headCount);
               for (var count=0; count < items.length; count++){
                    items[count].style.display = \"block\";
               }
           }else{
               var items = document.getElementsByClassName(headCount);
               for (var count=0; count < items.length; count++){
                    items[count].style.display = \"none\";
               }
           }
      }
  }else if(i === -1){
      for (var a=0; a<4; a++){
          var cleans = document.getElementsByClassName(a);
          for (var cleanscount=0; cleanscount < cleans.length; cleanscount++){
              cleans[cleanscount].style.display = \"block\";
          }
      } 
  } 
}
const STATUS = [
            {
                id: 0,
                name: \"Not Started\"
            },
            {
                id: 1,
                name: \"Ongoing\"
            },
            {
                id: 2,
                name: \"Halted\"
            },
            {
                id: 3,
                name: \"Completed\"
            }
        ];
        let statusCounter = 0;

        function sortTasks() {
            statusCounter++;

            let div = document.getElementById(\"statusWrapper\");
            let selected = STATUS[statusCounter % STATUS.length];
            document.getElementById(\"order\").innerText = selected.name;

            let data = [];

            for (let range = 0; range < STATUS.length; range++) {
                for (let i = 0; i < div.children.length; i++) {
                    let child = div.children[i];
                    let id = parseInt(child.classList[0]);

                    if ((statusCounter + range) % STATUS.length === id) {
                        data.push(child.cloneNode(true));
                    }
                }
            }

            while(div.children.length > 0)
                div.children[0].remove();

            for (let i = 0; i < data.length; i++) {
                div.appendChild(data[i]);
            }
        }</script>";

$user = "root";
$pass = "";

try {
    $conn = new PDO('mysql:host=localhost;dbname=todobase', $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT `id`, `listName` FROM `listtable` WHERE `id` = (:idParent) ORDER BY `id` ASC");
    $stmt->bindParam(':idParent', $idParent);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($stmt->fetchAll() as $k => $v) {
        echo "<p id='taskTitle'>$v[listName]</p>";
    }


    $stmt = $conn->prepare("SELECT `id`, `name`, `status`, `duration`, `description`, `idParent` FROM `taskTable` WHERE idParent = (:idParent) ORDER BY `id` ASC");
    $stmt->bindParam(':idParent', $idParent);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    echo "<div id='statusWrapper'>";
    foreach ($stmt->fetchAll() as $k => $v) {
        //dev note: I know that most items can be in one echo, but I think this is easier to read.
        echo "<ul class='$v[status]' '>";
        echo "<li>id: $v[id]</li>";
        echo "<li>name: $v[name]</li>";
        if ($v['status'] == 0) {
            echo "<li>Status: Not Started</li>";
        } elseif ($v['status'] == 1) {
            echo "<li>Status: Ongoing</li>";
        } elseif ($v['status'] == 2) {
            echo "<li>Status: Halted</li>";
        } elseif ($v['status'] == 3) {
            echo "<li>Status: Completed</li>";
        } elseif ($v['status'] == "default") {
            echo "<li>Status: Incorrect value entered when making/updating task</li>";
        } else {
            echo "<li>Status: There was an error, please excuse us.</li>";
        }
        echo "<li>duration: $v[duration]</li>";
        echo "<li>description: $v[description]</li>";
        echo "<li>parent id: $v[idParent]</li>";
        echo "<a class='listEdit' href='editTask.php?id=$v[id]'>Edit</a><a class='listDelete' href='removeTask.php?id=$v[id]'>Delete</a>";
        echo "</ul>";
    }
    echo "</div>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
</body>
