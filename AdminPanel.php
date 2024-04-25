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
if (isset($_POST['serviceName']) && isset($_POST['timeForExecution'])  && isset($_POST['price']) && isset($_POST['range'])) {


  $Name = $_POST['serviceName'];
  $Mins = $_POST['timeForExecution'];
  $Price = $_POST['price'];
  $Range = $_POST['range'];
  try{
   // заявка към базата, с която се записват полетата
   $sql = "INSERT INTO Services (`name`, `timeForExecution`, `price`, `range`) VALUES (?, ?, ?, ?)";
$connection->prepare($sql)->execute([$Name, $Mins, $Price, $Range]);
echo "<b style='color:green;'>Успешно добавихте услуга.</b><br><br>";

  }catch(PDOException $e){
    echo "Error: " . $e->getMessage();
  }
    
}
if (isset($_POST['mechanicName']) && isset($_POST['email']) && isset($_POST['logInCode']) && isset($_POST['specializedIn'])) {


  $Name = $_POST['mechanicName'];
  $Email = $_POST['email'];
  $logInCode = $_POST['logInCode'];
  $Specialization = $_POST['specializedIn'];
  
   // заявка към базата, с която се записват полетата
   $sql = "INSERT INTO mechanics (name, email,logIncode,specializedIn) VALUES (?,?,?,?)";
   $connection->prepare($sql)->execute([$Name, $Email,$logInCode, $Specialization]);
   echo "<b style='color:green;'>Успешно добавихте механик.</b><br><br>";
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin panel</title>
  <link rel="stylesheet" href="./styles/adminStyle.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="styles/mechanicPage2.0.css">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

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
          <a href="#" class="nav_link admin-services-link">
          <span class="navlink_icon">
          <i class='bx bx-time' ></i>
          </span>
          <span class="navlink">Услуги</span>
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

  <div class = "main-content">

  
<div class = "serviceContainer" id = "serviceContainer">
  <div class = "container" id = "container">
  <h3>Добавяне на услуга</h3>
  <div class = "form">
    <form method="post">
      <div class = "form-group">
        <label for="serviceName">Име на услугата:</label>
        <input type="text"id="serviceName" name="serviceName" required>
      </div>
      <div class = "form-group">
        <label for="timeForExecution">Време за изпълнение (в минути):</label>
         <input type="number" id="timeForExecution" name="timeForExecution" required>
      </div>
      <div class = "form-group">
        <label for="price">Цена (в лв.):</label>
         <input type="number" id="price" name="price" required>
      </div>
      <div class = "form-group">
        <label for="range">Направление:</label>
        <input type="text"id="range" name="range" required>
      </div>
    </form>
    
  </div>
  </div>
  
 <br>
  <br>
  <div class = "tableContainer">
  <table class="table table-striped table-hover" >
  <thead class="table-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Име на услугата</th>
      <th scope="col">Време за изпълнение</th>
      <th scope="col">Направление</th>
      <th scope="col">Цена</th>
      <th scope="col">Операции</th>
    </tr> 
  </thead>
  <tbody>
  <?php
  $sql = "Select * from `Services`";
  $result = $connection->query($sql);
  if ($result) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id'];
        $name = $row['name'];
        $timeForExecution = $row['timeForExecution'];
        $range = $row['range'];
        $price = $row['price'];
        
        echo '<tr>
        <th scope="row">' . $id . '</th>
        <td class="nameDB">' . $name . '</td>
        <td class="timeDB">' . $timeForExecution. ' мин</td>
        <td class="rangeDB">' . $range. ' </td>
        <td class="nameDB">' . $price . 'лв</td>
        <td>
        <button class="btn btn-primary editBtn">
  <a href="" class="text-light">
    <i class="fa-solid fa-pen-to-square"></i>
  </a>
  <div class="editTextArea">Промени</div>
  </button>

        <button class="btn btn-danger">
        <a href="delete.php?deleteid='.$id.'" class="text-light">
        <i class="fa-solid fa-trash"></i>
        </a>
        <div class="editTextArea">Изтрий</div>
        </button>
      </tr>';
  
    }
 }
 ?>

  
   
  </tbody>
 </table>
 </div>
 </div>
 <div class = "mechanicsContainer" id = "mechanicsContainer">
 <div class = "container" id = "containerForMechanic">
  <h3>Добавяне на механик</h3>
  <div class = "form">
    <form method="post">
      <div class = "form-group">
        <label for="mechanicName">Име на механика:</label>
        <input type="text"id="mechanicName" name="mechanicName" required>
      </div>
      <div class = "form-group">
        <label for="email">Имейл:</label>
         <input type="text" id="email" name="email" required>
      </div>
      <div class = "form-group">
        <label for="logInCode">Код за влизане:</label>
         <input type="text" id="logInCode" name="logInCode" required>
      </div>
      <div class = "form-group">
        <label for="specializedIn">Специалност:</label>
         <input type="text" id="specializedIn" name="specializedIn" required>
      </div>
      <div class = "buttonContainer">
         <button  type="submit" class = "insertBtn" id = "insertBtn">Добави механик</button>
      </div>
    </form>
    
  </div>
  </div>
  <div style="width: 25%; margin: 0 auto;" >
    <button type="button" class = "btn btn-primary" id="addMechanicBtn">Добави механик</button>
