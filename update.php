<?php
var_dump($_POST);
$servername = "localhost";
$username = "root";
$password = "";
$database = "mCarService";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postData = json_decode(file_get_contents("php://input"), true);
    $id = $postData["id"];
    $name = $postData["name"];
    $time = $postData["time"];
    

    // Update the record in the database
    $sql = "UPDATE Services SET name=?, timeForExecution=? WHERE id=?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$name, $time, $id]);

    // Return the updated HTML for the row
    echo '<th scope="row">' . $id . '</th>
        <td class="nameDB">' . $name . '</td>
        <td class="timeDB">' . $time . ' мин</td>
        <td>
        <button class="btn btn-primary editBtn"><a href="" class="text-light">Промени</a></button>
        <button class="btn btn-danger"><a href="delete.php?deleteid='.$id.'" class="text-light">Изтрий</a></button>';
}
?>
