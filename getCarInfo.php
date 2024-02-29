<?php
// Проверка на заявката
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['carId'])) {
    // Вземане на идентификатора на автомобила от POST заявката
    $carId = $_POST['carId'];

    // Връзка с базата данни
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "mCarService";

    try {
        $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Заявка за извличане на информация за избрания автомобил от таблицата "cars"
        $stmt = $connection->prepare("SELECT * FROM cars WHERE car_id = :car_id");
        $stmt->bindParam(':car_id', $carId);
        $stmt->execute();

        // Извличане на данните за автомобила
        $carInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        // Извеждане на получената информация
        if ($carInfo) {
            echo "Марка: " . $carInfo['brand'] . "<br>";
            echo "Модел: " . $carInfo['model'] . "<br>";
            echo "Година: " . $carInfo['year'] . "<br>";
            echo "Цвят: " . $carInfo['color'] . "<br>";
            echo "Регистрационен номер: " . $carInfo['license_plate'] . "<br>";
            // И така нататък за останалата информация за автомобила
        } else {
            echo "Грешка: Няма намерен автомобил с този идентификатор.";
        }
    } catch (PDOException $e) {
        echo "Грешка при връзка с базата данни: " . $e->getMessage();
    }
} else {
    echo "Невалидна заявка за информация за автомобил.";
}
?>