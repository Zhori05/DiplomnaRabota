<?php
// getMechanics.php

// Проверка за наличие на параметър rangeValue в заявката
if (!isset($_GET['rangeValue'])) {
    die("Грешка: Недостатъчно данни.");
}

$rangeValue = $_GET['rangeValue'];

$servername = "localhost";
$username = "root";
$password = "";
$database = "mCarService";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Заявка за извличане на механици със специализация, съвпадаща с "range"
    $stmt_mechanics = $connection->prepare("SELECT * FROM mechanics WHERE specializedIn = :rangeValue");
    $stmt_mechanics->bindParam(':rangeValue', $rangeValue, PDO::PARAM_STR); // Промяна на типа на параметъра
    $stmt_mechanics->execute();
    
    // Извличане на резултатите
    $mechanics = $stmt_mechanics->fetchAll(PDO::FETCH_ASSOC);

    // Генериране на HTML за опциите на механици
    foreach ($mechanics as $mechanic) {
        echo '<option value="' . $mechanic['id'] . '">' . $mechanic['name'] . '</option>';
    }
} catch (PDOException $e) {
    die("Грешка при връзка с базата данни: " . $e->getMessage());
}
?>
