<?php
session_start();



// Достъп до информацията за логнатия потребител
$user = $_SESSION['user'];

// Изписване на информацията
echo "Добре дошъл, " . $user['Name'] . "!";

$user_id = $_SESSION['user']['iduser'];

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
    <div class = "mechanic">
  <p class="mechanicName"><?php echo "Добре дошъл, " . $user['name'] . " !"; ?></p>
  </div>
    <div class="menu_content">
      <ul class="menu_items">
        <li class="menu_item">
          <a href="home.html" class="nav_link">
          <span class="navlink_icon">
            <i class="bx bx-home"></i>
          </span>
          <span class="navlink">Начало</span>
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
        <i class='bx bx-calendar-check'></i>
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
    
</div>
<script src="js/mechanicPage2.0.js"></script>
</body>


</html>