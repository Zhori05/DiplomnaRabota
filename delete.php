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
        header('location:adminPage3.php');
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
        header('location:adminPage3.php');
    } else {
        die($e->getMessage());
    }
}
if(isset($_GET['deleteidUser'])){
    $idUser = $_GET['deleteidUser'];

    // Извлечете информацията за потребителя, който ще бъде изтрит
    $sql_select_user = "SELECT * FROM users WHERE iduser = ?";
    $stmt_select_user = $connection->prepare($sql_select_user);
    $stmt_select_user->execute([$idUser]);
    $user = $stmt_select_user->fetch(PDO::FETCH_ASSOC);

    // Вмъкнете информацията за изтрития потребител в таблицата blockedUsers
    $sql_insert_blocked_user = "INSERT INTO blockedUsers (iduser, Name, Email, Password, PhoneNumber) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert_blocked_user = $connection->prepare($sql_insert_blocked_user);
    $stmt_insert_blocked_user->execute([$user['iduser'], $user['Name'], $user['Email'], $user['Password'], $user['PhoneNumber']]);
    
    // Изтрийте потребителя от таблицата users
    $sql_delete_user = "DELETE FROM users WHERE iduser = ?";
    $stmt_delete_user = $connection->prepare($sql_delete_user);
    $stmt_delete_user->execute([$idUser]);

    if($stmt_delete_user){
        header('location:adminPage3.php');
    } else {
        die($e->getMessage());
    }
}
if(isset($_GET['activateIdUser'])){
    $idUser = $_GET['activateIdUser'];

    // Извлечете информацията за потребителя, който ще бъде активиран
    $sql_select_user = "SELECT * FROM blockedUsers WHERE iduser = ?";
    $stmt_select_user = $connection->prepare($sql_select_user);
    $stmt_select_user->execute([$idUser]);
    $user = $stmt_select_user->fetch(PDO::FETCH_ASSOC);

    // Вмъкнете информацията за изтрития потребител в таблицата blockedUsers
    $sql_insert_blocked_user = "INSERT INTO users (iduser, Name, Email, Password, PhoneNumber) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert_blocked_user = $connection->prepare($sql_insert_blocked_user);
    $stmt_insert_blocked_user->execute([$user['iduser'], $user['Name'], $user['Email'], $user['Password'], $user['PhoneNumber']]);
    
    // Изтрийте потребителя от таблицата users
    $sql_delete_user = "DELETE FROM blockedUsers WHERE iduser = ?";
    $stmt_delete_user = $connection->prepare($sql_delete_user);
    $stmt_delete_user->execute([$idUser]);

    if($stmt_delete_user){
        header('location:adminPage3.php');
    } else {
        die($e->getMessage());
    }
}

?>
