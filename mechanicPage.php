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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/mechanicPageStyle.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>MechanicPage</title>
</head>
<body>
<div class = "header">  
<div class = "titleContainer">
    <h1 class = "title"><?php echo "Добре дошъл, " . $mechanic['name'] . ", за нас е чест да бъдеш част от нашия екип"; ?></h1>
    </div>
</div>  
<div class = "sidebar">
    <div class = "top">
    <div class = "logo">
        <i class = "bx bxl-codepen"></i>
        <span>M Car Service</span>
        </div> 
        <i class = " bx bx-menu" id ="btn"></i>
</div>

<div class = "user">
    <!-- img src="image" class = "user-img"-->
        <div>
            <p class = "bold">Client B.</p>
            <p>Admin</p>
        </div>
        </div>
        <ul>
            <li>
                <a href="#">
                    <i class="bx bxs-grid-alt"></i>
                    <span class = "nav-item">Dashboard</span>
                </a>
                <span class = "tooltip">Dashboard</span>

            </li>
            <li>
                <a href="#">
                    <i class="bx bx-time"></i>
                    <span class = "nav-item">График на деня </span>
                </a>
                <span class = "tooltip">График на деня</span>
                
            </li><li>
                <a href="#">
                <i class='bx bx-calendar'></i>
                    <span class = "nav-item">График на седмицата</span>
                </a>
                <span class = "tooltip">График на седмицата</span>
                
            </li>
        </ul>
</div>
<div class="main-content">
    <div class = "container">
        <h1>M Car Service</h1>
    </div>
    <div class = "tableContainer" id ="tableContainer">
  <h1>График на деня</h1>
<div class = "tableContainerContent">
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
                    <button class="btn btn-primary endApointmentBtn">
                        <a href="" class="text-light">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <div class="endTextArea">Завърши</div>
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



</body>
<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar')
    btn.onclick = function (){
        sidebar.classList.toggle('active');
    };
   

</script>
</html>