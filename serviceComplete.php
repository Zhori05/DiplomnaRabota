<?php
session_start();

// Проверка за логнат потребител
if (!isset($_SESSION['mechanic'])) {
    header("location: mechanicLogIn.php");
    exit();
}

// Достъп до информацията за логнатия потребител
$mechanic = $_SESSION['mechanic'];

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


// Проверка дали формата е изпратена
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Вземане на информацията от формата
  $kilometers = $_POST['kilometers'];
  $moreInfo = $_POST['more'];
  $appointment_id = $_POST['appointment_id'];

  // Проверка за валидност на appointment_id
  if (!empty($appointment_id)) {
      // Извличане на информацията за апоинтмънта от таблицата appointments
      $stmt = $connection->prepare("SELECT * FROM apointments WHERE id = ?");
      $stmt->execute([$appointment_id]);
      $appointmentData = $stmt->fetch(PDO::FETCH_ASSOC);

      // Вмъкване на данните в таблицата endedAppointments
      $sql = "INSERT INTO endedAppointments (idAppointment, idCarOwner, idcar, serviceName, mechanicName, dateTime, moreInfo, endDateTime, mileage, infoAfterServicing) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $connection->prepare($sql);
      $stmt->execute([
          $appointmentData['id'],
          $appointmentData['idCarOwner'],
          $appointmentData['idcar'],
          $appointmentData['serviceName'],
          $appointmentData['mechanicName'],
          $appointmentData['dateTime'],
          $moreInfo,
          $appointmentData['endDateTime'],
          $kilometers,
          $moreInfo
      ]);

      // Изтриване на записа от таблицата apointments
      $stmt = $connection->prepare("DELETE FROM apointments WHERE id = ?");
      $stmt->execute([$appointment_id]);

      // Редирект към страница за успешно завършване на услугата
      header("location: mechanicPage2.0.php");
      exit();
  } else {
      echo "Грешка: ID на апоинтмънта не е дефиниран.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/serviceComplete.css">
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Document</title>
</head>
<body>
<div class="container">
<form method = "post" id = "myForm" enctype="multipart/form-data">
<input type="hidden" name="appointment_id" value="<?php echo $_GET['id']; ?>">
<div class = "tab">
<div class = "row">
      <div class = "col-25">
          <label for = "kilometers"></i>Пробег</label>
      </div>
      <div class = "col-75">
          <input type="number" id="kilometers" name="kilometers" placeholder="Пробег.." data-addcar required>
      </div>
  </div>
    <div class="row">
                    <div class="col-25">
                      <label for="more"><i class="fa-solid fa-file-pen"></i> Допълнителна информация</label>
                    </div>
                    <div class="col-75">
                      <textarea id="more" name="more" placeholder="Напиши тук: " style="height:200px"></textarea>
                    </div>
                  </div>
                  <div class = "row">
                  <button type="submit">Завърши</button>
                  </div>
           
                </div>
        
</body>
</html>