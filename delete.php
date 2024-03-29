<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mCarService";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if(isset($_GET['deleteid'])){
    $id = $_GET['deleteid'];

    $sql = "DELETE FROM Services WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$id]);

    if($stmt){
        header('location:AdminPanel.php');
    } else {
        die($e->getMessage());
    }
}
if(isset($_GET['deleteidMechanic'])){
    $idMechanic = $_GET['deleteidMechanic'];

    $sql = "DELETE FROM mechanics WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$idMechanic]);

    if($stmt){
        header('location:AdminPanel.php');
    } else {
        die($e->getMessage());
    }
}
?>
