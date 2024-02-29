<?php
// Връзка с базата данни
$servername = "localhost";
$username = "root";
$password = "";
$database = "mCarService";

try {
  $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Извличане на записите от таблицата endedAppointments, които са свързани с избраната кола
  $carId = $_POST['carId'];
  $stmt = $connection->prepare("SELECT * FROM endedAppointments WHERE idcar = :carId");
  $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);
  $stmt->execute();

  $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Връщане на данните в JSON формат
  header('Content-Type: application/json');
  echo json_encode($appointments);
} catch (PDOException $e) {
  // Връщане на грешка, ако има проблем с връзката към базата данни
  echo "Грешка при връзка с базата данни: " . $e->getMessage();
}
?>
