<?php
// load_mechanics.php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['service'])) {
    // Предполагаме, че вашият код за връзка с базата данни вече е включен в този файл.
    // Ако не, включете го тук.
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "mCarService";
    
    try {
        $connection = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();  // Прекратява изпълнението на скрипта, ако няма връзка с базата данни
    }
    
    // Извлечете избраната услуга от POST заявката
    $selectedService = $_POST['service'];

    // Тук направете вашия SQL заявка, за да извлечете механиците, специализирани в избраната услуга
    // Например:
     $stmt = $connection->prepare("SELECT * FROM mechanics WHERE specializedIn = :selectedService");
     $stmt->bindParam(':selectedService', $selectedService, PDO::PARAM_STR);
     $stmt->execute();
     $mechanics = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Примерни данни за тестване (заменете ги със своите данни от базата данни)
    $stmt = $connection->prepare("SELECT id, name FROM mechanics WHERE specializedIn = :selectedService");
    $stmt->bindParam(':selectedService', $selectedService, PDO::PARAM_STR);
    $stmt->execute();
    $mechanics = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Генерирайте HTML за опциите на механиците
    $htmlOptions = '';
    foreach ($mechanics as $mechanic) {
        $htmlOptions .= '<option value="' . $mechanic['id'] . '">' . $mechanic['name'] . '</option>';
    }

    // Изпратете генерирания HTML като отговор на AJAX заявката
    echo $htmlOptions;
} else {
    // Ако заявката не е POST или липсва параметър 'service', върнете грешка
    http_response_code(400);
    echo 'Bad Request';
}
?>
