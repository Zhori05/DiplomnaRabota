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
if (isset($_POST['serviceName']) && isset($_POST['timeForExecution']) && isset($_POST['price'])) {


  $Name = $_POST['serviceName'];
  $Mins = $_POST['timeForExecution'];
  $Price = $_POST['price'];
  
   // заявка към базата, с която се записват полетата
   $sql = "INSERT INTO Services (name, timeForExecution,price) VALUES (?,?,?)";
   $connection->prepare($sql)->execute([$Name, $Mins, $Price]);
   echo "<b style='color:green;'>Успешно добавихте услуга.</b><br><br>";
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!-- add CSS -->
  <link rel="stylesheet" href="styles/mechanicPage2.0.css">
  <title>Responsive Side Nav</title>
</head>
<body>
  <nav class="navbar">
    <div class="logo">
      <i class="bx bx-menu" id="sidebarOpen"></i>
      M Car Service
    </div>
  </nav>
  <nav class="sidebar">
  <p class="mechanicName"><?php echo "Добре дошъл, " . $mechanic['name']; ?></p>
    <div class="menu_content">
      <ul class="menu_items">
        <li class="menu_item">
          <a href="#" class="nav_link">
          <span class="navlink_icon">
            <i class="bx bx-home"></i>
          </span>
          <span class="navlink">Home</span>
        </a>
        </li>
        <li class="menu_item">
          <a href="#" class="nav_link day-work-link">
          <span class="navlink_icon">
          <i class='bx bx-time' ></i>
          </span>
          <span class="navlink">Работа за деня</span>
        </a>
        </li>
        <li class="menu_item">
        <a href="#" class="nav_link week-work-link">
    <span class="navlink_icon">
    <i class='bx bx-calendar-week'></i>
    </span>
    <span class="navlink">Работа за седмица</span>
</a>
        </li>
        <li class="menu_item">
        <a href="#" class="nav_link services-link">
        <span class="navlink_icon">
            <i class='bx bx-calendar-week'></i>
        </span>
        <span class="navlink">Свършена работа</span>
    </a>
</li>
      
      </ul>
      <div class="collapse_content">
        <div class="collapse expand_sidebar">
          <span> Expand</span>
          <i class="bx bx-chevron-right"></i>
        </div>
        <div class="collapse collapse_sidebar">
          <span> Collapse</span>
          <i class="bx bx-chevron-left"></i>
        </div>
      </div>
    </div>
  </nav>


  <div class="main-content">
    <div class="container">
        
    </div>
    <div class="tableContainer" id="tableDayWork">
  <h1>График на деня</h1>
<div class="tableContainerContent">
  <table class="table table-striped table-hover">
    <thead class="table-dark">
      <tr>
      <th scope="col">#</th>
      <th scope="col">Име на собственика</th>
      <th scope="col">Кола</th>
      <th scope="col">Услуга</th>
      <th scope="col">Име на механик</th>
      <th scope="col">Начало</th>
      <th scope="col">Край</th>
      <th scope="col">Допълнителна информация</th>
      <th scope="col">Операции</th>
      </tr> 
    </thead>
    <tbody>
    <?php
$currentDate = date("Y-m-d");
$sql = "SELECT a.id, u.name AS carOwner, c.brand, c.model, a.serviceName, a.mechanicName, a.dateTime, a.endDateTime, a.moreInfo
        FROM `apointments` AS a
        INNER JOIN `users` AS u ON a.idCarOwner = u.iduser
        INNER JOIN `cars` AS c ON a.idcar = c.car_id
        WHERE a.mechanicName = ? AND DATE(a.dateTime) = ?";
$stmt = $connection->prepare($sql);
$stmt->execute([$mechanic['name'], $currentDate]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($result) {
    foreach ($result as $row) {
        $idAppointment = $row['id'];
        $carOwner = $row['carOwner'];
        $carBrand = $row['brand'];
        $carModel = $row['model'];
        $serviceName = $row['serviceName'];
        $mechanicName = $row['mechanicName'];
        $dateTime = $row['dateTime'];
        $endDateTime = $row['endDateTime'];
        $moreInfo = $row['moreInfo'];
        echo '<tr>
                <th scope="row">' . $idAppointment . '</th>
                <td class="carOwnerDB">' . $carOwner . '</td>
                <td class="carDB">' . $carBrand . ' ' . $carModel . '</td>
                <td class="serviceNameDB">' . $serviceName . '</td>
                <td class="mechanicNameDB">' . $mechanicName . '</td>
                <td class="dateTimeDB">' . $dateTime . '</td>
                <td class="endDateTimeDB">' . $endDateTime . '</td>
                <td class="moreInfoDB">' . $moreInfo . '</td>
                <td>
                <button class="btn btn-primary">
                <a href="serviceComplete.php?id=' . $idAppointment . '">
                    <div class="editTextArea">Завърши</div>
                </a>
            </button>
                   
                </td>
            </tr>';
    }
} else {
  echo "<p> <font color=green> За днес нямаш часове</font> </p>";
}
?>
  
    
     
    </tbody>
  </table>
  </div>
  </div>
  <div class="tableContainer" id="tableWeekWork" style="display: none;">
  <h1>График за седмицата</h1>
<div class="tableContainerContent">
  <table class="table table-striped table-hover">
    <thead class="table-dark">
      <tr>
      <th scope="col">#</th>
      <th scope="col">Име на собственика</th>
      <th scope="col">Кола</th>
      <th scope="col">Услуга</th>
      <th scope="col">Име на механик</th>
      <th scope="col">Начало</th>
      <th scope="col">Край</th>
      <th scope="col">Допълнителна информация</th>
      <th scope="col">Операции</th>
      </tr> 
    </thead>
    <tbody>
    <?php
$currentDate = date("Y-m-d");
$dayOfWeek = date("N", strtotime($currentDate));

// Изчисляване на датата на последния работен ден на текущата седмица (събота)
if ($dayOfWeek < 6) {
    // Ако не е събота (6), намираме разликата до събота и я добавяме към текущата дата
    $daysUntilSaturday = 6 - $dayOfWeek;
    $lastWorkingDayOfWeek = date("Y-m-d", strtotime("+{$daysUntilSaturday} days", strtotime($currentDate)));
} else {
    // Ако вече е събота, последния работен ден е текущата дата
    $lastWorkingDayOfWeek = $currentDate;
}

// Заявка за извличане на записите за оставащите работни дни от седмицата за дадения механик
$sql = "SELECT a.id, u.name AS carOwner, c.brand, c.model, a.serviceName, a.mechanicName, a.dateTime, a.endDateTime, a.moreInfo
        FROM `apointments` AS a
        INNER JOIN `users` AS u ON a.idCarOwner = u.iduser
        INNER JOIN `cars` AS c ON a.idcar = c.car_id
        WHERE a.mechanicName = ? AND DATE(a.dateTime) BETWEEN ? AND ?";
$stmt = $connection->prepare($sql);
$stmt->execute([$mechanic['name'], $currentDate, $lastWorkingDayOfWeek]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($result) {
    foreach ($result as $row) {
        $idAppointment = $row['id'];
        $carOwner = $row['carOwner'];
        $carBrand = $row['brand'];
        $carModel = $row['model'];
        $serviceName = $row['serviceName'];
        $mechanicName = $row['mechanicName'];
        $dateTime = $row['dateTime'];
        $endDateTime = $row['endDateTime'];
        $moreInfo = $row['moreInfo'];
        echo '<tr>
                <th scope="row">' . $idAppointment . '</th>
                <td class="carOwnerDB">' . $carOwner . '</td>
                <td class="carDB">' . $carBrand . ' ' . $carModel . '</td>
                <td class="serviceNameDB">' . $serviceName . '</td>
                <td class="mechanicNameDB">' . $mechanicName . '</td>
                <td class="dateTimeDB">' . $dateTime . '</td>
                <td class="endDateTimeDB">' . $endDateTime . '</td>
                <td class="moreInfoDB">' . $moreInfo . '</td>
                <td>
                <button class="btn btn-primary">
                <a href="serviceComplete.php?id=' . $idAppointment . '">
                    <div class="editTextArea">Завърши</div>
                </a>
            </button>
                   
                </td>
            </tr>';
    }
} else {
    echo "Няма налични апоинтмънти за вашия механик.";
}
?>
  
    
     
    </tbody>
  </table>
  </div>
</div>
<div class="tableContainer" id="tableEndedAppointmets"> <!-- Променено тук -->
  <h1>Извършени услуги последния месец</h1>
<div class="tableContainerContent">
  <table class="table table-striped table-hover" >
    <thead class="table-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Номер на записа</th>
        <th scope="col">Собственик</th>
        <th scope="col">Кола</th>
        <th scope="col">Услуга</th>
        <th scope="col">Име на механик</th>
        <th scope="col">Начало</th>
        <th scope="col">Повече информация</th>
        <th scope="col">Край</th>
        <th scope="col">Пробег</th>
        <th scope="col">Информация след сервизиране</th>
      </tr> 
    </thead>
    <tbody>
    <?php
  $sql = "Select * from `endedAppointments`";
  $result = $connection->query($sql);
  if ($result) {
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          $id = $row['id'];
          $idAppointment = $row['idAppointment'];
          $idCarOwner = $row['idCarOwner'];
          $idcar = $row['idcar'];
          $serviceName = $row['serviceName'];
          $mechanicName = $row['mechanicName'];
          $dateTime = $row['dateTime']; 
          $moreInfo = $row['moreInfo'];
          $endDateTime = $row['endDateTime'];
          $mileage = $row['mileage'];
          $infoAfterServicing = $row['infoAfterServicing'];

          echo '<tr>
          <th scope="row">' . $id . '</th>
          <td class="nameDB">' . $idAppointment . '</td>
          <td class="nameDB">' . $idCarOwner . '</td>
          <td class="nameDB">' . $idcar . '</td>
          <td class="nameDB">' . $serviceName . '</td>
          <td class="nameDB">' . $mechanicName . '</td>
          <td class="timeDB">' . $dateTime. ' </td>
          <td class="nameDB">' . $moreInfo . '</td>
          <td class="timeDB">' . $endDateTime. ' </td>
          <td class="nameDB">' . $mileage . '</td>
          <td class="nameDB">' . $infoAfterServicing . '</td>
          <td>
          
        </tr>';
    
      }
  }
  ?>
  
    
     
    </tbody>
  </table>
  </div>
</div>
<script src="js/mechanicPage2.0.js"></script>
</body>


</html>