</div>
<br>
<br>


<div class = "tableContainer">
<table class="table table-striped table-hover" >
  <thead class="table-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Име на механика</th>
      <th scope="col">Имейл</th>
      <th scope="col">Специалност</th>
      <th scope="col">Операции</th>
    </tr> 
  </thead>
  <tbody>
  <?php
$sql = "Select * from `mechanics`";
$result = $connection->query($sql);
if ($result) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $idMechanic = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $specializedIn = $row['specializedIn'];
        echo '<tr>
        <th scope="row">' . $idMechanic . '</th>
        <td class="nameDB">' . $name . '</td>
        <td class="emailDB">' . $email. ' </td>
        <td class="specializedInDB">' . $specializedIn . '</td>
        <td>
        <button class="btn btn-primary editMechanicBtn">
  <a href="" class="text-light">
    <i class="fa-solid fa-pen-to-square"></i>
  </a>
  <div class="editTextArea">Промени</div>
</button>

        <button class="btn btn-danger">
        <a href="delete.php?deleteidMechanic='.$idMechanic.'" class="text-light">
        <i class="fa-solid fa-trash"></i>
        </a>
        <div class="editTextArea">Изтрий</div>
        </button>
      </tr>';
  
    }
}
?>

  
  
  </tbody>
</table>
</div>
</div>
 <div class = "appointmentsContainer"  id="appointmentsContainer">
 <div class = "tableContainer">
 <table class="table table-striped table-hover" >
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
 $sql = "SELECT a.id, u.name AS carOwner, c.brand, c.model, a.serviceName, a.mechanicName, a.dateTime, a.endDateTime, a.moreInfo
 FROM `apointments` AS a
 INNER JOIN `users` AS u ON a.idCarOwner = u.iduser
 INNER JOIN `cars` AS c ON a.idcar = c.car_id";

 $result = $connection->query($sql);

 if ($result) {
 while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
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
        <button class="btn btn-primary editApointmentBtn">
  <a href="" class="text-light">
    <i class="fa-solid fa-pen-to-square"></i>
  </a>
  <div class="editTextArea">Промени</div>
 </button>

        <button class="btn btn-danger">
        <a href="delete.php?deleteidAppointment='.$idAppointment.'" class="text-light">
        <i class="fa-solid fa-trash"></i>
        </a>
        <div class="editTextArea">Изтрий</div>
        </button>
      </tr>';
  
    }
}
?>

  
   
  </tbody>
</table>
</div>
</div>
</div>
<script src="js/mechanicPage2.0.js"></script>
<script src="script.js"></script>
</body>

</html>